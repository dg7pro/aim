<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: ticket-search.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// Access..
if (!in_array('search',$userAccess) && $MSTEAM->id!='1') {
  header("Location: index.php?noaccess=1");
  exit;
}
  
// Department check..
if ($MSTEAM->id!='1') { 
  if (isset($_GET['department']) && $_GET['department']>0 && !in_array($_GET['department'],$userDeptAccess)) {
    header("Location: index.php?p=search");
    exit;
  }
}

if (isset($_POST['process'])) {
  $cn = $MSTICKET->searchBatchUpdate();
  $OK = true;
}
  
$title      = $msg_search2;
$loadJQAPI  = true;
     
include(PATH.'templates/header.php');
include(PATH.'templates/system/tickets/tickets-search.php');
include(PATH.'control/system/core/footer.php');

?>
