<?php
  // CLASS DEFINITION
  class QUnit_Io_Socket {
    // PRIVATAE OBJECT VARIABLES
    var $_Fp = NULL;                 // file pointer - connection resource
    var $_Addr = '';                 // socket address
    var $_Port = 0;                  // socket port
    var $_Blocking = true;           // socket blocking flag
    var $_Persistent = false;        // connection persistent flag
    var $_Timeout = 0;               // connection timeout setting


    // PUBLIC OBJECT VARIABLES


    // CONSTRUCTOR & DESTRUCTOR


    // PUBLIC METHODS
    // establishes socket connection (or reconnects if connection is already opened)
    //   parameters: none
    //   return value: (bool) true on success, false on failure
    function Connect() {
      // if connected, close connection
      if(is_resource($this->_Fp)) {
        @fclose($this->_Fp);
        $this->_Fp = null;
      }

      // try to connect
      $errno = NULL;
      $errstr = NULL;
      if($this->_Persistent) {
        $this->_Fp = pfsockopen($this->_Addr, $this->_Port, $errno, $errstr, $this->_Timeout);
      }
      else {
        $this->_Fp = fsockopen($this->_Addr, $this->_Port, $errno, $errstr, $this->_Timeout);
      }
      // check connection
      if($this->_Fp === false) {
        $this->_Fp = NULL;
        QUnit_Messager::setErrorMessage(L_G_SOCKETERROR);
        QCore_History::DebugMsg(WLOG_ERROR, L_G_SOCKETERROR.': ('.$errno.') '.$errstr, __FILE__, __LINE__);
        return(false);
      }
       // set connection attributes
       $this->SetBlocking($this->_Blocking);
       $this->SetTimeout($this->_Timeout);
       // on success return true
       return(true);
    }


    // closes connection
    //   parameters: none
    //   return value: none
    function Disconnect() {
      // if connection is established
      if($this->IsConnected()) {
        // close connection
        @fclose($this->_Fp);
        $this->_Fp = NULL;
      }
    }


    // checks, whether connection is established
    //   parameters: none
    //   return value: (bool) true/false
    function IsConnected() {
      if(!is_resource($this->_Fp)) {
        return(false);
      }
      return(true);
    }


    // sets host address and port
    //   parameters: Addr (string) - host address
    //               Port (int)    - host port
    //   return value: (array) array containing old settings
    function SetAddress($Addr, $Port) {
      $oldaddr = Array('Addr' => $this->_Addr, 'Port' => $this->_Port);
      $this->_Addr = $Addr;
      $this->_Port = $Port;
      return($oldaddr);
    }


    // gets connection address and port
    //   parameters: none
    //   return value: (array) array containting connection address and port setting
    function GetAddress() {
      return(Array('addr' => $this->_Addr, 'port' => $this->_Port));
    }


    // sets blocking flag
    //   parameters: Blocking (bool) - blocking flag
    //   return value: (bool) old blocking flag setting
    function SetBlocking($Blocking) {
      if(!is_bool($Blocking)) {
        return($this->_Blocking);
      }
      $oldblocking = $this->_Blocking;
      $this->_Blocking = $Blocking;
      if($this->IsConnected()) {
        stream_set_blocking($this->_Fp, $this->_Blocking);
      }
      return($oldblocking);
    }


    // gets connection blocking flag
    //   parameters: none
    //   return value: (bool) connection blocking flag setting
    function GetBlocking() {
      return($this->_Blocking);
    }


    // sets connection timeout
    //   parameters: Timeout (int) - timeout in seconds
    //   return value: (int) old timeout setting
    function SetTimeout($Timeout) {
      if(!is_int($Timeout)) {
        return($this->_Timeout);
      }
      $oldtimeout = $this->_Timeout;
      $this->_Timeout = $Timeout;
      if($this->IsConnected) {
        stream_set_timeout($this->_Fp, $this->_Timeout);
      }
      return($oldtimeout);
    }


    // gets connection timeout setting
    //   parameters: none
    //   return value: (int) connection timeout setting in seconds
    function GetTimeout() {
      return($this->_Timeout);
    }


    // gets connection status
    //   parameters: none
    //   return value: (array) array containing connection status (see PHP help for stream_get_mata_data function for more information)
    function GetStatus() {
      if(!$this->IsConnected()) {
        return(false);
      }

      return(stream_get_meta_data($this->_Fp));
    }


    // gets string
    //   parameters: Len (int) - string maximum length
    //   return value: (string) string red from socket
    function Gets($Len) {
      if(!$this->IsConnected()) {
        QUnit_Messager::setErrorMessage(L_G_SOCKETERROR);
        QCore_History::DebugMsg(WLOG_ERROR, L_G_SOCKETERROR, __FILE__, __LINE__);
      }
      return(@fgets($this->_Fp, $Len));
    }


    // reads string
    //   parameters: Len (int) - string maximum length
    //   return value: (string) string red from socket
    function Read($Len) {
      if(!$this->IsConnected()) {
        QUnit_Messager::setErrorMessage(L_G_SOCKETERROR);
        QCore_History::DebugMsg(WLOG_ERROR, L_G_SOCKETERROR, __FILE__, __LINE__);
      }
      return(@fread($this->_Fp, $Len));
    }


    // gets byte
    //   parameters: none
    //   return value: (byte) byte red from socket
    function ReadByte() {
      if(!$this->IsConnected()) {
        QUnit_Messager::setErrorMessage(L_G_SOCKETERROR);
        QCore_History::DebugMsg(WLOG_ERROR, L_G_SOCKETERROR, __FILE__, __LINE__);
      }
      return(ord(@fread($this->_Fp, 1)));
    }


    // gets word
    //   parameters: none
    //   return value: (word) word red from socket
    function ReadWord() {
      if(!$this->IsConnected()) {
        QUnit_Messager::setErrorMessage(L_G_SOCKETERROR);
        QCore_History::DebugMsg(WLOG_ERROR, L_G_SOCKETERROR, __FILE__, __LINE__);
      }
      $word = @fread($this->_Fp, 2);
      return((ord($word[0]) + (ord($word[1]) << 8)));
    }


    // gets int
    //   parameters: none
    //   return value: (int) number red from socket
    function ReadInt() {
      if(!$this->IsConnected()) {
        QUnit_Messager::setErrorMessage(L_G_SOCKETERROR);
        QCore_History::DebugMsg(WLOG_ERROR, L_G_SOCKETERROR, __FILE__, __LINE__);
      }
      $int = @fread($this->_Fp, 4);
      return((ord($int[0]) + (ord($int[1]) << 8) + (ord($int[2]) << 16) + (ord($int[3]) << 24)));
    }


    // gets null-terminated string
    //   parameters: none
    //   return value: (string) string red from socket
    function ReadStr() {
      if(!$this->IsConnected()) {
        QUnit_Messager::setErrorMessage(L_G_SOCKETERROR);
        QCore_History::DebugMsg(WLOG_ERROR, L_G_SOCKETERROR, __FILE__, __LINE__);
      }
      $str = '';
      while(($char = @fread($this->_Fp, 1)) != "\x00") {
        $str .= $char;
      }
      return($str);
    }


    // gets line
    //   parameters: none
    //   return value: (string) line red from socket
    function ReadLn() {
      if(!$this->IsConnected()) {
        QUnit_Messager::setErrorMessage(L_G_SOCKETERROR);
        QCore_History::DebugMsg(WLOG_ERROR, L_G_SOCKETERROR, __FILE__, __LINE__);
      }
      $str = '';
      while(1) {
        if($this->Eof()) {
          break;
        }
        $str .= @fread($this->_Fp, 1);
        $status = $this->GetStatus();
        if($status['timed_out']) {
          break;
        }
        if((substr($str, -1) == "\n") || (substr($str, -2) == "\r\n")) {
          rtrim($str, "\r\n");
          break;
        }
      }
      return($str);
    }


    // puts string
    //   parameters: Data (string) - string to write
    //   return value: (mixed) number of bytes successfully written on success, or false on failure
    function Write($Data) {
      if(!$this->IsConnected()) {
        QUnit_Messager::setErrorMessage(L_G_SOCKETERROR);
        QCore_History::DebugMsg(WLOG_ERROR, L_G_SOCKETERROR, __FILE__, __LINE__);
      }
      return(fwrite($this->_Fp, $Data));
    }


    // puts line (adds CR LF at the end of given string)
    //   parameters: Data (string) - string to write
    //   return value: (mixed) number of bytes successfully written on success, or false on failure
    function WriteLn($Data) {
echo '<br />'.nl2br(htmlentities($Data)).'<br />';
      if(!$this->IsConnected()) {
        QUnit_Messager::setErrorMessage(L_G_SOCKETERROR);
        QCore_History::DebugMsg(WLOG_ERROR, L_G_SOCKETERROR, __FILE__, __LINE__);
      }
      return(fwrite($this->_Fp, $Data."\r\n"));
    }


    // checks, whteher end of stream was reached
    //   parameters: none
    //   return value: (bool) true, if end of stream was reached, or false if not
    function Eof() {
      if((!$this->IsConnected()) || (feof($this->_Fp))) {
        return(true);
      }
      return(false);
    }
  }
?>