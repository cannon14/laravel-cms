<?PHP
error_reporting(E_ALL);
?>
<style>
	#hbxBar {
	width: 700px;
	height: 20px;
	margin: 0px 0px 0px 0px;
	position: relative;
	vertical-align: bottom;
	background: #FFFFFF;
	}
	#hbxBar ul {
		position: absolute;
		right: 0px;
		bottom: 0px;
		margin: 0px 0px 0px 0px;
		padding: 0px;
	}
	#hbxBar li {
		display: inline;
		font: bold 10px Arial, Helvetica, sans-serif;
		text-transform: lowercase;
	}
	#hbxBar li a {
		margin: 0px;
		color: #FFFFFF;
		text-decoration: none;
		background: #003366;
		white-space: nowrap;
		text-align: center;
		padding: 3px;
	}
	#hbxBar li a:hover {
		background: #99AAFF;
	}
	.formBox{
		width: 700px;
		background: #99AAFF;
		border: 3px solid #003366;
		padding: 3px;
	}
	.formBox th{
		background: #003366;
		color: #FFFFFF;
	}
	#dataTitle{
		background: #003366;
		color: #FFFFFF;
		width: 100%;
		font: bold 10px Arial, Helvetica, sans-serif;
	}
	.hbxButton{
		background: #003366;
		height: 20px;
		color: #FFFFFF;
		padding: 2px;
		border: 1px solid #FFFFFF;
		cursor: pointer;
	}	
</style>
<script type="text/javascript">
function submitForm(formAction)
{
   document.forms[0].action.value = formAction;
   document.forms[0].submit()   
}
</script>
<?
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
$mod = isset($_REQUEST['mod']) ? $_REQUEST['mod'] : '';
$siteId = isset($_POST['site']) ? $_POST['site'] : '';
$action = isset($_POST['action']) ? $_POST['action'] : '';
?>
      
<center>
<div id="hbxBar">
	<ul>
      <?
      $navTabs = array('issuerpages'=>'Issuer Pages','categorypages'=>'Category Pages','creditcards'=>'Individual Card Pages', 'merchantservices'=>'Merchant Services');
      
      foreach($navTabs as $tmpType => $label)
      {
      ?>
      <li><a href="javascript: document.forms[0].type.value = '<?= $tmpType; ?>'; document.forms[0].submit();" <?=$type == $tmpType || !isset($_REQUEST['type'])?'style="background: #99AAFF"':''?>><?= $label; ?></a></li>
      <?      
      }
      ?>      
	</ul>
