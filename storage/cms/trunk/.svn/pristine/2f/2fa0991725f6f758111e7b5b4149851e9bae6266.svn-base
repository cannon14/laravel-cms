<script>
function one2two() {
	m1len = m1.length ;
	m3len = m3.length;
	
    for ( i=0; i<m1len ; i++){
        if (m1.options[i].selected == true ) {
        	m2len = m2.length;
        	m2.options[m2len]= new Option(m1.options[i].text);
        	m2.options[m2len].value = m1.options[i].value;

        	m4len = m4.length;
        	m4.options[m4len]= new Option(m1.options[i].text);
        	m4.options[m4len].value = m1.options[i].value;
        }
    }

    for ( i = (m1len -1); i>=0; i--){
        if (m1.options[i].selected == true ) {
        	for ( j = (m3len -1); j>=0; j--){
        		if (m1.options[i].value == m3.options[j].value ) {
        			m3.options[j] = null;
        		}
        	}
        	
        	m1.options[i] = null;
        }
    }
}

function two2one() {
	m2len = m2.length ;
	m4len = m4.length;
        for ( i=0; i<m2len ; i++){
            if (m2.options[i].selected == true ) {
                m1len = m1.length;
                m1.options[m1len]= new Option(m2.options[i].text);
                m1.options[m1len].value = m2.options[i].value;

                m3len = m3.length;
            	m3.options[m3len]= new Option(m2.options[i].text);
            	m3.options[m3len].value = m2.options[i].value;
            }
        }
        for ( i=(m2len-1); i>=0; i--) {
            if (m2.options[i].selected == true ) {
            	for ( j = (m4len -1); j>= 0; j--){
            		if (m2.options[i].value == m4.options[j].value ) {
            			m4.options[j] = null;
            		}
            	}
            	
                m2.options[i] = null;
            }
        }
}

function excludes_one2two() {
	m5len = m5.length ;
	m7len = m7.length;
	
    for ( i=0; i<m5len ; i++){
        if (m5.options[i].selected == true ) {
        	m6len = m6.length;
        	m6.options[m6len]= new Option(m5.options[i].text);
        	m6.options[m6len].value = m5.options[i].value;

        	m8len = m8.length;
        	m8.options[m8len]= new Option(m5.options[i].text);
        	m8.options[m8len].value = m5.options[i].value;
        }
    }

    for ( i = (m5len -1); i>=0; i--){
        if (m5.options[i].selected == true ) {
        	for ( j = (m7len -1); j>=0; j--){
        		if (m5.options[i].value == m7.options[j].value ) {
        			m7.options[j] = null;
        		}
        	}
        	
        	m5.options[i] = null;
        }
    }
}

function excludes_two2one() {
	m6len = m6.length ;
	m8len = m8.length;
        for ( i=0; i<m6len ; i++){
            if (m6.options[i].selected == true ) {
                m5len = m5.length;
                m5.options[m5len]= new Option(m6.options[i].text);
                m5.options[m5len].value = m6.options[i].value;

                m7len = m7.length;
            	m7.options[m7len]= new Option(m6.options[i].text);
            	m7.options[m7len].value = m6.options[i].value;
            }
        }
        for ( i=(m6len-1); i>=0; i--) {
            if (m6.options[i].selected == true ) {
            	for ( j = (m8len -1); j>= 0; j--){
            		if (m6.options[i].value == m8.options[j].value ) {
            			m8.options[j] = null;
            		}
            	}
            	
                m6.options[i] = null;
            }
        }
}

