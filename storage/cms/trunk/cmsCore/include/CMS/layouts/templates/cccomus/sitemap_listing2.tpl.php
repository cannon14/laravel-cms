<?if($this->input['listType']=='category'){?>

    <hr size="1px" noshade color="#CCCCCC" style="solid">
    
    <br />
    
    <span class="credit-card-med-no-dec-BIG"><?=$this->input['category']?></span>
    <br />
    <br />

<?}else if($this->input['listType']=='cardListing'){?>

	<table width="100%" border="0" cellpadding="0" cellspacing="5">
        <tr>

        <?if($this->input['page']){?>
            <td width="35%" valign="top" rowspan="<?=$this->input['remainingCards']+1?>">
                <table>
                    <tr>
                        <td valign="top">
                            <a href="<?=$this->input['page']->get('pageLink')?>.php" class="credit-card-med-no-dec"><img src="/images/ar2.gif" alt="<?=$this->input['page']->get('pageHeaderString')?>" width="8" height="8" hspace="5" border="0"></a>
                        </td>
                        <td valign="top">
                            <a href="<?=$this->input['page']->get('pageLink')?>.php" class="credit-card-med-no-dec"><?=$this->input['page']->get('pageHeaderString')?></a>
                        </td>
                    </tr>
                </table>
            </td>
        <?}?>

            <td width="65%" valign="top">
                <a href="<?=$this->input['card'][1]?>.php" class="credit-card-med-no-dec-no-bold"><?=$this->input['card'][0]?></a>
            </td>
        </tr>
    </table>
    
<? } //if else if ?>