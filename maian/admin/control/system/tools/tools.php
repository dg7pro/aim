<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: tools.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// Access..
if (!in_array('tools',$userAccess) && $MSTEAM->id!='1') {
  header("Location: index.php?noaccess=1");
  exit;
}
     
if (isset($_POST['process']) && USER_DEL_PRIV=='yes') {
  $counts  = $MSTICKET->purgeTickets();
  $OK      = true;
}
  
if (isset($_POST['process2']) && USER_DEL_PRIV=='yes') {
  $count  = $MSTICKET->purgeAttachments();
  $OK2    = true;
}
  
$title = $msg_adheader18;
  
include(PATH.'templates/header.php');
include(PATH.'templates/system/tools/tools.php');
include(PATH.'control/system/core/footer.php');

?>
