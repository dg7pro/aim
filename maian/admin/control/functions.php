<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: functions.php
  Description: Functions

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

function mswSQLDepartmentFilter($code,$query='AND') {
  return ($code ? $query.' '.$code : '');
}

function mswDeptFilterAccess($MSTEAM,$userDeptAccess,$table) {
  $f = '';
  if ($MSTEAM->id!='1') {
    switch ($MSTEAM->assigned) {
      // Can view assigned tickets ONLY..
      case 'yes':
      switch ($table) {
        case 'department':
        $f  = '`id` > 0 AND `manual_assign` = \'yes\'';
        break;
        case 'tickets':
        $f  = 'FIND_IN_SET(\''.$MSTEAM->id.'\',`assignedto`) > 0';
        break;
      }
      break;
      // Can view tickets by department..
      case 'no':
      switch ($table) {
        case 'department':
        if (!empty($userDeptAccess)) {
          $f  = '`id` IN ('.implode(',',$userDeptAccess).')';
        } else {
          $f  = '`id` = \'0\'';
        }
        break;
        case 'tickets':
        if (!empty($userDeptAccess)) {
          $f  = '(`department` IN ('.implode(',',$userDeptAccess).') OR FIND_IN_SET(\''.$MSTEAM->id.'\',`assignedto`) > 0)';
        } else {
          $f  = '`department` = \'0\'';
        }
        break;
      }
      break;
    }  
  }
  return $f;    
}

function mswCallBackUrls($cmd) {
  if (isset($_GET['auto'])) {
    $cmd = 'portal';
  }
  if (isset($_GET['downloadAttachment'])) {
    $cmd = 'view-ticket';
  }
  if (isset($_GET['response'])) {
    $cmd = 'view-ticket';
  }
  if (substr($cmd,0,6)=='stats-') {
    $statsData  = $cmd;
    $cmd        = 'stats';
  }
  return $cmd;
}

// Help tip..
function mswUsersInDispute($ticket,$count,$align='CENTER') {
  global $msg_javascript129,$msg_javascript142,$msg_javascript143;
  // Tip positioning...
  switch (strtoupper($align)) {
    case 'RIGHT':
    $xy = 'ol_offsety = 5, ol_offsetx = 10,ol_vpos = ABOVE';
    break;
    case 'LEFT':
    $xy = 'ol_offsety = 10, ol_offsetx = 10,ol_vpos = ABOVE';
    break;
    default:
    $xy = 'ol_offsety = 10, ol_offsetx = 10,ol_vpos = ABOVE';
    break;
  }
  $text = '<p>'.$ticket->name.'<span class="email">('.$ticket->email.')</span><span class="in">'.$msg_javascript142.'</span></p>';
  $q = mysql_query("SELECT * FROM ".DB_PREFIX."disputes WHERE `ticketID` = '{$ticket->id}' ORDER BY postPrivileges,userName")
       or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  if (mysql_num_rows($q)>0) {
  while ($D_USER = mysql_fetch_object($q)) {
    $text .= '<p>'.$D_USER->userName.'<span class="email">('.$D_USER->userEmail.')</span></p>';
  }
  } else {
    $text .= '<p class="none">'.$msg_javascript143.'</p>';
  }
  $html = '<div class="toolTip"><div class="users">'.$text.'</div></div>';
  return '<a href="javascript:void(0);" onmouseover="return overlib(\''.htmlspecialchars($html).'\',\''.htmlspecialchars($msg_javascript129).'\', '.$align.', '.$xy.');" onmouseout="nd();">'.($count+1).'</a>';
}

// Check for new version..
function mswSoftwareVersionCheck() {
  global $SETTINGS;
  $url = 'http://www.maianscriptworld.co.uk/version-check.php?id='.SCRIPT_ID;
  if (function_exists('curl_init')) {
    $ch = @curl_init();
    @curl_setopt($ch,CURLOPT_URL,$url);
    @curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    $result = @curl_exec($ch);
    @curl_close ($ch);
    if ($result) {
      if ($result!=$SETTINGS->softwareVersion) {
        echo 'Installed Version: '.$SETTINGS->softwareVersion.mswDefineNewline();
        echo 'Current Version: '.$result.mswDefineNewline().mswDefineNewline();
        echo 'Your version is out of date.'.mswDefineNewline().mswDefineNewline();
        echo 'Download new version at:'.mswDefineNewline();
        echo 'www.'.SCRIPT_URL;
        exit;
      } else {
        echo 'Current Version: '.$SETTINGS->softwareVersion.mswDefineNewline().mswDefineNewline().'You are currently using the latest version';
        exit;
      }
      exit;
    }
  } else {
    if (@ini_get('allow_url_fopen') == '1') {
      $result = @file_get_contents($url);
      if ($result) {
        if ($result!=$SETTINGS->softwareVersion) {
          echo 'Installed Version: '.$SETTINGS->softwareVersion.mswDefineNewline();
          echo 'Current Version: '.$result.mswDefineNewline().mswDefineNewline();
          echo 'Your version is out of date.'.mswDefineNewline().mswDefineNewline();
          echo 'Download new version at:'.mswDefineNewline();
          echo 'www.'.SCRIPT_URL;
          exit;
        } else {
          echo 'Current Version: '.$SETTINGS->softwareVersion.mswDefineNewline().mswDefineNewline().'You are currently using the latest version';
          exit;
        }
        exit;
      }
    }
  }
  echo 'Server check functions not available.'.mswDefineNewline().mswDefineNewline();
  echo 'Please visit '.SCRIPT_URL.' to check for updates';
  exit;
}

