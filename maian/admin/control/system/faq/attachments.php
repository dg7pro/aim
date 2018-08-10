<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: attachments.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// Access..
if (!in_array('attachments',$userAccess) && $MSTEAM->id!='1') {
  header("Location: index.php?noaccess=1");
  exit;
}   

// Add
if (isset($_POST['process'])) {
  $count = $FAQ->addAttachments();
  $OK    = true;
}

// Update..
if (isset($_POST['update'])) {
  $FAQ->updateAttachment();
  $OK2    = true;
}

// Delete..
if (isset($_GET['delete']) && USER_DEL_PRIV=='yes') {
  $cnt = $FAQ->deleteAttachment();
  $OK3 = true;
}

$title  = $msg_adheader33;
     
include(PATH.'templates/header.php');
include(PATH.'templates/system/faq/faq-attachments.php');
include(PATH.'control/system/core/footer.php');

?>