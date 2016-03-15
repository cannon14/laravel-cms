<head>
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
</head>

<BODY>
<center>
 <table border=0 class=listing cellspacing=0 cellpadding=2>
	<form name="assign" onSubmit="return selectAll();" action=index.php>
    <tr>
      <td class=dir_form>

<table bgcolor=white cellpadding=10 cellspacing=0 align=center >
<tr>
<td align=center width='50%'><b>Unassigned Campaign Categories</td><td align=center width='50%'><b>Assigned Campaign Categories</td>
<tr>
<td>
    <select name='unAssignedPages' id='unassignedPages' size=10 multiple>
<?while($this->unassignedSubPages && !$this->unassignedSubPages->EOF){ ?>
	<OPTION VALUE="<?=$this->unassignedSubPages->fields['cardpageId']?>"><?=$this->unassignedSubPages->fields['pageName']?></OPTION>

<? $this->unassignedSubPages->MoveNext();} ?>
    </select><br>
    <p align=center><input class="formbutton" type="button" onClick="one2two()" value=" Assign >> "></p>
                                                                             
</td><td align=center  width='50%'>
    <select name='subpageId[]' id='assignedPages' size=10 multiple >
    <?while($this->assignedSubPages && !$this->assignedSubPages->EOF){ ?>
	<OPTION VALUE="<?=$this->assignedSubPages->fields['cardpageId']?>"><?=$this->assignedSubPages->fields['pageName']?></OPTION>

	<? $this->assignedSubPages->MoveNext();} ?>
    </select><br>
    <p align=center><input class="formbutton" type="button" onClick="two2one()" value=" << Remove " ></p>

</td></tr></table>

<br><br>
<input type=hidden name=mod value='<?=$_REQUEST['mod']?>'>
<input type=hidden name=pageId value='<?=$_REQUEST['pageId']?>'>
<input type=hidden name=siteId value='<?=$_REQUEST['siteId']?>'>
<input type=hidden name=process value=1>
<input type=hidden name=action value='addSubPage'>
<center>

<input type="submit" class="formbutton" value="Commit Changes">
&nbsp;
<input type="button" onclick="document.location.href='index.php?mod=<?=$_REQUEST['mod']?>&siteId=<?=$_REQUEST['siteId']?>'";
  	" class="formbutton" value="Cancel">
</center>
</form>
</center>
<script language="JavaScript">
// shorthand for refering to menus
// must run after document has been created
// you can also change the name of the select menus and
// you would only need to change them in one spot, here
var m1 = document.getElementById('unassignedPages');
var m2 = document.getElementById('assignedPages');
</script>

</body>
</html>