</div>
<div class="formBox">
	<form method="post" name="selectorForm">
   
   <input type="hidden" name="mod" value="<?= $mod; ?>">
   <input type="hidden" name="type" value="<?= $type; ?>">
   <input type="hidden" name="action" value="<?= $action; ?>">   

		<table width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td width="200px">Select a Site:&nbsp;</td>
				<td>
               <select name="site" onChange="document.forms[0].submit();">
						<option value="-1"></option>
						<?
                  foreach($this->sites as $site)
                  {
                  ?>
							<option value="<?=$site->fields['siteId']?>" <?= $siteId == $site->fields['siteId']?'selected':''?>><?=$site->fields['siteName']?></option>
						<?
                  }
                  ?>
					</select>
            </td>
			</tr>
			<tr>         
				<?if(isset($this->cards)){?>
					<td>Select a Card:&nbsp;</td>
					<td><select name="detail_id"  onChange="submitForm('showPageData');">
						<option value="-1"></option>
						<?while($this->cards && !$this->cards->EOF)
                  {
                     // some card pages have no fid, I don't know why.  - mz
                     if($this->cards->fields['cardLink'] != '')
                     {
                  ?>
							<option value="<?=$this->cards->fields['id']?>" <?=$_REQUEST['detail_id']==$this->cards->fields['id']?'selected':''?>><?=$this->cards->fields[SITECATALYST_CARD_IDENTIFIER]?></option>
						<?
                     }
                     $this->cards->MoveNext();
                  }
                  ?>
					</select></td>
            <?}else if(isset($this->issuerpages)){?>
               <td>Select an Issuer Pages:</td>
               <td><select name="detail_id" onChange="submitForm('showPageData');">
                  <option value="-1"></option>                  
                  <?
                  while(!$this->issuerpages->EOF)
                  {?>
                     <option value="<?=$this->issuerpages->fields['id']; ?>" <?=$_REQUEST['detail_id']==$this->issuerpages->fields['id']?'selected':''?>><?=$this->issuerpages->fields[SITECATALYST_CARD_PAGE_IDENTIFIER]?></option>
                  <?
                  $this->issuerpages->MoveNext();
                  }
                  ?>
               </select></td>
            <?}else if(isset($this->categorypages)){?>
               <td>Select a Category Page:</td>
               <td>
                  <select name="detail_id" onChange="submitForm('showPageData');">
                  <option value="-1"></option>                  
                  <?
                  while(!$this->categorypages->EOF)
                  {?>
                     <option value="<?=$this->categorypages->fields['id']?>" <?=$_REQUEST['detail_id']==$this->categorypages->fields['id']?'selected':''?>><?=$this->categorypages->fields[SITECATALYST_CARD_PAGE_IDENTIFIER]?></option>
                  <?
                  $this->categorypages->MoveNext();
                  }
                  ?>
               </select></td>                                          					
				<?
            }
            else if(isset($this->merchantservices))
            {               
            ?>
					<td>Select a Merchant Service:&nbsp;</td>
					<td><select name="detail_id" onChange="submitForm('showPageData');">
						<option value="-1"></option>
						<?while($this->merchantservices && !$this->merchantservices->EOF){?>
							<option value="<?= $this->merchantservices->fields['merchant_service_detail_id']; ?>" <?=$_REQUEST['detail_id']==$this->merchantservices->fields['merchant_service_detail_id']?'selected':''?>><?=$this->merchantservices->fields[SITECATALYST_MERCHANT_SERVICE_IDENTIFIER]?></option>
						<?$this->merchantservices->MoveNext();}?>
					</select></td>
				<?}?>
			</tr>
		</table>	
