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
csCore_Import::importClass('CMS_libs_CardCategories');

class CMS_view_cardCategories extends CMS_pages_cmsList
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
				case 'deleteCardCategory':
                    if($this->processDeleteCardCategory())
                        return;
                    break;     
				case 'createCardCategory':
                    if($this->drawFormCreateCardCategory())
                        return;
                    break;   
				case 'processCreateCardCategory':
                    if($this->processCreateCardCategory())
                        return;
                    break; 
				case 'updateCardCategory':
                    if($this->drawFormUpdateCardCategory())
                        return;
                    break;   
				case 'processUpdateCardCategory':
                    if($this->processUpdateCardCategory())
                        return;
                    break;
                case 'manageCards':
                	$this->redirect("CMS_view_cardToCardCategory&card_category_id=".$_REQUEST['card_category_id']);
                        return;
                    break;
                case 'manageCardCategoryRanks':
			        if(!empty($_REQUEST['sortableListsSubmitted']))
			        {
						
						$orderArray = CsCore_UI_SLLists::getOrderArray($_REQUEST['assignedListOrder'],'assignedList');
						foreach($orderArray as $item) {
							$s = "INSERT INTO card_category_ranks (card_category_rank, card_category_id, card_category_context_id) VALUES (" . _q($item['order']) . ","  . _q($item['element']) . ", 1)";
							//echo $s ."<br>";
							$sql[] = $s; 
						}
						$this->updateOrder($sql);
					}
                    if($this->drawFormManageCardCategoryRanks())
                        return;
                	//$this->redirect("CMS_view_cardCategoryRanks&card_category_context_id=1");
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
    	$this->sql = <<<SQL
    	SELECT 
    		cc.card_category_id,
    		cc.card_category_name, 
    		cc.card_category_display_name,  
    		COUNT(cr.card_id) as cnt 
    	FROM card_categories cc 
    	LEFT JOIN card_ranks cr 
    		ON (cc.card_category_id = cr.card_category_id)
    	WHERE cc.deleted != 1
    	GROUP BY cc.card_category_id
SQL;

   		$this->where = "";
    }
    
    function setPaging()
    {
    	$this->paging = 'select count(*) as count FROM card_categories';
		
    }
    
    function setFilter()
    {
    	$this->filter->setTitle("Card Category Filter");		
    }
    
	function getColumns()
    {
		// db Column name => array(Label, sortable, table, callback function)
		return array(
			"card_category_id"		 	=> array("Category ID", true),
			"card_category_name"		=> array("Category Name", true),
			"card_category_display_name"=> array("Category Display Name", true),
			"cnt"		 				=> array("Count of assigned cards", true)
		);    
		
    }
    
    function getKey()
    {
    	return "card_category_id";
    }
    
    function setSelectActions()
    {
    	$label 		= "Update Card Category";
    	$action		= "updateCardCategory";
    	$vars 		= array("card_category_id" => $this->getKey());
    	$confirm	= false;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);     	
    	
    	$label 		= "Delete Card Category";
    	$action		= "deleteCardCategory";
    	$vars 		= array("card_category_id" => $this->getKey());
    	$confirm	= true;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);
    	
    	$label		= "Manage Cards";
    	$action		= "manageCards";
    	$vars 		= array("card_category_id" => $this->getKey());
    	$confirm	= false;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);
    }
    
    function setTextActions()
    {
    	$label 		= "Create New Card Category";
    	$action		= "createCardCategory";
    	$vars 		= array();
    	$confirm	= false;
    	$this->textActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
    	
    	$label 		= "View / Edit Card Category Ranks";
    	$action		= "manageCardCategoryRanks&card_category_context_id=1";
    	$vars 		= array();
    	$confirm	= false;
    	$this->textActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
    }
    
    function processDeleteCardCategory()
    {
    	CMS_libs_CardCategories::deleteCardCategory($_REQUEST['card_category_id']);
    }
    
    function drawFormCreateCardCategory()
    {
    	
    	$this->addContent('cardCategory_create');
    	
    	return true;
    }
    
    function processCreateCardCategory()
    {
    	$data = array(	"card_category_name" => $_REQUEST['card_category_name'],
    					"card_category_display_name" => $_REQUEST['card_category_display_name']
    					);
    	CMS_libs_CardCategories::addCardCategory($data);
    }
    
    function drawFormUpdateCardCategory()
    {
    	$this->assignValue('card_category_id', $_REQUEST['card_category_id']);
    	
    	$this->assignValue('data', CMS_libs_CardCategories::getCardCategoryById($_REQUEST['card_category_id']));
    	
    	$this->addContent('cardCategory_edit');
    	
    	return true;    		
    }
    
    function processUpdateCardCategory()
    {
    	$data = array(	"card_category_name" => $_REQUEST['card_category_name'],
    					"card_category_display_name" => $_REQUEST['card_category_display_name']
    					);
    	CMS_libs_CardCategories::updateCardCategory($_REQUEST['card_category_id'], $data);
    }
    
    function drawFormManageCardCategoryRanks()
    {
    	$cardCategoriesDAO = new CMS_libs_CardCategories();
    	
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
		$cardCats = CMS_libs_CardCategories::getAllCardCategories();
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
