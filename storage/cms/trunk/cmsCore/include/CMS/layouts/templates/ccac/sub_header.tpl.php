<?php
/*
 * Created on Jun 16, 2006
 * Click Success L.P.
 * Author: Jason Huie
 * <jasonh@clicksuccess.com>
 */
?>
<table width="90%" border="1" cellspacing="1" cellpadding="2" align="center" bordercolor="#CCdaf0" bgcolor="#003399">
	<tr> 
		<td height="25"> 
			<h1 align="center">&nbsp;<?=$this->page->get('pageHeaderString')?></h1>
		</td>
	</tr>
</table>
<table width="90%" border="0" cellspacing="0" cellpadding="1" align="center"> 
	<tr> 
		<td>
		<?if($this->pageNav){?>
			<br>
			<div align="left">
				<table width="90%" border="0" cellspacing="0" cellpadding="1" align="center">
					<tr> 
						<td align='center'><?=$this->pageNav?></td>
					</tr>
				</table>
			</div>
			<br>
		<?}else{?><p><?=$this->page->get('pageDescription')?><br><br></p><?}?>
		</td>
	</tr>
</table>