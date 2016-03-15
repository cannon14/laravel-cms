	    <?if(isset($_SESSION[MESSAGE_SESSION]) && is_object($_SESSION[MESSAGE_SESSION])){ ?>
	    <br>
	    <table align='center' width='600' class='dbList'> 
	    <tr>
	    <td class='fctitle_blue'>
	    Console 
	    </td>
	    </tr>
	    <tr>
	    <td>
	    <div style="width:600px; height:100px; background-color:#ffffff; overflow:auto;">
	    <?=_getMessages()?>
	    </div>
	    </td>
	    </tr>
	    </table>
	    <? } ?>

