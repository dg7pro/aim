<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: settings.php
  Description: Class File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

class systemSettings {

function exportReportCSV() {
  global $SETTINGS,$msg_reports7,$msg_reports8,$msg_reports9,$msg_reports10,$msg_reports11,$msg_script21;
  $sep   = ',';
  $file  = PATH.'export/'.REPORT_LOG_FILENAME;
  $data  = $msg_reports7.$sep.$msg_reports8.$sep.$msg_reports9.$sep.$msg_reports10.$sep.$msg_reports11.mswDefineNewline();
  $from  = (isset($_GET['from']) && mswDatePickerFormat($_GET['from'])!='0000-00-00' ? $_GET['from'] : mswConvertMySQLDate(date('Y-m-d',strtotime('-6 months',mswTimeStamp()))));
  $to    = (isset($_GET['to']) && mswDatePickerFormat($_GET['to'])!='0000-00-00' ? $_GET['to'] : mswConvertMySQLDate(date('Y-m-d',mswTimeStamp())));
  $view  = (isset($_GET['view']) && in_array($_GET['view'],array('month','day')) ? $_GET['view'] : 'month');
  $dept  = (isset($_GET['dept']) ? $_GET['dept'] : '0');
  // Get data..
  $where = 'WHERE DATE(FROM_UNIXTIME(`ts`)) BETWEEN \''.mswDatePickerFormat($from).'\' AND \''.mswDatePickerFormat($to).'\'';
  if (substr($dept,0,1)=='u') {
    $where .= mswDefineNewline().'AND FIND_IN_SET(\''.substr($dept,1).'\',`assignedto`) > 0';
  } else {
    if ($dept>0) {
      $where .= mswDefineNewline().'AND `department` = \''.$dept.'\'';
    }
  }
  $where .= mswDefineNewline().'AND `assignedto` != \'waiting\'';
  switch ($view) {
    case 'month':
    $qRE = mysql_query("SELECT *,MONTH(FROM_UNIXTIME(`ts`)) AS `m`,YEAR(FROM_UNIXTIME(`ts`)) AS `y` FROM ".DB_PREFIX."tickets 
           $where
           GROUP BY MONTH(FROM_UNIXTIME(`ts`)),YEAR(FROM_UNIXTIME(`ts`))
           ORDER BY 2
           ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    break;
    case 'day':
    $qRE = mysql_query("SELECT *,DATE(FROM_UNIXTIME(`ts`)) AS `d` FROM ".DB_PREFIX."tickets 
           $where
           GROUP BY DATE(FROM_UNIXTIME(`ts`))
           ORDER BY 2
           ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    break;
  }  
  while ($REP = mysql_fetch_object($qRE)) {
    switch ($view) {
      case 'month':
      // Open tickets..
      $C1 = mysql_fetch_object(
             mysql_query("SELECT COUNT(*) AS c FROM ".DB_PREFIX."tickets 
             $where
             AND `ticketStatus`             = 'open'
             AND `isDisputed`               = 'no'
             AND MONTH(FROM_UNIXTIME(`ts`)) = '{$REP->m}'
             AND YEAR(FROM_UNIXTIME(`ts`))  = '{$REP->y}'
             ")
            );
      // Closed tickets..      
      $C2 = mysql_fetch_object(
             mysql_query("SELECT COUNT(*) AS c FROM ".DB_PREFIX."tickets 
             $where
             AND `ticketStatus`             = 'close'
             AND `isDisputed`               = 'no'
             AND MONTH(FROM_UNIXTIME(`ts`)) = '{$REP->m}'
             AND YEAR(FROM_UNIXTIME(`ts`))  = '{$REP->y}'
             ")
            );      
      // Open disputes..
      $C3 = mysql_fetch_object(
             mysql_query("SELECT COUNT(*) AS c FROM ".DB_PREFIX."tickets 
             $where
             AND `ticketStatus`             = 'open'
             AND `isDisputed`               = 'yes'
             AND MONTH(FROM_UNIXTIME(`ts`)) = '{$REP->m}'
             AND YEAR(FROM_UNIXTIME(`ts`))  = '{$REP->y}'
             ")
            );
      // Closed disputes..      
      $C4 = mysql_fetch_object(
             mysql_query("SELECT COUNT(*) AS c FROM ".DB_PREFIX."tickets 
             $where
             AND `ticketStatus`             = 'close'
             AND `isDisputed`               = 'yes'
             AND MONTH(FROM_UNIXTIME(`ts`)) = '{$REP->m}'
             AND YEAR(FROM_UNIXTIME(`ts`))  = '{$REP->y}'
             ")
            ); 
      break;
      case 'day':
      // Open tickets..
      $C1 = mysql_fetch_object(
             mysql_query("SELECT COUNT(*) AS c FROM ".DB_PREFIX."tickets 
             $where
             AND `ticketStatus`             = 'open'
             AND `isDisputed`               = 'no'
             AND DATE(FROM_UNIXTIME(`ts`))  = '{$REP->d}'
             ")
            );
      // Closed tickets..      
      $C2 = mysql_fetch_object(
             mysql_query("SELECT COUNT(*) AS c FROM ".DB_PREFIX."tickets 
             $where
             AND `ticketStatus`             = 'close'
             AND `isDisputed`               = 'no'
             AND DATE(FROM_UNIXTIME(`ts`))  = '{$REP->d}'
             ")
            );      
      // Open disputes..
      $C3 = mysql_fetch_object(
             mysql_query("SELECT COUNT(*) AS c FROM ".DB_PREFIX."tickets 
             $where
             AND `ticketStatus`             = 'open'
             AND `isDisputed`               = 'yes'
             AND DATE(FROM_UNIXTIME(`ts`))  = '{$REP->d}'
             ")
            );
      // Closed disputes..      
      $C4 = mysql_fetch_object(
             mysql_query("SELECT COUNT(*) AS c FROM ".DB_PREFIX."tickets 
             $where
             AND `ticketStatus`             = 'close'
             AND `isDisputed`               = 'yes'
             AND DATE(FROM_UNIXTIME(`ts`))  = '{$REP->d}'
             ")
            ); 
      break;
    }  
    $cnt1  = (isset($C1->c) ? $C1->c : '0');
    $cnt2  = (isset($C2->c) ? $C2->c : '0');
    $cnt3  = (isset($C3->c) ? $C3->c : '0');
    $cnt4  = (isset($C4->c) ? $C4->c : '0');
    $data .= ($view=='day' ? date($SETTINGS->dateformat,strtotime($REP->d)) : $msg_script21[($REP->m-1)].' '.$REP->y).$sep;
    $data .= number_format($cnt1).$sep;
    $data .= number_format($cnt2).$sep;
    $data .= number_format($cnt3).$sep;
    $data .= number_format($cnt4).mswDefineNewline();
  }
  if ($data) {
    // Save file to server and download..
    $fp = fopen($file, 'ab');
    if ($fp) {
      fwrite($fp,trim($data));
      fclose($fp);
    }
    if(@ini_get('zlib.output_compression')) {
      @ini_set('zlib.output_compression', 'Off');
    }
    header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private',false);
    header('Content-Type: '.mswGetMimeType());
    header('Content-Type: application/force-download');
    header('Content-Disposition: attachment; filename='.basename($file).';');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: '.filesize($file));
    @ob_end_flush();
    readfile($file);
    // Remove file after download..
    @unlink($file);
  }
  exit;
}

function enableDisableFields($status) {
  if (!empty($_POST['fid'])) {
    mysql_query("UPDATE ".DB_PREFIX."cusfields SET
    `enField`   = '$status'
    WHERE id IN (".implode(',',$_POST['fid']).")
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
}

function orderFields() {
  for ($i=0; $i<count($_POST['id']); $i++) {
    mysql_query("UPDATE ".DB_PREFIX."cusfields SET
    `orderBy` = '{$_POST['order'][$i]}'
    WHERE id  = '{$_POST['id'][$i]}'
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
}

function addCustomField() {
  if (LICENCE_VER=='locked') {
    if (mswRowCount('cusfields')+1>RESTR_FIELDS) {
      header("Location: index.php?restr=yes");
      exit;
    }
  }
  // Defaults if not set..
  $_POST['fieldType']   = (isset($_POST['fieldType']) && in_array($_POST['fieldType'],array('textarea','input','select','checkbox')) ? $_POST['fieldType'] : 'input');
  $_POST['fieldReq']    = (isset($_POST['fieldReq']) && in_array($_POST['fieldReq'],array('yes','no')) ? $_POST['fieldReq'] : 'no');
  $_POST['repeatPref']  = (isset($_POST['repeatPref']) && in_array($_POST['repeatPref'],array('yes','no')) ? $_POST['repeatPref'] : 'yes');
  $_POST['enField']     = (isset($_POST['enField']) && in_array($_POST['enField'],array('yes','no')) ? $_POST['enField'] : 'yes');
  $dept                 = (empty($_POST['dept']) ? 'all' : implode(',',$_POST['dept']));
  if (empty($_POST['fieldLoc'])) {
    $_POST['fieldLoc'][] = 'ticket';
  }
  mysql_query("INSERT INTO ".DB_PREFIX."cusfields (
  `fieldInstructions`,
  `fieldType`,
  `fieldReq`,
  `fieldOptions`,
  `fieldLoc`,
  `repeatPref`,
  `enField`,
  `departments`
  ) VALUES (
  '".mswSafeImportString($_POST['fieldInstructions'])."',
  '{$_POST['fieldType']}',
  '{$_POST['fieldReq']}',
  '".mswSafeImportString($_POST['fieldOptions'])."',
  '".implode(',',$_POST['fieldLoc'])."',
  '{$_POST['repeatPref']}',
  '{$_POST['enField']}',
  '$dept'
  )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $id = mysql_insert_id();
  // Update order..
  if ($id>0) {
    mysql_query("UPDATE ".DB_PREFIX."cusfields SET
    `orderBy`  = '".mswRowCount('cusfields')."'
    WHERE id   = '$id'
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
}

function editCustomField() {
  // Defaults if not set..
  $_POST['fieldType']   = (isset($_POST['fieldType']) && in_array($_POST['fieldType'],array('textarea','input','select','checkbox')) ? $_POST['fieldType'] : 'input');
  $_POST['fieldReq']    = (isset($_POST['fieldReq']) && in_array($_POST['fieldReq'],array('yes','no')) ? $_POST['fieldReq'] : 'no');
  $_POST['repeatPref']  = (isset($_POST['repeatPref']) && in_array($_POST['repeatPref'],array('yes','no')) ? $_POST['repeatPref'] : 'yes');
  $_POST['enField']     = (isset($_POST['enField']) && in_array($_POST['enField'],array('yes','no')) ? $_POST['enField'] : 'yes');
  $dept                 = (empty($_POST['dept']) ? 'all' : implode(',',$_POST['dept']));
  if (empty($_POST['fieldLoc'])) {
    $_POST['fieldLoc'][] = 'ticket';
  }
  if (is_numeric($_GET['edit'])) {
    mysql_query("UPDATE ".DB_PREFIX."cusfields SET
    `fieldInstructions`  = '".mswSafeImportString($_POST['fieldInstructions'])."',
    `fieldType`          = '{$_POST['fieldType']}',
    `fieldReq`           = '{$_POST['fieldReq']}',
    `fieldOptions`       = '".mswSafeImportString($_POST['fieldOptions'])."',
    `fieldLoc`           = '".implode(',',$_POST['fieldLoc'])."',
    `repeatPref`         = '{$_POST['repeatPref']}',
    `enField`            = '{$_POST['enField']}',
    `departments`        = '$dept'
    WHERE id             = '{$_GET['edit']}'
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
}

function deleteCustomField() {
  if (is_numeric($_GET['delete'])) {
    mysql_query("DELETE FROM ".DB_PREFIX."cusfields WHERE `id` = '{$_GET['delete']}' LIMIT 1") 
    or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    $rows = mysql_affected_rows();
    mysql_query("DELETE FROM ".DB_PREFIX."ticketfields WHERE `fieldID` = '{$_GET['delete']}'") 
    or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    if (mswRowCount('cusfields')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."cusfields");
    }
    if (mswRowCount('ticketfields')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."ticketfields");
    }
    return $rows;
  }
}

function enableDisableImap() {
  if (!empty($_POST['id'])) {
    mysql_query("UPDATE ".DB_PREFIX."imap SET
    `im_piping`  = '".(isset($_POST['enable']) ? 'yes' : 'no')."'
    WHERE id    IN (".implode(',',$_POST['id']).")
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
}

function addImapAccount() {
  if (LICENCE_VER=='locked') {
    if (mswRowCount('imap')+1>RESTR_IMAP) {
      header("Location: index.php?restr=yes");
      exit;
    }
  }
  $_POST                    = mswMultiDimensionalArrayMap('mswSafeImportString',$_POST);
  // Defaults if not set..
  $_POST['im_piping']       = (isset($_POST['im_piping']) && in_array($_POST['im_piping'],array('yes','no')) ? $_POST['im_piping'] : 'no');
  $_POST['im_protocol']     = (isset($_POST['im_protocol']) && in_array($_POST['im_protocol'],array('imap','pop3')) ? $_POST['im_protocol'] : 'pop3');
  $_POST['im_flags']        = systemSettings::filterImapFlag($_POST['im_flags']);
  $_POST['im_attach']       = (isset($_POST['im_attach']) && in_array($_POST['im_attach'],array('yes','no')) ? $_POST['im_attach'] : 'no');
  $_POST['im_ssl']          = (isset($_POST['im_ssl']) && in_array($_POST['im_ssl'],array('yes','no')) ? $_POST['im_ssl'] : 'no');
  $_POST['im_port']         = (is_numeric($_POST['im_port']) && $_POST['im_port']>=0 ? (int)$_POST['im_port'] : '110');
  $_POST['im_messages']     = (is_numeric($_POST['im_messages']) && $_POST['im_messages']>=0 ? (int)$_POST['im_messages'] : '20');
  $_POST['im_move']         = (isset($_POST['im_move']) ? $_POST['im_move'] : '');
  $_POST['im_flags']        = (isset($_POST['im_flags']) ? $_POST['im_flags'] : '');
  mysql_query("INSERT INTO ".DB_PREFIX."imap (
  `im_piping`,
  `im_protocol`,
  `im_host`,
  `im_user`,
  `im_pass`,
  `im_port`,
  `im_name`,
  `im_flags`,
  `im_attach`,
  `im_move`,
  `im_messages`,
  `im_ssl`,
  `im_priority`,
  `im_dept`,
  `im_email`
  ) VALUES (
  '{$_POST['im_piping']}',
  '{$_POST['im_protocol']}',
  '{$_POST['im_host']}',
  '{$_POST['im_user']}',
  '{$_POST['im_pass']}',
  '{$_POST['im_port']}',
  '{$_POST['im_name']}',
  '{$_POST['im_flags']}',
  '{$_POST['im_attach']}',
  '{$_POST['im_move']}',
  '{$_POST['im_messages']}',
  '{$_POST['im_ssl']}',
  '{$_POST['im_priority']}',
  '{$_POST['im_dept']}',
  '{$_POST['im_email']}'
  )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
}

function editImapAccount() {
  $_POST                    = mswMultiDimensionalArrayMap('mswSafeImportString',$_POST);
  // Defaults if not set..
  $_POST['im_piping']       = (isset($_POST['im_piping']) && in_array($_POST['im_piping'],array('yes','no')) ? $_POST['im_piping'] : 'no');
  $_POST['im_protocol']     = (isset($_POST['im_protocol']) && in_array($_POST['im_protocol'],array('imap','pop3')) ? $_POST['im_protocol'] : 'pop3');
  $_POST['im_flags']        = systemSettings::filterImapFlag($_POST['im_flags']);
  $_POST['im_attach']       = (isset($_POST['im_attach']) && in_array($_POST['im_attach'],array('yes','no')) ? $_POST['im_attach'] : 'no');
  $_POST['im_ssl']          = (isset($_POST['im_ssl']) && in_array($_POST['im_ssl'],array('yes','no')) ? $_POST['im_ssl'] : 'no');
  $_POST['im_port']         = (is_numeric($_POST['im_port']) && $_POST['im_port']>=0 ? (int)$_POST['im_port'] : '110');
  $_POST['im_messages']     = (is_numeric($_POST['im_messages']) && $_POST['im_messages']>=0 ? (int)$_POST['im_messages'] : '20');
  $_POST['im_move']         = (isset($_POST['im_move']) ? $_POST['im_move'] : '');
  $_POST['im_flags']        = (isset($_POST['im_flags']) ? $_POST['im_flags'] : '');
  if (is_numeric($_GET['edit'])) {
    mysql_query("UPDATE ".DB_PREFIX."imap SET
    `im_piping`      = '{$_POST['im_piping']}',
    `im_protocol`    = '{$_POST['im_protocol']}',
    `im_host`        = '{$_POST['im_host']}',
    `im_user`        = '{$_POST['im_user']}',
    `im_pass`        = '{$_POST['im_pass']}',
    `im_port`        = '{$_POST['im_port']}',
    `im_name`        = '{$_POST['im_name']}',
    `im_flags`       = '{$_POST['im_flags']}',
    `im_attach`      = '{$_POST['im_attach']}',
    `im_move`        = '{$_POST['im_move']}',
    `im_messages`    = '{$_POST['im_messages']}',
    `im_ssl`         = '{$_POST['im_ssl']}',
    `im_priority`    = '{$_POST['im_priority']}',
    `im_dept`        = '{$_POST['im_dept']}',
    `im_email`       = '{$_POST['im_email']}'
    WHERE id         = '{$_GET['edit']}'
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
}

function deleteImapAccount() {
  if (is_numeric($_GET['delete'])) {
    mysql_query("DELETE FROM ".DB_PREFIX."imap WHERE id = '{$_GET['delete']}' LIMIT 1") 
    or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    $rows = mysql_affected_rows();
    if (mswRowCount('imap')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."imap");
    }
    return $rows;
  }
}

function exportLogFile() {
  global $SETTINGS;
  $file  = PATH.'export/'.ENTRY_LOG_FILENAME;
  $data  = '';
  $sepr  = ',';
  if (!is_writeable(PATH.'export')) {
    die('<b>export</b> directory must be writeable for this operation. Check and try again..');
  }
  $q_log = mysql_query("SELECT *,".DB_PREFIX."log.ts AS `lts` FROM ".DB_PREFIX."log
           LEFT JOIN ".DB_PREFIX."users
           ON ".DB_PREFIX."log.userID = ".DB_PREFIX."users.id 
           ".(isset($_GET['user']) ? 'WHERE `userID` = \''.(int)$_GET['user'].'\'' : '')."
           ORDER BY ".DB_PREFIX."log.id DESC
           ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  while ($LOG = mysql_fetch_object($q_log)) {
    $data .= mswCleanCSV($LOG->name,$sepr).','.mswCleanCSV(mswDateDisplay($LOG->lts,$SETTINGS->dateformat),$sepr).','.mswCleanCSV(mswTimeDisplay($LOG->lts,$SETTINGS->timeformat),$sepr).mswDefineNewline();
  }
  // Save file to server and download..
  $fp = fopen($file, 'ab');
  if ($fp) {
    fwrite($fp,trim($data));
    fclose($fp);
  }
  if(@ini_get('zlib.output_compression')) {
    @ini_set('zlib.output_compression', 'Off');
  }
  header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
  header('Pragma: public');
  header('Expires: 0');
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  header('Cache-Control: private',false);
  header('Content-Type: '.mswGetMimeType());
  header('Content-Type: application/force-download');
  header('Content-Disposition: attachment; filename='.basename($file).';');
  header('Content-Transfer-Encoding: binary');
  header('Content-Length: '.filesize($file));
  @ob_end_flush();
  readfile($file);
  // Remove file after download..
  @unlink($file);
  exit;
}

function clearLogFile() {
  if (!isset($_GET['user'])) {
    mysql_query("TRUNCATE TABLE ".DB_PREFIX."log") 
    or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    $rows = mysql_affected_rows();
    if (mswRowCount('log')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."log");
    }
    return $rows;
  } else {
    mysql_query("DELETE FROM ".DB_PREFIX."log
    WHERE userID = '".(int)$_GET['user']."'
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    return mysql_affected_rows();
  }
}

function updateSettings() {
  $_POST                    = mswMultiDimensionalArrayMap('mswSafeImportString',$_POST);
  // Defaults if not set..
  $_POST['attachment']      = (isset($_POST['attachment']) && in_array($_POST['attachment'],array('yes','no')) ? $_POST['attachment'] : 'no');
  $_POST['rename']          = (isset($_POST['rename']) && in_array($_POST['rename'],array('yes','no')) ? $_POST['rename'] : 'no');
  $_POST['weekStart']       = (isset($_POST['weekStart']) && in_array($_POST['weekStart'],array('sun','mon')) ? $_POST['weekStart'] : 'sun');
  $_POST['enSpamSum']       = (isset($_POST['enSpamSum']) && in_array($_POST['enSpamSum'],array('yes','no')) ? $_POST['enSpamSum'] : 'yes');
  $_POST['enableBBCode']    = (isset($_POST['enableBBCode']) && in_array($_POST['enableBBCode'],array('yes','no')) ? $_POST['enableBBCode'] : 'no');
  $_POST['multiplevotes']   = (isset($_POST['multiplevotes']) && in_array($_POST['multiplevotes'],array('yes','no')) ? $_POST['multiplevotes'] : 'no');
  $_POST['enableVotes']     = (isset($_POST['enableVotes']) && in_array($_POST['enableVotes'],array('yes','no')) ? $_POST['enableVotes'] : 'yes');
  $_POST['enCapLogin']      = (isset($_POST['enCapLogin']) && in_array($_POST['enCapLogin'],array('yes','no')) ? $_POST['enCapLogin'] : 'yes');
  $_POST['sysstatus']       = (isset($_POST['sysstatus']) && in_array($_POST['sysstatus'],array('yes','no')) ? $_POST['sysstatus'] : 'yes');
  $_POST['autoenable']      = ($_POST['autoenable'] ? mswDatePickerFormat($_POST['autoenable']) : '0000-00-00');
  $_POST['maxsize']         = (is_numeric($_POST['maxsize']) && $_POST['maxsize']>=0 ? $_POST['maxsize'] : '0');
  $_POST['kbase']           = (isset($_POST['kbase']) && in_array($_POST['kbase'],array('yes','no')) ? $_POST['kbase'] : 'no');
  $_POST['smtp']            = (isset($_POST['smtp']) && in_array($_POST['smtp'],array('yes','no')) ? $_POST['smtp'] : 'no');
  $_POST['scriptpath']      = systemSettings::filterInstallationPath($_POST['scriptpath']);
  $_POST['attachpath']      = systemSettings::filterInstallationPath($_POST['attachpath']);
  $_POST['portalpages']     = ($_POST['portalpages']>0 ? $_POST['portalpages'] : 10);
  // Enforce digits..
  $_POST['popquestions']    = (is_numeric($_POST['popquestions']) && $_POST['popquestions']>=0 ? $_POST['popquestions'] : '10');
  $_POST['quePerPage']      = (is_numeric($_POST['quePerPage']) && $_POST['quePerPage']>=0 ? $_POST['quePerPage'] : '10');
  $_POST['cookiedays']      = (is_numeric($_POST['cookiedays']) && $_POST['cookiedays']>=0 ? $_POST['cookiedays'] : '60');
  $_POST['attachboxes']     = (is_numeric($_POST['attachboxes']) && $_POST['attachboxes']>=0 ? $_POST['attachboxes'] : '1');
  $_POST['portalpages']     = (is_numeric($_POST['portalpages']) && $_POST['portalpages']>=0 ? $_POST['portalpages'] : '20');
  $_POST['autoClose']       = (is_numeric($_POST['autoClose']) && $_POST['autoClose']>=0 ? $_POST['autoClose'] : '0');
  $_POST['smtp_port']       = (is_numeric($_POST['smtp_port']) && $_POST['smtp_port']>=0 ? $_POST['smtp_port'] : '25');
  // Restrictions..
  if (LICENCE_VER=='locked') {
    $_POST['attachboxes']   = RESTR_ATTACH;
    $_POST['adminFooter']   = 'To add your own footer code, click <Settings> from the above menu';
    $_POST['publicFooter']  = 'To add your own footer code, log in to your admin area and click <Settings>';
  }
  mysql_query("UPDATE ".DB_PREFIX."settings SET
  `website`              = '{$_POST['website']}',
  `email`                = '{$_POST['email']}',
  `scriptpath`           = '{$_POST['scriptpath']}',
  `attachpath`           = '{$_POST['attachpath']}',
  `language`             = '{$_POST['language']}',
  `dateformat`           = '{$_POST['dateformat']}',
  `timeformat`           = '{$_POST['timeformat']}',
  `timezone`             = '{$_POST['timezone']}',
  `weekStart`            = '{$_POST['weekStart']}',
  `jsDateFormat`         = '{$_POST['jsDateFormat']}',
  `kbase`                = '{$_POST['kbase']}',
  `enableVotes`          = '{$_POST['enableVotes']}',
  `multiplevotes`        = '{$_POST['multiplevotes']}',
  `popquestions`         = '{$_POST['popquestions']}',
  `quePerPage`           = '{$_POST['quePerPage']}',
  `cookiedays`           = '{$_POST['cookiedays']}',
  `attachment`           = '{$_POST['attachment']}',
  `rename`               = '{$_POST['rename']}',
  `attachboxes`          = '{$_POST['attachboxes']}',
  `filetypes`            = '{$_POST['filetypes']}',
  `maxsize`              = '{$_POST['maxsize']}',
  `enableBBCode`         = '{$_POST['enableBBCode']}',
  `afolder`              = '{$_POST['afolder']}',
  `portalpages`          = '{$_POST['portalpages']}',
  `autoClose`            = '{$_POST['autoClose']}',
  `smtp`                 = '{$_POST['smtp']}',
  `smtp_host`            = '{$_POST['smtp_host']}',
  `smtp_user`            = '{$_POST['smtp_user']}',
  `smtp_pass`            = '{$_POST['smtp_pass']}',
  `smtp_port`            = '{$_POST['smtp_port']}',
  `adminFooter`          = '{$_POST['adminFooter']}',
  `publicFooter`         = '{$_POST['publicFooter']}',
  `apiKey`               = '{$_POST['apiKey']}',
  `recaptchaPrivateKey`  = '{$_POST['recaptchaPrivateKey']}',
  `recaptchaPublicKey`   = '{$_POST['recaptchaPublicKey']}',
  `enCapLogin`           = '{$_POST['enCapLogin']}',
  `sysstatus`            = '{$_POST['sysstatus']}',
  `autoenable`           = '{$_POST['autoenable']}'
  WHERE id               = '1'
  LIMIT 1
  ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
}

function filterInstallationPath($path) {
  if (substr($path,-1)=='/') {
    $path = substr_replace($path,'',-1);
  }
  return $path;
}

function filterImapFlag($path) {
  if (substr($path,0,1)!='/') {
    $path = '/'.$path;
  }
  if (substr($path,-1)=='\\') {
    $path = substr_replace($path,'',-2);
  }
  return $path;
}

}

?>