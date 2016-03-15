<?
  $data=$this->a_data;
?>
  </td>
</tr>
<? QUnit_Templates::printFilter2(1, L_G_SUMMARY); ?>
<tr>
    <td valign=top align=left>
  <table width=100% cellspacing=0 cellpadding=3 border=0>
    <tr>
      <td>
      &nbsp;<?=L_G_TOTALCLICKS?>&nbsp; 
      <b><?=$data['clicks']?></b><br><br>

<? if($this->a_saleSupported) { ?>
      &nbsp;<?=L_G_TOTALAPPROVEDSALES?>&nbsp; 
      <b><?=$data['sales_approved']+$data['st_sales_approved']?></b><br>
      
      &nbsp;<?=L_G_TOTALWAITINGSALES?>&nbsp; 
      <b><?=$data['sales_waitingapproval']+$data['st_sales_waitingapproval']?></b><br>
      
      &nbsp;<?=L_G_TOTALDECLINEDSALES?>&nbsp; 
      <b><?=$data['sales_declined']+$data['st_sales_declined']?></b><br><br>
<? } ?>
      
<? if($this->a_leadSupported) { ?>
      &nbsp;<?=L_G_TOTALAPPROVEDLEADS?>&nbsp; 
      <b><?=$data['leads_approved']+$data['st_leads_approved']?></b><br>
      
      &nbsp;<?=L_G_TOTALWAITINGLEADS?>&nbsp; 
      <b><?=$data['leads_waitingapproval']+$data['st_leads_waitingapproval']?></b><br>
      
      &nbsp;<?=L_G_TOTALDECLINEDLEADS?>&nbsp; 
      <b><?=$data['leads_declined']+$data['st_leads_declined']?></b><br><br>
<? } ?>

      &nbsp;<?=L_G_TOTALAPPROVEDCOMM?>&nbsp; 
      <b><?=Affiliate_Merchants_Bl_Settings::showCurrency(floatval($data['revenue_approved']+$data['st_revenue_approved']))?></b><br>
      
      &nbsp;<?=L_G_TOTALWAITINGCOMM?>&nbsp; 
      <b><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_waitingapproval']+$data['st_revenue_waitingapproval'])?></b><br>
      
      &nbsp;<?=L_G_TOTALDECLINEDCOMM?>&nbsp; 
      <b><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_declined']+$data['st_revenue_declined'])?></b><br>
      
      &nbsp;<?=L_G_TOTALPAIDCOMM?>&nbsp; 
      <b><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_paid']+$data['st_revenue_paid'])?></b><br>
      </td>
    </tr>
  </table>
  <br>  
  </td>
</tr>  
<? QUnit_Templates::printFilter2(1, L_G_COUNTS); ?>
<tr>
    <td valign=top align=left>

  <table width=100% cellspacing=0 cellpadding=3 border=0>
    <tr>
      <td class=listresult width=150>&nbsp;</td>
      <td class=listresult><b><?=L_G_APPROVED?></b></td>
      <td class=listresult><b><?=L_G_WAITINGAPPROVAL?></b></td>
      <td class=listresult><b><?=L_G_SUPPRESSED?></b></td>
    </tr>
    <tr>
      <td class=listresult><b><?=L_G_IMPRESSIONS?> <?=L_G_IMPUNIQUEALL?></b></td>
      <td class=listresult><?=$data['unique_impressions']?> / <?=$data['impressions']?></td>
      <td class=listresult>-</td>
      <td class=listresult>-</td>
    </tr>
    <tr>
      <td class=listresult><b><?=L_G_CLICKS?></b></td>
      <td class=listresult><?=$data['clicks_approved']?></td>
      <td class=listresult><?=$data['clicks_waitingapproval']?></td>
      <td class=listresult><?=$data['clicks_declined']?></td>
    </tr>
