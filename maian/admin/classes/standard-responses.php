<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: standard-responses.php
  Description: Class File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

class standardResponses {

var $settings;

function enableDisableResponses($status) {
  if (!empty($_POST['id'])) {
    mysql_query("UPDATE ".DB_PREFIX."responses SET
    `ts`         = UNIX_TIMESTAMP(UTC_TIMESTAMP),
    `enResponse` = '$status'
    WHERE id IN (".implode(',',$_POST['id']).")
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
}

function batchImportSR($lines,$del,$enc) {
  $count = 0;
  if (!is_writeable(PATH.'export')) {
    die('<b>export</b> directory must be writeable for this operation. Check and try again..');
  }
  // Clear current responses..
  if (isset($_POST['clear']) && $_POST['clear']=='yes') {
    mysql_query("DELETE FROM ".DB_PREFIX."responses 
    WHERE `department` = '{$_POST['dept']}'
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    if (mswRowCount('responses')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."responses");
    }
  }
  // Upload CSV file..
  if (is_uploaded_file($_FILES['file']['tmp_name'])) {
    $ext = strrchr(strtolower($_FILES['file']['name']), '.');
    $fl  = 'import-'.date('Ymdhis').$ext;
    move_uploaded_file($_FILES['file']['tmp_name'],PATH.'export/'.$fl);
    // If uploaded file exists, read CSV data...
    if (file_exists(PATH.'export/'.$fl)) {
      $handle = fopen(PATH.'export/'.$fl, "r");
      while (($CSV = fgetcsv($handle,$lines,$del,$enc))!== FALSE) {
        if (LICENCE_VER=='locked') {
          if (mswRowCount('responses')+1>RESTR_RESPONSES) {
            // Clear temp file..
            if (file_exists($_FILES['file']['tmp_name'])) {
              @unlink($_FILES['file']['tmp_name']);
            }
            fclose($handle);
            // Clear upload..
            @unlink(PATH.'export/'.$fl);
            header("Location: index.php?restr=yes");
            exit;
          }
        }
        // Clean array..
        $CSV  = array_map('trim',$CSV);
        mysql_query("INSERT INTO ".DB_PREFIX."responses (
        `ts`,
        `title`,
        `answer`,
        `department`
        ) VALUES (
        UNIX_TIMESTAMP(UTC_TIMESTAMP),
        '".mswSafeImportString($CSV[0])."',
        '".mswSafeImportString($CSV[1])."',
        '{$_POST['dept']}'
        )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
        ++$count;
      }
      fclose($handle);
      // Clear upload..
      @unlink(PATH.'export/'.$fl);
    }
    // Clear temp file..
    if (file_exists($_FILES['file']['tmp_name'])) {
      @unlink($_FILES['file']['tmp_name']);
    }
  }
  return $count;
}

function addResponse() {
  if (LICENCE_VER=='locked') {
    if (mswRowCount('responses')+1>RESTR_RESPONSES) {
      header("Location: index.php?restr=yes");
      exit;
    }
  }
  $_POST['dept'] = (is_numeric($_POST['dept']) ? $_POST['dept'] : '0');
  mysql_query("INSERT INTO ".DB_PREFIX."responses (
  `ts`,
  `title`,
  `answer`,
  `department`,
  `enResponse`
  ) VALUES (
  UNIX_TIMESTAMP(UTC_TIMESTAMP),
  '".mswSafeImportString($_POST['title'])."',
  '".mswSafeImportString($_POST['answer'])."',
  '{$_POST['dept']}',
  '".(isset($_POST['enResponse']) && in_array($_POST['enResponse'],array('yes','no')) ? $_POST['enResponse'] : 'yes')."'
  )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
}

function updateResponse() {
  if (is_numeric($_GET['edit'])) {
    mysql_query("UPDATE ".DB_PREFIX."responses SET
    `ts`          = UNIX_TIMESTAMP(UTC_TIMESTAMP),
    `title`       = '".mswSafeImportString($_POST['title'])."',
    `answer`      = '".mswSafeImportString($_POST['answer'])."',
    `department`  = '{$_POST['dept']}',
    `enResponse`  = '".(isset($_POST['enResponse']) && in_array($_POST['enResponse'],array('yes','no')) ? $_POST['enResponse'] : 'yes')."'
    WHERE `id`    = '{$_GET['edit']}'
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
}

function deleteResponse() {
  if (is_numeric($_GET['delete'])) {
    mysql_query("DELETE FROM ".DB_PREFIX."responses 
    WHERE `id` = '{$_GET['delete']}' 
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    if (mswRowCount('responses')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."responses");
    }
  }
}

}

?>