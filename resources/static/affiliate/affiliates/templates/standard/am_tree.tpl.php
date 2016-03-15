<center>
<table class=listing border=0 cellspacing=0 cellpadding=3>
<? QUnit_Templates::printFilter(1, L_G_TREEOFSUBAFFILIATES) ?>
<? while($data=$this->a_list_data->getNextRecord()) { ?>
   <tr>
     <td align=left nowrap>&nbsp;
     <?=$data['tab']?><?=$data['userid'].': '.$data['name'].' '.$data['surname'].' - '?>
     <a class=blueLink href="mailto:<?=$data['username']?>"><?=$data['username']?></a>
     &nbsp;</td>
   </tr>
<? } ?>

</table>
</center>
