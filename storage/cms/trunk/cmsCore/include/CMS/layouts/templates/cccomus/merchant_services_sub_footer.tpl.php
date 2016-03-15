<?$components = $this->page->getComponents()?>
<table width="90%" border="0" cellspacing="0" cellpadding="1" align="center">
  <tr>
    <td><?='<center>'.$this->pageNav.'</center>'?></td>
   </tr>
</table>
<?if($this->articles != null){?>  
<br>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<table width="100%" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td><img width="6" height="6" src="images/credit-corner-top-lft.gif" alt="" /></td>
					<td background="images/credit-corner-hdr_fill.gif"><img width="1" height="6" src="images/clear.gif" alt="" /></td>
					<td><img width="6" height="6" src="images/credit-corner-top-rt.gif" alt="" /></td>
				</tr>
				<tr>
					<td background="images/credit-corner-body_leftfill.gif"><img width="6" height="1" src="images/clear.gif" alt="" /></td>
					<td width="100%" bgcolor="#f5f6f0">
						<table width="100%" cellspacing="0" cellpadding="4" border="0">
							<tr>
								<td>
									<p><strong>Want to know more about <?=$this->page->get('pageTitle')?>? Below are articles and resources that should be of interest to you:</strong>                     </p>
									<ul>
										<?foreach($this->articles as $article){
											$opening = '';
											$articleArray=explode(' ', strip_tags($article->get('post_content')));
											for($x=0; $x<25; $x++)
												$opening .= $articleArray[$x].' ';?>
												<li class="sand-article"><a href="/<?=$article->get('post_name')?>.php"><?=$article->get('post_title')?></a>&nbsp;--&nbsp;<?=$opening?>...</li>
											<?}?>
									</ul>
									<img width="375" height="1" src="/images/1-375-spacer.gif" alt="" />
								</td>
							</tr>
						</table>
					</td>
					<td background="images/credit-corner-body_rightfill.gif"><img width="6" height="1" src="images/clear.gif" alt="" /></td>
				</tr>
				<tr>
					<td><img width="6" height="6" src="images/credit-corner-bt-lft.gif" alt="" /></td>
					<td background="images/credit-corner-ftr_fill.gif"><img width="1" height="6" src="images/clear.gif" alt="" /></td>
					<td><img width="6" height="6" src="images/credit-corner-bt-rt.gif" alt="" /></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height="3"></td>
	</tr>
</table>
<?}?>
<?if($this->page->get('pageSeeAlso') != ""){?>
	<table width="95%" border="0" cellspacing="0" cellpadding="6" align="center" bgcolor="#FFFFFF">
        <tr> 
          <td> 
            <table border="0" cellspacing="0" cellpadding="6" width="100%" >
              <td valign="top" class="credit-card-details" width="100%"><p><?=$this->page->get('pageSeeAlso')?></p></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
<?}?>
<img src="/images/445spacer.gif" width="445" height="8"><br>
<?if($components[1])
	echo '<br>'.$components[1]->get('render').'<img src="/images/445spacer.gif" width="445" height="8"><br>';
?>
<?if($this->page->get('pageDisclaimer') != ""){?>
      <table border="0" cellspacing="0" cellpadding="0" width="90%" align="center" >
        <td valign="top" class="credit-card-details" width="100%"><br><br><?=$this->page->get('pageDisclaimer')?><br><br></td>
        </tr>
      </table>
<?}?>
<img src="/images/1-375-spacer.gif" width="375" height="1"></td>
</tr></table>