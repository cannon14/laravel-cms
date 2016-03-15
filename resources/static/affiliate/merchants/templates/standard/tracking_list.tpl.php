<?
include('tracking_filter.tpl.php');
$capKeyword = ucfirst($_REQUEST['mode']);
$singCapKeyword = substr(ucfirst($capKeyword), 0, strlen($capKeyword)-1);
?>

    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Merchants_Views_TrackingManager'>
    <input type=hidden name=type value='all'>
    <input type=hidden id=list_page name=list_page value='<?=$_REQUEST['list_page']?>'>
    <input type=hidden id=action name=action value=''>    
    <input type=hidden id=mode name=mode value='<?=$_REQUEST['mode']?>'>    
    <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">
    <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">
</form>

    <table class=listingClosed border=0 cellspacing=0 cellpadding=0>
    <? QUnit_Templates::printFilter(1,$capKeyword." ".L_G_RT_TRACKING); ?>
    <tr>
        <td class=actionheader align=left>
            <b><a class=mainlink href="javascript:add<?=$singCapKeyword?>();">Add <?=$singCapKeyword?></a></b>
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
                <? if ($_REQUEST['mode'] == "merchants") $this->a_this->printTrackingAvailableViews('Affiliate_Merchants_Views_TrackingManager'); ?>
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
        <? $this->a_this->printMassAction($row); ?>
    </tr>
    </table>

<br>
<br>