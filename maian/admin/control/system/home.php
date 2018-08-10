<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: home.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// Version check..
if (isset($_GET['versionCheck'])) {
  mswSoftwareVersionCheck();
}

if (isset($_GET['restr']) || isset($_GET['locked'])) {
  $title = (isset($_GET['restr']) ? $msg_script22 : $msg_script25);
  include(PATH.'templates/header.php');
  include(PATH.'control/system/core/controller.php');
} else {
  $jqPlot = true;
  include(PATH.'templates/header.php');
  include(PATH.'templates/system/home.php');
}
include(PATH.'control/system/core/footer.php');

?>
