<?php

if(isset($_GET['pollId'])){
	
	require_once("./config.php");
	
	$optionId = false;
	
	if(isset($_GET['optionId'])){
		$optionId = $_GET['optionId'];
		$optionId = preg_replace("/[^0-9]/si","",$optionId);
	}
	$pollId = $_GET['pollId'];
	$pollId = preg_replace("/[^0-9]/si","",$pollId);
	
	$pollTitle = $_GET['pollTitle'];
	$optionVals = $_GET['optionVals']; // array
	$optionText = $_GET['optionText']; // array
	$numOptions = count($optionVals);
	
			
	// Insert new vote into the database
	// You may put in some more code here to limit the number of votes the same ip adress could cast.
	
	if($optionId)mysql_query("insert into cp_poller_vote(optionID,ipAddress)values('".$optionId."','".getenv("REMOTE_ADDR")."')");
	
	// Returning data as xml
	
	echo '<?xml version="1.0" ?>';
	
	//$res = mysql_query("select ID,pollerTitle from cp_poller where ID='".$pollId."'");
	//if($inf = mysql_fetch_array($res)){
		//echo "<pollerTitle>".$inf["pollerTitle"]."</pollerTitle>\n";
		echo "<pollerTitle>".str_replace("\'","'",$pollTitle)."</pollerTitle>\n";
		
		//$resOptions = mysql_query("select ID,optionText from cp_poller_option where pollerID='".$inf["ID"]."' order by pollerOrder") or die(mysql_error());
		//while($infOptions = mysql_fetch_array($resOptions)){
		for ($i=0; $i<$numOptions; $i++)
		{
			echo "<option>\n";
			//echo "\t<optionText>".$infOptions["optionText"]."</optionText>\n";					
			//echo "\t<optionId>".$infOptions["ID"]."</optionId>\n";					
			echo "\t<optionText>".str_replace("\'","'",$optionText[$i])."</optionText>\n";					
			echo "\t<optionId>".$optionVals[$i]."</optionId>\n";	
			
			//$resVotes = mysql_query("select count(ID) from cp_poller_vote where optionID='".$infOptions["ID"]."'");
			$resVotes = mysql_query("select count(ID) from cp_poller_vote where optionID='".$optionVals[$i]."'");
			if($infVotes = mysql_fetch_array($resVotes)){
				echo "\t<votes>".$infVotes["count(ID)"]."</votes>\n";							
			}
			else {
				echo "\t<votes>0</votes>\n";
			}

			echo "</option>";				
		}	
		//}				
	//}
	exit;

}else{
	echo "No success";
	
}
