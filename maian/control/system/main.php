<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: main.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

if (isset($_GET['bbhelp'])) {
  
  $tpl = mswGetSavant();
  $tpl->assign('CHARSET', $msg_charset);
  $tpl->assign('TITLE', $msg_newticket32);
  $tpl->assign('TEXT', array('',$msg_bbcode,$msg_bbcode27,$msg_bbcode3,$msg_bbcode4,$msg_bbcode5,$msg_bbcode6,$msg_bbcode7,$msg_bbcode8,$msg_bbcode9,$msg_bbcode10,
                                $msg_bbcode11,$msg_bbcode12,$msg_bbcode13,$msg_bbcode14,$msg_bbcode15,$msg_bbcode16,$msg_bbcode17,$msg_bbcode18,$msg_bbcode19,$msg_bbcode20,
                                $msg_bbcode21,$msg_bbcode22,$msg_bbcode23,$msg_bbcode24,$msg_bbcode25,$msg_bbcode26,$msg_bbcode28,$msg_bbcode29,$msg_bbcode30));
  $tpl->display('templates/bb-code-help.tpl.php');
  exit;
}

if (isset($_GET['np'])) {
  if (!mswIsValidEmail($_GET['np'])) {
    echo 'error#####'.$msg_javascript59;
  } else {
    $ACC = mswGetTableData('portal','email',mswSafeImportString($_GET['np']));
    if (!isset($ACC->email)) {
      echo 'error#####'.$msg_javascript60;
    } else {
      $ACD = mswGetTableData('tickets','email',mswSafeImportString($_GET['np']),'ORDER BY id');
      // Create and send new password...
      $newPass = $MSPORTAL->generateNewPassword($_GET['np']);
      $MSMAIL->addTag('{PASSWORD}',$newPass);
      $MSMAIL->sendMSMail($ACD->name,
                        $ACC->email,
                        $SETTINGS->website,
                        $SETTINGS->email,
                        str_replace('{website}',$SETTINGS->website,$msg_main12),
                        $MSMAIL->template(E_LANG_PATH.'email/new-password.txt')
                        );
      echo 'ok#####'.str_replace('{email}',$_GET['np'],$msg_javascript61);                  
    }
  }
  exit;
}

// Log out..
if ($cmd=='logout') {
  $_SESSION[md5(SECRET_KEY).'_msw_support'] = '';
  unset($_SESSION[md5(SECRET_KEY).'_msw_support'],$_SESSION['portalEmail']);
  header("Location: index.php");
  exit;
}
      
// Log into portal..
if (isset($_POST['process'])) {
  if ($_POST['email'] && $_POST['upass']) {
    $_POST = mswMultiDimensionalArrayMap('mswSafeImportString',$_POST);
    // Check for valid e-mail..
    if (!mswIsValidEmail($_POST['email'])) {
      $eFields[]  = 'email';
      $eString[]  = $msg_main13; 
    } else {
      // Now check account..
      $ACC = mswGetTableData('portal','email',$_POST['email'],'AND userPass = \''.md5(SECRET_KEY.$_POST['upass']).'\'');
      if (isset($ACC->email)) {
        // Check access..
        if ($ACC->enabled=='yes') {
          $_SESSION[md5(SECRET_KEY).'_msw_support'] = $ACC->email;
          // Ticket/dispute redirection..
          if (AUTO_VIS_TICKET_REDIRECT) {
            if (isset($_SESSION['ticketAccessID']) && $_SESSION['ticketAccessID']>0) {
              $rid = $_SESSION['ticketAccessID'];
              unset($_SESSION['ticketAccessID']);
              header("Location: index.php?t=".$rid);
              exit;
            }
            if (isset($_SESSION['disputeAccessID']) && $_SESSION['disputeAccessID']>0) {
              $rid = $_SESSION['disputeAccessID'];
              unset($_SESSION['disputeAccessID']);
              header("Location: index.php?d=".$rid);
              exit;
            }
          }
          header("Location: index.php?p=portal");
          exit;
        } else {
          // Clear fields..
          $_POST['email']  = '';
          $_POST['upass']  = '';
          $eFields[]       = 'none';
          $eString[]       = $msg_main20;
        }
      } else {
        $eFields[]  = 'none';
        $eString[]  = $msg_main14; 
      }
    }
  } else {
    header("Location: index.php");
    exit;
  }
}
  
// If logged in direct to portal..
if (MS_PERMISSIONS) {
  header("Location: index.php?p=portal");
  exit;
}
  
include(PATH.'control/header.php');
  
// Pre-populate email field if ticket created..
$prePop = array('','');
$msg    = '';
if (isset($_SESSION['portalEmail'])) {
  $prePop[0]  = $_SESSION['portalEmail'];
  $msg        = $msg_main19;
}
if (isset($_SESSION['newTickPass'])) {
  $prePop[1]  = $_SESSION['newTickPass'];
  $msg        = str_replace('{password}',$prePop[1],$msg_main15);
}
if (isset($_GET['e'])) {
  $_POST['email'] = $_GET['e'];
}
if (isset($_GET['ap'])) {
  $_POST['upass'] = $_GET['ap'];
}
 
$tpl = mswGetSavant();
$tpl->assign('MESSAGE', array($msg_main,$msg_main2,str_replace('{count}',$SETTINGS->popquestions,$msg_main10)));
$tpl->assign('TEXT', array($msg_main3,$msg_main4,mswSpecialChars($msg_main5),mswSpecialChars($msg_main6),
                           mswSpecialChars($msg_main9),mswSpecialChars($msg_main11),$msg,mswSpecialChars($msg_main16),
                           mswSpecialChars($msg_main2),mswSpecialChars($msg_main17),mswSpecialChars($msg_main18)));
$tpl->assign('JS',array_map('mswFilterJS',array($msg_javascript43)));
$tpl->assign('VALUE', array((isset($_POST['email']) ? mswSpecialChars($_POST['email']) : $prePop[0]),(isset($_POST['upass']) ? mswSpecialChars($_POST['upass']) : $prePop[1])));
$tpl->assign('ERROR', array((in_array('email',$eFields) ? '<span class="error" id="eError">'.$eString[0].'</span>' : ''),(in_array('none',$eFields) ? '<span class="error" id="pError">'.$eString[0].'</span>' : '')));
$tpl->assign('SETTINGS', $SETTINGS);
$tpl->assign('QUESTIONS',$FAQ->buildLinks(0,false));
$tpl->display('templates/main-display.tpl.php');
if (isset($_SESSION['newTickPass'])) {
  unset($_SESSION['newTickPass']);
}
if (isset($_SESSION['portalEmail'])) {
  unset($_SESSION['portalEmail']);
}
include(PATH.'control/footer.php');  

?>