<? if($this->a_saleSupported) { ?>
    <tr>
      <td class=listresult><b><?=L_G_SALES?></b></td>
      <td class=listresult><?=$data['sales_approved']?></td>
      <td class=listresult><?=$data['sales_waitingapproval']?></td>
      <td class=listresult><?=$data['sales_declined']?></td>
    </tr>
<? } ?>
<? if($this->a_leadSupported) { ?>
    <tr>
      <td class=listresult><b><?=L_G_LEADS?></b></td>
      <td class=listresult><?=$data['leads_approved']?></td>
      <td class=listresult><?=$data['leads_waitingapproval']?></td>
      <td class=listresult><?=$data['leads_declined']?></td>
    </tr>
<? } ?>
    
<? if($this->a_Auth->getSetting('Aff_support_recurring_commissions') == 1) { ?>    
    <tr>
      <td class=listresult><b><?=L_G_RECURRING?></b></td>
      <td class=listresult><?=$data['recurring_approved']?></td>
      <td class=listresult><?=$data['recurring_waitingapproval']?></td>
      <td class=listresult><?=$data['recurring_declined']?></td>
    </tr>
<? } ?>       
<? if($this->a_Auth->getSetting('Aff_maxcommissionlevels') > 1) { ?> 
    <tr>
     <td colspan=4 class=listresult align=center><b><?=L_G_SECONDTIER?></b></td>
    </tr>
    <tr>
      <td class=listresult width=150>&nbsp;</td>
      <td class=listresult><b><?=L_G_APPROVED?></b></td>
      <td class=listresult><b><?=L_G_WAITINGAPPROVAL?></b></td>
      <td class=listresult><b><?=L_G_SUPPRESSED?></td>
    </tr>
    <tr>
      <td class=listresult><b><?=L_G_CLICKS?></b></td>
      <td class=listresult><?=$data['st_clicks_approved']?></td>
      <td class=listresult><?=$data['st_clicks_waitingapproval']?></td>
      <td class=listresult><?=$data['st_clicks_declined']?></td>
    </tr>
<? if($this->a_saleSupported) { ?>
    <tr>
      <td class=listresult><b><?=L_G_SALES?></b></td>
      <td class=listresult><?=$data['st_sales_approved']?></td>
      <td class=listresult><?=$data['st_sales_waitingapproval']?></td>
      <td class=listresult><?=$data['st_sales_declined']?></td>
    </tr>
<? } ?>
<? if($this->a_leadSupported) { ?>
    <tr>
      <td class=listresult><b><?=L_G_LEADS?></b></td>
      <td class=listresult><?=$data['st_leads_approved']?></td>
      <td class=listresult><?=$data['st_leads_waitingapproval']?></td>
      <td class=listresult><?=$data['st_leads_declined']?></td>
    </tr>
<? } ?>    
<? } // end if max comission levels?>
  </table>

  <br>
  <br>
  </td>
</tr>  
<? QUnit_Templates::printFilter2(1, L_G_REVENUES); ?>
<tr>
    <td valign=top align=left>
    
  <table width=100% cellspacing=0 cellpadding=3 border=0>
    <tr>
      <td class=listresult width=100>&nbsp;</td>
      <td class=listresult width=20%><b><?=L_G_PAID?></b></td>
      <td class=listresult width=20%><b><?=L_G_APPROVED?></b></td>
      <td class=listresult width=20% nowrap><b><?=L_G_WAITINGAPPROVAL?></b></td>
      <td class=listresult width=20%><b><?=L_G_SUPPRESSED?></b></td>
    </tr>
<? if($this->a_signupSupported) { ?>
    <tr>
      <td class=listresult><b><?=L_G_SIGNUPBONUS?></b></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_signup_paid'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_signup_approved'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_signup_waitingapproval'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_signup_declined'])?></td>
    </tr>
<? } ?>

<? if($this->a_referralSupported) { ?>
    <tr>
      <td class=listresult><b><?=L_G_REFERRAL?></b></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_referral_paid'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_referral_approved'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_referral_waitingapproval'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_referral_declined'])?></td>
    </tr>
<? } ?>

<? if($this->a_cpmSupported) { ?>
    <tr>
      <td class=listresult><b><?=L_G_CPM?></b></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_cpm_paid'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_cpm_approved'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_cpm_waitingapproval'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_cpm_declined'])?></td>
    </tr>
