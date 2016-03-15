<script>
function one2two(list1, list2) {
	list1len = list1.length ;
    for ( i=0; i<list1len ; i++){
        if (list1.options[i].selected == true ) {
        	list2len = list2.length;
        	list2.options[list2len]= new Option(list1.options[i].text);
        	list2.options[list2len].value = list1.options[i].value;
        }
    }

    for ( i = (list1len -1); i>=0; i--){
        if (list1.options[i].selected == true ) {
        	list1.options[i] = null;
        }
    }
}

function two2one(list1, list2) {
	list2len = list2.length ;
        for ( i=0; i<list2len ; i++){
            if (list2.options[i].selected == true ) {
                list1len = list1.length;
                list1.options[list1len]= new Option(list2.options[i].text);
                list1.options[list1len].value = list2.options[i].value;
            }
        }
        for ( i=(list2len-1); i>=0; i--) {
            if (list2.options[i].selected == true ) {
                list2.options[i] = null;
            }
        }
}

function selectAll(){
	for (i=0; i<m2.length; i++) { 
		m2.options[i].selected = true; 
	}
	for (i=0; i<m1.length; i++) { 
		m1.options[i].selected = true; 
	}
	for (i=0; i<m3.length; i++) { 
		m3.options[i].selected = true; 
	}
	for (i=0; i<m4.length; i++) { 
		m4.options[i].selected = true; 
	}
	return true;
}
</script>
    
    <form id="siteForm" action='index.php' method="post">
    <table class='component' align='center'>
	<tr>
	<td class='componentHead' colspan=2>
	Create Site
	</td>
	</tr>	
    <tr>
     <td>Site Name</td>
     <td>
        <input type=text name=siteName size=80 value=''>
     </td>
    </tr>          
      <tr>
      <td>Site Title</td>
      <td>
        <input type='text' name='siteTitle' size='80' value=''>       
      </td>
    </tr>
    <tr>
      <td>Development URL</td>
      <td>
         <input type='text' name='hostname' size='80' value=''>                          
      </td>
    </tr>
	<tr>
      <td>Publish URL</td>
      <td>
         <input type='text' name='publishurl' size='80' value=''>
      </td>
    </tr> 
    <tr>
      <td align="left">Language / Localization</td>
      <td align="left">
         <select name="language">
         	<option value='EN'>English</option>
         	<option value='SP'>Spanish</option>
         	<option value='FR'>French</option>
         	<option value='AU'>Australia (English)</option>
         </select>
      </td>
    </tr>
    <tr>
      <td>Layout File</td>
      <td>
         <input type='text' name='layout' size='80' value=''>
      </td>
    </tr>
    <tr>
      <td align="left">Version</td>
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
      <td>Page Extension</td>
      <td>
         <select name=pagetype>
			   <option></option>
				<option value='html'>HTML</option>
				<option value='php'>PHP</option>  
			</select>
      </td>
    </tr>
    <tr>
      <td>Build in ccbuild</td>
      <td>
         <INPUT TYPE=CHECKBOX NAME="ccbuildPublish" VALUE="1" checked='false'></INPUT>
      </td>
    </tr>
    <tr>
      <td>Publish Path</td>
      <td>
         <input type='text' name='publishPath' size='80' value=''>
      </td>
    </tr>
    <tr>
      <td>Source Path</td>
      <td>
         <input type='text' name='sourcePath' size='80' value=''>
      </td>
    </tr> 
    <tr>
      <td>Core Path (Full Path From Root)</td>
      <td>
         <input type='text' name='corePath' size='80' value=''>
      </td>
    </tr>     
    <tr>
		<td>Active</td>
    	<td><INPUT TYPE=CHECKBOX NAME=active VALUE="1" checked='true'</INPUT></td>
    </tr>
    <tr>
      <td>Description</td>
      <td>
         <TEXTAREA NAME="siteDescription" COLS=80 ROWS=6></TEXTAREA>
      </td>
    </tr>
    <tr>
        <td colspan=2><hr></td>
    </tr>
    <tr>
        <td colspan=2 align="center"><b>Publishing</b></td>
    </tr>
    <tr>
      <td>Post-Build Script</td>
      <td>
         <input type='text' name='postBuildScript' size='80' value=''>
      </td>
    </tr> 
    <tr>
      <td>Sync/Publish Script</td>
      <td>
         <input type='text' name='publishScript' size='80' value=''>
      </td>
    </tr>
    <tr>
      <td>FTP Address</td>
      <td>
         <input type='text' name='ftpSite' size='80' value=''>
      </td>
    </tr>
    <tr>
      <td>FTP Path</td>
      <td>
         <input type='text' name='ftpPath' size='80' value=''>
      </td>
    </tr>
    <tr>
        <td colspan=2><hr></td>
    </tr>
    <tr>
        <td colspan=2><hr></td>
    </tr>
    <tr>
        <td colspan=2 align="center"><b>Optional Documents</b></td>
    </tr>
    <tr>
      <td>Build Site Map</td>
      <td>
         <INPUT TYPE=CHECKBOX ID="sitemap" NAME="sitemap" VALUE="1" onClick="javascript:showdiropt('sitemap','sitemaplink');return;">
         <span id="sitemaplink">
         	&nbsp;Site Map Link&nbsp;
         	<input type=text name="sitemaplink" value=''>
         </span>
      </td>
    </tr>  
    <tr>
      <td align="left">Path to Article Portion of Site Map</td>
      <td align="left">
         <input type=text name="articleSiteMapFile" value="" size="35" maxlength="255">
      </td>
    </tr>
    <tr>
      <td align="left">Path to Google Article XML File</td>
      <td align="left">
         <input type=text name="googleArticleFile" value="" size="35" maxlength="255">
      </td>
    </tr>
    <tr>
      <td align="left">Path to Yahoo Article Text File</td>
      <td align="left">             
         <input type=text name="yahooArticleFile" value="" size="35" maxlength="255">
      </td>
    </tr>      
    <tr>
      <td align="left">Path to Yahoo Article Category Text File</td>
      <td align="left">             
         <input type=text name="yahooArticleCategoryFile" value="" size="35" maxlength="255">
      </td>
    </tr>      
    <tr>
      <td align="left">Build Individual Card Pages</td>
      <td align="left">
      	<select name="individualcards">
      		<option value=0>None</option>
      		<option value=1>Regular Page</option>
      		<option value=2>Extended Page</option>
      	</select>
      &nbsp;&nbsp;Directory Name&nbsp;&nbsp;<input type=text name="individualcarddir" value="">
      </td>
    </tr> 
    <tr>
      <td align="left">Build Alternative Card Pages</td>
      <td align="left">
         <? $checked = $_POST['alternativecardpages'] == 1?"checked='true'":'';?>
			<INPUT TYPE=CHECKBOX NAME=alternativecardpages VALUE="1" <?=$checked?></INPUT>
      Directory Name&nbsp;&nbsp;<input type=text name="alternativecardpagesdir" value=<?=$_POST['alternativecardpagesdir']?>>
      </td>
    </tr>         
    <tr>
      <td align="left">Build Individual Merchant Service Pages</td>
      <td align="left">
          <select name="individualmerchantservices">
          		<option value=0>None</option>
          		<option value=1>Regular Page</option>
          		<option value=2>Extended Page</option>
          	</select>
         &nbsp;&nbsp;Directory Name&nbsp;&nbsp;<input type=text name="individualmerchantservicesdir" value="">
      </td>
    </tr>               
    <tr>
        <td>Build SEO Documents</td>
        <td>
            <INPUT TYPE=CHECKBOX NAME=createSeoDoc VALUE="1" />            
        </td>
    </tr>
    <tr>
      <td align="left">&nbsp;Landing Page Directory&nbsp;(Path from site root)</td>
      <td align="left">
         <input type=text value="" name=landingPageDir size=80>
      </td>
    </tr>
    <tr>
    	<td colspan=2><hr></td>
    </tr>
    

	<tr>
		<td colspan="2">
		<table align='center'>
			<tr>
				<td align="center" width='50%' colspan="2"><b>Non-Historical Cards</b></td>
				<td colspan="2" align="center" width='50%'><b>Historical Cards</b></td>
			</tr>
			<tr>
				<td width='50%' colspan="2">
				<select name='unassignedCards[]'
					id='unassignedCards' style="width: 400px" size="10" multiple>
					<?foreach($this->unassignedCards as $card){ ?>
					<option value="<?=$card['cardId']?>"><?=$card['cardTitle'] . ' (' . $card['cardId'] . ')'?></option>
					<? } ?>
				</select> <br>
				<p align="center"><input class="formbutton" type="button"
					onclick="one2two(m1, m2)" value=" Add to history >> "></p>
				</td>
				
				<td align="center" colspan="2" width='50%'>
					<select name='assignedCards[]' id='assignedCards' style="width: 400px"
					size="10" multiple>
					<?foreach($this->assignedCards as $site){ ?>
					<option value="<?=$card['cardId']?>"><?=$card['cardTitle'] . '(' . $card['cardId'] . ')'?></option>
					<? } ?>
				</select> <br>
				<p align="center"><input class="formbutton" type="button"
					onclick="two2one(m1, m2)" value=" << Remove from history "></p>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
		<table align='center'>
			<tr>
				<td align="center" width='50%' colspan="2"><b>Non-Excluded Cards</b></td>
				<td colspan="2" align="center" width='50%'><b>Excluded Cards</b></td>
			</tr>
			<tr>
				<td width='50%' colspan="2">
    				<select name='nonExcluded[]' id='nonExcluded' style="width: 400px" size="10" multiple>
    					<?foreach($this->nonExcluded as $card){ ?>
    					<option value="<?=$card['cardId']?>"><?=$card['cardTitle'] . ' (' . $card['cardId'] . ')'?></option>
    					<? } ?>
    				</select> <br>
    				<p align="center"><input class="formbutton" type="button" onclick="one2two(m3, m4)" value=" Assign >> "></p>
				</td>
				
				<td align="center" colspan="2" width='50%'>
					<select name='excluded[]' id='excluded' style="width: 400px" size="10" multiple></select>
					<br>
					<p align="center"><input class="formbutton" type="button" onclick="two2one(m3, m4)" value=" << Remove "></p>
				</td>
			</tr>
		</table>
		</td>
	</tr>	
			
			
			
			
			
    <tr>
      <td colspan=3 align=center>
         <input type=hidden name=commited value=yes>
         <input type=hidden name=mod value='<?=$_REQUEST['mod']?>'>
         <input type=hidden name=action value='update'>
         <input type=hidden name=postaction value='create'>
         <input type=hidden name=siteId value='<?=isset($_POST['siteId']) ? $_POST['siteId'] : ''?>'>
         <input class=formbutton type=submit onClick="selectAll(); document.getElementById('siteForm').submit();" value="CREATE"> 
   	   <input class=formbutton type=button value="CANCEL" onClick="goToMod('<?=$_REQUEST['mod']?>')">   
      </td>
    </tr> 
    </table>
  </form>
<script>
var m1 = document.getElementById('unassignedCards');
var m2 = document.getElementById('assignedCards');
var m3 = document.getElementById('nonExcluded');
var m4 = document.getElementById('excluded');
showdiropt('sitemap', 'sitemaplink');
</script>