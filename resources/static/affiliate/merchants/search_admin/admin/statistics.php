<?php
/*
----------------------------------------------------------------------------------
PhpDig Version 1.8.x - See the config file for the full version number.
This program is provided WITHOUT warranty under the GNU/GPL license.
See the LICENSE file for more information about the GNU/GPL license.
Contributors are listed in the CREDITS and CHANGELOG files in this package.
Developer from inception to and including PhpDig v.1.6.2: Antoine Bajolet
Developer from PhpDig v.1.6.3 to and including current version: Charter
Copyright (C) 2001 - 2003, Antoine Bajolet, http://www.toiletoine.net/
Copyright (C) 2003 - current, Charter, http://www.creditcards.com/
Contributors hold Copyright (C) to their code submissions.
Do NOT edit or remove this copyright or licence information upon redistribution.
If you modify code and redistribute, you may ADD your copyright to this notice.
----------------------------------------------------------------------------------
*/

$relative_script_path = '..';
$no_connect = 0;
include "$relative_script_path/includes/config.php";
include "$relative_script_path/libs/auth.php";
include "$relative_script_path/admin/robot_functions.php";

// extract http vars
extract(phpdigHttpVars(array('type' => 'string')),EXTR_SKIP);

set_time_limit(300);
?>
<?php include $relative_script_path.'/libs/htmlheader.php' ?>
<head>
<title>CreditCards.com : <?php phpdigPrnMsg('statistics') ?> </title>
<?php include $relative_script_path.'/libs/htmlmetas.php' ?>
<link rel="stylesheet" href="dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
	<SCRIPT type="text/javascript" src="dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20051112"></script>
	
	<script language="javascript"> 
  function show_row(){ 
    // Make sure the element exists before calling it's properties 
    if ((document.getElementById("police_response1") != null)&&(document.getElementById("police_response2") != null)) 
      // Toggle visibility between none and inline 
      if ((document.getElementById("police_response1").style.display == 'none')&&(document.getElementById("police_response2").style.display == 'none')) 
      { 
        document.getElementById("police_response1").style.display = 'inline'; 
        document.getElementById("police_response2").style.display = 'inline'; 
          document.getElementById("Inc_Police_Called").checked = true; 
      } else { 
        document.getElementById("police_response1").style.display = 'none'; 
        document.getElementById("police_response2").style.display = 'none'; 
          document.getElementById("Inc_Police_Called").checked = false; 
      } 
  } 
</script> 
</head>
<body bgcolor="white">
<table><tr><td valign="top">
<h1><?php phpdigPrnMsg('statistics') ?> - <b><? if ($_REQUEST ['type'] != ''){ phpdigPrnMsg("$type"); }?></b></h1>
<form action='statistics.php'>
<table width='770' align='center'>