<? } ?>

<? if($this->a_clickRevenueSupported) { ?>
    <tr>
      <td class=listresult><b><?=L_G_CLICKS?></b></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_clicks_paid'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_clicks_approved'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_clicks_waitingapproval'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_clicks_declined'])?></td>
    </tr>
<? } ?>
    
<? if($this->a_saleSupported) { ?>
    <tr>
      <td class=listresult><b><?=L_G_SALES?></b></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_sales_paid'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_sales_approved'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_sales_waitingapproval'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_sales_declined'])?></td>
    </tr>
<? } ?>

<? if($this->a_leadSupported) { ?>    
    <tr>
      <td class=listresult><b><?=L_G_LEADS?></b></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_leads_paid'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_leads_approved'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_leads_waitingapproval'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_leads_declined'])?></td>
    </tr>
<? } ?>

<? if($this->a_Auth->getSetting('Aff_support_recurring_commissions') == 1) { ?>    
    <tr>
      <td class=listresult><b><?=L_G_RECURRING?></b></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_recurring_paid'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_recurring_approved'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_recurring_waitingapproval'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_recurring_declined'])?></td>
    </tr>
<? } ?>      
    <tr>
      <td class=listresult><i><b><?=L_G_SUM?></b></i></td>
      <td class=listresult><i><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_paid'])?></i></td>
      <td class=listresult><i><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_approved'])?></i></td>
      <td class=listresult><i><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_waitingapproval'])?></i></td>
      <td class=listresult><i><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_declined'])?></i></td>
    </tr>
<? if($this->a_Auth->getSetting('Aff_maxcommissionlevels') > 1) { ?>    
    <tr>
     <td colspan=5 class=listresult align=center><b><?=L_G_SECONDTIER?></b></td>
    </tr>
    <tr>
      <td class=listresult width=100>&nbsp;</td>
      <td class=listresult width=20%><b><?=L_G_PAID?></b></td>
      <td class=listresult width=20%><b><?=L_G_APPROVED?></b></td>
      <td class=listresult width=20% nowrap><b><?=L_G_WAITINGAPPROVAL?></b></td>
      <td class=listresult width=20%><b><?=L_G_SUPPRESSED?></b></td>
    </tr>
<? if($this->a_referralSupported) { ?>
    <tr>
      <td class=listresult><b><?=L_G_REFERRAL?></b></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_referral_paid'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_referral_approved'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_referral_waitingapproval'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_referral_declined'])?></td>
    </tr>
<? } ?>

<? if($this->a_cpmSupported) { ?>
    <tr>
      <td class=listresult><b><?=L_G_CPM?></b></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_cpm_paid'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_cpm_approved'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_cpm_waitingapproval'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_cpm_declined'])?></td>
    </tr>
<? } ?>

<? if($this->a_clickRevenueSupported) { ?>    
    <tr>
      <td class=listresult><b><?=L_G_CLICKS?></b></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_clicks_paid'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_clicks_approved'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_clicks_waitingapproval'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_clicks_declined'])?></td>
    </tr>
<? } ?>

<? if($this->a_saleSupported) { ?>
    <tr>
      <td class=listresult><b><?=L_G_SALES?></b></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_sales_paid'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_sales_approved'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_sales_waitingapproval'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_sales_declined'])?></td>
    </tr>
<? } ?>
    
<? if($this->a_leadSupported) { ?>
    <tr>
      <td class=listresult><b><?=L_G_LEADS?></b></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_leads_paid'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_leads_approved'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_leads_waitingapproval'])?></td>
      <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_leads_declined'])?></td>
    </tr>
<? } ?>
    
    <tr>
      <td class=listresult><i><b><?=L_G_SUM?></b></i></td>
      <td class=listresult><i><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_paid'])?></i></td>
      <td class=listresult><i><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_approved'])?></i></td>
      <td class=listresult><i><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_waitingapproval'])?></i></td>
      <td class=listresult><i><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_declined'])?></i></td>
    </tr>
<? } ?>
  </table>

  </td>
</tr>
</table>
<br>
