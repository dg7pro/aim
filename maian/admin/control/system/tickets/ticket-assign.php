<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: ticket-assign.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// Access..
if (!in_array('assign',$userAccess) && $MSTEAM->id!='1') {
  header("Location: index.php?noaccess=1");
  exit;
} 

// Assign..
if (isset($_POST['process'])) {
  $processed   = 0;
  $userNotify  = array();
  foreach ($_POST['ticketID'] AS $ID) {
    if (!empty($_POST['assign'][$ID])) {
      ++$processed;
      // Assigned users..
      $assigned    = implode(',',$_POST['assign'][$ID]);
      $userNotify  = array_merge($userNotify,$_POST['assign'][$ID]);
      // Update ticket..
      $MSTICKET->ticketUserAssign($ID,$assigned); 
    }
  }
  // Email users..
  if (!empty($userNotify) && isset($_POST['mail'])) {
    $userEmIDs  = array_unique($userNotify);
    $eLanPh     = REL_PATH.'templates/language/'.$SETTINGS->language.'/admin-email/'; 
    $q_users    = mysql_query("SELECT `name`,`email` FROM ".DB_PREFIX."users
                  WHERE `id` IN (".implode(',',$userEmIDs).")
                  AND `id`   != '{$MSTEAM->id}'
                  ORDER BY `name`
                  ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    while ($USERS = mysql_fetch_object($q_users)) {
      $MSMAIL->addTag('{ASSIGNEE}',$MSTEAM->name);
      $MSMAIL->addTag('{NAME}',$USERS->name);
      // Include support team member signature..
      if ($MSTEAM->signature && $MSTEAM->emailSigs=='yes') {
        $MSMAIL->addTag('{SIGNATURE}', mswCleanData($MSTEAM->signature));
      } else {
        $MSMAIL->addTag('{SIGNATURE}', '');
      }
      $MSMAIL->sendMSMail($USERS->name,
                          $USERS->email,
                          $MSTEAM->name,
                          $MSTEAM->email,
                          str_replace(
                           array('{website}','{user}'),
                           array($SETTINGS->website,$MSTEAM->name),
                           $msg_viewticket91
                          ),
                          $MSMAIL->template($eLanPh.'ticket-assign.txt')
               ); 
    }
  }
  $OK = true;
}
   
$title = $msg_adheader32;   

include(PATH.'templates/header.php');
include(PATH.'templates/system/tickets/tickets-assign.php');
include(PATH.'control/system/core/footer.php');

?>