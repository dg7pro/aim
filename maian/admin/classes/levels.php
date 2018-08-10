<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: levels.php
  Description: Class File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

class levels {

// Re-order..
function orderLevels() {
  for ($i=0; $i<count($_POST['id']); $i++) {
    mysql_query("UPDATE ".DB_PREFIX."levels SET
    `orderBy` = '{$_POST['order'][$i]}'
    WHERE id  = '{$_POST['id'][$i]}'
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
}

// Add level..
function addLevel() {
  global $MSTEAM;
  mysql_query("INSERT INTO ".DB_PREFIX."levels (
  `name`,`display`,`orderBy`
  ) VALUES (
  '".mswSafeImportString($_POST['name'])."',
  '".(isset($_POST['display']) && in_array($_POST['display'],array('yes','no')) ? $_POST['display'] : 'yes')."',
  '0'
  )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $last = mysql_insert_id();
  // Update order..
  if ($last>0) {
    mysql_query("UPDATE ".DB_PREFIX."levels SET
    `orderBy`  = '".mswRowCount('levels')."'
    WHERE id   = '$last'
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
}

// Update level..
function updateLevel() {
  if (is_numeric($_GET['edit'])) {
    mysql_query("UPDATE ".DB_PREFIX."levels SET
    `name`     = '".mswSafeImportString($_POST['name'])."',
    `display`  = '".(isset($_POST['display']) && in_array($_POST['display'],array('yes','no')) ? $_POST['display'] : 'yes')."'
    WHERE id   = '{$_GET['edit']}'
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
}

// Delete level..
function deleteLevel() {
  if (is_numeric($_GET['delete'])) {
    mysql_query("DELETE FROM ".DB_PREFIX."levels 
    WHERE `id` = '{$_GET['delete']}' 
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    $rows = mysql_affected_rows();
    if (mswRowCount('levels')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."levels");
    }
    return $rows;
  }
}

}

?>