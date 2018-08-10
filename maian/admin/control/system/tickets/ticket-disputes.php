<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: ticket-disputes.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// Access..
if (!in_array('disputes',$userAccess) && $MSTEAM->id!='1') {
  header("Location: index.php?noaccess=1");
  exit;
} 
   
// Department check.. 
if ($MSTEAM->id!='1' && isset($_GET['dept']) && !in_array($_GET['dept'],$userDeptAccess)) {
  header("Location: index.php?p=disputes");
  exit;
}
     
$title = $msg_adheader28;   

include(PATH.'templates/header.php');
include(PATH.'templates/system/tickets/tickets-disputes.php');
include(PATH.'control/system/core/footer.php');

?>
