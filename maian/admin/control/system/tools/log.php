<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: log.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// Access..
if (!in_array('log',$userAccess) && $MSTEAM->id!='1') {
  header("Location: index.php?noaccess=1");
  exit;
}   
     
if (isset($_GET['clear']) && USER_DEL_PRIV=='yes') {
  $count = $MSSET->clearLogFile();
  $OK    = true;
}
  
if (isset($_GET['export'])) {
  $MSSET->exportLogFile();
}
  
$title = $msg_adheader20;
  
include(PATH.'templates/header.php');
include(PATH.'templates/system/tools/log.php');
include(PATH.'control/system/core/footer.php');

?>
