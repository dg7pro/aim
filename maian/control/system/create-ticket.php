<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: create-ticket.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// Pre-populate subject/comments/custom fields..
if (isset($_GET['prePopulation']) && (int)$_GET['prePopulation']>0) {
  // Does session data exist for custom fields?
  // Only populate if post data is sent..ie, on a error load..
  if (!empty($_SESSION['cs_fields_data']) && $_GET['postSent']=='yes') {
    $_POST['customField'] = $_SESSION['cs_fields_data'];
  }
  if (!empty($_SESSION['cs_fields_error']) && $_GET['postSent']=='yes') {
    $eFields = $_SESSION['cs_fields_error'];
  }
  $fields = $MSFIELDS->build('ticket',$_GET['prePopulation'],'no');
  $html   = $MSTICKET->prePopulate();
  echo json_encode(
   array(
    0 => ($_GET['postSent']=='yes' ? 'none' : $html[0]),
    1 => ($_GET['postSent']=='yes' ? 'none' : $html[1]),
    2 => $fields
   )
  ); 
  exit;
}

// Preview..
if (isset($_GET['previewMsg'])) {
  if (isset($_POST['msg'])) {
    $_SESSION['previewBoxText'] = (trim($_POST['msg']) ? mswCleanData($_POST['msg']) : '');
    echo 'ok|||||'.$msg_script36;
  } else {
    $tpl = mswGetSavant();
    $tpl->assign('CHARSET', $msg_charset);
    $tpl->assign('TITLE', $msg_newticket44);
    $tpl->assign('PREVIEW', (isset($_SESSION['previewBoxText']) && $_SESSION['previewBoxText'] ? mswTxtParsingEngine($_SESSION['previewBoxText']) : $msg_newticket44));
    $tpl->display('templates/ticket-preview.tpl.php');
  }
  exit;
}

if (defined('MS_PERMISSIONS') && MS_PERMISSIONS!='') {
  $_POST['email'] = MS_PERMISSIONS;
  // Do we disable recaptcha..
  if ($SETTINGS->enCapLogin=='yes') {
    define('DISABLE_CAPTCHA', 1);
  }
}

