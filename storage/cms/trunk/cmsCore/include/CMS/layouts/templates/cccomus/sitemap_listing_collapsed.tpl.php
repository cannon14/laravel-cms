<?php /*?><table width="100%" border="0" cellpadding="0" cellspacing="5">

<?if($this->input['page']){?>

	<tr>
		<td width="35%" valign="top" rowspan="<?=$this->input['remainingCards']+1?>">
			<table>
				<tr>
					<td valign="top">
						<a href="<?=$this->input['page']->get('pageLink')?>.php" class="credit-card-med-no-dec">
							<img src="/images/ar2.gif" alt="<?=$this->input['page']->get('pageHeaderString')?>" width="8" height="8" border="0" hspace="5">
						</a>
					</td>
					<td valign="top">
						<a href="<?=$this->input['sitemap_link']?>.php" class="credit-card-med-no-dec">
						    <?=$this->input['page']->get('pageHeaderString')?>
						</a>
					</td>
				</tr>
			</table>
		</td>
	    <?}?>
	    
		<td width="65%" valign="top">
			<a href="<?=$this->input['page']->get('pageLink')?>.php" class="credit-card-med-no-dec-no-bold">Compare <?=$this->input['page']->get('pageHeaderString')?></a>
		</td>
	</tr>
</table><?php */?>


<?php if($this->input['page']){ ?>

				<dl class="dl-horizontal-sitemap">
				
					<dt><i class="fa fa-caret-right"></i> <a href="<?=$this->input['sitemap_link']?>.php">
						    <?=$this->input['page']->get('pageHeaderString')?></a></dt>
					<dd><a href="<?=$this->input['page']->get('pageLink')?>.php">Compare <?=$this->input['page']->get('pageHeaderString')?></a></dd>
					<hr />

<?php } ?>						
						
					</dl>