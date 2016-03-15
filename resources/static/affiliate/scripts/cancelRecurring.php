<?

// include files
require_once('global.php');

$OrderID = preg_replace('/[\'\"\ ]/', '', $_GET['OrderID']);

$recComm = new RecurringCommissions();

$recComm->cancelRecurring($OrderID);

?>
OK