function selectAll(){
	for (i=0; i<m4.length; i++) { 
		m4.options[i].selected = true; 
	}
	for (i=0; i<m3.length; i++) { 
		m3.options[i].selected = true; 
	}
	for (i=0; i<m7.length; i++) { 
		m7.options[i].selected = true; 
	}
	for (i=0; i<m8.length; i++) { 
		m8.options[i].selected = true; 
	}
	return true;
}
</script>
<body onload="javascript:showdiropt();return;">
    <form id="siteForm" action='index.php' method="post">
    <table class='component' align='center'>
    <tr>
    <td colspan=2 class='componentHead'>Edit Site</td>
    </tr>	
    <tr>
     <td align=left nowrap>Site Name</td>
     <td align=left>
        <input type=text name=siteName size=80 value='<?=$_POST['siteName']?>'>
     </td>
    </tr>          
      <tr>
      <td align="left">Site Title</td>
      <td align="left">
         <input type='text' name='siteTitle' size='80' value='<?= $_POST['siteTitle']?>'>     
      </td>
    </tr>
    <tr>
      <td align="left">Development URL</td>
      <td align="left">
			<input type='text' name='hostname' size='80' value='<?= $_POST['hostname']?>'>
      </td>
    </tr>
    <tr>
      <td align="left">Publish URL</td>
      <td align="left">        
			<input type='text' name='publishurl' size='80' value='<?= $_POST['publishurl']?>'>
      </td>
    </tr>        
    <tr>
      <td align="left">Language / Localization</td>
      <td align="left">
         <select name="language">
         	<option value='EN' <?= $_POST['language'] == 'EN' ? 'selected' : '' ?>>English</option>
         	<option value='SP' <?= $_POST['language'] == 'SP' ? 'selected' : '' ?>>Spanish</option>
         	<option value='FR' <?= $_POST['language'] == 'FR' ? 'selected' : '' ?>>French</option>
         	<option value='AU' <?= $_POST['language'] == 'AU' ? 'selected' : '' ?>>Australia (English)</option>
         </select>
      </td>
    </tr>
    <tr>
      <td align="left">Layout File</td>
      <td align="left">
         <input type='text' name='layout' size='80' value='<?= $_POST['layout']?>'>
      </td>
    </tr> 
    <tr>
      <td align="left">Publish Version</td>
      <td align="left">
         <select name="version_id">
         <?
			foreach($this->versions as $version) {
				echo $version . '<br/>';
         ?>
         	<option value='<?=$version['version_id']?>' <?= $_POST['version_id'] == $version['version_id'] ? 'selected' : '' ?>><?=$version['version_name']?></option>
       	 <?
			}
       	 ?>
       	 </select>
      </td>
    </tr>
    <tr>
      <td align="left">Page Extension</td>
      <td align="left">
			<select name=pagetype>
				<option></option>
				<option value='html' <?if($_POST['pagetype']=='html')echo "selected"?>>HTML</option>
				<option value='php' <?if($_POST['pagetype']=='php')echo "selected"?>>PHP</option>
			</select>  
      </td>
    </tr>
    <tr>
      <td>Build in ccbuild</td>
      <td>
			<INPUT TYPE=CHECKBOX NAME="ccbuildPublish" VALUE="1" <?=$_POST['ccbuildPublish']?'checked':''?>></INPUT>        
      </td>
    </tr>
    <tr>
      <td align="left">Publish Path</td>
      <td align="left">
         <input type='text' name='publishPath' size='80' value='<?= $_POST['publishPath']?>'>  
      </td>
    </tr>
    <tr>
      <td align="left">Source Path</td>
      <td align="left">
         <input type='text' name='sourcePath' size='80' value='<?= $_POST['sourcePath']?>'>
      </td>
    </tr>
    <tr>
      <td align="left">Core Path (Full Path From Root)</td>
      <td align="left">
         <input type='text' name='corePath' size='80' value='<?= $_POST['corePath']?>'>
      </td>
    </tr>    
    <tr>
      <td align="left">Active</td>
      <td align="left">
         <? if($_POST['active'] == 1)
            $checked = "checked='true'";
         ?>
         <INPUT TYPE=CHECKBOX NAME=active VALUE="1" <?=$checked?> />
      </td>
    </tr>
    <tr>
      <td align="left">Description</td>
      <td align="left">
         <textarea NAME="siteDescription" COLS=40 ROWS=6><?=$_POST['siteDescription']?></TEXTAREA>
      </td>
    </tr>
    <tr>
        <td colspan=2><hr></td>
    </tr>
    <tr>
        <td colspan=2 align="center"><b>Publishing</b></td>
    </tr>
    <tr>
      <td align="left">Post-Build Script</td>
      <td align="left">
         <input type='text' name='postBuildScript' size='80' value='<?= $_POST['postBuildScript']?>'>
      </td>
    </tr>      
    <tr>
      <td align="left">Sync/Publish Script</td>
      <td align="left">
         <input type='text' name='publishScript' size='80' value='<?= $_POST['publishScript']?>'>                          
      </td>
    </tr>
    <tr>
      <td align="left">FTP Address</td>
      <td align="left">
         <input type='text' name='ftpSite' size='80' value='<?= $_POST['ftpSite']?>'>
      </td>
    </tr>
    <tr>
      <td align="left">FTP Path</td>
      <td align="left">
         <input type='text' name='ftpPath' size='80' value='<?= $_POST['ftpPath']?>'>
      </td>
    </tr>
    <tr>
        <td colspan=2><hr></td>
    </tr>
    <tr>
        <td colspan=2 align="center"><b>Optional Documents</b></td>
    </tr>
    <tr>
      <td align="left">Build Site Map</td>
      <td align="left">
         <?
            $checked = $_POST['sitemap']?'checked':'';
         ?>
			<input type="checkbox" id="sitemap" name="sitemap" value="1" <?=$checked?> onClick="javascript:showdiropt('sitemap','sitemaplink');return;">
			<span id="sitemaplink">&nbsp;Site Map Link&nbsp;&nbsp;<input type=text name="sitemaplink" value=<?=$_POST['sitemaplink']?>></span>
      </td>
    </tr>
    <tr>
      <td align="left">Path to Article Portion of Site Map</td>
      <td align="left">
         <input type=text name="articleSiteMapFile" value="<?=$_POST['articleSiteMapFile']?>" size="35" maxlength="255">
      </td>
    </tr>
    <tr>
      <td align="left">Path to Google Article XML File</td>
      <td align="left">
         <input type=text name="googleArticleFile" value="<?=$_POST['googleArticleFile']?>" size="35" maxlength="255">
      </td>
    </tr>
    <tr>
      <td align="left">Path to Yahoo Article Text File</td>
      <td align="left">
         <input type=text name="yahooArticleFile" value="<?=$_POST['yahooArticleFile']?>" size="35" maxlength="255">
      </td>
    </tr>
    <tr>
      <td align="left">Path to Yahoo Article Category Text File</td>
      <td align="left">
         <input type=text name="yahooArticleCategoryFile" value="<?=$_POST['yahooArticleCategoryFile']?>" size="35" maxlength="255">
      </td>
    </tr>
    <tr>
      <td align="left">Build Individual Card Pages</td>
      <td align="left">
      		<select name="individualcards">
          		<option value=0 <?= $_POST['individualcards'] == 0 ? 'selected' : '';?>>None</option>
          		<option value=1 <?= $_POST['individualcards'] == 1 ? 'selected' : '';?>>Individual Page</option>
          	</select>
      		Directory Name&nbsp;&nbsp;<input type=text name="individualcarddir" value=<?=$_POST['individualcarddir']?>>
      </td>
    </tr> 
    <tr>
      <td align="left">Build Alternative Card Pages</td>
      <td align="left">
         <? $checked = $_POST['alternativecardpages'] == 1?"checked='true'":'';?>
			<INPUT TYPE=CHECKBOX NAME=alternativecardpages VALUE="1" <?=$checked?></input>
      Directory Name&nbsp;&nbsp;<input type=text name="alternativecardpagesdir" value=<?=$_POST['alternativecardpagesdir']?>>
      </td>
    </tr>        
    <tr>
      <td align="left">Build Individual Merchant Service Pages</td>
      <td align="left">
          <select name="individualmerchantservices">
          		<option value=0 <?= $_POST['individualmerchantservices'] == 0 ? 'selected' : '';?>>None</option>
          		<option value=1 <?= $_POST['individualmerchantservices'] == 1 ? 'selected' : '';?>>Individual Page</option>
          	</select>
         &nbsp;&nbsp;Directory Name&nbsp;&nbsp;<input type=text name="individualmerchantservicesdir" value=<?=$_POST['individualmerchantservicesdir']?>>
      </td>
    </tr>          
    <tr>
      <td align="left">Build SEO Documents</td>
      <td align="left">
         <? $checked = $_POST['createSeoDoc'] == 1?"checked='true'":'';?>
			<INPUT TYPE=CHECKBOX NAME=createSeoDoc VALUE="1" <?=$checked?></INPUT>
      </td>
    </tr>
    <tr>
      <td align="left">Landing Page Directory&nbsp;(Path from site root)</td>
      <td align="left">
         <input type=text value="<?=$_POST['landingPageDir']?>" name=landingPageDir size=80>
      </td>
    </tr>
    
    <tr>
    	<td colspan=2><hr></td>
	<tr>
		<td colspan="2">
		<table align='center'>
			<tr>
				<td align="center" width='50%' colspan="2"><b>Non-Historical Cards</b></td>
				<td colspan="2" align="center" width='50%'><b>Recent Cards (Added in the last 5 days)</b></td>
			</tr>
			<tr>
				<td width='50%' colspan="2">
				<select name='unassignedCardsFacade[]' id='unassignedCardsFacade' style="width: 400px" size="10" multiple>
					<?foreach($this->unassignedCards as $card){ ?>
					<option value="<?=$card['cardId']?>"><?=$card['cardTitle'] . ' (' . $card['cardId'] . ')'?></option>
					<? } ?>
				</select>
				<select name='unassignedCards[]' id="unassignedCards" style="display: none" multiple></select>
				<br>
				<p align="center"><input class="formbutton" type="button"
					onclick="one2two()" value=" Add to history >> "></p>
				</td>
				
				<td align="center" colspan="2" width='50%'>
					<select name='recentlyAssignedCardsFacade[]' id='recentlyAssignedCardsFacade' style="width: 400px"
					size="10" multiple>
					<?foreach($this->recentlyAssignedCards as $card){ ?>
					<option value="<?=$card['cardId']?>"><?=$card['cardTitle'] . '(' . $card['cardId'] . ')'?></option>
					<? } ?>
				</select>
				<select name='recentlyAssignedCards[]' id="recentlyAssignedCards" style="display: none" multiple></select>
				<br>
				<p align="center"><input class="formbutton" type="button"
					onclick="two2one()" value=" << Remove from history"></p>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="4"><b>All Historical Cards</b></td>
			</tr>
			<tr>
				<td align="center" colspan="4">
					<textarea 
						id='assignedCards' 
						style="width: 100%" 
						rows="10px" 
						readonly><?foreach($this->assignedCards as $card){ print $card['cardTitle'] . " (" . $card['cardId'] . ")\n";	}?></textarea> 
				</td>
			</tr>
		</table>
	</td>
