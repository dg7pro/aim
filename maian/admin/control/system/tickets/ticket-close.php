<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: ticket-close.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// Access..
if (!in_array('close',$userAccess) && $MSTEAM->id!='1') {
  header("Location: index.php?noaccess=1");
  exit;
}
  
// Department check..
if ($MSTEAM->id!='1' && isset($_GET['dept']) && !in_array($_GET['dept'],$userDeptAccess)) {
  header("Location: index.php?p=close");
  exit;
}
  
if (isset($_POST['process']) && USER_DEL_PRIV=='yes') {
  $del = $MSTICKET->deleteTickets();
  if ($del>0) {
    $OK = true;
  } else {
    header("Location: index.php?p=close");
    exit;
  }
}
  
if (isset($_GET['open'])) {
  $MSTICKET->reOpenTicket();
  $OK2 = true;
}
     
$title = $msg_adheader6;   
     
include(PATH.'templates/header.php');
include(PATH.'templates/system/tickets/tickets-closed.php');
include(PATH.'control/system/core/footer.php');

?>