// Field information..
function mswFieldInformation($field) {
  global $msg_customfields30,$msg_customfields5,$msg_customfields6,$msg_customfields7,$msg_customfields32,
         $msg_customfields8,$msg_script4,$msg_script5,$msg_customfields18,$msg_customfields19,$msg_customfields20;
  $type = '';
  $req  = ($field->fieldReq=='yes' ? $msg_script4 : $msg_script5);
  $loc  = '';
  switch($field->fieldType) {
    case 'textarea': $type = $msg_customfields5; break;
    case 'input':    $type = $msg_customfields6; break;
    case 'select':   $type = $msg_customfields7; break;
    case 'checkbox': $type = $msg_customfields8; break;
  }
  if (strpos($field->fieldLoc,'ticket')!==false) {
    $loc = $msg_customfields18;
  }
  if (strpos($field->fieldLoc,'reply')!==false) {
    $loc .= ($loc ? ', ' : '').$msg_customfields19;
  }
  if (strpos($field->fieldLoc,'admin')!==false) {
    $loc .= ($loc ? ', ' : '').$msg_customfields20;
  }
  return str_replace(array('{type}','{req}','{loc}','{dept}'),array($type,$req,$loc,($field->departments=='all' ? $msg_customfields32 : count(explode(',',$field->departments)))),$msg_customfields30);
}

