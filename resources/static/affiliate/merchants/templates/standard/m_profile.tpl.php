<?
    $data = $this->a_data;
?>
<script>
function updateContactInfo()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_MerchantProfile&action=editcontactinfo","EditContactInfo","scrollbars=1, top=100, left=100, width=450, height=500, status=0")
    wnd.focus(); 
}
/*
function updateAccountInfo()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_MerchantProfile&action=editaccountinfo","EditAccountInfo","scrollbars=0, top=100, left=100, width=350, height=220, status=0")
      wnd.focus(); 
}
*/
function approveTransactions()
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_TransactionManager&tmdl_status=allpending";
}

function approveURLs()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_ApprovalManager&type=urls","EditCustomization","scrollbars=1, top=100, left=100, width=550, height=260, status=0")
    wnd.focus(); 
}
</script>
<table border=0>
<tr>
    <td align=left>
    
    <table class=listing border=0 cellspacing=0 cellpadding=2>
    <? QUnit_Templates::printFilter(8, L_G_STATISTICS); ?>
    <tr>
        <td class=theader align=right>&nbsp;<?=L_G_AFFWAITINGAPPROVAL?></td><td width=5></td>
        <td align=right>
            <?=($this->a_aff_waiting > 0 ? '<a class=textlink href="index.php?md=Affiliate_Merchants_Views_AffiliateManager&fromprofile=1&umprof_status='.AFFSTATUS_NOTAPPROVED.'">'.$this->a_aff_waiting.'</a>' : 0)?>
        </td>
        <td width=30></td>
        <td class=theader align=right>&nbsp;<?=L_G_TRANSAPPLICATIONS?></td><td width=5></td>
        <td align=right>
            <?=($this->a_trans_waiting > 0 ? '<a class=textlink href="javascript:approveTransactions();">'.$this->a_trans_waiting.'</a>' : 0)?>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr><td colspan=7></td></tr>
        <tr>
          <td class=theader align=right>&nbsp;<?=L_G_TOTALCLICKS?></td><td width=5></td>
            <td align=right>
            <?=$data['clicks_approved']?>
            </td>
          <td width=30></td>
          <td class=theader align=right><?=L_G_TOTALIMPRESSIONS?> <?=L_G_IMPUNIQUEALL?></td><td width=5></td>
            <td align=right>
            <?=$data['unique_impressions']?> / <?=$data['impressions']?>
            </td>
        <td>&nbsp;</td>
        </tr>
        
<? if($this->a_Auth->getSetting('Aff_support_sale_commissions') == 1 || $this->a_Auth->getSetting('Aff_support_lead_commissions') == 1) { ?>
    <tr>
<?      if($this->a_Auth->getSetting('Aff_support_sale_commissions') == 1)
        { 
?>        
          <td class=theader align=right>&nbsp;<?=L_G_TOTALAPPROVEDSALES?></td><td width=5></td>
          <td align=right>
            <?=$data['sales_approved']+$data['st_sales_approved']?>
          </td>
          <td width=30></td>
<?      } 
        
        if($this->a_Auth->getSetting('Aff_support_lead_commissions') == 1)
        { 
?>
          <td class=theader align=right>&nbsp;<?=L_G_TOTALAPPROVEDLEADS?></td><td width=5></td>
          <td align=right>
            <?=$data['leads_approved']+$data['st_leads_approved']?>
          </td>
<?
        }

        if($this->a_Auth->getSetting('Aff_support_sale_commissions') != 1 || $this->a_Auth->getSetting('Aff_support_lead_commissions') != 1) 
        {
?>
          <td colspan=4>&nbsp;</td>

<?      } ?>
    </tr>
    <tr>
<?      if($this->a_Auth->getSetting('Aff_support_sale_commissions') == 1)
        { 
?>        
          <td class=theader align=right>&nbsp;<?=L_G_TOTALWAITINGSALES?></td><td width=5></td>
          <td align=right>
            <?=$data['sales_waitingapproval']+$data['st_sales_waitingapproval']?>
          </td>
          <td width=30></td>
<?      } 
        
        if($this->a_Auth->getSetting('Aff_support_lead_commissions') == 1)
        { 
?>
          <td class=theader align=right>&nbsp;<?=L_G_TOTALWAITINGLEADS?></td><td width=5></td>
          <td align=right>
            <?=$data['leads_waitingapproval']+$data['st_leads_waitingapproval']?>
          </td>
<?
        }

        if($this->a_Auth->getSetting('Aff_support_sale_commissions') != 1 || $this->a_Auth->getSetting('Aff_support_lead_commissions') != 1) 
        {
?>
          <td colspan=4>&nbsp;</td>

<?      } ?>
    </tr>
    <tr>
<?      if($this->a_Auth->getSetting('Aff_support_sale_commissions') == 1)
        { 
?>        
          <td class=theader align=right>&nbsp;<?=L_G_TOTALDECLINEDSALES?></td><td width=5></td>
          <td align=right>
            <?=$data['sales_declined']+$data['st_sales_declined']?>
          </td>
          <td width=30></td>
<?      } 
        
        if($this->a_Auth->getSetting('Aff_support_lead_commissions') == 1)
        { 
?>
          <td class=theader align=right>&nbsp;<?=L_G_TOTALDECLINEDLEADS?></td><td width=5></td>
          <td align=right>
            <?=$data['leads_declined']+$data['st_leads_declined']?>
          </td>
<?
        }

        if($this->a_Auth->getSetting('Aff_support_sale_commissions') != 1 || $this->a_Auth->getSetting('Aff_support_lead_commissions') != 1) 
        {
?>
          <td colspan=4>&nbsp;</td>

<?      } ?>
    </tr>
<? } ?>

    <tr><td>&nbsp;</td></tr>
    
    <? QUnit_Templates::printFilter2(8, L_G_TODAYREVENUES); ?>

        <tr>
          <td class=theader align=right><?=L_G_TOTALAPPROVEDCOMM?></td><td width=5></td>
          <td align=right>
            <?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_approved']+$data['st_revenue_approved'])?>
            &nbsp;
          </td>
          <td colspan=5>&nbsp;</td>
        </tr>
        <tr>
          <td class=theader align=right><?=L_G_TOTALWAITINGCOMM?></td><td width=5></td>
          <td align=right>
            <?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_waitingapproval']+$data['st_revenue_waitingapproval'])?>
            &nbsp;
          </td>
          <td colspan=5>&nbsp;</td>
        </tr>
        <tr>
          <td class=theader align=right><?=L_G_TOTALDECLINEDCOMM?></td><td width=5></td>
          <td align=right>
            <?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_declined']+$data['st_revenue_declined'])?>
            &nbsp;
          </td>
          <td colspan=5>&nbsp;</td>
        </tr>
    </table>
    <br>
    

    <table class=listing border=0 cellspacing=0 cellpadding=2>
    <? QUnit_Templates::printFilter(2, L_G_AFFSTATS); ?>
    <tr>
        <td align=center colspan=2><b><?=L_G_ALLAFFILIATES?> &nbsp;[</b><a class=textlink href='index.php?md=Affiliate_Merchants_Views_AffiliateManager&fromprofile=1'><?=$this->a_aff_all?></a><b>]</b></td>
    </tr>
    <tr>
        <td align=left colspan=2>
        <?=$this->a_affstats_graph?>
        <br>
        </td>
    </tr>
    </table>
    <br>
    
    <table class=listing border=0 cellspacing=0 cellpadding=2>
    <? QUnit_Templates::printFilter(2, L_G_TRENDS); ?>
    <tr>
        <td align=left colspan=2>
        &nbsp;<b><?=L_G_IMPRESSIONS?>
        <table border=0 cellspacing=0 cellpadding=0>
        <tr>
            <td height=150 valign=bottom>
            <?=$this->a_impstrend_graph?>
            </td>
        </tr>
        <tr>
            <td align=center><b><?=$this->a_period?></b></td>
        </tr>
        </table>
        <br>
        </td>
    </tr>
    <tr><td class=settingsLine colspan=2><img border=0 src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>blank.png"></td></tr> 
    <tr>
        <td align=left colspan=2>
        
