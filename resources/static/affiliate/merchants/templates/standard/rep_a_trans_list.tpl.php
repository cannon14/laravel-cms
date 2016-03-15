
  <center>
    <br>
    <table class=listing border=0 cellspacing=0 cellpadding=1>
    <tr>
      <td class=listheader colspan=8 align=center>
<?
  echo ($this->a_list_page>0 ? "<a href='javascript:FilterForm.list_page.value=0; FilterForm.submit();'>" : "")."<img border=0 src=".$_SESSION[SESSION_PREFIX.'templateImages']."FirstPage.gif>".($this->a_list_page>0 ? "</a>" : "")."&nbsp;&nbsp;";
  echo ($this->a_list_page>0 ? "<a href='javascript:FilterForm.list_page.value=".($this->a_list_page-1)."; FilterForm.submit();'>" : "")."<img border=0 src=".$_SESSION[SESSION_PREFIX.'templateImages']."PrevPage.gif>".($this->a_list_page>0 ? "</a>" : "")."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
  echo L_G_RECORDCOUNT.": ".$this->a_allcount."&nbsp;&nbsp;&nbsp;&nbsp;".L_G_PAGE." ".($this->a_list_page+1)." ".L_G_PAGEFROM." ".$this->a_list_pages."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
  echo ($this->a_list_page<$this->a_list_pages-1 ? "<a href='javascript:FilterForm.list_page.value=".($this->a_list_page+1)."; FilterForm.submit();'>" : "")."<img border=0 src=".$_SESSION[SESSION_PREFIX.'templateImages']."NextPage.gif>".($this->a_list_page<$this->a_list_pages-1 ? "</a>" : "")."&nbsp;&nbsp;";
  echo ($this->a_list_page<$this->a_list_pages-1 ? "<a href='javascript:FilterForm.list_page.value=".($this->a_list_pages-1)."; FilterForm.submit();'>" : "")."<img border=0 src=".$_SESSION[SESSION_PREFIX.'templateImages']."LastPage.gif>".($this->a_list_page<$this->a_list_pages-1 ? "</a>" : "")."&nbsp;&nbsp;";
?>    
      </td>
    </tr>          
        <tr class=listheader>
        <td class=listheader width=1% nowrap><?=L_G_TRANSID?></td>
        <td class=listheader width=1% nowrap><?=L_G_CAMOUNT?></td>
        <td class=listheader width=1% nowrap><?=L_G_TOTALCOST?></td>
        <td class=listheader width=1% nowrap><?=L_G_ORDERID?></td>
        <td class=listheader width=1% nowrap><?=L_G_CREATED?></td>
        <td class=listheader width=1% nowrap><?=L_G_TYPE?></td>
        <td class=listheader width=1% nowrap><?=L_G_IP?></td>
        <td class=listheader width=1% nowrap><?=L_G_STATUS?></td>
        </tr>    
        
        <?
        while($data=$this->a_list_data->getNextRecord())
        {
            if($count<($this->a_list_page*$_REQUEST['numrows']) || ($count+1>($this->a_list_page+1)*$_REQUEST['numrows']))
            {
                $count++;
                continue;
            }
            else
                $count++;

        ?>    
            <tr class=listresult class=row onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
            <td class=listresult>&nbsp;<?=$data['transid']?></td>
            <td class=listresultnocenter align=right nowrap><?=Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['commission']))?>&nbsp;</td>
            <td class=listresultnocenter align=right nowrap><?=Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['totalcost']))?>&nbsp;</td>
            <td class=listresult nowrap>&nbsp;<?=$data['orderid']?>&nbsp;</td>
            <td class=listresult nowrap>&nbsp;<?=$data['datecreated']?>&nbsp;</td>
            <td class=listresult nowrap>&nbsp;
            <?      
            if($data['transkind'] > TRANSKIND_SECONDTIER)
                print L_G_SECONDTIER.' ';
            
            print $GLOBALS['Auth']->getComposedCommissionTypeString($data['transtype']);            
            ?>
            &nbsp;</td>
            <td class=listresult>&nbsp;<?=$data['ip']?>&nbsp;</td>
            <td class=listresult nowrap>&nbsp;
            <?      
            if($data['payoutstatus'] == AFFSTATUS_APPROVED)
            {
                print L_G_PAID;
                $totalPaid += $data['commission'];
            }
            else
            {
                if($data['rstatus'] == AFFSTATUS_NOTAPPROVED) print L_G_WAITINGAPPROVAL;
                else if($data['rstatus'] == AFFSTATUS_APPROVED) print L_G_APPROVED;
                else if($data['rstatus'] == AFFSTATUS_SUPPRESSED) print L_G_SUPPRESSED;
                
                if($data['rstatus'] == AFFSTATUS_SUPPRESSED || $data['payoutstatus'] == AFFSTATUS_SUPPRESSED)
                $totalDeclined += $data['commission'];
                else
                $totalWaiting += $data['commission'];
            }
            ?>
            &nbsp;</td>
            </tr>
            <?
        }
        ?>    
        <tr class=listheader>
        <td class=listheader width=1% nowrap><?=L_G_SUMMARY?></td>
        <td class=listheadernocenter width=1% align=right nowrap><?=Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($this->a_summaries['paid']+$this->a_summaries['approved']+$this->a_summaries['pending']+$this->a_summaries['reversed']))?>&nbsp;</td>
        <td class=listheadernocenter width=1% align=right nowrap><?=Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($this->a_summaries['totalcost']))?>&nbsp;</td>
        <td class=listheader width=1% colspan=5></td>
        </tr>      
        <tr class=listheader>
        <td class=listheader width=1%><?=L_G_WAITING?></td>
        <td class=listheadernocenter width=1% align=right nowrap><?=Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($this->a_summaries['pending']))?>&nbsp;</td>
        <td class=listheader width=1% colspan=6></td>
        </tr>      
        <tr class=listheader>
        <td class=listheader width=1%><?=L_G_APPROVED?></td>
        <td class=listheadernocenter width=1% align=right nowrap><?=Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($this->a_summaries['approved']))?>&nbsp;</td>
        <td class=listheader width=1% colspan=6></td>
        </tr>      
        <tr class=listheader>
        <td class=listheader width=1%><?=L_G_PAID?></td>
        <td class=listheadernocenter width=1% align=right nowrap><?=Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($this->a_summaries['paid']))?>&nbsp;</td>
        <td class=listheader width=1% colspan=6></td>
        </tr>      
        <tr class=listheader>
        <td class=listheader width=1%><?=L_G_SUPPRESSED?></td>
        <td class=listheadernocenter width=1% align=right nowrap><?=Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($this->a_summaries['reversed']))?>&nbsp;</td>
        <td class=listheader width=1% colspan=6></td>
        </tr>      
        </table>

  </center>

  </td>
</tr>
</table>
<br>

