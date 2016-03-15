<?
  $data=$this->a_data;
  //$totalpaid = $data['revenue']+$data['st_revenue']+$data['bonus'];
  //$epc = $totalpaid/$data['clicks'];
?>
  </td>
</tr>
<? QUnit_Templates::printFilter2(1, L_G_COMMISSIONS); ?>
<tr>
    <td valign=top align=left>
  <table width=100% cellspacing=0 cellpadding=3 border=0>
  	<tr>
      <td class=listresultnocenter><?=L_G_TOTALCLICKS?></td>
      <td class=listresultright><?=$data['clicks']?></td>
    </tr>
    <tr>
      <td class=listresultnocenter>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=L_G_BASECOMM?> </td>
      <td class=listresultright><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_sales_paid'])?></td>
    </tr>
    <tr>
      <td class=listresultnocenter>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=L_G_TOTALPAIDBONUS?></td>
      <td class=listresultright><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_bonuses_paid'])?></td>
    </tr>
    <tr>
      <td class=listresultnocenter><?=L_G_TOTALPAIDCOMM?></td>
      <td class=listresultright><?=Affiliate_Merchants_Bl_Settings::showCurrency($data['total_paid'])?></td>
    </tr>
  </table>
  <br>  
  </td>
</tr>  
<? QUnit_Templates::printFilter2(1, L_G_EPC); ?>
<tr>
    <td valign=top align=left>

  <table width=100% cellspacing=0 cellpadding=3 border=0>
    <tr>
      <td class=listresultnocenter><?=L_G_CALCEPC?></td>
      <td class=listresultright><b>$<?=number_format($data['epc'],2)?></b></td>
    </tr>
  </table>

  <br>
  <br>
  </td>
</tr>  
</table>
<? $varString = "bonuses"; 
	if (0){ ?>
<?=$varString?>=<?=$data[$varString]?><BR>
<?=$varString?>_waiting=<?=$data[$varString.'_waiting']?><BR>
<?=$varString?>_approved=<?=$data[$varString.'_approved']?><BR>
<?=$varString?>_declined=<?=$data[$varString.'_declined']?><BR>
revenue_<?=$varString?>=<?=$data['revenue_'.$varString]?><BR>
revenue_<?=$varString?>_paid=<?=$data['revenue_'.$varString.'_paid']?><BR>
revenue_<?=$varString?>_waiting=<?=$data['revenue_'.$varString.'_waiting']?><BR>
revenue_<?=$varString?>_approved=<?=$data['revenue_'.$varString.'_approved']?><BR>
revenue_<?=$varString?>_declined=<?=$data['revenue_'.$varString.'_declined']?><BR>
<?	} ?>
<br>
