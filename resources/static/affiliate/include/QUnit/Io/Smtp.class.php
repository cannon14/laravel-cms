<?php
  // DEFINES
  define('SMTP_CODETYPE_ERROR', -1     , true);
  define('SMTP_CODETYPE_OK2'  ,  2     , true);
  define('SMTP_CODETYPE_OK3'  ,  3     , true);
  define('SMTP_CODETYPE_BUSY' ,  4     , true);
  define('SMTP_CODETYPE_FAIL' ,  5     , true);


  // CLASS DEFINITION
  class QUnit_Io_Smtp {
    // PRIVATE OBJECT VARIABLES
    // SMTP configuration
    var $_Host;                   // SMTP host
    var $_Port;                   // SMTP port
    var $_Domain;                 // local domain
    var $_Auth;                   // authentification method
    var $_AuthUname;              // user name
    var $_AuthPass;               // user password
    // SMTP features
    var $_Feats;                  // features supported by SMTP server
    // last response
    var $_Code;                   // last response code
    var $_CodeType;               // last response code type
    var $_Exts;                   // last response extensions
    // socket handler
    var $_Socket;                 // socket handler resource


    // PUBLIC OBJECT VARIABLES


    // CONSTRUCTOR & DESTRUCTOR
    // constructor
    //   parameters: host (string)   - SMTP host
    //               port (int)      - SMTP port
    //               domain (string) - domain to send with HELO / EHLO command
    //               auth (string)   - authentification method one of SMTP_AUTH_??? constants
    //   return value: N/A
    function QUnit_Io_Smtp($host, $port, $domain = 'localhost', $auth = SMTP_AUTH_NONE, $authuname = '', $authpass = '') {
      // set SMTP configuration
      $this->_Host = $host;
      $this->_Port = $port;
      $this->_Domain = $domain;
      $this->_Auth = $auth;
      $this->_AuthUname = $authuname;
      $this->_AuthPass = $authpass;
      // create socket handler object
      $this->_Socket = QUnit_Global::newObj('QUnit_Io_Socket');
      // set EHLO support
      $this->_Feats = Array('EHLO' => true);
    }


    // PUBLIC METHODS
    // sets SMTP configuration
    //   parameters: host (string)   - SMTP host
    //               port (int)      - SMTP port
    //               domain (string) - domain to send with HELO / EHLO command
    //   return value: (array) array containing old SMTP configuration
    function SetSmtpConfig($host = NULL, $port = NULL, $domain = NULL) {
      $oldconfig = Array('host' => $this->_Host, 'port' => $this->_Port, 'auth' => $this->_Auth, 'domain' => $this->_Domain);
      if(!is_null($host)) {
        $this->_Host = $host;
      }
      if(!is_null($port)) {
        $this->_Port = $port;
      }
      if(!is_null($domain)) {
        $this->_Domain = $domain;
      }
      return($oldconfig);
    }


    // gets SMTP configuration
    //   parameters: none
    //   return value: (array) array containing SMTP configuration
    function GetSmtpConfig() {
      return(Array('host' => $this->_Host, 'port' => $this->_Port, 'auth' => $this->_Auth, 'domain' => $this->_Domain));
    }


    // sets SMTP authentification
    //   parameters: auth (string)  - authentification method
    //               uname (string) - user name
    //               pass (string)  - password
    //   return value: (array) array containing old authentification configuration
    function SetSmtpAuth($auth, $uname = '', $pass = '') {
      $oldauth = Array($this->_Auth, $this->_AuthUname, $this->_AuthPass);
      $this->_Auth = $auth;
      if($auth != SMTP_AUTH_NONE) {
        $this->_AuthUname = $uname;
        $this->_AuthPass = $pass;
      }
      return($oldauth);
    }


    function GetSmtpAuth() {
      return(Array($this->_Auth, $this->_AuthUname, $this->_AuthPass));
    }


    // sends e-mail
    //   parameters: from (string)            - from e-mail address
    //               to (mixed: string/array) - either simple string or array containing strings of recipient e-mail addresses
    //               message (string)         - e-mail full MIME body
    //               headers (string)         - e-mail headers
    //               resetconn (bool)         - tells, whether reset connection at first
    //   return value: (array) array containing old authentification configuration
    function SendMail($from, $to, $message, $headers, $resetconn = false) {
      // if connection shoul be reset, or does not exist, it should be established
      if(($resetconn) || (!$this->_SmtpIsConnected())) {
        if(!$this->_SmtpConnect()) {
          return(false);
        }
      }
      // if using old connection, it should be reset
      else {
        $this->_smtp->WriteLn('RSET');
        if(!$this->_GetSmtpResponse(SMTP_CODETYPE_OK2)) {
          $this->_SmtpDisconnect();
          QUnit_Messager::setErrorMessage(L_G_MAILERROR);
          QCore_History::DebugMsg(WLOG_ERROR, L_G_MAILERROR, __FILE__, __LINE__);
          return(false);
        }
      }
      // begin mail
      $this->_Socket->WriteLn('MAIL FROM: '.$from);
      if(!$this->_GetSmtpResponse(SMTP_CODETYPE_OK2)) {
        $this->_SmtpDisconnect();
        QUnit_Messager::setErrorMessage(L_G_MAILERROR);
        QCore_History::DebugMsg(WLOG_ERROR, L_G_MAILERROR, __FILE__, __LINE__);
        return(false);
      }
      // set recipients
      $toarray = Array();
      $notsent = Array();
      // prepare recipients into array
      if(is_array($to)) {
        $toarray = $to;
      }
      else {
        $toarray = Array($to);
      }
      // one RCPT command for each recipient
      foreach($toarray as $toemail) {
        $this->_Socket->WriteLn('RCPT TO: '.$toemail);
        if(!$this->_GetSmtpResponse(SMTP_CODETYPE_OK2)) {
          // save each rejected recipient into array
          $this->_notsent[] = $toemail;
        }
      }
      // if all recipients were rejected
      if((count($notsent) > 0) && (count($toarray) == count($notsent))) {
        return(false);
      }
      // prepare data (convert Unix and Mac linefeeds into standard CR LF, convert leading period into double period)
      $data = $headers."\r\n".$message;
      $data = preg_replace("/([^\r]{1})\n/", "\\1\r\n", $data);
      $data = preg_replace("/\n\n/", "\n\r\n", $data);
      $data = preg_replace("/\n\./", "\n..", $data);
      // send DATA command
      $this->_Socket->WriteLn('DATA');
      if(!$this->_GetSmtpResponse(SMTP_CODETYPE_OK3)) {
        $this->_SmtpDisconnect();
        QUnit_Messager::setErrorMessage(L_G_MAILERROR);
        QCore_History::DebugMsg(WLOG_ERROR, L_G_MAILERROR, __FILE__, __LINE__);
        return(false);
      }
      // send e-mail data
      $this->_Socket->WriteLn($data."\r\n".'.');
      if(!$this->_GetSmtpResponse(SMTP_CODETYPE_OK2)) {
        $this->_SmtpDisconnect();
        QUnit_Messager::setErrorMessage(L_G_MAILERROR);
        QCore_History::DebugMsg(WLOG_ERROR, L_G_MAILERROR, __FILE__, __LINE__);
        return(false);
      }
      // if there are some rejected recipients, return their addresses
      if(count($notsent) > 0) {
        return($notsent);
      }
      // everything went ok
      return(true);
    }

    // function should be called everytime, when e-mail work is done (closes connection and resets some variables)
    //   parameters: none
    //   return value: none
    function Done() {
      $this->_SmtpDisconnect();
    }


    // PRIVATE METHODS
    // establishes connection to SMTP server
    //   parameters: none
    //   return value: (bool) true on success, false on failure
    function _SmtpConnect() {
      // if connection is already established, disconnect
      if($this->_SmtpIsConnected()) {
        $this->_SmtpDisconnect();
      }
      // set socket parameters
      $this->_Socket->SetAddress($this->_Host, $this->_Port);
      $this->_Socket->SetBlocking(true);
      $this->_Socket->SetTimeout(0);
      // try to connect
      if(!$this->_Socket->Connect()) {
        QUnit_Messager::setErrorMessage(L_G_MAILERROR);
        QCore_History::DebugMsg(WLOG_ERROR, L_G_MAILERROR, __FILE__, __LINE__);
        return(false);
      }
      // if response is wrong
      if(!$this->_GetSmtpResponse(SMTP_CODETYPE_OK2)) {
        $this->_SmtpDisconnect();
        QUnit_Messager::setErrorMessage(L_G_MAILERROR);
        QCore_History::DebugMsg(WLOG_ERROR, L_G_MAILERROR, __FILE__, __LINE__);
        return(false);
      }
      // if EHLO is supported
      $helo = true;
      if($this->_Feats['EHLO']) {
        // send EHLO command
        $this->_Socket->WriteLn('EHLO '.(($this->_Domain) ? $this->_Domain : 'localhost'));
        // if response is wrong (503: greetings already sent)
        if(!(($this->_GetSmtpResponse(SMTP_CODETYPE_OK2)) || ($this->_Code == 503))) {
          // serious error was detected
          if($this->_CodeType == SMTP_CODETYPE_ERROR) {
            $this->_SmtpDisconnect();
            QUnit_Messager::setErrorMessage(L_G_MAILERROR);
            QCore_History::DebugMsg(WLOG_ERROR, L_G_MAILERROR, __FILE__, __LINE__);
            return(false);
          }
          // try HELO instead
          $helo = true;
        }
      }
      else {
        $helo = true;
      }
      // if EHLO is not supported, or failed
      if($helo) {
        // send HELO command
        $this->_Socket->WriteLn('HELO '.(($this->_Domain) ? $this->_Domain : 'localhost'));
        // if response is wrong
        if(!$this->_GetSmtpResponse(SMTP_CODETYPE_OK2)) {
          $this->_SmtpDisconnect();
          QUnit_Messager::setErrorMessage(L_G_MAILERROR);
          QCore_History::DebugMsg(WLOG_ERROR, L_G_MAILERROR, __FILE__, __LINE__);
          return(false);
        }
      }

      // try to authentificate (if needed)
      if($this->_Auth != SMTP_AUTH_NONE) {
        // choose authentification type
        $authentificated = false;
        switch($this->_Auth) {
          case SMTP_AUTH_PLAIN   :
            $authentificated = $this->_SmtpAuthPlain();
            break;
          case SMTP_AUTH_LOGIN   :
            $authentificated = $this->_SmtpAuthLogin();
            break;
          case SMTP_AUTH_CRAMMD5 :
            $authentificated = $this->_SmtpAuthCramMd5();
          default                : // authentification type is not supported
            break;
        }
        // if authentification failed
        if(!$authentificated) {
          $this->_SmtpDisconnect();
          QUnit_Messager::setErrorMessage(L_G_MAILERROR);
          QCore_History::DebugMsg(WLOG_ERROR, L_G_MAILERROR, __FILE__, __LINE__);
          return(false);
        }
      }
      // handshake done, connection is ready
      return(true);
    }


    // closes SMTP connection
    //   parameters: none
    //   return value: none
    function _SmtpDisconnect() {
      // if connection is not established
      if(!$this->_SmtpIsConnected()) {
        // silently return
        return;
      }
      // otherwise disconnect
      $this->_Socket->WriteLn('QUIT');
      $this->_GetSmtpResponse();
      $this->_Socket->Disconnect();
    }


    // checks, whether connection to SMTP server is established
    //   parameters: none
    //   return value: (bool) true/false
    function _SmtpIsConnected() {
      // check socket connection
      return($this->_Socket->IsConnected());
    }


    // SMTP Plain authentification method implementation
    //   parameters: none
    //   return value: (bool) true on success, false on failure
    function _SmtpAuthPlain() {
      // send AUTH PLAIN command
      $this->_Socket->WriteLn('AUTH PLAIN');
      // if response is wrong
      if(!$this->_GetSmtpResponse(SMTP_CODETYPE_OK3)) {
        // 503: already authentificated
        if($this->_Code == 503) {
          return(true);
        }
        return(false);
      }
      $this->_Socket->WriteLn(base64_encode(chr(0).$this->_AuthUname.chr(0).$this->_AuthPass));
      // if response is wrong
      if(!$this->_GetSmtpResponse(SMTP_CODETYPE_OK2)) {
        return(false);
      }
      // authentification successful
      return(true);
    }


    // SMTP Login authentification method implementation
    //   parameters: none
    //   return value: (bool) true on success, false on failure
    function _SmtpAuthLogin() {
      // send AUTH PLAIN command
      $this->_Socket->WriteLn('AUTH LOGIN');
      // if response is wrong
      if(!$this->_GetSmtpResponse(Array(SMTP_CODETYPE_OK2, SMTP_CODETYPE_OK3))) {
        // 503: already authentificated
        if($this->_Code == 503) {
          return(true);
        }
        return(false);
      }
      $this->_Socket->WriteLn(base64_encode($this->_AuthUname));
      // if response is wrong
      if(!$this->_GetSmtpResponse(SMTP_CODETYPE_OK3)) {
        return(false);
      }
      $this->_Socket->WriteLn(base64_encode($this->_AuthPass));
      // if response is wrong
      if(!$this->_GetSmtpResponse(SMTP_CODETYPE_OK2)) {
        return(false);
      }
      // authentification successful
      return(true);
    }


    // SMTP Login authentification method implementation
    //   parameters: none
    //   return value: (bool) true on success, false on failure
    function _SmtpAuthCramMd5() {
      // send AUTH PLAIN command
      $this->_Socket->WriteLn('AUTH CRAM-MD5');
      // if response is wrong
      if(!$this->_GetSmtpResponse(Array(SMTP_CODETYPE_OK2, SMTP_CODETYPE_OK3))) {
        // 503: already authentificated
        if($this->_Code == 503) {
          return(true);
        }
        return(false);
      }
      // encode password
      $key = $this->_AuthPass;
      $challenge = base64_decode($this->_Exts[0]);
echo 'Challenge: '.base64_encode($challenge).'<br />';
      if(strlen($key) > 64) {
        $key = pack('H32', md5($key));
      }
      if(strlen($key) < 64) {
        $key = str_pad($key, 64, chr(0));
      }
      $ipad = substr($key, 0, 64) ^ str_repeat(chr(0x36), 64);
      $opad = substr($key, 0, 64) ^ str_repeat(chr(0x5C), 64);
      $inner  = pack('H32', md5($ipad.$challenge));
      $pass = md5($opad . $inner);
      // send user name and encoded password
      $this->_Socket->WriteLn(base64_encode($this->_AuthUname.' '.$pass));
      // if response is wrong
      if(!$this->_GetSmtpResponse(SMTP_CODETYPE_OK2)) {
        return(false);
      }
      // authentification successful
      return(true);
    }


    // Gets SMTP server response and parse it
    //   parameters: validcodetypes (mixed - int/array) - either simple int, or array of ints, contains valid response codetypes (see SMTP_CODETYPE_??? constants)
    //               validcodes (mixed - int/array)     - either simple int, or array of ints, contains valid response codes
    //   return value: (bool) true on success, false on failure
    function _GetSmtpResponse($validcodetypes = NULL, $validcodes = NULL) {
      // clear previous response
      $this->_Code = SMTP_CODETYPE_ERROR;
      $this->_CodeType = SMTP_CODETYPE_ERROR;
      $this->_Exts = Array();

      // read server response
      while($str = $this->_Socket->ReadLn()) {
echo htmlentities($str).'<br />';
        // empty line - connection unexpectedly closed
        if($str == '') {
          $this->Disconnect();
          return(false);
        }
        // get response extensions
        $this->_Exts[] = trim(substr($str, 4));
        // get response code
        $this->_Code = substr($str, 0, 3);
        // response code should be numeric value
        if(is_numeric($this->_Code)) {
          $this->_CodeType = (int) substr($this->_Code, 0, 1);
          $this->_Code = (int) $this->_Code;
        }
        else {
          $this->_Code = SMTP_CODETYPE_ERROR;
          $this->_CodeType = SMTP_CODETYPE_ERROR;
          break;
        }

        // if it is last line, end reading
        if(substr($str, 3, 1) != '-') {
          break;
        }
      }
      // check code type validity
      $valid = true;
      if(!is_null($validcodetypes)) {
        $valid = false;
        // if there were more valid code types passed
        if(is_array($validcodetypes)) {
          foreach($validcodetypes as $codetype) {
            if($this->_CodeType == $codetype) {
              $valid = true;
              break;
            }
          }
        }
        // or only one valid code type
        else {
          if($this->_CodeType == $validcodetypes) {
            $valid = true;
          }
        }
      }
      // if code type is not valid
      if(!$valid) {
        return(false);
      }

      // check code validity
      if(!is_null($validcodes)) {
        $valid = false;
        // if there were more valid codes passed
        if(is_array($validcodes)) {
          foreach($validcodes as $code) {
            if($this->_Code == $code) {
              $valid = true;
              break;
            }
          }
        }
        // or only one valid code
        else {
          if($this->_Code == $validcodes) {
            $valid = true;
          }
        }
      }
      // if code is not valid
      if(!$valid) {
        return(false);
      }
      // code and codetype are valid
      return(true);
    }
  }
?>