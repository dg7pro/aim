<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: header.php
  Description: Header Parsing File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw404();
}

// If user is logged in, pre-populate name/email fields..
if (defined('MS_PERMISSIONS') && MS_PERMISSIONS!='' && !isset($_POST['process'])) {
  $ACD = mswGetTableData('tickets','email',MS_PERMISSIONS,'ORDER BY id','email,name');
  $PTL = mswGetTableData('portal','email',MS_PERMISSIONS);
  if (isset($ACD->name)) {
    $_POST['name']  = $ACD->name;
    $_POST['email']  = $ACD->email;
    define('POP_NAME',$_POST['name']);
    define('POP_MAIL',$_POST['email']);
  } else {
    // Does this user have dispute info?
    if (mswRowCount('disputes WHERE `userEmail` = \''.MS_PERMISSIONS.'\'')>0) {
      $ACD             = mswGetTableData('disputes','userEmail',MS_PERMISSIONS,'ORDER BY `id` DESC');
      $PTL             = mswGetTableData('portal','email',MS_PERMISSIONS);
      $_POST['name']   = $ACD->userName;
      $_POST['email']  = $ACD->userEmail;
      define('POP_NAME',$_POST['name']);
      define('POP_MAIL',$_POST['email']);
    }
  }
}

$tpl = mswGetSavant();
$tpl->assign('CHARSET', $msg_charset);
$tpl->assign('TITLE', ($title ? mswSpecialChars($title).': ' : '').str_replace('{website}',mswCleanData($SETTINGS->website),$msg_header).(ENABLE_POWERED_BY_LINK && LICENCE_VER!='unlocked' ? ' ('.$msg_script18.' '.$msg_script.')' : '').(LICENCE_VER!='unlocked' ? ' - Free Version' : '').(mswCheckBetaVersion()=='yes' ? ' - BETA VERSION' : ''));
$tpl->assign('SCRIPTPATH', $SETTINGS->scriptpath);
$tpl->assign('LOGOUT', mswSpecialChars($msg_header2));
$tpl->assign('LOGGED_IN', (MS_PERMISSIONS ? 'yes' : 'no'));
$tpl->assign('SCROLL_TO_TOP', (SCROLL_TO_TOP ? 'yes' : 'no'));
$tpl->assign('MY_ACCOUNT', mswSpecialChars($msg_header3));
$tpl->assign('SEARCH', mswSpecialChars($msg_header4));
$tpl->assign('SEARCH_TICKETS',mswSpecialChars($msg_header9));
$tpl->assign('GREYBOX',(isset($loadGreyBox) ? 'yes' : 'no'));
$tpl->assign('TEXT', array(mswSpecialChars($msg_header5),
                           mswSpecialChars($msg_header4),
                           (MS_PERMISSIONS ? str_replace(array('{name}','{email}'),array($_POST['name'],MS_PERMISSIONS),$msg_header6) : ''),
                           mswSpecialChars($msg_header7),
                           mswSpecialChars($msg_header8)
                     )
            );
$tpl->display('templates/header.tpl.php');

?>