</tr>
			
			
			
			
			
			
			<tr>
    			<td colspan="2"><hr></td>
    		</tr>
			<tr>
				<td colspan="2" align="center"><b>Card Exclusions</b></td>
			</tr>
			<tr>
				<td colspan="2">
    				<table align='center'>
    					<tr>
    						<td align="center" width='50%' colspan="2"><b>Non-excluded Cards</b></td>
    						<td colspan="2" align="center" width='50%'><b>Excluded Cards</b></td>
    					</tr>
    					<tr>
    						<td width='50%' colspan="2">
    							<select name='nonExcludedFacade[]' id='nonExcludedFacade' size="10" multiple>
        							<?foreach($this->nonExcluded as $card){ ?>
        							<option value="<?=$card['cardId']?>"><?=$card['cardTitle']?></option>
        							<? } ?>
    							</select>
    							<select name='nonExcluded[]' id='nonExcluded' style="display: none" multiple></select>
    							<br>
    							<p align="center"><input class="formbutton" type="button" onclick="excludes_one2two()" value=" Assign >> "></p>
    						</td>
    
    						<td align="center" colspan="2" width='50%'>
    							<select name='excludedFacade[]' id='excludedFacade' size="10" multiple>
        							<?foreach($this->excluded as $card){ ?>
        							<option value="<?=$card['cardId']?>"><?=$card['cardTitle']?></option>
        							<? } ?>
    							</select>
    							<select name='excluded[]' id='excluded' style="display: none" multiple></select>
    							<br>
    							<p align="center"><input class="formbutton" type="button" onclick="excludes_two2one()" value=" << Remove "></p>
    						</td>
    					</tr>
    				</table>
				</td>
			</tr>
			
			
			
			
			
			
			
			
		
	<tr>
    	<td colspan=2><hr></td>
    </tr> 
    <tr>
      <td colspan=2 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=mod value='<?=$_REQUEST['mod']?>'>
      <input type=hidden name=action value='update'>
      <input type=hidden name=postaction value='update'>
      <input type=hidden name=siteId value='<?=$_POST['siteId']?>'>
      <input  type=submit value="UPDATE" onClick="selectAll(); document.getElementById('siteForm').submit();">
      <input class=formbutton type=button value="CANCEL" onClick="goToMod('<?=$_REQUEST['mod']?>')">     
      </form>
      </td>
    </tr> 
 </table>
<script>
var m1 = document.getElementById('unassignedCardsFacade');
var m2 = document.getElementById('recentlyAssignedCardsFacade');
var m3 = document.getElementById('unassignedCards');
var m4 = document.getElementById('recentlyAssignedCards');

var m5 = document.getElementById('nonExcludedFacade');
var m6 = document.getElementById('excludedFacade');
var m7 = document.getElementById('nonExcluded');
var m8 = document.getElementById('excluded');

showdiropt('sitemap', 'sitemaplink');
</script>