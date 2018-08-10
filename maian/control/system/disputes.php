<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: disputes.php
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

// Filters..
if (isset($_GET['display'])) {
  if (!in_array($_GET['display'],array('tickets','disputes'))) {
    msw404();
  }
}

$title    = $msg_portal45;

include(PATH.'control/header.php');
  
// Dispute IDs..
$disputeIDs = $MSTICKET->getDisputeIDs();

// Count..
$pageCount = $MSTICKET->buildClosedDisputeTickets(MS_PERMISSIONS,$disputeIDs,true);

// Page numbers..
define('PER_PAGE',$SETTINGS->portalpages);
$pageNumbers = '';
if ($pageCount>0 && $pageCount>$SETTINGS->portalpages) {
  $PTION        = new pagination($pageCount,'?p=vd&amp;next=');
  $pageNumbers  = $PTION->display();
}

// Filters
$tpl = mswGetSavant();
$tpl->assign('TEXT', array(str_replace('{count}',$pageCount,$msg_tickets2),$msg_header7));
$tpl->assign('TICKETS', $MSTICKET->buildClosedDisputeTickets(MS_PERMISSIONS,$disputeIDs));
$tpl->assign('PAGES', $pageNumbers);
$tpl->display('templates/portal-disputes.tpl.php');

include(PATH.'control/footer.php');  

?>
