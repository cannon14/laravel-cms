<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Merchants_Views_Maintenance extends QUnit_UI_TemplatePage
{
    function initPermissions()
    {
        $this->modulePermissions['backup'] = 'aff_tool_db_maintenance_backup';
        $this->modulePermissions['startbackup'] = 'aff_tool_db_maintenance_backup';
        $this->modulePermissions['restore'] = 'aff_tool_db_maintenance_restore';
        if(is_array($GLOBALS['Auth']->permissions) && count($GLOBALS['Auth']->permissions) > 0)
        {
            if(in_array('aff_tool_db_maintenance_backup', $GLOBALS['Auth']->permissions))
                $this->modulePermissions['view'] = 'aff_tool_db_maintenance_backup';
            else if(in_array('aff_tool_db_maintenance_restore', $GLOBALS['Auth']->permissions))
                $this->modulePermissions['view'] = 'aff_tool_db_maintenance_restore';
        }
    }
    
    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_POST['commited']))
        {
            switch($_POST['action'])
            {
                case 'edit':
                if($this->saveSettings())
                    return;
                break;
                
                case 'backup':
                if($this->showBackupForm())
                    return;
                break;
                
                case 'restore':
                if($this->showRestoreForm())
                    return;
                break;
            }
        }
        
        switch($_REQUEST['action'])
        {
                case 'startbackup':
                if($this->processBackup())
                    return;
                break;       
        }
        
        $this->show();    
    }  

    //------------------------------------------------------------------------

    function showBackupForm()
    {
        echo '<meta http-equiv="refresh" content="2;url=index_exp.php?md=Affiliate_Merchants_Views_Maintenance&action=startbackup&gzipcompress='.$_REQUEST['gzipcompress'].'">';

        $this->addContent('backup_in_process');

        return true;
    }

    //------------------------------------------------------------------------

    function showRestoreForm()
    {
        @set_time_limit(1200);

        // check file upload
        if($_FILES['sqlfile']['name'] == '')
            QUnit_Messager::setErrorMessage(L_G_YOUHAVETOSELECTFILE);
        else
        {
            if(!is_uploaded_file($_FILES['sqlfile']['tmp_name']))
                QUnit_Messager::setErrorMessage(L_G_YOUHAVETOSELECTFILE);
        }

        if(preg_match("/\.gz$/is", $_FILES['sqlfile']['name']))
        {
            // check if zip extension is installed
            $gzipCompress = false;
            $phpver = phpversion();
            
            if($phpver >= "4.0")
            {
                if(extension_loaded("zlib"))
                    $gzipCompress = true;
            }
            
            if(!$gzipCompress)
                QUnit_Messager::setErrorMessage(L_G_GZIPNOTINSTALLED);
        }
        
        if(QUnit_Messager::getErrorMessage() != '')
        {
            $this->show();
        }
        else
        {
            if($gzipCompress)
            {
                $file = gzopen($_FILES['sqlfile']['tmp_name'], 'rb');
                $sqlQuery = "";
                while( !gzeof($file) )
                {
                    $sqlQuery .= gzgets($file, 100000);
                }
            }
            else
            {
                $sqlQuery = file_get_contents($_FILES['sqlfile']['tmp_name']);
            }
            
            if($sqlQuery != "")
            {
                $this->addContent('restore_in_process');

                // Strip out sql comments...
                $sqlQuery = removeMysqlComments($sqlQuery);
                $pieces = splitSqlFile($sqlQuery, ";");
                
                $sqlCount = count($pieces);
                $executedCount = 0;
                for($i = 0; $i < $sqlCount; $i++)
                {
                    $sql = trim($pieces[$i]);
                    
                    if(!empty($sql) and $sql[0] != "#")
                    {
                        $executedCount++;
                        
                        if($executedCount % 10 == 0)
                        {
                            echo '.';
                            flush();
                        }
                        
                        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
                        if (!$ret)
                        {
                            showMsg(L_G_DBERROR);
                            return true;
                        }   
                    }
                }
            }
        }

        $this->addContent('restore_finishedok');        

        return true;
    }   

    //------------------------------------------------------------------------

    function processBackup()
    {
        @set_time_limit(1200);

        $tables = array
                  (
                  wd_g_accounts,
                  wd_g_emailtemplates,
                  wd_g_groups,
                  wd_g_history,
                  wd_g_listviews,
                  wd_g_messages,
                  wd_g_messagestousers,
                  wd_g_righttypes,
                  wd_g_settings,
                  wd_g_usergroups,
                  wd_g_userprofiles,
                  wd_g_userrights,
                  wd_g_users,
                  wd_pa_accounting,
                  wd_pa_affiliatescampaigns,
                  wd_pa_banners,
                  wd_pa_campaigncategories,
                  wd_pa_campaigns,
                  wd_pa_impressions,
                  wd_pa_payoutfields,
                  wd_pa_payoutoptions,
                  wd_pa_recurringcommissions,
                  wd_pa_transactions
                  );
        
        $gzipCompress = false;
        if($_REQUEST['gzipcompress'] == 1)
        {
            $phpver = phpversion();

            if($phpver >= "4.0")
			{
			    if(extension_loaded("zlib"))
				{
					$gzipCompress = true;
				}
			}
		}

        if($gzipCompress)
        {
            @ob_start();
            @ob_implicit_flush(0);
            header("Pragma: no-cache");     
            header("Content-Type: application/x-gzip; name=\"db_backup.sql.gz\"");
            header("Content-disposition: attachment; filename=db_backup.sql.gz");
        }
        else
        {
            header("Pragma: no-cache");     
            header("Content-Type: text/x-delimtext; name=\"db_backup.sql\"");
            header("Content-disposition: attachment; filename=db_backup.sql");
        }

        // create statements
        foreach($tables as $table)
        {
            QCore_Sql_DBUnit::getTableCreateStatement($table);
        }

        // insert statements
        foreach($tables as $table)
        {
            QCore_Sql_DBUnit::getTableInsertStatement($table);
        }

        if($gzipCompress)
        {
            $size = ob_get_length();
            $crc = crc32(ob_get_contents());
            $contents = gzencode(ob_get_contents());
            ob_end_clean();
            echo $contents;
            //"\x1f\x8b\x08\x00\x00\x00\x00\x00".substr($contents, 0, strlen($contents) - 4).gzip_PrintFourChars($crc).gzip_PrintFourChars($size);
		}
        exit;
        
        return true;
    }
    
    //------------------------------------------------------------------------
    
    function show()
    {
        if(AFF_DEMO == 1)
            QUnit_Messager::setErrorMessage(L_G_DISABLED_IN_DEMO);

        $temp_perm['restore'] = $this->checkPermissions('restore');
        $temp_perm['backup'] = $this->checkPermissions('backup');

        $this->assign('a_action_permission', $temp_perm);


        $this->addContent('maintenance');
    }
    
    //------------------------------------------------------------------------
}
?>
