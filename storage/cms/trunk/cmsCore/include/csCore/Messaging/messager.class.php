<?php
/**
 * 
 * ClickSuccess, L.P.
 * March 23, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 */ 

  
class csCore_Messaging_messager 
{
    var $prevMessagea;
    var $messages;
    var $errorMessages;
    var $errors;
    
    
    function csCore_Messaging_messager() 
    {
    	
    }
    
    function setMessage($message, $error=false, $line = "n/a", $file = "n/a")
    {
    	$message = htmlentities($message);
    	
    	if($error){
    		++ $this->errors;
    		$this->messages[] = "<p class='error'>[". date('H:i:s') ."] [LINE: ". $line . "] [FILE " . $file  ."] " .$message."</p>";	
    		$this->errorMessages[] = "<p class='error'>[". date('H:i:s') ."] [LINE: ". $line . "] [FILE " . $file  ."] " .$message."</p>";
    	}else{
    		$this->messages[] =  "<p class='console'>[". date('H:i:s') ."] " . $message . "</p>";
    	}
    	
    }
    
    function getMessages()
    {
    	if($this->errors < 1)
    		$message = "<p class='success'>Process handled successfully!</p>";
    	else
    		$message = "<p class='error'>Process encountered errors! <a class='error' href='index.php?mod=".$_REQUEST['mod']."&mailConsole=1'>Click Here to send a bug report</a></p>";
    	
    	if(is_array($this->messages)){
    		$revArray = array_reverse($this->messages);
    		foreach($revArray as $msg){
    			$message .= $msg;
    		}
    	}
    	$this->prevMessages = $message;
    	$this->messages = array();
    	$this->errors = 0;
    	return $message;
    }
    
    function getErrors()
    {
    	$message = '';
		if(is_array($this->errorMessages)){
    		$revArray = array_reverse($this->errorMessages);
    		foreach($revArray as $msg){
    			$message .= $msg;
    		}
    	}
    	$this->errorMessages = array();
    	return $message;    		
    }
    
    function hasMessages()
    {
    	return (count($this->messages) > 0);
    }
    
    function numErrors()
    {
    	return $this->errors;
    }
    
    function mailDebug()
    {
    	$subject = PROJECT_NAME . " [" . PROJECT_VERSION . "] console report.";
    	$body = str_replace("</p>" ,"\n", $this->prevMessages);
    	$body = strip_tags($body);
    	$to = DEBUG_EMAIL;
    	
    	if(mail($to, $subject, $body)){
    		$this->setMessage("Mail successfully sent.");
    	}else{
    		$this->setMessage("Error sending mail.", true);
    	}
    }
}
?>