<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QCore_EmailTemplates');
QUnit_Global::includeClass('QCore_Bl_Communications');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Rules');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_Registrator');

class Affiliate_Scripts_Bl_SaleRegistrator extends Affiliate_Scripts_Bl_Registrator
{
    var $className = 'Affiliate_Scripts_Bl_SaleRegistrator';
    var $multiTierSaleCommissionsCounter = 0;
    var $multiTierSaleRecurCommissionsCounter = 0;
    
    //--------------------------------------------------------------------------
    
    function findPaymentBySubscriptionID($orderID)
    {
        if(trim($orderID) == '')
            return false;
        
        // search transactions if we'll find sale with this order ID
        $sql = "select * from wd_pa_transactions where transtype=".TRANSTYPE_SALE." and transkind=".TRANSKIND_NORMAL.
            " and orderid="._q(trim($orderID));
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            $errorMsg = "Sale/Lead registration: Error checking for initial subscription payment for transaction '$orderID'";
            LogError($errorMsg, __FILE__, __LINE__);
            return false;
        }
        
        if($rs->EOF)
        {
            $errorMsg = "Sale/Lead registration: No initial subscription payment for transaction '$orderID' found.";
            LogError($errorMsg, __FILE__, __LINE__);
            return false;
        }
        
        $userID = $rs->fields['affiliateid'];
        
        // find campaign
        $sql = 'select * from wd_pa_campaigncategories '.
               'where deleted=0 and campcategoryid='._q($rs->fields['campcategoryid']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            $errorMsg = "Sale/Lead registration: Error checking for campaign of initial subscription payment for transaction '$orderID'";
            LogError($errorMsg, __FILE__, __LINE__);
            return false;
        }
        
        if($rs->EOF)
        {
            $errorMsg = "Sale/Lead registration: No campaign for initial subscription payment for transaction '$orderID' found.";
            LogError($errorMsg, __FILE__, __LINE__);
            return false;
        }
        
        $campaignID = $rs->fields['campaignid'];
        
