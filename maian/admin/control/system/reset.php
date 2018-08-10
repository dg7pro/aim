<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: reset.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// Permissions..
if (!defined('PASS_RESET')) {
  die('This page cannot be accessed. Refer to the <a href="../docs/reset.html">documentation</a> on how to access the reset page');
}

// Update..
if (isset($_POST['process'])) {
  $MSUSERS->reset();
  $OK = true;
}

$title = $msg_adheader36;
if (file_exists(PATH.'templates/reset.php')) {
  include(PATH.'templates/reset.php');
} else {
  die('Reset template file is missing. Did you rename it? Refer to the <a href="../docs/reset.html">documentation</a>.');
}

?>
