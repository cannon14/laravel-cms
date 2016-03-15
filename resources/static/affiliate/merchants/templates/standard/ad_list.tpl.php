
    <table class=listing border=0 cellspacing=0 cellpadding=1>
    <tr>
       <td class=actionheader colspan=10>
       		<div style="text-align: center;">
       			<?
       				$alphabet = array();
	       			for ($i=65; $i<=90; $i++) {
					 	$alphaLink = '<a href="javascript:filterByAlphabet(\'' . chr($i) . '\');">' . chr($i) . '</a>';
					 	
					 	array_push($alphabet, $alphaLink);
					}
					print(implode(' | ', $alphabet));
       			?>
       			&nbsp;&nbsp;&nbsp;&nbsp;
       			<input type="button" value="Show All" onclick="javascript:filterByAlphabet('All');">
       		</div>
       </td>
    </tr>    
<? if($this->a_action_permission['add']) { ?>
    <tr>
       <td class=actionheader align=left colspan=10><b><a class=mainlink href="javascript:addCampaign();"><?=L_G_ADDAD?></a></b></td>
    </tr>    
<? } ?>
    <tr>
      <td class=listheader colspan=10 align=center><?=L_G_LISTOFADS?>&nbsp;<? print " ( ".L_G_ROWS.": ".$this->a_numrows." )"; ?></td>
     </tr>
    <tr class=listheader>
<?
      // QUnit_Templates::printHeader(L_G_ID, 'campaignid');
      QUnit_Templates::printHeader(L_G_NAME, 'name');
      QUnit_Templates::printHeader(L_G_CREATED, 'dateinserted');
      QUnit_Templates::printHeader(L_G_CAMPAIGNTYPE, 'commtype');
      QUnit_Templates::printHeader(L_G_COMMISSIONS);
      QUnit_Templates::printHeader(L_G_BANNERS);
      
      if($this->a_Auth->getSetting('Aff_join_campaign') == '1') {
        QUnit_Templates::printHeader(L_G_STATUS);
      }
      QUnit_Templates::printHeader(L_G_ACTIONS);
?>    
    </tr>    
<?
    while($data=$this->a_list_data->getNextRecord())
    {
?>
    <tr class=listresult class=row onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <!--  <td class=listresult>&nbsp;<?=$data['campaignid']?>&nbsp;</td> -->
      <td class=listresultnocenter align=left nowrap>&nbsp;<?=$data['name']?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;<?=$data['dateinserted']?>&nbsp;</td>
      <td class=listresult>&nbsp;
      <?
        print $GLOBALS['Auth']->getComposedCommissionTypeString($data['commtype']);
      ?> &nbsp;
      </td>
      <td class=listresultnocenter nowrap align=left>
        <? $this->a_this->drawCommissionField($data); ?>    
      &nbsp;
      </td>
      <td class=listresult>&nbsp;<?=$data['bannercount']?>&nbsp;</td>
      <? if($this->a_Auth->getSetting('Aff_join_campaign') == '1') { ?>
        <td class=listresult>&nbsp;<?=($data['status'] == AFF_CAMP_PRIVATE ? L_G_PRIVATE : L_G_PUBLIC )?>&nbsp;</td>
      <? } ?>
       
      <td class=listresult>
        <select name=action_select OnChange="performAction(this);">
        <option value="-">------------------------</option>
        <? if($this->a_action_permission['edit']) { ?>
             <option value="javascript:editCampaign('<?=$data['campaignid']?>');"><?=L_G_EDIT?></option>
        <? }
           if($this->a_action_permission['delete']) {
        ?>
             <option value="javascript:Delete('<?=$data['campaignid']?>');"><?=L_G_DELETE?></a>
        <? } ?>
        	<option value="javascript:viewBanners('<?=$data['campaignid']?>');">Manage Banners</a>
        </select>
      </td>
      </td>
    </tr>    
      
<?
    }
?>
  </table>
  
  </form>
