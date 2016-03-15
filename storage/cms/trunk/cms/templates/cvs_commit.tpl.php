<?if(!$_REQUEST['commited']){?>
<script>
	if(confirm("You are about to commit articles into CVS. Are you sure you want to continue?"))
		document.location="index.php?mod=CMS_view_cvsUpdate&commited=1";
</script><?}?>

<br><br>	    
    <br>
    <table align='center' width='600' class='dbList'> 
    <tr>
    <td class='fctitle_blue'>CVS Status</td>
    </tr>
    <tr>
    <td>
    <div style="width:600px; height:400px; background-color=#ffffff; overflow:auto">
    New Files:<hr>
    <?foreach($this->added as $file)echo $file.'<br>'?>
    <br><br>
    Commited Files:<hr>
    <?foreach($this->committed as $file)echo $file.'<br>'?>
    </div>  
    </td>
    </tr>
    </table>