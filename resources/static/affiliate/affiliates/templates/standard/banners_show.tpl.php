<?
    $paging = $this->a_Auth->getSetting('Aff_paging');
    if($paging == '' || $paging == 0) {
        $paging = 10;
    }
    
    if($this->a_numrows > $paging) {
        $pages = floor($this->a_numrows / $paging);
        if($this->a_numrows%$paging) $pages++;
    }
    
    if($_REQUEST['list_page'] == '' || $_REQUEST['list_page'] > $pages) {
        $_REQUEST['list_page'] = 1;
    }
?>
<script>
function showCode(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Affiliates_Views_AffBannerManager&action=showcode&bid="+ID,"ShowBannerCodeBanner","scrollbars=0, top=100, left=100, width=450, height=270, status=0")
    wnd.focus(); 
}
</script>
<? 
    include('banner_show_filter.tpl.php'); 
    
    if($this->a_numrows>$paging)
    {
      echo "<br><center>";
      echo '<b>'.L_G_PAGES.':&nbsp;<b>';
      // draw page numbers

      for($i=1; $i<=$pages; $i++)
      {
        if($i != $_REQUEST['list_page'])
          echo "&nbsp;<a class=\"paging\" href=\"index.php?md=Affiliate_Affiliates_Views_AffBannerManager&list_page=$i&campaign=$campaignid\">$i</a>&nbsp;";
        else
          echo "&nbsp;<b>$i</b>&nbsp;";
      }
      echo "</center><br>";
    }
?>    
   <table border=0>
   <tr>
   <td align=center>
