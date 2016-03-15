<table class=listing border=0 cellspacing=0 cellpadding=0>
<?
  $cdata=$this->a_data;
  $pdata=$this->b_data;
  //$totalpaid = $data['revenue']+$data['st_revenue']+$data['bonus'];
  //$epc = $totalpaid/$data['clicks'];
?>
 
<? QUnit_Templates::printFilter2(1, L_G_PENDINGCOMM); ?>
<tr>
    <td valign=top align=left>
  <table width=100% cellspacing=0 cellpadding=3 border=0>
  	<tr>
      <td class=listresultnocenter>&nbsp;</td>
      <td class=listresultright><?=$_SESSION['pmonthLabel']?><BR>Previous Month</td>
      <td class=listresultright><?=$_SESSION['cmonthLabel']?><BR>Current Month</td>
    </tr>
    <tr>
    <tr>
      <td class=listresultnocenter><?=L_G_TOTALCLICKS?></td>
      <td class=listresultright><?=$pdata['clicks']?></td>
      <td class=listresultright><?=$cdata['clicks']?></td>
    </tr>
    <tr>
      <td class=listresultnocenter>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=L_G_BASECOMM?> </td>
      <td class=listresultright><?=Affiliate_Merchants_Bl_Settings::showCurrency($pdata['revenue_sales_approved'])?></td>
      <td class=listresultright><?=Affiliate_Merchants_Bl_Settings::showCurrency($cdata['revenue_sales_approved'])?></td>
    </tr>
    <?
    $count = count($pdata['bonusLevels']);
    
    for ($i = 0; $i < $count; $i++)
	{
		$pbl = $pdata['bonusLevels'][$i];
		$cbl = $cdata['bonusLevels'][$i];
		?>
		<tr>
      		<td class=listresultnocenter>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; w/ <?=$pbl[0]?> </td>
      		<td class=listresultright><?=Affiliate_Merchants_Bl_Settings::showCurrency($pbl[1])?></td>
      		<td class=listresultright><?=Affiliate_Merchants_Bl_Settings::showCurrency($cbl[1])?></td>
    	</tr>
		<?
	}
    ?>
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
      <td class=listresultright><b>$<?=number_format($pdata['epc'],2)?></b></td>
      <td class=listresultright><b>$<?=number_format($cdata['epc'],2)?></b></td>
    </tr>
    <?
    $ecount = count($pdata['epcLevels']);
    
    for ($e = 0; $e < $ecount; $e++) 
	{
		$pel = $pdata['epcLevels'][$e];
		$cel = $cdata['epcLevels'][$e];
		?>
		<tr>
      		<td class=listresultnocenter>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; w/ <?=$pel[0]?> </td>
      		<td class=listresultright>$<?=number_format($pel[1],2)?></td>
      		<td class=listresultright>$<?=number_format($cel[1],2)?></td>
    	</tr>
		<?
	}
    ?>
  </table>
  <BR>
  </td>
</tr>  
</table>
<? $varString = "sales"; 
	if (0){ ?>
<?=$varString?>=<?=$cdata[$varString]?><BR>
<?=$varString?>_waiting=<?=$cdata[$varString.'_waiting']?><BR>
<?=$varString?>_approved=<?=$cdata[$varString.'_approved']?><BR>
<?=$varString?>_declined=<?=$cdata[$varString.'_declined']?><BR>
revenue_<?=$varString?>=<?=$cdata['revenue_'.$varString]?><BR>
revenue_<?=$varString?>_paid=<?=$cdata['revenue_'.$varString.'_paid']?><BR>
revenue_<?=$varString?>_waiting=<?=$cdata['revenue_'.$varString.'_waiting']?><BR>
revenue_<?=$varString?>_approved=<?=$cdata['revenue_'.$varString.'_approved']?><BR>
revenue_<?=$varString?>_declined=<?=$cdata['revenue_'.$varString.'_declined']?><BR>
<?	} ?>
<br>
