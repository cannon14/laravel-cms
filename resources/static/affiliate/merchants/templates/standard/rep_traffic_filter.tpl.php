<style type="text/css">
.suggest_link {
	background-color: #FFFFFF;
	padding: 2px 6px 2px 6px;
}

.suggest_link_over {
	background-color: #3366CC;
	padding: 2px 6px 2px 6px;
	color: #FFF;
}

#search_suggest {
	position: absolute; 
	background-color: #FFFFFF; 
	text-align: left; 
	border: 1px solid #000000;            
}
</style>
<script language="JavaScript" type="text/javascript" src="/affiliate/include/javascript/keyword_search_ajax.js"></script>

<script>
function popupSQL()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_MerchantReports&action=viewSQL","Transaction","scrollbars=1, top=100, left=100, width=500, height=500, status=0");
    wnd.focus(); 
}
</script>

<table class=listing border=0 cellspacing=0 cellpadding=2>
<? QUnit_Templates::printFilter(L_G_TRAFFIC); ?>
<tr>
  <td valign=top align=left>

  <form action="index.php" method="get" onsubmit="validateKeywordFields();">
  <table border=0 cellspacing=0 cellpadding=0>
  <tr>
  <td>
  <table border=0>
  
      <tr>
      <td align=left>
        Affiliate Group
      </td>
      <td align=left>
        <select name=rt_affiliategroup>
          <option value='_'><?=L_G_ALL?></option>
<?      while($data=$this->a_list_data3->getNextRecord()) { ?>
          <option value='<?=$data['groupid']?>' <?=($_REQUEST['rt_affiliategroup'] == $data['groupid'] ? 'selected' : '')?>><?=$data['name']?></option>
<?      } ?>          
      </select>&nbsp;&nbsp;
      </td>
    </tr>
  
  
    <tr>
      <td align=left>
        <?=L_G_AFFILIATE?>
      </td>
      <td align=left>
        <select name=rt_affiliate>
          <option value='_'><?=L_G_ALL?></option>
<?      while($data=$this->a_list_data2->getNextRecord()) { ?>
          <option value='<?=$data['userid']?>' <?=($_REQUEST['rt_affiliate'] == $data['userid'] ? 'selected' : '')?>><?=$data['name'].' '.$data['surname']?></option>
<?      } ?>          
      </select>&nbsp;&nbsp;
      </td>
    </tr>
    

    
        
    <tr>
      <td align=left>
        <?=L_G_PCNAME?>
      </td>
      <td align=left>
        <select name=rt_campaign>
          <option value='_'><?=L_G_ALL?></option>
<?      while($data=$this->a_list_data1->getNextRecord()) { ?>
          <option value='<?=$data['campaignid']?>' <?=($_REQUEST['rt_campaign'] == $data['campaignid'] ? 'selected' : '')?>><?=($data['merchantname'] == null ? 'No Merchant' : $data['merchantname'])?> -- <?=$data['name']?></option>
<?      } ?>          
      </select>&nbsp;&nbsp;
      </td>
    </tr>
    
	<tr>
      <td align=left>
        Product Category Type
      </td>
      <td align=left>
        <select name=rt_campaigntype>
          <option value='_'><?=L_G_ALL?></option>
<?      while($data=$this->a_list_data4->getNextRecord()) { ?>
          <option value='<?=$data['typeid']?>' <?=($_REQUEST['rt_campaigntype'] == $data['typeid'] ? 'selected' : '')?>><?=$data['typename']?></option>
<?      } ?>          
      </select>&nbsp;&nbsp;
      </td>
    </tr>
	
    <tr>
      <td align=left>
        CID-Channel
      </td>
      <td align=left>
        <select name=rt_trackerId>
          <option value='_'><?=L_G_ALL?></option>
