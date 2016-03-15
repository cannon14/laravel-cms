
    <form name=FilterForm action=index.php method=get>
    <table class=listing border=0 cellspacing=0>
    <? QUnit_Templates::printFilter(2, L_G_FILTER); ?>
    <tr>
      <td>&nbsp;<?=L_G_PRODUCT_CATEGORY?>&nbsp;</td>
      <td>
        <select name=aa_prod_cat>
          <option value='_'><?=L_G_ALL_PRODUCT_CATEGORIES?></option>
          <? while($data=$this->a_list_data->getNextRecord()) { ?>
            <option value='<?=$data['campaignid']?>' <?=($_REQUEST['aa_prod_cat'] == $data['campaignid'] ? 'selected' : '');?>><?=$data['name']?></option>
          <? } ?>
        </select>&nbsp;
      </td>
    </tr>
    <tr>
      <td>&nbsp;<?=L_G_STATUS?>&nbsp;</td>
      <td>
        <select name=aa_status>
          <option value='_'><?=L_G_ALLSTATES?></option>
          <option value=<?=AFFSTATUS_NOTAPPROVED?> <? print ($_REQUEST['aa_status'] == AFFSTATUS_NOTAPPROVED ? 'selected' : '');?>><?=L_G_WAITINGAPPROVAL?></option>
          <option value=<?=AFFSTATUS_APPROVED?> <? print ($_REQUEST['aa_status'] == AFFSTATUS_APPROVED ? 'selected' : '');?>><?=L_G_APPROVED?></option>
          <option value=<?=AFFSTATUS_SUPPRESSED?> <? print ($_REQUEST['aa_status'] == AFFSTATUS_SUPPRESSED ? 'selected' : '');?>><?=L_G_SUPPRESSED?></option>
        </select>&nbsp;
      </td>
    </tr>
    <tr>
      <td colspan=2 align=center>&nbsp;<input type=submit class=formbutton value='Search'>&nbsp;</td>
        <input type=hidden name=commited value='yes'>
        <input type=hidden name=md value='Affiliate_Merchants_Views_AppliedAffiliate'>
        <input type=hidden id=action name=action value=''>
        <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">
        <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">
    </tr>
    <tr>
      <td colspan=2>&nbsp;</td>
    </tr>
    </table>

    <br>
