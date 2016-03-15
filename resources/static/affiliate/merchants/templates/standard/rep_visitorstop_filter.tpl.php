
<table class=listing border=0 cellspacing=0 cellpadding=0>
<? QUnit_Templates::printFilter(1, L_G_VISITORTOP); ?>
<tr>
  <td valign=top align=left>

  <form action=index.php method=get>
  <table border=0>
    <tr>
      <td align=left>
        TOP VISITORS TO SHOW:
      </td>
      <td align=left>
        <select name=rep_topcount>
          <option value='_'><?=L_G_ALL?></option>
          <option value='10' <?=($_REQUEST['rep_topcount'] == 10 ? 'selected' : '')?>>10</option>
          <option value='20' <?=($_REQUEST['rep_topcount'] == 20 ? 'selected' : '')?>>20</option>
          <option value='30' <?=($_REQUEST['rep_topcount'] == 30 ? 'selected' : '')?>>30</option>
          <option value='50' <?=($_REQUEST['rep_topcount'] == 50 ? 'selected' : '')?>>50</option>
          <option value='100' <?=($_REQUEST['rep_topcount'] == 100 ? 'selected' : '')?>>100</option>
      </select>&nbsp;&nbsp;
      </td>
    </tr>      
    <tr>
      <td align=left colspan=2>
        SELECT A DATE:
      </td>
    </tr>
    
    <tr>
	  <td>
		<b>Date:</b>
		</td>
		<td>
		<input type='text' class='disabled' onfocus="this.blur()" name='rep_startdate' value="<?=$_REQUEST['rep_startdate']?>">&nbsp;<img src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>cal.gif" onclick="displayCalendar(document.forms[0].rep_startdate,'mm-dd-yyyy',this)">
	  </td>
	</tr>
	<!-- tr>
	  <td>
		<b>End Date:</b>
	  </td>
      <td>
		<input type='text' class='disabled' onfocus="this.blur()" name='rep_enddate' value="<?=$_REQUEST['rep_enddate']?>">&nbsp;<img src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>cal.gif" onclick="displayCalendar(document.forms[0].rep_enddate,'mm-dd-yyyy',this)">
	  </td>	
	</tr -->
    
    
    <tr>
      <td align=left>
        <input type=checkbox name=rep_fullip value='full' <?=($_REQUEST['rep_fullip']=='full' ? "checked" : "")?>>
        &nbsp; USE FULL IP ADDRESS
      </td>
      
    </tr>
    <tr>
      <td align=center colspan=2>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_MerchantReports'>
      <input type=hidden name=reporttype value='visitortop'>
      <input class=formbutton type=submit value='<?=L_G_SUBMIT; ?>'>      
      </form>
      </td>
    </tr>
  </table>
  </form>

  <hr>