        return $this->initData($userID, $campaignID);
    }
    
    //--------------------------------------------------------------------------
    
    function setSaleTypeAndKind($type, $kind)
    {
        if(in_array($type, array(TRANSTYPE_CLICK, TRANSTYPE_SALE, TRANSTYPE_RECURRING)))
            $this->saleType = $type;
        
        if(in_array($kind, array(TRANSKIND_NORMAL, TRANSKIND_SECONDTIER, TRANSKIND_RECURRING)))
            $this->saleKind = $kind;
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    /** decodes data from cookie or other source, 
    * finds user id and campaign id 
    */
    function decodeData($value, $userID = '')
    {
        // decode from cookie
        $data = $this->decodeValue($value, $userID);

        $this->settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $this->AccountID);

        // decode from session
        if(!$data && $this->settings['Aff_track_by_session'] == 1)
        {
            QCore_History::writeHistory(WLOG_DEBUG, "Sale/Lead registration: Tracking referrer from session", __FILE__, __LINE__);
            $data = $this->decodeValue($_SESSION[COOKIE_NAME]);
        }

        // decode from IP
        if(!$data && $this->settings['Aff_track_by_ip'] == 1)
        {
            QCore_History::writeHistory(WLOG_DEBUG, "Sale/Lead registration: Tracking referrer from IP", __FILE__, __LINE__);
            $data = $this->decodeFromIP($value);
        }

        // use referred affiliate
        if(!$data && $this->settings['Aff_referred_affiliate_allow'] == 1)
        {
            QCore_History::writeHistory(WLOG_DEBUG, "Sale/Lead registration: Tracking referrer from settings", __FILE__, __LINE__);
            $data = $this->getUsersCampaign($this->settings['Aff_referred_affiliate']);
        }

        if(!$data) return false;

        return $this->initData($data[0], $data[1]);
    }
    
    //--------------------------------------------------------------------------
    
    function initData($userID, $campaignID)
    {
        QCore_History::writeHistory(WLOG_DEBUG, "Sale/Lead registration: Referer recognized (User ID: $userID, Product category ID: $campaignID)", __FILE__, __LINE__);
        
        //------------------------------------------------------------------------
        // check user and campaign
        if(!$this->checkUserExists($userID))
        {
            $errorMsg = "Sale/Lead registration: User with ID '$userID' doesn't exist";
            LogError($errorMsg, __FILE__, __LINE__);
            return false;
        }
        QCore_History::writeHistory(WLOG_DEBUG, "Sale/Lead registration: After checking that user exists, OK", __FILE__, __LINE__);

        if(!$this->checkCampaignExists($campaignID))
        {
            $errorMsg = "Sale/Lead registration: Campaign with ID '$campaignID' doesn't exist";
            LogError($errorMsg, __FILE__, __LINE__);
            return false;
        }
        QCore_History::writeHistory(WLOG_DEBUG, "Sale/Lead registration: After checking that product category exists, OK", __FILE__, __LINE__);

        if(!$this->checkUserInCampaign())
        {
            $errorMsg = "Sale/Lead registration: User ID '$userID' doesn't belong to the campaign ID '$campaignID'";
            LogError($errorMsg, __FILE__, __LINE__);
            return false;
        } 
        QCore_History::writeHistory(WLOG_DEBUG, "Sale/Lead registration: After checking that user exists in campaign, OK", __FILE__, __LINE__);
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function registerSale($totalCost, $OrderID, $ProductID)
    {
        $original_totalCost = $totalCost;
        $fixedCost = $this->settings['Aff_fixed_cost'];
        $totalCost = $totalCost - $fixedCost;

        QCore_History::writeHistory(WLOG_DEBUG, "Sale/Lead registration: Compute total cost = total cost - fixed cost: ".$totalCost."=".$totalCost."-".$fixedCost, __FILE__, __LINE__);

        if($this->CampaignCommType == TRANSTYPE_CLICK) 
        {
            // we dont need to save click transactions
            // as they are registered already
            QCore_History::writeHistory(WLOG_DEBUG, "Sale/Lead registration: It is only per click product category", __FILE__, __LINE__);
            return true;
        }

        $remoteAddr = $_SERVER['HTTP_REFERER'];
        $ip = $_SERVER['REMOTE_ADDR'];
        
        if($this->SaleTransactionApproval == APPROVE_MANUAL)
            $status = AFFSTATUS_NOTAPPROVED;
        else
            $status = AFFSTATUS_APPROVED;
        
        if(!is_numeric($totalCost))
            $totalCost = 0;
        
        if(!is_numeric($original_totalCost) || $original_totalCost < 0)
            $original_totalCost = 0;

        //------------------------------------------------------------------------
        // check whether to force product_id-based lookup for commission category
        if($ProductID != '' && $this->settings['Aff_forcecommfromproductid'] == 'yes')
        {
            $result = $this->lookupForProductCategory($ProductID);

            if($result == false && $this->settings['Aff_apply_from_banner'] != '1')
            {
                QCore_History::writeHistory(WLOG_DEBUG, "Sale/Lead registration: No category for ProductID '$ProductID' found for transaction '$OrderID'", __FILE__, __LINE__);
                return false;
            }
        }

        QCore_History::writeHistory(WLOG_DEBUG, "Sale/Lead registration: After lookup for product category", __FILE__, __LINE__);
        
        //------------------------------------------------------------------------
        // check fraud protection
        if(!$this->applyFraudProtection($ip, $status, $OrderID))
            return false;

        QCore_History::writeHistory(WLOG_DEBUG, "Sale/Lead registration: After fraud protection", __FILE__, __LINE__);

        //------------------------------------------------------------------------
        // compute commission    
        if(!($this->CampaignCommType & TRANSTYPE_SALE) && !($this->CampaignCommType & TRANSTYPE_LEAD))
        {
            QCore_History::writeHistory(WLOG_DEBUG, "Sale/Lead registration: Campaign category is not sale or lead", __FILE__, __LINE__);
            return true;
        }

        $commission = $this->computeCommission($totalCost, $this->PerSaleCommType, $this->SaleCommission);

        if($commission == 0)
        {
            QCore_History::writeHistory(WLOG_DEBUG, "Sale/Lead registration: Commission is zero", __FILE__, __LINE__);
        }

        QCore_History::writeHistory(WLOG_DEBUG, "Sale/Lead registration: After computing commission", __FILE__, __LINE__);
        
        $this->setSaleKindAndTypeByCommType();        

        //------------------------------------------------------------------------
        // insert sale
        $params = array('OrderID' => $OrderID,
                        'ProductID' => $ProductID,
                        'original_totalCost' => $original_totalCost,
                        'remoteAddr' => $remoteAddr,
                        'ip' => $ip,
                        'status' => $status,
                        'commission' => $commission
                       );
        if(($TransID = $this->insertSale($params)) == false) return false;

        //----------------------------------------
        // send notifications
        $params = array();
        $params['id'] = $TransID;
        $params['commission'] = $commission;
        $params['totalcost'] = $totalCost;
        $params['orderid'] = $OrderID;
        $params['productid'] = $ProductID;
        $params['date'] = date("Y-m-d h:j:s");
        $params['userid'] = $this->UserID;
        $params['status'] = $status;
        $params['ip'] = $ip;
        $params['referrer'] = $remoteAddr;

        if($status != AFFSTATUS_SUPPRESSED)
        {
            $this->sendNotificationToMerchant($params);
        }

        if($status != AFFSTATUS_SUPPRESSED)
        {
            $this->sendNotificationToUser($params);
        }

        QCore_History::writeHistory(WLOG_DEBUG, "Sale/Lead registration: After sending notifications", __FILE__, __LINE__);
        
        QCore_History::writeHistory(WLOG_DEBUG, "Sale/Lead registration: Start registering multi tier commissions", __FILE__, __LINE__);

        //------------------------------------------
        // register multi tier sale commissions
        $this->registerMultiTierSaleCommission($TransID, $OrderID, $ProductID, $totalCost, $remoteAddr, $ip, $status, $this->UserID, 2);

        QCore_History::writeHistory(WLOG_DEBUG, "Sale/Lead registration: After registering multi tier commissions", __FILE__, __LINE__);
        
        //------------------------------------------------------------------------
        // insert recurring commission
        if($this->settings['Aff_support_recurring_commissions'] != 1 || $this->RecurringCommission == '' || $this->RecurringCommission == '0')
        {
            QCore_History::writeHistory(WLOG_DEBUG, "Sale/Lead registration: No recurring commissions found", __FILE__, __LINE__);
            
            return true;
        }

        QCore_History::writeHistory(WLOG_DEBUG, "Sale/Lead registration: Start registering recurring commissions", __FILE__, __LINE__);
        
        $commission = $this->computeCommission($totalCost, $this->RecurringCommType, $this->RecurringCommission);
        
        $params = array('status' => $status,
                        'TransID' => $TransID
                       );

        if(($RecurringCommissionID = $this->insertRecurringCommission($params)) === false) return false;

        //------------------------------------------
        // register multi tier recurring commissions
        $this->registerMultiTierRecurringCommission($RecurringCommissionID, $totalCost, $this->UserID, 2);

        QCore_History::writeHistory(WLOG_DEBUG, "Sale/Lead registration: After registering recurring commissions", __FILE__, __LINE__);
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function lookupForProductCategory($ProductID)
    {
        // check if there exist some product category that contains this product
        $ProductID = preg_replace('/[\'\"]/', '', $ProductID);
        
        $sql = "select * from wd_pa_campaigns where deleted=0 and products like'%"._q_noendtags($ProductID)."%'";
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            $errorMsg = "Sale/Lead registration: Error saving 2nd tier recurring commission";
            LogError($errorMsg, __FILE__, __LINE__);
            return false;
        }            

        while(!$rs->EOF)
        {
            $products = $rs->fields['products'];
            
            $parts = explode(';', $products);

            foreach($parts as $product_id)
            {
                $product_id = trim($product_id);
                
                if($product_id == $ProductID)
                {
                    // we found it
                    $this->setNewProductCategory($rs->fields['campaignid']);
                    
                    QCore_History::writeHistory(WLOG_DEBUG, "Sale regisrator: Commission from new product category applied (according to Product ID '$ProductID')", __FILE__, __LINE__);
                    
                    return true;
                }
            }
            
            $rs->MoveNext();
        }
        
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function setNewProductCategory($campaignID)
    {
        // check in which comm. category user is & set the correct commissions
        $sql = 'select cc.* from wd_pa_affiliatescampaigns ac, wd_pa_campaigncategories cc '.
            'where cc.campaignid='._q($campaignID).
            '  and cc.campcategoryid=ac.campcategoryid'.
            '  and cc.deleted=0 and affiliateid='._q($this->UserID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        return false;
        
        if($rs->EOF)
        {
            // get basic commission category for this campaign
            $sql = 'select * from wd_pa_campaigncategories '.
                'where deleted=0 and campaignid='._q($campaignID).
                '  and name='._q(UNASSIGNED_USERS);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs || $rs->EOF)
                return false;
        }
        
        $this->CampaignID = $rs->fields['campaignid'];
        $this->CampaignCategoryID = $rs->fields['campcategoryid'];
        $this->ClickCommission = $rs->fields['clickcommission'];
        $this->SaleCommission = $rs->fields['salecommission'];
        
        $this->maxCommissionLevels = $this->settings['Aff_maxcommissionlevels'];
        if($this->maxCommissionLevels == '')
        $this->maxCommissionLevels = 1;
        
        $this->STClickCommission = array();
        $this->STSaleCommission = array();
        $this->STRecurringCommission = array();
        
        for($i=2; $i<=$this->maxCommissionLevels; $i++)
        {
            $this->STClickCommission[$i] = $rs->fields['st'.$i.'clickcommission'];
            $this->STSaleCommission[$i] = $rs->fields['st'.$i.'salecommission'];
            $this->STRecurringCommission[$i] = $rs->fields['st'.$i.'recurringcommission'];
        }
        
        $this->PerSaleCommType = $rs->fields['salecommtype'];
        $this->STPerSaleCommType = $rs->fields['stsalecommtype'];
        
        $this->RecurringCommission = $rs->fields['recurringcommission'];
        $this->RecurringCommType = $rs->fields['recurringcommtype'];
        $this->RecurringCommDate = $rs->fields['recurringcommdate'];
        $this->RecurringDateType = $rs->fields['recurringdatetype'];
        $this->STRecurringCommType = $rs->fields['strecurringcommtype'];
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function applyFraudProtection($ip, &$status, $OrderID)
    {
        if($this->DeclineFrequentSales == 1)
        {
            // find initial click (first non-declined within this day)
            $sql = "select dateinserted as aa from wd_pa_transactions ".
                "where transtype=".TRANSTYPE_SALE.
                "  and transkind=".TRANSKIND_NORMAL." and ip="._q($ip).
                "  and rstatus<>".AFFSTATUS_SUPPRESSED.
                "  and (".sqlTimeToSec(sqlNow())." - ".sqlTimeToSec('dateinserted')."<".$this->SaleFrequency.")";
            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$ret)
            {
                $errorMsg = "Sale registration (fraud protection): Error saving transaction 1";
                LogError($errorMsg, __FILE__, __LINE__);
                return false;
            }

            if(!$ret->EOF)
            {
                if($this->FrequentSales == 2)
                    return false;

                // decline the transaction
                $status = AFFSTATUS_SUPPRESSED;
            }
        }

        if($OrderID != '' && $this->DeclineSameOrderId == 1)
        {
            // find initial click with same OrderID
            $sql = "select orderid as aa from wd_pa_transactions ".
                "where transtype=".TRANSTYPE_SALE.
                "  and transkind=".TRANSKIND_NORMAL.
                "  and ip="._q($ip)." and rstatus<>".AFFSTATUS_SUPPRESSED.
                "  and OrderID="._q($OrderID);
            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            
            if (!$ret)
            {
                $errorMsg = "Sale registration (fraud protection): Error saving transaction 2";
                LogError($errorMsg, __FILE__, __LINE__);
                return false;
            }     

            if(!$ret->EOF)
            {
                // decline the transaction 
                $status = AFFSTATUS_SUPPRESSED;
            }
        }
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function computeCommission($totalCost, $commType, $saleCommission)
    {
        $commission = 0;
        if($totalCost == '' || !is_numeric($totalCost))
            $totalCost = 0;

        // compute commission
        if($commType == '%')
        {
            if($totalCost == '')
            $totalCost = 0;
            
            $commission = round(($totalCost * $saleCommission)/100, 2);
        }
        else
            $commission = $saleCommission;

        if($commission == '')
            $commission = 0;
        
        return $commission;
    }
    
    //--------------------------------------------------------------------------
    
    function setSaleKindAndTypeByCommType()
    {
        if($this->saleKind == '') $this->saleKind = TRANSKIND_NORMAL;

        if($this->saleType == '' && ($this->CampaignCommType & TRANSTYPE_SALE))
        {
            $this->saleType = TRANSTYPE_SALE;
        }
        if($this->saleType == '' && ($this->CampaignCommType & TRANSTYPE_LEAD))
        {
            $this->saleType = TRANSTYPE_LEAD;
        }
    }
    
    //--------------------------------------------------------------------------

    function insertSale($params)
    {
        $TransID = QCore_Sql_DBUnit::createUniqueID('wd_pa_transactions', 'transid');

        $sql = "insert into wd_pa_transactions(".
            "transid,accountid,affiliateid,campcategoryid,dateinserted,orderid,".
            "productid,totalcost,transtype,transkind,refererurl,ip,rstatus,commission,".
            "data1,data2,data3)".
            "values("._q($TransID).","._q($this->AccountID).
            ","._q($this->UserID).","._q($this->CampaignCategoryID).",".sqlNow().
            ","._q($params['OrderID']).","._q($params['ProductID']).","._q($params['original_totalCost']).
            ",".$this->saleType.",".$this->saleKind.","._q($params['remoteAddr']).","._q($params['ip']).
            ",".$params['status'].","._q($params['commission']).","._q($this->extraData1).
                ","._q($this->extraData2).","._q($this->extraData3).")";
        
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret)
        {
            $errorMsg = "Sale/Lead registration: Error saving sale";
            LogError($errorMsg, __FILE__, __LINE__);
            return false;
        }
        
        QCore_History::writeHistory(WLOG_DEBUG, "Sale/Lead registration: After inserting sale (ID: $TransID)", __FILE__, __LINE__);

        if($params['status'] == AFFSTATUS_APPROVED)
        {
            $params = array('users' => array($this->UserID),
                            'AccountID' => $this->AccountID,
                            'decimal_places' => $this->settings['Aff_round_numbers']
                           );

            if(($rules = Affiliate_Merchants_Bl_Rules::getRulesAsArray($params)) !== false)
                Affiliate_Merchants_Bl_Rules::checkPerformanceRules($params, $rules);
        }

        return $TransID;
    }
    
    //--------------------------------------------------------------------------
    
    function sendNotificationToMerchant($params)
    {
        if($this->settings['Aff_email_onsale'] != 1)
            return false;

        $emaildata = QCore_EmailTemplates::getFilledEmailMessage($params['id'], 'AFF_EMAIL_NTF_SALE', $this->settings['Aff_default_lang'], $params);
        
        if($emaildata != false)
        {
            $systemEmail = $this->settings['Aff_notifications_email'];

            $email_params = array('accountid' => $this->AccountID,
                                  'subject' => $emaildata['subject'],
                                  'text' => $emaildata['text'],
                                  'message_type' => MESSAGETYPE_EMAIL,
                                  'userid' => '',
                                  'email' => $systemEmail
            );

            if(!QCore_Bl_Communications::sendEmail($email_params)) {
                $errorMsg = "Sale/Lead registration: There was a problem sending merchant notification email about sale transaction ID '".$params['id']."'";
                LogError($errorMsg, __FILE__, __LINE__);
                showMsg(L_G_EMAILSEND, __FILE__, __LINE__);
            } else {
                LogMsg("Sale registration merchant notification email about sale transaction ID '".$params['id']."' was succesfully generated and sent to '$systemEmail'", __FILE__, __LINE__);
                return true;
            }
        }
        else
        {
            $errorMsg = "Sale/Lead registration:  There was a problem generating merchant notification email about sale transaction ID '".$params['id']."' from template";
            LogError($errorMsg, __FILE__, __LINE__);
            showMsg(L_G_EMAILTEMPERR, __FILE__, __LINE__);
        }
        
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function sendNotificationToUser($params)
    {
        $ntfSettings = QCore_Settings::getUserSettings(SETTINGTYPE_USER, $this->AccountID, $this->UserID);

        // check whether to send notification email to user
        if($ntfSettings['Aff_email_affonsale'] != 1)
            return;

        $lang = $ntfSettings['Aff_aff_notificationlang'];
        
        $emaildata = QCore_EmailTemplates::getFilledEmailMessage($params['id'], 'AFF_EMAIL_AF_NTF_SLE', $lang, $params);
        
        if($emaildata != false)
        {
            $email = QCore_Auth::getUsernameForUser($this->UserID, $this->AccountID);

            $email_params = array('accountid' => $this->AccountID,
                                  'subject' => $emaildata['subject'],
                                  'text' => $emaildata['text'],
                                  'message_type' => MESSAGETYPE_EMAIL,
                                  'userid' => $this->UserID,
                                  'email' => $email
            );

            if(!QCore_Bl_Communications::sendEmail($email_params)) {
                $errorMsg = "Sale/Lead registration: There was a problem sending user notification email about sale transaction ID '".$params['id']."'";
                LogError($errorMsg, __FILE__, __LINE__);
                showMsg(L_G_EMAILSEND, __FILE__, __LINE__);
            } else {
                LogMsg("Sale registration user notification email about sale transaction ID '".$params['id']."' was succesfully generated and sent to '$email'", __FILE__, __LINE__);
                return true;
            }
        }
        else
        {
            $errorMsg = "Sale/Lead registration:  There was a problem generating user notification email about sale transaction ID '".$params['id']."' from template";
            LogError($errorMsg, __FILE__, __LINE__);
            showMsg(L_G_EMAILTEMPERR, __FILE__, __LINE__);
        }
        
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function registerMultiTierSaleCommission($parentTransID, $OrderID, $ProductID, $totalCost, $remoteAddr, $ip, $status, $parentUserID, $tier, $maxRecursion = 50)
    {
        if($maxRecursion <= 0)
            return false;

        if($tier > $this->maxCommissionLevels)
            return false;

        //----------------------------------------
        // get parent user for this child
        $params = array('parentUserID' => $parentUserID, 'status' => $status);

        if(($params = $this->getParentUser($params)) == false) return false;

        $userID = $params['userID'];
        $status = $params['status'];
        
        //---------------------------------------
        // check if this user is not assigned in some special user commission category for this product category
        $params = array('userID' => $userID, 'tier' => $tier);
        
        if($this->checkSpecialComm($params) === false) return false;
        
        //----------------------------------------
        // compute commission in this tier
        if(!($this->CampaignCommType & TRANSTYPE_SALE) && !($this->CampaignCommType & TRANSTYPE_LEAD))
            return false;
        
        // compute commission
        $commission = $this->computeCommission($totalCost, $this->STPerSaleCommType, $this->STSaleCommission[$tier]);
        
        if($commission != 0)
        {
            //----------------------------------------
            // register commission
            $TransID = QCore_Sql_DBUnit::createUniqueID('wd_pa_transactions', 'transid');
            $sql = "insert into wd_pa_transactions(".
                "transid,accountid,parenttransid,affiliateid,campcategoryid,".
                "dateinserted,orderid,productid,totalcost,transtype,transkind,".
                "refererurl,ip,rstatus,commission,
                data1,data2,data3)".
                "values("._q($TransID).","._q($this->AccountID).
                ","._qOrNull($parentTransID).","._q($userID).
                ","._q($this->CampaignCategoryID).",".sqlNow().", "._q($OrderID).
                ","._q($ProductID).",0,".$this->saleType.
                ",".(TRANSKIND_SECONDTIER+$tier).","._q($remoteAddr).","._q($ip).
                ",$status,"._q($commission).","._q($this->extraData1).
                ","._q($this->extraData2).","._q($this->extraData3).")";
            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if(!$ret)
            {
                $errorMsg = "Sale/Lead registration: Error saving $tier - tier sale commission";
                LogError($errorMsg, __FILE__, __LINE__);
                return false;
            }

            $this->multiTierSaleCommissionsCounter++;

            if($status == AFFSTATUS_APPROVED)
            {
                $params = array('users' => array($userID),
                                'AccountID' => $this->AccountID,
                                'decimal_places' => $this->settings['Aff_round_numbers']
                               );

                if(($rules = Affiliate_Merchants_Bl_Rules::getRulesAsArray($params)) !== false)
                    Affiliate_Merchants_Bl_Rules::checkPerformanceRules($params, $rules);
            }
        }
        
        //----------------------------------------
        // go recursively to the next tier
        if($tier < $this->maxCommissionLevels)
        {
            $this->registerMultiTierSaleCommission($TransID, $OrderID, $ProductID, $totalCost, $remoteAddr, $ip, $status, $userID, $tier + 1, $maxRecursion - 1);
        }
    }
    
    //--------------------------------------------------------------------------
    
    function insertRecurringCommission($params)
    {
        $RecurringCommissionID = QCore_Sql_DBUnit::createUniqueID('wd_pa_recurringcommissions', 'recurringcommid');    
        $sql = "insert into wd_pa_recurringcommissions ".
            "(recurringcommid,originaltransid,affiliateid,campcategoryid,".
            "dateinserted,commission,commtype,commdate,datetype,rstatus)".
            "values("._q($RecurringCommissionID).","._q($params['TransID']).
            ","._q($this->UserID).","._q($this->CampaignCategoryID).",".sqlNow().
            ","._q($this->RecurringCommission).","._q($this->RecurringCommType).
            ","._q($this->RecurringCommDate).","._q($this->RecurringDateType).
            ","._q($params['status']).")";
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret)
        {
            $errorMsg = "Sale/Lead registration: Error saving recurring commission";
            LogError($errorMsg, __FILE__, __LINE__);
            return false;
        }
        
        return $RecurringCommissionID;
    }

    //--------------------------------------------------------------------------
    
    function registerMultiTierRecurringCommission($parentTransID, $totalCost, $parentUserID, $tier, $maxRecursion = 50)
    {
        if($maxRecursion <= 0)
            return;

        if($tier > $this->maxCommissionLevels)
            return;

        //----------------------------------------
        // get parent user for this child
        $params = array('parentUserID' => $parentUserID, 'status' => $status);

        if(($params = $this->getParentUser($params)) === false) return false;

        $userID = $params['userID'];
        $status = $params['status'];
        
        //---------------------------------------
        // check if this user is not assigned in some special user commission category for this product category
        $params = array('userID' => $userID, 'tier' => $tier);
 
        if($this->checkRecurSpecialComm($params) === false) return false;
        
        //----------------------------------------
        // compute commission
        $commission = $this->computeCommission($totalCost, $this->STRecurringCommType, $this->STRecurringCommission[$tier]);

        //----------------------------------------
        // register commission
        $sql = "update wd_pa_recurringcommissions ".
            "set st".$tier."commission="._q($commission).",".
            "    stcommtype="._q($this->STRecurringCommType).",".
            "    st".$tier."affiliateid="._q($userID).
            " where recurringcommid="._q($parentTransID);
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret)
        {
            $errorMsg = "Sale/Lead registration: Error saving $tier - tier recurring commission";
            LogError($errorMsg, __FILE__, __LINE__);
            return false;
        }

        $this->multiTierSaleRecurCommissionsCounter++;
        
        //----------------------------------------
        // go recursively to the next tier
        if($tier < $this->maxCommissionLevels)
        {
            $this->registerMultiTierRecurringCommission($parentTransID, $totalCost, $userID, $tier + 1, $maxRecursion -1);
        }
    }
    
    //--------------------------------------------------------------------------
    
    function checkSpecialComm($params)
    {
        $sql = 'select cc.* from wd_pa_affiliatescampaigns ac, wd_pa_campaigncategories cc '.
            'where cc.campaignid='._q($this->CampaignID).
            '  and cc.campcategoryid=ac.campcategoryid'.
            '  and affiliateid='._q($params['userID']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
            return false;
        
        if(!$rs->EOF)
        {
            if($this->CampaignCategoryID != $rs->fields['campcategoryid'])
            {
                // user is in different commission category, get the commission level
                $this->STSaleCommission[$params['tier']] = $rs->fields['st'.$params['tier'].'salecommission'];
            }
        }
        else
        {
            // get commission from default commission category
            $sql = 'select * from wd_pa_campaigncategories '.
                'where deleted=0 and campaignid='._q($this->CampaignID).
                '  and name='._q(UNASSIGNED_USERS);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs || $rs->EOF)
                return false;  
            
            $this->STSaleCommission[$params['tier']] = $rs->fields['st'.$params['tier'].'salecommission'];
        }
    }
    
    //--------------------------------------------------------------------------
    
    function checkRecurSpecialComm($params)
    {
        $sql = 'select cc.* from wd_pa_affiliatescampaigns ac, wd_pa_campaigncategories cc '.
            'where cc.campaignid='._q($this->CampaignID).
            '  and cc.campcategoryid=ac.campcategoryid'.
            '  and affiliateid='._q($params['userID']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
            return false;
        
        if(!$rs->EOF)
        {
            if($this->CampaignCategoryID != $rs->fields['campcategoryid'])
            {
                // user is in different commission category, get the commission level
                $this->STRecurringCommission[$params['tier']] = $rs->fields['st'.$params['tier'].'recurringcommission'];
            }
        }
        else
        {
            // get commission from default commission category
            $sql = 'select * from wd_pa_campaigncategories '.
                'where deleted=0 and campaignid='._q($this->CampaignID).
                '  and name='._q(UNASSIGNED_USERS);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs || $rs->EOF)
                return false;  
            
            $this->STRecurringCommission[$params['tier']] = $rs->fields['st'.$params['tier'].'recurringcommission'];
        }
    }
}
?>
