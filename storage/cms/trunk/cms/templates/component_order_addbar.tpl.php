<?php
/*
 * Created on Jun 28, 2006
 *
 * Click Success L.P.
 * Author: Jason Huie
 * <jasonh@clicksuccess.com>
 */
 
 $this->returnlink='index.php?mod=CMS_view_siteToPage&siteId='.$this->siteId;
 ?>
 <head>
 <style type="text/css" media="screen">
		ul.sortableList {
			list-style-type: none;
			padding: 0px;
			margin: 0px;
			width: 100%;
			font-family: Arial, sans-serif;
		}
		
		ul.sortableList li.blue {
			cursor: move;
			padding: 2px 2px;
			margin: 2px 0px;
			border: 0px solid #000000;
			BACKGROUND: #FFFFFF
		}
		
		ul.sortableList span.name {
			cursor: move;
			padding: 2px 2px;
			margin: 2px 0px;
			border: 1px solid #FFFFFF;
			BACKGROUND: #FFFFFF url("cc-menuheader_center.gif") repeat-x top left; 
			width: '100%';
		}

li.sortableList{
	list-style: none;	
		
		
  </style>
  </head>
<form method='post'>
<center>Add Components: 
<select name=add onChange='submit()'>
<option>-----------------------------------</option>
<?while($this->rs_unassigned && !$this->rs_unassigned->EOF){
	echo "<option value=".$this->rs_unassigned->fields['itemid'].">".$this->rs_unassigned->fields['item']."</option>";
	$this->rs_unassigned->MoveNext();
}?>
</select>
<input type='hidden' name='action' value='add'>
<input type='hidden' name='pageId' value='<?=$this->pageId?>'>
<input type='hidden' name='siteId' value='<?=$this->siteId?>'>
<br>
</form>
