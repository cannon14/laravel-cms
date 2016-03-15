    <table width="100%" border=0 cellspacing=0 cellpadding=3>
    <? QUnit_Templates::printFilter2(3, L_G_TROUBLESHOOTING); ?>
    <tr>
      <td colspan=2 valign=top><? showHelp('L_G_HLPTROUBLESHOOTING'); ?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap>&nbsp;<b><?=L_G_LOG_LEVEL?></b>&nbsp;</td>
      <td valign=top>
        <input type=checkbox name=log_level_element[] value=<?=WLOG_DBERROR?> <?=(($_POST['log_level'] & WLOG_DBERROR) == WLOG_DBERROR ? ' checked' : '')?>><?=L_G_LOG_DBERROR?>
        <br><input type=checkbox name=log_level_element[] value=<?=WLOG_ERROR?> <?=(($_POST['log_level'] & WLOG_ERROR) == WLOG_ERROR ? ' checked' : '')?>><?=L_G_LOG_ERROR?>
<!--        <br><input type=checkbox name=log_level_element[] value=<?=WLOG_ACTIONS?> <?=(($_POST['log_level'] & WLOG_ACTIONS) == WLOG_ACTIONS ? ' checked' : '')?>><?=L_G_LOG_ACTIONS?> -->
        <br><input type=checkbox name=log_level_element[] value=<?=WLOG_DEBUG?> <?=(($_POST['log_level'] & WLOG_DEBUG) == WLOG_DEBUG ? ' checked' : '')?>><?=L_G_LOG_DEBUG?>
      </td>
    </tr>
    </table>    
