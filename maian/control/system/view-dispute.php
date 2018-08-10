<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: view-dispute.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// For redirection..
if (MS_PERMISSIONS=='' && isset($_GET['d']) && (int)$_GET['d']>0 && AUTO_VIS_TICKET_REDIRECT) {
  $_SESSION['disputeAccessID'] = (int)$_GET['d'];
}

// Check log in..
if (MS_PERMISSIONS=='' || !isset($_GET['d'])) {
  header("Location:index.php");
  exit;
}
  
// Check id..
mswCheckDigit($_GET['d']);
      
// Get ticket information and check permissions..
$TICKET = mswGetTableData('tickets','id',$_GET['d'],'AND email = \''.MS_PERMISSIONS.'\''); 
  
// Is ticket valid..
if (!isset($TICKET->name)) {
  // Check if this user is in the dispute list...
  $PRIV = mswGetTableData('disputes','userEmail',MS_PERMISSIONS,'AND ticketID = \''.$_GET['d'].'\''); 
  // If privileges allow viewing of dispute, requery without email..
  if (isset($PRIV->id)) {
    $TICKET = mswGetTableData('tickets','id',$_GET['d']);
  }
}  

// Is ticket valid..
if (!isset($TICKET->name) && !isset($PRIV->id)) {
  msw403();
} 

// Post privileges..
$userPostPriv = (isset($PRIV->id) ? $PRIV->postPrivileges : $TICKET->disPostPriv);
  
// Is ticket permanently closed..
if ($TICKET->ticketStatus=='closed') {
  header("Location: index.php?p=portal");
  exit;
}

// Ticket language..
define('VIS_TICK_LANG', mswVisLang($TICKET->tickLang));
define('VIS_LANG_PATH', PATH.'templates/language/'.VIS_TICK_LANG.'/');
define('DISPUTE_VIEW', 1);
  
// Add reply..
if (isset($_POST['process']) && $userPostPriv=='yes') {
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
  if (empty($eString) && empty($eFields)) {
    if (mswRowCount('tickets WHERE id = \''.$_GET['d'].'\'')>0) {
      // Add ticket reply..
      $replyID = $MSTICKET->addTicketReply();
      if ($SETTINGS->attachment=='yes' && !empty($ticketAttachments)) {
        for ($i=0; $i<count($ticketAttachments); $i++) {
          $n             = $MSTICKET->getAttachmentName($ticketAttachments[$i]['ext'],$replyID,$ticketAttachments[$i]['name'],$replyID,($i+0));
          $t             = $ticketAttachments[$i]['temp'];
          $s             = $ticketAttachments[$i]['size'];
          $folder        = $MSTICKET->uploadFiles($t,$n,$s,$_GET['d'],$replyID);
          $attachString .= $SETTINGS->scriptpath.'/templates/attachments/'.$folder.$n.' ('.mswFileSizeConversion($s).')'.mswDefineNewline();
        }
      }
      // Build mail tags..
      $MSMAIL->addTag('{TICKET}', mswTicketNumber($_GET['d']));
      $MSMAIL->addTag('{SUBJECT}', $_POST['subject']);
      $MSMAIL->addTag('{COMMENTS}', mswTicketCommentsFilter($_POST['comments']));
      $MSMAIL->addTag('{DEPT}', mswGetDepartmentName($_POST['deptid']));
      $MSMAIL->addTag('{PRIORITY}', $_POST['priority']);
      $MSMAIL->addTag('{STATUS}', (isset($_POST['close']) ? $msg_showticket24 : $msg_showticket23));
      $MSMAIL->addTag('{ATTACHMENTS}', ($attachString ? trim($attachString) : $msg_script17));
      $MSMAIL->addTag('{IS_EMAIL}',$msg_script5);
      $MSMAIL->addTag('{CUSTOM}',$MSFIELDS->email($_GET['d'],$replyID));
      $MSMAIL->addTag('{USER}', (isset($PRIV->userName) ? $PRIV->userName : $TICKET->name));
      $MSMAIL->addTag('{ID}',$_GET['d']);
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
                                        array($SETTINGS->website,
                                              mswTicketNumber($_GET['d'])
                                        ),
                                        $msg_showticket31
                            ),
                            $MSMAIL->template(VIS_LANG_PATH.'email/dispute-reply-notification.txt')
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
                                          array($SETTINGS->website,
                                                mswTicketNumber($_GET['d'])
                                          ),
                                          $msg_showticket31
                              ),
                              $MSMAIL->template(VIS_LANG_PATH.'email/dispute-reply-notification.txt')
                   );
        }
      }
      // Now send to other people in dispute..
      if ($TICKET->email==MS_PERMISSIONS) {
        $qDU  = mysql_query("SELECT * FROM ".DB_PREFIX."disputes
                WHERE ticketID = '{$_GET['d']}' 
                ORDER BY userName
                ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
        while ($DIS_USERS  = mysql_fetch_object($qDU)) {
          $MSMAIL->sendMSMail($DIS_USERS->userName,
                              $DIS_USERS->userEmail,
                              $SETTINGS->website,
                              $SETTINGS->email,
                              str_replace(array('{website}','{ticket}'),
                                          array($SETTINGS->website,
                                                mswTicketNumber($_GET['d'])
                                          ),
                                          $msg_showticket31
                              ),
                              $MSMAIL->template(VIS_LANG_PATH.'email/dispute-notification.txt')
                   );
        }
      } else {
        $qDU  = mysql_query("SELECT * FROM ".DB_PREFIX."disputes 
                WHERE ticketID  = '{$_GET['d']}' 
                AND userEmail  != '".MS_PERMISSIONS."'
                ORDER BY userName
                ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
        while ($DIS_USERS  = mysql_fetch_object($qDU)) {
          $MSMAIL->sendMSMail($DIS_USERS->userName,
                              $DIS_USERS->userEmail,
                              $SETTINGS->website,
                              $SETTINGS->email,
                              str_replace(array('{website}','{ticket}'),
                                          array($SETTINGS->website,
                                                mswTicketNumber($_GET['d'])
                                          ),
                                          $msg_showticket31
                              ),
                              $MSMAIL->template(VIS_LANG_PATH.'email/dispute-notification.txt')
                   );
        }
        // Original ticket user..
        $MSMAIL->sendMSMail($TICKET->name,
                            $TICKET->email,
                            $SETTINGS->website,
                            $SETTINGS->email,
                            str_replace(array('{website}','{ticket}'),
                                        array($SETTINGS->website,
                                              mswTicketNumber($_GET['d'])
                                        ),
                                        $msg_showticket31
                            ),
                            $MSMAIL->template(VIS_LANG_PATH.'email/dispute-notification.txt')
                 );
      }
      header("Location: index.php?d=".$_GET['d']."#r".$replyID);
      exit;
    } else {
      header("Location: index.php?d=".$_GET['d']);
      exit;
    }
  }
}
  
