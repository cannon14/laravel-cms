        <table border=0 cellspacing=0 cellpadding=3>
        <tr>
          <td class=dir_form valign=top>
          <?=L_G_COOKIELIFETIME;?>
          </td>
          <td valign=top><input type=text name=cookielifetime size=2 value="<?=$_POST['cookielifetime']?>">*&nbsp;<?=L_G_DAYS?>&nbsp;&nbsp;<br>
          <? showMsgNoBR(L_G_COOKIEMSG,'ok'); ?>
          </td>
          <td class=dir_form valign=top>&nbsp;</td>
          <td valign=top>&nbsp;</td>
        </tr>
        <tr>
          <td class=dir_form valign=top>
          <?=L_G_TRANSCLICKAPPROVAL;?>
          </td>
          <td valign=top>      
          <select name=clickapproval>
            <option value="<?=APPROVE_AUTOMATIC?>" <? print ($_POST['clickapproval'] == APPROVE_AUTOMATIC ? 'selected' : '');?>><?=L_G_AUTOMATIC?></option>
            <option value="<?=APPROVE_MANUAL?>" <? print ($_POST['clickapproval'] == APPROVE_MANUAL ? 'selected' : '');?>><?=L_G_MANUAL?></option>
          </select>
          </td>
          <td class=dir_form valign=top>
          <?=L_G_TRANSSALEAPPROVAL;?>
          </td>
          <td valign=top>
          <select name=saleapproval>
            <option value="<?=APPROVE_AUTOMATIC?>" <? print ($_POST['saleapproval'] == APPROVE_AUTOMATIC ? 'selected' : '');?>><?=L_G_AUTOMATIC?></option>
            <option value="<?=APPROVE_MANUAL?>" <? print ($_POST['saleapproval'] == APPROVE_MANUAL ? 'selected' : '');?>><?=L_G_MANUAL?></option>
          </select>
          &nbsp;&nbsp;
          </td>
        </tr>
        <tr>
          <td class=dir_form valign=top>
          <?=L_G_AFFILIATE_APPROVAL;?>
          </td>
          <td valign=top>      
          <select name=affapproval>
            <option value="<?=APPROVE_AUTOMATIC?>" <? print ($_POST['affapproval'] == APPROVE_AUTOMATIC ? 'selected' : '');?>><?=L_G_AUTOMATIC?></option>
            <option value="<?=APPROVE_MANUAL?>" <? print ($_POST['affapproval'] == APPROVE_MANUAL ? 'selected' : '');?>><?=L_G_MANUAL?></option>
          </select>
          </td>
          <td class=dir_form valign=top>
          <?=L_G_STATUS;?>
          </td>
          <td valign=top>
          <select name=status>
            <option value="<?=AFF_CAMP_PUBLIC?>" <? print ($_POST['status'] == AFF_CAMP_PUBLIC ? 'selected' : '');?>><?=L_G_PUBLIC?></option>
            <option value="<?=AFF_CAMP_PRIVATE?>" <? print ($_POST['status'] == AFF_CAMP_PRIVATE ? 'selected' : '');?>><?=L_G_PRIVATE?></option>
          </select>
          &nbsp;&nbsp;
          </td>
        </tr>
        <tr>
          <td class=dir_form valign=top>
          <?=L_G_OVERWRITE_COOKIE;?>
          </td>
          <td valign=top>
          <input type=checkbox name=overwrite_cookie value='1' <?=($_POST['overwrite_cookie'] == true ? ' checked' : '')?>>
          </td>
          <? if($GLOBALS['Auth']->getSetting('Aff_join_campaign') == '1') { ?>
            <td class=dir_form valign=top>
            <?=L_G_SIGNUP_BONUS;?>
            </td>
            <td valign=top>      
            <input type=text name=signup_bonus value="<?=$_POST['signup_bonus']?>">
            &nbsp;&nbsp;
            </td>
          <? } else { ?>
            <td class=dir_form valign=top colspan=2>&nbsp;</td>
          <? } ?>
        </tr>
        
<? if($this->a_Auth->getSetting('Aff_forcecommfromproductid') == 'yes') { ?>         
        <tr>
          <td class=dir_form valign=top colspan=4>
          <?=L_G_ALLOWEDPRODUCTS?>&nbsp;<? showPopupHelp(G_HLPALLOWEDPRODUCTS); ?>
          </td>
        </tr>
        <tr>
          <td class=dir_form valign=top colspan=4>
          <textarea name=products cols=86 rows=2><?=$_POST['products']?></textarea>
          </td>
        </tr>
<? } ?>

        </table>
