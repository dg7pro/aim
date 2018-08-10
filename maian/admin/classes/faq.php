<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: faq.php
  Description: Class File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

class faqCentre {

var $settings;

// Get attachments..
function loadAttachments() {
  $ID   = (int)$_GET['loadAttachments'];
  $ASD  = faqCentre::assignedAttachments($ID);
  $html = '';
  $cnt  = 0;
  $q_att = mysql_query("SELECT * FROM ".DB_PREFIX."faqattach ORDER BY `name`") 
           or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  while ($ATT = mysql_fetch_object($q_att)) {
    $ext   = substr(strrchr(($ATT->path ? $ATT->path : $ATT->remote), '.'),1);
    $pt    = ($ATT->name ? $ATT->name : ($ATT->remote ? $ATT->remote : $ATT->path));
    $html .= '<p class="alt_color_'.(is_int(++$cnt/2) ? '1' : '2').'"><input type="checkbox" value="'.$ATT->id.'" name="att[]"'.(in_array($ATT->id,$ASD) ? ' checked="checked"' : '').' /> ['.strtoupper($ext).'] '.mswCleanData($pt).'</p>';
  }
  return $html;
}

// Assigned attachments..
function assignedAttachments($id) {
  $assign = array();
  if ($id>0) {
    $q_att = mysql_query("SELECT * FROM ".DB_PREFIX."faqattassign WHERE `question` = '$id' GROUP BY `attachment`") 
             or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    while ($ATT = mysql_fetch_object($q_att)) {
      $assign[] = $ATT->attachment;
    }
  }
  return $assign;
}

// Delete attachment..
function deleteAttachment() {
  $_GET['delete'] = (int)$_GET['delete'];
  mysql_query("DELETE FROM ".DB_PREFIX."faqattach
  WHERE `id` = '{$_GET['delete']}' 
  LIMIT 1
  ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $rows = mysql_affected_rows();
  if ($_GET['file'] && file_exists($this->settings->attachpath.'/faq/'.$_GET['file'])) {
    @unlink($this->settings->attachpath.'/faq/'.$_GET['file']);
  }
  if (mswRowCount('faqattach')==0) {
    @mysql_query("TRUNCATE TABLE ".DB_PREFIX."faqattach");
  }
  return $rows;
}

// Update attachment..
function updateAttachment() {
  $_GET['edit'] = (int)$_GET['edit'];
  $display      = $_POST['name'][0];
  $remote       = $_POST['remote'][0];
  $f_name       = $_FILES['file']['name'][0];
  $f_temp       = $_FILES['file']['tmp_name'][0];
  $f_size       = ($f_name && $f_temp ? $_FILES['file']['size'][0] : $_POST['old_size']);
  if ($remote) {
    $f_size = mswFileRemoteSizeConversion($remote);
  }
  $path         = $_POST['old_path'];
  // Update file..
  if ($remote=='' && $f_size>0 && is_uploaded_file($f_temp)) {
    // Delete original..
    if (file_exists($this->settings->attachpath.'/faq/'.$_POST['old_path'])) {
      @unlink($this->settings->attachpath.'/faq/'.$_POST['old_path']);
    }
    // Does file exist?
    if (file_exists($this->settings->attachpath.'/faq/'.$f_name)) {
      $path = $ID.'_'.$f_name;
      move_uploaded_file($f_temp,$this->settings->attachpath.'/faq/'.$path);
    } else {
      $path = $f_name;
      move_uploaded_file($f_temp,$this->settings->attachpath.'/faq/'.$path);
    }
    // Remove temp file if it still exists..
    if (file_exists($f_temp)) {
      @unlink($f_temp);
    }
  }
  // Add to database..
  mysql_query("UPDATE ".DB_PREFIX."faqattach SET
  `name`     = '".mswSafeImportString($display)."',
  `remote`   = '".mswSafeImportString($remote)."',
  `path`     = '".mswSafeImportString($path)."',
  `size`     = '$f_size'
  WHERE `id` = '{$_GET['edit']}'
  LIMIT 1
  ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
}

// Add attachments..
function addAttachments() {
  if (!is_dir($this->settings->attachpath.'/faq') || !is_writeable($this->settings->attachpath.'/faq')) {
    die('FAQ attachments folder (<b>templates/attachments/faq</b>) doesn`t exist or is not writeable. Please check this folder exists and has write permissions.');
  }
  $count = 0;
  for ($i=0; $i<count($_FILES['file']['tmp_name']); $i++) {
    $display = $_POST['name'][$i];
    $remote  = $_POST['remote'][$i];
    $f_name  = $_FILES['file']['name'][$i];
    $f_temp  = $_FILES['file']['tmp_name'][$i];
    $f_size  = ($f_name && $f_temp ? $_FILES['file']['size'][$i] : ($remote ? mswFileRemoteSizeConversion($remote) : '0'));
    $new     = '';
    // Add to database..
    mysql_query("INSERT INTO ".DB_PREFIX."faqattach (
    `ts`,
    `name`,
    `remote`,
    `path`,
    `size`
    ) VALUES (
    UNIX_TIMESTAMP(UTC_TIMESTAMP),
    '".mswSafeImportString($display)."',
    '".mswSafeImportString($remote)."',
    '".mswSafeImportString($f_name)."',
    '$f_size'
    )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    $ID = mysql_insert_id();
    // Now upload file if applicable..
    if ($ID>0) {
      if ($remote=='' && $f_size>0 && is_uploaded_file($f_temp)) {
        // Does file exist?
        if (file_exists($this->settings->attachpath.'/faq/'.$f_name)) {
          $new = $ID.'_'.$f_name;
          move_uploaded_file($f_temp,$this->settings->attachpath.'/faq/'.$new);
        } else {
          move_uploaded_file($f_temp,$this->settings->attachpath.'/faq/'.$f_name);
        }
      }
      // Was file renamed?
      if ($new) {
        mysql_query("UPDATE ".DB_PREFIX."faqattach SET `path` = '$new' WHERE `id` = '$ID' LIMIT 1");
      }
      ++$count;
    }
    // Remove temp file if it still exists..
    if (file_exists($f_temp)) {
      @unlink($f_temp);
    }
  }
  return $count;
}

// Re-order..
function orderFields() {
  for ($i=0; $i<count($_POST['order_id']); $i++) {
    mysql_query("UPDATE ".DB_PREFIX."categories SET
    `orderBy` = '{$_POST['order'][$i]}'
    WHERE id  = '{$_POST['order_id'][$i]}'
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
}

function enableDisableQuestions($status) {
  if (!empty($_POST['id'])) {
    mysql_query("UPDATE ".DB_PREFIX."faq SET
    `ts`     = UNIX_TIMESTAMP(UTC_TIMESTAMP),
    `enFaq`  = '$status'
    WHERE `id` IN (".implode(',',$_POST['id']).")
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
}

function enableDisableCategory() {
  if (!empty($_POST['id'])) {
    mysql_query("UPDATE ".DB_PREFIX."categories SET
    `enCat`   = '".(isset($_POST['enable']) ? 'yes' : 'no')."'
    WHERE `id` IN (".implode(',',$_POST['id']).")
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
}

function batchImportKB($lines,$del,$enc) {
  $count = 0;
  if (!is_writeable(PATH.'export')) {
    die('<b>export</b> directory must be writeable for this operation. Check and try again..');
  }
  // Clear current responses..
  if (isset($_POST['clear']) && $_POST['clear']=='yes') {
    mysql_query("DELETE FROM ".DB_PREFIX."faq 
    WHERE `category` = '{$_POST['cat']}'
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    if (mswRowCount('faq')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."faq");
    }
  }
  // Upload CSV file..
  if (is_uploaded_file($_FILES['file']['tmp_name'])) {
    $ext          = strrchr(strtolower($_FILES['file']['name']), '.');
    $fl           = 'import-'.date('Ymdhis').$ext;
    $_POST['cat'] = (int)$_POST['cat'];
    move_uploaded_file($_FILES['file']['tmp_name'],PATH.'export/'.$fl);
    // If uploaded file exists, read CSV data...
    if (file_exists(PATH.'export/'.$fl)) {
      $handle = fopen(PATH.'export/'.$fl, "r");
      while (($CSV = fgetcsv($handle,$lines,$del,$enc))!== FALSE) {
        // Restrictions..
        if (LICENCE_VER=='locked') {
          if (mswRowCount('faq')+1>RESTR_FAQ_QUE) {
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
        mysql_query("INSERT INTO ".DB_PREFIX."faq (
        `ts`,
        `question`,
        `answer`,
        `category`
        ) VALUES (
        UNIX_TIMESTAMP(UTC_TIMESTAMP),
        '".mswSafeImportString($CSV[0])."',
        '".mswSafeImportString($CSV[1])."',
        '{$_POST['cat']}'
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

// Reset counts..
function resetCounts() {
  if (!empty($_POST['id'])) {
    mysql_query("UPDATE ".DB_PREFIX."faq SET
    `ts`          = UNIX_TIMESTAMP(UTC_TIMESTAMP),
    `kviews`      = '0',
    `kuseful`     = '0',
    `knotuseful`  = '0'
    WHERE `id`   IN (".implode(',',$_POST['id']).")
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
}

// Add category..
function addCategory() {
  if (LICENCE_VER=='locked') {
    if (mswRowCount('categories')+1>RESTR_FAQ_CATS) {
      header("Location: index.php?restr=yes");
      exit;
    }
  }
  mysql_query("INSERT INTO ".DB_PREFIX."categories (
  `name`,
  `summary`,
  `enCat`,
  `subcat`
  ) VALUES (
  '".mswSafeImportString($_POST['name'])."',
  '".mswSafeImportString($_POST['summary'])."',
  '".(isset($_POST['enCat']) && in_array($_POST['enCat'],array('yes','no')) ? $_POST['enCat'] : 'no')."',
  '".(int)$_POST['subcat']."'
  )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $last = mysql_insert_id();
  // Update order..
  if ($last>0) {
    mysql_query("UPDATE ".DB_PREFIX."categories SET
    `orderBy`  = '".mswRowCount('categories WHERE `subcat` = \''.(int)$_POST['subcat'].'\'')."'
    WHERE id   = '$last'
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
}

// Update category..
function updateCategory() {
  if (is_numeric($_GET['edit'])) {
    mysql_query("UPDATE ".DB_PREFIX."categories SET
    `name`      = '".mswSafeImportString($_POST['name'])."',
    `summary`   = '".mswSafeImportString($_POST['summary'])."',
    `enCat`     = '".(isset($_POST['enCat']) && in_array($_POST['enCat'],array('yes','no')) ? $_POST['enCat'] : 'no')."',
    `subcat`    = '".(int)$_POST['subcat']."'
    WHERE `id`  = '{$_GET['edit']}'
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
}

// Delete category..
function deleteCategory() {
  if (is_numeric($_GET['delete'])) {
    mysql_query("DELETE FROM ".DB_PREFIX."categories 
    WHERE `id` = '{$_GET['delete']}' 
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    $rows = mysql_affected_rows();
    mysql_query("DELETE FROM ".DB_PREFIX."faq 
    WHERE `category` = '{$_GET['delete']}' 
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    if (mswRowCount('categories')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."categories");
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."faq");
    } else {
      if (mswRowCount('faq')==0) {
        @mysql_query("TRUNCATE TABLE ".DB_PREFIX."faq");
      }
    }
    return $rows;
  }
}

function addQuestion() {
  if (LICENCE_VER=='locked') {
    if (mswRowCount('faq')+1>RESTR_FAQ_QUE) {
      header("Location: index.php?restr=yes");
      exit;
    }
  }
  $_POST['cat'] = (int)$_POST['cat'];
  mysql_query("INSERT INTO ".DB_PREFIX."faq (
  `ts`,
  `question`,
  `answer`,
  `category`,
  `enFaq`
  ) VALUES (
  UNIX_TIMESTAMP(UTC_TIMESTAMP),
  '".mswSafeImportString($_POST['question'])."',
  '".mswSafeImportString($_POST['answer'])."',
  '{$_POST['cat']}',
  '".(isset($_POST['enFaq']) && in_array($_POST['enFaq'],array('yes','no')) ? $_POST['enFaq'] : 'no')."'
  )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $ID = mysql_insert_id();
  if (!empty($_POST['att'])) {
    foreach ($_POST['att'] AS $aID) {
      mysql_query("INSERT INTO ".DB_PREFIX."faqattassign (
      `question`,`attachment`
      ) VALUES (
      '$ID','$aID'
      )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    }
  }
}

function updateQuestion() {
  if (is_numeric($_GET['edit']) && is_numeric($_POST['cat'])) {
    mysql_query("UPDATE ".DB_PREFIX."faq SET
    `ts`        = UNIX_TIMESTAMP(UTC_TIMESTAMP),
    `question`  = '".mswSafeImportString($_POST['question'])."',
    `answer`    = '".mswSafeImportString($_POST['answer'])."',
    `category`  = '{$_POST['cat']}',
    `enFaq`     = '".(isset($_POST['enFaq']) && in_array($_POST['enFaq'],array('yes','no')) ? $_POST['enFaq'] : 'no')."'
    WHERE `id`  = '{$_GET['edit']}'
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    if (!empty($_POST['att'])) {
      mysql_query("DELETE FROM ".DB_PREFIX."faqattassign WHERE `question` = '{$_GET['edit']}'");
      if (mswRowCount('faqattassign')==0) {
        @mysql_query("TRUNCATE TABLE ".DB_PREFIX."faqattassign");
      }
      foreach ($_POST['att'] AS $aID) {
        mysql_query("INSERT INTO ".DB_PREFIX."faqattassign (
        `question`,`attachment`
        ) VALUES (
        '{$_GET['edit']}','$aID'
        )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      }
    }
  }
}

function deleteQuestion() {
  if (is_numeric($_GET['delete'])) {
    mysql_query("DELETE FROM ".DB_PREFIX."faq 
    WHERE `id` = '{$_GET['delete']}' 
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    $rows = mysql_affected_rows();
    mysql_query("DELETE FROM ".DB_PREFIX."faqattassign
    WHERE `question` = '{$_GET['delete']}'
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    if (mswRowCount('faq')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."faq");
    }
    if (mswRowCount('faqattassign')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."faqattassign");
    }
    return $rows;
  }
}

}

?>