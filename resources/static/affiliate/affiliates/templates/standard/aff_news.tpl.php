<? $data=$this->a_news_data; ?>

  <form action=index.php method=post>
  <table class=listing width="500" cellspacing=0 cellpadding=3 border=0>
    <? QUnit_Templates::printFilter(1, $data['title']); ?>
    <tr>
      <td align=left nowrap><i><?=$data['dateinserted']?></i></td>
    </tr>
    <tr>
      <td align=left><?=nl2br($data['rtext'])?>&nbsp;</td>
    </tr>
    <tr>
      <td align=center>
        <input type=hidden name=commited value=yes>
        <input type=hidden name=md value='Affiliate_Affiliates_Views_News'>
        <input type=hidden name=action value=<?=$_POST['action']?>>
        <input type=hidden name=nid value='<?=$_POST['nid']?>'>
        <input type=hidden name=view_old value='<?=$_REQUEST['view_old']?>'>
        <? if($data['status'] != MESSAGESTATUS_NOT_SHOW) { ?>
          <input type=submit class=formbutton value='<?=L_G_DO_NOT_SHOW_THIS_NEWS_AGAIN?>'>&nbsp;&nbsp;
        <? } ?>
        <input class=formbutton type=button value='<?=L_G_BACK?>' onClick='javascript:history.go(-1);'>
      </td>
    </tr>
  </table>
  </form>

  <br>
