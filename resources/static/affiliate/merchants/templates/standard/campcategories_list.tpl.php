
<script>
function Delete(ID)
{
  if(confirm("<?=L_G_CONFIRMDELETECAT?>") && '<?=$_REQUEST['cid']?>' != '')
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_CampCategoriesManager&catid="+ID+"&cid=<?=$_REQUEST['cid']?>&action=delete";
}

function addAffCategory()
{
    var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_CampCategoriesManager&action=add&cid=<?=$_REQUEST['cid']?>","AddAffCategory","scrollbars=1, top=100, left=100, width=500, height=480, status=0");
    wnd.focus();
}

function editAffCategory(ID)
{
    var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_CampCategoriesManager&action=edit&catid="+ID+"&cid=<?=$_REQUEST['cid']?>","AddAffCategory","scrollbars=1, top=100, left=100, width=500, height=480, status=0");
    wnd.focus();
}
</script>
    <table border=0 cellspacing=0 cellpadding=5>
    <tr>
      <td>
      <?=L_G_HLPSPECIALCOMMCATEGORIES?>
      <br><br>
    <table class=listing border=0 cellspacing=0 cellpadding=1>
   
    <tr>
      <td class=actionheader align=left colspan=6 height=25 valign=top><b><a class=mainlink href="javascript:addAffCategory();"><?=L_G_ADDCATEGORY?></a></b></td>
    </tr>
  
    <tr class=listheader>
     <td class=listheader><?=L_G_CATEGORY?></td>
     <td class=listheader><?=L_G_CLICKCOMMISSION?></td>
     <td class=listheader><?=L_G_SALECOMMISSION?></td>
     <td class=listheader><?=L_G_NOAFFILIATES?></td>
     <td class=listheader width=10%><?=L_G_ACTIONS?></td>
    </tr>    
<?
    while($data=$this->a_list_data->getNextRecord())
    {
        if($data['basiccategory'])
            continue;
?>      
    <tr class=listresult class=row onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td class=listresult nowrap><?=$data['name']?></td>
      <td class=listresult nowrap>
<?      if($data['clickcommission'] != '-')
        {
            print Affiliate_Merchants_Bl_Settings::showCurrency($data['clickcommission']);
        }
        else
            print '-';
?>            
      </td>
      <td class=listresult nowrap>
<?      if($data['salecommission'] != '-')
        {
            print ($data['salecommtype'] != '$' ? $data['salecommission'].' '.$data['salecommtype'] : Affiliate_Merchants_Bl_Settings::showCurrency($data['salecommission']));
        }
        else
            print '-';
?>            
      
      </td>
      <td class=listresult nowrap>
      <?=$data['affiliatescount'];?>
      </td>
      <td class=listresult>
        <select name=action_select OnChange="performAction(this);">
        <option value="-">------------------------</option>
        <option value="javascript:editAffCategory('<?=$data['campcategoryid']?>')"><?=L_G_EDIT?></option>
        <? if($data['basiccategory'] != true) { ?>
        <option value="javascript:Delete('<?=$data['campcategoryid']?>');"><?=L_G_DELETE?></a>
        <? } ?>
        </select>
      </td>
    </tr>    
<?
    }
?>    
   </table>
   
   </td>
   </tr>
   </table>
   
