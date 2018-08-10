<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: faq-cat.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// Access..
if (!in_array('faq-cat',$userAccess) && $MSTEAM->id!='1') {
  header("Location: index.php?noaccess=1");
  exit;
}
     
if (isset($_POST['process'])) {
  if (trim($_POST['name'])) {
    $return = $FAQ->addCategory();
    $OK     = true;
  } else {
    header("Location: ?p=faq-cat");
    exit;
  }
}
     
if (isset($_POST['update'])) {
  if (trim($_POST['name'])) {
    $FAQ->updateCategory();
    $OK2 = true;
  } else {
    header("Location: ?p=faq-cat");
    exit;
  }
}

if (isset($_GET['delete']) && USER_DEL_PRIV=='yes') {
  $count = $FAQ->deleteCategory();
  $OK3   = true;
}

if (isset($_POST['endis'])) {
  if (isset($_POST['enable'])) {
    $FAQ->enableDisableCategory();
    $OK4 = true;
  } elseif (isset($_POST['disable'])) {
    $FAQ->enableDisableCategory();
    $OK5 = true;
  } else {
    $FAQ->orderFields();
    $OK6 = true;
  }
}
  
$title = $msg_adheader16;

include(PATH.'templates/header.php');
include(PATH.'templates/system/faq/faq-cat.php');
include(PATH.'control/system/core/footer.php');

?>
