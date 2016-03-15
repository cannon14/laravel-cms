
<table border=0 width=100% cellspacing=0 cellpadding=1>
<tr>
  <td width=20% align=left valign=top>&nbsp;<b><?=$this->a_impData['xtitle']?></b>&nbsp;</td>
  <td width=20% align=right valign=top nowrap>&nbsp;<b><?=L_G_IMPRESSIONS?><br><?=L_G_IMPUNIQUEALL?></b>&nbsp;</td>
<? if($this->a_cpmSupported) { ?>  
    <td width=20% align=right valign=top nowrap>&nbsp;<b><?=L_G_MILIONIMPRESSIONS?></b>&nbsp;</td>
<? } ?>
  <td width=20% align=right valign=top nowrap>&nbsp;<b><?=L_G_CLICKS?></b>&nbsp;</td>
<? if($this->a_saleSupported) { ?>  
    <td width=20% align=right valign=top nowrap>&nbsp;<b><?=L_G_SALES?></b>&nbsp;</td>
<? } ?>
<? if($this->a_leadSupported) { ?>  
    <td width=20% align=right valign=top nowrap>&nbsp;<b><?=L_G_LEADS?></b>&nbsp;</td>
<? } ?>
  <td width=20% align=right valign=top nowrap>&nbsp;<b><?=L_G_REVENUE?></b>&nbsp;</td>
  <td width=20% align=right valign=top nowrap>&nbsp;<b><?=L_G_IMPRESSIONS.'<br>/ '.L_G_CLICKS?></b>&nbsp;</td>

<? if($this->a_clickSupported) { ?>  
    <td width=20% align=right valign=top nowrap>&nbsp;<b><?=L_G_REVENUE.'<br>/ '.L_G_CLICKS?></b>&nbsp;</td>
<? } ?>

<? if($this->a_saleSupported) { ?>  
    <td width=20% align=right valign=top nowrap>&nbsp;<b><?=L_G_IMPRESSIONS.'<br>/ '.L_G_SALES?></b>&nbsp;</td>
    <td width=20% align=right valign=top nowrap>&nbsp;<b><?=L_G_CLICKS.'<br>/ '.L_G_SALES?></b>&nbsp;</td>
<? } ?>

<? if($this->a_leadSupported) { ?>
    <td width=20% align=right valign=top nowrap>&nbsp;<b><?=L_G_IMPRESSIONS.'<br>/ '.L_G_LEADS?></b>&nbsp;</td>
    <td width=20% align=right valign=top nowrap>&nbsp;<b><?=L_G_CLICKS.'<br>/ '.L_G_LEADS?></b>&nbsp;</td>
<? } ?>
  <td>&nbsp;&nbsp;</td>
</tr>
<? for($i=$this->a_periodMin; $i<=$this->a_periodMax; $i++) { ?>
<tr>
  <td align=left>&nbsp;<?=($this->a_reportType == 'monthly' ? constant($GLOBALS['wd_monthname'][$i]) : $i)?>&nbsp;&nbsp;</td>
  <td align=right nowrap><?=$this->a_trendData['imps'][$i]['unique']?> / <?=$this->a_trendData['imps'][$i]['all']?>&nbsp;&nbsp;</td>
<? if($this->a_cpmSupported) { ?>  
    <td align=right nowrap><?=$this->a_trendData['cpm'][$i]?>&nbsp;&nbsp;</td>
<? } ?>
  <td align=right nowrap><?=$this->a_trendData['clicks'][$i]?>&nbsp;&nbsp;</td>
<? if($this->a_saleSupported) { ?>  
    <td align=right nowrap><?=$this->a_trendData['sales'][$i]?>&nbsp;&nbsp;</td>
<? } ?>
<? if($this->a_leadSupported) { ?>  
    <td align=right nowrap><?=$this->a_trendData['leads'][$i]?>&nbsp;&nbsp;</td>
<? } ?>
  <td align=right nowrap><?=Affiliate_Merchants_Bl_Settings::showCurrency($this->a_trendData['revenue'][$i])?>&nbsp;&nbsp;</td>
  <td align=right nowrap><?=($this->a_trendData['imps'][$i]['unique'] <= 0 ? '0' : _r($this->a_trendData['clicks'][$i]/$this->a_trendData['imps'][$i]['unique']))?> %&nbsp;&nbsp;</td>

<? if($this->a_clickSupported) { ?>  
    <td width=20% align=right valign=top nowrap><?=Affiliate_Merchants_Bl_Settings::showCurrency(($this->a_trendData['revenue'][$i] <= 0 || $this->a_trendData['clicks'][$i] <= 0? '0' : _r($this->a_trendData['revenue'][$i]/$this->a_trendData['clicks'][$i])))?>&nbsp;&nbsp;</b>&nbsp;</td>
<? } ?>
  
<? if($this->a_saleSupported) { ?>  
  <td align=right nowrap><?=($this->a_trendData['sales'][$i] <= 0 || $this->a_trendData['imps'][$i]['unique'] <= 0 ? '0' : _r($this->a_trendData['sales'][$i]/$this->a_trendData['imps'][$i]['unique']))?> %&nbsp;&nbsp;</td>
  <td align=right nowrap><?=($this->a_trendData['clicks'][$i] <= 0 || $this->a_trendData['clicks'][$i] <= 0 ? '0' : _r($this->a_trendData['sales'][$i]/$this->a_trendData['clicks'][$i]))?> %&nbsp;&nbsp;</td>
<? } ?>

<? if($this->a_leadSupported) { ?>  
  <td align=right nowrap><?=($this->a_trendData['leads'][$i] <= 0 || $this->a_trendData['imps'][$i]['unique'] <= 0 ? '0' : _r($this->a_trendData['leads'][$i]/$this->a_trendData['imps'][$i]['unique']))?> %&nbsp;&nbsp;</td>
  <td align=right nowrap><?=($this->a_trendData['clicks'][$i] <= 0 || $this->a_trendData['clicks'][$i] <= 0 ? '0' : _r($this->a_trendData['leads'][$i]/$this->a_trendData['clicks'][$i]))?> %&nbsp;&nbsp;</td>
<? } ?>
  <td>&nbsp;&nbsp;</td>
</tr>
<? } ?>
</table>
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

<? if($this->a_saleSupported) { ?>  
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
<? } ?>

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

<hr>
&nbsp;<b><?=L_G_REVENUE.' '.L_G_IN.' '.$this->a_Auth->getSetting('Aff_system_currency')?>
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
