<?php
  // DEFINES
  // send mail modes
  define('ML_MODE_SENDMAIL'    , 1               , true);
  define('ML_MODE_SMTP'        , 2               , true);

  // content types
  define('ML_CONTENTTYPE_PLAIN', 'text/plain'    , true);
  define('ML_CONTENTTYPE_HTML' , 'text/html'     , true);

  // SMTP authentification methods
  define('SMTP_AUTH_NONE'     , 'NONE'           , true);
  define('SMTP_AUTH_PLAIN'    , 'PLAIN'          , true);
  define('SMTP_AUTH_LOGIN'    , 'LOGIN'          , true);
  define('SMTP_AUTH_CRAMMD5'  , 'CRAM-MD5'       , true);

  // CLASS DEFINITION
  class Qunit_Io_Mail {
    // PRIVATE OBJECT VARIABLES
    // configuration
    var $_Mode;                          // sendmail mode (ML_MODE_??? constant)
    var $_SendmailPath;                  // path to sendmail
    var $_Smtp;                          // SMTP server address
    var $_SmtpPort;                      // SMTP port
    var $_SmtpAuth;                      // SMTP authentification method
    var $_SmtpAuthUname;                 // SMTP user name
    var $_SmtpAuthPass;                  // SMTP password
    var $_SmtpDomain;                    // local domain used for SMTP communication

    // e-mail headers
    var $_ReturnPath;                    // return path
    var $_From = Array();                // from e-mail address
    var $_To = Array(Array());           // to e-mail addresses
    var $_Cc = Array(Array());           // carbon copy e-mail addresses
    var $_Bcc = Array(Array());          // blind carbon copy e-mail addresses
    var $_Subject;                       // e-mail subject
    var $_ContentType;                   // e-mail content type
    var $_Encoding;                      // e-mail encoding
    var $_Message;                       // message body
    var $_Attachments = Array(Array());  // e-mail attachments

    // PUBLIC OBJECT VARIABLES


    // CONSTRUCTOR & DESTRUCTOR
    // constructor
    //   parameters: none
    //   return value: N/A
    function Newsletter_Bl_Mailer() {
      // set default configuration
      $this->_Mode = ML_MODE_SENDMAIL;
      $this->_SendmailPath = ini_get('sendamil_path');
      $this->_Smtp = ini_get('SMTP');
      $this->_SmtpPort = ini_get('smtp_port');
      $this->_SmtpAuth = SMTP_AUTH_NONE;
      $this->_SmtpAuthUname = '';
      $this->_SmtpAuthPass = '';
      $this->_SmtpDomain = 'localhost';

      // set default e-mail headers
      $this->_ReturnPath = ini_get('sendmail_from');
      $this->_From = Array('Email' => ini_get('sendmail_from'), 'Name' => '');
      $this->_To = Array(Array('Email' => ini_get('sendmail_from'), 'Name' => ''));
      $this->_Cc = Array(Array());
      $this->_Bcc = Array(Array());
      $this->_Subject = '';
      $this->_ContentType = ML_CONTENTTYPE_PLAIN;
      $this->_Encoding = 'iso-8859-1';
      $this->_Message = '';
      $this->_Attachments = Array(Array());
    }


    // PUBLIC METHODS
    // sends e-mail
    //   parameters: none
    //   return value: (bool) true on success, false on failure
    function SendMail() {
      // if there is no address to send e-mail to, there is nothing to do...
      if(!$this->_To) {
        return(false);
      }

      // set recipients strings
      $tostr = '';
      $tonamesstr = '';
      $ccnamesstr = '';
      $bccnamesstr = '';
      foreach($this->_To as $email) {
          $tostr .= ', '.$email['Email'];
          $tonamesstr .= ', '.$email['Name'].' <'.$email['Email'].'>';
      }
      foreach($this->_Cc as $ccemail) {
          if(isset($ccemail['Email'])) {
            $ccnamesstr .= ', '.$ccemail['Name'].' <'.$ccemail['Email'].'>';
          }
      }
      foreach($this->_Bcc as $bccemail) {
          if(isset($bccemail['Email'])) {
            $bccnamesstr .= ', '.$bccemail['Name'].' <'.$bccemail['Email'].'>';
          }
      }
      // trash last ', '
      $tostr = substr($tostr, 2);
      $tonamesstr = substr($tonamesstr, 2);
      $ccnamesstr = substr($ccnamesstr, 2);
      $bccnamesstr = substr($bccnamesstr, 2);

      // set from e-mail string
      $fromstr = $this->_From['Name'].' <'.$this->_From['Email'].'>';

      // is there any attachments?
      $atts = false;
      if(isset($this->_Attachments[0]['Data'])) {
        $atts = true;
      }

      // generate e-mail header
      $headers = 'Return-Path: <'.$this->_ReturnPath.'>'."\n".
                 'From: '.$fromstr."\n".
                 'To: '.$tonamesstr."\n";
      if($ccnamesstr) {
        $headers .= 'CC: '.$ccnamesstr."\n";
      }
      // sendmail needs also BCC: header, SMTP class can not receive it
      if(($this->_Mode == ML_MODE_SENDMAIL) && ($bccnamesstr)) {
        $headers .= 'BCC: '.$bccnamesstr."\n";
      }
      $headers .= 'Subject: '.$this->_Subject."\n".
                  'Date: '.date('r')."\n".
                  'X-Mailer: QUnit Mailer library ver. 1.0'."\n".
                  'MIME-Version: 1.0'."\n";
      $message = '';
      $boundary = '';
      if($atts) {
        $boundary = 'boundary'.md5(time()).'boudnary';
        $headers .= 'Content-Type: multipart/mixed;'."\n".
                    ' boundary="'.$boundary.'"'."\n";
        $message = 'This is a multi-part message in MIME format.'."\n\n".
                   '--'.$boundary."\n".
                   'Content-Type: '.$this->_ContentType.'; charset="'.$this->_Encoding.'"'."\n".
                   'Content-Transfer-Encoding: 7bit'."\n\n";
      }
      else {
        $headers .= 'Content-Type: '.$this->_ContentType.'; charset="'.$this->_Encoding.'"'."\n".
                    'Content-Transfer-Encoding: 7bit'."\n\n";
      }

      // generate e-mail full MIME body
      $message .= $this->_Message."\n\n";
      if($atts) {      
        foreach($this->_Attachments as $att) {
          $message .= '--'.$boundary."\n".
                      'Content-Type: '.$att['Type'].';'."\n".
                      ' name="'.$att['Name'].'"'."\n".
                      'Content-Transfer-Encoding: base64'."\n\n".
                      chunk_split(base64_encode($att['Data']))."\n\n";
      }
        $message .= '--'.$boundary.'--'."\n";
      }

      // select desired send mode
      switch($this->_Mode) {
        case ML_MODE_SENDMAIL : // sendmail
          // set necessary parameters
          ini_set('sendmail_path', $this->_SendmailPath);
          ini_set('sendmail_from', $this->_From);
          ini_set('SMTP', NULL);
          ini_set('smtp_port', NULL);
          // send e-mail
          return(@mail($tostr, $this->_Subject, $message, $headers));
        case ML_MODE_SMTP     : // SMTP
          // include SMTP support class
          QUnit_Global::includeClass('QUnit_Io_Smtp');
          // create SMTP support object
          $smtp = new QUnit_Io_Smtp($this->_Smtp, $this->_SmtpPort, $this->_SmtpDomain, $this->_SmtpAuth, $this->_SmtpAuthUname, $this->_SmtpAuthPass);
          // generate recipients array
          $to = Array();
          foreach($this->_To as $email) {
            $to[] = $email['Email'];
          }
          foreach($this->_Cc as $email) {
            $to[] = $email['Email'];
          }
          foreach($this->_Bcc as $email) {
            $to[] = $email['Email'];
          }
          // while there are some temporarily rejected recipients
          while(is_array($sm = $smtp->SendMail($this->_From['Email'], $to, $message, $headers, false))) {
            // set recipients array to list of temporarily rejected recipients
            $to = $sm;
          }
          // e-mail jobs done, say hello
          $smtp->Done();
          // are there some errors?
          if($sm) {
            // everything ok
            return(true);
          }
          else {
            // something went wrong
            return(false);
          }
        default               : // send mail mode not supported
          return(false);
          break;
      }
    }


    // sets e-mail subject and message
    //   parameters: Subject (string) - e-mail subject
    //               Message (stirng) - e-mail message
    //   return value: (array) old e-mail subject and message
    function SetMessage($Subject, $Message) {
      $oldto = $this->_To;
      $oldmessage = $this->_Message;

      $this->_Subject = $Subject;
      $this->_Message = $Message;

      return(Array('Subject'    => $oldsubject,
                   'Message'    => $oldmessage));
    }


    // sets e-mail addresses
    //   parameters: To (mixed - string/array)   - either simple string, or array of strings, conatining information about recipients
    //               Cc (mixed - string/array)   - either simple string, or array of strings, conatining information about carbon copy recipients
    //               Bcc (mixed - string/array)  - either simple string, or array of strings, conatining information about blind carbon copy recipients
    //               From (mixed - string/array) - either simple string, or array of strings, conatining information about sender
    //               ReturnPath (string)         - ReturnPath header element
    //   return value: (array) old e-mail addresses
    function SetEmails($To, $Cc = NULL, $Bcc = NULL, $From = NULL, $ReturnPath = NULL) {
      // save old e-mails
      $oldto = $this->_To;
      $oldcc = $this->_Cc;
      $oldbcc = $this->_Bcc;
      $oldfrom = $this->_From;
      $oldreturnpath = $this->_ReturnPath;

      // set recipients
      if(is_array($To)) {
        if(isset($To['Email'])) {
          $this->_To = Array(Array('Email' => $To['Email'], 'Name' => $To['Name']));
        }
        else {
          $i = 0;
          foreach($To as $email) {
            $this->_To[$i++] = Array('Email' => $email['Email'], 'Name' => $email['Name']);
          }
        }
      }
      else {
        $this->_To = Array(Array('Email' => $To, 'Name' => ''));
      }

      // set carbon copy recipients
      if(!is_null($Cc)) {
        if(is_array($Cc)) {
          if(isset($Cc['Email'])) {
            $this->_Cc = Array(Array('Email' => $Cc['Email'], 'Name' => $Cc['Name']));
          }
          else {
            $i = 0;
            foreach($Cc as $ccemail) {
              $this->_Cc[$i++] = Array('Email' => $ccemail['Email'], 'Name' => $ccemail['Name']);
            }
          }
        }
        else {
          $this->_Cc = Array(Array('Email' => $Cc, 'Name' => ''));
        }
      }
      else {
        $this->_Cc = Array(Array());
      }

      // set blind carbon copy recipients
      if(!is_null($Bcc)) {
        if(is_array($Bcc)) {
          if(isset($Bcc['Email'])) {
            $this->_Bcc = Array(Array('Email' => $Bcc['Email'], 'Name' => $Bcc['Name']));
          }
          else {
            $i = 0;
            foreach($Bcc as $bccemail) {
              $this->_Bcc[$i++] = Array('Email' => $bccemail['Email'], 'Name' => $bccemail['Name']);
            }
          }
        }
        else {
          $this->_Bcc = Array(Array('Email' => $Bcc, 'Name' => ''));
        }
      }
      else {
        $this->_Bcc = Array(Array());
      }

      // set sender information
      if(!is_null($From)) {
        if(is_array($From)) {
          $this->_From['Email'] = $From['Email'];
          $this->_From['Name'] = $From['Name'];
        }
        else {
          $this->_From['Email'] = $From;
          $this->_From['Name'] = '';
        }
      }

      // set return path
      if($ReturnPath) {
        $this->_ReturnPath = $ReturnPath;
      }

      // return old values
      return(Array('To'         => $oldto,
                   'Cc'         => $oldcc,
                   'Bcc'        => $oldbcc,
                   'From'       => $oldfrom,
                   'ReturnPath' => $oldreturnpath));
    }

    // sets attachments
    //   parameters: Attach (mixed - string/array) - information about all attachments
    //   return value: (array) old attachments
    function SetAttachments($Attach) {
      // save old attachments
      $oldattach = $this->_Attachments;

      // set attachments
      if(is_array($Attach)) {
        if(isset($Attach['Data'])) {
          $this->_Attachments = Array(Array('Data' => $Attach['Data'], 'Type' => $Attach['Type'], 'Name' => $Attach['Name']));
        }
        else {
          $this->_Attachments = Array();
          foreach($Attach as $att) {
            $this->_Attachments[] = Array('Data' => $att['Data'], 'Type' => $att['Type'], 'Name' => $att['Name']);
          }
        }
      }
      else {
        $this->_To = Array(Array('Data' => $Attach, 'Type' => 'text/plain', 'Name' => 'attachment.txt'));
      }

      // return old value
      return($oldattach);
    }


    // sets content type
    //   parameters: ContentType (string) - content type
    //               Encoding (string)    - encoding
    //   return value: (array) old values
    function SetContentType($ContentType, $Encoding) {
      $oldcontenttype = $this->_ContentType;
      $oldencoding = $this->_Encoding;
      $this->_ContentType = $ContentType;
      $this->_Encoding = $Encoding;
      return(Array('ContentType' => $oldcontenttype, 'Encoding' => $oldencoding));
    }


    // returns information about content type
    //   parameters: none
    //   return value: (array) content type information
    function GetContentType() {
      return(Array('ContentType' => $this->_Contenttype, 'Encoding' => $this->_Encoding));
    }


    // sets send mode
    //   parameters: Mode (int) - send mode (see ML_MODE_??? constants)
    //   return value: (int) old send mode
    function SetMode($Mode) {
      $oldmode = $this->_Mode;
      $this->_Mode = $Mode;
      return($OldMode);
    }


    // returns send mode setting
    //   parameters: none
    //   return value: (int) send mode setting
    function GetMode() {
      return($this->_Mode);
    }


    // sets sendmail path
    //   parameters: Path (string) - sendmail system path
    //   return value: (string) old sendmail path setting
    function SetSendmailPath($Path) {
      $oldpath = $this->_SendmailPath;
      $this->_SendmailPath = $Path;
      return($oldpath);
    }


    // returns sendmail path setting
    //   parameters: none
    //   return value: (string) send mail path setting
    function GetSendmailPath() {
      return($this->_SendmailPath);
    }


    // sets SMTP configuration
    //   parameters: Smtp (string)   - SMTP server address
    //               Port (int)      - SMTP server port
    //               Auth (string)   - SMTP authentification method
    //               Uname (string)  - SMTP user name
    //               Pass (string)   - SMTP password
    //               Domain (string) - local domain
    //   return value: (array) old values
    function SetSmtp($Smtp, $Port = NULL, $Auth = SMTP_AUTH_NONE, $Uname = '', $Pass = '', $Domain = 'localhost') {
      // save old settings
      $oldsmtp = $this->_Smtp;
      $oldauth = $this->_SmtpAuth;
      $olduname = $this->_SmtpAuthUname;
      $oldpass = $this->_SmtpAuthPass;
      $olddomain = $this->_SmtpDomain;

      // set new values
      $this->_Smtp = $Smtp;
      // port should be integer
      if((!is_null($Port)) && (is_integer($Port))) {
        $oldport = $this->_SmtpPort;
        $this->_SmtpPort = $Port;
      }
      else {
      }
      $this->_SmtpAuth = $Auth;
      $this->_SmtpAuthUname = $Uname;
      $this->_SmtpAuthPass = $Pass;
      $this->_SmtpDomain = $Domain;
      // return old settings array
      return(Array('Smtp' => $oldsmtp, 'Port' => $oldport, 'Auth' => $oldauth, 'Uname' => $olduname, 'Pass' => $oldpass, 'Domain' => $olddomain));
    }


    // returns SMTP configuration
    //   parameters: none
    //   return value: (array) SMTP configuration
    function GetSmtp() {
      return(Array('Smtp' => $this->_Smtp, 'Port' => $this->_SmtpPort, 'Auth' => $this->_SmtpAuth, 'Uname' => $this->_SmtpAuthUname, 'Pass' => $this->_SmtpAuthPass, 'Domain' => $this->_SmptDomain));
    }


    // PRIVATE METHODS
  }
?>