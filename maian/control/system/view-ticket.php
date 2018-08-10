<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: view-ticket.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// For redirection..
if (MS_PERMISSIONS=='' && isset($_GET['t']) && (int)$_GET['t']>0 && AUTO_VIS_TICKET_REDIRECT) {
  $_SESSION['ticketAccessID'] = (int)$_GET['t'];
}
  
// Check log in..
if (MS_PERMISSIONS=='' || !isset($_GET['t'])) {
  header("Location:index.php");
  exit;
}
  
// Check id..
mswCheckDigit($_GET['t']);
      
// Get ticket information and check permissions..
$TICKET = mswGetTableData('tickets','id',$_GET['t'],'AND email = \''.MS_PERMISSIONS.'\''); 
  
// Is ticket valid..
if (!isset($TICKET->name)) {
  msw403();
}   
  
// Is ticket permanently closed..
if ($TICKET->ticketStatus=='closed') {
  header("Location: index.php?p=portal");
  exit;
}

// Ticket language..
define('VIS_TICK_LANG', mswVisLang($TICKET->tickLang));
define('VIS_LANG_PATH', PATH.'templates/language/'.VIS_TICK_LANG.'/');
  
// Add reply..
if (isset($_POST['process'])) {
  if ($_POST['comments']=='') {
    $eString[0]  = $msg_newticket19;
    $eFields[]   = 'comments';
  }
  if ($SETTINGS->attachment=='yes') {
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
  $customCheckFields = $MSFIELDS->check('reply',$_POST['deptid']);
  if (!empty($customCheckFields)) {
    $eFields = array_merge($eFields,$customCheckFields);
  }
  // Department preferences..
  if (empty($eString) && empty($eFields)) {
    if (mswRowCount('tickets WHERE id = \''.$_GET['t'].'\'')>0) {
      // Add ticket reply..
      $replyID = $MSTICKET->addTicketReply();
      if ($SETTINGS->attachment=='yes' && !empty($ticketAttachments)) {
        for ($i=0; $i<count($ticketAttachments); $i++) {
          $n             = $MSTICKET->getAttachmentName($ticketAttachments[$i]['ext'],$replyID,$ticketAttachments[$i]['name'],$replyID,($i+0));
          $t             = $ticketAttachments[$i]['temp'];
          $s             = $ticketAttachments[$i]['size'];
          $folder        = $MSTICKET->uploadFiles($t,$n,$s,$_GET['t'],$replyID);
          $attachString .= $SETTINGS->scriptpath.'/templates/attachments/'.$folder.$n.' ('.mswFileSizeConversion($s).')'.mswDefineNewline();
        }
      }
      // Build mail tags..
      $MSMAIL->addTag('{NAME}', $TICKET->name);
      $MSMAIL->addTag('{TICKET}', mswTicketNumber($_GET['t']));
      $MSMAIL->addTag('{SUBJECT}', $_POST['subject']);
      $MSMAIL->addTag('{COMMENTS}', mswTicketCommentsFilter($_POST['comments']));
      $MSMAIL->addTag('{DEPT}', mswGetDepartmentName($_POST['deptid']));
      $MSMAIL->addTag('{PRIORITY}', $_POST['priority']);
      $MSMAIL->addTag('{STATUS}', (isset($_POST['close']) ? $msg_showticket24 : $msg_showticket23));
      $MSMAIL->addTag('{ATTACHMENTS}', ($attachString ? trim($attachString) : $msg_script17));
      $MSMAIL->addTag('{IS_EMAIL}',$msg_script5);
      $MSMAIL->addTag('{CUSTOM}',$MSFIELDS->email($_GET['t'],$replyID));      
      $MSMAIL->addTag('{ID}',$_GET['t']);
      // Send message to support team..
      // This doesn`t include global user..
      if ($TICKET->assignedto) {
        $q_users = mysql_query("SELECT *,".DB_PREFIX."users.name AS person FROM ".DB_PREFIX."userdepts
                   LEFT JOIN ".DB_PREFIX."departments
                   ON ".DB_PREFIX."userdepts.deptID  = ".DB_PREFIX."departments.id
                   LEFT JOIN ".DB_PREFIX."users
                   ON ".DB_PREFIX."userdepts.userID  = ".DB_PREFIX."users.id
                   WHERE `userID`  IN (".$TICKET->assignedto.")
                   AND `notify`     = 'yes'
                   ORDER BY ".DB_PREFIX."users.name
                   ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      } else {
        $q_users = mysql_query("SELECT *,".DB_PREFIX."users.name AS person FROM ".DB_PREFIX."userdepts
                   LEFT JOIN ".DB_PREFIX."departments
                   ON ".DB_PREFIX."userdepts.deptID  = ".DB_PREFIX."departments.id
                   LEFT JOIN ".DB_PREFIX."users
                   ON ".DB_PREFIX."userdepts.userID  = ".DB_PREFIX."users.id
                   WHERE `deptID`  = '{$_POST['deptid']}'
                   AND `userID`   != '1'
                   AND `notify`    = 'yes'
                   ORDER BY ".DB_PREFIX."users.name
                   ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      }
      while ($USERS = mysql_fetch_object($q_users)) {
        $MSMAIL->sendMSMail($USERS->person,
                            $USERS->email,
                            $SETTINGS->website,
                            $SETTINGS->email,
                            str_replace(array('{website}','{ticket}'),
                                        array($SETTINGS->website,mswTicketNumber($_GET['t'])),
                                        $msg_showticket25
                            ),
                            $MSMAIL->template(VIS_LANG_PATH.'email/ticket-reply-notification.txt')
                 );
      }
      // Now send to global user if ticket assign is off..
      if ($TICKET->assignedto=='') {
        $GLOBAL = mswGetTableData('users','id',1,' AND `notify` = \'yes\'');
        if (isset($GLOBAL->name)) {
          $MSMAIL->sendMSMail($GLOBAL->name,
                              $GLOBAL->email,
                              $SETTINGS->website,
                              $SETTINGS->email,
                              str_replace(array('{website}','{ticket}'),
                                          array($SETTINGS->website,mswTicketNumber($_GET['t'])),
                                          $msg_showticket25
                              ),
                              $MSMAIL->template(VIS_LANG_PATH.'email/ticket-reply-notification.txt')
                   );
        }
      }
      header("Location: index.php?t=".$_GET['t']."#r".$replyID);
      exit;
    } else {
      header("Location: index.php?t=".$_GET['t']);
      exit;
    }
  }
}
  
$title = str_replace('{ticket}',mswTicketNumber($_GET['t']),$msg_showticket4);
  
// Attachments count..
$aCount = mswRowCount('attachments WHERE ticketID = \''.$_GET['t'].'\' AND replyID = \'0\'');
  
// Update IP which wasn`t present for imap/xml-rpc..
if ($TICKET->ipAddresses==$msg_script37 || strpos($TICKET->ipAddresses,'.')===false) {
  $newIP               = $MSTICKET->updateTicketIP($TICKET->id);
  $TICKET->ipAddresses = $newIP;
}  
  
$loadGreyBox = true;  
  
include(PATH.'control/header.php');

$tpl = mswGetSavant();
$tpl->assign('MESSAGE', array(mswSpecialChars($TICKET->subject),$msg_showticket,($TICKET->ticketStatus=='close' ? $msg_showticket26 : $msg_showticket17)));
$tpl->assign('TEXT',array($msg_showticket18,$msg_showticket9,$msg_showticket10,$msg_showticket11,$msg_showticket12,$msg_showticket13,
                          $msg_showticket16,$msg_showticket14,$msg_showticket5,
                          str_replace('{count}',mswRowCount('attachments WHERE `ticketID` = \''.$_GET['t'].'\''),$msg_showticket22),
                          str_replace('{count}',count($eFields),$msg_newticket36),
                          mswSpecialChars($msg_showticket17),
                          mswSpecialChars($msg_showticket27),
                          mswSpecialChars($msg_newticket43),
                          mswSpecialChars($msg_newticket47)
                    )
            );
$tpl->assign('TEXT_DATA',array(str_replace('{ticket}',mswTicketNumber($TICKET->id),$msg_showticket19),mswSpecialChars($TICKET->name),
                               $TICKET->email,mswGetDepartmentName($TICKET->department),mswDateDisplay($TICKET->ts,$SETTINGS->dateformat).' / '.mswTimeDisplay($TICKET->ts,$SETTINGS->timeformat),$TICKET->ipAddresses,
                              ($TICKET->priority==3 ? '<span class="highPriority">'.mswGetPriorityLevel($TICKET->priority).'</span>' : mswGetPriorityLevel($TICKET->priority)),
                              mswGetTicketStatus($TICKET->ticketStatus,$TICKET->replyStatus)
                         )
            );
$tpl->assign('REPLY_DATA', $MSTICKET->getTicketReplies($TICKET->id,mswCleanData($TICKET->name)));
$tpl->assign('HIDDEN_FIELDS', $MSTICKET->replyHiddenFields($TICKET));
$tpl->assign('ATTACHMENTS', $MSTICKET->ticketAttachments($eFields,$eString));
$tpl->assign('CUSTOM_FIELDS', $MSFIELDS->build('reply',$TICKET->department));
$tpl->assign('BBCODE', $MSTICKET->bbCode());
$tpl->assign('CUSTOM_FIELD_DATA', $MSFIELDS->display($_GET['t']));
$tpl->assign('TICKET_ATTACHMENTS', $MSTICKET->buildAttachmentLinks($TICKET->id,0,'main'));
$tpl->assign('COMMENTS', (isset($_POST['comments']) ? mswSpecialChars($_POST['comments']) : ''));
$tpl->assign('IS_ATTACHMENTS', ($aCount>0 ? 'yes' : 'no'));
$tpl->assign('E_ARRAY', $eFields);
$tpl->assign('ERRORS', $eString);
$tpl->assign('IS_CHECKED', (isset($_POST['close']) ? 'yes' : 'no'));
$tpl->assign('JS',array_map('mswFilterJS',array($msg_newticket19)));
$tpl->assign('TICKET_TEXT', mswTxtParsingEngine($TICKET->comments));
$tpl->assign('STAFF_ASSIGN',($TICKET->assignedto ? $MSTICKET->staffAssignment($TICKET->assignedto) : ''));
$tpl->assign('MULTIPART', ($SETTINGS->attachment=='yes' ? ' enctype="multipart/form-data"' : ''));
$tpl->display('templates/portal-view-ticket.tpl.php');
include(PATH.'control/footer.php');  

?>