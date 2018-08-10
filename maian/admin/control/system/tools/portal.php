<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: portal.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// Access..
if (!in_array('portal',$userAccess) && $MSTEAM->id!='1') {
  header("Location: index.php?noaccess=1");
  exit;
}
  
if (isset($_GET['autoComplete'])) {
  $emails = $MSTICKET->getAllPostalEmails();
  $string = array();
  if (!empty($emails)) {
    foreach ($emails as $e) {
	    $string[] = mswSpecialChars($e);
    }
    echo implode(',',$string);
    exit;
  }
  echo 'none';
  exit;
}
     
if (isset($_POST['process'])) {
  if (mswIsValidEmail($_POST['email']) && $_POST['accpass']) {
    if (mswRowCount('portal WHERE `email` = \''.mswSafeImportString($_POST['email']).'\'')>0) {
      // Create and send new password...
      $newPass = $MSUSERS->generateNewPassword($_POST['email'],$_POST['accpass']);
      if (isset($_POST['mail'])) {
        $ACD = mswGetTableData('tickets','email',$_POST['email'],'ORDER BY id');
        $MSMAIL->addTag('{ACCPASS}',$newPass);
        $MSMAIL->sendMSMail((isset($ACD->name) ? $ACD->name : $_POST['email']),
                            $_POST['email'],
                            $SETTINGS->website,
                            $SETTINGS->email,
                            str_replace('{website}',$SETTINGS->website,$msg_main12),
                            $MSMAIL->template(LANG_PATH.'new-password.txt')
                 );
      }
      foreach ($_POST AS $key => $value) {
        unset($_POST[$key]);
      }
      $OK = true;
    } else {
      $eString[] = 'email';
    }
  } else {
    header("Location: ?p=portal");
    exit;
  }
}
  
if (isset($_POST['process2'])) {
  if (mswIsValidEmail($_POST['email']) && mswIsValidEmail($_POST['email2'])) {
    if (mswRowCount('portal WHERE `email` = \''.mswSafeImportString($_POST['email']).'\'')==0) {
      $eString[] = 'email';
    }
    if (mswRowCount('portal WHERE `email` = \''.mswSafeImportString($_POST['email2']).'\'')==0) {
      $eString[] = 'email2';
    }
    if (empty($eString)) {
      // Move tickets..
      $moved = $MSTICKET->moveTickets($_POST['email'],$_POST['email2']);
      if (isset($_POST['mail'])) {
        $ACD = mswGetTableData('tickets','email',$_POST['email2'],'ORDER BY id');
        $MSMAIL->addTag('{FEMAIL}',$_POST['email']);
        $MSMAIL->addTag('{TEMAIL}',$_POST['email2']);
        $MSMAIL->sendMSMail((isset($ACD->name) ? $ACD->name : $_POST['email2']),
                            $_POST['email2'],
                            $SETTINGS->website,
                            $SETTINGS->email,
                            str_replace('{website}',$SETTINGS->website,$msg_systemportal14),
                            $MSMAIL->template(LANG_PATH.'tickets-moved.txt')
                 );
      }
      foreach ($_POST AS $key => $value) {
        unset($_POST[$key]);
      }
      $OK2 = true;
    }
  } else {
    header("Location: ?p=portal");
    exit;
  }
}
  
if (isset($_POST['process3'])) {
  if (isset($_POST['email']) || isset($_POST['name'])) {
    $MSTICKET->exportPortal();
  } else {
    header("Location: ?p=portal");
    exit;
  }
}

if (isset($_POST['process4'])) {
  if (mswIsValidEmail($_POST['email'])) {
    if (mswRowCount('portal WHERE `email` = \''.mswSafeImportString($_POST['email']).'\'')==0) {
      $eString[] = 'email';
    }
    if (empty($eString)) {
      // Block account..
      $MSTICKET->disableAccount();
      foreach ($_POST AS $key => $value) {
        unset($_POST[$key]);
      }
      $OK3 = true;
    }
  } else {
    header("Location: ?p=portal");
    exit;
  }
}

if (isset($_GET['enable']) && mswIsValidEmail($_GET['enable'])) {
  // Enable account..
  $cnt = $MSTICKET->enableAccount();
  $OK4 = true;
}
  
$title      = $msg_adheader21;
$loadJQAPI  = true;
  
include(PATH.'templates/header.php');
include(PATH.'templates/system/tools/portal.php');
include(PATH.'control/system/core/footer.php');

?>
