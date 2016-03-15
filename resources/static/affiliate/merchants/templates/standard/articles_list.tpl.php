<? 
include('articles_filter.tpl.php');
if($_POST['runQuery'] == null){
if($this->a_exportFileName != '') { ?>

    <table class=listing border=0 cellspacing=0 cellpadding=1>
        <tr>
            <td align=center><?=L_G_DOWNLOADCSV?> <br>
            
            | <a class=mainlink
                href="<?=$this->a_Auth->getSetting('Aff_export_url').$this->a_exportFileName?>"><b><?=$this->a_exportFileName?></b></a></td>
        </tr>
    </table>
    <br><br>
<? } ?>


   <table class=listingClosed border=0 cellspacing=0 cellpadding=0>
    <? QUnit_Templates::printFilter(10, "View Articles"); ?>
    <tr>
        <td class=actionheader align=left>
          <? if($this->a_action_permission['view']) { ?>
            <b><a class=mainlink href="javascript:createSite()">Create New Article </a> | <a class=mainlink href="javascript:FilterForm.action.value='exportcsv'; FilterForm.submit();"><?=L_G_EXPORTTOCSV?></a></b>
          <? } ?>
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
                <? $this->a_this->printAvailableViews('Affiliate_Merchants_Views_ArticleManager'); ?>
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

<input type=hidden name=tmdl_status value="<?=$_REQUEST['tmdl_status']?>">
<input type=hidden name=md value='Affiliate_Merchants_Views_ArticleManager'>
<input type=hidden name=commited value='yes'>
</form>

<br><br>
<? } ?>
