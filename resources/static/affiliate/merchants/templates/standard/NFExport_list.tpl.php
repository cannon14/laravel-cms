  
   <table class=listingClosed border=0 cellspacing=0 cellpadding=0>
    <? QUnit_Templates::printFilter(10, "NETFINITI Exports"); ?>
    <tr>
    </tr>    
    <tr>
        <td class=listPaging align=right>
        <table width="100%" border="0" height="18" cellspacing="0" cellpadding="0">
        <tr>
            <td class=listheaderNoLineLeft width="30%" nowrap>
                &nbsp;
                <a class=simplelink href="javascript:showListOptions();"><?=L_G_LISTOPTIONS?></a>
                &nbsp;
            </td>
            <td width="40">&nbsp;</td>
            <td align="left" class=listheaderNoLineLeft nowrap>
                <? QUnit_Templates::printPaging($this->a_list_page, $this->a_list_pages, $this->a_allcount) ?>
            </td>
        </tr>
        </table>
        
        <div id="view_av_options" style="display:none;">
        <table width="100%"  height="18" cellspacing="0" cellpadding="0">
        <tr>
            <td class=listViewLine>
                <? $this->a_this->printAvailableViews('Affiliate_Merchants_Views_ExpensesManager'); ?>
            </td>
        </tr>
        </table>
        
        </div>
        </td>
    </tr>
    <tr>
        <td align=left>
        <table width="100%" cellspacing="0" cellpadding="1">
        <tr class=listheader>
            <? $this->a_this->printListHeader(); ?>
        </tr>
</form>
<form action=index.php method=post>
<?
        while($row = $this->exports->getNextRecord())
        {
?>    
        <tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
            <? $this->a_this->printListRow($row); ?>
        </tr>
<?
    }
?>
        </table>
        </td>
    </tr>
    <tr class=listheader>
        <? $this->a_this->printMassAction($row); ?>
    </tr>
    </table>

<input type=hidden name=md value='Affiliate_Merchants_Views_NFExportManager'>
<input type=hidden name=commited value='yes'>
</form>

<br><br>