<?
if($_POST['type'] == ''){
?>
<input type='hidden' name='action' value='reportchosen'>
<tr>
	<td>
		<b>Report Type:</b>		</td>
		<td>
		<select name='type'>
		<option value='Select a Report'><?php phpdigPrnMsg('selectreport') ?></option>
		<option value='mostterms'><?php phpdigPrnMsg('mostterms') ?></option>
		<option value='lastqueries'><?php phpdigPrnMsg('lastqueries') ?></option>
		<option value='lastclicks'><?php phpdigPrnMsg('lastclicks') ?></option>
		<option value='largestresults'><?php phpdigPrnMsg('largestresults') ?></option>
		<option value='mostempty'><?php phpdigPrnMsg('mostempty') ?></option>
		<option value='mostkeys'><?php phpdigPrnMsg('mostkeys') ?></option>
		<option value='mostpages'><?php phpdigPrnMsg('mostpages') ?></option>
		<option value='responsebyhour'><?php phpdigPrnMsg('responsebyhour') ?></option>
		</select>		
		</td>
		<td>
		<b>Date Period:</b>		</td>
		<td>
		<select name='timeframe'>
		<option value='yesterday'><?php phpdigPrnMsg('yesterday') ?></option>
		<option value='thisweek'><?php phpdigPrnMsg('thisweek') ?></option>
		<option value='lastweek'><?php phpdigPrnMsg('lastweek') ?></option>
		<option value='thismonth'><?php phpdigPrnMsg('thismonth') ?></option>
		<option value='lastmonth'><?php phpdigPrnMsg('lastmonth') ?></option>
		<option value='last3months'><?php phpdigPrnMsg('last3month') ?></option>
		<option value='last6months'><?php phpdigPrnMsg('last6months') ?></option>
		<option value='yeartodate'><?php phpdigPrnMsg('yeartodate') ?></option>
		<option value='lastyear'><?php phpdigPrnMsg('lastyear') ?></option>
		</select>		</td></tr>
		<tr><td>
		<b>Show X Top Searches:</b>		</td>
		<td>
		<select name='count'>
		<option value='all' selected="selected">all</option>
		<option value='25'>25</option>
		<option value='50'>50</option>
		<option value='100'>100</option>
		<option value='500'>500</option>
		<option value='1000'>1000</option>
		<option value='2000'>2000</option>
		<option value='5000'>5000</option>
		</select>		</td>
</tr>
<? }else{
	?>
	
	<?
	
	} ?>

<?
if($_POST['type'] != ''){
?>
<tr>
	<td>
		<b>Start Date:</b>		</td>
		<td>
		<input type='text' class='disabled' onFocus="this.blur()" name='startdate' value="<?=$_REQUEST['startdate']?>">&nbsp;<img src="cal.gif" onClick="displayCalendar(document.forms[0].startdate,'mm-dd-yyyy',this)">	</td>
</tr>
<tr>
	<td>
		<b>End Date:</b>		</td>
		<td>
		<input type='text' class='disabled' onFocus="this.blur()" name='enddate' value="<?=$_REQUEST['enddate']?>">&nbsp;<img src="cal.gif" onClick="displayCalendar(document.forms[0].enddate,'mm-dd-yyyy',this)">		</td>	
</tr>

<? } ?>


<tr>
<td></td><td><input type='submit' value='View Report' class='formSubmitButton'></td>
</tr>
</table>
<center>



</center>
</form>
<a href="index.php">[<?php phpdigPrnMsg('back') ?>]</a> <?php phpdigPrnMsg('to_admin') ?>.


</td></tr>
<table><tr><td valign="top"><br>
<?php
if ($type)
    {
    $query = "SET OPTION SQL_BIG_SELECTS=1";
    mysql_query($query,$id_connect);

    $start_table_template = "<table class=\"borderCollapse\">\n";
    $end_table_template = "</table>\n";
    $line_template = "<tr>%s</tr>\n";
    $title_cell_template = "\t<td class=\"blueForm\">%s</td>\n";
    $cell_template[0] = "\t<td class=\"greyFormDark\">%s</td>\n";
    $cell_template[1] = "\t<td class=\"greyForm\">%s</td>\n";
    $cell_template[2] = "\t<td class=\"greyFormLight\">%s</td>\n";
    $cell_template[3] = "\t<td class=\"greyForm\">%s</td>\n";

    $mod_template = count($cell_template);
    flush();

    $result = phpdigGetLogs($id_connect,$type,$timeframe);

    if ((is_array($result)) && (count($result) > 0)) {
        print $start_table_template;
        // title line
        $title_line = '';
        list($i,$titles) = each($result);
        foreach($titles as $field => $useless) {
            $title_line .= sprintf($title_cell_template,ucwords(str_replace('_',' ',$field)));
        }
        printf($line_template,$title_line);
        foreach($result as $id => $row) {
           $this_line = '';
           $id_row_style = $id % $mod_template;
           foreach ($row as $value) {
                $this_line .= sprintf($cell_template[$id_row_style],$value);
           }
           printf($line_template,$this_line);
        }
        print $end_table_template;
    }
    }
?>
</td></tr></table>
</body>
</html>