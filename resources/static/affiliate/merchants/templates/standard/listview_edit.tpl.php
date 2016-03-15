
    <center>
    <form action=index_popup.php method=post>
    <table class=listing border=0 cellspacing=0 cellpadding=2>
    <? QUnit_Templates::printFilter(2, $_POST['header']); ?>
    <tr>
      <td class=dir_form>
      <b><?=L_G_VIEWNAME;?></b>
      </td>
      <td><input type=text name=name size=44 value="<?=$_POST['name']?>">*</td>
    </tr>
    <tr>
      <td colspan=2><br></td>
    </tr>
    
<?
    for($i=1; $i<=count($this->a_available_columns); $i++)
    {
?>
    <tr>
      <td class=dir_form>
      <b><?=L_G_VIEWCOLUMN.' '.$i?></b>
      </td>
      <td>
        <select name="column<?=$i?>">
            <option value='_'>--------------------------------------</option>
            
<?      foreach($this->a_available_columns as $colid => $column)
        { 
            print '<option value="'.$colid.'" '.($_POST['column'.$i] == $colid ? 'selected' : '').'>'.$column[0].'</option>';
        }
?>
        </select>
      </td>
    </tr>
<?
        $count++;
    } 
?>

    <tr>
      <td class=dir_form colspan=2 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_ListViews'>
      <input type=hidden name=action value=<?=$_POST['action']?>>
      <input type=hidden name=vid value="<?=$_REQUEST['vid']?>">
      <input type=hidden name=postaction value=<?=$_POST['postaction']?>>
      <input type=hidden name=listViewName value="<?=$_REQUEST['listViewName']?>">
      <input type=hidden name=columns_count value=<?=count($this->a_available_columns)?>>
      <input type=hidden name=listview_name value=<?=$this->a_listview_name?>>
      <input type=submit class=formbutton value='<?=L_G_SUBMIT; ?>'>
      </td>
    </tr>
    <tr>
      <td colspan=2>&nbsp;</td>
    </tr>
    </table>
    </form>
    </center>
