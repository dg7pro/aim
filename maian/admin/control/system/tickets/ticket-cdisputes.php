<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: ticket-cdisputes.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// Access..
if (!in_array('cdisputes',$userAccess) && $MSTEAM->id!='1') {
  header("Location: index.php?noaccess=1");
  exit;
} 
   
// Department check.. 
if ($MSTEAM->id!='1' && isset($_GET['dept']) && !in_array($_GET['dept'],$userDeptAccess)) {
  header("Location: index.php?p=cdisputes");
  exit;
}

if (isset($_POST['process']) && USER_DEL_PRIV=='yes') {
  $del = $MSTICKET->deleteTickets();
  if ($del>0) {
    $OK = true;
  } else {
    header("Location: index.php?p=cdisputes");
    exit;
  }
}
  
if (isset($_GET['open'])) {
  $cnt = $MSTICKET->reOpenTicket();
  $OK2 = true;
}
     
$title = $msg_adheader29;   
     
include(PATH.'templates/header.php');
include(PATH.'templates/system/tickets/tickets-cdisputes.php');
include(PATH.'control/system/core/footer.php');

?>
