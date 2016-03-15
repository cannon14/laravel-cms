<?
//============================================================================
// Copyright (c) Maros Fric  2003
// All rights reserved
//
// For support contact mark@mylinks.sk
//============================================================================

class QCore_Users
{
  var $className = 'QCore_Users';
  
  function process()
  {
    if(!empty($_POST['commited']))
    {
      switch($_POST['action'])
      {
        case 'add':
              if($this->processAddUser())
                return;
              break;
              
        case 'edit':
              if($this->processEditUser())
                return;
              break;
      }
    }
    
    if(!empty($_REQUEST['action']))
    {
      switch($_REQUEST['action'])
      {
        case 'add':
              if($this->drawFormAddUser())
                return;
              break;              

        case 'edit':
              if($this->drawFormEditUser())
                return;
              break;              

        case 'delete':
              if($this->processDeleteUser())
                return;
              break;              
      }
    }    
    
    $this->showUsers();    
  }  
  
  
 /**
  * sets header for currect action.
  */
  function getHeader()
  {
    $header = TMS_G_USERLIST; 
    
    if(!empty($_REQUEST['action']))
    {
      switch($_REQUEST['action'])
      {
        case 'add': $header = TMS_G_ADDUSER;
                    break;   

        case 'edit': $header = TMS_G_EDITUSER;
                    break;   
      }
    }
    
    $GLOBALS['PageTitle'] = $header;
  }  
  
  
  //==========================================================================
  // PROCESSING FUNCTIONS
  //==========================================================================
  
  function processAddUser()
  {
    $Auth = $GLOBALS['Auth'];    
    $errorMsg = '';
  
    if($_POST['username'] == '')
      $errorMsg .= L_ERR_USERNAMECANNOTBEEMPTY.'<br>';
    
    if($_POST['password'] == '')
      $errorMsg .= L_ERR_PASSWORDCANNOTBEEMPTY.'<br>';

    // check if this user (with the same username) doesnt exists already
    if($_REQUEST['id'] != '')
      $sql = 'select * from faq_users where username = '._q($_POST['username']).' and deleted=0 and userid<>'.$_REQUEST['id'];
    else
      $sql = 'select * from faq_users where deleted=0 and username = '._q($_POST['username']);
    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    if(!$rs)
    {
      Logger::logShowError(L_ERR_DBERROR, __FILE__, __LINE__);
      return true;
    }  
    
    if(!$rs->EOF)
    {
      $errorMsg .= L_ERR_USEREXISTSMSG.'<br>';
    }

    if($errorMsg != '')
    {
      $GLOBALS['action'] = 'add';
      echo "<center><font color=red>$errorMsg</font></center><br>";
      
      //------------------------------------------------------------------------
      // show list
      QUnit_Templates::includeTemplate('user_add.php');   
      return true;
    }
    
    $_POST['password'] = md5($_POST['password']);
    
    $UserID = QCore_Sql_DBUnit::generateID('seq_faq_users', 10);
    $sql = 'insert into faq_users(userid, fullname, username, rpassword, deleted) values($UserID, '._q($_POST['fullname']).','._q($_POST['username']).','._q($_POST['password']).', \'0\')';
    // insert user
    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    if(!$rs)
    {
      Logger::logShowError(L_ERR_DBERROR, __FILE__, __LINE__);
      return false;
    }
    
    // get ID of inserted user
    $userId = $GLOBALS['db']->Insert_ID();
    
    GlobalFuncs::Redirect_nomsg('admin.php?md=QUnit_Templates');
    return true;
  }
    