</div>
<?
if(!empty($type) && !empty($siteId))
{
   $scPageVars = array();   
   // iterate over the rs, storing the var name, value, and it's id in the db.  We'll need
   // the var's id for replication safe insert statements.  - mz
   //echo 'page vars is ... ';   
   if(!empty($this->pageVars))
   {
      /*
      echo 'page vars are ';
      print_R($this->pageVars);
      */
      while(!$this->pageVars->EOF)
      {      
         $scPageVars[$this->pageVars->fields['var_name']]['value'] = $this->pageVars->fields['var_value'];
         $scPageVars[$this->pageVars->fields['var_name']]['var_name'] = $this->pageVars->fields['var_name'];       
         $this->pageVars->MoveNext();
      }      
   }
?>
<br>
<div class="formBox">	
		<div id="dataTitle">Site Catalyst Data</div>
		<table width="100%">
         <thead>
            <tr>
               <th colspan="2">
                  <div id="dataTitle">Page Variables</div>                  
               </th>
               <th colspan="2">
                  <div id="dataTitle">Conversion Variables</div>                  
               </th>
            </tr>
         </thead>
         <tr>
            <td>server:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'server'; ?>" type="text" value="<?= $scPageVars['server']['value']; ?>"></td>
            <td>campaign:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.$scPageVars.'campaign'; ?>" type="text" value="<?= $scPageVars['campaign']['value']; ?>"></td>
         </tr>         
         <tr>
            <td>s.pageName:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'pageName'; ?>" type="text" value="<?= $scPageVars['pageName']['value']; ?>"></td>
            <td>state:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'state'; ?>" type="text" value="<?= $scPageVars['state']['value']; ?>"></td>
         </tr>
         <tr>
            <td>s.channel:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'channel'; ?>" type="text" value="<?= $scPageVars['channel']['value']; ?>"></td>
            <td>zip:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'zip'; ?>" type="text" value="<?= $scPageVars['zip']['value']; ?>"></td>
         </tr>
         <tr>
            <td>s.pageType:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'pageType'; ?>" type="text" value="<?= $scPageVars['pageType']['value']; ?>"></td>
            <td>events:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'events'; ?>" type="text" value="<?= $scPageVars['events']['value']; ?>"></td>
         </tr>
         <tr>
            <td>s.prop1:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'prop1'; ?>" type="text" value="<?= $scPageVars['prop1']['value']; ?>"></td>
            <td>products:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'products'; ?>" type="text" value="<?= $scPageVars['products']['value']; ?>"></td>
         </tr>
         <tr>
            <td>s.prop2:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'prop2'; ?>" type="text" value="<?= $scPageVars['prop2']['value']; ?>"></td>
            <td>purchase ID:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'purchaseID'; ?>" type="text" value="<?= $scPageVars['purchaseID']['value']; ?>"></td>
         </tr>
         <tr>
            <td>s.prop3:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'prop3'; ?>" type="text" value="<?= $scPageVars['prop3']['value']; ?>"></td>
            <td>eVar1:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'evar1'; ?>" type="text" value="<?= $scPageVars['evar1']['value']; ?>"></td>
         </tr>
         <tr>
            <td>s.prop4:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'prop4'; ?>" type="text" value="<?= $scPageVars['prop4']['value']; ?>"></td>
            <td>eVar2:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'evar2'; ?>" type="text" value="<?= $scPageVars['evar2']['value']; ?>"></td>
         </tr>
         <tr>
            <td>s.prop5:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'prop5'; ?>" type="text" value="<?= $scPageVars['prop5']['value']; ?>"></td>
            <td>eVar3:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'evar3'; ?>" type="text" value="<?= $scPageVars['evar3']['value']; ?>"></td>
         </tr>
         <tr>
            <td>s.prop6:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'prop6'; ?>" type="text" value="<?= $scPageVars['prop6']['value']; ?>"></td>
            <td>eVar4:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'evar4'; ?>" type="text" value="<?= $scPageVars['evar4']['value']; ?>"></td>
         </tr>
         <tr>
            <td>s.prop7:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'prop7'; ?>" type="text" value="<?= $scPageVars['prop7']['value']; ?>"></td>
            <td>eVar5:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'evar5'; ?>" type="text" value="<?= $scPageVars['evar5']['value']; ?>"></td>
         </tr>
         <tr>
            <td>s.prop8:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'prop8'; ?>" type="text" value="<?= $scPageVars['prop8']['value']; ?>"></td>
            <td>eVar5:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'evar5'; ?>" type="text" value="<?= $scPageVars['evar5']['value']; ?>"></td>
         </tr>
         <tr>
            <td colspan="2">&nbsp;</td>            
            <td>eVar6:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'evar6'; ?>" type="text" value="<?= $scPageVars['evar6']['value']; ?>"></td>
         </tr>
         <tr>
            <td colspan="2">&nbsp;</td>            
            <td>eVar7:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'evar7'; ?>" type="text" value="<?= $scPageVars['evar7']['value']; ?>"></td>
         </tr>
         <tr>
            <td colspan="2">&nbsp;</td>            
            <td>eVar8:</td>
            <td><input name="<?= SITECATALYST_VAR_ID_PREFIX.'evar8'; ?>" type="text" value="<?= $scPageVars['evar8']['value']; ?>"></td>
         </tr>
			<tr>
				<td colspan="4" align="center">
               <span class="hbxButton" onClick="submitForm('saveData');">Submit</span>
            </td>
			</tr>
		</table>		
	</form>
</div>
<?
}
?>
<br>
<?if(sizeof($this->messages) > 0){?>
<div class="formBox">
	<?foreach($this->messages as $message)
		print $message.'<br>';
	?>
</div>
<?}?>
</center>