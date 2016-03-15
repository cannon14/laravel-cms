<?
$data=$this->a_list_data->getNextRecord();
?>
<center>
<table width=100% border=0 cellspacing=0 cellpadding=5>
 <tr>
  <td>
    <table class=listing width=100% border=0 cellspacing=0 cellpadding=2>
    <? QUnit_Templates::printFilter(2, $_POST['header']) ?>
    <tr>
      <td class=formBText>&nbsp;<?=L_G_CAMPAIGN_NAME;?>&nbsp;</td>
      <td class=formText><?=$data['name']?></td>
    </tr>
    <tr>
      <td class=formBText>&nbsp;<?=L_G_CAMPAIGNTYPE;?>&nbsp;</td>
      <td class=formText>
      <?
        print $this->a_Auth->getComposedCommissionTypeString($data['commtype']);
      ?> &nbsp;
      </td>
    </tr>
    <tr>
      <td class=formBText valign=top>&nbsp;<?=L_G_COMMISSIONS;?>&nbsp;</td>
      <td class=formText>
        <? $this->a_this->drawCommissionField($data); ?>
      </td>
    </tr>
    <tr>
      <td class=formBText valign=top>&nbsp;<?=L_G_BANNERS;?>&nbsp;</td>
      <td class=formText><?=$data['bannercount']?></td>
    </tr>
<? if($this->a_Auth->getSetting('Aff_join_campaign') == '1') { ?>
    <tr>
      <td class=formBText>&nbsp;<?=L_G_STATUS;?>&nbsp;</td>
      <td class=formText>
      <?
        if($data['rstatus'] == AFFSTATUS_NOTAPPROVED) print L_G_WAITINGAPPROVAL;
        else if($data['rstatus'] == AFFSTATUS_APPROVED) print L_G_APPROVED;
        else if($data['rstatus'] == AFFSTATUS_SUPPRESSED) print L_G_SUPPRESSED;
        else print L_G_NOTJOINED;
      ?> &nbsp;
      </td>
    </tr>
<? } ?>
    <tr>
      <td class=formBText colspan=2 valign=top>&nbsp;<?=L_G_SHORT_DESCRIPTION;?>&nbsp;</td>
    </tr>
      <td class=formText colspan=2><?=$data['shortdescription']?></td>
    </tr>
    <tr>
      <td class=formBText colspan=2 valign=top>&nbsp;<?=L_G_DESCRIPTION;?>&nbsp;</td>
    </tr>
      <td class=formText colspan=2><?=$data['description']?></td>
    </tr>
<? if($data['rstatus'] == AFFSTATUS_SUPPRESSED) { ?>
    <tr>
      <td class=formBText colspan=2>&nbsp;<?=L_G_DECLINE_REASON;?>&nbsp;</td>
    </tr>
      <td class=formText colspan=2>
        <?=($data['declinereason'] == '' ? L_G_REASON_NOT_SPECIFIED : $data['declinereason']) ?>
      </td>
    </tr>
<? } ?>
    <tr>
      <td class=dir_form colspan=2 align=center>
        <input type=button class=formbutton value='<?=L_G_CLOSE?>' onClick='javascript:window.close();'>
      </td>
    </tr>
    </table>
   </td>
  </tr>
</table>
</center>
