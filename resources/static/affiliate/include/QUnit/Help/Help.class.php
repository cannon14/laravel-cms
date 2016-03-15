<?
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class QUnit_Help_Help extends QUnit_UI_TemplatePage
{
    function process()
    {
?>
    <table class=listing border=0 width=100% cellspacing=0 cellpadding=3>
      <? QUnit_Templates::printFilter(1, L_G_HELP); ?>
      <tr>
        <td valign=top align=left><?=constant('L_'.$_REQUEST['hid'])?></td>
      </tr>
    </table>
<?
    }
}
?>