// Get attachments..
function mswGetAttachments($id) {
  global $SETTINGS;
  $attachString = '';
  $query = mysql_query("SELECT * FROM ".DB_PREFIX."attachments
           WHERE `ticketID`  = '$id' 
           AND `replyID`     = '0'
           ORDER BY `fileName`
           ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  while ($A = mysql_fetch_object($query)) {        
    $split         = explode('-',$A->addDate);
    $folder        = ''; 
    if (file_exists($SETTINGS->attachpath.'/'.$split[0].'/'.$split[1].'/'.$A->fileName)) {
      $folder  = $split[0].'/'.$split[1].'/';
    }
    $attachString .= $SETTINGS->scriptpath.'/templates/attachments/'.$folder.$A->fileName.' ('.mswFileSizeConversion($A->fileSize).')'.mswDefineNewline();
  }
  return trim($attachString);
}

// Entry log restriction array..
function mswEntryLogRestrictionIDs() {
  $ids = array();
  if (ENTRY_LOG_RESTRICTION) {
    if (strpos(ENTRY_LOG_RESTRICTION,',')!==FALSE) {
      $ids = explode(',',ENTRY_LOG_RESTRICTION);
    } else {
      $ids[] = ENTRY_LOG_RESTRICTION;
    }
  }
  return array_map('trim',$ids);
}

// Clear settings footers..
function mswClearSettingsFooters() {
  mysql_query("UPDATE ".DB_PREFIX."settings SET
  `adminFooter`   = '',
  `publicFooter`  = ''
  ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
}

// Log in checker..
function mswIsLoggedIn($stats=false) {
  global $MSTEAM,$userAccess,$userDeptAccess;
  if (!isset($userDeptAccess) || !isset($userAccess)) {
    header("Location: index.php?p=login");
    exit;
  }
  if ((isset($_SESSION[md5(SECRET_KEY).'_ms_mail']) && 
     isset($_SESSION[md5(SECRET_KEY).'_ms_key']) && 
     mswIsValidEmail($_SESSION[md5(SECRET_KEY).'_ms_mail'])
    ) || (
     isset($_COOKIE[md5(SECRET_KEY).'_msc_mail']) && 
     isset($_COOKIE[md5(SECRET_KEY).'_msc_key']) && 
     mswIsValidEmail($_COOKIE[md5(SECRET_KEY).'_msc_mail'])
    )
   ) {
    if (!isset($MSTEAM->name)) {
      if ($stats) {
        exit;
      } else {
        header("Location: index.php?p=login");
      }
      exit;
    }
  } else {
    header("Location: index.php?p=login");
    exit;
  }
}

// Build calculator..
function mswBuildCalculator($field='') {
  global $msg_javascript69;
  $num = '';
  foreach (range(0,9) AS $cal) {
   $num .= '<span class="calNum" onclick="gCalculator.OnClick(\''.$cal.'\')">'.$cal.'</span>';
  }
  foreach (array('c','+','-','x') AS $key) {
   if ($key=='c') {
     $num .= '<span class="calSymbols" onclick="document.getElementById(\''.$field.'\').value=\'\'">'.$key.'</span>';
   } else {
     $num .= '<span class="calSymbols" onclick="if (document.getElementById(\''.$field.'\').value!=\'\') { gCalculator.OnClick(\''.$key.'\'); } else { alert(\''.$msg_javascript69.'\'); }">'.$key.'</span>';
   }
  }
  return '<div id="calendar" style="display:none">'.$num.'<span class="action" onclick="if (document.getElementById(\''.$field.'\').value!=\'\') { gCalculator.OnClick(\'=\');toggle_box(\'calendar\');return false } else { alert(\''.$msg_javascript69.'\'); }">=</span><br class="clear" /></div>';
}

// Cleans CSV..adds quotes if data contains delimiter..
function mswCleanCSV($data,$del) {
  if (strpos($data,$del)!==FALSE) {
    return '"'.mswCleanData($data).'"';
  } else {
    return mswCleanData($data);
  }
}

// Get page access for user..
function mswGetUserPageAccess($id) {
  $query = mysql_query("SELECT * FROM ".DB_PREFIX."users WHERE `id` = '$id'") 
           or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $row = mysql_fetch_object($query);
  return explode('|',$row->pageAccess);
}

// Get department access for user..
function mswGetDepartmentAccess($id) {
  global $MSTEAM;
  $dept = array();
  $query = mysql_query("SELECT * FROM ".DB_PREFIX."userdepts WHERE `userID` = '$id'") 
           or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  while ($row = mysql_fetch_object($query)) {
    $dept[] = $row->deptID;
  }
  // Are there any tickets assigned to this user NOT in the department array..?
  // If there are, add department to allowed array..
  $q = mysql_query("SELECT * FROM ".DB_PREFIX."tickets 
       WHERE `department` NOT IN (".implode(',',(!empty($dept) ? $dept : array('0'))).") 
       AND FIND_IN_SET('".$MSTEAM->id."',`assignedto`) > 0 
       GROUP BY `department`
       ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  while ($DP = mysql_fetch_object($q)) {
    $dept[] = $DP->department;
  }
  if (!empty($dept)) {
    sort($dept);
  }
  return $dept;
}

// Standard response department..
function mswSrCat($id) {
  global $msg_response6;
  $D = mswGetTableData('departments','id',$id);
  return (isset($D->name) ? $D->name : $msg_response6);
}

// FAQ Cat..
function mswFaqCat($id) {
  global $msg_kbase6;
  $C = mswGetTableData('categories','id',$id);
  return (isset($C->name) ? $C->name : $msg_kbase6);
}

// Pages..
function mswGetAdminPages($keys=false) {
  global $msg_adheader2,$msg_adheader3,$msg_adheader4,$msg_adheader5,$msg_adheader6,$msg_adheader7,
         $msg_adheader8,$msg_adheader13,$msg_adheader16,$msg_adheader18,$msg_adheader19,$msg_adheader20,
         $msg_adheader21,$msg_adheader24,$msg_adheader26,$msg_adheader28,$msg_adheader29,$msg_adheader30,
         $msg_adheader32,$msg_adheader33,$msg_adheader34,$msg_adheader35;
  $pages = array(
  'settings'            => $msg_adheader2,
  'imap'                => $msg_adheader24,
  'fields'              => $msg_adheader26,
  'levels'              => $msg_adheader35,
  'dept'                => $msg_adheader3,
  'users'               => $msg_adheader4,
  'assign'              => $msg_adheader32,
  'open'                => $msg_adheader5,
  'close'               => $msg_adheader6,
  'disputes'            => $msg_adheader28,
  'cdisputes'           => $msg_adheader29,
  'search'              => $msg_adheader7,
  'standard-responses'  => $msg_adheader13,
  'faq-cat'             => $msg_adheader16,
  'faq'                 => $msg_adheader8,
  'attachments'         => $msg_adheader33,
  'tools'               => $msg_adheader18,
  'import'              => $msg_adheader19,
  'portal'              => $msg_adheader21,
  'reports'             => $msg_adheader34,
  'log'                 => $msg_adheader20,
  'backup'              => $msg_adheader30
  );
  $k = array_keys($pages);
  return ($keys ? $k : $pages);
}

// Display box if action is done..
function mswActionCompleted($text) {
  global $msg_script15;
  return '
  <div id="actionComplete">
    <p>'.$text.' (<a href="#" onclick="jQuery(\'#actionComplete\').hide(\'slow\');return false" title="'.mswSpecialChars($msg_script15).'">'.$msg_script15.'</a>)</p>
  </div>
  ';
}

// Pass reset..
function mswActionCompletedReset($text) {
  global $msg_script15;
  return '
  <div id="actionCompleteReset">
    <p>'.$text.' (<a href="#" onclick="jQuery(\'#actionCompleteReset\').hide(\'slow\');return false" title="'.mswSpecialChars($msg_script15).'">'.$msg_script15.'</a>)</p>
  </div>
  ';
}

// Display box if action is done..for reload..
function mswActionCompletedReload($text,$url) {
  global $msg_script23;
  return '
  <div id="actionComplete">
    <p>'.$text.' (<a href="#" onclick="window.top.location.href=\'?'.$url.'\'" title="'.mswSpecialChars($msg_script23).'">'.$msg_script23.'</a>)</p>
  </div>
  ';
}

?>