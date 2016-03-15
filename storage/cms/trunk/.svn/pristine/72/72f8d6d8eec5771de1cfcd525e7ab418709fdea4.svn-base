<?
/**
 * 
 * ClickSuccess, L.P.
 * August 7, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * @package CMS_View
 */ 

csCore_Import::importClass('CsCore_UI_SLLists');
csCore_Import::importClass('CMS_pages_cmsList');
csCore_Import::importClass('csCore_UI_filter');
csCore_Import::importClass('csCore_UI_formItem');
csCore_Import::importClass('CMS_libs_CardCategoryGroups');

class CMS_view_cardCategoryGroups extends CMS_pages_cmsList
{
	var $filter;
    function process()
    {
        if(!empty($_REQUEST['sortableListsSubmitted']))
        {
        	$_REQUEST['action'] = 'manageCardCategoryRanks';
        }
        
		if(!empty($_REQUEST['action'])){
			switch($_REQUEST['action']){
				case 'deleteCardCategoryGroup':
                    if($this->processDeleteCardCategoryGroup())
                        return;
                    break;     
				case 'createCardCategoryGroup':
                    if($this->drawFormCreateCardCategoryGroup())
                        return;
                    break;   
				case 'processCreateCardCategoryGroup':
                    if($this->processCreateCardCategoryGroup())
                        return;
                    break; 
				case 'updateCardCategoryGroup':
                    if($this->drawFormUpdateCardCategoryGroup())
                        return;
                    break;   
				case 'processUpdateCardCategoryGroup':
                    if($this->processUpdateCardCategoryGroup())
                        return;
                    break;
                case 'manageCardCategories':
                	$this->redirect("CMS_view_cardCategoryToCardCategoryGroup&id=".$_REQUEST['id']);
                        return;
                    break;
			}			
		}
		$this->showData();      
    }
    
    function getRequiredPermissions()
    {
    	return array('CMS_cards');	
    }
	
	function setSql()
    {
    	$columns =  implode(", ", $this->keys);
    	$this->sql = "
    		SELECT ccg.id as id, ccg.card_category_group_name as name, COUNT(1) AS cnt
			FROM card_category_groups ccg 
			LEFT JOIN card_category_group_to_category ccgc 
				ON ( ccg.id = ccgc.card_category_group_id )
			GROUP BY (ccg.id)";

   		$this->where = "";
    }
    
    function setPaging()
    {
    	$this->paging = 'select count(*) as count FROM card_category_groups';
    }
    
    function setFilter()
    {
    	$this->filter->setTitle("Card Category Group Filter");		
    }
    
	function getColumns()
    {
    	// This no longer will automatically update the query...and addition here must be added to the query as well
		// db Column name => array(Label, sortable, table, callback function)
		return array(
			"name"							=> array("Category Group Name", true),			
			"id"		 					=> array("Category Group ID", true),
			"cnt"		 					=> array("Number of assigned categories", true)
		);    
		
    }
    
    function getKey()
    {
    	return "id";
    }
    
    function setSelectActions()
    {
    	
    	$label 		= "Update Card Category Group";
    	$action		= "updateCardCategoryGroup";
    	$vars 		= array("id" => $this->getKey());
    	$confirm	= false;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);     	
    	
    	$label 		= "Delete Card Category Group";
    	$action		= "deleteCardCategoryGroup";
    	$vars 		= array("id" => $this->getKey());
    	$confirm	= true;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);
    	
    	$label		= "Manage Card Categories";
    	$action		= "manageCardCategories";
    	$vars 		= array("id" => $this->getKey());
    	$confirm	= false;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);
    }
    
    function setTextActions()
    {
    	$label 		= "Create New Card Category Group";
    	$action		= "createCardCategoryGroup";
    	$vars 		= array();
    	$confirm	= false;
    	$this->textActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
    	
//    	$label 		= "View / Edit Card Category Ranks";
//    	$action		= "manageCardCategoryRanks&card_category_context_id=1";
//    	$vars 		= array();
//    	$confirm	= false;
//    	$this->textActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
    }
    
    function processDeleteCardCategoryGroup()
    {
    	CMS_libs_CardCategoryGroups::deleteCardCategoryGroup($_REQUEST['id']);
    }
    
    function drawFormCreateCardCategoryGroup()
    {
    	
    	$this->addContent('cardCategoryGroup_create');
    	
    	return true;
    }
    
    function processCreateCardCategoryGroup()
    {
    	$data = array(	"card_category_group_name" => $_REQUEST['card_category_group_name'],
    					);
    	CMS_libs_CardCategoryGroups::addCardCategoryGroup($data);
    }
    
    function drawFormUpdateCardCategoryGroup()
    {
    	$this->assignValue('id', $_REQUEST['id']);
    	
    	$this->assignValue('data', CMS_libs_CardCategoryGroups::getCardCategoryGroupById($_REQUEST['id']));
    	
    	$this->addContent('cardCategoryGroup_edit');
    	
    	return true;    		
    }
    
    function processUpdateCardCategoryGroup()
    {
    	$data = array(	"card_category_group_name" => $_REQUEST['card_category_group_name'],
    					);
    	CMS_libs_CardCategoryGroups::updateCardCategoryGroup($_REQUEST['card_category_id'], $data);
    }
    
    function drawFormManageCardCategoryRanks()
    {
    	$cardCategoriesDAO = new CMS_libs_CardCategoryGroups();
    	
        //$assignedCards = $this->getAssignedCards();
		//$unassignedCards = $this->getUnassignedCards();
		$cardCategories = $cardCategoriesDAO->getAllCardCategoriesOrderByRank();
		
		//$_POST['rs_assignedCards'] = $assignedCards;
		//$_POST['rs_unassignedCards'] = $unassignedCards;

		//$_POST['categoryName'] = $assigned->fields['categoryName'];
		
		//$_POST['cardCategoryInfo'] = $this->getCardCategoryInfo($_REQUEST['card_category_id']);
		//echo "Category Name: " . $assigned->fields['categoryName'];
		
		$this->assignValue('cardCategories', $cardCategories);
		//$this->assignValue('imageRepository', $this->settings->getSetting('CMS_image_repository'));
		
		$this->addContent('cardCategoryRanks_list');
    }
    
	function updateOrder($sql){//mlucas - done
		$cardCats = CMS_libs_CardCategoryGroups::getAllCardCategories();
		$ids = array();
		foreach ($cardCats as $cat)
			$ids[] = $cat['card_category_id'];
		$deletesql = "DELETE from card_category_ranks where card_category_context_id = " . _q($_REQUEST['card_category_context_id']) . " AND card_category_id IN " . _array2paren($ids, "'");
		
		$rs = _sqlQuery($deletesql, __LINE__, __FILE__, DEBUG_MODE);
		if($sql != ''){
			foreach($sql as $currentSql)
				$rs = _sqlQuery($currentSql, __LINE__, __FILE__, DEBUG_MODE);
		}
	}
}
?>