if (isset($_POST['process'])) {
  if (isset($_SESSION['cs_fields_data'])) {
    unset($_SESSION['cs_fields_data']);
  }
  if (isset($_SESSION['cs_fields_error'])) {
    unset($_SESSION['cs_fields_error']);
  }
  if (isset($_POST['name']) && $_POST['name']=='') {
    $eString[0]  = $msg_newticket16;
    $eFields[]   = 'name';
  }
  if (isset($_POST['email']) && !mswIsValidEmail($_POST['email'])) {
    $eString[1]  = $msg_newticket17;
    $eFields[]   = 'email';
  }
  if (!is_numeric($_POST['dept']) || $_POST['dept']=='0') {
    $eString[6]  = $msg_newticket27;
    $eFields[]   = 'dept';
  }
  if ($_POST['subject']=='') {
    $eString[2]  = $msg_newticket18;
    $eFields[]   = 'subject';
  }
  if ($_POST['comments']=='') {
    $eString[3]  = $msg_newticket19;
    $eFields[]   = 'comments';
  }
  if (!in_array($_POST['priority'],$levelPrKeys)) {
    $eString[7]  = $msg_newticket28;
    $eFields[]   = 'priority';
  }
  if (!defined('DISABLE_CAPTCHA')) {
    if ($SETTINGS->recaptchaPublicKey && $SETTINGS->recaptchaPrivateKey && isset($_POST['recaptcha_response_field'])) {
      $RECAPTCHA = recaptcha_check_answer($SETTINGS->recaptchaPrivateKey,$_SERVER['REMOTE_ADDR'],$_POST['recaptcha_challenge_field'],$_POST['recaptcha_response_field']);
      if (!$RECAPTCHA->is_valid) {
        $eString[5] = $msg_newticket24;
        $eFields[]  = 'sum';
        $capErr     = $RECAPTCHA->error;
      }
    } else {
      // If javascript isn`t enabled, fail..
      if ($SETTINGS->recaptchaPublicKey && $SETTINGS->recaptchaPrivateKey) {
        if (isset($_POST['recaptcha_response_field_fail'])) {
          $eString[5] = $msg_newticket39;
          $eFields[]  = 'sum';
        }
      }
    }
  }
  if ($SETTINGS->attachment=='yes') {
    // Check limit..
    if (!empty($_FILES['attachment']['tmp_name']) && LICENCE_VER=='locked' && count($_FILES['attachment']['tmp_name'])>RESTR_ATTACH) {
      $countOfBoxes = RESTR_ATTACH;
    }
    for ($i=0; $i<(isset($countOfBoxes) ? $countOfBoxes : count($_FILES['attachment']['tmp_name'])); $i++) {
      $fname  = $_FILES['attachment']['name'][$i];
      $ftemp  = $_FILES['attachment']['tmp_name'][$i];
      $fsize  = $_FILES['attachment']['size'][$i];
      if ($fname && $ftemp && $fsize>0) {
        if (!$MSTICKET->checkFileSize($fsize)) {
          $eString[4] = $msg_newticket20;
          $eFields[]  = 'attach';
        }
        if (!isset($eString[4]) && !$MSTICKET->checkFileType($fname)) {
          $eString[4] = $msg_newticket21;
          $eFields[]  = 'attach';
        }
        $ticketAttachments[$i]['ext']  = (strpos($fname,'.')!==FALSE ? strrchr(strtolower($fname), '.') : '');
        $ticketAttachments[$i]['temp'] = $ftemp;
        $ticketAttachments[$i]['size'] = $fsize;
        $ticketAttachments[$i]['name'] = $fname;  
      }
    }
    // If error, clear all attachment temp files..
    if (in_array('attach',$eFields)) {
      for ($i=0; $i<count($_FILES['attachment']['tmp_name']); $i++) {
        @unlink($_FILES['attachment']['tmp_name'][$i]);
      }
      $ticketAttachments = array();
    }
  }
  // Check required custom fields..
  $customCheckFields = $MSFIELDS->check('ticket',$_POST['dept']);
  if (isset($_POST['customField'])) {
    $_SESSION['cs_fields_data'] = $_POST['customField'];
  }
  if (!empty($customCheckFields)) {
    $eFields = array_merge($eFields,$customCheckFields);
  }
  // Department preferences..
  $MAN_ASSIGN = mswGetDepartmentName($_POST['dept'],true); 
  // Create ticket if no errors..
  if (empty($eString) && empty($eFields)) {
    // Add new ticket data to database and return ticket id..
    $ticketID = $MSTICKET->openNewTicket(false,false,$MAN_ASSIGN->manual_assign);
    // Add attachments..
    if ($SETTINGS->attachment=='yes' && !empty($ticketAttachments)) {
      for ($i=0; $i<count($ticketAttachments); $i++) {
        $n             = $MSTICKET->getAttachmentName($ticketAttachments[$i]['ext'],$ticketID,$ticketAttachments[$i]['name'],0,($i+1));
        $t             = $ticketAttachments[$i]['temp'];
        $s             = $ticketAttachments[$i]['size'];
        $folder        = $MSTICKET->uploadFiles($t,$n,$s,$ticketID);
        $attachString .= $SETTINGS->scriptpath.'/templates/attachments/'.$folder.$n.' ('.mswFileSizeConversion($s).')'.mswDefineNewline();
      }
    }
    $userPass = '';
    // First time user? Create login details..
    if (!$MSTICKET->isPortal($_POST['email'])) {
      $userPass = $MSTICKET->createPortalLogin($_POST['email']);
    }
    // Build mail tags from post data..
    foreach ($_POST AS $key => $value) {
      if (in_array($key,array('name','email','dept','subject','comments','priority'))) {
        $MSMAIL->addTag('{'.strtoupper($key).'}', $value);
        // If HTML emails are on, lets add line breaks to comments..
        // We`ll also convert character entities..
        if (HTML_EMAILS && $key=='comments') {
          $MSMAIL->addTag('{'.strtoupper($key).'}', mswTicketCommentsFilter($value));
        }
      }
    }
    // Line breaks for attachments for html emails..
    if (HTML_EMAILS && $attachString) {
      $attachString = nl2br($attachString);
    }
    // Build mail tags..
    $MSMAIL->addTag('{TICKET}', mswTicketNumber($ticketID));
    $MSMAIL->addTag('{DEPT}', mswGetDepartmentName($_POST['dept']));
    $MSMAIL->addTag('{PRIORITY}', mswGetPriorityLevel($_POST['priority']));
    $MSMAIL->addTag('{PASSWORD}', $userPass);
    $MSMAIL->addTag('{ATTACHMENTS}', ($attachString ? trim($attachString) : $msg_script17));
    $MSMAIL->addTag('{IS_EMAIL}', $msg_script5);
    $MSMAIL->addTag('{CUSTOM}',$MSFIELDS->data('ticket',$ticketID,0,$_POST['dept']));
    $MSMAIL->addTag('{ID}',$ticketID);
      
    // Send message to support team if manual assign is off for department..
    // This doesn`t include the global user..
    if ($MAN_ASSIGN->manual_assign=='no') {
      $q_users = mysql_query("SELECT *,".DB_PREFIX."users.name AS person FROM ".DB_PREFIX."userdepts
                 LEFT JOIN ".DB_PREFIX."departments
                 ON ".DB_PREFIX."userdepts.deptID  = ".DB_PREFIX."departments.id
                 LEFT JOIN ".DB_PREFIX."users
                 ON ".DB_PREFIX."userdepts.userID  = ".DB_PREFIX."users.id
                 WHERE deptID  = '{$_POST['dept']}'
                 AND userID   != '1'
                 AND notify    = 'yes'
                 ORDER BY ".DB_PREFIX."users.name
                 ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      while ($USERS = mysql_fetch_object($q_users)) {
        $MSMAIL->sendMSMail($USERS->person,
                            $USERS->email,
                            $SETTINGS->website,
                            $SETTINGS->email,
                            str_replace(array('{website}','{ticket}'),
                                        array($SETTINGS->website,mswTicketNumber($ticketID)),
                                        $msg_newticket22
                            ),
                            $MSMAIL->template(E_LANG_PATH.'email/new-ticket-notification.txt')
                 );
      }
    }
    // Now send to global user..
    $GLOBAL = mswGetTableData('users','id',1,' AND notify = \'yes\'');
    if (isset($GLOBAL->name)) {
      $MSMAIL->sendMSMail($GLOBAL->name,
                          $GLOBAL->email,
                          $SETTINGS->website,
                          $SETTINGS->email,
                          str_replace(array('{website}','{ticket}'),
                                      array($SETTINGS->website,mswTicketNumber($ticketID)),
                                      $msg_newticket22
                          ),
                          $MSMAIL->template(E_LANG_PATH.'email/new-ticket-notification.txt')
               );
    }
    // Send auto responder to person who opened ticket..
    $MSMAIL->sendMSMail($_POST['name'],
                        $_POST['email'],
                        $SETTINGS->website,
                        $SETTINGS->email,
                        str_replace(array('{website}','{ticket}'),
                                    array($SETTINGS->website,mswTicketNumber($ticketID)),
                                    $msg_newticket23
                        ),
                        $MSMAIL->template(E_LANG_PATH.'email/'.($userPass ? 'first-' : '').'auto-responder.txt')
             );
    // Display message..
    $title  = $msg_newticket42;
    if ($userPass) {
      $msg = str_replace(array('{email}','{pass}','{website}','{subject}'),
                         array(mswSpecialChars($_POST['email']),
                               $userPass,
                               mswSpecialChars($SETTINGS->website),
                               mswSpecialChars($_POST['subject'])
                         ),
                         $msg_newticket40
             );
    } else {
      $msg = str_replace(array('{email}','{website}','{subject}'),
                         array(mswSpecialChars($_POST['email']),
                               mswSpecialChars($SETTINGS->website),
                               mswSpecialChars($_POST['subject'])
                         ),
                         (defined('MS_PERMISSIONS') && MS_PERMISSIONS!='' ? $msg_newticket41 : $msg_newticket45)
             );
    }
    include(PATH.'control/header.php');
    $tpl = mswGetSavant();
    $tpl->assign('TEXT', array($msg_newticket42,$msg));
    $tpl->assign('TICKET_ID', mswTicketNumber($ticketID));
    $tpl->display('templates/message.tpl.php');
    include(PATH.'control/footer.php');
    exit;
  }
}

$loadGreyBox = true;
$title       = $msg_main2;
  
include(PATH.'control/header.php');

// Populate department..
if (isset($_POST['process'])) {
  $dept = $_POST['dept'];
}

// Assign arrays to session..
if (!empty($eFields)) {
  $_SESSION['cs_fields_error'] = $eFields;
}

// Hidden fields for readonly..prevents errors..
$hidden = '';
if (defined('MS_PERMISSIONS') && MS_PERMISSIONS!='') {
  if (defined('POP_NAME') && defined('POP_MAIL')) {
    $hidden  = '<input type="hidden" name="name" value="'.mswSpecialChars(POP_NAME).'" />'.mswDefineNewline();
    $hidden .= '<input type="hidden" name="email" value="'.mswSpecialChars(POP_MAIL).'" />'.mswDefineNewline();
  }
}

$tpl = mswGetSavant();
$tpl->assign('TEXT', array((defined('MS_PERMISSIONS') && MS_PERMISSIONS!='' ? $msg_newticket30 : $msg_newticket2),$msg_newticket,
                           $msg_newticket6,$msg_newticket3,$msg_newticket4,$msg_newticket15,$msg_newticket5,$msg_newticket8,
                           $msg_newticket9,$msg_newticket10,$msg_newticket11,mswSpecialChars($msg_newticket12),
                           str_replace('{count}',count($eFields),$msg_newticket36),
                           mswSpecialChars($msg_newticket43)
                     )
            );
$tpl->assign('MULTIPART', ($SETTINGS->attachment=='yes' ? ' enctype="multipart/form-data"' : ''));
$tpl->assign('DEPARTMENTS', $MSTICKET->ticketDepartments());
$tpl->assign('VALUE', array((isset($_POST['name']) ? mswSpecialChars($_POST['name']) : ''),
                            (isset($_POST['email']) ? mswSpecialChars($_POST['email']) : ''),
                            (isset($_POST['subject']) ? mswSpecialChars($_POST['subject']) : ''),
                            (isset($_POST['comments']) ? mswSpecialChars($_POST['comments']) : ''))
            );
$tpl->assign('CUSTOM_FIELDS', str_replace('{fields}','',file_get_contents(PATH.'templates/html/custom-fields/wrapper.htm')));  
$tpl->assign('BBCODE', $MSTICKET->bbCode()); 
$tpl->assign('PRIORITY_LEVELS', $ticketLevelSel);
$tpl->assign('PRIORITY_LEVEL_SELECTED', (isset($_POST['priority']) && in_array($_POST['priority'],$levelPrKeys) ? $_POST['priority'] : 'low'));         
$tpl->assign('ATTACHMENTS', $MSTICKET->ticketAttachments($eFields,$eString));
$tpl->assign('SHOW_RECAPTCHA', $MSTICKET->spamSumDiv($eFields,$eString,(isset($capErr) ? '&amp;error='.$capErr : '')));
$tpl->assign('SUM', array((isset($_POST['s1']) ? (int)$_POST['s1'] : $sum1),(isset($_POST['s2']) ? (int)$_POST['s2'] : $sum2)));
$tpl->assign('E_ARRAY', $eFields);
$tpl->assign('JS', array_map('mswFilterJS',array($msg_newticket16,$msg_newticket17,$msg_newticket18,$msg_newticket19,$msg_newticket24)));
$tpl->assign('ERRORS', $eString);
$tpl->assign('SPAM_PREVENTION', ($SETTINGS->recaptchaPublicKey && $SETTINGS->recaptchaPrivateKey ? 'yes' : 'no'));
$tpl->assign('READONLY_NAME', (defined('MS_PERMISSIONS') && MS_PERMISSIONS!='' && $hidden ? ' disabled="disabled"' : ''));
$tpl->assign('READONLY_EMAIL', (defined('MS_PERMISSIONS') && MS_PERMISSIONS!='' && $hidden ? ' disabled="disabled"' : ''));
$tpl->assign('HIDDEN_FIELDS', $hidden);
$tpl->display('templates/create-ticket.tpl.php');
include(PATH.'control/footer.php');  

?>