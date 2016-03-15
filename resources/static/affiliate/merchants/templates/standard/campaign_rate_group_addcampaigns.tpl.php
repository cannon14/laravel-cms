<script language= "JavaScript" type="text/javascript">
<!--

function one2two() {
    m1len = m1.length ;
    for ( i=0; i<m1len ; i++){
        if (m1.options[i].selected == true ) {
            m2len = m2.length;
            m2.options[m2len]= new Option(m1.options[i].text);
        	m2.options[m2len].value = m1.options[i].value;
        }
    }

    for ( i = (m1len -1); i>=0; i--){
        if (m1.options[i].selected == true ) {
            m1.options[i] = null;
        }
    }
}

function two2one() {
    m2len = m2.length ;
        for ( i=0; i<m2len ; i++){
            if (m2.options[i].selected == true ) {
                m1len = m1.length;
                m1.options[m1len]= new Option(m2.options[i].text);
                m1.options[m1len].value = m2.options[i].value;
            }
        }
        for ( i=(m2len-1); i>=0; i--) {
            if (m2.options[i].selected == true ) {
                m2.options[i] = null;
            }
        }
}

function selectAll(){
	for (i=0; i<m2.length; i++) { 
		m2.options[i].selected = true; 
	}
	return true;
}

//-->
</script>

 <table border=0 class=listing cellspacing=0 cellpadding=2>
    <? QUnit_Templates::printFilter(2, $_POST['header']); ?>
	<form name="assign" onSubmit="return selectAll();" action=index_popup.php method=post >
    <tr>
      <td class=dir_form>

		<table bgcolor=white cellpadding=10 cellspacing=0 border=0 align=center>
			<tr>
				<td align=center width='50%'><b>Unassigned Products</td>
				<td align=center width='50%'><b>Assigned Products</td>
			</tr>
			<tr>
				<td>
				    <select name='unAssignedCampaigns' id='unAssignedCampaigns' size=10 multiple>
						<?foreach($_POST['nonmembersarray'] as $id=>$name){ ?>
							<OPTION VALUE="<?=$id?>"><?=$name?></OPTION>
						
						<? } ?>
				    </select>
				    <br>
				    <p align=center><input class="formbutton" type="button" onClick="one2two()" value=" Assign >> "></p>
		                                                                             
				</td>
				<td align=center  width='50%'>
				    <select name='assignedCampaigns[]' id='assignedCampaigns' size=10 multiple >
						<?foreach($_POST['membersarray'] as $id=>$name){ ?>
							<OPTION VALUE="<?=$id?>"><?=$name?></OPTION>
						
						<? } ?>
				    </select>
				    <br>
				    <p align=center><input class="formbutton" type="button" onClick="two2one()" value=" << Remove " ></p>
		
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>

<br>
<br>

<input type=hidden name=commited value=yes>
<input type=hidden name=postaction value='addMembers'>
<input type=hidden name=md value='Affiliate_Merchants_Views_CampaignRateGroupsManager'>
<input type=hidden name=action value=<?=$_POST['action']?>>
<input type=hidden name=gid value=<?=$_POST['gid']?>>

<center>
	<input type="submit" class="formbutton" value="Commit Changes">
	&nbsp;
	<input type="button" onclick="javascript:window.close()" class="formbutton" value="Cancel">
</center>

</form>

<script language="JavaScript">
// shorthand for refering to menus
// must run after document has been created
// you can also change the name of the select menus and
// you would only need to change them in one spot, here
var m1 = document.getElementById('unAssignedCampaigns');
var m2 = document.getElementById('assignedCampaigns');
</script>