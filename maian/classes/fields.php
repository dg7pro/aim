<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: fields.php
  Description: Class File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

class customFieldManager {

// Mysql..
function insert($ticketID,$fieldID,$replyID,$data) {
  mysql_query("INSERT INTO ".DB_PREFIX."ticketfields (
  `ticketID`,`fieldID`,`replyID`,`fieldData`
  ) VALUES (
  '$ticketID','$fieldID','$replyID','".mswSafeImportString($data)."'
  )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
}

// Display..
function display($ticketID,$replyID=0) {
  $html     = '';
  $wrapper  = trim(file_get_contents(PATH.'templates/html/ticket-custom-field-wrapper.htm'));
  $qT       = mysql_query("SELECT * FROM ".DB_PREFIX."ticketfields
              WHERE `ticketID`  = '$ticketID'
              AND `replyID`     = '$replyID'
              ORDER BY `id`
              ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  while ($TS = mysql_fetch_object($qT)) {
    $FIELD = mswGetTableData('cusfields','id',$TS->fieldID);
    if (isset($FIELD->fieldType)) {
      if ($FIELD->repeatPref=='no' && strpos($FIELD->fieldLoc,'admin')!==false) {
      } else {
        switch ($FIELD->fieldType) {
          case 'textarea':
          case 'input':
          case 'select':
          $html .= str_replace(array('{head}','{data}'),
                               array(mswCleanData($FIELD->fieldInstructions),
                                     mswTxtParsingEngine($TS->fieldData)
                               ),
                               file_get_contents(PATH.'templates/html/ticket-custom-field-data.htm')
                   );
          break;
          case 'checkbox':
          $html .= str_replace(array('{head}','{data}'),
                               array(mswCleanData($FIELD->fieldInstructions),
                                     str_replace('#####','<br />',mswCleanData($TS->fieldData))
                               ),
                               file_get_contents(PATH.'templates/html/ticket-custom-field-data.htm')
                   );
          break;
        }
      }
    }
  }
  return ($html ? mswDefineNewline().str_replace('{data}',trim($html),$wrapper) : '');
}

// Insert and return data..
function email($ticketID,$replyID=0) {
  $text  = '';
  $qF    = mysql_query("SELECT * FROM ".DB_PREFIX."cusfields
           LEFT JOIN ".DB_PREFIX."ticketfields
           ON ".DB_PREFIX."cusfields.id = ".DB_PREFIX."ticketfields.fieldID
           WHERE `ticketID`  = '$ticketID'
           AND `replyID`     = '$replyID'
           AND `enField`     = 'yes'
           ORDER BY ".DB_PREFIX."cusfields.`orderBy`
           ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  if (mysql_num_rows($qF)>0) {
  while ($FIELDS = mysql_fetch_object($qF)) {
    switch ($FIELDS->fieldType) {
      case 'checkbox':
      $text .= mswCleanData($FIELDS->fieldInstructions).mswDefineNewline();
      $text .= str_replace('#####',mswDefineNewline(),mswCleanData($FIELDS->fieldData)).mswDefineNewline().mswDefineNewline();
      break;
      default:
      $text .= mswCleanData($FIELDS->fieldInstructions).mswDefineNewline();
      $text .= mswCleanData($FIELDS->fieldData).mswDefineNewline().mswDefineNewline();
      break;
    }
  }
  }
  return ($text ? (HTML_EMAILS ? nl2br(trim($text)) : trim($text)) : 'N/A');
}

// Insert and return data..
function data($area,$ticketID,$replyID=0,$dept) {
  $text  = '';
  $qF    = mysql_query("SELECT * FROM ".DB_PREFIX."cusfields
           WHERE FIND_IN_SET('$area',`fieldLoc`) > 0
           AND `enField`  = 'yes'
           AND (FIND_IN_SET('all',`departments`) > 0 OR FIND_IN_SET('$dept',`departments`) > 0)
           ORDER BY `orderBy`
           ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  if (mysql_num_rows($qF)>0) {
  while ($FIELDS = mysql_fetch_object($qF)) {
    switch ($FIELDS->fieldType) {
      case 'textarea':
      case 'input':
      if ($_POST['customField'][$FIELDS->id]!='') {
        $text .= mswCleanData($FIELDS->fieldInstructions).mswDefineNewline();
        $text .= $_POST['customField'][$FIELDS->id].mswDefineNewline().mswDefineNewline();
        //customFieldManager::insert($ticketID,$FIELDS->id,$replyID,mswCleanData($_POST['customField'][$FIELDS->id]));
      }
      break;
      case 'select':
      if ($_POST['customField'][$FIELDS->id]!='nothing-selected') {
        $text .= mswCleanData($FIELDS->fieldInstructions).mswDefineNewline();
        $text .= $_POST['customField'][$FIELDS->id].mswDefineNewline().mswDefineNewline();
        //customFieldManager::insert($ticketID,$FIELDS->id,$replyID,mswCleanData($_POST['customField'][$FIELDS->id]));
      }
      break;
      case 'checkbox':
      if (!empty($_POST['customField'][$FIELDS->id])) {
        $text .= mswCleanData($FIELDS->fieldInstructions).mswDefineNewline();
        foreach ($_POST['customField'][$FIELDS->id] AS $k => $v) {
          $text .= $v.mswDefineNewline();
        }
        $text .= mswDefineNewline();
        //customFieldManager::insert($ticketID,$FIELDS->id,$replyID,mswCleanData(implode('#####',$_POST['customField'][$FIELDS->id])));
      }
      break;
    }
  }
  }
  return ($text ? (HTML_EMAILS ? nl2br(trim($text)) : trim($text)) : 'N/A');
}

// Check required fields..
function check($area,$dept) {
  $errors = array();
  $qF     = mysql_query("SELECT * FROM ".DB_PREFIX."cusfields
            WHERE FIND_IN_SET('$area',`fieldLoc`) > 0
            AND `fieldReq`  = 'yes'
            AND `enField`   = 'yes'
            AND (FIND_IN_SET('all',`departments`) > 0 OR FIND_IN_SET('$dept',`departments`) > 0)
            ORDER BY `orderBy`
            ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  if (mysql_num_rows($qF)>0) {
  while ($FIELDS = mysql_fetch_object($qF)) {
    switch ($FIELDS->fieldType) {
      case 'textarea':
      case 'input':
      if (isset($_POST['customField'][$FIELDS->id]) && $_POST['customField'][$FIELDS->id]=='') {
        $errors[] = 'cusfield_'.$FIELDS->id;
      }
      break;
      case 'select':
      if (isset($_POST['customField'][$FIELDS->id]) && $_POST['customField'][$FIELDS->id]=='nothing-selected') {
        $errors[] = 'cusfield_'.$FIELDS->id;
      }
      break;
      case 'checkbox':
      if (empty($_POST['customField'][$FIELDS->id])) {
        $errors[] = 'cusfield_'.$FIELDS->id;
      }
      break;
    }
  }
  }
  return $errors;
}

// Render new fields..
function build($area,$dept,$wrapper='yes') {
  $html     = '';
  $tab      = 6;
  $wrapper  = file_get_contents(PATH.'templates/html/custom-fields/wrapper.htm');
  $qF = mysql_query("SELECT * FROM ".DB_PREFIX."cusfields
        WHERE FIND_IN_SET('$area',`fieldLoc`) > 0
        AND `enField`  = 'yes'
        AND (FIND_IN_SET('all',`departments`) > 0 OR FIND_IN_SET('$dept',`departments`) > 0)
        ORDER BY `orderBy`
        ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  if (mysql_num_rows($qF)>0) {
  while ($FIELDS = mysql_fetch_object($qF)) {
    switch ($FIELDS->fieldType) {
      case 'textarea':
      $html .= customFieldManager::textarea(mswCleanData($FIELDS->fieldInstructions),$FIELDS->id,++$tab,$FIELDS->fieldReq);
      break;
      case 'input':
      $html .= customFieldManager::box(mswCleanData($FIELDS->fieldInstructions),$FIELDS->id,++$tab,$FIELDS->fieldReq);
      break;
      case 'select':
      $html .= customFieldManager::select(mswCleanData($FIELDS->fieldInstructions),$FIELDS->id,$FIELDS->fieldOptions,++$tab,$FIELDS->fieldReq);
      break;
      case 'checkbox':
      $html .= customFieldManager::checkbox(mswCleanData($FIELDS->fieldInstructions),$FIELDS->id,$FIELDS->fieldOptions,$FIELDS->fieldReq);
      break;
    }
  }
  }
  return ($html ? ($wrapper=='yes' ? str_replace('{fields}',$html,$wrapper) : $html) : '');
}

// Create select/drop down menu..
function select($text,$id,$options,$tab,$req) {
  global $eFields;
  $html     = '';
  $wrapper  = file_get_contents(PATH.'templates/html/custom-fields/select.htm');
  $select   = explode(mswDefineNewline(),$options);
  foreach ($select AS $o) {
    $html .= str_replace(array('{value}','{selected}','{text}'),
                         array(mswSpecialChars($o),
                               (isset($_POST['customField'][$id]) && $_POST['customField'][$id]==$o ? ' selected="selected"' : ''),
                               mswSpecialChars($o)
                         ),
                         file_get_contents(PATH.'templates/html/custom-fields/select-option.htm')
             );
  }
  return str_replace(array('{id}','{options}','{label}','{error}','{tab}'),
                     array($id,
                           trim($html),
                           ($req=='yes' ? CUSTOM_REQUIRED_MARKER : '').mswSpecialChars($text),
                           (in_array('cusfield_'.$id,$eFields) ? customFieldManager::error($id) : ''),
                           $tab
                     ),
                     $wrapper
         );
}

// Create checkbox..
function checkbox($text,$id,$options,$req) {
  global $msg_viewticket71,$eFields;
  $wrapper  = file_get_contents(PATH.'templates/html/custom-fields/checkbox-wrapper.htm');
  $html     = '';
  $v        = array();
  $boxes    = explode(mswDefineNewline(),$options);
  if (isset($_POST['customField'][$id]) && !empty($_POST['customField'][$id])) {
    $v = $_POST['customField'][$id];
  }
  foreach ($boxes AS $cb) {
    $html .= str_replace(array('{value}','{checked}','{id}'),
                         array(mswSpecialChars($cb),
                               (in_array($cb,$v) ? ' checked="checked"' : ''),
                               $id
                         ),
                         file_get_contents(PATH.'templates/html/custom-fields/checkbox.htm')
             );
  }
  return str_replace(array('{label}','{text}','{checkboxes}','{error}','{id}'),
                     array(($req=='yes' ? CUSTOM_REQUIRED_MARKER : '').mswSpecialChars($text),
                           $msg_viewticket71,
                           trim($html),
                           (in_array('cusfield_'.$id,$eFields) ? customFieldManager::error($id) : ''),
                           $id
                     ),
                     $wrapper
         );
}

// Create input box..
function box($text,$id,$tab,$req) {
  global $eFields;
  return str_replace(array('{label}','{value}','{error}','{id}','{tab}'),
                     array(($req=='yes' ? CUSTOM_REQUIRED_MARKER : '').mswSpecialChars($text),
                           (isset($_POST['customField'][$id]) ? mswSpecialChars($_POST['customField'][$id]) : ''),
                           (in_array('cusfield_'.$id,$eFields) ? customFieldManager::error($id) : ''),
                           $id,
                           $tab
                     ),
                     file_get_contents(PATH.'templates/html/custom-fields/input-box.htm')
         );
}

// Create textarea..
function textarea($text,$id,$tab,$req) {
  global $eFields,$MSTICKET;
  return str_replace(array('{label}','{value}','{error}','{id}','{tab}','{bbcode}'),
                     array(($req=='yes' ? CUSTOM_REQUIRED_MARKER : '').mswSpecialChars($text),
                           (isset($_POST['customField'][$id]) ? mswSpecialChars($_POST['customField'][$id]) : ''),
                           (in_array('cusfield_'.$id,$eFields) ? customFieldManager::error($id) : ''),
                           $id,
                           $tab,
                           $MSTICKET->bbCode()
                     ),
                     file_get_contents(PATH.'templates/html/custom-fields/textarea.htm')
         );
}

// Error..
function error($id) {
  global $msg_newticket31;
  return str_replace(array('{id}','{error}'),
                     array($id,$msg_newticket31),
                     file_get_contents(PATH.'templates/html/custom-fields/error.htm')
         );
}

}

?>