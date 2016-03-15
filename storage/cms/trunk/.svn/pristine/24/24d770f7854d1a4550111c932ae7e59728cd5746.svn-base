<?php
/*
 * Created on Jun 29, 2006
 *
 *Click Success L.P.
 *Author: Jason Huie
 *<jasonh@clicksuccess.com>
 */
?>
<head>
<link rel="stylesheet" href="/cms/style.css" type="text/css">
</head>
<center>
<form name='editComponent' method=POST>
	<table class='dbList' align='center' width='600' border=0>
	<tr>
		<td class="fctitle_blue" colspan=2 align='center'>Select Component</td>
		<td class="fctitle_blue" align='center'>Current Component</td>
	</tr>
	<tr height='150'>
		<td align='center' width=5%>
			[0]
		</td>
		<td width=45%>
			<select name='0' onChange='submit();'>
				<option value=-1>--Empty--</option>
				<?foreach($this->all as $value=>$name){
					echo '<option value='.$value;
					if($this->assigned['0']['name'] == $name)
						echo ' selected';

					echo '>'.$name.'</option>';
				}?>
			</select>
		</td>
		<td width=50%><center><?=$this->assigned['0']['render']?></center></td>
	</tr>
	<tr height='150'>
		<td align='center'>
			[1]
		</td>
		<td>
			<select name='1' onChange='submit();'>
				<option value=-1>--Empty--</option>
				<?foreach($this->all as $value=>$name){
					echo '<option value='.$value;
					if($this->assigned['1']['name'] == $name)
						echo ' selected';

					echo '>'.$name.'</option>';
				}?>
			</select>
		</td>
		<td><center><?=$this->assigned['1']['render']?></center></td>
	</tr>
	<tr height='150'>
		<td align='center'>
			[2]
		</td>
		<td>
			<select name='2' onChange='submit();'>
				<option value=-1>--Empty--</option>
				<?foreach($this->all as $value=>$name){
					echo '<option value='.$value;
					if($this->assigned['2']['name'] == $name)
						echo ' selected';

					echo '>'.$name.'</option>';
				}?>
			</select>
		</td>
		<td><center><?=$this->assigned['2']['render']?></center></td>
	</tr>
	<tr height='150'>
		<td align='center'>
			[3]
		</td>
		<td>
			<select name='3' onChange='submit();'>
				<option value=-1>--Empty--</option>
				<?foreach($this->all as $value=>$name){
					echo '<option value='.$value;
					if($this->assigned['3']['name'] == $name)
						echo ' selected';

					echo '>'.$name.'</option>';
				}?>
			</select>
		</td>
		<td><center><?=$this->assigned['3']['render']?></center></td>
	</tr>
	<tr height='150'>
		<td align='center'>
			[4]
		</td>
		<td>
			<select name='4' onChange='submit();'>
				<option value=-1>--Empty--</option>
				<?foreach($this->all as $value=>$name){
					echo '<option value='.$value;
					if($this->assigned['4']['name'] == $name)
						echo ' selected';

					echo '>'.$name.'</option>';
				}?>
			</select>
		</td>
		<td><center><?=$this->assigned['4']['render']?></center></td>
	</tr>
	<tr height='150'>
		<td align='center'>
			[5]
		</td>
		<td>
			<select name='5' onChange='submit();'>
				<option value=-1>--Empty--</option>
				<?foreach($this->all as $value=>$name){
					echo '<option value='.$value;
					if($this->assigned['5']['name'] == $name)
						echo ' selected';

					echo '>'.$name.'</option>';
				}?>
			</select>
		</td>
		<td><center><?=$this->assigned['5']['render']?></center></td>
	</tr>
</table>
<input type='hidden' name='mod' value='<?=$_REQUEST['mod']?>'>
<input type='hidden' name='committed' value=1>
<input type='hidden' name='pageId' value='<?=$_REQUEST['pageId']?>'>
<input type='hidden' name='siteId' value='<?=$_REQUEST['siteId']?>'>
<input type='button' value='Done' onClick="window.location='index.php?mod=CMS_view_siteToPage&siteId=<?=$_REQUEST['siteId']?>'">
</center>