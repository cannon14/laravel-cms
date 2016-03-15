<?
require('tracking_filter.tpl.php');
// Changed to alter table header text.  - mz
// $capKeyword = ucfirst($_REQUEST['mode']);
$capKeyword = 'EPC';
$singCapKeyword = substr(ucfirst($capKeyword), 0, strlen($capKeyword)-1);
$list_page = (int)$_REQUEST['list_page'];
$sortby = $_REQUEST['sortby'];
$sortorder= $_REQUEST['sortorder'];
$search = $_REQUEST['search'];

if(isset($_REQUEST['alphabetFilter']))
{
   $alphabetFilter = $_REQUEST['alphabetFilter'];
}
else
{
   $alphabetFilter = '';
}
?>

    <input type="hidden" name=filtered value=1>
    <input type="hidden" name=md value='Affiliate_Merchants_Views_TrackingManager'>
    <input type="hidden" name=type value='all'>
    <input type="hidden" id=list_page name=list_page value='<?= $list_page; ?>'>
    <input type="hidden" id=action name=action value=''>    
    <input type="hidden" id=mode name=mode value='<?=$_REQUEST['mode']?>'>    
    <input type="hidden" id=sortby name=sortby value="<?= $sortby; ?>">
    <input type="hidden" id=sortorder name=sortorder value="<?= $sortorder; ?>">
    <input type="hidden" name="alphabetFilter" value="<?= $alphabetFilter; ?>">
      
</form>

<script language="JavaScript">
function validateEpcForm()
{
   var elem = document.forms['frmEpcEdit'].elements;
   var numElements = elem.length;
   var invalidDataFound = false;

   for(y=0; y<numElements; y++)
   {           
      if(elem[y].name.substring(0, 15) == 'txtEpcOverride_')
      {
         if(IsNumeric(elem[y].value) == false)
         {
            elem[y].style.backgroundColor = '#FFFF99';
            invalidDataFound = true;            
         }
      }
   }   

   if(invalidDataFound == true)
   {
      alert('Sorry, all EPC Override values must be numeric.');
   }
   else
   {
      document.forms['frmEpcEdit'].submit();
   }   
}

// checks for numeric input
function IsNumeric(strString) 
{       
   var strValidChars = "0123456789.";
   var strChar;
   var blnResult = true;

   if (strString.length == 0) return false;

   // test strString consists of valid characters listed above
   for (i = 0; i < strString.length && blnResult == true; i++)
   {
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1)
      {
         blnResult = false;
      }
   }
   return blnResult;
}

/*
* Author: mz
* Date:   12/19/07
* Desc:   prompts the user to confirm they want to update EPC rates
*/
function updateEpcRates()
{
   if(confirm('You are about to update the database permenently.\nAre you sure you wish to continue?') == true)
   {
      document.forms['frmEpcEdit'].action = "./index.php?md=Affiliate_Merchants_Views_TrackingManager&mode=epcedit&action=edit&subaction=updateEpcRates&list_page=<? print $list_page; ?>&sortorder=<? print $sortorder; ?>&sortby=<? print $sortby; ?>&search=<? print $search; ?>";
      document.forms['frmEpcEdit'].submit();
   }
       
}

/*
* Author: mz
* Date:   1/2/08
* Desc:   copied from other files, aides in filtering products by a chosen letter.
*/
function filterByAlphabet(ID)
{
   //frm = document.getElementById("FilterForm");
   // alert(frm.action.value);
   // frm.search.value = ID;
   // frm.action.value .= '&alphabetFilter='+ID;
   // frm.alphabetFilter.value = ID;
   
   document.forms["frmEpcEdit"].action = "./index.php?md=Affiliate_Merchants_Views_TrackingManager&mode=epcedit&action=edit&alphabetFilter="+ID;
   document.forms["frmEpcEdit"].submit();
}
</script>

<form name="frmEpcEdit" action="./index.php?md=Affiliate_Merchants_Views_TrackingManager&mode=epcedit&action=edit&list_page=<? print $list_page; ?>&sortorder=<? print $sortorder; ?>&sortby=<? print $sortby; ?>&alphabetFilter=<? print $alphabetFilter; ?>" method="post">
    <table class=listingClosed border=0 cellspacing=0 cellpadding=0>
    <? QUnit_Templates::printFilter(1,$capKeyword." ".L_G_RT_TRACKING); ?>
    <tr>
       <td class=actionheader colspan="9">
            <div style="text-align: center;">
              <?
                  $alphabet = array();
                  for ($i=65; $i<=90; $i++) {
                  $alphaLink = '<a href="javascript:filterByAlphabet(\'' . chr($i) . '\');">' . chr($i) . '</a>';
                  
                  array_push($alphabet, $alphaLink);
               }
               print(implode(' | ', $alphabet));
               ?>
               &nbsp;&nbsp;&nbsp;&nbsp;
               <input type="button" value="Show All" onclick="javascript:filterByAlphabet('All');">
            </div>
       </td>
    </tr>  
    <tr>
        <td class=listPaging>
            <? QUnit_Templates::printPaging($this->a_list_page, $this->a_list_pages, $this->a_allcount); ?>
        </td>                    
    </tr>
    <tr>
        <td align=left>
        <table width="100%" cellspacing="0" cellpadding="1">                      
        <tr class=listheader>
            <?
               // passing false to remove check-all header column. - mz
               $this->a_this->printListHeader(false);
            ?>
        </tr>       
<?
        while($row = $this->a_list_data->getNextRecord())
        {    
            if($row['epc_rate'] == '')
            {
               $style='style="color:red;"';
            }
            else if ($row['use_override'] == 1)
            {             
               $style='style="color:#F87217;"';               
            }
            else
            {
               $style='';
            }            
?>    
        <tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';" <? print $style; ?>>
            <? $this->a_this->printListRow($row); ?>
        </tr>
<?      
         }
?>
        </table>        
        </td>
    </tr>
    </table>
    <div id="submitButtonDiv">
    <br>
    <? $this->a_this->printButton('Save Changes', 'javascript:validateEpcForm();'); ?>
    </div>    
</form>
<br>
<br>