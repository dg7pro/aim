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

// Check log in..
if (MS_PERMISSIONS=='') {
  header("Location:index.php");
  exit;
}

// Update timezone..
if (isset($_GET['setTS'])) {
  $MSPORTAL->updateTimeZone();
  exit;
}

// Filters..
if (isset($_GET['display'])) {
  if (!in_array($_GET['display'],array('tickets','disputes'))) {
    msw404();
  }
}

// Process new email..
if (isset($_POST['portemail'])) {
  if ($_POST['portemail']==MS_PERMISSIONS) {
    echo 'error#####'.mswSpecialChars($msg_portal31);
  } else {
    if (!mswIsValidEmail($_POST['portemail'])) {
      echo 'error#####'.mswSpecialChars($msg_portal30);
    } else {
      $PORTAL = mswGetTableData('portal','email',$_POST['portemail']);
      if (isset($PORTAL->id)) {
        echo 'error#####'.mswSpecialChars($msg_portal32);
      } else {
        $MSPORTAL->updateEmailAddress(MS_PERMISSIONS,$_POST['portemail']);
        if (CHANGE_EMAIL_NOTIFICATION) {
          $ACD = mswGetTableData('tickets','email',$_POST['portemail'],'ORDER BY id');
          $MSMAIL->sendMSMail((isset($ACD->name) ? $ACD->name : $_POST['portemail']),
                              $_POST['portemail'],
                              $SETTINGS->website,
                              $SETTINGS->email,
                              str_replace('{website}',$SETTINGS->website,$msg_portal34),
                              $MSMAIL->template(E_LANG_PATH.'email/change-email.txt')
                   );
        }
        echo 'ok#####'.mswSpecialChars($msg_portal33);
      }
    }
  }
  exit;
}
  
// Process password update..
if (isset($_POST['pass'])) {
  if (strlen($_POST['pass'])<PASS_CHARS) {
    echo 'error#####'.str_replace('{min}',PASS_CHARS,$msg_portal14); 
  } else {
    $MSPORTAL->generateNewPassword(MS_PERMISSIONS,$_POST['pass']);
    if (CHANGE_PASS_NOTIFICATION) {
      $ACD = mswGetTableData('tickets','email',MS_PERMISSIONS,'ORDER BY id');
      $MSMAIL->addTag('{PASSWORD}',$_POST['pass']);
      $MSMAIL->sendMSMail((isset($ACD->name) ? $ACD->name : MS_PERMISSIONS),
                          MS_PERMISSIONS,
                          $SETTINGS->website,
                          $SETTINGS->email,
                          str_replace('{website}',$SETTINGS->website,$msg_main12),
                          $MSMAIL->template(E_LANG_PATH.'email/change-password.txt')
               );
    }
    echo 'ok#####'.str_replace('{pass}',$_POST['pass'],mswSpecialChars($msg_portal29));
  }
  exit;
}
  
// Get dispute ids..
$disputeIDs  = array();
$qDisOther   = mysql_query("SELECT * FROM ".DB_PREFIX."disputes 
               WHERE userEmail = '".MS_PERMISSIONS."'
               GROUP BY ticketID
               ORDER BY ticketID
               ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
while ($D = mysql_fetch_object($qDisOther)) {
  $disputeIDs[] = $D->ticketID;
}

// Ticket counts..
$tOpenCount  = mswRowCount('tickets WHERE email = \''.MS_PERMISSIONS.'\' AND ticketStatus = \'open\' AND isDisputed = \'no\'');
// Current ticket counts..
$dOpenCount  = mswRowCount('tickets WHERE email = \''.MS_PERMISSIONS.'\' AND ticketStatus = \'open\' AND isDisputed = \'yes\'');
// Counts of other tickets in dispute..
$dOpenOther  = mswRowCount('tickets WHERE id IN ('.(!empty($disputeIDs) ? implode(',',$disputeIDs) : '0').') AND ticketStatus = \'open\' AND isDisputed = \'yes\'');
$title       = $msg_header3;

include(PATH.'control/header.php');
  
// Display text for left box..
if ($cmd=='portal-new') {
  $leftText = $msg_portal35;
} else {
  $leftText = $msg_portal5;
}  
  
// Count..
$pageCount = $MSTICKET->buildPortalTickets(MS_PERMISSIONS,$disputeIDs,true);

// Page numbers..
define('PER_PAGE',$SETTINGS->portalpages);
$pageNumbers = '';
if ($pageCount>0 && $pageCount>$SETTINGS->portalpages) {
  $PTION        = new pagination($pageCount,'?p=portal'.(isset($_GET['display']) ? '&amp;display='.$_GET['display'] : '').'&amp;next=');
  $pageNumbers  = $PTION->display();
}

// Filters
$tpl = mswGetSavant();
$tpl->assign('MESSAGE', array($msg_portal2,($cmd=='portal-new' ? $msg_portal17 : (isset($PASS_UPDATED) ? $msg_portal22 : $msg_portal))));
$tpl->assign('TEXT', array(str_replace('{min}',PASS_CHARS,$msg_portal4),
                           $msg_portal3,
                           $leftText,
                           $msg_portal6,
                           $msg_portal25,
                           mswSpecialChars($msg_portal26),
                           str_replace('{open}',$tOpenCount,$msg_portal27),
                           str_replace('{dis_open}',($dOpenCount+$dOpenOther),$msg_portal28),
                           mswSpecialChars($msg_portal37),
                           mswSpecialChars($msg_portal38),
                           mswSpecialChars($msg_portal39),
                           mswSpecialChars($msg_portal40),
                           mswSpecialChars($msg_portal41),
                           mswSpecialChars($msg_portal46),
                           mswSpecialChars($msg_portal47)
                     )
            );
$tpl->assign('CREATED_CLASS', '');   
$tpl->assign('TIMEZONES', $timezones);     
$tpl->assign('CURRENT_TS', ($PTL->timezone!='0' ? $PTL->timezone : $SETTINGS->timezone));
$tpl->assign('JS', array_map('mswFilterJS',array($msg_javascript43)));
$tpl->assign('ERROR', array((in_array('pass',$eFields) ? '<span class="error">'.$eString[0].'</span>' : '')));
$tpl->assign('TICKETS', $MSTICKET->buildPortalTickets(MS_PERMISSIONS,$disputeIDs));
$tpl->assign('PAGES', $pageNumbers);
$tpl->display('templates/portal-main.tpl.php');

unset($_SESSION['newTickPass']);

include(PATH.'control/footer.php');  

?>
