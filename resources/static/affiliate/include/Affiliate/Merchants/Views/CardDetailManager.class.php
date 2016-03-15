<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
require('../../include/QUnit/Graphics/FCKeditor/FCKeditor.php');
QUnit_Global::includeClass('QUnit_UI_ListPage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Cards');

class Affiliate_Merchants_Views_CardDetailManager extends QUnit_UI_ListPage
{

    //--------------------------------------------------------------------------    

    function initPermissions()
    {
//        $this->modulePermissions['approvetrans'] = 'aff_trans_transactions_approvedecline';
//        $this->modulePermissions['denytrans'] = 'aff_trans_transactions_approvedecline';
//        $this->modulePermissions['create'] = 'aff_trans_transactions_modify';
//        $this->modulePermissions['edit'] = 'aff_trans_transactions_modify';
//        $this->modulePermissions['suppress'] = 'aff_trans_transactions_approvedecline';
//        $this->modulePermissions['approve'] = 'aff_trans_transactions_approvedecline';
//        $this->modulePermissions['delete'] = 'aff_trans_transactions_modify';
//        $this->modulePermissions['view'] = 'aff_trans_transactions_view';
    }

    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_POST['commited']))
        {
            switch($_POST['postaction'])
            {

               case 'update':
                    if($this->processUpdateCard())
                        return;
                    break;
					
               case 'updateVersion':
                    if($this->processUpdateVersion())
                        return;
                    break;
										
               case 'createVersion':
                    if($this->processCreateVersion())
                        return;
                    break;	
					
				case 'create':
                    if($this->processCreateCard())
                        return;
                    break;				
            }
        }
        else if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'editVersion':
					
					$this->loadVersionInfo();
                    if($this->drawFormEditVersion())
                        return;
                    break;
					
                case 'createVersion':
                    if($this->drawFormCreateVersion())
                        return;
                    break;								                
                
                case 'edit':
					$this->loadCardInfo();
                    if($this->drawFormEditCard())
                        return;
                    break;
				case 'create':
                    if($this->drawFormCreateCard())
                        return;
                    break;					
            }
        }        
		$this->redirect('Affiliate_Merchants_Views_CardManager');
    }
	
	function drawFormEditCard(){
		$eid = preg_replace('/[\'\"]/', '', $_REQUEST['eid']);
		
		$_POST['rs_versions'] = $this->getVersions($eid);
		$_POST['defaultVersion'] = Affiliate_Merchants_Bl_Cards::getDefaultVersion($eid);
		
		$this->addContent('card_edit');
		return true;
	}
	
	function drawFormEditVersion(){
		$_POST['action'] = "updateVersion";
		$sBasePath =  "../../include/QUnit/Graphics/FCKeditor/";

		$oFCKeditor = new FCKeditor('cardDetailText');
		$oFCKeditor->Value = $_POST['cardDetailText'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject1'] = $oFCKeditor;
		
		$oFCKeditor = new FCKeditor('cardIntroDetail');
		$oFCKeditor->Value = $_POST['cardIntroDetail'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject2'] = $oFCKeditor;
		
		$oFCKeditor = new FCKeditor('cardMoreDetail');
		$oFCKeditor->Value = $_POST['cardMoreDetail'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject3'] = $oFCKeditor;
		
		$_POST['rs_sites'] = Affiliate_Merchants_Bl_Cards::getUnusedVersions($_REQUEST['cardId']);
		$_POST['cardId'] = $_REQUEST['cardId'];
		$this->loadCardInfo();
		$this->addContent('card_createVersion');		
		return true;
	}
	
	function drawFormCreateCard(){
		$sBasePath =  "../../include/QUnit/Graphics/FCKeditor/";

		$oFCKeditor = new FCKeditor('cardDetailText');
		$oFCKeditor->Value = $_POST['cardDetailText'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject1'] = $oFCKeditor;
		
		$oFCKeditor = new FCKeditor('cardIntroDetail');
		$oFCKeditor->Value = $_POST['cardIntroDetail'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject2'] = $oFCKeditor;
		
		$oFCKeditor = new FCKeditor('cardMoreDetail');
		$oFCKeditor->Value = $_POST['cardMoreDetail'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject3'] = $oFCKeditor;		
		$this->addContent('card_create');
		return true;
	}
	
	function drawFormCreateVersion(){
		$_POST['action'] = "createVersion";
		$sBasePath =  "../../include/QUnit/Graphics/FCKeditor/";

		$oFCKeditor = new FCKeditor('cardDetailText');
		$oFCKeditor->Value = $_POST['cardDetailText'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject1'] = $oFCKeditor;
		
		$oFCKeditor = new FCKeditor('cardIntroDetail');
		$oFCKeditor->Value = $_POST['cardIntroDetail'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject2'] = $oFCKeditor;
		
		$oFCKeditor = new FCKeditor('cardMoreDetail');
		$oFCKeditor->Value = $_POST['cardMoreDetail'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject3'] = $oFCKeditor;
		
		$_POST['rs_sites'] = Affiliate_Merchants_Bl_Cards::getUnusedVersions($_REQUEST['cardId']);
		$_POST['cardId'] = $_REQUEST['cardId'];
		$this->addContent('card_createVersion');
		return true;
	}
	
	function getVersions($cardId){
		$sql = "SELECT * FROM rt_carddetails WHERE cardId = " . _q($cardId) . " AND deleted != 1 ORDER BY cardDetailLabel ASC";
		echo $sql;
		return QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}	

    //--------------------------------------------------------------------------        
    
	function processUpdateVersion(){
        if($_REQUEST['active'] != 1)
			$_REQUEST['active'] = 0;
		
		$temp = explode(".", $_REQUEST['cardLink']);
		if(is_array($temp)){
			$_REQUEST['cardLink'] = $temp[0];	
		}
		
		$params = array(
            'cardDetailText' => $_REQUEST['cardDetailText'],
            'cardIntroDetail' =>  $_REQUEST['cardIntroDetail'],
            'cardMoreDetail' =>  $_REQUEST['cardMoreDetail'],
            'cardSeeDetails' =>  $_REQUEST['cardSeeDetails'],
			'categoryImage' =>  $_REQUEST['categoryImage'],
            'categoryAltText' =>  $_REQUEST['categoryAltText'],
            'cardIOImage' =>  $_REQUEST['cardIOImage'],
            'cardIOAltText' =>  $_REQUEST['cardIOAltText'],
            'cardButtonAltText' =>  $_REQUEST['cardButtonAltText'],
            'cardIOButtonAltText' =>  $_REQUEST['cardIOButtonAltText'],
            'cardIconSmall' =>  $_REQUEST['cardIconSmall'],
            'cardIconMid' =>  $_REQUEST['cardIconMid'],
            'cardIconLarge' =>  $_REQUEST['cardIconLarge'],
            'cardLink' =>  $_REQUEST['cardLink'],
            'appLink' =>  $_REQUEST['appLink'],
            
            'cardListingString' =>  $_REQUEST['cardListingString'],
            'cardPageHeaderString' =>  $_REQUEST['cardPageHeaderString'],
            'fid' =>  $_REQUEST['fid'],
		);
        
        if(QUnit_Messager::getErrorMessage() != '')
        {

            return false;
        }		
		
        // save changes of user to db
        Affiliate_Merchants_Bl_Cards::updateVersion($_REQUEST['versionId'], $params);
                
		QUnit_Messager::setOkMessage("Version Successfully Updated");
              
        return false;		
		
	}
	
	
    function processUpdateCard()
    {   
		
        if($_REQUEST['active'] != 1)
			$_REQUEST['active'] = 0;


		$params = array(
            'cardTitle' =>  $_REQUEST['cardTitle'],
            'cardDescription' => $_REQUEST['cardDescription'],
            'merchant' => $_REQUEST['merchant'],
            'introApr' => $_REQUEST['introApr'],
			'active_introApr' => $_REQUEST['active_introApr'],
			'regularApr' => $_REQUEST['regularApr'],
			'active_regularApr' => $_REQUEST['active_regularApr'],
            'introAprPeriod' => $_REQUEST['introAprPeriod'],
            'active_introAprPeriod' => $_REQUEST['active_introAprPeriod'],
            'annualFee' => $_REQUEST['annualFee'],
            'active_annualFee' => $_REQUEST['active_annualFee'],
            'monthlyFee' =>  $_REQUEST['monthlyFee'],
            'active_monthlyFee' =>  $_REQUEST['active_monthlyFee'],
            'balanceTransfers' =>   $_REQUEST['balanceTransfers'],
            'active_balanceTransfers' =>   $_REQUEST['active_balanceTransfers'],
            'creditNeeded' =>     	$_REQUEST['creditNeeded'],
            'active_creditNeeded' =>    $_REQUEST['active_creditNeeded'],
            'ratesAndFees' =>      $_REQUEST['ratesAndFees'],
            'rewards' =>         	$_REQUEST['rewards'],
            'cardBenefits' =>      $_REQUEST['cardBenefits'],
            'onlineServices' =>    $_REQUEST['onlineServices'],
            'footNotes' =>        $_REQUEST['footNotes'],
            'layout' =>         	$_REQUEST['layout'],
            'active' =>         	$_REQUEST['active'],
			'imagePath' =>         	$_REQUEST['imagePath'],
		);
		
        
        if(QUnit_Messager::getErrorMessage() != '')
        {

            return false;
        }		
		
        // save changes of user to db
        Affiliate_Merchants_Bl_Cards::updateCard($_REQUEST['cardId'], $params);
                
		QUnit_Messager::setOkMessage("Card Successfully Updated");      
        return false;
    }
	
    function processCreateCard()
    {   
        
		if($_REQUEST['active'] != 1)
			$_REQUEST['active'] = 0;
		
			
		$params = array(
            'id' =>  $_REQUEST['cardId'],
			'cardId' =>  $_REQUEST['cardId'],
            'cardTitle' =>  $_REQUEST['cardTitle'],
            'cardDescription' => $_REQUEST['cardDescription'],
            'merchant' => $_REQUEST['merchant'],
            'introApr' => $_REQUEST['introApr'],
            'active_introApr' => $_REQUEST['activeintroApr'],
			'regularApr' => $_REQUEST['regularApr'],
			'active_regularApr' => $_REQUEST['active_regularApr'],
            'introAprPeriod' => $_REQUEST['introAprPeriod'],
            'active_introAprPeriod' => $_REQUEST['active_introAprPeriod'],
            'annualFee' => $_REQUEST['annualFee'],
            'active_annualFee' => $_REQUEST['active_annualFee'],
            'monthlyFee' =>  $_REQUEST['monthlyFee'],
            'active_monthlyFee' =>  $_REQUEST['active_monthlyFee'],
            'balanceTransfers' =>   $_REQUEST['balanceTransfers'],
            'active_balanceTransfers' =>   $_REQUEST['active_balanceTransfers'],
            'creditNeeded' =>     	$_REQUEST['creditNeeded'],
            'active_creditNeeded' =>     	$_REQUEST['active_creditNeeded'],
            'ratesAndFees' =>      $_REQUEST['ratesAndFees'],
            'rewards' =>         	$_REQUEST['rewards'],
            'cardBenefits' =>      $_REQUEST['cardBenefits'],
            'onlineServices' =>    $_REQUEST['onlineServices'],
            'footNotes' =>         $_REQUEST['footNotes'],
            'layout' =>         	$_REQUEST['layout'],
            'active' =>         	$_REQUEST['active'],
			'imagePath' =>         $_REQUEST['imagePath'],
		);
		
        
        if(QUnit_Messager::getErrorMessage() != '')
        {
            return false;
        }		
		

        Affiliate_Merchants_Bl_Cards::addCard($params);
		
		$temp = explode(".", $_REQUEST['cardLink']);
		if(is_array($temp)){
			$_REQUEST['cardLink'] = $temp[0];	
		}
		
		$params = array(
            'cardDetailText' =>  $_REQUEST['cardDetailText'],
            'cardIntroDetail' => $_REQUEST['cardIntroDetail'],
            'cardMoreDetail' => $_REQUEST['cardMoreDetail'],
            'cardSeeDetails' => $_REQUEST['cardSeeDetails'],
			'categoryImage' => $_REQUEST['categoryImage'],
            'categoryAltText' => $_REQUEST['categoryAltText'],
            'cardIOImage' => $_REQUEST['cardIOImage'],
            'cardIOAltText' =>  $_REQUEST['cardIOAltText'],
            'cardButtonAltText' =>  $_REQUEST['cardButtonAltText'],
            'cardIOButtonAltText' =>  $_REQUEST['cardIOButtonAltText'],
            'cardIconSmall' =>     $_REQUEST['cardIconSmall'],
            'cardIconMid' =>      $_REQUEST['cardIconMid'],
            'cardIconLarge' =>         	$_REQUEST['cardIconLarge'],
            'cardLink' => $_REQUEST['cardLink'],
            'appLink' => $_REQUEST['appLink'],
            'cardListingString' =>  $_REQUEST['cardListingString'],
            'cardPageHeaderString' =>  $_REQUEST['cardPageHeaderString'],
            'fid' =>  $_REQUEST['fid'],
		);
		
		Affiliate_Merchants_Bl_Cards::addDefaultVersion($_REQUEST['cardId'] ,$params);
                
		QUnit_Messager::setOkMessage("Site Successfully Created");
              
        return false;
    }
	
    function processCreateVersion()
    {   
        
		if($_REQUEST['active'] != 1)
			$_REQUEST['active'] = 0;
		foreach($_REQUEST as $col=>$data){
			echo $col . " : " . $data . "<br>";
		}
		
		$temp = explode(".", $_REQUEST['cardLink']);
		if(is_array($temp)){
			$_REQUEST['cardLink'] = $temp[0];	
		}
		
		$params = array(
			'cardId' => $_REQUEST['cardId'],
			'cardDetailVersion' => $_REQUEST['cardDetailVersion'],
			//'cardDetailLabel' =>  $rs->fields['pageName'],
            'cardDetailText' =>  $_REQUEST['cardDetailText'],
            'cardIntroDetail' => $_REQUEST['cardIntroDetail'],
            'cardMoreDetail' => $_REQUEST['cardMoreDetail'],
            'cardSeeDetails' => $_REQUEST['cardSeeDetails'],
			'categoryImage' => $_REQUEST['categoryImage'],
            'categoryAltText' => $_REQUEST['categoryAltText'],
            'cardIOImage' => $_REQUEST['cardIOImage'],
            'cardIOAltText' =>  $_REQUEST['cardIOAltText'],
            'cardButtonAltText' =>  $_REQUEST['cardButtonAltText'],
            'cardIOButtonAltText' =>  $_REQUEST['cardIOButtonAltText'],
            'cardIconSmall' => $_REQUEST['cardIconSmall'],
            'cardIconMid' => $_REQUEST['cardIconMid'],
            'cardIconLarge' => $_REQUEST['cardIconLarge'],
            'cardLink' => $_REQUEST['cardLink'],
            'appLink' => $_REQUEST['appLink'],
            'cardListingString' =>  $_REQUEST['cardListingString'],
            'cardPageHeaderString' =>  $_REQUEST['cardPageHeaderString'],
            'fid' =>  $_REQUEST['fid'],            
		);
		
        
        if(QUnit_Messager::getErrorMessage() != '')
        {
            return false;
        }		
		
        // save changes of user to db
        Affiliate_Merchants_Bl_Cards::addVersion($params);
              
        return false;
    } 	  		
    
    function loadVersionInfo()
    {
        $id = $_REQUEST['versionId'];
		
		$rs = Affiliate_Merchants_Bl_Cards::getVersion($id);

        if (!$rs || $rs->EOF) {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }
			$_POST['versionId'] = $id;
            $_POST['cardDetailText'] =  $rs->fields['cardDetailText'];
            $_POST['cardIntroDetail'] = $rs->fields['cardIntroDetail'];
            $_POST['cardMoreDetail'] = $rs->fields['cardMoreDetail'];
            $_POST['cardSeeDetails'] = $rs->fields['cardSeeDetails'];
			$_POST['categoryImage'] = $rs->fields['categoryImage'];
            $_POST['categoryAltText'] = $rs->fields['categoryAltText'];
            $_POST['cardIOImage'] = $rs->fields['cardIOImage'];
            $_POST['cardIOAltText'] = $rs->fields['cardIOAltText'];
            $_POST['cardButtonAltText'] = $rs->fields['cardButtonAltText'];
            $_POST['cardIOButtonAltText'] = $rs->fields['cardIOButtonAltText'];
            $_POST['cardIconSmall'] = $rs->fields['cardIconSmall'];
            $_POST['cardIconMid'] = $rs->fields['cardIconMid'];
            $_POST['cardIconLarge'] = $rs->fields['cardIconLarge'];
			$_POST['cardLink'] = $rs->fields['cardLink'];
			$_POST['appLink'] = $rs->fields['appLink'];
			
			$_POST['cardListingString'] = $rs->fields['cardListingString'];
			$_POST['cardPageHeaderString'] = $rs->fields['cardPageHeaderString'];
			$_POST['fid'] = $rs->fields['fid'];
    }	
	
	
    function loadCardInfo()
    {
        $eid = preg_replace('/[\'\"]/', '', $_REQUEST['eid']);
		
		$rs = Affiliate_Merchants_Bl_Cards::getCard($eid);

        if (!$rs || $rs->EOF) {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }
			$_POST['cardId'] =  $eid;
            $_POST['cardTitle'] =  $rs->fields['cardTitle'];
            $_POST['cardDescription'] = $rs->fields['cardDescription'];
            $_POST['merchant'] = $rs->fields['merchant'];
            $_POST['introApr'] = $rs->fields['introApr'];
            $_POST['active_introApr'] = $rs->fields['active_introApr'];
			$_POST['regularApr'] = $rs->fields['regularApr'];
			$_POST['active_regularApr'] = $rs->fields['active_regularApr'];
            $_POST['introAprPeriod'] = $rs->fields['introAprPeriod'];
            $_POST['active_introAprPeriod'] = $rs->fields['active_introAprPeriod'];
            $_POST['annualFee'] = $rs->fields['annualFee'];
            $_POST['active_annualFee'] = $rs->fields['active_annualFee'];
            $_POST['monthlyFee'] = $rs->fields['monthlyFee'];
            $_POST['active_monthlyFee'] = $rs->fields['active_monthlyFee'];
            $_POST['balanceTransfers'] =$rs->fields['balanceTransfers'];
            $_POST['active_balanceTransfers'] =$rs->fields['active_balanceTransfers'];
            $_POST['creditNeeded'] = $rs->fields['creditNeeded'];
            $_POST['active_creditNeeded'] = $rs->fields['active_creditNeeded'];
            $_POST['ratesAndFees'] = $rs->fields['ratesAndFees'];
            $_POST['rewards'] = $rs->fields['rewards'];
			$_POST['cardBenefits'] = $rs->fields['cardBenefits'];
			$_POST['onlineServices'] = $rs->fields['onlineServices'];
			$_POST['footNotes'] = $rs->fields['footNotes'];
			$_POST['layout'] = $rs->fields['layout'];
            $_POST['active'] = $rs->fields['active'];
			$_POST['imagePath'] = $rs->fields['imagePath']; 
			
		
    }

}
?>
