<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: tickets.php
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

$title = $msg_portal13;

include(PATH.'control/header.php');
  
// Count..
$pageCount = $MSTICKET->buildClosedPortalTickets(MS_PERMISSIONS,true);

// Page numbers..
define('PER_PAGE',$SETTINGS->portalpages);
$pageNumbers = '';
if ($pageCount>0 && $pageCount>$SETTINGS->portalpages) {
  $PTION        = new pagination($pageCount,'?p=vt&amp;next=');
  $pageNumbers  = $PTION->display();
}

// Filters
$tpl = mswGetSavant();
$tpl->assign('TEXT', array(str_replace('{count}',$pageCount,$msg_tickets),$msg_header7));
$tpl->assign('TICKETS', $MSTICKET->buildClosedPortalTickets(MS_PERMISSIONS));
$tpl->assign('PAGES', $pageNumbers);
$tpl->display('templates/portal-tickets.tpl.php');

include(PATH.'control/footer.php');  

?>
