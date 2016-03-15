<?php
/*
 * Created on Jun 27, 2006
 *
 * Click Success L.P.
 * Author: Jason Huie
 * <jasonh@clicksuccess.com>
 */
?>
<head>
<script>
	function preview(render)
	{
		var content = document.getElementById('preview')
		if(content == null){
			var content = document.createElement('div');
			content.setAttribute('id', 'preview');
			editor.appendChild(content);
		}		
		content.innerHTML = "<center><table class='component' align='center'><tr><td class='componentHead'>Preview</td></tr><tr><td align=center>"+render+"</td></tr></table></center>";
	}
</script>

<div id='editor'>
<form action=index.php method=post name=edit>  
    <table class='component' align='center'>
	<tr>
	<td colspan=2 class='componentHead'>
	Create Page Component
	</td>
	</tr>
    <tr>
     <td align=left nowrap>&nbsp;Item Name</td>
     <td align=left>
        <input type=text name=item size=40 value='<?=$_POST['item']?>'>
     </td>
    </tr>
    <tr>
    	<td align-left nowrap>HTML</td>
    	<td align=left>
    		<textarea name=render cols=75 rows=10><?=$_POST['render']?></textarea>
    	</td>
    </tr>
    </table>
    <center>
    <table>
    <tr>
    <td align=left width=33.3%><input type=submit value='Submit'></td>
    <td align=left width=33.3%><input type=button value='Cancel' onClick="window.location='index.php?mod=<?=$_REQUEST['mod']?>'"></td>
    <td align=left width=33.3%><input type=button value='Preview' onClick="javascript:preview(render.value)"></td>
    </tr>
    </table>
    <br><br>
	</div>
	
    </center>
    <input type=hidden name=committed value=1>
    <input type=hidden name=mod value=<?=$_REQUEST['mod']?>>
    <input type=hidden name=action value=<?=$_REQUEST['action']?>>
    <input type=hidden name=itemid value=<?=$_REQUEST['itemid']?>>
</form>