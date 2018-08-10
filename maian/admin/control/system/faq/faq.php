<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: faq.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// Access..
if (!in_array('faq',$userAccess) && $MSTEAM->id!='1') {
  header("Location: index.php?noaccess=1");
  exit;
}   

// Get attachments..
if (isset($_GET['loadAttachments'])) {
  $html = $FAQ->loadAttachments();
  echo $html;
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
     
if (isset($_POST['process'])) {
  if (trim($_POST['question']) && trim($_POST['answer'])) {
    $return  = $FAQ->addQuestion();
    $OK      = true;
  } else {
    header("Location: ?p=faq");
    exit;
  }
}
  
if (isset($_GET['view'])) {
  include(PATH.'templates/system/faq/faq-window.php');
  exit; 
}

if (isset($_POST['reset'])) {
  if (isset($_POST['enable'])) {
    $FAQ->enableDisableQuestions('yes');
    $OK5 = true;
  } elseif (isset($_POST['disable'])) {
    $FAQ->enableDisableQuestions('no');
    $OK6 = true;
  } else {
    $FAQ->resetCounts();
    $OK4 = true;
  }
}
     
if (isset($_POST['update'])) {
  if (trim($_POST['question']) && trim($_POST['answer'])) {
    $FAQ->updateQuestion();
    $OK2 = true;
  } else {
    header("Location: ?p=faq");
    exit;
  }
}
     
if (isset($_GET['delete']) && USER_DEL_PRIV=='yes') {
  $count = $FAQ->deleteQuestion();
  $OK3   = true;
}
  
$title        = $msg_adheader17;
$loadGreyBox  = true;
     
include(PATH.'templates/header.php');
include(PATH.'templates/system/faq/faq.php');
include(PATH.'control/system/core/footer.php');

?>