<?
include('keywords_filter.tpl.php');
$capKeyword = ucfirst($_REQUEST['mode']);
$singCapKeyword = substr(ucfirst($capKeyword), 0, strlen($capKeyword)-1);
?>

    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Merchants_Views_KeywordsManager'>
    <input type=hidden name=type value='all'>
    <input type=hidden id=list_page name=list_page value='<?=$_REQUEST['list_page']?>'>
    <input type=hidden id=action name=action value=''>    
    <input type=hidden id=mode name=mode value='<?=$_REQUEST['mode']?>'>    
    <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">
    <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">
</form>

<script type="text/javascript" language="javascript">
function validateMassAction(frm)
{
	if (frm.massaction.value == "delete")
	{
		if(confirm("Delete keywords?")) {
			return true;
		}
		return false;
	}
	return true;
}
</script>

<?if($this->a_exportFileName != '') { ?>

    <table class=listing border=0 cellspacing=0 cellpadding=1>
        <tr>
            <td align=center><?=L_G_DOWNLOADCSV?> <br><a class=mainlink href="<?=$this->a_Auth->getSetting('Aff_export_url').$this->a_exportFileName?>"><b><?=$this->a_exportFileName?></b></a></td>
        </tr>
    </table>
    <br><br>
<? } ?>

<form action=index.php method=post onsubmit="javascript:return validateMassAction(this);">

    <table class=listingClosed border=0 cellspacing=0 cellpadding=0>
    <!--<tr>
        <td class=actionheader align=left>
          <? //if($this->a_action_permission['view']) { ?>
            <b><a class=mainlink href="javascript:FilterForm.action.value='exportcsv'; FilterForm.submit();"><?=L_G_EXPORTTOCSV?></a></b>
          <? //} ?>
        </td>
    </tr>-->
    
    <? QUnit_Templates::printFilter(1,L_G_RT_KEYWORDS); ?>
    
    <tr>
        <td class=listPaging align=right>
        <table width="100%" border="0" height="18" cellspacing="0" cellpadding="0">
        <tr>
            <td class=listheaderNoLineLeft width="30%">&nbsp;</td>
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
                <? if ($_REQUEST['mode'] == "merchants") $this->a_this->printTrackingAvailableViews('Affiliate_Merchants_Views_KeywordsManager'); ?>
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

	<input type=hidden name=md value='Affiliate_Merchants_Views_KeywordsManager'>
	<input type=hidden name=commited value='yes'>
	</form>

<br>
<br>