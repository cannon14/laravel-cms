<?
    $data = $this->a_data;
?>

<table border=0>
<tr>
    <td align=left>
  
<? if($this->a_Auth->getSetting(Aff_display_news) == '1' && ($this->a_news_count>0 || ($this->a_news_count == 0 && $this->a_old_news_exist))) { ?>
    <table class=listing width="450" cellspacing=0 cellpadding=3 border=0>
    <? QUnit_Templates::printFilter(2, L_G_NEWS); ?>
    <tr>
        <td class=actionheader align=right colspan=2>&nbsp;
        <a class=mainlink href="index.php?md=Affiliate_Affiliates_Views_MainPage&view_old=1"><?=L_G_VIEW_OLD?></a>
        </td>
    </tr>
    <? while($news=$this->a_list_data->getNextRecord()) { ?>
    <tr>
      <td align=left width="5%" nowrap>&nbsp;<?=$news['dateinserted']?>&nbsp;</td>
      <td align=left nowrap>&nbsp;<? if($_REQUEST['nid'] != $news['messagetouserid']) { ?><a href='index.php?md=Affiliate_Affiliates_Views_News&nid=<?=$news['messagetouserid']?>&view_old=<?=$_REQUEST['view_old']?>'><? } ?><b><?=$news['title']?></b><? if($_REQUEST['nid'] != $news['messagetouserid']) { ?></a><? } ?>&nbsp;</td>
    </tr>
    <? } ?>
    <? if($this->a_news_count < 1) { ?>
    <tr>
      <td align=left colspan=2 nowrap>&nbsp;<?=L_G_NO_AVAILABLE_NEWS?>&nbsp;</td>
    </tr>
    <? } ?>
    </table>

    <br>
<? } ?>
    <table class=listing width="450" border=0 cellspacing=0 cellpadding=2>
    <? QUnit_Templates::printFilter(7, L_G_STATISTICS); ?>
    <tr><td colspan=7></td></tr>
        <tr>
          <td class=theader align=right>&nbsp;<?=L_G_TOTALCLICKS?></td><td width=5></td>
            <td align=right>
            <?=$data['clicks_approved']?>
            </td>
          <td width=30></td>
          <td class=theader align=right nowrap><?=L_G_TOTALIMPRESSIONS?> <?=L_G_IMPUNIQUEALL?></td><td width=5></td>
            <td align=right nowrap>
            <?=$data['unique_impressions']?> / <?=$data['impressions']?>
            </td>
        </tr>
        
<? if($this->a_Auth->getSetting('Aff_support_sale_commissions') == 1 || $this->a_Auth->getSetting('Aff_support_lead_commissions') == 1) { ?>
    <tr>
<?      if($this->a_Auth->getSetting('Aff_support_sale_commissions') == 1)
        { 
?>        
          <td class=theader align=right>&nbsp;<?=L_G_TOTALAPPROVEDSALES?></td><td width=5></td>
          <td align=right nowrap>
            <?=$data['sales_approved']+$data['st_sales_approved']?>
          </td>
          <td width=30></td>
<?      } 
        
        if($this->a_Auth->getSetting('Aff_support_lead_commissions') == 1)
        { 
?>
          <td class=theader align=right>&nbsp;<?=L_G_TOTALAPPROVEDLEADS?></td><td width=5></td>
          <td align=right nowrap>
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
          <td align=right nowrap>
            <?=$data['sales_waitingapproval']+$data['st_sales_waitingapproval']?>
          </td>
          <td width=30></td>
<?      } 
        
        if($this->a_Auth->getSetting('Aff_support_lead_commissions') == 1)
        { 
?>
          <td class=theader align=right>&nbsp;<?=L_G_TOTALWAITINGLEADS?></td><td width=5></td>
          <td align=right nowrap>
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
          <td align=right nowrap>
            <?=$data['sales_declined']+$data['st_sales_declined']?>
          </td>
          <td width=30></td>
<?      } 
        
        if($this->a_Auth->getSetting('Aff_support_lead_commissions') == 1)
        { 
?>
          <td class=theader align=right>&nbsp;<?=L_G_TOTALDECLINEDLEADS?></td><td width=5></td>
          <td align=right nowrap>
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
    
    <? QUnit_Templates::printFilter2(7, L_G_TODAYREVENUES); ?>

        <tr>
          <td class=theader align=right><?=L_G_TOTALAPPROVEDCOMM?></td><td width=5></td>
          <td align=right nowrap>
            <?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_approved']+$data['st_revenue_approved'])?>
          </td>
          <td colspan=5>&nbsp;</td>
        </tr>
        <tr>
          <td class=theader align=right><?=L_G_TOTALWAITINGCOMM?></td><td width=5></td>
          <td align=right nowrap>
            <?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_waitingapproval']+$data['st_revenue_waitingapproval'])?>
          </td>
          <td colspan=5>&nbsp;</td>
        </tr>
        <tr>
          <td class=theader align=right><?=L_G_TOTALDECLINEDCOMM?></td><td width=5></td>
          <td align=right nowrap>
            <?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_declined']+$data['st_revenue_declined'])?>
          </td>
          <td colspan=5>&nbsp;</td>
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
