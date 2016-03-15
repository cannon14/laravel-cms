<?if($this->input['listType']=='category'){?>
	</table>
	<table width="93%" border="0" align="center" cellpadding="0" cellspacing="5">
		<tr>
        	<td colspan=2><hr size="1px" noshade color="#CCCCCC" style="solid"></td>
        </tr>
        <tr>
        	<td colspan=2><span class="credit-card-med-no-dec-BIG"><?=$this->input['category']?></span><br>
        		<img src="/images/10-10-spacer.gif" width="10" height="10" border="0">
        	</td>
        	
<?}else if($this->input['listType']=='cardListing'){
	if($this->input['page'] !== null){?>
	</tr>
	<tr>
		<td width=35% valign="top" rowspan="<?=$this->input['remainingCards']+1?>">
			<table>
				<tr>
					<td valign="top">
						<a href="<?=$this->input['page']->get('pageLink')?>.php" class="credit-card-med-no-dec">
							<img src="/images/ar2.gif" alt="<?=$this->input['page']->get('siteMapTitle')?>" width="8" height="8" hspace="5" border="0">
						</a>
					</td>
					<td valign="top">
						<a href="<?=$this->input['page']->get('pageLink')?>.php" class="credit-card-med-no-dec">
					        <?=$this->input['page']->get('siteMapTitle')?>
					    </a>
					</td>
				</tr>
			</table>
		</td>
    <?}
    else {
         echo '<tr>';   
    }    
    ?>
	
    	<td width=80% valign="top">
            <? if($this->input['card'][1] != '') {?>
    		<a href="<?=$this->input['card'][1]?>.php" class="credit-card-med-no-dec-no-bold">
    		    <?=$this->input['card'][0]?>
    		</a>
            <? }else{ print $this->input['card'][0]; }?>
    	</td>
    </tr>    
    
    <?if($this->input['remainingCards'] <= 0 && $this->input['remainingPages'] > 0){?>
    	<tr>
    		<td colspan=2>
    			<hr size="1px" noshade color="#CCCCCC" class="hr-dashed" style="dashed">
    		</td>
    	</tr>
    <?}?>
<?}?>