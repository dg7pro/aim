<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: imap.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// Access..
if (!in_array('imap',$userAccess) && $MSTEAM->id!='1') {
  header("Location: index.php?noaccess=1");
  exit;
}

if (isset($_GET['showImapFolders'])) {
  $html   = '';
  $_POST  = array_map('cleanData',$_POST);
  if (function_exists('imap_open')) {
    $mbox = @imap_open('{'.$_POST['host'].':'.$_POST['port'].'/imap'.
                       ($_POST['flags'] ? $_POST['flags'] : '').
                       '}',$_POST['user'],$_POST['pass']
             );
    if ($mbox) {
      $list = @imap_list($mbox,'{'.$_POST['host'].'}','*');
      if (is_array($list)) {
        sort($list);
        foreach ($list AS $box) {
          $box   = str_replace('{'.$_POST['host'].'}','',$box);
          $html .= '<span><input type="radio" name="folder" value="'.$box.'" onclick="ms_insertMailBox(this.value,\''.$_GET['showImapFolders'].'\')" /> '.$box.'</span>'.mswDefineNewline();
        }
        echo trim($html);
      } else {
        echo '####'.$msg_javascript147;
      }
      @imap_close($mbox);
      @imap_errors();
      @imap_alerts();
    } else {
      echo '####'.$msg_javascript147;
    }
  } else {
    echo '####'.$msg_javascript148;
  }
  exit;
}

if (isset($_POST['process'])) {
  $MSSET->addImapAccount();
  $OK = true;
}
  
if (isset($_POST['update'])) {
  $MSSET->editImapAccount();
  $OK2 = true;
} 
  
if (isset($_GET['delete']) && USER_DEL_PRIV=='yes') {
  $count = $MSSET->deleteImapAccount();
  $OK3   = true;
} 

if (isset($_POST['endis'])) {
  $MSSET->enableDisableImap();
  if (isset($_POST['enable'])) {
    $OK4 = true;
  } else {
    $OK5 = true;
  }
}
  
$title  = $msg_adheader24;
  
include(PATH.'templates/header.php');
include(PATH.'templates/system/settings/imap.php');
include(PATH.'control/system/core/footer.php');

?>
