<head>
  <script>
  	function addPage(specialsPageId, pageId){
  		document.location.href = "index.php?mod=<?=$_REQUEST['mod']?>&pageId="+pageId+"&cardpageId="+specialsPageId+"&action=addPage";
  	}
  </script>
  
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

.rate-top {  
font-family: Arial, Helvetica, sans-serif; 
font-size: 10px; 
background-color: #d7d7d7; 
text-align: center; 
padding-right: 1px; 
padding-left: 1px
}


.rates-bottom {  
font-family: Verdana, Arial, Helvetica, sans-serif; 
font-size: 9px; 
background-color: #F2F2F2; 
text-align: center
}


.rate-rc {  
width: 100%; 
background-color: #FFFFFF
}		
		
.cc-card-art-align {
text-align: right; 
background-color: #FFFFFF;
vertical-align: top;
}

.offer-left-sub {
font-size: 13px;
background-color: #EEEEEE; 
text-align: left;
font-family: Arial, Helvetica, sans-serif; 
font-weight: bold;
width: 100%;
color: #0066CC;
padding-left: 4px
BACKGROUND: #FFFFFF
}

.offer-left {
font-size: 13px;
background-color: #CCCCCC; 
text-align: left;
font-family: Arial, Helvetica, sans-serif; 
font-weight: bold;
width: 100%;
color: #0066CC;
padding-left: 4px
BACKGROUND: #FFFFFF
}


.offer-left a:link {
color: #000999; 
text-decoration: none

}


.offer-left a:hover {
color: #000999; 
text-decoration: none
}


.offer-left a:visited {
color: #000999; 
text-decoration: none
}

.details {
	background-color: #FFFFFF;
	list-style-position: outside;
	list-style-image: url(/images/b3-spacer.gif);
	vertical-align: text-top
}		
		
		
  </style>
</head>


