<?
//============================================================================
// RAPIDO TECHNOLOGIES ADDITION
//============================================================================

QUnit_Global::includeClass('QUnit_UI_ListPage');
QUnit_Global::includeClass('Affiliate_Affiliates_Bl_Settings');
QUnit_Global::includeClass('Affiliate_Merchants_Views_Settings');
class Affiliate_Merchants_Views_TrackingManager extends QUnit_UI_ListPage
{
    // added for epc override pg.  - mz 12/14/07
    var $_epcTextFieldPrefix = 'txtEpcOverride_';
    var $_useOverrideCheckboxPrefix = 'chkUseOverride_';
    var $_epcTmpTablesCreated = false;
    
    function initPermissions()
    {
//        $this->modulePermissions['delete'] = 'aff_aff_affiliates_modify';
//        $this->modulePermissions['add'] = 'aff_aff_affiliates_modify';
//        $this->modulePermissions['view'] = 'aff_aff_affiliates_view';
//        $this->modulePermissions['edit'] = 'aff_aff_affiliates_modify';
//        $this->modulePermissions['viewassigned'] = 'aff_aff_affiliates_modify';
    }

    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_POST['commited']))
        {
            switch($_POST['postaction'])
            {
                case 'addRT':
                    if($this->processAddRT($_REQUEST['mode']))
                        return;
                    break;
                      
                case 'editRT':
                    if($this->processEditRT($_REQUEST['mode']))
                        return;
                break;
							
            }
            
            switch($_POST['massaction'])
            {
                
                case 'delete':
               	    if($this->processDelete()) {
               	    	if ($this->showView())
           	            	return;
               	    }
                break;
                
            }
        }

        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
			
                case 'add':
                	switch($_REQUEST['mode']) {
                		case "keywords":
                    		if($this->drawFormAddKeyword())
                        		return;
                		case "merchants":
                    		if($this->drawFormAddMerchant())
                        		return;
                		case "pages":
                    		if($this->drawFormAddPage())
                        		return;
                		case "timeslots":                        
                    		if($this->drawFormAddTimeslot())
                        		return;
                		case "trackers":
                    		if($this->drawFormAddTracker())
                        		return;
                                
                     case "epcedit":
                        if($this->drawFormAddEpc())
                              return;                                                 

                	}
                	break;
                case 'edit':                  
                	switch($_REQUEST['mode']) {
                		case "keywords":
                    		if($this->drawFormEditKeyword())
                        		return;
                		case "merchants":
                    		if($this->drawFormEditMerchant())
                        		return;
                		case "pages":
                    		if($this->drawFormEditPage())
                        		return;
                		case "timeslots":
                    		if($this->drawFormEditTimeslot())
                        		return;
                		case "trackers":
                    		if($this->drawFormEditTracker())
                        		return;
                                
                     case "epcedit":
                        if(isset($_GET['subaction']) && $_GET['subaction'] == 'updateEpcRates')
                        {                           
                           $this->_updateEpcRates();
                        }
                        else
                        {
                           $this->processEditRT($_REQUEST['mode']);                                         
                        }                                                                                
                	}
	                break;
	
                case 'delete':
               	    if($this->processDelete()) {
               	    	if ($this->showView())
           	            	return;
               	    }
       	        break;
   	        }
        }         
         
        if($this->showView())
        	return;
        	 
	}
    
    
    //==========================================================================
    // PROCESSING FUNCTIONS
    //==========================================================================

    function processDelete()
    {           
		if(($EIDs = $this->returnEIDs()) == false)
            return false;
			
		$sqlEIDs = "('" . implode("','", $EIDs) . "')";
		$sql = "";
        
        switch ($_REQUEST['mode']) {
        	case "keywords":
        		$sql = 'delete from rt_keywords where entryId in ' . $sqlEIDs;
				break;
			case "merchants":
				break;
			case "pages":
        		$sql = 'delete from pages where page_id in ' . $sqlEIDs;
				break;
			case "timeslots":
        		$sql = 'delete from rt_timeslots where entryId in ' . $sqlEIDs;
				break;
			case "trackers":
        		$sql = 'delete from rt_trackers where entryId in ' . $sqlEIDs;
				break;
			default:
				return false;
        }
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if (!$rs)
        {
        	QUnit_Messager::setErrorMessage(L_G_DBERROR);
        	return false;
        }     
        
        return true;
    }
	
	//--------------------------------------------------------------------------

    function processEditRT($mode)
    {
    	switch ($mode) {
    		case "keywords":
        		$keywordId = preg_replace('/[^0-9a-zA-Z_-]/', '', $_POST['keywordId']);
        		$keyword = preg_replace('/[\'\"]/', '', $_POST['keyword']);
				$entryId = $_POST['entryId'];
				$ordering = 0;
				if ($_REQUEST['ordering'] == "on") $ordering = 1;
		
        		$sql = 'update rt_keywords set keywordId="'.$keywordId.'", keyword="'.$keyword.'", ordering="'.$ordering.'" where entryId="'.$entryId.'"';
        		$ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
				if(!$ret)
        		{
            		QUnit_Messager::setErrorMessage(L_G_DBERROR);
            		return false;
        		} else {
                	QUnit_Messager::setOkMessage(L_G_RT_KEYWORDEDITED);

            		$this->closeWindow('Affiliate_Merchants_Views_TrackingManager');
            		$this->addContent('tracking_closewindow');
            		return true;
        		}
    		case "merchants":
    			break;
    		case "pages":
        		$pageId = preg_replace('/[^0-9a-zA-Z_-]/', '', $_POST['pageId']);
        		$pageName = preg_replace('/[\'\"]/', '', $_POST['pageName']);
				$pageId = $_POST['page_id'];
				$ordering = 0;
				if ($_REQUEST['ordering'] == "on") $ordering = 1;
		
        		$sql = 'update pages set page_name="'.$pageName.'" where page_id="'.$pageId.'"';
        		$ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
				if(!$ret)
        		{
            		QUnit_Messager::setErrorMessage(L_G_DBERROR);
            		return false;
        		} else {
                	QUnit_Messager::setOkMessage(L_G_RT_PAGEEDITED);

            		$this->closeWindow('Affiliate_Merchants_Views_TrackingManager');
            		$this->addContent('tracking_closewindow');
            		return true;
        		}
    		case "timeslots":
        		$timeslotId = preg_replace('/[^0-9a-zA-Z_-]/', '', $_POST['timeslotId']);
        		$timeslotName = preg_replace('/[\'\"]/', '', $_POST['timeslotName']);
				$entryId = $_POST['entryId'];
				$ordering = 0;
				if ($_REQUEST['ordering'] == "on") $ordering = 1;
		
        		$sql = 'update rt_timeslots set timeslotId="'.$timeslotId.'", timeslotName="'.$timeslotName.'", ordering="'.$ordering.'" where entryId="'.$entryId.'"';
        		$ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
				if(!$ret)
        		{
            		QUnit_Messager::setErrorMessage(L_G_DBERROR);
            		return false;
        		} else {
                	QUnit_Messager::setOkMessage(L_G_RT_TIMESLOTEDITED);

            		$this->closeWindow('Affiliate_Merchants_Views_TrackingManager');
            		$this->addContent('tracking_closewindow');
            		return true;
        		}
    		case "trackers":
        		$trackerId = preg_replace('/[^0-9a-zA-Z_-]/', '', $_POST['trackerId']);
        		$trackerName = preg_replace('/[\'\"]/', '', $_POST['trackerName']);
				$entryId = $_POST['entryId'];
				$ordering = 0;
				if ($_REQUEST['ordering'] == "on") $ordering = 1;
		
        		$sql = 'update rt_trackers set trackerId="'.$trackerId.'", trackerName="'.$trackerName.'", ordering="'.$ordering.'" where entryId="'.$entryId.'"';
        		$ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
				if(!$ret)
        		{
            		QUnit_Messager::setErrorMessage(L_G_DBERROR);
            		return false;
        		} else {
                	QUnit_Messager::setOkMessage(L_G_RT_TRACKEREDITED);

            		$this->closeWindow('Affiliate_Merchants_Views_TrackingManager');
            		$this->addContent('tracking_closewindow');
            		return true;
        		}
            
                
            case 'epcedit':
               
               // this is real inefficient, selecting, then inserting, then updating, on a 
               // row by row basis ... not sure how to accomplish the validation otherwise
               // though.  - mz 12/17/07
               foreach($_POST as $key=>$val)
               {
                  if(substr($key, 0, 15) == $this->_epcTextFieldPrefix)
                  {
                     $bannerid = end(explode('_', $key));
                     $epcRateOverride = $_POST[$this->_epcTextFieldPrefix.$bannerid];               
                                            
                     if(isset($_POST[$this->_useOverrideCheckboxPrefix.$bannerid]))
                     {
                        $useOverride = 1;
                     }
                     else
                     {
                        $useOverride = 0; 
                     }
                     
                     // only update an epc override if it was entered.  - mz 12/18/07
                     if($epcRateOverride != '')
                     {                        
                        $epcRateOverride = (float)$epcRateOverride;
                                           
                         // first read the record before changing.  If a change will occur,
                         // the original record will write to the history table before we update.  
                         // The comparison using cast() is necessary for a valid comparison
                         // between 2 floats.  W/out it, the comparison usually fails
                         // when it seemingly should pass.  - mz 12/17/07
                         $sql = 
                         "
                         select 
                            epc_rate, 
                            epc_rate_override, 
                            last_change_time                            
                         from product_epc
                         where bannerid = $bannerid
                         and (
                              cast(epc_rate_override as decimal(8,5)) <> cast($epcRateOverride as decimal(8,5))
                              or
                              use_override <> $useOverride
                              )
                         ";
                         
                         $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
                         
                         if(!$rs)
                         {
                            QUnit_Messager::setErrorMessage(L_G_DBERROR);
                            return false;
                         }                     
    
                         if($rs->RowCount() > 0)
                         {                        
                            $sql = 
                            "
                            insert product_epc_history (bannerid, rate_begin_time, epc_rate, epc_rate_override)
                            values ('$bannerid', '".$rs->fields['last_change_time']."', ".$rs->fields['epc_rate'].", ".$rs->fields['epc_rate_override'].")
                            ";                        
                         
                            QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);                        
                            
                            // ensure the insert occured
                            if($GLOBALS['db']->Affected_Rows() != 1)
                            {
                               QUnit_Messager::setErrorMessage(L_G_EPC_HISTORY_WRITE_FAILED);
                               return false;
                            }                     
                            
                            $sql = 
                            "
                            update product_epc set
                            epc_rate_override = ".$epcRateOverride.",
                            use_override = ".$useOverride.",
                            last_change_time = now()
                            where bannerid = '".$bannerid."'";                        
                                                 
                            QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
                            
                            // ensure the update occured
                            if($GLOBALS['db']->Affected_Rows() != 1)
                            {
                               QUnit_Messager::setErrorMessage(L_G_EPC_UPDATE_FAILED);
                               return false;
                            }                          
                         }   
                     }                                
                  }
               }                        

            break;
    	}

        return false;
    }
	
    //--------------------------------------------------------------------------
  
    function processAddRT($mode)
    {
    	switch ($mode) {
    		case "keywords":
        		$keywordId = preg_replace('/[^0-9a-zA-Z_-]/', '', $_REQUEST['keywordId']);
        		$keyword = preg_replace('/[\'\"]/', '', $_REQUEST['keyword']);
				$ordering = 0;
				if ($_REQUEST['ordering'] == "on") $ordering = 1;
		
				$sql = "INSERT INTO rt_keywords (keywordId, keyword, ordering, dateinserted, deleted) VALUES ('$keywordId', '$keyword', '$ordering', now(), 0)";
				$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
				if (!$rs)
        		{
            		QUnit_Messager::setErrorMessage(L_G_DBERROR);
            		return false;
        		} else {
                	QUnit_Messager::setOkMessage(L_G_RT_KEYWORDADDED);
            
            		$this->closeWindow('Affiliate_Merchants_Views_TrackingManager');
            		$this->addContent('tracking_closewindow');
            		return true;
        		}	
    		case "merchants":
    			break;
    		case "pages":
        		$pageId = preg_replace('/[^0-9a-zA-Z_-]/', '', $_REQUEST['pageId']);
        		$pageName = preg_replace('/[\'\"]/', '', $_REQUEST['pageName']);
				$ordering = 0;
				if ($_REQUEST['ordering'] == "on") $ordering = 1;
		
				$sql = "INSERT INTO pages (page_name, ordering, insert_time, deleted) VALUES ('$pageName', '$ordering', now(), 0)";
				$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
				if (!$rs)
        		{
            		QUnit_Messager::setErrorMessage(L_G_DBERROR);
            		return false;
        		} else {
                	QUnit_Messager::setOkMessage(L_G_RT_PAGEADDED);
            
            		$this->closeWindow('Affiliate_Merchants_Views_TrackingManager');
            		$this->addContent('tracking_closewindow');
            		return true;
        		}	
    		case "timeslots":
        		$timeslotId = preg_replace('/[^0-9a-zA-Z_-]/', '', $_REQUEST['timeslotId']);
        		$timeslotName = preg_replace('/[\'\"]/', '', $_REQUEST['timeslotName']);
				$ordering = 0;
				if ($_REQUEST['ordering'] == "on") $ordering = 1;
		
				$sql = "INSERT INTO rt_timeslots (timeslotId, timeslotName, ordering, dateinserted, deleted) VALUES ('$timeslotId', '$timeslotName', '$ordering', now(), 0)";
				$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
				if (!$rs)
        		{
            		QUnit_Messager::setErrorMessage(L_G_DBERROR);
            		return false;
        		} else {
                	QUnit_Messager::setOkMessage(L_G_RT_TIMESLOTADDED);
            
            		$this->closeWindow('Affiliate_Merchants_Views_TrackingManager');
            		$this->addContent('tracking_closewindow');
            		return true;
        		}	
    		case "trackers":
        		$trackerId = preg_replace('/[^0-9a-zA-Z_-]/', '', $_REQUEST['trackerId']);
        		$trackerName = preg_replace('/[\'\"]/', '', $_REQUEST['trackerName']);
				$ordering = 0;
				if ($_REQUEST['ordering'] == "on") $ordering = 1;
		
				$sql = "INSERT INTO rt_trackers (trackerId, trackerName, ordering, dateInserted, deleted) VALUES ('$trackerId', '$trackerName', '$ordering', now(), 0)";
				$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
				if (!$rs)
        		{
            		QUnit_Messager::setErrorMessage(L_G_DBERROR);
            		return false;
        		} else {
                	QUnit_Messager::setOkMessage(L_G_RT_TRACKERADDED);
            
            		$this->closeWindow('Affiliate_Merchants_Views_TrackingManager');
            		$this->addContent('tracking_closewindow');
            		return true;
        		}
                
         case "epcedit":   
         
            $bannerID = trim($_POST['txtBannerID']);
            
            // ensure the bannerID is valid, and that we don't already
            // have epc data for it.  - mz 12/19/07
            $sql = 
            "
            select 
               b.bannerid,
               pe.bannerid as epc_banner_id 
            from wd_pa_banners b
            left outer join product_epc pe on b.bannerid = pe.bannerid
            where b.bannerid = '$bannerID'
            and b.deleted = 0            
            ";
            
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            
            if(!$rs)
            {
               QUnit_Messager::setErrorMessage(L_G_DBERROR);
               return false;
            } 
            else
            {                
               if($rs->rowCount() == 0)
               {
                  QUnit_Messager::setErrorMessage(L_G_EPC_BANNER_ID_INVALID);
                  return false; 
               }
               else if($rs->fields['bannerid'] != '' && $rs->fields['epc_banner_id'] != '')
               {
                  QUnit_Messager::setErrorMessage(L_G_EPC_BANNER_ID_ALREADY_HAS_EPC_DATA);
                  return false; 
               }
            }  
            
            $epcOverride = (float)$_POST['txtEpcOverride'];
                             
            $sql = 
            "
            insert into product_epc (bannerid, epc_rate, epc_rate_override, last_change_time, use_override, active)
            values ('$bannerID', 0, $epcOverride, null, 0, 1)
            ";           
            
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if(!$rs)
            {
                  QUnit_Messager::setErrorMessage(L_G_DBERROR);
                  return false;
            } 
            else
            {
               QUnit_Messager::setOkMessage(L_G_RT_EPCADDED);
            
               $this->closeWindow('Affiliate_Merchants_Views_TrackingManager');
               $this->addContent('tracking_closewindow');
               return true;
            }            
    	}

        return false;
    }
    

    //==========================================================================
    // FORMS FUNCTIONS
    //==========================================================================
    function showView()
    {
//        $temp_perm['add'] = $this->checkPermissions('add');
//        $temp_perm['view'] = $this->checkPermissions('view');
//        $this->assign('a_action_permission', $temp_perm);
      
         
		  $mode = $_REQUEST['mode'];
         
        $this->createWhereOrderBy($orderby, $where, $mode);

        $TrackingData = $this->getRecords($orderby, $where, $mode);    
         // TrackingData only has 10 rows of data (vs. 20) when Epc rates
         // are refreshed.  - mz        

        
        $this->initViews($mode);        
        
        $list_data = QUnit_Global::newobj('QCore_RecordSet'); 
        $list_data->setTemplateRS($TrackingData);
        $this->assign('a_list_data', $list_data);

        $this->pageLimitsAssign();
        
      // had to add a new template for the epcedit pg, this
      // gives directive to that tempate.  - mz 12/14/07
      switch ($mode)
      {
         case ('epcedit'):
            $this->addContent('epcedit_list');
         break;
        
         default:
            $this->addContent('tracking_list');
         break;        
      }                          
    }
    //--------------------------------------------------------------------------

    function getRecords($orderby, $where, $mode)
    {
        $TrackingData = array();

    	switch ($mode) {
    		case ("keywords"):
        		// init paging        
        		$sql = 'select count(*) as count from rt_keywords';
        		$limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));

        		// get records
        		$sql = 'select *, '.sqlShortDate('dateinserted').' as joined from rt_keywords ';               
        		
				$rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$orderby, $limitOffset, $_REQUEST['numrows'], __FILE__, __LINE__);
        		if(!$rs) {
            		QUnit_Messager::setErrorMessage(L_G_DBERROR);
            		return false;
        		}

        		// prepare the data
        		while(!$rs->EOF) {
            		$TrackingData[$rs->fields['entryId']]['entryId'] = $rs->fields['entryId'];
            		$TrackingData[$rs->fields['entryId']]['keywordId'] = $rs->fields['keywordId'];
            		$TrackingData[$rs->fields['entryId']]['keyword'] = $rs->fields['keyword'];
					$TrackingData[$rs->fields['entryId']]['ordering'] = $rs->fields['ordering'];
					$TrackingData[$rs->fields['entryId']]['joined'] = $rs->fields['joined'];
		            $rs->MoveNext();      
        		}
                
    			break;

    		case ("merchants"):
        		// init paging        
        		$sql = 'select count(*) as count from rt_keywords';
        		$limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));

        		// get records
        		$sql = 'select *, '.sqlShortDate('dateinserted').' as joined from rt_keywords ';
        		
				$rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$orderby, $limitOffset, $_REQUEST['numrows'], __FILE__, __LINE__);
        		if(!$rs) {
            		QUnit_Messager::setErrorMessage(L_G_DBERROR);
            		return false;
        		}

        		// prepare the data
        		while(!$rs->EOF) {
            		$TrackingData[$rs->fields['merchatId']]['merchantId'] = $rs->fields['merchantId'];
            		$TrackingData[$rs->fields['merchantId']]['short_name'] = $rs->fields['short_name'];
            		$TrackingData[$rs->fields['merchantId']]['longName'] = $rs->fields['longName'];
            		$TrackingData[$rs->fields['merchantId']]['description'] = $rs->fields['longName'];
            		$TrackingData[$rs->fields['merchantId']]['type'] = $rs->fields['longName'];
            		$TrackingData[$rs->fields['merchantId']]['acctId'] = $rs->fields['longName'];
            		$TrackingData[$rs->fields['merchantId']]['addressLine1'] = $rs->fields['addressLine1'];
            		$TrackingData[$rs->fields['merchantId']]['addressLine2'] = $rs->fields['addressLine2'];
            		$TrackingData[$rs->fields['merchantId']]['city'] = $rs->fields['city'];
            		$TrackingData[$rs->fields['merchantId']]['state'] = $rs->fields['state'];
            		$TrackingData[$rs->fields['merchantId']]['zipCode'] = $rs->fields['zipCode'];
            		$TrackingData[$rs->fields['merchantId']]['phone'] = $rs->fields['phone'];
            		$TrackingData[$rs->fields['merchantId']]['contact'] = $rs->fields['contact'];
            		$TrackingData[$rs->fields['merchantId']]['notes'] = $rs->fields['notes'];
            		$TrackingData[$rs->fields['merchantId']]['active'] = $rs->fields['active'];
					$TrackingData[$rs->fields['merchantId']]['joined'] = $rs->fields['joined'];
		            $rs->MoveNext();      
        		}
                
    			break;

    		case ("pages"):
        		// init paging        
        		$sql = 'select count(*) as count from pages';
        		$limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));

        		// get records
        		$sql = 'select *, '.sqlShortDate('insert_time').' as joined from pages ';
        		
				//echo $sql.$where.$orderby, $limitOffset;
				$rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$orderby, $limitOffset, $_REQUEST['numrows'], __FILE__, __LINE__);
        		if(!$rs) {
            		QUnit_Messager::setErrorMessage(L_G_DBERROR);
            		return false;
        		}

        		// prepare the data
        		while(!$rs->EOF) {
            		//$TrackingData[$rs->fields['entryId']]['entryId'] = $rs->fields['entryId'];
            		$TrackingData[$rs->fields['page_id']]['page_id'] = $rs->fields['page_id'];
            		$TrackingData[$rs->fields['page_id']]['page_name'] = $rs->fields['page_name'];
					$TrackingData[$rs->fields['page_id']]['joined'] = $rs->fields['joined'];
		            $rs->MoveNext();      
        		}
                
    			break;
    		case ("timeslots"):
        		// init paging        
        		$sql = 'select count(*) as count from rt_timeslots';
        		$limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));

        		// get records
        		$sql = 'select *, '.sqlShortDate('dateinserted').' as joined from rt_timeslots ';
        		
				$rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$orderby, $limitOffset, $_REQUEST['numrows'], __FILE__, __LINE__);
        		if(!$rs) {
            		QUnit_Messager::setErrorMessage(L_G_DBERROR);
            		return false;
        		}

        		// prepare the data
        		while(!$rs->EOF) {
            		$TrackingData[$rs->fields['entryId']]['entryId'] = $rs->fields['entryId'];
            		$TrackingData[$rs->fields['entryId']]['timeslotId'] = $rs->fields['timeslotId'];
            		$TrackingData[$rs->fields['entryId']]['timeslotName'] = $rs->fields['timeslotName'];
					$TrackingData[$rs->fields['entryId']]['joined'] = $rs->fields['joined'];
		            $rs->MoveNext();      
        		}
                
    			break;

    		case ("trackers"):            
        		// init paging        
        		$sql = 'select count(*) as count from rt_trackers';
        		$limitOffset = initPaging($this->getTotalNumberOfRecords($sql));

        		// get records
        		$sql = 'select *, '.sqlShortDate('dateinserted').' as joined from rt_trackers ';

				$rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$orderby, $limitOffset, $_REQUEST['numrows'], __FILE__, __LINE__);
        		if(!$rs) {
            		QUnit_Messager::setErrorMessage(L_G_DBERROR);
            		return false;
        		}

        		// prepare the data
        		while(!$rs->EOF) {
            		$TrackingData[$rs->fields['entryId']]['entryId'] = $rs->fields['entryId'];
            		$TrackingData[$rs->fields['entryId']]['trackerId'] = $rs->fields['trackerId'];
            		$TrackingData[$rs->fields['entryId']]['trackerName'] = $rs->fields['trackerName'];
					$TrackingData[$rs->fields['entryId']]['joined'] = $rs->fields['joined'];
		            $rs->MoveNext();      
        		}
                
    			break;
                
         case ("epcedit"):            
            // init paging       
            $sql = 
            "
            select count(*) as count from product_epc pe
            inner join wd_pa_banners b on pe.bannerid = b.bannerid
               and pe.active = 1
               and b.deleted = 0
            inner join wd_pa_campaigns c on b.campaignid = c.campaignid
               and c.deleted = 0
            inner join merchants m on c.merchant_id = m.merchant_id
            ";           
            
            // if all records should be shown, empty the where clause and get the
            // number of rows to return from the total count of records sql above.  - mz 1/11/08
            if(isset($_REQUEST['alphabetFilter']) && $_REQUEST['alphabetFilter'] == 'All')
            { 
               $where = '';
               $_REQUEST['numrows'] = $this->getTotalNumberOfRecords($sql);
            }
            
            $limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));            
            
            // added where 1 = 1 to begin the where clause.  The $where var appends
            // to it using "and ...".  - mz 12/20/07
            $sql =
            "
            select               
               pe.bannerid,
               c.name as product_name,
               m.short_name,
               pe.sale_rate,
               pe.sale_price,
               pe.epc_rate,
               pe.epc_rate_override,
               pe.use_override,
               pe.last_change_time
            from product_epc pe
            inner join wd_pa_banners b on pe.bannerid = b.bannerid
               and pe.active = 1
               and b.deleted = 0
            inner join wd_pa_campaigns c on b.campaignid = c.campaignid               
               and c.deleted = 0
            inner join merchants m on c.merchant_id = m.merchant_id               
            where 1 = 1                                
            ";

            $rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$orderby, $limitOffset, $_REQUEST['numrows'], __FILE__, __LINE__);
                                    
                                  
                                    
            if(!$rs) {
                  QUnit_Messager::setErrorMessage(L_G_DBERROR);
                  return false;
            }
            
            // prepare the data             
            while(!$rs->EOF)
            {               
               $TrackingData[$rs->fields['bannerid']]['bannerid'] = $rs->fields['bannerid'];
               $TrackingData[$rs->fields['bannerid']]['product_name'] = $rs->fields['product_name'];
               $TrackingData[$rs->fields['bannerid']]['short_name'] = $rs->fields['short_name'];
               $TrackingData[$rs->fields['bannerid']]['sale_rate'] = $rs->fields['sale_rate'];
               $TrackingData[$rs->fields['bannerid']]['sale_price'] = $rs->fields['sale_price'];
               $TrackingData[$rs->fields['bannerid']]['epc_rate'] = $rs->fields['epc_rate'];
               $TrackingData[$rs->fields['bannerid']]['epc_rate_override'] = $rs->fields['epc_rate_override'];
               $TrackingData[$rs->fields['bannerid']]['last_change_time'] = $rs->fields['last_change_time'];
               $TrackingData[$rs->fields['bannerid']]['use_override'] = $rs->fields['use_override'];
               $rs->MoveNext();      
            }
                
            break;
        }
        
        return $TrackingData;
    }

    //--------------------------------------------------------------------------

    function drawFormEditKeyword()
    {
        if($_POST['commited'] != 'yes') $this->loadKeywordInfo($_REQUEST['entryId']);

		$_POST['entryId'] = $_REQUEST['entryId'];
        $_POST['header'] = L_G_RT_EDITKEYWORD;
        $_POST['action'] = 'edit';
        $_POST['postaction'] = 'editRT';  

        $this->drawFormAddKeyword();
        return true;
    }
  
    function drawFormEditPage()
    {
        if($_POST['commited'] != 'yes') $this->loadPageInfo($_REQUEST['entryId']);

        $_POST['header'] = L_G_RT_EDITPAGE;
        $_POST['action'] = 'edit';
        $_POST['postaction'] = 'editRT';  

        $this->drawFormAddPage();
        return true;
    }
  
    function drawFormEditTimeslot()
    {
        if($_POST['commited'] != 'yes') $this->loadTimeslotInfo($_REQUEST['entryId']);

		$_POST['entryId'] = $_REQUEST['entryId'];
        $_POST['header'] = L_G_RT_EDITTIMESLOT;
        $_POST['action'] = 'edit';
        $_POST['postaction'] = 'editRT';
        $this->drawFormAddTimeslot();
        return true;
    }
  
    function drawFormEditTracker()
    {
        if($_POST['commited'] != 'yes') $this->loadTrackerInfo($_REQUEST['entryId']);

		$_POST['entryId'] = $_REQUEST['entryId'];
        $_POST['header'] = L_G_RT_EDITTRACKER;
        $_POST['action'] = 'edit';
        $_POST['postaction'] = 'editRT';  

        $this->drawFormAddTracker();
        return true;
    }
  
    //--------------------------------------------------------------------------

    function drawFormAddKeyword()
    {
        if(!isset($_POST['postaction'])) $_POST['postaction'] = 'addRT';  
		if(!isset($_POST['action'])) $_POST['action'] = 'add';
        if(!isset($_POST['header'])) $_POST['header'] = L_G_RT_ADDKEYWORD;

        $this->addContent('rt_keyword_edit');
        return true;
    }
	
    function drawFormAddPage()
    {
        if(!isset($_POST['postaction'])) $_POST['postaction'] = 'addRT';  
		if(!isset($_POST['action'])) $_POST['action'] = 'add';
        if(!isset($_POST['header'])) $_POST['header'] = L_G_RT_ADDPAGE;

        $this->addContent('rt_page_edit');
        return true;
    }
	
    function drawFormAddTimeslot()
    {
        if(!isset($_POST['postaction'])) $_POST['postaction'] = 'addRT';  
		if(!isset($_POST['action'])) $_POST['action'] = 'add';
        if(!isset($_POST['header'])) $_POST['header'] = L_G_RT_ADDTIMESLOT;

        $this->addContent('rt_timeslot_edit');
        return true;
    }
	
    function drawFormAddTracker()
    {
        if(!isset($_POST['postaction'])) $_POST['postaction'] = 'addRT';  
		if(!isset($_POST['action'])) $_POST['action'] = 'add';
        if(!isset($_POST['header'])) $_POST['header'] = L_G_RT_ADDTRACKER;

        $this->addContent('rt_tracker_edit');
        return true;
    }
    
    function drawFormAddEpc()
    {
      if(!isset($_POST['postaction'])) $_POST['postaction'] = 'addRT';  
      if(!isset($_POST['action'])) $_POST['action'] = 'add';
      if(!isset($_POST['header'])) $_POST['header'] = L_G_RT_ADDEPC;
      // marco

      $this->addContent('rt_epc_edit');
      return true;
    }    
	
    //==========================================================================
    // OTHER FUNCTIONS
    //==========================================================================

   //--------------------------------------------------------------------------
    
    /** returns list of columns in list view */
    function getAvailableColumns()
    {
        $a = array();
        
        switch ($_REQUEST['mode']) {
        	case "keywords":
        		$a = array(
            		'keywordId' =>         	array("Keyword ID", 'keywordId'),
            		'keyword' =>       		array("Keyword", 'keyword'),
            		'joined' =>   			array(L_G_JOINED, 'joined'),
					'actions' =>            array(L_G_ACTIONS, ''),
			        );
			   	break;

        	case "merchants":
        		$a = array(
            		'merchantId' =>         array("Merchant ID", 'merchantId'),
            		'shortName' =>       	array("Short Name", 'shortName'),
            		'longName' =>       	array("Long Name", 'longName'),
            		'description' =>       	array("Description", 'description'),
            		'type' =>       		array("Type", 'type'),
            		'acctId' =>       		array("Account ID", 'acctId'),
            		'addressLine1' =>       array("Address Line 2", 'addressLine1'),
            		'addressLine2' =>       array("Address Line 2", 'addressLine2'),
            		'city' =>       		array("City", 'city'),
            		'state' =>       		array("State", 'state'),
            		'zipCode' =>       		array("Zip", 'zipCode'),
            		'phone' =>       		array("Phone", 'phone'),
            		'contact' =>       		array("Contact", 'contact'),
            		'notes' =>       		array("Notes", 'notes'),
            		'active' =>       		array("Active", 'active'),
            		'joined' =>   			array(L_G_JOINED, 'joined'),
					'merchactions' =>            array(L_G_ACTIONS, ''),
			        );
			   	break;

        	case "pages":
        		$a = array(
            		'page_id' =>         	array("Page ID", 'page_id'),
            		'page_name' =>       	array("Page Name", 'page_name'),
            		'joined' =>   			array(L_G_JOINED, 'joined'),
					'pageactions' =>            array(L_G_ACTIONS, ''),
			        );
			   	break;
			   	
        	case "timeslots":
        		$a = array(
            		'timeslotId' =>         array("Timeslot ID", 'timeslotId'),
            		'timeslotName' =>       array("Timeslot Name", 'timeslotName'),
            		'joined' =>   			array(L_G_JOINED, 'joined'),
					'actions' =>            array(L_G_ACTIONS, ''),
			        );
			   	break;

        	case "trackers":
        		$a = array(
            		'trackerId' =>         	array("Tracker ID", 'trackerId'),
            		'trackerName' =>       	array("Tracker Name", 'trackerName'),
            		'joined' =>   			array(L_G_JOINED, 'joined'),
					'actions' =>            array(L_G_ACTIONS, ''),
			        );
			   	break;
                
         case "epcedit":
            $a = array(
                  'bannerid' =>           array('Banner ID', 'pe.bannerid'),
                  'product_name' =>        array('Product Name', 'c.name'),
                  'short_name' =>        array('Merchant', 'm.short_name'),
                  'sale_rate' =>          array('Sale Rate', 'pe.sale_rate'),
                  'sale_price' =>         array('Sale Price', 'pe.sale_price'),
                  'epc_rate' =>           array('EPC Rate', 'pe.epc_rate'),
                  'epc_rate_override' =>  array('EPC Override', 'pe.epc_rate_override'),
                  'use_override' =>  array('Use Override', 'pe.use_override'),
                  'last_change_time' =>   array('Last Change Time', 'pe.last_change_time'),
                 );
               break;
        }
                 
        return $a;
    }
    
	//--------------------------------------------------------------------------

    function getListViewName()
    {
        return "tracking_list";
    }
    
    //--------------------------------------------------------------------------

    function initViews($mode)
    {
    	$viewColumns = array();
    	
    	switch ($mode) {
			case ("keywords"):
				$viewColumns = array(
							'keywordId',
            				'keyword',
            				'joined',
							'actions',
        					);
        		break;
        		
			case ("merchants"):
				$viewColumns = array(
							'merchantId',
            				'shortName',
            				'longName',
            				'description',
            				'type',
            				'acctId',
            				'addressLine1',
            				'addressLine2',
            				'city',
            				'state',
            				'zipCode',
            				'phone',
            				'contact',
            				'notes',
            				'active',
            				'joined',
							'merchactions',
        					);
        		break;
        		
			case ("pages"):
				$viewColumns = array(
							'page_id',
            				'page_name',
            				'joined',
							'pageactions',
        					);
        		break;

			case ("timeslots"):
				$viewColumns = array(
							'timeslotId',
            				'timeslotName',
            				'joined',
							'actions',
        					);
        		break;
        		
			case ("trackers"):
				$viewColumns = array(
							'trackerId',
            				'trackerName',
            				'joined',
							'actions',
        					);
        		break;

         case ("epcedit"):
            $viewColumns = array(
                        'bannerid',
                        'product_name',
                        'short_name',
                        'sale_rate',
                        'sale_price',
                        'epc_rate',
                        'epc_rate_override',
                        'use_override',
                        'last_change_time',
                        );
            break;        		
    	}
    	
        $this->createDefaultView($viewColumns);
        
        $this->loadAvailableViews();
        
        $tplAvailableViews = array();
        foreach($this->availableViews as $objView)
        {
            $tplAvailableViews[$objView->dbid] = $objView->getName();
        }
        
       $this->assign('a_list_views', $this->tplAvailableViews);
        
        $this->applyView();
    }

    //--------------------------------------------------------------------------

    function createWhereOrderBy(&$orderby, &$where, $mode)
    {
        $orderby = '';
        // changed from an empty string to deleted = 0.  It was being
        // set after the switch expression, but I needed to empty it
        // for the epc_edit case below.  - mz 12/17/07
        $where = ' where deleted=0';
        
        $a = array();
        switch ($mode) {
        	case "keywords":
        		$a = array( 
            		'keywordId',
            		'keyword',
            		'joined', 
 	        		);
        		break;
        	case "merchants":
        		$a = array( 
            		'merchantId',
            		'shortName',
            		'longName',
            		'description',
            		'type',
            		'acctId',
            		'addressLine1',
            		'addressLine2',
            		'city',
            		'state',
            		'zipCode',
            		'phone',
            		'contact',
            		'notes',
            		'active',
            		'joined', 
 	        		);
 	        	break;
        	case "pages":
        		$a = array( 
            		'page_id',
            		'page_name',
            		'joined', 
 	        		);
 	        	break;
        	case "timeslots":
        		$a = array( 
            		'timeslotId',
            		'timeslotNames',
            		'joined', 
 	        		);
 	        	break;
        	case "trackers":
        		$a = array( 
            		'trackerId',
            		'trackerName',
            		'joined', 
 	        		);
 	        	break;
                
         case "epcedit":
            // now setting the default order by here, to avoid the generic
            // "order by ordering" assigned below.  - mz 12/14/07
            
            if(empty($_REQUEST['sortby']))
            {
               $_REQUEST['sortby'] =  'pe.bannerid';
            }
                      
            $a = array('pe.bannerid','c.name','m.short_name','pe.sale_rate','pe.sale_price','pe.epc_rate','pe.epc_rate_override','pe.use_override','pe.last_change_time',);
            //reset the where clause.  The qry that pulls epc data will break otherwise.  - mz 12/17/07
            $where = '';           
            
            break;                
        }
         
        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a)) {
            $orderby = ' order by '.$_REQUEST['sortby'].' '.$_REQUEST['sortorder'];
        }
        else {            
            $orderby = ' order by ordering desc, '.$a[0]; 
        }
        
        // product_epc no longer has a "deleted".  $where is now initialized above the
        // switch statement, and emptied in the epcedit case.
        // $where = ' where deleted=0 ';
        
        if($_REQUEST['search'] != null){
        	$where .= ' AND (' . $a[0] .' = ' . _q($_REQUEST['search']) . ' OR  ' . 
        	$a[1] . ' LIKE ' . _q('%'. $_REQUEST['search'] .'%') .')';
        }
        // check if the user clicked on the alphabet filter.  This assumes the alphabet 
        // filter and search box are mutually exclusive features...the user can only use
        // 1 or the other.
        else if(!empty($_REQUEST['alphabetFilter']))        
        {
         $where .= ' AND (' . $a[1] .' LIKE ' . _qWithAppendingWildCard($_REQUEST['alphabetFilter']).')';
        }
        
        //         '   and a.rtype='._q(USERTYPE_USER).
        //         '   and accountid='._q($GLOBALS['Auth']->getAccountID());

        return true;
    }
    
    //--------------------------------------------------------------------------

    function printListRow($row)
    {
		
		$view = $this->getView();
        if($view == false || $view == null)
        {
            print '<td><font color="ff0000">no view given</font></td>';
            return false;
        }
        
         // added this for the epc edit form.  All other forms were using this, so
         // currently an epcedit mode is the only thing that stops the check all
         // column. - mz 12/14/07
         
         switch($_REQUEST['mode'])
         {
            case 'epcedit':
               $printCheckAllColumn = false;               
            break;
            
            default: $printCheckAllColumn = true;            
         }
        
        if($printCheckAllColumn === true)
        {
           print '<td class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="'.$row['entryId'].'"></td>';
        }        
        
        foreach($view->columns as $column)
        {        
            switch($column)
            {
                case 'keywordId': print '<td class=listresult nowrap>&nbsp;'.$row['keywordId'].'&nbsp;</td>';
                        break;
				
				case 'keyword': print '<td class=listresult>&nbsp;'.$row['keyword'].'&nbsp;</td>';
                        break;
                
				case 'page_id': print '<td class=listresult>&nbsp;'.$row['page_id'].'&nbsp;</td>';
                        break;
                
				case 'page_name': print '<td class=listresult>&nbsp;'.$row['page_name'].'&nbsp;</td>';
                        break;
                
                case 'timeslotId': print '<td class=listresult nowrap>&nbsp;'.$row['timeslotId'].'&nbsp;</td>';
                        break;
                        
                case 'timeslotName': print '<td class=listresult nowrap>&nbsp;'.$row['timeslotName'].'&nbsp;</td>';
                        break;
                        
                case 'trackerId': print '<td class=listresult nowrap>&nbsp;'.$row['trackerId'].'&nbsp;</td>';
                        break;
                        
                case 'trackerName': print '<td class=listresult nowrap>&nbsp;'.$row['trackerName'].'&nbsp;</td>';
                        break;
                        
                case 'merchantId': print '<td class=listresult nowrap>&nbsp;'.$row['merchantId'].'&nbsp;</td>';
                        break;
                        
                case 'shortName': print '<td class=listresult nowrap>&nbsp;'.$row['shortName'].'&nbsp;</td>';
                        break;
                        
                case 'longName': print '<td class=listresult nowrap>&nbsp;'.$row['longName'].'&nbsp;</td>';
                        break;
                        
                case 'description': print '<td class=listresult nowrap>&nbsp;'.$row['description'].'&nbsp;</td>';
                        break;
                        
                case 'type': print '<td class=listresult nowrap>&nbsp;'.$row['type'].'&nbsp;</td>';
                        break;
                        
                case 'acctId': print '<td class=listresult nowrap>&nbsp;'.$row['acctId'].'&nbsp;</td>';
                        break;
                        
                case 'addressLine1': print '<td class=listresult nowrap>&nbsp;'.$row['addressLine1'].'&nbsp;</td>';
                        break;
                        
                case 'addressLine2': print '<td class=listresult nowrap>&nbsp;'.$row['addressLine2'].'&nbsp;</td>';
                        break;
                        
                case 'city': print '<td class=listresult nowrap>&nbsp;'.$row['city'].'&nbsp;</td>';
                        break;
                        
                case 'state': print '<td class=listresult nowrap>&nbsp;'.$row['state'].'&nbsp;</td>';
                        break;
                        
                case 'zipCode': print '<td class=listresult nowrap>&nbsp;'.$row['zipCode'].'&nbsp;</td>';
                        break;
                        
                case 'phone': print '<td class=listresult nowrap>&nbsp;'.$row['phone'].'&nbsp;</td>';
                        break;
                        
                case 'contact': print '<td class=listresult nowrap>&nbsp;'.$row['contact'].'&nbsp;</td>';
                        break;
                        
                case 'notes': print '<td class=listresult nowrap>&nbsp;'.$row['notes'].'&nbsp;</td>';
                        break;
                        
                case 'active': print '<td class=listresult nowrap>&nbsp;'.$row['active'].'&nbsp;</td>';
                        break;
                        
                case 'joined': print '<td class=listresult nowrap>&nbsp;'.$row['joined'].'&nbsp;</td>';
                        break;
                        
                case 'actions':
?>                
                        <td class=listresult>
                            <select name=action_select OnChange="performAction(this);">
                                <option value="-">------------------------</option>
                                <option value="javascript:editRT('<?=$row['entryId']?>','<?=$_REQUEST['mode']?>');"><?=L_G_EDIT?></option>
                                <option value="javascript:Delete('<?=$row['entryId']?>','<?=$_REQUEST['mode']?>');"><?=L_G_DELETE?></option>                      
                            </select>
                        </td>
<?
                        break;
                case 'merchactions':
?>                
                        <td class=listresult>
                            <select name=action_select OnChange="performAction(this);">
                                <option value="-">------------------------</option>
                                <option value="javascript:editRT('<?=$row['entryId']?>','<?=$_REQUEST['mode']?>');"><?=L_G_EDIT?></option>
                                <option value="javascript:Delete('<?=$row['entryId']?>','<?=$_REQUEST['mode']?>');"><?=L_G_DELETE?></option>                      
                            </select>
                        </td>
<?
                        break;
                        
                case 'pageactions':
?>                
                        <td class=listresult>
                            <select name=action_select OnChange="performAction(this);">
                                <option value="-">------------------------</option>
                                <option value="javascript:editRT('<?=$row['page_id']?>','<?=$_REQUEST['mode']?>');"><?=L_G_EDIT?></option>
                                <option value="javascript:Delete('<?=$row['page_id']?>','<?=$_REQUEST['mode']?>');"><?=L_G_DELETE?></option>                      
                            </select>
                        </td>
<?
                        break;
                        
                // added for epc edit.  - mz 12/14/07    
                          
                case 'bannerid':  
                  print '<td class=listresult nowrap>&nbsp;'.$row['bannerid'].'&nbsp;</td>';
                break;
                
                case 'product_name':  
                  print '<td class="listresult" nowrap>&nbsp;'.$row['product_name'].'&nbsp;</td>';
                break;
                case 'short_name':  
                  print '<td class="listresult" nowrap>&nbsp;'.$row['short_name'].'&nbsp;</td>';
                break;
                
                case 'sale_rate':  
                  print '<td class="listresult" nowrap>&nbsp;'.$row['sale_rate'].'&nbsp;</td>';
                break;
                
                case 'sale_price':  
                  print '<td class="listresult" nowrap>&nbsp;'.$row['sale_price'].'&nbsp;</td>';
                break;
                
                case 'epc_rate':
                  print '<td class=listresult nowrap>&nbsp;'.$row['epc_rate'].'&nbsp;</td>';
                break;       
                
                case 'epc_rate_override': 
                  // if we have no override value, it's b/c there is no epc data for this product.  Do not 
                  // render a text field in such cases, epc data should first be added (through some other method)
                  // before an override can be entered.  - mz 12/18/07
                  if($row['epc_rate'] != '')
                  {
                     print '<td class=listresult nowrap><input type="text" name="'.$this->_epcTextFieldPrefix.$row['bannerid'].'" value="'.$row['epc_rate_override'].'" size="6" maxlength="6"></td>';
                  }
                  else
                  {
                     print '<td class=listresult>&nbsp;</td>';
                  }
                  
                break;   
                
                case 'use_override': 
                  // if we have no override value, it's b/c there is no epc data for this product.  Do not 
                  // render a text field in such cases, epc data should first be added (through som other method)
                  // before an override can be entered.  - mz 12/18/07
                  if($row['epc_rate'] != '')
                  {                    
                     if($row['use_override'] == 1)
                     {
                        $checked = 'checked';                        
                     }
                     else
                     {
                        $checked = '';                        
                     }
                     
                     print '<td class=listresult nowrap><input type="checkbox" name="'.$this->_useOverrideCheckboxPrefix.$row['bannerid'].'" '.$checked.'></td>';      
                  }
                  else
                  {
                     print '<td class=listresult>&nbsp;</td>';
                  }
                  
                break;                    
                
                case 'last_change_time': 
                  print '<td class=listresult nowrap>&nbsp;'.$row['last_change_time'].'&nbsp;</td>';
                break;                                                       

                default: 
                        print '<td class=listresult>&nbsp;<font color="#ff0000">'.L_G_UNKNOWN.'</font>&nbsp;</td>';
                        break;
            }           
        }
    }
    
    //--------------------------------------------------------------------------

    function printMassAction()
    {
?>
      <td align=left>&nbsp;&nbsp;&nbsp;<?=L_G_SELECTED;?>&nbsp;
        <select name="massaction">
          <option value="-"><?=L_G_CHOOSEACTION?></option>
          <? if($this->checkPermissions('delete')) { ?>
               <option value="delete"><?=L_G_DELETE?></option>
          <? } ?>
        </select>
        &nbsp;&nbsp;
        <input type="submit" class="formbutton" value="<?=L_G_SUBMITMASSACTION?>">
      </td>
<?
    }
    
    /**
     * Author:mz
     * Date:  12:17:07
     * Desc:  Added to return a submit button.  Didn't use printMassAction() (above)
     *        b/c I wanted to change the label and alignment of the button.  Plus
     *        I didn't need the select list.
     **/
    function printSubmitButton($value = "Submit")
    {
?>      
        <input type="submit" class="formbutton" value="<? print $value; ?>">    
<?
    }
    
     /**
     * Author:mz
     * Date:  12:17:07
     * Desc:  Returns a button.  
     **/
    function printButton($value = "Submit", $onClick = '')
    {
       if($onClick != '')
       {
         $onClick = 'onClick="'.$onClick.'"';
       }               
?>      
        <input type="button" class="formbutton" value="<? print $value; ?>" <? print $onClick; ?>>    
<?
    }    
    
    function loadKeywordInfo($entryId)
     {
        $sql = 'select * from rt_keywords '.
               'where deleted=0 '.
               '  and entryId='.$entryId;
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs || $rs->EOF)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $_POST['keywordId'] = $rs->fields['keywordId'];
        $_POST['keyword'] = $rs->fields['keyword'];
		$_POST['entryId'] = $rs->fields['entryId'];
		$_POST['ordering'] = $rs->fields['ordering'];

        return true;
    }
	
    function loadPageInfo($entryId)
     {
        $sql = 'select * from pages '.
               'where deleted=0 '.
               '  and page_id= '. _q($entryId);
        
        //echo $sql;
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs || $rs->EOF)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $_POST['pageId'] = $rs->fields['page_id'];
        $_POST['pageName'] = $rs->fields['page_name'];
		//$_POST['entryId'] = $rs->fields['entryId'];
		$_POST['ordering'] = $rs->fields['ordering'];

        return true;
    }
	
    function loadTimeslotInfo($entryId)
     {
        $sql = 'select * from rt_timeslots '.
               'where deleted=0 '.
               '  and entryId='.$entryId;
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs || $rs->EOF)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $_POST['timeslotId'] = $rs->fields['timeslotId'];
        $_POST['timeslotName'] = $rs->fields['timeslotName'];
		$_POST['entryId'] = $rs->fields['entryId'];
		$_POST['ordering'] = $rs->fields['ordering'];

        return true;
    }
	
    function loadTrackerInfo($entryId)
     {
        $sql = 'select * from rt_trackers '.
               'where deleted=0 '.
               '  and entryId='.$entryId;
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs || $rs->EOF)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $_POST['trackerId'] = $rs->fields['trackerId'];
        $_POST['trackerName'] = $rs->fields['trackerName'];
		$_POST['entryId'] = $rs->fields['entryId'];
		$_POST['ordering'] = $rs->fields['ordering'];

        return true;
    }
    
    function returnEIDs()
    {
        if($_POST['massaction'] != '')
        {
            $eIDs = $_POST['itemschecked'];
        }
        else
        {
            $eIDs = array($_REQUEST['entryId']);
        }
        
        return $eIDs;
    }	
    
    function printTrackingAvailableViews($className)
    {
        $listViewName = $this->getListViewName();
        if($listViewName == '') {
            return false;
        }
            
        print '&nbsp;'.L_G_LISTVIEW.'&nbsp;<select name="list_view">';
        
        foreach($this->availableViews as $objView) {
            print '<option value="'.$objView->dbid.'" '.($_REQUEST['list_view'] == $objView->dbid ? 'selected' : '').'>'.$objView->getName().'</option>';
        }
        
        print '</select>&nbsp;<input type="button" onClick="submitTrackingView()" value="'.L_G_CHANGEVIEW.'">';
        
        print '&nbsp;&nbsp;&nbsp;';
        if($_REQUEST['list_view'] != '_' && $_REQUEST['list_view'] != '')
        {
            print '<a class="simplelink" href="javascript:editTrackingView(\''.$_REQUEST['list_view'].'\', \''.$className.'\');">'.L_G_EDITVIEW.'</a>';
            print '&nbsp;&nbsp;|&nbsp;&nbsp;';
            print '<a class="simplelink" href=\'javascript:deleteTrackingView("'.$_REQUEST['list_view'].'", "'.$className.'", "'.L_G_CONFIRMDELETEVIEW.'");\'>'.L_G_DELETEVIEW.'</a>';
            print '&nbsp;&nbsp;|&nbsp;&nbsp;';
        }
        print '<a class="simplelink" href="javascript:addTrackingView(\''.$className.'\');">'.L_G_NEWVIEW.'</a>';
    }
}  
?>