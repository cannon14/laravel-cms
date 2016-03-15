<? 	$hasTrackingFilter = '0';
	if (($_REQUEST['rt_imps'] == '1') || ($_REQUEST['rt_clicks'] == '1') || ($_REQUEST['rt_sales'] == '1') || ($_REQUEST['rt_commission'] == '1') || ($_REQUEST['rt_revenue'] == '1') || ($_REQUEST['rt_expenses'] == '1') || ($_REQUEST['rt_profits'] == '1') || ($_REQUEST['rt_cpc'] == '1') || ($_REQUEST['rt_epc'] == '1') || ($_REQUEST['rt_epu'] == '1') || ($_REQUEST['rt_epm'] == '1')) { 
		if ($_REQUEST['rt_trackerId'] != "_" || $_REQUEST['rt_keywordId'] != "_" || $_REQUEST['rt_timeslotId'] != "_" || $_REQUEST['rt_pageId'] != "_" ) {
			$hasTrackingFilter = '1';
		}
	
	?>
<table border=0 cellspacing=0 cellpadding=1>
<tr>
  <td align=left valign=top>&nbsp;<b><?=$this->a_impData['xtitle']?></b>&nbsp;</td>
<? if ('1' == $_REQUEST['rt_imps'] /**&& $hasTrackingFilter == '0' **/) { 
	?>
  <td align=right valign=top nowrap>&nbsp;<b><?=L_G_IMPRESSIONS?><br><?=L_G_IMPUNIQUEALL?></b>&nbsp;</td>
<? } ?>

<? if($this->a_cpmSupported && $hasTrackingFilter == '0') { ?>  
    <td align=right valign=top nowrap>&nbsp;<b><?=L_G_MILIONIMPRESSIONS?></b>&nbsp;</td>
<? } ?>

<? if ('1' == $_REQUEST['rt_clicks']) { ?>
  <td align=right valign=top nowrap>&nbsp;<b><?=L_G_CLICKS?></b>&nbsp;</td>
<? } ?>

<? if(('1' == $_REQUEST['rt_sales'])) { ?>  
    <td align=right valign=top nowrap>&nbsp;<b><?=L_G_SALES?></b>&nbsp;</td>
<? } ?>

<? if($this->a_leadSupported) { ?>  
    <td align=right valign=top nowrap>&nbsp;<b><?=L_G_LEADS?></b>&nbsp;</td>
<? } ?>

<? if ('1' == $_REQUEST['rt_commission']) { ?>
  <td align=right valign=top nowrap>&nbsp;<b><?=L_G_REVENUE?></b>&nbsp;</td>
<? } ?>

<? if ('1' == $_REQUEST['rt_clicks'] && $hasTrackingFilter == '0') { ?>
  <td align=right valign=top nowrap>&nbsp;<b><?=L_G_CLICKS.'<br>/ '.L_G_IMPRESSIONS?></b>&nbsp;</td>
<? } ?>

<? if(($this->a_clickSupported) && ('1' == $_REQUEST['rt_commission'])) { ?>  
    <td align=right valign=top nowrap>&nbsp;<b><?=L_G_REVENUE.'<br>/ '.L_G_CLICKS?></b>&nbsp;</td>
<? } ?>

<? if($this->a_saleSupported) { ?>  
<? 		if ('1' == $_REQUEST['rt_imps'] && $hasTrackingFilter == '0') { ?>
    <td align=right valign=top nowrap>&nbsp;<b><?=L_G_IMPRESSIONS.'<br>/ '.L_G_SALES?></b>&nbsp;</td>
<? 		} ?>

<? 		if ('1' == $_REQUEST['rt_clicks']) { ?>
    <td align=right valign=top nowrap>&nbsp;<b><?=L_G_CLICKS.'<br>/ '.L_G_SALES?></b>&nbsp;</td>
<? 		} ?>
<? } ?>

<? if($this->a_leadSupported) { ?>
    <td align=right valign=top nowrap>&nbsp;<b><?=L_G_IMPRESSIONS.'<br>/ '.L_G_LEADS?></b>&nbsp;</td>
    <td align=right valign=top nowrap>&nbsp;<b><?=L_G_CLICKS.'<br>/ '.L_G_LEADS?></b>&nbsp;</td>
<? } ?>
<? if ('1' == $_REQUEST['rt_revenue']) { ?>
    <td align=right valign=top nowrap>&nbsp;<b><?=L_G_ESTIMATED.' '.L_G_TOTALCOSTS?></b>&nbsp;</td>
    <td align=right valign=top nowrap>&nbsp;<b><?=L_G_ACTUAL.' '.L_G_TOTALCOSTS?></b>&nbsp;</td>
    <td align=right valign=top nowrap>&nbsp;<b>Avg. Sale</b>&nbsp;</td>
<? } ?>
<? if ('1' == $_REQUEST['rt_expenses']) { ?>
    <td align=right valign=top nowrap>&nbsp;<b><?=L_G_EXPENSES?></b>&nbsp;</td>
<? } ?>
<? if ('1' == $_REQUEST['rt_profits']) { ?>
    <td align=right valign=top nowrap>&nbsp;<b><?=L_G_ESTIMATED.' '.L_G_PROFITS?></b>&nbsp;</td>
    <td align=right valign=top nowrap>&nbsp;<b><?=L_G_ACTUAL.' '.L_G_PROFITS?></b>&nbsp;</td>
<? } ?>
<? if ('1' == $_REQUEST['rt_cpc']) { ?>
    <td align=right valign=top nowrap>&nbsp;<b><?=L_G_CPC?></b>&nbsp;</td>
<? } ?>
<? if ('1' == $_REQUEST['rt_epc']) { ?>
    <td align=right valign=top nowrap>&nbsp;<b><?=L_G_EPC?></b>&nbsp;</td>
<? } ?>
<? if ('1' == $_REQUEST['rt_epu']) { ?>
    <td align=right valign=top nowrap>&nbsp;<b><?=L_G_EPU?></b>&nbsp;</td>
<? } ?>
<? if ('1' == $_REQUEST['rt_epm']) { ?>
    <td align=right valign=top nowrap>&nbsp;<b><?=L_G_EPM?></b>&nbsp;</td>  
<? } ?>
  <td>&nbsp;&nbsp;</td>
</tr>
<? for($i=$this->a_periodMin; $i<=$this->a_periodMax; $i++) { ?>
<tr>
  <td align=left valign=top nowrap>&nbsp;
  <? 
    switch($this->a_reportType) {
        case "tenmins":
            echo strftime('%H:%M', mktime(0,$i*10)); 
            break;
        case "monthly":
           echo constant($GLOBALS['wd_monthname'][$i]);
           break;
        default:
            echo $i;
            break;
    }    
  ?>
  &nbsp;&nbsp;
  </td>
<? if ('1' == $_REQUEST['rt_imps'] /**&& $hasTrackingFilter == '0' **/) { ?>
  <td align=right valign=top nowrap><?=$this->a_trendData['imps'][$i]['unique']?> / <?=$this->a_trendData['imps'][$i]['all']?>&nbsp;&nbsp;</td>
<? } ?>
<? if($this->a_cpmSupported) { ?>  
    <td align=right valign=top nowrap><?=$this->a_trendData['cpm'][$i]?>&nbsp;&nbsp;</td>
<? } ?>
<? if ('1' == $_REQUEST['rt_clicks']) { ?>
  <td align=right valign=top nowrap><?=$this->a_trendData['clicks'][$i]?>&nbsp;&nbsp;</td>
<? } ?>
<? if(('1' == $_REQUEST['rt_sales'])) { ?>  
    <td align=right valign=top nowrap><?=$this->a_trendData['sales'][$i]?>&nbsp;&nbsp;</td>
<? } ?>
<? if($this->a_leadSupported) { ?>  
    <td align=right valign=top nowrap><?=$this->a_trendData['leads'][$i]?>&nbsp;&nbsp;</td>
<? } ?>
<? if ('1' == $_REQUEST['rt_commission']) { ?>
  <td align=right valign=top nowrap><?=Affiliate_Merchants_Bl_Settings::showCurrency($this->a_trendData['revenue'][$i])?>&nbsp;&nbsp;</td>
<? } ?>
<? if ('1' == $_REQUEST['rt_clicks'] && $hasTrackingFilter == '0') { ?>
  <td align=right valign=top nowrap><?=($this->a_trendData['imps'][$i]['unique'] <= 0 ? '0' : _r($this->a_trendData['clicks'][$i]/$this->a_trendData['imps'][$i]['unique']))?> %&nbsp;&nbsp;</td>
<? } ?>

<? if(($this->a_clickSupported) && ('1' == $_REQUEST['rt_commission'])) { ?>  
    <td align=right valign=top nowrap><?=Affiliate_Merchants_Bl_Settings::showCurrency(($this->a_trendData['revenue'][$i] <= 0 || $this->a_trendData['clicks'][$i] <= 0? '0' : _r($this->a_trendData['revenue'][$i]/$this->a_trendData['clicks'][$i])))?>&nbsp;&nbsp;</b>&nbsp;</td>
<? } ?>
  
<? if($this->a_saleSupported) { ?>  
<? 		if ('1' == $_REQUEST['rt_imps'] && $hasTrackingFilter == '0') { ?>
  <td align=right valign=top nowrap><?=($this->a_trendData['sales'][$i] <= 0 || $this->a_trendData['imps'][$i]['unique'] <= 0 ? '0' : _r($this->a_trendData['sales'][$i]/$this->a_trendData['imps'][$i]['unique']))?> %&nbsp;&nbsp;</td>
<? 		} ?>

<? 		if ('1' == $_REQUEST['rt_clicks']) { ?>
  <td align=right valign=top nowrap><?=($this->a_trendData['clicks'][$i] <= 0 || $this->a_trendData['clicks'][$i] <= 0 ? '0' : _r($this->a_trendData['sales'][$i]/$this->a_trendData['clicks'][$i]))?> %&nbsp;&nbsp;</td>
<? 		} ?>
<? } ?>

<? if($this->a_leadSupported) { 
	 if ('1' == $_REQUEST['rt_imps'] && $hasTrackingFilter == '0') { ?>  
  <td align=right valign=top nowrap><?=($this->a_trendData['leads'][$i] <= 0 || $this->a_trendData['imps'][$i]['unique'] <= 0 ? '0' : _r($this->a_trendData['leads'][$i]/$this->a_trendData['imps'][$i]['unique']))?> %&nbsp;&nbsp;</td>
  	<? } ?>
  <td align=right valign=top nowrap><?=($this->a_trendData['clicks'][$i] <= 0 || $this->a_trendData['clicks'][$i] <= 0 ? '0' : _r($this->a_trendData['leads'][$i]/$this->a_trendData['clicks'][$i]))?> %&nbsp;&nbsp;</td>
<? } ?>
<? if ('1' == $_REQUEST['rt_revenue']) { ?>
    <td align=right valign=top nowrap><?=$this->a_trendData['estimatedrevenue'][$i]?>&nbsp;&nbsp;</td>
    <td align=right valign=top nowrap><?=$this->a_trendData['totalcost'][$i]?>&nbsp;&nbsp;</td>
    <td align=right valign=top nowrap><?=$this->a_trendData['estimatedbysales'][$i]?>&nbsp;&nbsp;</td>
<? } ?>
<? if ('1' == $_REQUEST['rt_expenses']) { ?>
    <td align=right valign=top nowrap><?=$this->a_trendData['expense'][$i]?>&nbsp;&nbsp;</td>
<? } ?>
<? if ('1' == $_REQUEST['rt_profits']) { ?>
    <td align=right valign=top nowrap><?=($this->a_trendData['estimatedrevenue'][$i] - ($this->a_trendData['revenue'][$i] + $this->a_trendData['expense'][$i]))?>&nbsp;&nbsp;</td>
    <td align=right valign=top nowrap><?=($this->a_trendData['totalcost'][$i] - ($this->a_trendData['revenue'][$i] + $this->a_trendData['expense'][$i]))?>&nbsp;&nbsp;</td>
<? } ?>
<? if ('1' == $_REQUEST['rt_cpc']) { ?>
    <td align=right valign=top nowrap><?=($this->a_trendData['expense'][$i] <= 0 || $this->a_trendData['clicks'][$i] <= 0 ? '0' : _r($this->a_trendData['expense'][$i]/$this->a_trendData['clicks'][$i]*1))?>&nbsp;&nbsp;</td>
<? } ?>
<? if ('1' == $_REQUEST['rt_epc']) { ?>
    <td align=right valign=top nowrap><?=($this->a_trendData['estimatedrevenue'][$i] <= 0 || $this->a_trendData['clicks'][$i] <= 0 ? '0' : _r($this->a_trendData['estimatedrevenue'][$i]/$this->a_trendData['clicks'][$i]))?>&nbsp;&nbsp;</td>
<? } ?>
<? if ('1' == $_REQUEST['rt_epu'] && $hasTrackingFilter == '0') { ?>
    <td align=right valign=top nowrap><?=($this->a_trendData['estimatedrevenue'][$i] <= 0 || $this->a_trendData['imps'][$i]['unique'] <= 0 ? '0' : _r($this->a_trendData['estimatedrevenue'][$i]/$this->a_trendData['imps'][$i]['unique']))?>&nbsp;&nbsp;</td>
<? } ?>
<? if ('1' == $_REQUEST['rt_epm'] && $hasTrackingFilter == '0') { ?>
    <td align=right valign=top nowrap><?=($this->a_trendData['estimatedrevenue'][$i] <= 0 || $this->a_trendData['imps'][$i]['all'] <= 0 ? '0' : _r($this->a_trendData['estimatedrevenue'][$i]/($this->a_trendData['imps'][$i]['all']/1000)))?>&nbsp;&nbsp;</td>
<? } ?>
  <td>&nbsp;&nbsp;</td>
</tr>
<? } ?>
</table>

<? if ('1' == $_REQUEST['rt_imps']  /** && $hasTrackingFilter == '0'**/) { ?>
<hr>
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
<? } ?>

<? if($this->a_cpmSupported) { ?>  
<hr>
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
<? } ?>

<? if ('1' == $_REQUEST['rt_clicks']) { ?>
<hr>
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
<? } ?>


<? 	if ('1' == $_REQUEST['rt_sales']) { ?>
<hr>
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
<? 	} ?>


<? if($this->a_leadSupported) { ?>
<hr>
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
<? } ?>

<? if ('1' == $_REQUEST['rt_commission']) { ?>
<hr>
&nbsp;<b><?=L_G_REVENUE.' '.L_G_IN.' '.$this->a_Auth->getSetting('Aff_system_currency')?>
<table border=0 cellspacing=0 cellpadding=0>
<tr>
  <td height=150 valign=bottom>
  <?=$this->a_commissiontrend_graph?>
  </td>
</tr>
<tr>
  <td align=center><b><?=$this->a_period?></b></td>
</tr>
</table>
<? } ?>

<? if ('1' == $_REQUEST['rt_revenue']) { ?>
<hr>
&nbsp;<b><?=L_G_ESTIMATED.' '.L_G_TOTALCOSTS?>
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

<hr>
&nbsp;<b><?=L_G_ACTUAL.' '.L_G_TOTALCOSTS?>
<table border=0 cellspacing=0 cellpadding=0>
<tr>
  <td height=150 valign=bottom>
  <?=$this->a_revenuetrend_act_graph?>
  </td>
</tr>
<tr>
  <td align=center><b><?=$this->a_period?></b></td>
</tr>
</table>
<? } ?>

<? if ('1' == $_REQUEST['rt_expenses']) { ?>
<hr>
&nbsp;<b><?=L_G_EXPENSES?>
<table border=0 cellspacing=0 cellpadding=0>
<tr>
  <td height=150 valign=bottom>
  <?=$this->a_expensetrend_graph?>
  </td>
</tr>
<tr>
  <td align=center><b><?=$this->a_period?></b></td>
</tr>
</table>
<? } ?>

<? if ('1' == $_REQUEST['rt_profits']) { ?>
<hr>
&nbsp;<b><?=L_G_ESTIMATED.' '.L_G_PROFITS?>
<table border=0 cellspacing=0 cellpadding=0>
<tr>
  <td height=150 valign=bottom>
  <?=$this->a_profittrend_graph?>
  </td>
</tr>
<tr>
  <td align=center><b><?=$this->a_period?></b></td>
</tr>
</table>

<hr>
&nbsp;<b><?=L_G_ACTUAL.' '.L_G_PROFITS?>
<table border=0 cellspacing=0 cellpadding=0>
<tr>
  <td height=150 valign=bottom>
  <?=$this->a_profittrend_act_graph?>
  </td>
</tr>
<tr>
  <td align=center><b><?=$this->a_period?></b></td>
</tr>
</table>
<? } ?>

</td>
</tr>
</table>
<? } ?>
