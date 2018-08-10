<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: users.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// Access..
if (!in_array('users',$userAccess) && $MSTEAM->id!='1') {
  header("Location: index.php?noaccess=1");
  exit;
}

// Auto pass..
if (isset($_GET['autoPass'])) {
  $pass  = $MSUSERS->generateSecurePassword();
  echo $pass.'#####'.$msg_javascript154.' '.$pass.mswDefineNewline().mswDefineNewline().$msg_javascript155;
  exit;
}
     
if (isset($_POST['process'])) {
  if (trim($_POST['name']) && trim($_POST['email']) && trim($_POST['accpass'])) {
    $MSUSERS->addUser();
    // Send mail..
    if (isset($_POST['sendMail'])) {
      $MSMAIL->addTag('{PASSWORD}', $_POST['accpass']);
      $MSMAIL->addTag('{EMAIL}', $_POST['email']);
      $MSMAIL->addTag('{NAME}', $_POST['name']);
      $MSMAIL->sendMSMail($_POST['name'],
                          $_POST['email'],
                          $SETTINGS->website,
                          $SETTINGS->email,
                          str_replace(array('{website}'),
                                      array($SETTINGS->website
                                      ),
                                      $msg_user53
                          ),
                          $MSMAIL->template(LANG_PATH.'new-user.txt')
               );
    }
    $OK = true;
  } else {
    header("Location: ?p=users");
    exit;
  }
}
  
if (isset($_GET['view'])) {
  // Check view for global user..
  if ($_GET['view']=='1' && $MSTEAM->id!='1') {
    msw403();
  }
  // Update notification..
  if (isset($_GET['set_notify']) || isset($_GET['set_sig']) || isset($_GET['set_pad']) 
      || isset($_GET['set_priv']) || isset($_GET['set_assigned']) || isset($_GET['set_timezone'])) {
    $MSUSERS->setNotification();
    header("Location: index.php?p=users&view=".$_GET['view']);
    exit;
  }
  include(PATH.'templates/system/users/users-window.php');
  exit;
}
  
if (isset($_GET['responses'])) {
  // Check view for global user..
  if ($_GET['responses']=='1' && $MSTEAM->id!='1') {
    msw403();
  }
  include(PATH.'templates/system/users/user-responses-window.php');
  exit;
}
  
if (isset($_GET['graph'])) {
  // Check view for global user..
  if ($_GET['graph']=='1' && $MSTEAM->id!='1') {
    msw403();
  }
  include(PATH.'templates/system/users/user-responses-graph.php');
  exit;
}
  
if (isset($_POST['endis'])) {
  $MSUSERS->updateNotifications();
  if (isset($_POST['enable'])) {
    $OK4 = true;
  } else {
    $OK5 = true;
  }
}

if (isset($_GET['delete']) && $_GET['delete']>1) {
  if ($_GET['delete']!=$MSTEAM->id && USER_DEL_PRIV=='yes') {
    $count = $MSUSERS->deleteUser();
    $OK2   = true;
  } else {
    header("Location: ?p=users");
    exit;
  }
}
     
if (isset($_POST['update'])) {
  if (trim($_POST['name']) && trim($_POST['email'])) {
    // Check edit for global user..
    if ($_GET['edit']=='1' && $MSTEAM->id!='1') {
      msw403();
    }
    $MSUSERS->updateUser($MSTEAM->id);
    $OK3 = true;
  } else {
    header("Location: ?p=users");
    exit;
  }
}
  
$title        = $msg_adheader4;
$loadGreyBox  = true;
  
include(PATH.'templates/header.php');
include(PATH.'templates/system/users/users.php');
include(PATH.'control/system/core/footer.php');

?>