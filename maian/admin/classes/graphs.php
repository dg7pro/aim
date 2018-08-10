<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: graphs.php
  Description: Class File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

class graphs {

var $settings;

function homepageGraphData() {
  global $msg_script29,$msg_script28,$msg_script21;
  $ticks  = '';
  $line1  = '';
  $line2  = '';
  $range  = (isset($_GET['range']) && in_array($_GET['range'],array('today','week','month','year')) ? $_GET['range'] : ADMIN_HOME_DEFAULT_SALES_VIEW);
  switch ($range) {
    // Today..
    case 'today':
    $t   = array();
    $l1  = array();
    $l2  = array();
    $ts  = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');
    $dt  = graphs::today();
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
    $dt = graphs::week($from,date("Y-m-d",strtotime("+6 days",strtotime($from))));
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
      $dt = graphs::month();
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
      $dt = graphs::year();
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
  global $ticketFilterAccess;
  $today = array();
  $q     = mysql_query("SELECT HOUR(`addTime`) AS h,count(*) as c,isDisputed FROM ".DB_PREFIX."tickets 
           WHERE DATE(FROM_UNIXTIME(`ts`)) = '".mswSQLDate()."'
           ".mswSQLDepartmentFilter($ticketFilterAccess)."
           GROUP BY HOUR(`addTime`),`isDisputed`
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
  global $ticketFilterAccess;
  $week  = array();
  $q     = mysql_query("SELECT DAY(FROM_UNIXTIME(`ts`)) AS d,count(*) as c,isDisputed FROM ".DB_PREFIX."tickets 
           WHERE DATE(FROM_UNIXTIME(`ts`)) BETWEEN '$from' AND '$to'  
           ".mswSQLDepartmentFilter($ticketFilterAccess)."
           GROUP BY DAY(FROM_UNIXTIME(`ts`)),`isDisputed`
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
  global $ticketFilterAccess;
  $month  = array();
  $q      = mysql_query("SELECT DAY(FROM_UNIXTIME(`ts`)) AS d,count(*) as c,isDisputed FROM ".DB_PREFIX."tickets 
            WHERE MONTH(FROM_UNIXTIME(`ts`)) = '".date("m",mswTimeStamp())."' 
            ".mswSQLDepartmentFilter($ticketFilterAccess)."
            GROUP BY DAY(FROM_UNIXTIME(`ts`)),`isDisputed`
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
  global $ticketFilterAccess;
  $year  = array();
  $q     = mysql_query("SELECT MONTH(FROM_UNIXTIME(`ts`)) AS m,count(*) as c,isDisputed FROM ".DB_PREFIX."tickets 
           WHERE YEAR(FROM_UNIXTIME(`ts`)) = '".date("Y",mswTimeStamp())."'
           ".mswSQLDepartmentFilter($ticketFilterAccess)."
           GROUP BY MONTH(FROM_UNIXTIME(`ts`)),`isDisputed`
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

}

?>