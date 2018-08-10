<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: fields.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// Access..
if (!in_array('fields',$userAccess) && $MSTEAM->id!='1') {
  header("Location: index.php?noaccess=1");
  exit;
}
  
if (isset($_POST['process']) && $_POST['fieldInstructions']) {
  $MSSET->addCustomField();
  $OK = true;
}
  
if (isset($_POST['update']) && $_POST['fieldInstructions']) {
  $MSSET->editCustomField();
  $OK2 = true;
} 

if (isset($_GET['delete']) && USER_DEL_PRIV=='yes') {
  $count = $MSSET->deleteCustomField();
  $OK3   = true;
} 

if (isset($_POST['update_order'])) {
  if (isset($_POST['enable'])) {
    $MSSET->enableDisableFields('yes');
    $OK5 = true;
  } elseif (isset($_POST['disable'])) {
    $MSSET->enableDisableFields('no');
    $OK6 = true;
  } else {
    $MSSET->orderFields();
    $OK4 = true;
  }
}
  
$title  = $msg_adheader26;
  
include(PATH.'templates/header.php');
include(PATH.'templates/system/settings/fields.php');
include(PATH.'control/system/core/footer.php');

?>
