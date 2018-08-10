<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: disabled.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// Auto enable..
if ($SETTINGS->autoenable!='0000-00-00' && $SETTINGS->autoenable<=mswSQLDate()) {
  mysql_query("UPDATE ".DB_PREFIX."settings SET
  `sysstatus`   = 'yes',
  `autoenable`  = '0000-00-00'
  ");
  header("Location: index.php");
  exit;
}

$title = $msg_offline;

$tpl = mswGetSavant();
$tpl->assign('CHARSET', $msg_charset);
$tpl->assign('TITLE', ($title ? mswSpecialChars($title).': ' : '').str_replace('{website}',mswCleanData($SETTINGS->website),$msg_header).(ENABLE_POWERED_BY_LINK && LICENCE_VER!='unlocked' ? ' ('.$msg_script18.' '.$msg_script.')' : '').(LICENCE_VER!='unlocked' ? ' - Free Version' : '').(mswCheckBetaVersion()=='yes' ? ' - BETA VERSION' : ''));
$tpl->assign('TEXT', array($msg_offline,($SETTINGS->autoenable!='0000-00-00' ? str_replace('{date}',date($SETTINGS->dateformat,strtotime($SETTINGS->autoenable)),$msg_offline3) : $msg_offline2)));
$tpl->assign('SETTINGS', $SETTINGS);
$tpl->display('templates/system-disabled.tpl.php');

?>