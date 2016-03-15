<?
if(!$_REQUEST['endDay'])
	$_REQUEST['endDay']=date("j");
if(!$_REQUEST['endMonth'])
	$_REQUEST['endMonth']=date("n");
if(!$_REQUEST['endDay'])
	$_REQUEST['endYear']=date("Y");
?>
<script>

function exportAll()
{
  if(confirm("Are you sure you want to export all transactions?"))
   	document.location.href = "index.php?md=<?=$_REQUEST['md']?>&action=exportAll";
}

</script>
	
	<input type="button" style="height: 50px; font-weight: bold; margin: 10px;" value="Export ALL Transactions to Netfiniti" onclick="javascript:exportAll();">
	<form name=FilterForm action=index.php method=get>
    <!--
    
    <table class=listing border=0 cellspacing=0 cellpadding=3>
    <? QUnit_Templates::printFilter(1,"Export All Transactions"); ?>
    <tr>
      <td valign=top>Search by upload file</td>
      <td valign=top><input type=text name=file value="<?=$_REQUEST['file']?>"></td>
    </tr>
    <tr>
      <td valign=top>Search by date</td>
      <td valign=top><b>From&nbsp;&nbsp;</b>
      Day <select name=beginDay>
      <?for($x=1; $x<=31; $x++){?>
      <option <?=$_REQUEST['beginDay']==$x?"selected":""?>><?=$x?></option>;
      <?}?>
      </select>
      &nbsp;&nbsp;
      Month <select name=beginMonth>
      <?for($x=1; $x<=12; $x++){?>
      <option <?=$_REQUEST['beginMonth']==$x?"selected":""?>><?=$x?></option>;
      <?}?>
      </select>
      &nbsp;&nbsp;
      Year <select name=beginYear>
      <?for($x=0; $x<=2; $x++){?>
      <option <?=$_REQUEST['beginYear']==(date("Y")-$x)?"selected":""?>><?=(date("Y")-$x)?></option>;
      <?}?>
      </select>
      <br>
      <b>To&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
      Day <select name=endDay>
      <?for($x=1; $x<=31; $x++){?>
      <option <?=$_REQUEST['endDay']==$x?"selected":""?>><?=$x?></option>;
      <?}?>
      </select>
      &nbsp;&nbsp;
      Month <select name=endMonth>
      <?for($x=1; $x<=12; $x++){?>
      <option <?=$_REQUEST['endMonth']==$x?"selected":""?>><?=$x?></option>;
      <?}?>
      </select>
      &nbsp;&nbsp;
      Year <select name=endYear>
      <?for($x=0; $x<=2; $x++){?>
      <option <?=$_REQUEST['endYear']==(date("Y")-$x)?"selected":""?>><?=(date("Y")-$x)?></option>;
      <?}?>
      </select>
    </tr>
    <tr>
      <td>
      	&nbsp;<input type=submit class=formbutton value='<?=L_G_SEARCH?>'>
      	
      </td>
    </tr>
    </table>-->
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='<?=$_REQUEST['md']?>'>    
    <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">    
    <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">    
    <input type=hidden id=list_page name=list_page value='0'>
    
    
    <br>