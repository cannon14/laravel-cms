<script type="text/javascript">
<!--
function toggleBox(szDivID, iState) // 1 visible, 0 hidden
{
    if(document.layers)	   //NN4+
    {
       //document.layers[szDivID].visibility = iState ? "show" : "hide";
       document.layers[szDivID].visibility = iState ? "inline" : "none";
    }
    else if(document.getElementById)	  //gecko(NN6) + IE 5+
    {
        var obj = document.getElementById(szDivID);
        //obj.style.visibility = iState ? "visible" : "hidden";
        obj.style.display = iState ? "inline" : "none";
    }
    else if(document.all)	// IE 4
    {
        //document.all[szDivID].style.visibility = iState ? "visible" : "hidden";
        document.all[szDivID].style.display = iState ? "inline" : "none";
    
    }
}

function checkBannerStats(obj){
	if (obj.checked){
		toggleBox('bannerstats',1); 
	}
	else { toggleBox('bannerstats',0);
	}
}
// -->
</script>
  <form action=index.php method=post>
  <table class=listing border=0 cellspacing=0 cellpadding=3>
  <? QUnit_Templates::printFilter(2, L_G_FILTER); ?>
   <tr>
     <td width="20%" nowrap><?=L_G_PCNAME?>&nbsp;</td>
     <td>
        <select name=campaign>
          <option value='_'><?=L_G_ALL?></option>
<?      while($data=$this->a_list_data2->getNextRecord()) { ?>
          <option value='<?=$data['campaignid']?>' <?=($_REQUEST['campaign'] == $data['campaignid'] ? 'selected' : '')?>><?=$data['name']?></option>
<?      } ?>          
        </select>
      </td>
   </tr>
   <tr>
      <td align=left nowrap>
        <?=L_G_SHOWSTATS?>
      </td>
   	  <td align=left>
       <input type="checkbox" name="showBannerStats" onClick="checkBannerStats(this)" <?=($_REQUEST['showBannerStats'] ? 'checked' : '')?>>
      </td>
    </tr>
    <tr>
      <td align=left nowrap colspan=2>
      <div class="hiddenSection" id="bannerstats" name="bannerstats">
      <table>
    <tr>
      <td align=left nowrap>
        <?=L_G_STATSFORAFFILIATE?>
      </td>
      <td align=left>
        <select name=bs_affiliate>
          <option value='_'><?=L_G_ALL?></option>
<?      while($data=$this->a_aff_list->getNextRecord()) { ?>
          <option value='<?=$data['userid']?>' <?=($_REQUEST['bs_affiliate'] == $data['userid'] ? 'selected' : '')?>><?=$data['name'].' '.$data['surname']?></option>
<?      } ?>          
      </select>&nbsp;&nbsp;
      </td>
    </tr>
<!--    
   <tr>
     <td align=left><?=L_G_SORTBY?></td>
     <td align=left>
        <select name="bs_sortby">
            <option value='campaign'><?=L_G_CAMPAIGN?></option>
            <option value='uniqimps_period'><?=L_G_IMPRESSIONSUNIQUE.' '.L_G_PERIOD?></option>
            <option value='clicks_period'><?=L_G_CLICKS.' '.L_G_PERIOD?></option>
            <option value='ratio_period'><?=L_G_RATIO.' '.L_G_PERIOD?></option>
            <option value='uniqimps_all'><?=L_G_IMPRESSIONSUNIQUE.' '.L_G_ALL2?></option>
            <option value='clicks_all'><?=L_G_CLICKS.' '.L_G_ALL2?></option>
            <option value='ratio_all'><?=L_G_RATIO.' '.L_G_ALL2?></option>
        </select>
     </td>
   </tr>
-->
   <tr>
      <td align=left colspan=2>
        <?=L_G_BANNERSTATSPERIOD?>
      </td>
    </tr>
    
    <tr>
      <td align=left colspan=2>
        <input type=radio name=bs_reporttype value=today <?=($_REQUEST['bs_reporttype']=='today' ? "checked" : "")?>>
        &nbsp;
        <?=L_G_TODAY?>
      </td>
    </tr>
    <tr>
      <td align=left colspan=2>
        <input type=radio name=bs_reporttype value=thisweek <?=($_REQUEST['bs_reporttype']=='thisweek' ? "checked" : "")?>>
        &nbsp;
        <?=L_G_THISWEEK?>
      </td>
    </tr>
    <tr>
      <td align=left colspan=2>
        <input type=radio name=bs_reporttype value=thismonth <?=($_REQUEST['bs_reporttype']=='thismonth' ? "checked" : "")?>>
        &nbsp;
        <?=L_G_THISMONTH?>
      </td>
    </tr>
    <tr>
      <td align=left colspan=2 nowrap>
        <input type=radio name=bs_reporttype value=timerange <?=($_REQUEST['bs_reporttype']=='timerange' ? "checked" : "")?>>
        &nbsp;
        <?=L_G_TIMERANGE?>
        &nbsp;&nbsp;
        &nbsp;
        <?=L_G_FROM?>
        &nbsp;<?=L_G_DAY?>&nbsp;
        <select name=bs_day1>
<?      for($i=1; $i<=31; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['bs_day1'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
        &nbsp;<?=L_G_MONTH?>&nbsp;
        <select name=bs_month1>
<?      for($i=1; $i<=12; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['bs_month1'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
        &nbsp;<?=L_G_YEAR?>&nbsp;
        <select name=bs_year1>
<?      for($i=2003; $i<=$this->a_curyear; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['bs_year1'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>

        &nbsp;<?=L_G_TO?>&nbsp;

        &nbsp;<?=L_G_DAY?>&nbsp;
        <select name=bs_day2>
<?      for($i=1; $i<=31; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['bs_day2'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
        &nbsp;<?=L_G_MONTH?>&nbsp;
        <select name=bs_month2>
<?      for($i=1; $i<=12; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['bs_month2'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
        &nbsp;<?=L_G_YEAR?>&nbsp;
        <select name=bs_year2>
<?      for($i=2003; $i<=$this->a_curyear; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['bs_year2'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
        
      </td>
      
   </tr>
   </table>
   </div>
   </td>
   </tr>
   <tr>
     <td colspan=2 align=left>
      <input type=hidden name=filtered value=1>
      <input type=hidden name=list_page value="<?=$_REQUEST['list_page']?>">
      <input type=hidden name=md value='Affiliate_Merchants_Views_BannerManager'>
      <input type=submit class=formbutton value="<?=L_G_FILTER?>">
     </td>
   </tr>  
   </table>
    </form>
 <script>
 <?=($_REQUEST['showBannerStats'] ? 'toggleBox(\'bannerstats\',1);' : '')?>
 
 </script>
