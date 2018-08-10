<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: ticket-open.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// Access..
if (!in_array('open',$userAccess) && $MSTEAM->id!='1') {
  header("Location: index.php?noaccess=1");
  exit;
} 
   
// Ticket preview message..
if (isset($_GET['loadTicketMessage']) && (int)$_GET['loadTicketMessage']>0) {
  $T = mswGetTableData('tickets','id',$_GET['loadTicketMessage']);
  echo mswTxtParsingEngine($T->comments);
  exit;
}   
   
// Department check.. 
if ($MSTEAM->id!='1' && isset($_GET['dept']) && !in_array($_GET['dept'],$userDeptAccess)) {
  header("Location: index.php?p=open");
  exit;
}
     
$title = $msg_adheader5;   

include(PATH.'templates/header.php');
include(PATH.'templates/system/tickets/tickets-open.php');
include(PATH.'control/system/core/footer.php');

?>
