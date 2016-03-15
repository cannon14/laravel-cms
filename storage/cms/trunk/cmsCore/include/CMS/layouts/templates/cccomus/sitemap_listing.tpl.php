<?php /*?><?if($this->input['listType']=='category'){?>

<hr size="1px" noshade color="#CCCCCC" style="solid">
<br />
<span class="credit-card-med-no-dec-BIG">
<?=$this->input['category']?>
</span> <br />
<br />
<?}else if($this->input['listType']=='cardListing'){?>
<table width="100%" border="0" cellpadding="0" cellspacing="5">
	<tr>
		<?if($this->input['page'] !== null){?>
		<td width="35%" valign="top" rowspan="<?=$this->input['remainingCards']+1?>"><table>
				<tr>
					<td valign="top"><a href="<?=$this->input['page']->get('pageLink')?>.php" class="credit-card-med-no-dec"><img src="/images/ar2.gif" alt="<?=$this->input['page']->get('siteMapTitle')?>" width="8" height="8" hspace="5" border="0"></a></td>
					<td valign="top"><a href="<?=$this->input['page']->get('pageLink')?>.php" class="credit-card-med-no-dec">
						<?=$this->input['page']->get('siteMapTitle')?>
						</a></td>
				</tr>
			</table></td>
		<?}?>
		<td width="65%" valign="top"><a href="<?=$this->input['card'][1]?>.php" class="credit-card-med-no-dec-no-bold">
			<?=$this->input['card'][0]?>
			</a></td>
	</tr>
</table>
<? } //if else if ?>
<?php */?>


<?php if ($this->input['listType']=='category') { ?>
<h3><strong><?=$this->input['category']?></strong></h3>
<br>
<?php } elseif ($this->input['listType']=='cardListing') { ?>

	<dl class="dl-horizontal-sitemap">
		<?php if($this->input['page'] !== null) { ?>
		<dt><i class="fa fa-caret-right"></i> <a href="<?=$this->input['page']->get('pageLink')?>.php"></a></dt>
		<dd><a href="<?=$this->input['card'][1]?>.php">
			<?=$this->input['card'][0]?>
			</a></dd>
		<hr />
		<?php } ?>
	</dl>
<?php } ?>
