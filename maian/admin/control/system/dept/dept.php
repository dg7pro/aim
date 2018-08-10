<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: dept.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// Access..
if (!in_array('dept',$userAccess) && $MSTEAM->id!='1') {
  header("Location: index.php?noaccess=1");
  exit;
}

if (isset($_POST['update_order'])) {
  $MSDEPT->orderFields();
  $OK4 = true;
}
  
if (isset($_POST['process'])) {
  if (trim($_POST['name'])) {
    $return = $MSDEPT->addDepartment();
    $OK     = true;
  } else {
    header("Location: ?p=dept");
    exit;
  }
}
     
if (isset($_POST['update'])) {
  if (trim($_POST['name'])) {
    $MSDEPT->updateDepartment();
    $OK2 = true;
  } else {
    header("Location: ?p=dept");
    exit;
  }
}

if (isset($_GET['delete']) && USER_DEL_PRIV=='yes') {
  $count = $MSDEPT->deleteDepartment();
  $OK3   = true;
}
  
$title = $msg_adheader3;

include(PATH.'templates/header.php');
include(PATH.'templates/system/dept/dept.php');
include(PATH.'control/system/core/footer.php');

?>