<?      while($data=$this->cid_list_data1->getNextRecord()) { ?>
          <option value='<?=$data['trackerId']?>' <?=($_REQUEST['rt_trackerId'] == $data['trackerId'] ? 'selected' : '')?>><?=$data['name']?> (<?=$data['trackerId']?>)</option>
<?      } ?>          
      </select>&nbsp;&nbsp;
      </td>
    </tr>
    <tr>
      <td align=left>
        DID-Keyword
      </td>
      <td align=left>
      
      	<div style="float: right;" id="result_count"></div>
		<br />
		<input type="text" id="suggestTerm" name="search" size="35" value="<?=$_REQUEST['search']?>" title="Search Criteria" onkeyup="searchSuggest();" onclick="clearSearchPopup();" onblur="validateKeywordFields();" autocomplete="off"> &nbsp;&nbsp; Keyword ID: <input type="text" size="7" name="rt_keywordId" id="rt_keywordId" value="<?=$_REQUEST['rt_keywordId']?>" readonly>
		<br />
		<div id="search_suggest"></div>
      
      </td>
    </tr>
    <tr>
      <td align=left>
        EID-TimeSlot
      </td>
      <td align=left>
        <select name=rt_timeslotId>
          <option value='_'><?=L_G_ALL?></option>
<?      while($data=$this->eid_list_data1->getNextRecord()) { ?>
          <option value='<?=$data['timeslotId']?>' <?=($_REQUEST['rt_timeslotId'] == $data['timeslotId'] ? 'selected' : '')?>><?=$data['name']?>  (<?=$data['timeslotId']?>)</option>
<?      } ?>          
      </select>&nbsp;&nbsp;
      </td>
    </tr>
    <tr>
      <td align=left>
        FID-Exit Page
      </td>
      <td align=left>
        <select name=rt_pageId>
          <option value='_'><?=L_G_ALL?></option>
<?      while($data=$this->fid_list_data1->getNextRecord()) { ?>
          <option value='<?=$data['pageId']?>' <?=($_REQUEST['rt_pageId'] == $data['pageId'] ? 'selected' : '')?>><?=$data['name']?>  (<?=$data['pageId']?>)</option>
<?      } ?>          
      </select>&nbsp;&nbsp;
      </td>
    </tr>
    <tr>
      <td align=left colspan=2>
        <?=L_G_TIMEPERIOD?>
      </td>
    </tr>
    <tr>
      <td align=left>
        <input type=radio name=rt_reporttype value=tenminsperday <?=($_REQUEST['rt_reporttype']=='tenminsperday' ? "checked" : "")?>>
        &nbsp;
        <?=L_G_TENMINSINDAY?>
      </td>
      <td align=left>
        <select name=rt_ptm_day>
