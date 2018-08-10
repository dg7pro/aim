<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: fieldManager.php
  Description: Class File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

class fieldManager {

// Create select/drop down menu..
function buildSelect($text,$id,$options,$value='') {
  global $tabIndex;
  $html    = '<option value="nothing-selected">- - - - - - -</option>';
  $select  = explode(mswDefineNewline(),$options);
  foreach ($select AS $o) {
    $html .= '<option value="'.mswSpecialChars($o).'"'.($value==$o ? ' selected="selected"' : '').'>'.mswSpecialChars($o).'</option>'.mswDefineNewline();
  }
  if (defined('EDIT_BLOCK')) {
    $pStart = '<div class="editBlock">';
    $pEnd   = '</div>';
  } else {
    $pStart = '<p class="select">';
    $pEnd   = '</p>';
  }
  return mswDefineNewline().$pStart.'<label>'.$text.'</label><span><select name="customField['.$id.']" tabindex="'.(++$tabIndex).'">'.$html.'</select></span>'.$pEnd.mswDefineNewline();
}

// Create checkbox..
function buildCheckBox($text,$id,$options,$values='',$admin='no') {
  global $tabIndex;
  global $msg_viewticket71;
  $html   = '';
  $v      = array();
  $boxes  = explode(mswDefineNewline(),$options);
  if ($values) {
    $v = explode('#####',$values);
  }
  foreach ($boxes AS $cb) {
    $html .= ' <input type="checkbox" tabindex="'.(++$tabIndex).'" name="customField['.$id.'][]" value="'.mswSpecialChars($cb).'"'.(in_array($cb,$v) ? ' checked="checked"' : '').' /> '.$cb.'<br />'.mswDefineNewline();
  }
  if (defined('EDIT_BLOCK')) {
    $pStart = '<div class="editBlock" id="nf_boxes_'.$id.'"><input type="hidden" name="hiddenBoxes[]" value="'.$id.'" />';
    $pEnd   = '</div>';
  } else {
    $pStart = '<p class="checkboxes" id="nf_boxes_'.$id.'"><input type="hidden" name="hiddenBoxes[]" value="'.$id.'" />';
    $pEnd   = '</p>';
  }
  return ($html ? mswDefineNewline().$pStart.'<label><span class="all"><input type="checkbox" name="boxeschecker" onclick="if(this.checked){selectAllCustomBoxes(\'nf_boxes_'.$id.'\',\'on\')}else{selectAllCustomBoxes(\'nf_boxes_'.$id.'\',\'off\')}" /></span> '.$text.'</label><span>'.$html.'</span>'.$pEnd : '');
}

// Create input box..
function buildInputBox($text,$id,$value='',$admin='no') {
  global $tabIndex;
  if (defined('EDIT_BLOCK')) {
    $pStart = '<div class="editBlock">';
    $pEnd   = '</div>';
  } else {
    $pStart = '<p class="inputbox">';
    $pEnd   = '</p>';
  }
  return mswDefineNewline().$pStart.'<label>'.$text.'</label><span><input tabindex="'.(++$tabIndex).'" class="box" type="text" name="customField['.$id.']" value="'.mswSpecialChars($value).'" /></span>'.$pEnd.mswDefineNewline();
}

// Create textarea..
function buildTextArea($text,$id,$value='',$admin='no') {
  global $tabIndex;
  if (defined('EDIT_BLOCK')) {
    $pStart = '<div class="editBlock">';
    $pEnd   = '</div>';
  } else {
    $pStart = '<p class="textarea">';
    $pEnd   = '</p>';
  }
  return mswDefineNewline().$pStart.'<label>'.$text.'</label><span><textarea tabindex="'.(++$tabIndex).'" rows="5" cols="20" name="customField['.$id.']">'.mswSpecialChars($value).'</textarea></span>'.$pEnd.mswDefineNewline();
}

}

?>
