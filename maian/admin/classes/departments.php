<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: departments.php
  Description: Class File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

class departments {

// Re-order..
function orderFields() {
  for ($i=0; $i<count($_POST['id']); $i++) {
    mysql_query("UPDATE ".DB_PREFIX."departments SET
    `orderBy` = '{$_POST['order'][$i]}'
    WHERE id  = '{$_POST['id'][$i]}'
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
}

// Add department..
function addDepartment() {
  global $MSTEAM;
  if (LICENCE_VER=='locked') {
    if (mswRowCount('departments')+1>RESTR_DEPTS) {
      header("Location: index.php?restr=yes");
      exit;
    }
  }
  mysql_query("INSERT INTO ".DB_PREFIX."departments (
  `name`,`showDept`,`dept_subject`,`dept_comments`,`orderBy`,`manual_assign`
  ) VALUES (
  '".mswSafeImportString($_POST['name'])."',
  '".(isset($_POST['showDept']) && in_array($_POST['showDept'],array('yes','no')) ? $_POST['showDept'] : 'yes')."',
  '".mswSafeImportString($_POST['dept_subject'])."',
  '".mswSafeImportString($_POST['dept_comments'])."',
  '0',
  '".(isset($_POST['manual_assign']) && in_array($_POST['manual_assign'],array('yes','no')) ? $_POST['manual_assign'] : 'no')."'
  )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $last = mysql_insert_id();
  // Update order..
  if ($last>0) {
    mysql_query("UPDATE ".DB_PREFIX."departments SET
    `orderBy`  = '".mswRowCount('departments')."'
    WHERE id   = '$last'
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
  // If user isn`t global user, let this user see departments added..
  if (isset($MSTEAM->id) && $MSTEAM->id!='1') {
    mysql_query("INSERT INTO ".DB_PREFIX."userdepts (
    `userID`,`deptID`
    ) VALUES (
    '{$MSTEAM->id}','$last'
    )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
}

// Update department..
function updateDepartment() {
  if (is_numeric($_GET['edit'])) {
    mysql_query("UPDATE ".DB_PREFIX."departments SET
    `name`          = '".mswSafeImportString($_POST['name'])."',
    `showDept`      = '".(isset($_POST['showDept']) && in_array($_POST['showDept'],array('yes','no')) ? $_POST['showDept'] : 'yes')."',
    `dept_subject`  = '".mswSafeImportString($_POST['dept_subject'])."',
    `dept_comments` = '".mswSafeImportString($_POST['dept_comments'])."',
    `manual_assign` = '".(isset($_POST['manual_assign']) && in_array($_POST['manual_assign'],array('yes','no')) ? $_POST['manual_assign'] : 'no')."'
    WHERE id        = '{$_GET['edit']}'
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    // If manual assign is not set, remove from any tickets..
    if (isset($_POST['manual_assign']) && $_POST['manual_assign']=='no') {
      mysql_query("UPDATE ".DB_PREFIX."tickets SET
      `assignedto`       = ''
      WHERE `department` = '{$_GET['edit']}'
      ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    }
  }
}

// Delete department..
function deleteDepartment() {
  if (is_numeric($_GET['delete'])) {
    mysql_query("DELETE FROM ".DB_PREFIX."departments 
    WHERE `id` = '{$_GET['delete']}' 
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    $rows = mysql_affected_rows();
    mysql_query("DELETE FROM ".DB_PREFIX."userdepts 
    WHERE `deptID` = '{$_GET['delete']}' 
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    if (mswRowCount('departments')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."departments");
    }
    if (mswRowCount('userdepts')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."userdepts");
    }
    return $rows;
  }
}

}

?>