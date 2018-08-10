<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: search.php
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

$title  = $msg_portal17;

// Dispute IDs..
$disputeIDs = $MSTICKET->getDisputeIDs();

include(PATH.'control/header.php');
  
// Count..
$pageCount = $MSTICKET->buildSearchPortalTickets(MS_PERMISSIONS,$disputeIDs,true);

// Page numbers..
define('PER_PAGE',$SETTINGS->portalpages);
$pageNumbers = '';
if ($pageCount>0 && $pageCount>$SETTINGS->portalpages) {
  $PTION        = new pagination($pageCount,'?keys='.urlencode($_GET['keys']).'&amp;next=');
  $pageNumbers  = $PTION->display();
}

// Filters
$tpl = mswGetSavant();
$tpl->assign('TEXT', array(str_replace('{count}',$pageCount,$msg_portsearch),$msg_portsearch2,$msg_portsearch3,$msg_portsearch4));
$tpl->assign('TICKETS', $MSTICKET->buildSearchPortalTickets(MS_PERMISSIONS,$disputeIDs));
$tpl->assign('PAGES', $pageNumbers);
$tpl->display('templates/portal-search.tpl.php');

include(PATH.'control/footer.php');  

?>
