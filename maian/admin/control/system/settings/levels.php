<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: levels.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// Access..
if (!in_array('levels',$userAccess) && $MSTEAM->id!='1') {
  header("Location: index.php?noaccess=1");
  exit;
}

if (isset($_POST['update_order'])) {
  $LVL->orderLevels();
  $OK4 = true;
}
  
if (isset($_POST['process'])) {
  if (trim($_POST['name'])) {
    $return = $LVL->addLevel();
    $OK     = true;
  } else {
    header("Location: ?p=levels");
    exit;
  }
}
     
if (isset($_POST['update'])) {
  if (trim($_POST['name'])) {
    $LVL->updateLevel();
    $OK2 = true;
  } else {
    header("Location: ?p=levels");
    exit;
  }
}

if (isset($_GET['delete']) && USER_DEL_PRIV=='yes') {
  $count = $LVL->deleteLevel();
  $OK3   = true;
}
  
$title = $msg_adheader35;

include(PATH.'templates/header.php');
include(PATH.'templates/system/settings/levels.php');
include(PATH.'control/system/core/footer.php');

?>
