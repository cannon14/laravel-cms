<?php
QUnit_Global::includeClass('QCore_Bl_Users');

class QCore_Bl_Communications
{
    function insert($params)
    {
        if($params['accountid'] == '' && is_object($GLOBALS['Auth']))
        {
            $params['accountid'] = $GLOBALS['Auth']->getAccountID();
        }
        
        if($params['accountid'] == '')
            return false;
        
        $MessageID = QCore_Sql_DBUnit::createUniqueID('wd_g_messages', 'messageid');
        $sql = 'insert into wd_g_messages ('.
               'messageid, rtype, dateinserted, title, rtext, deleted, accountid'.
               ') values '.
               '('._q($MessageID).','._q($params['message_type']).','.sqlNow().
               ','._q($params['subject']).','._q($params['text']).','._q('0').
               ','._q($params['accountid']).')';
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        if($params['users'] != '' && is_array($params['users']))
        {
            $mus = array();
            foreach($params['users'] as $user)
            {
                $MessageToUserID = QCore_Sql_DBUnit::createUniqueID('wd_g_messagestousers', 'messagetouserid');
                $sql = 'insert into wd_g_messagestousers ('.
                       'messagetouserid, messageid, userid, email, rstatus'.
                       ') values '.
                       '('._q($MessageToUserID).','._q($MessageID).','._q($user['userid']).
                       ','._q($user['username']).','._q(MESSAGESTATUS_NOT_READED).')';
                $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
                if(!$ret) {
                    QUnit_Messager::setErrorMessage(L_G_DBERROR);
                    return false;
                }
            
                $mus[$user['userid']] = $MessageToUserID;
            }
        }
        else
        {
            $MessageToUserID = QCore_Sql_DBUnit::createUniqueID('wd_g_messagestousers', 'messagetouserid');
            $sql = 'insert into wd_g_messagestousers ('.
                    'messagetouserid, messageid, userid, email, rstatus'.
                    ') values '.
                    '('._q($MessageToUserID).','._q($MessageID).','._q($params['userid']).
                    ','._q($params['email']).','._q(MESSAGESTATUS_NOT_READED).')';

            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if(!$ret) {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
            
            $mus = $MessageToUserID;
        }
        
        return $mus;
    }

    //--------------------------------------------------------------------------

    function getUsersOfMessageAsArray($params)
    {
        if($params['accountid'] == '') return array();

        $sql = 'select mu.*, u.name, u.surname '.
               'from wd_g_messagestousers mu, wd_g_users u '.
               'where u.accountid='._q($params['accountid']).
               '  and u.deleted=\'0\''.
               '  and u.userid=mu.userid';
        if($params['messageid'] != '') $sql .= '  and mu.messageid='._q($params['messageid']);
               ' order by u.name, u.surname';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return array();
        }        

        $mus = array();

        while(!$rs->EOF)
        {
            $mus[$rs->fields['messageid']][$rs->fields['messagetouserid']]['messagetouserid'] = $rs->fields['messagetouserid'];
            $mus[$rs->fields['messageid']][$rs->fields['messagetouserid']]['messageid'] = $rs->fields['messageid'];
            $mus[$rs->fields['messageid']][$rs->fields['messagetouserid']]['rstatus'] = $rs->fields['rstatus'];
            $mus[$rs->fields['messageid']][$rs->fields['messagetouserid']]['userid'] = $rs->fields['userid'];
            $mus[$rs->fields['messageid']][$rs->fields['messagetouserid']]['email'] = $rs->fields['email'];
            $mus[$rs->fields['messageid']][$rs->fields['messagetouserid']]['name'] = $rs->fields['name'];
            $mus[$rs->fields['messageid']][$rs->fields['messagetouserid']]['surname'] = $rs->fields['surname'];

            $rs->MoveNext();
        }

        return $mus;
    }

    //--------------------------------------------------------------------------

