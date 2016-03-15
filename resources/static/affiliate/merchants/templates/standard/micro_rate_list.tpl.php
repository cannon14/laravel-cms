<?
include('micro_rate_filter.tpl.php');
?>
	<br>
    <table class=listingClosed border=0 cellspacing=0 cellpadding=0>    
    <tr>
        <td colspan="3" class=actionheader align=left>
            <b><a class=mainlink href="javascript:addRate();">Add New Rate <?=$singCapKeyword?></a></b>
            &nbsp;&nbsp;
        </td>
    </tr>
    <tr>
        <td class=listPaging align=right>
        <table width="100%" border="0" height="18" cellspacing="0" cellpadding="0">
        <tr>
            <td class=listheaderNoLineLeft width="30%" nowrap>
                &nbsp;
                <?php if ($_REQUEST['mode'] == "merchants") { ?>
                <a class=simplelink href="javascript:showListOptions();"><?=L_G_LISTOPTIONS?></a>
				<?php } ?>
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
                <? $this->a_this->printAvailableViews('Affiliate_Merchants_Views_RateMicroManager'); ?>
            </td>
        </tr>
        </table>
        
        </div>
        </td>
    </tr>
    <tr>
        <td align=left>
        <table width="100%" cellspacing="0" cellpadding="1" style="border-top: 1px solid #000D51;">
        <tr class=listheader>
            <? $this->a_this->printListHeader(); ?>
        </tr>
</form>
<form name='list' action=index.php method=post>
<?
        while($row = $this->a_list_data->getNextRecord())
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
        <? $this->a_this->printMassAction(); ?>
    </tr>
    </table>


<input type=hidden name=md value='Affiliate_Merchants_Views_RateMicroManager'>
<input type=hidden name=rid value=<?=$_REQUEST['rid']?>>
<input type=hidden name=mode value='<?=$_REQUEST['mode']?>'>
<input type=hidden name=commited value='yes'>
</form>
<br>
<br>