 /**
  * process form for editing user and save changes to the database
  */
  function processEditUser()
  {
    $Auth = $GLOBALS['Auth'];    
    $errorMsg = '';
    
    // check if this user (with the same username) doesnt exists already
    $sql = 'select * from faq_users where deleted=0 and userid<>'.$_REQUEST['id'].' and username='._q($_POST['username']);
    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    if(!$rs)
    {
      Logger::logShowError(L_ERR_DBERROR, __FILE__, __LINE__);
      return true;
    }  
    
    if(!$rs->EOF)
      $errorMsg .= L_ERR_USEREXISTSMSG.'<br>';

    if($errorMsg != '')
    {
      $GLOBALS['action'] = 'edit';
      echo "<center><font color=red>$errorMsg</font></center><br>";
      
      //------------------------------------------------------------------------
      // show list
      QUnit_Templates::includeTemplate('user_add.php');   
      return true;
    }
    
    
    // now save user
    if($_POST['password'] == '')
    {
      // this means we should not change password so load current pwd from database  
      $sql = 'select rpassword from faq_users where userid='.$_POST['id'];
      $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
      if(!$rs || $RS->EOF)
      {
        Logger::logShowError(L_ERR_DBERROR, __FILE__, __LINE__);
        return false;
      }
  
      $_POST['password'] = $rs->fields['Password'];
    }
    else
      // hash password
      $_POST['password'] = md5($_POST['password']);
    
    // update user
    $sql = 'update faq_users set fullname='._q($_POST['fullname']).', username='._q($_POST['username']).', rpassword='._q($_POST['password']).' where userid='.$_POST['id'];    
    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    if(!$rs)
    {
      Logger::logShowError(L_ERR_DBERROR, __FILE__, __LINE__);
      return false;
    }
    
    GlobalFuncs::Redirect_nomsg('admin.php?md=QUnit_Templates');
    return true;
  }
  
  
 /**
  * funcion deletes user from central database as well as from all bank 
  * databases where this user exists. Deletion means only to set flag deleted = 1
  */
  function processDeleteUser()
  {
    $Auth = $GLOBALS['Auth'];   
    
    $sql = 'update faq_users set deleted=\'1\' where userid='.$_REQUEST['id'];
    // first delete organisation into central database
    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    if(!$rs)
    {
      Logger::logShowError(L_ERR_DBERROR, __FILE__, __LINE__);
      return false;
    }
    
    GlobalFuncs::Redirect_nomsg('admin.php?md=QUnit_Templates');
    return true;
  }
  
  
  //==========================================================================
  // FORMS FUNCTIONS
  //==========================================================================  
 /**
  * displays list of users
  */
  function showUsers()
  {
    $Auth = $GLOBALS['Auth'];
    
    $sql = 'SELECT * FROM faq_users WHERE deleted=0';
    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

    $GLOBALS['rs'] = $rs;
    
    //------------------------------------------------------------------------
    // show list
    QUnit_Templates::includeTemplate('users_list.php');
  }
  
  
 /**
  * draws form for adding the user
  */
  function drawFormAddUser()
  {
    $Auth = $GLOBALS['Auth'];
    
    $GLOBALS['action'] = 'add';
    
    //------------------------------------------------------------------------
    // show add form
    QUnit_Templates::includeTemplate('user_add.php');   
  
    return true;
  }
  
  
 /**
  * draws form for editing the user
  */
  function drawFormEditUser()
  {
    $Auth = $GLOBALS['Auth'];
    
    if(empty($_REQUEST['id']))
    {
      echo L_ERR_WRONGPAGECALL;
      return true;
    }

    // get data for this user
		$sql = 'SELECT * FROM faq_users where userid='.$_REQUEST['id'];
    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    if(!$rs || $rs->EOF)
    {
      Logger::logShowError(L_ERR_DBERROR, __FILE__, __LINE__);
      return true;
    }    
    
    $_POST['fullname'] = $rs->fields['fullname'];
    $_POST['username'] = $rs->fields['username'];
    $_POST['password'] = '';
    
    $GLOBALS['action'] = 'edit';
    
    //------------------------------------------------------------------------
    // show list
    QUnit_Templates::includeTemplate('user_add.php');   
    
    return true;
  }

  
  //==========================================================================
  // OTHER FUNCTIONS
  //==========================================================================
  function getUserData($userid)
  {        
    $sql = 'select * from Users where UserID='._q($userid); 
    $rs = QCore_Sql_DBUnit::DBexecuteCentral($sql);
    if(!$rs)
    {
      Logger::logShowError(L_ERR_DBERROR, __FILE__, __LINE__);
      return false;
    }
    
    if($rs->EOF)
      return false;
    
    $data = array();
    $data['Fullname'] = $rs->fields['Fullname'];
    $data['Email'] = $rs->fields['Email'];   
    
    return $data;
  }
  
 /**
  * returns array of user data indexed by UserID
  */
  function getUsersArray()
  {        
    $sql = 'select * from Users';
    $rs = QCore_Sql_DBUnit::DBexecuteCentral($sql);
    if(!$rs)
    {
      Logger::logShowError(L_ERR_DBERROR, __FILE__, __LINE__);
      return false;
    }
    
    $recs = array();
    while(!$rs->EOF)
    {
      $data = array();
      $data['Fullname'] = $rs->fields['Fullname'];
      $data['Email'] = $rs->fields['Email'];
      
      $recs[$rs->fields['UserID']] = $data;
      
      $rs->MoveNext();
    }
    
    return $recs;
  }
              
}


?>
