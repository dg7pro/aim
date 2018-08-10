<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: login.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

if ($cmd=='logout') {
  @session_unset();
  @session_destroy();
  unset($_SESSION[md5(SECRET_KEY).'_ms_mail'],$_SESSION[md5(SECRET_KEY).'_ms_key']);

  if (isset($_COOKIE[md5(SECRET_KEY).'_msc_mail'])) {
    @setcookie(md5(SECRET_KEY).'_msc_mail', '');
    @setcookie(md5(SECRET_KEY).'_msc_key', '');
    unset($_COOKIE[md5(SECRET_KEY).'_msc_mail'],$_COOKIE[md5(SECRET_KEY).'_msc_key']);
  }

  header("Location: index.php?p=login");
  exit;
}

if (isset($_POST['process'])) {
  $_POST = array_map('mswCleanEvilTags',$_POST);
  if ($_POST['user'] && $_POST['pass']) {
    if (!mswIsValidEmail($_POST['user'])) {
      $U_ERROR = $msg_login6;
    } else {
      $USER = mswGetTableData('users','email',$_POST['user'],'AND `accpass` = \''.md5(SECRET_KEY.$_POST['pass']).'\'');
      if (isset($USER->email)) {
        // Add entry log..
        $restrictIDs = mswEntryLogRestrictionIDs();
        if (ENABLE_ENTRY_LOG && !in_array($USER->id,$restrictIDs)) {
          $MSUSERS->addEntryLog($USER);
        }
        // Set session..
        $_SESSION[md5(SECRET_KEY).'_ms_mail'] = $USER->email;
        $_SESSION[md5(SECRET_KEY).'_ms_key']  = $USER->accpass;
        // Set cookie..
        if (isset($_POST['cookie']) && COOKIE_NAME) {
          if ((COOKIE_SSL && mswDetectSSLConnection()=='yes') || !COOKIE_SSL) {
            @setcookie(md5(SECRET_KEY).'_msc_mail', $USER->email, time()+60*60*24*COOKIE_EXPIRY_DAYS);
            @setcookie(md5(SECRET_KEY).'_msc_key', $USER->accpass, time()+60*60*24*COOKIE_EXPIRY_DAYS);
          }
        }
        if (isset($_SESSION[md5(SECRET_KEY).'thisTicket'])) {
          $thisTicket = mswReverseTicketNumber($_SESSION[md5(SECRET_KEY).'thisTicket']);
          $SUPTICK    = mswGetTableData('tickets','id',$thisTicket);
          unset($_SESSION[md5(SECRET_KEY).'thisTicket']);
          $userAccess = explode('|',$USER->pageAccess);
          if ($SUPTICK->assignedto=='waiting' && (in_array('assign',$userAccess) || $USER->id==1)) {
            header("Location: index.php?p=assign");
          } elseif ($SUPTICK->assignedto=='waiting' && !in_array('assign',$userAccess)) {
            header("Location: index.php");
          } else {
            header("Location: index.php?p=view-".(isset($SUPTICK->isDisputed) && $SUPTICK->isDisputed=='yes' ? 'dispute' : 'ticket')."&id=".$thisTicket);
          }
        } else {
          header("Location: index.php");
        }
        exit;
      } else {
        $P_ERROR = $msg_login4;
      }
    }
  } else {
    header("Location: index.php?p=login");
    exit;
  }
}
  
// Are we already logged in via cookie..
if (isset($MSTEAM->name)) {
  header("Location: index.php");
  exit;
}

include(PATH.'templates/system/login.php');

?>
