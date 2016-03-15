<?php
require_once('global.php');

/**
 * This script saves interview information to a 
 * database table.
 */
 
 /* Bring global data into scope */
 $name  = $_REQUEST['NAME'];
 $email = $_REQUEST['EMAIL'];
 $phone = $_REQUEST['PHONE_AREA'] .'-'. $_REQUEST['PHONE_PREFIX'] . '-' . $_REQUEST['PHONE_SUFFIX'] . ' ext: ' . $_REQUEST['PHONE_EXT'];

 
 /* Construct query */
 $sql = 'INSERT INTO 
 			interview_applications (name, email, phone) 
 			VALUES ('._q($name).', '._q($email).', '._q($phone).')';
 
 /* Execute query. */
 QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
 
?>