<script>
function editVersion(ID, pageId){
  		document.location.href = "index.php?md=Affiliate_Merchants_Views_PageManager&action=editVersion&versionId=" + ID +"&eid=" + pageId;
		
}
</script>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
  <form action=index.php method=post name=update>
  <table border=0>
  <tr>
  <td align=center>
    <table class=listing border=0 width=770 cellspacing=0 cellpadding=1>
    <? QUnit_Templates::printFilter(3,  $_POST['action'] . " page"); ?>  
	
    <tr>
     <td align=left nowrap>&nbsp;Page Name</td>
     <td align=left>
        <input type=text name=pageName size=40 value='<?=$_POST['pageName']?>'>
     </td>
    </tr>   
    
                    <? if($_POST['active'] == 1)
						$active_checked = "checked='true'";
					?>
    
    <tr>         
      <td align="left">&nbsp;<?=L_G_ACTIVE?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<INPUT TYPE=CHECKBOX NAME=active VALUE="1" <?=$active_checked?> </INPUT>
                </td>
            </tr>
        </table>
      </td>
    </tr>
    
     <? QUnit_Templates::printFilter(3, $_POST['pageDetailLabel']. " Version Properties"); ?>  
    <? if($_POST['action'] == "update"){ ?>
    <tr>
     <td align=left nowrap>&nbsp;Change Version: </td>
     <td align=left>       
        <?=$_POST['selectExisitngVersion']?>
         <a href='index.php?md=Affiliate_Merchants_Views_PageManager&action=createVersion&eid=<?=$_POST['cardpageId']?>'>Create New Version</a>
     </td>
    </tr>    	
    <? }else if($_POST['action'] == "createVersion"){ ?>
    <tr>
     <td align=left nowrap>&nbsp;Create Version: </td>
     <td align=left>       
        <?=$_POST['pageDetailVersion']?>
     </td>
    </tr>    	
    <? } ?>    
    
    <tr>
     <td align=left nowrap>&nbsp;Page Title</td>
     <td align=left>
        <input type=text name=pageTitle size=40 value='<?=$_POST['pageTitle']?>'>
     </td>
    </tr>
    
    <tr>
     <td align=left nowrap>&nbsp;Page Header String</td>
     <td align=left>
        <input type=text name=pageHeaderString size=40 value='<?=$_POST['pageHeaderString']?>'>
     </td>
    </tr>   
    
     <tr>
     <td align=left nowrap>&nbsp;Page Header Image</td>
     <td align=left>
        <input type=text name=pageHeaderImage size=40 value='<?=$_POST['pageHeaderImage']?>'>
     </td>
    </tr>
    
    <tr>
     <td align=left nowrap>&nbsp;Page Header Image Alt Text</td>
     <td align=left>
        <input type=text name=pageHeaderImageAltText size=40 value='<?=$_POST['pageHeaderImageAltText']?>'>
     </td>
    </tr>      
    
    <tr>
     <td align=left nowrap>&nbsp;Primary Navigation String</td>
     <td align=left>
        <input type=text name=primaryNavString size=40 value='<?=$_POST['primaryNavString']?>'>
     </td>
    </tr>  
    
    <tr>
     <td align=left nowrap>&nbsp;Secondary Navigation String</td>
     <td align=left>
        <input type=text name=secondaryNavString size=40 value='<?=$_POST['secondaryNavString']?>'>
     </td>
    </tr>             
    
     <tr>
     <td align=left nowrap>&nbsp;Page Link <br>(No extension is necessary, this is defined by the site <br>i.e., citi-platinum.php would be just citi-platinum)</td>
     <td align=left>
        <input type=text name=pageLink size=40 value='<?=$_POST['pageLink']?>'>
     </td>
    </tr> 
    
	<tr>
     <td align=left nowrap>&nbsp;Site Map Title</td>
     <td align=left>
        <input type=text name=siteMapTitle size=40 value='<?=$_POST['siteMapTitle']?>'>
     </td>
    </tr>  
    
    <tr>
     <td align=left nowrap>&nbsp;Site Map Description</td>
     <td align=left>
        <input type=text name=siteMapDescription size=40 value='<?=$_POST['siteMapDescription']?>'>
     </td>
    </tr>             
    
    <tr>
     <td align=left nowrap>&nbsp;Page fid</td>
     <td align=left>
        <input type=text name=fid size=40 value='<?=$_POST['fid']?>'>
     </td>
    </tr>                
    
     <tr>
     <td align=left nowrap>&nbsp;Small Image</td>
     <td align=left>
        <input type=text name=pageSmallImage size=40 value='<?=$_POST['pageSmallImage']?>'>
     </td>
    </tr>
       
     <tr>
     <td align=left nowrap>&nbsp;Small Image Alt Text</td>
     <td align=left>
        <input type=text name=pageSmallImageAltText size=40 value='<?=$_POST['pageSmallImageAltText']?>'>
     </td>
    </tr>        
    
    <tr>
     <td align=left nowrap>&nbsp;Special Offer Image</td>
     <td align=left>
        <input type=text name=pageSpecialOfferImage size=40 value='<?=$_POST['pageSpecialOfferImage']?>'>
     </td>
    </tr>
    
    <tr>
     <td align=left nowrap>&nbsp;Special Offer Image Alt Text</td>
     <td align=left>
        <input type=text name=pageSpecialOfferImageAltText size=40 value='<?=$_POST['pageSpecialOfferImageAltText']?>'>
     </td>
    </tr>
    
    <tr>
     <td align=left nowrap>&nbsp;Special Offer Link</td>
     <td align=left>
        <input type=text name=pageSpecialOfferLink size=40 value='<?=$_POST['pageSpecialOfferLink']?>'>
     </td>
    </tr>    
    
                    <? if($_POST['flagTopPick'] == 1)
						$flag_checked = "checked='true'";
					?>
    
    <tr>         
      <td align="left">&nbsp;Flag Top Pick In Category&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<INPUT TYPE=CHECKBOX NAME=flagTopPick VALUE="1" <?=$flag_checked?></INPUT>
                </td>
            </tr>
        </table>
      </td>
    </tr>    
    
    <tr>
     <td align=left nowrap>&nbsp;Top Pick In Category Alt Text</td>
     <td align=left>
        <input type=text name=topPickAltText size=40 value='<?=$_POST['topPickAltText']?>'>
     </td>
    </tr>      
    
      <tr>
      <td align="left">&nbsp;Page Meta Keywords/Description (html)&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<TEXTAREA NAME="pageMeta" COLS=80 ROWS=6><?=$_POST['pageMeta']?></TEXTAREA>
                </td>
            </tr>
        </table>
      </td>
    </tr>   
    
    <tr>
      <td align="left">&nbsp;Page Intro Description&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<TEXTAREA NAME="pageIntroDescription" COLS=80 ROWS=6><?=$_POST['pageIntroDescription']?></TEXTAREA>
                </td>
            </tr>
        </table>
      </td>
    </tr>         
    
    <tr>
      <td align="left">&nbsp;Page Detailed Description&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<TEXTAREA NAME="pageDescription" COLS=80 ROWS=6><?=$_POST['pageDescription']?></TEXTAREA>
                </td>
            </tr>
        </table>
      </td>
    </tr>
    
    <tr>
      <td colspan=2 align="left">&nbsp;Page &quot;Learn More&quot;&nbsp;</td>
    </tr>
    <tr>
      <td colspan=2 align="left">


    				<? $_POST['editorObject']->create(); ?>

      </td>
    </tr> 
     <tr>
    	<td colspan=2>
    		<br><hr><br>
    	</td>
    </tr>   
     <tr>
      <td colspan=2 align="left">&nbsp;Page Disclaimer&nbsp;</td>
    </tr>
    <tr>
      <td colspan=2 align="left">
      <TEXTAREA NAME="pageDisclaimer" COLS=150 ROWS=10><?=$_POST['pageDisclaimer']?></TEXTAREA>

      </td>
    </tr> 
    <tr>
    	<td colspan=2>
    		<br><hr><br>
    	</td>
    </tr>
   <tr>
      <td colspan=2 align="left">&nbsp;Also See&nbsp;</td>
    </tr>
    <tr>
      <td colspan=2 align="left">


    				<? $_POST['editorObject3']->create(); ?>

      </td>
    </tr>         
         
    
    <tr>
      <td colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_PageManager'>
      <input type=hidden name=pageDetailVersion value=<?=$_REQUEST['versionId']?>>
      <input type=hidden name=action value=<?=$_POST['action']?>>
      <input type=hidden name=postaction value=<?=$_POST['action']?>>
      <input type=hidden name=eid value='<?=$_POST['cardpageId']?>'>
       <input type=hidden name=type value='<?=$_REQUEST['type']?>'>
      <input class=formbutton type=submit value="SAVE">     
      </td>
    </tr> 
    </table>
  </td>
  </tr>
  </table>
  </form>
</center>
