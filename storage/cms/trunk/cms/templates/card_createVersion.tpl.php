<br><br>
<form action=index.php method=post name=update>
<table class=component align='center'>
    <tr>
    <td colspan=2 class='componentHead'>
    <?if ($_POST['edit'] == true){ ?>Edit Version<?}else{ ?> Create Version <? } ?>
    </td>
    </tR>
		  

<? if($_POST['action'] == 'createVersion'){ ?>
    <tr>
      <td align="left">&nbsp;<b>Version Name&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<SELECT NAME=cardDetailVersion>
					<option value='_'>Select a Page
					<?
					$rs = $_POST['rs_sites'];
					while(!$rs->EOF){
						
						?>
							<option value="<?=$rs->fields['siteId']?>"><?=$rs->fields['siteName']?></option>
						<?
						$rs->MoveNext();
					}
					?>
					</SELECT>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>     
<? } ?>
        <tr>
      <td align="left">&nbsp;<b>Card Link</b><br>(No extension is necessary, this is defined by the site <br>i.e., citi-platinum.php would be just citi-platinum)&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardLink' size='100' value="<?= $_POST['cardLink']?>">                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<b>Application Link</b>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='appLink' size='100' value="<?= $_POST['appLink']?>">                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    
     <tr>
      <td align="left">&nbsp;<b>Card Listing String&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardListingString' size='100' value="<?= $_POST['cardListingString']?>">                          
                </td>
            </tr>
        </table>
      </td>
    </tr> 

     <tr>
      <td align="left">&nbsp;<b>Card's Page Header String&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardPageHeaderString' size='100' value="<?= $_POST['cardPageHeaderString']?>">                          
                </td>
            </tr>
        </table>
      </td>
    </tr>  
    
    <tr>
      <td align="left">&nbsp;<b>fid&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='fid' size='100' value="<?= $_POST['fid']?>">                          
                </td>
            </tr>
        </table>
      </td>
    </tr>  
    
    <tr>
      <td align="left">&nbsp;<b>Category Image&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='categoryImage' size='100' value="<?= $_POST['categoryImage']?>">                          
                </td>
            </tr>
        </table>
      </td>
    </tr>           
    <tr>
      <td align="left">&nbsp;<b>Category Image Alt Text&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='categoryAltText' size='100' value="<?= $_POST['categoryAltText']?>">                          
                </td>
            </tr>
        </table>
      </td>
    </tr>  
    
    <tr>
      <td align="left">&nbsp;<b>Listing Apply Button Alt Text&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardButtonAltText' size='100' value="<?= $_POST['cardButtonAltText']?>">                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    
    <tr>
      <td align="left">&nbsp;<b>Individual Offer Apply Button Alt Text&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardIOButtonAltText' size='100' value="<?= $_POST['cardIOButtonAltText']?>">                          
                </td>
            </tr>
        </table>
      </td>
    </tr>          
           
    <tr>
      <td align="left">&nbsp;<b>Individual Offer Card Image Alt Text&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardIOAltText' size='100' value="<?= $_POST['cardIOAltText']?>">                          
                </td>
            </tr>
        </table>
      </td>
    </tr>   
    
    <tr>
      <td align="left">&nbsp;<b>Small Card Icon&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardIconSmall' size='100' value="<?= $_POST['cardIconSmall']?>">                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<b>Med Card Icon&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardIconMid' size='100' value="<?= $_POST['cardIconMid']?>">                          
                </td>
            </tr>
        </table>
      </td>
    </tr> 
    <tr>
      <td align="left">&nbsp;<b>Large Card Icon&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardIconLarge' size='100' value="<?= $_POST['cardIconLarge']?>">                          
                </td>
            </tr>
        </table>
      </td>
    </tr>  
    <tr>
    <td colspan=2><br><hr><br></td>
    </tr>
    <tr>
      <td align="left">&nbsp;<b>Card Teaser&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<textarea name='cardTeaserText' cols=50 rows=3><?= $_POST['cardTeaserText']?></textarea>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<b>Specials Additional Offer Link Text&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<textarea name='specialsAdditionalLink' cols=50 rows=10><?= $_POST['specialsAdditionalLink']?></textarea>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left" colspan=2>&nbsp;<b>Specials Description Text</b>&nbsp;<br><br>
		<? $_POST['editorObject4']->create(); ?>
      </td>
    </tr>    
    <tr>
    <td colspan=2><br><hr><br></td>
    </tr>
    <tr>
      <td align="left" colspan=2>&nbsp;<b>Card Page Meta</b>&nbsp;<br><br>
      <textarea rows=10 cols=90 name="cardPageMeta"><?=$_POST['cardPageMeta']?></textarea>
      </td>
    </tr>
    <tr>
      <td align="left" colspan=2>&nbsp;<b>Card Detail Text</b>&nbsp;<br><br>


    				<?= $_POST['editorObject1']->Value; ?>

      </td>
    </tr>
    <tr>
    <td colspan=2><br><hr><br></td>
    </tr>    
    <tr>
      <td align="left" colspan=2>&nbsp;<b>Card Intro Detail</b>&nbsp;<br><br>


    				<? $_POST['editorObject2']->create(); ?>

      </td>
    </tr> 
    <tr>
    <td colspan=2><br><hr><br></td>
    </tr>
      <tr>
      <td align="left" colspan=2>&nbsp;<b>Card More Detail</b>&nbsp;<br><br>


    				<? $_POST['editorObject3']->create(); ?>

      </td>
    </tr> 
           
   
                          
    <tr>
      <td colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=mod value="<?=$_REQUEST['mod']?>">
      <input type=hidden name=action value="<?=$_POST['action']?>">
      <input type=hidden name=postaction value="<?=$_POST['action']?>">
      <input type=hidden name=cardId value="<?=$_POST['cardId']?>">
      <? if($_POST['action'] != 'createVersion'){ ?>
      <input type=hidden name=versionId value="<?=$_POST['versionId']?>">
      <? } ?>
      <input class=formbutton type=submit value="SAVE">    
      <input class=formbutton type=button value="CANCEL" onClick="goToMod('<?=$_REQUEST['mod']?>')">     
       
      </td>
    </tr> 
    </table>
  </td>
  </tr>
  </table>
  </form>