$title = str_replace('{ticket}',mswTicketNumber($_GET['d']),$msg_showticket32);
  
// Attachments count..
$aCount           = mswRowCount('attachments WHERE ticketID = \''.$_GET['d'].'\' AND replyID = \'0\'');
$othersInDispute  = mswRowCount('disputes WHERE ticketID = \''.$_GET['d'].'\'');
  
$loadGreyBox      = true;  
  
include(PATH.'control/header.php');

$tpl = mswGetSavant();
$tpl->assign('MESSAGE', array(mswSpecialChars($TICKET->subject),$msg_showticket,($TICKET->ticketStatus=='close' ? $msg_showticket26 : $msg_showticket17)));
$tpl->assign('TEXT', array($msg_showticket29,$msg_showticket9,$msg_showticket10,$msg_showticket11,$msg_showticket12,$msg_showticket13,
                           $msg_showticket16,$msg_showticket14,$msg_showticket5,
                           str_replace('{count}',mswRowCount('attachments WHERE ticketID = \''.$_GET['d'].'\''),$msg_showticket22),
                           str_replace('{count}',count($eFields),$msg_newticket36),
                           mswSpecialChars($msg_showticket17),
                           mswSpecialChars($msg_showticket28),
                           str_replace('{count}',($othersInDispute+1),mswSpecialChars($msg_showticket30)),
                           mswSpecialChars($msg_viewticket76),
                           mswSpecialChars($msg_newticket43),
                           mswSpecialChars($msg_newticket47)
                     )
            );
$tpl->assign('TEXT_DATA', array(str_replace('{ticket}',mswTicketNumber($TICKET->id),$msg_showticket19),mswSpecialChars($TICKET->name),
                                $TICKET->email,mswGetDepartmentName($TICKET->department),mswDateDisplay($TICKET->ts,$SETTINGS->dateformat).' / '.mswTimeDisplay($TICKET->ts,$SETTINGS->timeformat),$TICKET->ipAddresses,
                                ($TICKET->priority==3 ? '<span class="highPriority">'.mswGetPriorityLevel($TICKET->priority).'</span>' : mswGetPriorityLevel($TICKET->priority)),
                                mswGetTicketStatus($TICKET->ticketStatus,$TICKET->replyStatus)
                          )
            );
$tpl->assign('REPLY_DATA', $MSTICKET->getTicketReplies($TICKET->id,mswSpecialChars($TICKET->name)));
$tpl->assign('HIDDEN_FIELDS', $MSTICKET->replyHiddenFields($TICKET));
$tpl->assign('ATTACHMENTS', $MSTICKET->ticketAttachments($eFields,$eString));
$tpl->assign('CUSTOM_FIELDS', $MSFIELDS->build('reply',$TICKET->department));
$tpl->assign('BBCODE', $MSTICKET->bbCode());
$tpl->assign('USERS_IN_DISPUTE', $MSTICKET->mswUsersInDispute($TICKET));
$tpl->assign('DISPUTE_STARTER', mswSpecialChars($TICKET->name));
$tpl->assign('CUSTOM_FIELD_DATA', $MSFIELDS->display($_GET['d']));
$tpl->assign('TICKET_ATTACHMENTS', $MSTICKET->buildAttachmentLinks($TICKET->id,0,'main'));
$tpl->assign('COMMENTS', (isset($_POST['comments']) ? mswSpecialChars($_POST['comments']) : ''));
$tpl->assign('IS_ATTACHMENTS', ($aCount>0 ? 'yes' : 'no'));
$tpl->assign('E_ARRAY', $eFields);
$tpl->assign('ERRORS', $eString);
$tpl->assign('CLOSE_PERMISSIONS', ($TICKET->email==MS_PERMISSIONS ? 'yes' : 'no'));
$tpl->assign('IS_CHECKED', (isset($_POST['close']) ? 'yes' : 'no'));
$tpl->assign('JS',array_map('mswFilterJS',array($msg_newticket19)));
$tpl->assign('TICKET_TEXT', mswTxtParsingEngine($TICKET->comments));
$tpl->assign('MULTIPART', ($SETTINGS->attachment=='yes' ? ' enctype="multipart/form-data"' : ''));
$tpl->assign('POST_PRIVILEGES', $userPostPriv);
$tpl->assign('STAFF_ASSIGN',($TICKET->assignedto ? $MSTICKET->staffAssignment($TICKET->assignedto) : ''));
$tpl->assign('SHOW_IP', ($TICKET->email==MS_PERMISSIONS ? true : false));
$tpl->display('templates/portal-view-dispute.tpl.php');
include(PATH.'control/footer.php');  

?>