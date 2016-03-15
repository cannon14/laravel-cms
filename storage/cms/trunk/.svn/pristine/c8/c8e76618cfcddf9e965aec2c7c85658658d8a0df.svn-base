<?
/**
 * 
 * CreditCards.com
 * July 10, 2007
 *  
 * Authors:
 * Jason Huie
 * <jasonh@creditcards.com>
 * 
 * @package CMS_View
 */ 

csCore_Import::importClass('CMS_pages_cmsRestrictedPage');
csCore_Import::importClass('CMS_libs_Profiles');

class CMS_view_profilePage extends CMS_pages_cmsRestrictedPage
{

	var $profileData;
	var $topCardData;
	
    function process()
    {    	
        switch($_REQUEST['action']){         	
				case 'updateProfile':
					if( $this->processUpdateProfile() )
					return;
					break;     	
				case 'addProfile':
					if( $this->processAddProfile() )
					return;
					break;
				default:
					break;
        }
		$this->showPage();
    }
	
	function processAddProfile() {
		
		CMS_libs_Profiles::addProfile($_REQUEST['cardpageId']);
		_setMessage("Profile Successfully Added");

        return false;
	}	
	function processUpdateProfile() {
		
		$params = array(
			'title' => $_REQUEST['title'],
			'sub_title' => $_REQUEST['sub_title'],
			'content_sub_title' => $_REQUEST['content_sub_title'],
			'background_color_code_light' => $_REQUEST['background_color_code_light'],
			'background_color_code_dark' => $_REQUEST['background_color_code_dark'],
			'profile_description' => $_REQUEST['profile_description'],
			'profile_card_types' => $_REQUEST['profile_card_types'],
			'profile_tip' => $_REQUEST['profile_tip'],
			'news_static_content' => $_REQUEST['news_static_content'],
			'image_path' => $_REQUEST['image_path'],
			'media_url' => $_REQUEST['media_url'],
			'calculator_url' => $_REQUEST['calculator_url'],
			'card_category_1' => $_REQUEST['card_category_1'],
			'card_category_2' => $_REQUEST['card_category_2'],
			'card_category_3' => $_REQUEST['card_category_3'],
			'tag_category_1' => $_REQUEST['tag_category_1'],
			'tag_category_2' => $_REQUEST['tag_category_2'],
			'tag_category_3' => $_REQUEST['tag_category_3'],
			'rank' =>  $_REQUEST['rank'],
		);
			
		CMS_libs_Profiles::updateProfile($_REQUEST['cardpageId'], $params);
		_setMessage("Profile Successfully Updated");

        return false;
	}
	
	function updateOrder($profilePageId){
		$orderArray = csCore_UI_SLLists::getOrderArray($_REQUEST['assignedListOrder'],'assignedList');
		//CMS_libs_Specials::removePagesById($specialsPageId);
		//foreach($orderArray as $item)
		//	CMS_libs_Specials::addSpecialsPageToPage($specialsPageId, $item['element']);
	}

    function showPage()
    {	
    	$this->assignValue('cardCategories', CMS_libs_Profiles::getCardCategories());
    	$this->assignValue('tagCategories', CMS_libs_Profiles::getTagCategories());
		$this->assignValue('profileRecords', CMS_libs_Profiles::getProfileById($_REQUEST['cardpageId']));
		$this->addContent('assignprofiles_list'); 	
    }
}
?>
