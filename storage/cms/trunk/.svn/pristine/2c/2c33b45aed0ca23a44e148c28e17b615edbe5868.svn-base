<script>
function resetSite(ID){
	if(confirm('Are you sure you want to reset this site?'))
	document.location.href = 'index.php?action=reset&id=' + ID + '&mod=<?=$_REQUEST['mod']?>';
}
</script>

<center>
<h2><?=$this->cardName?></h2>
<form action='index.php'>
<input class=formbutton type=button value="BACK" onClick="goToMod('<?=$_REQUEST['mod']?>')">     
<input class=formbutton type=button value="RESET" onClick="resetSite('<?=$_REQUEST['id']?>');"> 
<input type='hidden' name='mod' value='<?=$_REQUEST['mod']?>'>
<input type='hidden' name='action' value='reset'>
<input type='hidden' name='id' value='<?=$_REQUEST['id']?>'>
</form>
</center>
<table width='100%'>
<tr>
<td width=20 class='componentHead'>
Line:
</td>
<td width='50%' class='componentHead'>
Last Audit:
</td >
<td width='50%' class='componentHead'>
Current Site:
</td>
<?

foreach($this->diffArray as $line => $array){ ?>
<tr onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
<td align='center' <?if(in_array($line, $this->ignoredLines)){ ?> class='ignoredLine' <? } else {  ?> class=listresult <? } ?>>
	<center>
	<?if(in_array($line, $this->ignoredLines)){ ?>
	<b><font color='red'>IGNORED</font></b><br>
	<a href='index.php?mod=<?=$_REQUEST['mod']?>&id=<?=$_REQUEST['id']?>&action=unignore&line=<?=$line?>'>[unignore]</a><br>	
	<? }else{ ?>
	<a href='index.php?mod=<?=$_REQUEST['mod']?>&id=<?=$_REQUEST['id']?>&action=ignore&line=<?=$line?>'>[ignore]</a><br>
	<? } ?>
	<?=$line?><br>
</td>
<td  width='50%' <?if(in_array($line, $this->ignoredLines)){ ?> class='ignoredLine' <? }else { ?>class=listresult <? } ?>>
	&nbsp;<?=$array[1]?>
</td>
<td width='50%' <?if(in_array($line, $this->ignoredLines)){ ?> class='ignoredLine' <? }else { ?>class=listresult <? } ?>>
	&nbsp;<?=$array[2]?>
</td>
</tr>
<? } ?>
</table>
<br>
<br>

