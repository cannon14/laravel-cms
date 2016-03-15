<?
    $data = $this->a_data;
?>

<table border=0>
<tr>
    <td align=left>
  
<? if($this->a_Auth->getSetting(Aff_display_news) == '1' && ($this->a_news_count>0 || ($this->a_news_count == 0 && $this->a_old_news_exist))) { ?>
    <table class=listing width="450" cellspacing=0 cellpadding=3 border=0>
    <? QUnit_Templates::printFilter(2, L_G_NEWS); ?>
    <tr>
        <td class=actionheader align=right colspan=2>&nbsp;
        <a class=mainlink href="index.php?md=Affiliate_Affiliates_Views_MainPage&view_old=1"><?=L_G_VIEW_OLD?></a>
        </td>
    </tr>
    <? while($news=$this->a_list_data->getNextRecord()) { ?>
    <tr>
      <td align=left width="5%" nowrap>&nbsp;<?=$news['dateinserted']?>&nbsp;</td>
      <td align=left nowrap>&nbsp;<? if($_REQUEST['nid'] != $news['messagetouserid']) { ?><a href='index.php?md=Affiliate_Affiliates_Views_News&nid=<?=$news['messagetouserid']?>&view_old=<?=$_REQUEST['view_old']?>'><? } ?><b><?=$news['title']?></b><? if($_REQUEST['nid'] != $news['messagetouserid']) { ?></a><? } ?>&nbsp;</td>
    </tr>
    <? } ?>
    <? if($this->a_news_count < 1) { ?>
    <tr>
      <td align=left colspan=2 nowrap>&nbsp;<?=L_G_NO_AVAILABLE_NEWS?>&nbsp;</td>
    </tr>
    <? } ?>
    </table>

    <br>
<? } ?>

<?
include('./library/mainpage.html') 
?>
</td>
</tr>
</table>