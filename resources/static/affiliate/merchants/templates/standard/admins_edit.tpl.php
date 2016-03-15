<?if($_POST['allAffiliates'] == 1)$checked="checked"?>
<head>
<script>
	function disableSelect()
	{
		var un = document.getElementById("unassignedAffiliates");
		var as = document.getElementById("assignedAffiliates");
		var rm = document.getElementById("doRemove");
		var ad = document.getElementById("doAdd");
		var al = document.getElementById("all");
		
		if(al.checked == true){
			eval(un.disabled=true);
			as.disabled=true;
			rm.disabled=true;
			ad.disabled=true;
		}else{
			un.disabled=false;
			as.disabled=false;
			rm.disabled=false;
			ad.disabled=false;
		}
		return;
	}
</script>
</head>
<body onload="javascript:disableSelect();">
    <? if($_POST['show_no_popup'] == '1') { ?>
         <form action=index.php method=post onSubmit="return selectAll();">
    <? } else { ?>
        <form action=index_popup.php method=post onSubmit="return selectAll();">
    <? } ?>
    <table class=listing border=0 cellspacing=0 cellpadding=2>
    	<tr>
    		<td>
    			<table>
				    <? QUnit_Templates::printFilter(2, $_POST['header']); ?>
				    <tr>
				      <td class=dir_form>&nbsp;<b><?=L_G_USERNAME;?></b>&nbsp;</td>
				      <td><input type=text name=username size=44 value="<?=$_POST['username']?>">*&nbsp;</td>
				    </tr>
				    <tr>
				      <td class=dir_form>&nbsp;<b><?=L_G_PWD1;?></b>&nbsp;</td>
				      <td><input type=password name=pwd1 size=22 value="<?=$_POST['pwd1']?>">*&nbsp;</td>
				    </tr>
				    <tr>
				      <td class=dir_form>&nbsp;<b><?=L_G_PWD2;?></b>&nbsp;</td>
				      <td><input type=password name=pwd2 size=22 value="<?=$_POST['pwd2']?>">*&nbsp;</td>
				    </tr>
				    <tr>
				      <td class=dir_form>&nbsp;<b><?=L_G_NAME;?></b>&nbsp;</td>
				      <td><input type=text name=name size=44 value="<?=$_POST['name']?>">&nbsp;</td>
				    </tr>
				    <tr>
				      <td class=dir_form>&nbsp;<b><?=L_G_SURNAME;?></b>&nbsp;</td>
				      <td><input type=text name=surname size=44 value="<?=$_POST['surname']?>">&nbsp;</td>
				    </tr>
				    <tr>
				      <td class=dir_form>&nbsp;<b><?=L_G_USER_PROFILE;?></b>&nbsp;</td>
				      <td>
				        <select name=userprofile>
				        <?
				            while($data=$this->a_list_data->getNextRecord()) {
				              echo '<option value="'.$data['userprofileid'].'" '.($_POST['userprofile'] == $data['userprofileid'] ? ' selected' : '').'>'.$data['name'].'</option>';
				            }
				        ?>
				        </select>*&nbsp;
				      </td>
				    </tr>
				    <? if($this->a_Auth->getUserID() != $_POST['aid']) { ?>
				    <tr>
				      <td class=dir_form>&nbsp;<b><?=L_G_STATUS;?></b>&nbsp;</td>
				      <td>
				        <select name=rstatus>
				        <?
				          if($_POST['rstatus'] == '') $_POST['rstatus'] = STATUS_ENABLE;
				          echo "<option value=\"".STATUS_ENABLED."\" ".($_POST['rstatus'] == STATUS_ENABLED ? "selected" : "").">".L_G_ENABLE."</option>\n";
				          echo "<option value=\"".STATUS_DISABLED."\" ".($_POST['rstatus'] == STATUS_DISABLED ? "selected" : "").">".L_G_DISABLE."</option>\n"; 
				        ?>
				        </select>*&nbsp;
				      </td>
				    </tr>
    <? } ?>
      </table>
    </td>
  </tr>
  <tr>
    	<td colspan=2><hr></td>
    </tr>    

<script language= "JavaScript">
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
<tr>
	<td align='center'>
		<table>
		    <tr>
		    	<td class=dir_form><b>Unassigned Affilates</td><td align=center width='50%'><b>Assigned Affiliates</td>
			<tr>
				<td><select name='unAssignedPages' id='unassignedAffiliates' size=10 multiple>
				<?while($this->unassigned && !$this->unassigned->EOF){ ?>
					<OPTION VALUE="<?=$this->unassigned->fields['userid']?>"><?=$this->unassigned->fields['username']?></OPTION>
				<?$this->unassigned->MoveNext();} ?>		
		    		</select>
		    		<center><input id="doAdd" class="formbutton" type="button" onClick="one2two()" value=" Assign >> "></center></td>
		    		
		    	<td align=center  width='50%'><select name='affiliateId[]' id='assignedAffiliates' size=10 multiple >
		    	<?while($this->assigned && !$this->assigned->EOF){ ?>
					<OPTION VALUE="<?=$this->assigned->fields['userid']?>"><?=$this->assigned->fields['username']?></OPTION>
				<? $this->assigned->MoveNext();} ?>
		    		</select>
		    		<center><input id="doRemove" class="formbutton" type="button" onClick="two2one()" value=" << Remove " ></center></td>
		    </tr>
		    <tr>
		    	<td colspan=2 align=center>Assign All Affiliates <input name="allAffs" id="all" type=checkbox value=1 onclick="javascript:disableSelect();" <?=$checked?>></td>
		    </tr>
		    <script language="JavaScript">
				// shorthand for refering to menus
				// must run after document has been created
				// you can also change the name of the select menus and
				// you would only need to change them in one spot, here
				var m1 = document.getElementById('unassignedAffiliates');
				var m2 = document.getElementById('assignedAffiliates');
			</script>
		    </table>
		   </td>
		  </tr>
		  <tr>
		  	<td><hr></td>
		  </tr>
		  <tr>
		  	<td align="center">
			    <input type=hidden name=md value='Affiliate_Merchants_Views_AdminsManager'>
			    <input type=hidden name=action value=<?=$_POST['action']?>>
			    <input type=hidden name=aid value=<?=$_POST['aid']?>>
			    <input type=hidden name=postaction value=<?=$_POST['postaction']?>>
			    <input type=hidden name=show_no_popup value='<?=$_POST['show_no_popup']?>'>
			    <input type=submit class=formbutton value='<?=L_G_SUBMIT; ?>'>
	      </td>
	   </tr>
	 </table>
	</form>