<?
    if($this->a_numrows == 0)
        //print L_G_NOBANNERSINCAMPAIGN;

    $count = 0;
    $params = $this->a_params;    
    while($data=$this->a_list_data2->getNextRecord())
    {
      $count++;
      if(!(($_REQUEST['list_page']-1)*$paging<$count && $count<=($_REQUEST['list_page']*$paging)))
      {
        continue;
      }

      $clickUrlOnly = Affiliate_Affiliates_Views_AffBannerManager::getClickUrl($data['destinationurl'], $params);

      // get statistics data (impressions and clicks)
      $stat_data = $this->a_bannerStats[$data['bannerid']];
?>      
<script>
function makeDynamicLink(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Affiliates_Views_AffBannerManager&action=dynamiclink&bid="+ID,"EditBanner","scrollbars=1, top=100, left=100, width=600, height=320, status=0")
    wnd.focus(); 
}
</script>

    <br>
    <table class=listing width=750 border=0 cellspacing=0 cellpadding=3>
      <tr>
        <td class=tableheader align=left>
        <table width="100%" border=0 cellspacing=0 cellpadding=0>
        <tr>
        	<td align=left>
         		<?=L_G_PROGRAMNAME?>: <b><?=$data['campaignname']?></b>
        	</td>
            <td align=right>
<? if($this->a_Auth->getSetting('Aff_link_style') != LINK_STYLE_NEW) { ?>
            <a class=mainlink href="javascript:makeDynamicLink('<?=$data['bannerid']?>');"><?=L_G_DYNAMICLINK?></a>
<? } ?>              
            <? if($this->a_action_permission['edit']) { ?>
                <a class=mainlink href="javascript:editBanner('<?=$data['bannerid']?>');"><?=L_G_EDIT?></a>
            <? } ?>
            <? if($this->a_action_permission['delete']) { ?>
                &nbsp;&nbsp;
                <a class=mainlink href="javascript:deleteBanner('<?=$data['bannerid']?>');"><?=L_G_DELETE?></a>
            <? } ?>
            </td>
        </tr>
        </table>
        </td>
      </tr>
      <? if($this->a_Auth->getSetting('Aff_display_banner_stats_all') == '1') { ?>
      <tr>
        <td align=left class=listheaderNoLineLeft>
        <?=L_G_STATISTICSFORALLAFFS?>
        <table class=smalltext width=100%  border=0 cellspacing=0 cellpadding=0>
        <tr>
          <td class=smalltext width=10% align=left><?=L_G_INPERIOD?>&nbsp;</td>
          <td class=smalltext width=30% align=left><?=L_G_IMPRESSIONS?> <?=L_G_IMPUNIQUEALL?>:&nbsp;&nbsp;<?=$stat_data['unique_impressions_period']?> / <?=$stat_data['impressions_period']?></td>
          <td class=smalltext width=30% align=center><?=L_G_CLICKS?>:&nbsp;&nbsp;<?=$stat_data['clicks_period']?></td>
          <td class=smalltext width=30% align=right><?=L_G_RATIO?>:&nbsp;&nbsp;<?=$stat_data['ratio_period']?></td>
        </tr>
        <tr>
          <td class=smalltext width=10% align=left><?=L_G_ALL?>&nbsp;</td>
          <td class=smalltext width=30% align=left><?=L_G_IMPRESSIONS?> <?=L_G_IMPUNIQUEALL?>:&nbsp;&nbsp;<?=$stat_data['unique_impressions_all']?> / <?=$stat_data['impressions_all']?></td>
          <td class=smalltext width=30% align=center><?=L_G_CLICKS?>:&nbsp;&nbsp;<?=$stat_data['clicks_all']?></td>
          <td class=smalltext width=30% align=right><?=L_G_RATIO?>:&nbsp;&nbsp;<?=$stat_data['ratio_all']?></td>
        </tr>
        </table>
        </td>
      </tr>
      <? } ?>
<!--
      <tr>
        <td align=left class=listheaderNoLineLeft>
        <?=L_G_MYSTATISTICS?>
        <table class=smalltext width=100%  border=0 cellspacing=0 cellpadding=0>
        <tr>
          <td class=smalltext width=10% align=left><?=L_G_INPERIOD?>&nbsp;</td>
          <td class=smalltext width=30% align=left><?=L_G_IMPRESSIONS?> <?=L_G_IMPUNIQUEALL?>:&nbsp;&nbsp;<?=$stat_data[$this->a_Auth->getUserID()]['unique_impressions_period']?> / <?=$stat_data[$this->a_Auth->getUserID()]['impressions_period']?></td>
          <td class=smalltext width=30% align=center><?=L_G_CLICKS?>:&nbsp;&nbsp;<?=$stat_data[$this->a_Auth->getUserID()]['clicks_period']?></td>
          <td class=smalltext width=30% align=right><?=L_G_RATIO?>:&nbsp;&nbsp;<?=$stat_data[$this->a_Auth->getUserID()]['ratio_period']?></td>
        </tr>
        <tr>
          <td class=smalltext width=10% align=left><?=L_G_ALL?>&nbsp;</td>
          <td class=smalltext width=30% align=left><?=L_G_IMPRESSIONS?> <?=L_G_IMPUNIQUEALL?>:&nbsp;&nbsp;<?=$stat_data[$this->a_Auth->getUserID()]['unique_impressions_all']?> / <?=$stat_data[$this->a_Auth->getUserID()]['impressions_all']?></td>
          <td class=smalltext width=30% align=center><?=L_G_CLICKS?>:&nbsp;&nbsp;<?=$stat_data[$this->a_Auth->getUserID()]['clicks_all']?></td>
          <td class=smalltext width=30% align=right><?=L_G_RATIO?>:&nbsp;&nbsp;<?=$stat_data[$this->a_Auth->getUserID()]['ratio_all']?></td>
        </tr>
        </table>
        </td>
      </tr>
// -->
      <tr><td class=settingsLine><img border=0 src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>blank.png"></td></tr> 
      <tr>
        <td class=listresultNoLin align=center colspan=2>
<?
        $bannerCode = Affiliate_Affiliates_Views_AffBannerManager::showBannerAndGetCode($clickUrlOnly, $data['bannertype'], $data['bannerid'], $data['sourceurl'], $data['description'], $params);
?>
        </td>   
      </tr>
      <tr><td class=settingsLine><img border=0 src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>blank.png"></td></tr> 
      <tr>
        <td align=left colspan=2><?=L_G_CODETOINSERT?><br>
          <center>
          <textarea cols=130 rows=4><?=$bannerCode?></textarea>
          </center>
        </td>
      </tr>  
      <tr>
        <td align=left class=disabled>
            <?=L_G_DESTURL?>: <b><?=$data['destinationurl']?></b>
        </td>
        
      </tr>
    </table>
    <br>
<?
    }
?>
   </td>
   </tr>
   </table>
   </form>
   </center> 
<?
    if($this->a_numrows>$paging)
    {
      $pages = floor($this->a_numrows/$paging);
      if($this->a_numrows%$paging) $pages++;

      echo "<br><center>";
      echo '<b>'.L_G_PAGES.':&nbsp;<b>';
      // draw page numbers

      for($i=1; $i<=$pages; $i++)
      {
        if($i != $_REQUEST['list_page'])
          echo "&nbsp;<a class=\"paging\" href=\"index.php?md=Affiliate_Affiliates_Views_AffBannerManager&list_page=$i&campaign=$campaignid\">$i</a>&nbsp;";
        else
          echo "&nbsp;<b>$i</b>&nbsp;";
      }
      echo "</center>";
    }
?>
