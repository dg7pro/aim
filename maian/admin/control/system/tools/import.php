<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: import.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// Access..
if (!in_array('import',$userAccess) && $MSTEAM->id!='1') {
  header("Location: index.php?noaccess=1");
  exit;
}
     
if (isset($_POST['process'])) {
  // Set defaults..
  $lines  = ($_POST['lines'] ? str_replace(array('.',','),array(),$_POST['lines']) : '0');
  $del    = ($_POST['delimiter'] ? $_POST['delimiter'] : ',');
  $enc    = ($_POST['enclosed'] ? $_POST['enclosed'] : '"');
  // Import..
  $total  = $MSSTR->batchImportSR($lines,$del,$enc);
  if ($total>0 || $total=='limit') {
    $OK     = true;
  } else {
    header("Location: index.php?p=import");
    exit;
  }
}
  
if (isset($_POST['process2'])) {
  // Set defaults..
  $lines  = ($_POST['lines'] ? str_replace(array('.',','),array(),$_POST['lines']) : '0');
  $del    = ($_POST['delimiter'] ? $_POST['delimiter'] : ',');
  $enc    = ($_POST['enclosed'] ? $_POST['enclosed'] : '"');
  // Import..
  $total  = $FAQ->batchImportKB($lines,$del,$enc);
  if ($total>0 || $total=='limit') {
    $OK2    = true;
  } else {
    header("Location: index.php?p=import");
    exit;
  }
}
  
$title = $msg_adheader19;
  
include(PATH.'templates/header.php');
include(PATH.'templates/system/tools/import.php');
include(PATH.'control/system/core/footer.php');

?>
