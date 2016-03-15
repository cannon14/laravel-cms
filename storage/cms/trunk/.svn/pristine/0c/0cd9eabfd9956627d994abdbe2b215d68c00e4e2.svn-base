<br><br>
<form action=index.php method=post name=update>
<table class=component align='center'>
    <tr>
    <td colspan=2 class='componentHead'>
    <?=$_POST['edit'] == true?'Edit Version':'Create Version'?>
    </td>
    </tr>	  

<?if($_POST['action'] == 'createVersion'){?>
    <tr>
      <td align="left">&nbsp;<b>Version Name&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<SELECT NAME="merchantServiceDetailVersion"               
						<option value='_'>Select a Page</option>
    					<?
    					$rs = $_POST['rs_sites'];
    					while(!$rs->EOF){
    						
    						?>
    							<option value="<?=$rs->fields['siteId']?>" 
    							        <?= isset($_POST['merchantServiceDetailVersion']) && $_POST['merchantServiceDetailVersion'] ==  $rs->fields['siteId'] ? 
    							        'selected' 
    							        : '';?>
    							 ><?=$rs->fields['siteName']?></option>
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
  <td class='componentHead' colspan=2>
  Default Version Properties
  </td>
  </tr>
   <tr>
      <td align="left">&nbsp;<b>Image Path&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='merchantServiceImagePath' size='50' value='<?= $_POST['merchantServiceImagePath']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>       
    <tr>
      <td align="left">&nbsp;<b>Merchant Service Link</b><br>(No extension is necessary, this is defined by the site <br>i.e., merchantX.php would be just merchantX)&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='merchantServiceLink' size='40' value='<?= $_POST['merchantServiceLink']?>'>                          
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
					<input type='text' name='appLink' size='40' value='<?= $_POST['appLink']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    
     <tr>
      <td align="left">&nbsp;<b>Merchant Service Header String&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='merchantServiceHeaderString' size='30' value='<?= $_POST['merchantServiceHeaderString']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    
    <tr>
      <td align="left">&nbsp;<b>Category Image Path&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='categoryImagePath' size='30' value='<?= $_POST['categoryImagePath']?>'>                          
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
					<input type='text' name='categoryImageAltText' size='30' value='<?= $_POST['categoryImageAltText']?>'>                          
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
					<input type='text' name='fid' size='30' value='<?= $_POST['fid']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>  
    
    <tr>
      <td align="left">&nbsp;<b>Apply Button Alt Text&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='applyButtonAltText' size='30' value='<?= $_POST['applyButtonAltText']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>         
           
    <tr>
      <td align="left">&nbsp;<b>Merchant Service Image Alt Text&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='merchantServiceImageAltText' size='30' value='<?=$_POST['merchantServiceImageAltText']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>   


	<tr>
		<td><b>Merchant Service Page Meta</b></td>
		<td><textarea name='pageMeta' cols="50" rows="10"><?= $_POST['pageMeta'] ?></textarea></td>
	</tr> 
	
	<tr>
		<td><b>Merchant Service Page Disclaimer</b></td>
		<td><textarea name='disclaimer' cols="50" rows="10"><?= $_POST['disclaimer'] ?></textarea></td>
	</tr> 






    <tr>
    <td colspan=2><br><hr><br></td>
    </tr>  	
    <tr>
      <td align="left" colspan=2>&nbsp;<b>Merchant Service Detail Text</b>&nbsp;<br><br>


    				<? $_POST['editorObject1']->create(); ?>

      </td>
    </tr> 
    <tr>
    <td colspan=2><br><hr><br></td>
    </tr>    
    <tr>
      <td align="left" colspan=2>&nbsp;<b>Merchant Service Intro Detail</b>&nbsp;<br><br>


    				<? $_POST['editorObject2']->create(); ?>

      </td>
    </tr> 
    <tr>
    <td colspan=2><br><hr><br></td>
    </tr>
      <tr>
      <td align="left" colspan=2>&nbsp;<b>Merchant Service More Detail</b>&nbsp;<br><br>


    				<? $_POST['editorObject3']->create(); ?>

      </td>
    </tr> 
           
    <tr>
    <td colspan=2><br><hr><br></td>
    </tr>
           
   
                          
    <tr>
      <td colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=mod value="<?=$_REQUEST['mod']?>">
      <input type=hidden name=action value="<?=$_POST['action']?>">
      <input type=hidden name=postaction value="<?=$_POST['action']?>">  
      <input type=hidden name=merchantServiceId value="<?=$_POST['merchantServiceId']?>">
      <? if($_POST['action'] != 'createVersion'){ ?>
      	<input type=hidden name=versionId value="<?=$_POST['versionId']?>">
      	<input type=hidden name=merchantServiceDetailVersion value="<?=$_POST['merchantServiceDetailVersion']?>">
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