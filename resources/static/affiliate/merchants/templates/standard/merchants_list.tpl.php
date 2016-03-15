<form name=FilterForm id=FilterForm action=index.php method=get>

    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='<?=$_REQUEST['md']?>'>
    <input type=hidden name=type value='all'>
    <input type=hidden id=list_page name=list_page value='<?=$_REQUEST['list_page']?>'>
    <input type=hidden id=action name=action value=''>    
    <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">
    <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">
</form>
<script>
function createMerchant()
{
	var wnd = window.open("index_popup.php?md=<?=$_REQUEST['md']?>&action=create", "CreateMerchant","scrollbars=1, top=100, left=100, width=500, height=500, status=0");
    wnd.focus(); 
}

function updateMerchant(ID)
{
	var wnd = window.open("index_popup.php?md=<?=$_REQUEST['md']?>&action=update&merchantId="+ID,"CreateMerchant","scrollbars=1, top=100, left=100, width=500, height=500, status=0");
    wnd.focus(); 	
}

function deleteMerchant(ID)
{
	if(confirm("Are you sure you want to delete this merchant?"))
   		document.location.href = "index.php?md=<?=$_REQUEST['md']?>&action=delete&merchantId="+ID;
}

</script>
<?php
if($this->a_exportFileName != '') { ?>

    <table class=listing border=0 cellspacing=0 cellpadding=1>
        <tr>
            <td align=center><?=L_G_DOWNLOADCSV?> <br><a class=mainlink
                href="<?=$this->a_Auth->getSetting('Aff_export_url').$this->a_exportFileName?>"><b><?=$this->a_exportFileName?></b></a></td>
        </tr>
    </table>
    <br><br>
<? } ?>

    <table class=listingClosed border=0 cellspacing=0 cellpadding=0>
    <? QUnit_Templates::printFilter(10, 'Merchants'); ?>
    <tr>
        <td class=actionheader align=left>
            <b><a class=mainlink href="javascript:createMerchant();">Add Merchant</a></b>
        </td>
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
                <? $this->a_this->printAvailableViews('Affiliate_Merchants_Views_AffiliateManager'); ?>
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


<input type=hidden name=md value='<?=$_REQUEST['md']?>'>
<input type=hidden name=commited value='yes'>
</form>
