<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: portal.php
  Description: Class File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

class ms_portal {

// Get portal user..
function portalUser() {
  $q = mysql_query("SELECT * FROM ".DB_PREFIX."portal
       WHERE `email` = '".MS_PERMISSIONS."'
       LIMIT 1
       ");
  $P = mysql_fetch_object($q);     
  return $P;
}

// Update timezone..
function updateTimeZone() {
  mysql_query("UPDATE ".DB_PREFIX."portal SET
  `timezone`     = '".mswSafeImportString($_GET['setTS'])."'
  WHERE `email`  = '".MS_PERMISSIONS."'
  LIMIT 1
  ");
}

// Update email address..
function updateEmailAddress($from,$to) {
  // Update portal..
  mysql_query("UPDATE ".DB_PREFIX."portal SET
  `email`        = '$to'
  WHERE `email`  = '$from'
  LIMIT 1
  ");
  // Update tickets..
  mysql_query("UPDATE ".DB_PREFIX."tickets SET
  `email`        = '$to'
  WHERE `email`  = '$from'
  ");
  // Update disputes..
  mysql_query("UPDATE ".DB_PREFIX."disputes SET
  `userEmail`        = '$to'
  WHERE `userEmail`  = '$from'
  ");
  // Update login so we don`t log visitor out..
  $_SESSION[md5(SECRET_KEY).'_msw_support'] = $to;
}

// Update for new password..
function generateNewPassword($email,$password='') {
  $pass = substr (md5(uniqid(rand(),1)),3,PASS_CHARS);
  if ($password) {
    $pass = $password;
  }
  mysql_query("UPDATE ".DB_PREFIX."portal SET
  `userPass`     = '".md5(SECRET_KEY.$pass)."'
  WHERE `email`  = '$email'
  LIMIT 1
  ");
  return $pass;
}

}

?>
