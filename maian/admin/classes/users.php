<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: users.php
  Description: Class File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

class systemUsers {

var $settings;

function reset() {
  for ($i=0; $i<count($_POST['id']); $i++) {
    $e   = $_POST['email'][$i];
    $p   = ($_POST['password'][$i] ? md5(SECRET_KEY.$_POST['password'][$i]) : $_POST['password2'][$i]);
    $id  = $_POST['id'][$i];
    if ($e && $p) {
      mysql_query("UPDATE ".DB_PREFIX."users SET
      `email`     = '$e',
      `accpass`   = '$p'
      WHERE `id`  = '$id'
      LIMIT 1
      ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    }
  }
}

function userGraphData() {
  global $msg_script29,$msg_script28,$msg_script21;
  $ticks  = '';
  $line1  = '';
  $line2  = '';
  $range  = (isset($_GET['range']) && in_array($_GET['range'],array('today','week','month','year')) ? $_GET['range'] : USER_DEFAULT_GRAPH_VIEW);
  switch ($range) {
    // Today..
    case 'today':
    $t   = array();
    $l1  = array();
    $l2  = array();
    $ts  = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');
    $dt  = systemUsers::today();
    if (!empty($ts)) {
      foreach ($ts AS $tks) {
        $l1[] = (isset($dt['no-'.$tks]) ? $dt['no-'.$tks] : '0');
        $l2[] = (isset($dt['yes-'.$tks]) ? $dt['yes-'.$tks] : '0');
        $t[]  = "'$tks'";
      }
      $line1 = implode(',',$l1);
      $line2 = implode(',',$l2);
      $ticks = implode(',',$t);
    }
    break;
    // This week..
    case 'week':
    $t      = array();
    $l1     = array();
    $l2     = array();
    $which  = ($this->settings->weekStart=='sun' ? $msg_script29 : $msg_script28);
    // Determine start and end day for loop..
    if ($this->settings->weekStart=='sun') {
      switch (date('D')) {
        case 'Sun':
        $from  = mswSQLDate();
        break;
        default:
        $from  = date("Y-m-d",strtotime('last sunday',mswTimeStamp()));
        break;
      }
    } else {
      switch (date('D')) {
        case 'Mon':
        $from  = mswSQLDate();
        break;
        default:
        $from  = date("Y-m-d",strtotime('last monday',mswTimeStamp()));
        break;
      }
    }
    $dt = systemUsers::week($from,date("Y-m-d",strtotime("+6 days",strtotime($from))));
    for ($i=0; $i<7; $i++) {
      $day   = date("d",strtotime("+".$i." days",strtotime($from)));
      $l1[]  = (isset($dt['no-'.$day]) ? $dt['no-'.$day] : '0');
      $l2[]  = (isset($dt['yes-'.$day]) ? $dt['yes-'.$day] : '0');
    }
    foreach ($which AS $ts) {
      $t[]  = "'$ts'";
    }
    $line1 = implode(',',$l1);
    $line2 = implode(',',$l2);
    $ticks = implode(',',$t);
    break;
    // This month..
    case 'month':
    $t            = array();
    $l1           = array();
    $l2           = array();
    $daysInMonth  = date('t',mktime(0,0,0,date('m',mswTimeStamp()),1,date('Y',mswTimeStamp())));
    if ($daysInMonth>0) {
      $dt = systemUsers::month();
      for ($i=1; $i<$daysInMonth+1; $i++) {
        $i    = ($i<10 ? '0'.$i : $i);
        $l1[] = (isset($dt['no-'.$i]) ? $dt['no-'.$i] : '0');
        $l2[] = (isset($dt['yes-'.$i]) ? $dt['yes-'.$i] : '0');
        $t[]  = "'$i'";
      }
      $line1 = implode(',',$l1);
      $line2 = implode(',',$l2);
      $ticks = implode(',',$t);
    }
    break;
    // This year..
    case 'year':
    $t   = array();
    $l1  = array();
    $l2  = array();
    if (!empty($msg_script21)) {
      $dt = systemUsers::year();
      for ($i=1; $i<13; $i++) {
        $i    = ($i<10 ? '0'.$i : $i);
        $l1[] = (isset($dt['no-'.$i]) ? $dt['no-'.$i] : '0');
        $l2[] = (isset($dt['yes-'.$i]) ? $dt['yes-'.$i] : '0');
      }
      foreach ($msg_script21 AS $ts) {
        $t[]  = "'$ts'";
      }
      $line1 = implode(',',$l1);
      $line2 = implode(',',$l2);
      $ticks = implode(',',$t);
    }
    break;
  }
  // Prevent JS error..
  if ($line1=='' || $line2=='' || $ticks=='') {
    return array("'0','0','0'","'0','0','0'","'Invalid Config','Invalid Config','Invalid Config'");  
  }
  return array($line1,$line2,$ticks);
}

// Counts for today..
function today() {
  $today = array();
  $q     = mysql_query("SELECT HOUR(FROM_UNIXTIME(".DB_PREFIX."replies.`ts`)) AS h,count(*) as c,`isDisputed` FROM ".DB_PREFIX."tickets
           LEFT JOIN ".DB_PREFIX."replies
           ON ".DB_PREFIX."tickets.id = ".DB_PREFIX."replies.ticketID
           WHERE DATE(FROM_UNIXTIME(".DB_PREFIX."replies.`ts`)) = '".mswSQLDate()."'
           GROUP BY HOUR(".DB_PREFIX."replies.addTime),`isDisputed`
           ");
  while ($TD = mysql_fetch_object($q)) {
    $TD->h = ($TD->h>0 ? ($TD->h<10 ? '0'.$TD->h : $TD->h) : '00');
    switch ($TD->isDisputed) {
      case 'yes':
      $today['yes-'.$TD->h] = $TD->c;
      break;
      case 'no':
      $today['no-'.$TD->h] = $TD->c;
      break;
    }
  }
  return $today;
}

// Count for week..
function week($from,$to) {
  $week  = array();
  $q     = mysql_query("SELECT DAY(FROM_UNIXTIME(".DB_PREFIX."replies.`ts`)) AS d,count(*) as c,`isDisputed` FROM ".DB_PREFIX."tickets
           LEFT JOIN ".DB_PREFIX."replies
           ON ".DB_PREFIX."tickets.id = ".DB_PREFIX."replies.ticketID 
           WHERE DATE(FROM_UNIXTIME(".DB_PREFIX."replies.`ts`)) BETWEEN '$from' AND '$to'  
           GROUP BY DAY(FROM_UNIXTIME(".DB_PREFIX."replies.`ts`)),`isDisputed`
           ");
  while ($TD = mysql_fetch_object($q)) {
    $TD->d = ($TD->d>0 ? ($TD->d<10 ? '0'.$TD->d : $TD->d) : '00');
    switch ($TD->isDisputed) {
      case 'yes':
      $week['yes-'.$TD->d] = $TD->c;
      break;
      case 'no':
      $week['no-'.$TD->d] = $TD->c;
      break;
    }
  }
  return $week;
}

// Count for month..
function month() {
  $month  = array();
  $q      = mysql_query("SELECT DAY(FROM_UNIXTIME(".DB_PREFIX."replies.`ts`)) AS d,count(*) as c,`isDisputed` FROM ".DB_PREFIX."tickets
            LEFT JOIN ".DB_PREFIX."replies
            ON ".DB_PREFIX."tickets.id = ".DB_PREFIX."replies.ticketID 
            WHERE MONTH(FROM_UNIXTIME(".DB_PREFIX."replies.`ts`)) = '".mswSQLDate()."' 
            GROUP BY DAY(FROM_UNIXTIME(".DB_PREFIX."replies.`ts`)),`isDisputed`
            ");
  while ($TD = mysql_fetch_object($q)) {
    $TD->d = ($TD->d>0 ? ($TD->d<10 ? '0'.$TD->d : $TD->d) : '00');
    switch ($TD->isDisputed) {
      case 'yes':
      $month['yes-'.$TD->d] = $TD->c;
      break;
      case 'no':
      $month['no-'.$TD->d] = $TD->c;
      break;
    }
  }
  return $month;
}

// Count for year..
function year() {
  $year  = array();
  $q     = mysql_query("SELECT MONTH(FROM_UNIXTIME(".DB_PREFIX."replies.`ts`)) AS m,count(*) as c,`isDisputed` FROM ".DB_PREFIX."tickets 
           LEFT JOIN ".DB_PREFIX."replies
           ON ".DB_PREFIX."tickets.id = ".DB_PREFIX."replies.ticketID
           WHERE YEAR(FROM_UNIXTIME(".DB_PREFIX."replies.`ts`)) = '".mswSQLDate()."' 
           GROUP BY MONTH(FROM_UNIXTIME(".DB_PREFIX."replies.`ts`)),`isDisputed`
           ");
  while ($TD = mysql_fetch_object($q)) {
    $TD->m = ($TD->m>0 ? ($TD->m<10 ? '0'.$TD->m : $TD->m) : '00');
    switch ($TD->isDisputed) {
      case 'yes':
      $year['yes-'.$TD->m] = $TD->c;
      break;
      case 'no':
      $year['no-'.$TD->m] = $TD->c;
      break;
    }
  }
  return $year;
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

function generateSecurePassword() {
  $split = explode('|',$_GET['autoPass']);
  $sec   = array();
  $pass  = '';
  $chars = (isset($split[4]) && $split[4]>0 ? $split[4] : 6);
  if (isset($split[0]) && $split[0]=='yes') {
    $sec[]   = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
  }
  if (isset($split[1]) && $split[1]=='yes') {
    $sec[]  = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
  }
  if (isset($split[2]) && $split[2]=='yes') {
    $sec[]  = array(0,1,2,3,4,5,6,7,8,9);
  }
  if (isset($split[3]) && $split[3]=='yes') {
    $sec[]  = array('[',']','&','*','(',')','#','!','%');
  }
  if (empty($sec)){
    return substr (md5(uniqid(rand(),1)),0,$chars);
  }
  $keys = array_keys($sec);
  for ($i=0; $i<$chars; $i++) {
    $rand  = rand($keys[0],$keys[count($keys)-1]);
    shuffle($sec[$keys[$rand]]);
    $char  = $sec[$rand][rand(0,5)];
    $pass .= $char;
  }
  return $pass;
}

function updateNotifications() {
  if (!empty($_POST['id'])) {
    mysql_query("UPDATE ".DB_PREFIX."users SET
    `notify` = '".(isset($_POST['enable']) ? 'yes' : 'no')."'
    WHERE `id` IN (".implode(',',$_POST['id']).")
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
}

function setNotification() {
  if (isset($_GET['set_notify'])) {
    $_GET['set_notify'] = in_array($_GET['set_notify'],array('yes','no')) ? $_GET['set_notify'] : 'no';
    if (is_numeric($_GET['view'])) {
      mysql_query("UPDATE ".DB_PREFIX."users SET
      `notify`    = '{$_GET['set_notify']}'
      WHERE `id`  = '{$_GET['view']}'
      LIMIT 1
      ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    }
  }
  if (isset($_GET['set_sig'])) {
    $_GET['set_sig'] = in_array($_GET['set_sig'],array('yes','no')) ? $_GET['set_sig'] : 'no';
    if (is_numeric($_GET['view'])) {
      mysql_query("UPDATE ".DB_PREFIX."users SET
      `emailSigs` = '{$_GET['set_sig']}'
      WHERE `id`  = '{$_GET['view']}'
      LIMIT 1
      ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    }
  }
  if (isset($_GET['set_pad'])) {
    $_GET['set_pad'] = in_array($_GET['set_pad'],array('yes','no')) ? $_GET['set_pad'] : 'no';
    if (is_numeric($_GET['view'])) {
      mysql_query("UPDATE ".DB_PREFIX."users SET
      `notePadEnable`  = '{$_GET['set_pad']}'
      WHERE `id`       = '{$_GET['view']}'
      LIMIT 1
      ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    }
  }
  if (isset($_GET['set_priv'])) {
    $_GET['set_priv'] = in_array($_GET['set_priv'],array('yes','no')) ? $_GET['set_priv'] : 'no';
    if (is_numeric($_GET['view'])) {
      mysql_query("UPDATE ".DB_PREFIX."users SET
      `delPriv`   = '{$_GET['set_priv']}'
      WHERE `id`  = '{$_GET['view']}'
      LIMIT 1
      ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    }
  }
  if (isset($_GET['set_assigned'])) {
    $_GET['set_assigned'] = in_array($_GET['set_assigned'],array('yes','no')) ? $_GET['set_assigned'] : 'no';
    if (is_numeric($_GET['view'])) {
      mysql_query("UPDATE ".DB_PREFIX."users SET
      `assigned`  = '{$_GET['set_assigned']}'
      WHERE `id`  = '{$_GET['view']}'
      LIMIT 1
      ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    }
  }
  if (isset($_GET['set_timezone'])) {
    mysql_query("UPDATE ".DB_PREFIX."users SET
    `timezone`  = '".mswSafeImportString($_GET['set_timezone'])."'
    WHERE `id`  = '{$_GET['view']}'
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
}

function addEntryLog($user) {
  mysql_query("INSERT INTO ".DB_PREFIX."log (
  `ts`,`userID`
  ) VALUES (
  '".mswTimeStamp()."','{$user->id}'
  )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
}

function addUser() {
  if (LICENCE_VER=='locked') {
    if (mswRowCount('users')+1>RESTR_USERS) {
      header("Location: index.php?restr=yes");
      exit;
    }
  }
  if (isset($_POST['assigned']) && $_POST['assigned']=='yes') {
    define('BYPASS_DEPT', 1);
  }
  mysql_query("INSERT INTO ".DB_PREFIX."users (
  `ts`,
  `name`,
  `email`,
  `accpass`,
  `signature`,
  `notify`,
  `pageAccess`,
  `emailSigs`,
  `notePadEnable`,
  `delPriv`,
  `nameFrom`,
  `emailFrom`,
  `assigned`,
  `timezone`
  ) VALUES (
  UNIX_TIMESTAMP(UTC_TIMESTAMP),
  '".mswSafeImportString($_POST['name'])."',
  '{$_POST['email']}',
  '".md5(SECRET_KEY.$_POST['accpass'])."',
  '".mswSafeImportString($_POST['signature'])."',
  '".(isset($_POST['notify']) && in_array($_POST['notify'],array('yes','no')) ? $_POST['notify'] : 'yes')."',
  '".(!empty($_POST['pages']) ? implode('|',$_POST['pages']) : '')."',
  '".(isset($_POST['emailSigs']) && in_array($_POST['emailSigs'],array('yes','no')) ? $_POST['emailSigs'] : 'yes')."',
  '".(isset($_POST['notePadEnable']) && in_array($_POST['notePadEnable'],array('yes','no')) ? $_POST['notePadEnable'] : 'yes')."',
  '".(isset($_POST['delPriv']) && in_array($_POST['delPriv'],array('yes','no')) ? $_POST['delPriv'] : 'yes')."',
  '".mswSafeImportString($_POST['nameFrom'])."',
  '".mswSafeImportString($_POST['emailFrom'])."',
  '".(isset($_POST['assigned']) && in_array($_POST['assigned'],array('yes','no')) ? $_POST['assigned'] : 'no')."',
  '".mswSafeImportString($_POST['timezone'])."'
  )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $id = mysql_insert_id();
  // Add to user departments..
  if (!empty($_POST['dept']) && !defined('BYPASS_DEPT')) {
    foreach ($_POST['dept'] AS $dID) {
      mysql_query("INSERT INTO ".DB_PREFIX."userdepts (
      `userID`,`deptID`
      ) VALUES (
      '$id','$dID'
      )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    }
  } else {
    // If no departments were set, add user to all as default..
    $d = mysql_query("SELECT * FROM ".DB_PREFIX."departments ORDER BY id")
         or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    while ($D = mysql_fetch_object($d)) {
      mysql_query("INSERT INTO ".DB_PREFIX."userdepts (
      `userID`,`deptID`
      ) VALUES (
      '$id','{$D->id}'
      )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    }
  }
}

function updateUser($user) {
  if (isset($_POST['assigned']) && $_POST['assigned']=='yes') {
    define('BYPASS_DEPT', 1);
  }
  $_GET['edit'] = is_numeric($_GET['edit']) ? $_GET['edit'] : '0';
  mysql_query("UPDATE ".DB_PREFIX."users SET
  `name`           = '".mswSafeImportString($_POST['name'])."',
  `email`          = '{$_POST['email']}',
  `accpass`        = '".($_POST['accpass'] ? md5(SECRET_KEY.$_POST['accpass']) : $_POST['curPass'])."',
  `signature`      = '".mswSafeImportString($_POST['signature'])."',
  `notify`         = '".(isset($_POST['notify']) && in_array($_POST['notify'],array('yes','no')) ? $_POST['notify'] : 'yes')."',
  `pageAccess`     = '".(!empty($_POST['pages']) ? implode('|',$_POST['pages']) : '')."',
  `emailSigs`      = '".(isset($_POST['emailSigs']) && in_array($_POST['emailSigs'],array('yes','no')) ? $_POST['emailSigs'] : 'yes')."',
  `notePadEnable`  = '".(isset($_POST['notePadEnable']) && in_array($_POST['notePadEnable'],array('yes','no')) ? $_POST['notePadEnable'] : 'yes')."',
  `delPriv`        = '".(isset($_POST['delPriv']) && in_array($_POST['delPriv'],array('yes','no')) ? $_POST['delPriv'] : 'yes')."',
  `nameFrom`       = '".mswSafeImportString($_POST['nameFrom'])."',
  `emailFrom`      = '".mswSafeImportString($_POST['emailFrom'])."',
  `assigned`       = '".(isset($_POST['assigned']) && in_array($_POST['assigned'],array('yes','no')) ? $_POST['assigned'] : 'no')."',
  `timezone`       = '".mswSafeImportString($_POST['timezone'])."'
  WHERE `id`       = '{$_GET['edit']}'
  LIMIT 1
  ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  // Add to user departments..
  if (!empty($_POST['dept']) && !defined('BYPASS_DEPT')) {
    mysql_query("DELETE FROM ".DB_PREFIX."userdepts
    WHERE `userID` = '{$_GET['edit']}' 
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    if (mswRowCount('userdepts')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."userdepts");
    }
    foreach ($_POST['dept'] AS $dID) {
    mysql_query("INSERT INTO ".DB_PREFIX."userdepts (
      `userID`,`deptID`
      ) VALUES (
      '{$_GET['edit']}','$dID'
      )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    }
  } else {
    // If not global user, add to all departments if none set..
    if ($_GET['edit']>1) {
      mysql_query("DELETE FROM ".DB_PREFIX."userdepts
      WHERE `userID` = '{$_GET['edit']}' 
      ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      // If no departments were set, add user to all as default..
      $d = mysql_query("SELECT * FROM ".DB_PREFIX."departments ORDER BY id")
           or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      while ($D = mysql_fetch_object($d)) {
        mysql_query("INSERT INTO ".DB_PREFIX."userdepts (
        `userID`,`deptID`
        ) VALUES (
        '{$_GET['edit']}','{$D->id}'
        )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      }
    }
  }
  // If password was set and the person logged in has changed their details, change session vars..
  // We`ll update password and e-mail session vars and reset cookies..
  if ($user==$_GET['edit']) {
    $_SESSION[md5(SECRET_KEY).'_ms_mail'] = $_POST['email'];
    if ($_POST['accpass']) {
      $_SESSION[md5(SECRET_KEY).'_ms_key']  = md5(SECRET_KEY.$_POST['accpass']);
    }// Clear cookies..
    if (isset($_COOKIE[md5(SECRET_KEY).'_msc_mail'])) {
      setcookie(md5(SECRET_KEY).'_msc_mail', '');
      setcookie(md5(SECRET_KEY).'_msc_key', '');
      unset($_COOKIE[md5(SECRET_KEY).'_msc_mail'],$_COOKIE[md5(SECRET_KEY).'_msc_key']);
    }
  }
}

function deleteUser() {
  if (is_numeric($_GET['delete'])) {
    mysql_query("DELETE FROM ".DB_PREFIX."users 
    WHERE `id` = '{$_GET['delete']}' 
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    $rows = mysql_affected_rows();
    mysql_query("DELETE FROM ".DB_PREFIX."userdepts
    WHERE `userID` = '{$_GET['delete']}' 
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    mysql_query("DELETE FROM ".DB_PREFIX."log
    WHERE `userID` = '{$_GET['delete']}'
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    if (mswRowCount('users')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."users");
    }
    if (mswRowCount('userdepts')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."userdepts");
    }
    if (mswRowCount('log')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."log");
    }
    return $rows;
  }
}

}

?>