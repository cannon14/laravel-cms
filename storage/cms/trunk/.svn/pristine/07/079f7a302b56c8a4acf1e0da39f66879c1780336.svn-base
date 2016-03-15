<?php /*?>
<?if($this->input['page']){?>
<table width="100%" border="0" cellpadding="0" cellspacing="5">
	<tr>      
      <td width="35%" valign="top" align="left" rowspan="<?=$this->input['remainingCards']+2?>">
         <table border="0">
            <tr>             
               <td valign="top">
                  <a href="/<?=$this->input['page']->get('pageLink')?>.php<?=$this->input['page']->get('pageAnchor')?('#'.$this->input['page']->get('pageAnchor')):''?>" class="credit-card-med-no-dec">
                     <img src="/images/ar2.gif" alt="<?=$this->input['page']->get('pageHeaderString')?>" width="8" height="8" border="0" hspace="5">
                  </a>
               </td>
               <td>
                  <a href="/<?=$this->input['page']->get('pageLink')?>.php<?=$this->input['page']->get('pageAnchor')?('#'.$this->input['page']->get('pageAnchor')):''?>" class="credit-card-med-no-dec">
                     <?=$this->input['category_name']; ?>
                  </a>
               </td>                  
            </tr>
         </table>
      </td>
    </tr>
<?}?>

	<tr>
		<td width="65%" valign="top">
			<a href="/credit-cards/<?=$this->input['card']->get('cardLink')?>.php" class="credit-card-med-no-dec-no-bold">
	            <?=$this->input['card']->get('cardTitle')?> <?//='<? if(in_array(\'' . $this->input['card']->get('cardId') . '\', $cardMatchCards)) print \'<img src="/images/star.png" style="border:none; height: 15px; width: 15px;"/>\';? >';?>
			</a>
		</td>
	</tr>

<?if($this->input['remainingCards'] == 0){?>
    </table>
<?}?><?php */?>


<?php if ($this->input['page']) { ?>

<dl class="dl-horizontal-sitemap">
	<dt><i class="fa fa-caret-right"></i> <a href="/<?= $this->input['page']->get('pageLink') ?>.php<?= $this->input['page']->get('pageAnchor')?('#'.$this->input['page']->get('pageAnchor')):'' ?>">
		<?= $this->input['category_name'] ?>
		</a></dt>
	<?php } ?>
	<dd><a href="/credit-cards/<?= $this->input['card']->get('cardLink') ?>.php">
		<?= $this->input['card']->get('cardTitle') ?>
		<?php //='<? if(in_array(\'' . $this->input['card']->get('cardId') . '\', $cardMatchCards)) print \'<img src="/images/star.png" style="border:none; height: 15px; width: 15px;"/>\';? >'; ?>
		</a></dd>
	<?php if ($this->input['remainingCards'] == 0) { ?>
</dl>

<?php } ?>
