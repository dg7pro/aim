<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: standard-responses.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// Access..
if (!in_array('standard-responses',$userAccess) && $MSTEAM->id!='1') {
  header("Location: index.php?noaccess=1");
  exit;
}

// Preview message..
if (isset($_GET['previewMsg'])) {
  if (isset($_POST['msg'])) {
    $_SESSION['previewBoxText'] = mswCleanData($_POST['msg']);
    echo 'ok|||||test';
  } else {
    include(PATH.'templates/system/preview.php');
  }
  exit;
}

// For standard response only..
if (isset($_GET['getResponse'])) {
  $SR = mswGetTableData('responses','id',(int)$_GET['getResponse']);
  echo (isset($SR->answer) ? mswCleanData($SR->answer) : '&nbsp;');
  exit;
}
     
if (isset($_POST['process'])) {
  if (trim($_POST['title']) && trim($_POST['answer'])) {
    $return = $MSSTR->addResponse();
    if ($return=='yes') {
      $REST = true; 
    } else {
      $OK = true;
    }
  } else {
    header("Location: ?p=standard-responses");
    exit;
  }
}
  
if (isset($_GET['view'])) {
  include(PATH.'templates/system/tickets/tickets-responses-window.php');
  exit; 
}
     
if (isset($_POST['update'])) {
  if (trim($_POST['title']) && trim($_POST['answer'])) {
    $MSSTR->updateResponse();
    $OK2 = true;
  } else {
    header("Location: ?p=standard-responses");
    exit;
  }
}
     
if (isset($_GET['delete']) && USER_DEL_PRIV=='yes') {
  $MSSTR->deleteResponse();
  $OK3 = true;
}
  
// Department check..
if ($MSTEAM->id!='1') { 
  if (isset($_GET['dept']) && $_GET['dept']>0 && !in_array($_GET['dept'],$userDeptAccess)) {
    header("Location: index.php?p=standard-responses");
    exit;
  }
}

if (isset($_POST['endis'])) {
  if (isset($_POST['enable'])) {
    $MSSTR->enableDisableResponses('yes');
    $OK4 = true;
  } else {
    $MSSTR->enableDisableResponses('no');
    $OK5 = true;
  }
}
     
$title        = $msg_adheader13;
$loadGreyBox  = true;
     
include(PATH.'templates/header.php');
include(PATH.'templates/system/tickets/tickets-responses.php');
include(PATH.'control/system/core/footer.php');

?>
