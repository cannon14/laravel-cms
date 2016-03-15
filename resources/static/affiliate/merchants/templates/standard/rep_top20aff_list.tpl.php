
&nbsp;<b><?=L_G_IMPRESSIONS.' '.L_G_SORTEDBYUNIQUE?>
<table border=0 cellspacing=0 cellpadding=0>
<tr>
  <td height=150 valign=bottom>
  <?=$this->a_impstop_graph?>
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
  <?=$this->a_cpmtop_graph?>
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
  <?=$this->a_clickstop_graph?>
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
  <?=$this->a_salestop_graph?>
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
  <?=$this->a_leadstop_graph?>
  </td>
</tr>
<tr>
  <td align=center><b><?=$this->a_period?></b></td>
</tr>
</table>
<? } ?>

<hr>
&nbsp;<b><?=L_G_REVENUES.' '.L_G_IN.' '.$this->a_Auth->getSetting('Aff_system_currency')?>
<table border=0 cellspacing=0 cellpadding=0>
<tr>
  <td height=150 valign=bottom>
  <?=$this->a_revenuetop_graph?>
  </td>
</tr>
<tr>
  <td align=center><b><?=$this->a_period?></b></td>
</tr>
</table>


</td>
</tr>
</table>