<form action="index.php" method="GET">
   <table align='center' class='component'>
	<tr>
		<td colspan="2" class='componentHead'>
		Profiles Page
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<h4 style="text-align: center">
			Edit this profile below
			</h4>
		</td>
    <tr>
     <td align=left nowrap width="150">&nbsp;Profile Title</td>
     <td align=left>
        <input type=text name=title size=100 value="<?=$this->profileRecords->fields['title']?>">
     </td>
    </tr>  
    <tr>
     <td align=left nowrap>&nbsp;Sub Title</td>
     <td align=left>
        <input type=text name=sub_title size=100 value="<?=$this->profileRecords->fields['sub_title']?>">
     </td>
    </tr> 
    <tr>
     <td align=left nowrap>&nbsp;Content Sub Title</td>
     <td align=left>
        <input type=text name=content_sub_title size=100 value="<?=$this->profileRecords->fields['content_sub_title']?>">
     </td>
    </tr> 
    <tr>
     <td align=left nowrap>&nbsp;Background Light Color Code</td>
     <td align=left>
        <input type=text name=background_color_code_light size=100 value="<?=$this->profileRecords->fields['background_color_code_light']?>">
     </td>
    </tr> 
    <tr>
     <td align=left nowrap>&nbsp;Background Dark Color Code</td>
     <td align=left>
        <input type=text name=background_color_code_dark size=100 value="<?=$this->profileRecords->fields['background_color_code_dark']?>">
     </td>
    </tr> 
    <tr>
     <td align=left nowrap>&nbsp;Profile Description</td>
     <td align=left>
        <input type=text name=profile_description size=100 value="<?=$this->profileRecords->fields['profile_description']?>">
     </td>
    </tr> 
    <tr>
     <td align=left nowrap>&nbsp;Profile Card Types</td>
     <td align=left>
        <input type=text name=profile_card_types size=100 value="<?=$this->profileRecords->fields['profile_card_types']?>">
     </td>
    </tr> 
    <tr>
     <td align=left nowrap>&nbsp;Profile Tip</td>
     <td align=left>
        <input type=text name=profile_tip size=100 value="<?=$this->profileRecords->fields['profile_tip']?>">
     </td>
    </tr> 
    <tr>
     <td align=left nowrap>&nbsp;Image Path</td>
     <td align=left>
        <input type=text name=image_path size=100 value="<?=$this->profileRecords->fields['image_path']?>">
     </td>
    </tr> 
    <tr>
     <td align=left nowrap>&nbsp;Media URL (SWF File)</td>
     <td align=left>
        <input type=text name=media_url size=100 value="<?=$this->profileRecords->fields['media_url']?>">
     </td>
    </tr> 
    <tr>
     <td align=left nowrap>&nbsp;Calculator URL (SWF File)</td>
     <td align=left>
        <input type=text name=calculator_url size=100 value="<?=$this->profileRecords->fields['calculator_url']?>">
     </td>
    </tr> 
    <tr>
     <td align=left nowrap>&nbsp;Rank</td>
     <td align=left>
        <input type=text name=rank size=100 value="<?=$this->profileRecords->fields['rank']?>">
     </td>
    </tr> 
    <tr>
     <td align=left nowrap>&nbsp;Card Category 1</td>
     <td align=left>
     	<select name=card_category_1>
     	<?php
     		$this->cardCategories->MoveFirst();
			while (!$this->cardCategories->EOF) {
				?>
    			<option <?=$this->cardCategories->fields['cardpageId'] == $this->profileRecords->fields['card_category_1'] ? 'selected' : ''?>
    			value="<?=$this->cardCategories->fields['cardpageId']?>"><?=$this->cardCategories->fields['pageName']?></option>
    			<?php
    			$this->cardCategories->MoveNext();
			}
     	?>
    	</select>
	 </td>
    </tr> 
    <tr>
     <td align=left nowrap>&nbsp;Card Category 2</td>
     <td align=left>
     	<select name=card_category_2>
     	<?php
     		$this->cardCategories->MoveFirst();
			while (!$this->cardCategories->EOF) {
				?>
    			<option <?=$this->cardCategories->fields['cardpageId'] == $this->profileRecords->fields['card_category_2'] ? 'selected' : ''?>
    			value="<?=$this->cardCategories->fields['cardpageId']?>"><?=$this->cardCategories->fields['pageName']?></option>
    			<?php
    			$this->cardCategories->MoveNext();
			}
     	?>
    	</select>
    </td>
    </tr> 
    <tr>
     <td align=left nowrap>&nbsp;Card Category 3</td>
     <td align=left>
     	<select name=card_category_3>
     	<?php
     		$this->cardCategories->MoveFirst();
			while (!$this->cardCategories->EOF) {
				?>
    			<option <?=$this->cardCategories->fields['cardpageId'] == $this->profileRecords->fields['card_category_3'] ? 'selected' : ''?>
    			value="<?=$this->cardCategories->fields['cardpageId']?>"><?=$this->cardCategories->fields['pageName']?></option>
    			<?php
    			$this->cardCategories->MoveNext();
			}
     	?>
    	</select>
    </td>
    </tr> 
    
    <tr>
     <td align=left nowrap>&nbsp;Tag Category 1</td>
     <td align=left>
     	<select name=tag_category_1>
     	<?php
     		$this->tagCategories->MoveFirst();
			while (!$this->tagCategories->EOF) {
				?>
    			<option <?=$this->tagCategories->fields['card_category_id'] == $this->profileRecords->fields['tag_category_1'] ? 'selected' : ''?>
    			value="<?=$this->tagCategories->fields['card_category_id']?>"><?=$this->tagCategories->fields['card_category_name']?></option>
    			<?php
    			$this->tagCategories->MoveNext();
			}
     	?>
    	</select>
	 </td>
    </tr> 
    <tr>
     <td align=left nowrap>&nbsp;Tag Category 2</td>
     <td align=left>
     	<select name=tag_category_2>
     	<?php
     		$this->tagCategories->MoveFirst();
			while (!$this->tagCategories->EOF) {
				?>
    			<option <?=$this->tagCategories->fields['card_category_id'] == $this->profileRecords->fields['tag_category_2'] ? 'selected' : ''?>
    			value="<?=$this->tagCategories->fields['card_category_id']?>"><?=$this->tagCategories->fields['card_category_name']?></option>
    			<?php
    			$this->tagCategories->MoveNext();
			}
     	?>
    	</select>
    </td>
    </tr>     
    
    <tr>
     <td align=left nowrap>&nbsp;Tag Category 3</td>
     <td align=left>
     	<select name=tag_category_3>
     	<?php
     		$this->tagCategories->MoveFirst();
			while (!$this->tagCategories->EOF) {
				?>
    			<option <?=$this->tagCategories->fields['card_category_id'] == $this->profileRecords->fields['tag_category_3'] ? 'selected' : ''?>
    			value="<?=$this->tagCategories->fields['card_category_id']?>"><?=$this->tagCategories->fields['card_category_name']?></option>
    			<?php
    			$this->tagCategories->MoveNext();
			}
     	?>
    	</select>
     </td>
    </tr> 
    <tr>
    <tr>
     <td align=left nowrap>&nbsp;News Static Content</td>
     <td align=left>
        <textarea name=news_static_content cols=60 rows=10 style="font-size:8pt;"><?=$this->profileRecords->fields['news_static_content']?></textarea>
     </td>
    </tr>  
     <td align=left nowrap>&nbsp;Date Inserted</td>
     <td align=left>
        <input type=text disabled name=insert_time size=100 value='<?=$this->profileRecords->fields['insert_time']?>'>
     </td>
    </tr>
    </tr>  
     <td align=left nowrap>&nbsp;Date Updated</td>
     <td align=left>
        <input type=text disabled name=update_time size=100 value='<?=$this->profileRecords->fields['update_time']?>'>
     </td>
    </tr>
    <tr>
    	<td align="center" colspan="2">

				<input type=hidden name=tmdl_status value="<?=$_REQUEST['tmdl_status']?>">
				<input type=hidden name=mod value='<?=$_REQUEST['mod']?>'>

				<input type=hidden name=action value="updateProfile">
				<input type=hidden name=commited value='yes'>
	
				<input type="hidden" name="cardpageId" value="<?=$_REQUEST['cardpageId']?>">
				<input class=formbutton type="submit" value="Save">
				<input class=formbutton type=button value="Back" onClick="goToMod('CMS_view_pages')">      
  
			</form>
    	
    	</td>
    </tr>
    </table>


	


<br><br>
