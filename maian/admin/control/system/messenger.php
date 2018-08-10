<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: messenger.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

if (!ENABLE_MESSENGER) {
  header("Location: index.php?noaccess=1");
  exit;
}
  
if (isset($_POST['process']) && $_POST['message']) {
  // Send message to support team..
  if (!empty($_POST['user'])) {
    $q_users = mysql_query("SELECT `name`,`email` FROM ".DB_PREFIX."users
               WHERE `id` IN (".implode(',',$_POST['user']).")
               ORDER BY `name`
               ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    while ($USERS = mysql_fetch_object($q_users)) {
      $msg = str_replace('{name}',$USERS->name,$_POST['message']);
      $MSMAIL->sendMSMail($USERS->name,
                          $USERS->email,
                          $MSTEAM->name,
                          $MSTEAM->email,
                          str_replace(
                           array('{website}','{user}'),
                           array(
                            $SETTINGS->website,
                            $MSTEAM->name
                           ),
                           $msg_messenger5
                          ),
                          (HTML_EMAILS ? nl2br($msg) : $msg)
                );
    }
  }
  // Send copy if selected.
  if (isset($_POST['copy'])) {
    $msg = str_replace('{name}',$MSTEAM->name,$_POST['message']);
    $MSMAIL->sendMSMail($MSTEAM->name,
                        $MSTEAM->email,
                        $SETTINGS->website,
                        $SETTINGS->email,
                        str_replace(
                         array(
                          '{website}',
                          '{user}'
                         ),
                         array(
                          $SETTINGS->website,
                          $MSTEAM->name
                         ),
                         $msg_messenger6
                        ),
                        (HTML_EMAILS ? nl2br($msg) : $msg)
             );
  }
  $OK = true;
}

$title = $msg_adheader23;
  
include(PATH.'templates/header.php');
include(PATH.'templates/system/messenger.php');
include(PATH.'control/system/core/footer.php');

?>