<?      for($i=1; $i<=31; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['rt_ptm_day'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
        <select name=rt_ptm_month>
<?      for($i=1; $i<=12; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['rt_ptm_month'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
        <select name=rt_ptm_year>
<?      for($i=2003; $i<=$this->a_curyear; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['rt_ptm_year'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
      </td>
    </tr>    
    <tr>
      <td align=left>
        <input type=radio name=rt_reporttype value=hourlyperday <?=($_REQUEST['rt_reporttype']=='hourlyperday' ? "checked" : "")?>>
        &nbsp;
        <?=L_G_HORLYINDAY?>
      </td>
      <td align=left>
        <select name=rt_pd_day>
<?      for($i=1; $i<=31; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['rt_pd_day'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
        <select name=rt_pd_month>
<?      for($i=1; $i<=12; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['rt_pd_month'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
        <select name=rt_pd_year>
<?      for($i=2003; $i<=$this->a_curyear; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['rt_pd_year'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
      </td>
    </tr>
    <tr>
      <td align=left>
        <input type=radio name=rt_reporttype value=permonth <?=($_REQUEST['rt_reporttype']=='permonth' ? "checked" : "")?>>
        &nbsp;
        <?=L_G_DAILYINMONTH?>
      </td>
      <td align=left>
        <select name=rt_pm_month>
<?      for($i=1; $i<=12; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['rt_pm_month'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
        <select name=rt_pm_year>
<?      for($i=2003; $i<=$this->a_curyear; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['rt_pm_year'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
      </td>
    </tr>
    <tr>
      <td align=left>
        <input type=radio name=rt_reporttype value=peryear <?=($_REQUEST['rt_reporttype']=='peryear' ? "checked" : "")?>>
        &nbsp;
        <?=L_G_MONTHLYINYEAR?>
      </td>
      <td align=left>
        <select name=rt_py_year>
<?      for($i=2003; $i<=$this->a_curyear; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['rt_py_year'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
      </td>
    </tr>
    </table>
    </td>
    <td valign=top>
    	<table border=0>
    		<tr>
    			<td>
    				<strong>Show:</strong>
    			</td>
    		</tr>    		
    		<tr>
    			<td>
    				<input type=checkbox name=rt_imps value='1'<?=((('1' == $_REQUEST['rt_imps']) || ($_REQUEST['commited'] != 'yes')) ? " checked='checked'" : "")?> /> <?=L_G_IMPRESSIONS?>
    			</td>
				<td>
    				<input type=checkbox name=rt_cpc value='1'<?=('1' == $_REQUEST['rt_cpc'] ? " checked='checked'" : "")?> /> <?=L_G_CPC?>
    			</td>
    		</tr>    		
    		<tr>
    			<td>
    				<input type=checkbox name=rt_clicks value='1'<?=('1' == $_REQUEST['rt_clicks'] ? " checked='checked'" : "")?> /> <?=L_G_CLICKS?>
    			</td>
    			<td>
    				<input type=checkbox name=rt_epc value='1'<?=('1' == $_REQUEST['rt_epc'] ? " checked='checked'" : "")?> /> <?=L_G_EPC?>
    			</td>
    		</tr>    		
    		<tr>
    			<td>
    				<input type=checkbox name=rt_sales value='1'<?=('1' == $_REQUEST['rt_sales'] ? " checked='checked'" : "")?> /> <?=L_G_SALES?>
    			</td>
    			<td>
    				<input type=checkbox name=rt_epu value='1'<?=('1' == $_REQUEST['rt_epu'] ? " checked='checked'" : "")?> /> <?=L_G_EPU?>
    			</td>
    		</tr>    		
    		<tr>
    			<td>
    				<input type=checkbox name=rt_commission value='1'<?=('1' == $_REQUEST['rt_commission'] ? " checked='checked'" : "")?> /> <?=L_G_REVENUE?>
    			</td>
    			<td>
    				<input type=checkbox name=rt_epm value='1'<?=('1' == $_REQUEST['rt_epm'] ? " checked='checked'" : "")?> /> <?=L_G_EPM?>
    			</td>
    		</tr>    		
    		<tr>
    			<td colspan=2>
    				<input type=checkbox name=rt_revenue value='1'<?=('1' == $_REQUEST['rt_revenue'] ? " checked='checked'" : "")?> /> <?=L_G_TOTALCOSTS?>
    			</td>
    		</tr>    		
    		<tr>
    			<td colspan=2>
    				<input type=checkbox name=rt_expenses value='1'<?=('1' == $_REQUEST['rt_expenses'] ? " checked='checked'" : "")?> /> <?=L_G_EXPENSES?>
    			</td>
    		</tr>    		
    		<tr>
    			<td colspan=2>
    				<input type=checkbox name=rt_profits value='1'<?=('1' == $_REQUEST['rt_profits'] ? " checked='checked'" : "")?> /> <?=L_G_PROFITS?>
    			</td>
    		</tr>    		
    	</table>
    </td>
    </tr>
    <tr>
      <td align=center colspan=2>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_MerchantReports'>
      <input type=hidden name=reporttype value='traffic'>
      <input class=formbutton name=run type=submit value='<?=L_G_SUBMIT; ?>'>      
              <?
if($_REQUEST['run'] != null){?>
<input type=button class=formbutton onClick="javascript:popupSQL();" value="View SQL" /> 
<?
}
?>        
      </form>
      </td>
    </tr>
  </table>
  </form>

  <hr>