<? if($this->a_cpmSupported) { ?>  
        &nbsp;<b><?=L_G_MILIONIMPRESSIONS.' '.L_G_CPMCOMMISSIONTRANSACTIONS?>
        <table border=0 cellspacing=0 cellpadding=0>
        <tr>
            <td height=150 valign=bottom>
            <?=$this->a_cpmtrend_graph?>
            </td>
        </tr>
        <tr>
            <td align=center><b><?=$this->a_period?></b></td>
        </tr>
        </table>
        <br>
        </td>
    </tr>
    <tr><td class=settingsLine colspan=2><img border=0 src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>blank.png"></td></tr> 
    <tr>
        <td align=left colspan=2>
<? } ?>
        
        &nbsp;<b><?=L_G_CLICKS?>
        <table border=0 cellspacing=0 cellpadding=0>
        <tr>
            <td height=150 valign=bottom>
            <?=$this->a_clickstrend_graph?>
            </td>
        </tr>
        <tr>
            <td align=center><b><?=$this->a_period?></b></td>
        </tr>
        </table>
        <br>
        </td>
    </tr>
    <tr><td class=settingsLine colspan=2><img border=0 src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>blank.png"></td></tr> 
    <tr>
        <td align=left colspan=2>
        
<? if($this->a_saleSupported) { ?>  
        &nbsp;<b><?=L_G_SALES?>
        <table border=0 cellspacing=0 cellpadding=0>
        <tr>
            <td height=150 valign=bottom>
            <?=$this->a_salestrend_graph?>
            </td>
        </tr>
        <tr>
            <td align=center><b><?=$this->a_period?></b></td>
        </tr>
        </table>
        <br>
        </td>
    </tr>
    <tr><td class=settingsLine colspan=2><img border=0 src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>blank.png"></td></tr> 
    <tr>
        <td align=left colspan=2>
<? } ?>
        
<? if($this->a_leadSupported) { ?>
        &nbsp;<b><?=L_G_LEADS?>
        <table border=0 cellspacing=0 cellpadding=0>
        <tr>
            <td height=150 valign=bottom>
            <?=$this->a_leadstrend_graph?>
            </td>
        </tr>
        <tr>
            <td align=center><b><?=$this->a_period?></b></td>
        </tr>
        </table>
        <br>
        </td>
    </tr>
    <tr><td class=settingsLine colspan=2><img border=0 src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>blank.png"></td></tr> 
    <tr>
        <td align=left colspan=2>
<? } ?>
        
        &nbsp;<b><?=L_G_REVENUES.' '.L_G_IN.' '.$this->a_Auth->getSetting('Aff_system_currency')?>
        <table border=0 cellspacing=0 cellpadding=0>
        <tr>
            <td height=150 valign=bottom>
            <?=$this->a_revenuetrend_graph?>
            </td>
        </tr>
        <tr>
            <td align=center><b><?=$this->a_period?></b></td>
        </tr>
        </table>

        </td>
    </tr>
    </table>
    <br>
    </td>
</tr>
</table>
