
    <form name=FilterForm action=index.php method=post>
    <table class=listing border=0 cellspacing=0>
    <? QUnit_Templates::printFilter(8); ?> 
    <tr>
      <td>&nbsp;<?=L_G_NAME?>&nbsp;</td>
      <td><input type=text name=filter_name size=20 value="<?=$_REQUEST['filter_name']?>">&nbsp;</td>
    </tr>
    <tr>
      <td align=left nowrap>&nbsp;<?=L_G_ROWSPERPAGE?>&nbsp;</td>
      <td>
      <select name=up_numrows onchange="javascript:FilterForm.list_page.value=0;">
        <option value=10 <? print ($_REQUEST['up_numrows']==10 ? "selected" : ""); ?>>10</option>
        <option value=20 <? print ($_REQUEST['up_numrows']==20 ? "selected" : ""); ?>>20</option>
        <option value=30 <? print ($_REQUEST['up_numrows']==30 ? "selected" : ""); ?>>30</option>
        <option value=50 <? print ($_REQUEST['up_numrows']==50 ? "selected" : ""); ?>>50</option>
        <option value=100 <? print ($_REQUEST['up_numrows']==100 ? "selected" : ""); ?>>100</option>
        <option value=200 <? print ($_REQUEST['up_numrows']==200 ? "selected" : ""); ?>>200</option>
        <option value=500 <? print ($_REQUEST['up_numrows']==500 ? "selected" : ""); ?>>500</option>
        <option value=1000000 <? print ($_REQUEST['up_numrows']==1000000 ? "selected" : ""); ?>><?=L_G_ALL?></option>
      </select>&nbsp;
      </td>
    </tr>
    <tr>
      <td colspan=8 align=center>&nbsp;<input class=formbutton type=submit value='<?=L_G_SEARCH?>'></td>
    </tr>
    <tr>
      <td colspan=8>&nbsp;</td>
    </tr>
    </table>
    <input type=hidden name=filtered value=1>
    <input type=hidden id=list_page name=list_page value='<?=$_REQUEST['list_page']?>'>

    <br>