    function getOnlyUserIDsOfMessageAsArray($params)
    {
        if($params['accountid'] == '' || $params['messageid'] == '') return array();

        $sql = 'select mu.messageid, mu.userid '.
               'from wd_g_messagestousers mu, wd_g_users u '.
               'where u.accountid='._q($params['accountid']).
               '  and u.deleted=\'0\''.
               '  and u.userid=mu.userid'.
               '  and mu.messageid='._q($params['messageid']).
               ' order by u.name, u.surname';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return array();
        }        

        $mus = array();

        while(!$rs->EOF)
        {   
            $mus[] = $rs->fields['userid'];

            $rs->MoveNext();
        }

        return $mus;
    }
    
    //--------------------------------------------------------------------------

    function checkOldNewsExist($params)
    {
        if($params['accountid'] == '' || $params['userid'] == '') return false;

        $sql = 'select mu.messagetouserid, mu.messageid, m.dateinserted, m.title, mu.userid '.
               'from wd_g_messagestousers mu, wd_g_messages m '.
               'where m.accountid='._q($params['accountid']).
               '  and m.messageid=mu.messageid'.
               '  and mu.userid='._q($params['userid']).
               '  and m.deleted=\'0\''.
               '  and m.rtype='._q(MESSAGETYPE_NEWS).
               '  and (mu.rstatus='._q(MESSAGESTATUS_NOT_SHOW).' or mu.rstatus='._q(MESSAGESTATUS_SHOW).')';
        $sql .= ' order by m.dateinserted, m.title';

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return array();
        }
        
        if($rs->EOF) {
            return false;
        } else {
            return true;
        }
    }
    
    //--------------------------------------------------------------------------
    
    function getUserNews($params)
    {
        if($params['accountid'] == '') return false;

        $user = QCore_Bl_Users::getUserData($params['userid']);
        
        if($user === false) return false;
        
        $sql = 'select mu.messagetouserid, mu.messageid, m.dateinserted, m.title, mu.userid '.
               'from wd_g_messagestousers mu, wd_g_messages m '.
               'where m.accountid='._q($params['accountid']).
               '  and m.messageid=mu.messageid';
        if($params['userid'] != '') $sql .= '  and mu.userid='._q($params['userid']);
        $sql .= '  and m.deleted=\'0\''.
               '  and m.rtype='._q(MESSAGETYPE_NEWS);
        if($params['view_old'] != '1')
            $sql .= '  and (mu.rstatus='._q(MESSAGESTATUS_NOT_READED).' or mu.rstatus='._q(MESSAGESTATUS_SHOW).')';
        $sql .= ' order by m.dateinserted, m.title';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return array();
        }

        $news = array();

        while(!$rs->EOF)
        {
            $news[$rs->fields['userid']][$rs->fields['messagetouserid']]['messagetouserid'] = $rs->fields['messagetouserid'];
            $news[$rs->fields['userid']][$rs->fields['messagetouserid']]['messageid'] = $rs->fields['messageid'];
            $news[$rs->fields['userid']][$rs->fields['messagetouserid']]['dateinserted'] = $rs->fields['dateinserted'];
            $news[$rs->fields['userid']][$rs->fields['messagetouserid']]['title'] = $rs->fields['title'];

            $strs = array('title' => $news[$rs->fields['userid']][$rs->fields['messagetouserid']]['title']);
            
            $strs = QCore_Bl_Communications::replaceInNews($user, $strs);
            
            $news[$rs->fields['userid']][$rs->fields['messagetouserid']]['title'] = $strs['title'];
            
            $rs->MoveNext();
        }
        
        return $news;
    }
    
    //--------------------------------------------------------------------------
    
    function getNews($params)
    {
        $user = QCore_Bl_Users::getUserData($params['userid']);
        
        if($user_data === false) return false;
    
        $sql = 'select * from wd_g_messages m, wd_g_messagestousers mu '.
               'where m.accountid='._q($params['accountid']).
               '  and m.messageid=mu.messageid'.
               '  and mu.messagetouserid='._q($params['messagetouserid']).
               '  and mu.userid='._q($params['userid']);
               '  and m.deleted=\'0\''.
               '  and m.rtype='._q(MESSAGETYPE_NEWS).
               '  and (mu.rstatus='._q(MESSAGESTATUS_NOT_READED).' or mu.rstatus='._q(MESSAGESTATUS_SHOW).')';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return false;
        }

        $news = array();
    
        $news['messagetouserid'] = $rs->fields['messagetouserid'];
        $news['dateinserted'] = $rs->fields['dateinserted'];
        $news['title'] = $rs->fields['title'];
        $news['status'] = $rs->fields['rstatus'];
        $news['rtext'] = $rs->fields['rtext'];
    
        $strs = array('title' => $news['title'], 'rtext' => $news['rtext']);
    
        $strs = QCore_Bl_Communications::replaceInNews($user, $strs);
    
        $news['title'] = $strs['title'];
        $news['rtext'] = $strs['rtext'];
    
        return $news;
    }
    
    //--------------------------------------------------------------------------
    
    function replaceInNews($user, $strs)
    {
        if(!is_array($strs) || count($strs) < 1) return false;
        
        foreach($strs as $key => $str)
        {
            $str = str_replace('$Date', date("Y-m-d"), $str);
            $str = str_replace('$Time', date("h:j:s"), $str);
            $str = str_replace('$Affiliate_id', $user['userid'], $str);
            $str = str_replace('$Affiliate_name', $user['name'].' '.$user['surname'], $str);
            $str = str_replace('$Affiliate_username', $user['username'], $str);
            $str = str_replace('$Affiliate_password', $user['rpassword'], $str);
            $str = str_replace('$Affiliate_company', $user['company_name'], $str);
            $str = str_replace('$Affiliate_weburl', $user['weburl'], $str);
            $str = str_replace('$Affiliate_street', $user['street'], $str);
            $str = str_replace('$Affiliate_city', $user['city'], $str);
            $str = str_replace('$Affiliate_state', $user['state'], $str);
            $str = str_replace('$Affiliate_country', $user['country'], $str);
            $str = str_replace('$Affiliate_zipcode', $user['zipcode'], $str);
            $str = str_replace('$Affiliate_phone', $user['phone'], $str);
            $str = str_replace('$Affiliate_fax', $user['fax'], $str);
            $str = str_replace('$Affiliate_taxssn', $user['tax_ssn'], $str);
            $str = str_replace('$Affiliate_extradata1', $user['data1'], $str);
            $str = str_replace('$Affiliate_extradata2', $user['data2'], $str);
            $str = str_replace('$Affiliate_extradata3', $user['data3'], $str);
            $str = str_replace('$Affiliate_extradata4', $user['data4'], $str);
            $str = str_replace('$Affiliate_extradata5', $user['data5'], $str);
            
            $strs[$key] = $str;
        }

        return $strs;
    }
    
    //--------------------------------------------------------------------------
    
    function checkMessageType($params)
    {
        if($params['messageid'] == '' || $params['messagetype'] == '') return false;
    
        $sql = 'select rtype from wd_g_messages m '.
               'where messageid='._q($params['messageid']).
               '  and rtype='._q($params['messagetype']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return false;
        }
        
        if($params['checknegate']) {
            if($rs->EOF) return true;
            else return false;
        }
        else {
            if($rs->EOF) return false;
            else return true;
        }

    }
    
    //--------------------------------------------------------------------------
    
    function loadMessageInfoToPost($params)
    {
        if($params['messageid'] == '' || $params['accountid'] == '') return false;

        $sql = 'select * from wd_g_messages where accountid='._q($params['accountid']).
               ' and messageid='._q($params['messageid']).
               ' and deleted=\'0\'';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs || $rs->EOF)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return false;
        }

        $_POST['mid'] = $rs->fields['messageid'];
        $_POST['message_type'] = $rs->fields['rtype'];
        $_POST['dateinserted'] = $rs->fields['dateinserted'];
        $_POST['emailsubject'] = $rs->fields['title'];
        $_POST['emailtext'] = $rs->fields['rtext'];
        $_POST['deleted'] = $rs->fields['deleted'];

        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function deleteMessage($params)
    {
        if($params['accountid'] == '') return false;
    
        $sql = 'delete from wd_g_messagestousers '.
               'where 1=1';
        if($params['messageid'] != '') $sql .= ' and messageid='._q($params['messageid']);
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return false;
        }

        QCore_History::DebugMsg(WLOG_ACTION, $sql, __FILE__, __LINE__);

        $sql = 'update wd_g_messages '.
               'set deleted='._q('1').
               'where accountid='._q($params['accountid']);
        if($params['messageid'] != '') $sql .= ' and messageid='._q($params['messageid']);
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return false;
        }
        
        QCore_History::DebugMsg(WLOG_ACTION, $sql, __FILE__, __LINE__);
        
        return true;
    }
    
    //--------------------------------------------------------------------------

    function changeMessageStatus($muid, $status = MESSAGESTATUS_SHOW)
    {
        $sql = 'update wd_g_messagestousers set rstatus='._q($status).
               ' where messagetouserid='._q($muid);
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        return true;
    }

    //--------------------------------------------------------------------------

    function sendEmail($params)
    {
        if($params['email'] == '')
        {
            $errorMsg = "Email sending failed, because the recipient email address was empty. Subject of email: '".$params['subject']."'";
            LogError($errorMsg, __FILE__, __LINE__);
            return true;
        }

        if($params['subject'] == '' && $params['text'] == '')
        {
            $errorMsg = "Email sending failed, because both subject and text of email were empty. Email recipient: '".$params['email']."'";
            LogError($errorMsg, __FILE__, __LINE__);
            return true;
        }

        $messageToUserID = QCore_Bl_Communications::insert($params);
        
        $sent = QCore_Bl_Communications::sendEmailDirect($params, $messageToUserID);
        
        return $sent;
    }
    
    //----------------------------------------------------------------------------

    function sendEmailDirect($params, $messageToUserID = '')
    {
        if($GLOBALS['Test_mode'] == '1')
            return true;
        
        $header = "From: ".$GLOBALS['Auth']->getSetting('Aff_system_email')."\r\n";
        
        /*  //uncomment this if you want to support special characters in emails
        
        $header = "From: ".$GLOBALS['Auth']->getSetting('Aff_system_email')."\r\n". 
        "MIME-Version: 1.0\r\n". 
        "Content-Type: text/plain; charset=\"UTF-8\"\r\n". 
        "Content-Transfer-Encoding: 7bit\r\n\r\n"; 
        
        */
        
        $sentByMail = true;
        if(is_object($GLOBALS['Auth']) && $GLOBALS['Auth']->getSetting('Aff_mail_send_type') == EMAILBY_SMTP) {
            $sentByMail = false;
        }

        if($sentByMail) {
            DebugMsg('Sending by mail() function', __FILE__, __LINE__);
            $sent = QCore_Bl_Communications::sendNormal($params['email'], $params['subject'], $params['text'], $header);
        }
        else {
            DebugMsg('Sending by SMTP', __FILE__, __LINE__);
            $sent = QCore_Bl_Communications::sendSmtp($params['email'], $params['subject'], $params['text'], $header);
        }
        
        if($sent && $messageToUserID != '') {
            QUnit_Global::includeClass('QCore_Bl_Communications');
            
            QCore_Bl_Communications::changeMessageStatus($messageToUserID, MESSAGESTATUS_SHOW);
        }
        
        return $sent;
    }
    
    //----------------------------------------------------------------------------
    
    function sendNormal($recipient, $subject, $text, $header)
    {
        return @mail($recipient, $subject, $text, $header);
    }
    
    //----------------------------------------------------------------------------
    
    function sendSmtp($mail_to, $subject, $message, $headers = '')
    {
        // Fix any bare linefeeds in the message to make it RFC821 Compliant.
        $message = preg_replace("#(?<!\r)\n#si", "\r\n", $message);

        if ($headers != '')
        {
            if (is_array($headers))
            {
                if (sizeof($headers) > 1)
                {
                    $headers = join("\n", $headers);
                }
                else
                {
                    $headers = $headers[0];
                }
            }
            $headers = chop($headers);
            
            // Make sure there are no bare linefeeds in the headers
            $headers = preg_replace('#(?<!\r)\n#si', "\r\n", $headers);
            
            // Ok this is rather confusing all things considered,
            // but we have to grab bcc and cc headers and treat them differently
            // Something we really didn't take into consideration originally
            $header_array = explode("\r\n", $headers);
            @reset($header_array);
            
            $headers = '';
            while(list(, $header) = each($header_array))
            {
                if (preg_match('#^cc:#si', $header))
                {
                    $cc = preg_replace('#^cc:(.*)#si', '\1', $header);
                }
                else if (preg_match('#^bcc:#si', $header))
                {
                    $bcc = preg_replace('#^bcc:(.*)#si', '\1', $header);
                    $header = '';
                }
                $headers .= ($header != '') ? $header . "\r\n" : '';
            }
            
            $headers = chop($headers);
            $cc = explode(', ', $cc);
            $bcc = explode(', ', $bcc);
        }

        if (trim($subject) == '')
        {
            LogError("No email Subject specified", __FILE__, __LINE__);
            return false;
        }
        
        if (trim($message) == '')
        {
            LogError("Email message was blank", __FILE__, __LINE__);
            return false;
        }
        
        // Ok we have error checked as much as we can to this point let's get on
        // it already.
        if( !$socket = @fsockopen($GLOBALS['Auth']->getSetting('Aff_smtp_server'), 25, $errno, $errstr, 20) )
        {
            LogError("Could not connect to smtp host : $errno : $errstr", __FILE__, __LINE__);
            return false;
        }
        
        // Wait for reply
        if(!QCore_Bl_Communications::parseSmtp($socket, "220", __LINE__)) {
            DebugMsg('SMTP: parseSmtp 220 returned false', __FILE__, __LINE__);
            return false;
        }

        // Do we want to use AUTH?, send RFC2554 EHLO, else send RFC821 HELO
        // This improved as provided by SirSir to accomodate
        if( $GLOBALS['Auth']->getSetting('Aff_smtp_username') != '' && $GLOBALS['Auth']->getSetting('Aff_smtp_password') != '' )
        {
            fputs($socket, "EHLO " . $GLOBALS['Auth']->getSetting('Aff_smtp_server') . "\r\n");
            if(!QCore_Bl_Communications::parseSmtp($socket, "250", __LINE__)) {
                DebugMsg('SMTP: parseSmtp 250 returned false', __FILE__, __LINE__);
                return false;
            }
            
            fputs($socket, "AUTH LOGIN\r\n");
            if(!QCore_Bl_Communications::parseSmtp($socket, "334", __LINE__)) {
                DebugMsg('SMTP: parseSmtp 334 returned false', __FILE__, __LINE__);
                return false;
            }
            
            fputs($socket, base64_encode($GLOBALS['Auth']->getSetting('Aff_smtp_username')) . "\r\n");
            if(!QCore_Bl_Communications::parseSmtp($socket, "334", __LINE__)) {
                DebugMsg('SMTP: parseSmtp 334 (after username) returned false', __FILE__, __LINE__);
                return false;
            }
            
            fputs($socket, base64_encode($GLOBALS['Auth']->getSetting('Aff_smtp_password')) . "\r\n");
            if(!QCore_Bl_Communications::parseSmtp($socket, "235", __LINE__)) {
                DebugMsg('SMTP: parseSmtp 235 (after username) returned false', __FILE__, __LINE__);
                return false;
            }
        }
        else
        {
            fputs($socket, "HELO " . $GLOBALS['Auth']->getSetting('Aff_smtp_server') . "\r\n");
            if(!QCore_Bl_Communications::parseSmtp($socket, "250", __LINE__)) {
                DebugMsg('SMTP: parseSmtp after HELO returned false', __FILE__, __LINE__);
                return false;
            }
        }
        
        // From this point onward most server response codes should be 250
        // Specify who the mail is from....
        fputs($socket, "MAIL FROM: <" . $GLOBALS['Auth']->getSetting('system_email') . ">\r\n");
        if(!QCore_Bl_Communications::parseSmtp($socket, "250", __LINE__)) {
            DebugMsg('SMTP: parseSmtp after MAIL FROM returned false', __FILE__, __LINE__);
            return false;
        }
        
        // Specify each user to send to and build to header.
        $to_header = '';
        
        // Add an additional bit of error checking to the To field.
        $mail_to = (trim($mail_to) == '') ? 'Undisclosed-recipients:;' : trim($mail_to);
        if (preg_match('#[^ ]+\@[^ ]+#', $mail_to))
        {
            fputs($socket, "RCPT TO: <$mail_to>\r\n");
            if(!QCore_Bl_Communications::parseSmtp($socket, "250", __LINE__)) {
                DebugMsg('SMTP: parseSmtp after RCPT TO returned false', __FILE__, __LINE__);
                return false;
            }
        }
        
        // Ok now do the CC and BCC fields...
        @reset($bcc);
        while(list(, $bcc_address) = each($bcc))
        {
            // Add an additional bit of error checking to bcc header...
            $bcc_address = trim($bcc_address);
            if (preg_match('#[^ ]+\@[^ ]+#', $bcc_address))
            {
                fputs($socket, "RCPT TO: <$bcc_address>\r\n");
                if(!QCore_Bl_Communications::parseSmtp($socket, "250", __LINE__)) {
                    DebugMsg('SMTP: parseSmtp after RCPT TO 2 returned false', __FILE__, __LINE__);
                    return false;
                }
            }
        }
        
        @reset($cc);
        while(list(, $cc_address) = each($cc))
        {
            // Add an additional bit of error checking to cc header
            $cc_address = trim($cc_address);
            if (preg_match('#[^ ]+\@[^ ]+#', $cc_address))
            {
                fputs($socket, "RCPT TO: <$cc_address>\r\n");
                if(!QCore_Bl_Communications::parseSmtp($socket, "250", __LINE__)) {
                    DebugMsg('SMTP: parseSmtp after RCPT TO 3 returned false', __FILE__, __LINE__);
                    return false;
                }
            }
        }
 
        // Ok now we tell the server we are ready to start sending data
        fputs($socket, "DATA\r\n");
        
        // This is the last response code we look for until the end of the message.
        if(!QCore_Bl_Communications::parseSmtp($socket, "354", __LINE__)) {
            DebugMsg('SMTP: parseSmtp after DATA returned false', __FILE__, __LINE__);
            return false;
        }

        // Send the Subject Line...
        fputs($socket, "Subject: $subject\r\n");

        // Now the To Header.
        fputs($socket, "To: $mail_to\r\n");

        // Now any custom headers....
        fputs($socket, "$headers\r\n\r\n");

        // Ok now we are ready for the message...
        fputs($socket, "$message\r\n");

        // Ok the all the ingredients are mixed in let's cook this puppy...
        fputs($socket, ".\r\n");
        if(!QCore_Bl_Communications::parseSmtp($socket, "250", __LINE__)) { 
            DebugMsg('SMTP: parseSmtp after HEADER returned false', __FILE__, __LINE__);
            return false;
        }

        // Now tell the server we are done and close the socket...
        fputs($socket, "QUIT\r\n");
        fclose($socket);
        
        return true;
    }
    
    //----------------------------------------------------------------------------
    
    function parseSmtp($socket, $response, $line = __LINE__) 
    { 
        while (substr($server_response, 3, 1) != ' ') 
        {
            if (!($server_response = fgets($socket, 256))) 
            { 
                LogError("SMTP: Couldn't get mail server response codes", __FILE__, __LINE__);
                return false;
            } 
        } 
        
        if (!(substr($server_response, 0, 3) == $response)) 
        { 
            LogError("SMTP: Problem sending Mail. Response: $server_response", __FILE__, __LINE__);
            return false;
        } 
        
        return true;
    } 
    
    
}
?>
