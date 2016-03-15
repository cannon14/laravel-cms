<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QCore_Bl_ListViews');

class Affiliate_Merchants_Views_ListViews extends QUnit_UI_TemplatePage
{
    var $fromPage = '';

    //------------------------------------------------------------------------
    
    function process()
    {
        if(!empty($_POST['postaction']))
        {
            switch($_POST['postaction'])
            {              
                case 'add':
                    if($this->processAdd())
                        return;
                break;

                case 'edit':
                    if($this->processUpdate())
                        return;
                break;
            }
        }

        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'add':
                    if($this->drawFormAdd())
                        return;
                break;

                case 'edit':
                    if($this->drawFormEdit())
                        return;
                break;

                case 'delete':
                    if($this->processDelete())
                        return;
                break;
            }
        }
    }

    //------------------------------------------------------------------------

    function drawFormEdit()
    {
        $viewID = $_REQUEST['vid'];

        if($_POST['commited'] != 'yes')
        {
            $data = QCore_Bl_ListViews::loadViewInfo($viewID);
            $_POST['name'] = $data['name'];
            $_POST['columns'] = $data['columns'];
            
            $count = 1;
            foreach($data['columns'] as $column)
            {
                $_POST['column'.$count] = $column;
                $count++;
            }
        }

        $_POST['header'] = L_G_EDIT_LISTVIEW;
        $_POST['action'] = 'edit';
        $_POST['postaction'] = 'edit';

        $this->drawFormAdd();

        return true;
    }

    //--------------------------------------------------------------------------

    function drawFormAdd()
    {
        if($_REQUEST['listViewName'] == '')
            return true;
            
        $listViewObj = QUnit_Global::newObj($_REQUEST['listViewName']);
        if(!is_object($listViewObj))
            return true;
            
        if(!isset($_POST['action']))
            $_POST['action'] = 'add';
        if(!isset($_POST['postaction']))
            $_POST['postaction'] = 'add';

        if(!isset($_POST['header']))
            $_POST['header'] = L_G_ADD_LISTVIEW;

        $this->assign('a_columns', $list_data);
        $this->assign('a_available_columns', $listViewObj->getAvailableColumns());
        $this->assign('a_listview_name', $listViewObj->getListViewName());
        
        $this->addContent('listview_edit');

        return true;
    }

    //--------------------------------------------------------------------------

    function processDelete()
    {
        $params = array();
        $params['vid'] = $_REQUEST['vid'];
        
        if(QCore_Bl_ListViews::delete($params))
            QUnit_Messager::setOkMessage(L_G_VIEWDELETED);
            
        $this->closeWindow($_REQUEST['listViewName']);
        $this->addContent('closewindow');
        
        return false;
    }

    //--------------------------------------------------------------------------

    function processUpdate()
    {
        $params = array();
        $params['type'] = 'add';

        $protectedParams = QCore_Bl_ListViews::checkData($params);
        
        if(QUnit_Messager::getErrorMessage() != '')
        {
            return false;
        }
        else
        {
            if(QCore_Bl_ListViews::update($protectedParams))
                QUnit_Messager::setOkMessage(L_G_VIEWUPDATED);
            
            $this->closeWindow($protectedParams['listViewName']);
            $this->addContent('closewindow');
        }

        return true;
    }

    //--------------------------------------------------------------------------

    function processAdd()
    {
        $params = array();
        $params['type'] = 'add';

        $protectedParams = QCore_Bl_ListViews::checkData($params);
        
        if(QUnit_Messager::getErrorMessage() != '')
        {
            return false;
        }
        else
        {
            if(QCore_Bl_ListViews::insert($protectedParams))
                QUnit_Messager::setOkMessage(L_G_VIEWADDED);
            
            $this->closeWindow($protectedParams['listViewName']);
            $this->addContent('closewindow');
        }

        return true;
    }
    
    //--------------------------------------------------------------------------

}
?>
