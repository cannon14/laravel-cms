<? 
if(count($this->okMessages) > 0) { ?>
    
    <table class="okMsgTable" border=0 cellspacing=0 cellpadding=2>
    <tr>
        <td class="okMessageHeader">
        <img src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>success.png" border="10">&nbsp;
        <?=L_G_SUCCESS?>
        </td>
    </tr>
    <tr>
        <td class="okMessage" align=left valign=top>
        <ul class="okMessage2">
<?      foreach($this->okMessages as $msg) { ?>
            <li class="okMessage"><?=$msg?></li>
<?      } ?>
        </ul>
        </td>
    </tr>
    </table>
    <br>
<? } 

if(count($this->errorMessages) > 0) { ?>
    
    <table class="errorMsgTable" border=0 cellspacing=0 cellpadding=2>
    <tr>
        <td class="errorMessageHeader">
        <img src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>exclamation.png" border="10">&nbsp;
        <?=L_G_ERROR?>
        </td>
    </tr>
    <tr>
        <td class="errorMessage" align=left valign=top>
        <ul class="errorMessage">
<?      foreach($this->errorMessages as $msg) { ?>
            <li class="errorMessage"><?=$msg?></li>
<?      } ?>
        </ul>
        </td>
    </tr>
    </table>
    <br>
<? } ?>

