<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: ticket-management.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// Access..
if (!in_array('assign',$userAccess) && !in_array('open',$userAccess) && 
    !in_array('close',$userAccess) && !in_array('search',$userAccess) && 
    !in_array('odis',$userAccess) && !in_array('cdis',$userAccess) && 
    $MSTEAM->id!='1') {
  header("Location: index.php?noaccess=1");
  exit;
}

// Change privileges..
if (isset($_GET['ppriv'])) {
  $id  = (int)$_GET['id'];
  $pv  = (int)$_GET['ppriv'];
  $s   = $MSTICKET->ticketPostPrivileges($id,$pv);
  if (DISPUTE_POST_PRIVILEGE_CONFIRMATION) {
    echo $s.'#####'.str_replace('#####','',($s=='yes' ? $msg_javascript137 : $msg_javascript138));
  }
  exit;
}

// Update dispute users..
if (isset($_GET['disUserField']) && isset($_GET['disEmailField'])) {
  $rows = $MSTICKET->editDisputeUser(rawurldecode($_GET['disUserField']),rawurldecode($_GET['disEmailField']));
  echo ($rows>0 ? 'OK' : 'NONE');
  exit;
}

// Update notes..
if (isset($_GET['ticketNotes'])) {
  $rows = $MSTICKET->updateTicketNotes();
  if ($rows>0) {
    echo mswSpecialChars($msg_javascript117);
  } else {
    echo 'no-notes-trigger';
  }
  exit;
}

// Update assigned users..
if (isset($_GET['ticketAssigned'])) {
  $MSTICKET->updateAssignedTicketUsers();
  exit;
}

// View notes..
if (isset($_GET['notes'])) {
  // Update notes in window..
  if (isset($_POST['updateNotes'])) {
    $_GET['ticketNotes'] = $_GET['notes'];
    $MSTICKET->updateTicketNotes();
    $OK = true;
  }
  include(PATH.'templates/system/tickets/tickets-notes.php');
  exit;
}

// Dispute boxes..
if (isset($_GET['addDisputeBox'])) {
  $_GET['addDisputeBox'] = (int)$_GET['addDisputeBox'];
  if ($_GET['addDisputeBox']>0) {
    $tabIndex = 2;
    $html = str_replace(array('{id}','{name}','{email}','{tab}'),
                        array($_GET['addDisputeBox']+1,$msg_viewticket59,$msg_viewticket60,(++$tabIndex)),
                        file_get_contents(PATH.'templates/system/jhtml/dispute.htm')
            );
    echo $html;        
  }
  exit;
}

// Dispute Users..
if (isset($_GET['disputeUsers'])) {
  // Add users..
  if (isset($_POST['process_add'])) {
    $eLanPh  = REL_PATH.'templates/language/'.($_POST['olang'] ? $_POST['olang'] : $SETTINGS->language).'/admin-email/';  
    $added   = 0;
    $people  = array();
    for ($i=0; $i<count($_POST['name']); $i++) {
      if ($_POST['name'][$i] && mswIsValidEmail($_POST['email'][$i]) 
          && !in_array($_POST['oemail'],$_POST['email'])) {
        // Is this email already in the dispute?
        if (mswRowCount('disputes WHERE `userEmail` = \''.$_POST['email'][$i].'\' AND `ticketID` = \''.$_GET['disputeUsers'].'\'')==0) {
          if (LICENCE_VER=='locked') {
            if (mswRowCount('disputes WHERE `ticketID` = \''.$_GET['disputeUsers'].'\'')+1>RESTR_DISPUTE) {
              header("Location: index.php?restr=yes");
              exit;
            }
          }
          $MSTICKET->addDisputeUser($_POST['name'][$i],$_POST['email'][$i]);
          $pass   = '';
          $mailT  = 'dispute-user-current.txt';
          // If user doesn`t exist, generate password and add account..
          if (mswRowCount('portal WHERE `email` = \''.$_POST['email'][$i].'\'')==0) {
            $pass   = substr(md5(uniqid(rand(),1)),3,PASS_CHARS);
            $mailT  = 'dispute-user-new.txt';
            $MSTICKET->addDisputeUserPortal($_POST['name'][$i],$_POST['email'][$i],$pass);
          }
          // Send e-mails..
          $MSMAIL->addTag('{NAME}', $_POST['name'][$i]);
          $MSMAIL->addTag('{USER}', $_POST['oname']);
          $MSMAIL->addTag('{TITLE}', $_POST['otitle']);
          $MSMAIL->addTag('{EMAIL}', $_POST['email'][$i]);
          $MSMAIL->addTag('{PASSWORD}', $pass);
          $MSMAIL->addTag('{ID}',$_GET['disputeUsers']);
          $MSMAIL->sendMSMail($_POST['name'][$i],
                              $_POST['email'][$i],
                              $SETTINGS->website,
                              $SETTINGS->email,
                              str_replace(array('{ticket}','{website}'),
                                          array(mswTicketNumber($_GET['disputeUsers']),
                                                $SETTINGS->website
                                          ),
                                          $msg_viewticket70
                              ),
                              $MSMAIL->template($eLanPh.$mailT)
                   );
          $people[] = $_POST['name'][$i];         
          ++$added;
        }
      }
    }
    // If at least 1 other user is added, lets inform original ticket starter that this is now a dispute if enabled..
    if ($added>0 && !empty($people) && isset($_POST['notify'])) {
      $MSMAIL->addTag('{NAME}', $_POST['oname']);
      $MSMAIL->addTag('{TITLE}', $_POST['otitle']);
      $MSMAIL->addTag('{PEOPLE}', mswTicketCommentsFilter(implode(mswDefineNewline(),$people)));
      $MSMAIL->addTag('{ID}',$_GET['disputeUsers']);
      $MSMAIL->sendMSMail($_POST['oname'],
                          $_POST['oemail'],
                          $SETTINGS->website,
                          $SETTINGS->email,
                          str_replace(array('{ticket}','{website}'),
                                      array(mswTicketNumber($_GET['disputeUsers']),
                                            $SETTINGS->website
                                      ),
                                      $msg_viewticket70
                          ),
                          $MSMAIL->template($eLanPh.'dispute-notification.txt')
               );
    }
    $OK    = true;
  }
  // Update users..
  if (isset($_POST['process_update']) && $_POST['options']!='0') {
    $MSTICKET->updateDisputeUsers();
    $OK2     = true;
  }
  include(PATH.'templates/system/tickets/tickets-dispute-users.php');
  exit;
}

// Preview message..
if (isset($_GET['previewMsg'])) {
  if (isset($_POST['msg'])) {
    $_SESSION['previewBoxText'] = mswCleanData($_POST['msg']);
    echo 'ok|||||'.$msg_script36;
  } else {
    include(PATH.'templates/system/preview.php');
  }
  exit;
}

// For id check against department access..
if (isset($_GET['close']) || isset($_GET['open']) || isset($_GET['lock']) || isset($_GET['attach']) || isset($_GET['attachments'])) {
  if (isset($_GET['attach'])) {
    $_GET['id']  = $_GET['t'];
  } elseif (isset($_GET['attachments'])) {
    $_GET['id']  = $_GET['attachments'];
  } else {
    $_GET['id']  = (isset($_GET['close']) ? $_GET['close'] : (isset($_GET['open']) ? $_GET['open'] : (isset($_GET['lock']) ? $_GET['lock'] : '')));
  }
} else {
  if (isset($_GET['cdis']) || isset($_GET['odis'])) {
    $_GET['id'] = (isset($_GET['odis']) ? $_GET['odis'] : $_GET['cdis']);
  }
}

// Download attachments..
if (isset($_GET['downloadAttachment'])) {
  $MSTICKET->forceDownloadAttachment();
  exit;
}
  
// Delete reply..
if (isset($_GET['delete']) && USER_DEL_PRIV=='yes') {
  $cnt = $MSTICKET->deleteReply();
  if ($cnt>0) {
    $OK2 = true;
  }
}
  
// Add reply..
if (isset($_POST['process_add'])) {
  if ($_POST['comments'] || $_POST['mergeid']) {
    $attachString = '';
    // Add reply..
    $merged  = $MSTICKET->addTicketReply();
    // Load ticket data..
    $TICKET  = mswGetTableData('tickets','id',$merged[1]);
    // Language path..
    $eLanPh  = REL_PATH.'templates/language/'.($TICKET->tickLang ? $TICKET->tickLang : $SETTINGS->language).'/admin-email/';  
    // Add attachments..
    for ($i=0; $i<count($_FILES['attachment']['tmp_name']); $i++) {
      $name  = $_FILES['attachment']['name'][$i];
      $temp  = $_FILES['attachment']['tmp_name'][$i];
      $size  = $_FILES['attachment']['size'][$i];
      if ($name && $temp && $size>0) {
        $R = $MSTICKET->addReplyAttachments($temp,$name,$size,$merged[3],$TICKET->department);
        if (HTML_EMAILS) {
          $attachString .= '<a href="'.$SETTINGS->scriptpath.'/templates/attachments/'.$R.'">'.$name.'</a>'.mswDefineNewline();
        } else {
          $attachString .= $SETTINGS->scriptpath.'/templates/attachments/'.$R.mswDefineNewline();
        }
      }
    }
    // Send mail..
    if (isset($_POST['mail']) && $_POST['mail']=='yes') {
      // Include support team member signature..
      if ($MSTEAM->signature && $MSTEAM->emailSigs=='yes') {
        $MSMAIL->addTag('{SIGNATURE}', mswCleanData($MSTEAM->signature));
      } else {
        $MSMAIL->addTag('{SIGNATURE}', '');
      }
      if (isset($merged[2])) {
        $MSMAIL->addTag('{SUBJECT_OLD}', $merged[2]);
      }
      foreach ($_POST AS $key => $value) {
        if (!is_array($value)) {
          $MSMAIL->addTag('{'.strtoupper($key).'}', mswTicketCommentsFilter($value));
        }  
      }
      // Pass ticket number as custom mail header..
      $MSMAIL->xheaders = array(
        'X-TicketNo' => mswTicketNumber($TICKET->id)
      );
      // If this ticket was opened by imap, the return address should be the imap address..
      if ($TICKET->ipAddresses==$msg_piping7) {
        $IMAP_DEPT = mswGetTableData('imap','im_dept',$TICKET->department);
        if (isset($IMAP_DEPT->im_email)) {
          $MSTEAM->emailFrom = $IMAP_DEPT->im_email;
        }
      }
      switch ($_POST['isDisputed']) {
        case 'no':
        $MSMAIL->addTag('{ATTACHMENTS}', trim($attachString));
        $MSMAIL->addTag('{NAME}', $TICKET->name);
        $MSMAIL->addTag('{TICKET}', mswTicketNumber($TICKET->id));
        $MSMAIL->addTag('{SUBJECT}', $TICKET->subject);
        $MSMAIL->addTag('{DEPT}', mswGetDepartmentName($TICKET->department));
        $MSMAIL->addTag('{PRIORITY}', mswGetPriorityLevel($TICKET->priority));
        $MSMAIL->addTag('{STATUS}', mswGetTicketStatus($TICKET->ticketStatus,$TICKET->replyStatus));
        $MSMAIL->addTag('{USER}',($MSTEAM->nameFrom && COMMENTS_BY_TXT ? $MSTEAM->nameFrom : $MSTEAM->name));
        $MSMAIL->addTag('{ID}',$TICKET->id);
        $MSMAIL->sendMSMail($TICKET->name,
                            $TICKET->email,
                            ($MSTEAM->nameFrom ? $MSTEAM->nameFrom : $MSTEAM->name),
                            ($MSTEAM->emailFrom ? $MSTEAM->emailFrom : $MSTEAM->email),
                            str_replace(array('{ticket}','{website}'),
                                        array(mswTicketNumber($TICKET->id),
                                              $SETTINGS->website
                                        ),
                                        $msg_viewticket49
                            ),
                            $MSMAIL->template($eLanPh.'ticket-reply'.($merged[0]=='yes' ? '-and-merged' : '').'.txt')
                 );      
        break;
        case 'yes':
        $MSMAIL->addTag('{ATTACHMENTS}', trim($attachString));
        $MSMAIL->addTag('{NAME}', $TICKET->name);
        $MSMAIL->addTag('{TICKET}', mswTicketNumber($TICKET->id));
        $MSMAIL->addTag('{SUBJECT}', $TICKET->subject);
        $MSMAIL->addTag('{DEPT}', mswGetDepartmentName($TICKET->department));
        $MSMAIL->addTag('{PRIORITY}', mswGetPriorityLevel($TICKET->priority));
        $MSMAIL->addTag('{STATUS}', mswGetTicketStatus($TICKET->ticketStatus,$TICKET->replyStatus));
        $MSMAIL->addTag('{USER}',($MSTEAM->nameFrom && COMMENTS_BY_TXT ? $MSTEAM->nameFrom : $MSTEAM->name));
        $MSMAIL->addTag('{ID}',$TICKET->id);
        $MSMAIL->sendMSMail($TICKET->name,
                            $TICKET->email,
                            ($MSTEAM->nameFrom ? $MSTEAM->nameFrom : $MSTEAM->name),
                            ($MSTEAM->emailFrom ? $MSTEAM->emailFrom : $MSTEAM->email),
                            str_replace(array('{ticket}','{website}'),
                                        array(mswTicketNumber($TICKET->id),
                                              $SETTINGS->website
                                        ),
                                        $msg_viewticket49
                            ),
                            $MSMAIL->template($eLanPh.'dispute-reply'.($merged[0]=='yes' ? '-and-merged' : '').'.txt')
                 );
        // Also send to other users in dispute...
        $mswUsersInDispute = $MSTICKET->getDisputeUsers($TICKET->id);
        if (!empty($mswUsersInDispute)) {
          foreach ($mswUsersInDispute AS $u) {
            $split = explode('#####',$u);
            $MSMAIL->addTag('{NAME}', $split[0]);
            $MSMAIL->sendMSMail($split[0],
                                $split[1],
                                ($MSTEAM->nameFrom ? $MSTEAM->nameFrom : $MSTEAM->name),
                                ($MSTEAM->emailFrom ? $MSTEAM->emailFrom : $MSTEAM->email),
                                str_replace(array('{ticket}','{website}'),
                                            array(mswTicketNumber($TICKET->id),
                                                  $SETTINGS->website
                                            ),
                                            $msg_viewticket49
                                ),
                                $MSMAIL->template($eLanPh.'dispute-reply'.($merged[0]=='yes' ? '-and-merged' : '').'.txt')
                     ); 
          }
        }  
        break;
      }           
    }
    $_GET['id']  = $merged[1];
    if ($_POST['comments']) {
      $OK   = true;
    } else {
      $OK3  = true;
    }
  } else {
    header("Location: index.php?p=view-ticket&id=".$_GET['id']);
    exit;
  }
}
  
// Load ticket data..
if (!isset($SUPTICK->id)) {
  $SUPTICK = mswGetTableData('tickets','id',$_GET['id']);
}
  
// Checks..
if (!isset($SUPTICK->name)) {
  header("Location: index.php");
  exit;
}
  
// Update status..
if (isset($_GET['close']) || isset($_GET['open']) || isset($_GET['lock'])) {
  $MSTICKET->updateTicketStatus();
  header("Location: index.php?p=view-ticket&id=".$_GET['id']);
  exit;
}

// Update dispute..
if (isset($_GET['cdis']) || isset($_GET['odis'])) {
  $_GET['id'] = (isset($_GET['odis']) ? $_GET['odis'] : $_GET['cdis']);
  $MSTICKET->updateTicketDisputeStatus();
  if (isset($_GET['cdis'])) {
    $MSTICKET->removeDisputeUsersFromTicket();
  }
  header("Location: index.php?p=view-ticket&id=".$_GET['id']);
  exit;
}
  
// Department check.. 
if ($MSTEAM->id!='1' && !in_array($SUPTICK->department,$userDeptAccess)) {
  if ($cmd=='edit-ticket') {
    $NO_ACCESS = true;
  } else {
    header("Location: index.php");
    exit;
  }
}
  
// View attachments..
if (isset($_GET['attach']) || isset($_GET['attachments'])) {
  if (isset($_POST['process'])) {
    if (!empty($_POST['id']) && USER_DEL_PRIV=='yes') {
      $MSTICKET->deleteAttachments();
    }
    header("Location: index.php?p=view-ticket&".(isset($_GET['attachments']) ? 'attachments='.$_GET['attachments'] : 't='.$_GET['t'].'&attach='.$_GET['attach']));
    exit;
  }
  include(PATH.'templates/system/tickets/tickets-attachments.php');
  exit;
}
  
// Edit reply..
if (isset($_GET['edit']) || isset($_POST['edit'])) {
  if (isset($_POST['process'])) {
    $MSTICKET->updateTicketReply();
    header("Location: index.php?p=view-ticket&id=".$_GET['id']."&edit=".$_POST['edit']."&ok=1");
    exit;
  }
  include(PATH.'templates/system/tickets/tickets-edit-reply.php');
  exit;
}
  
// Merge ticket..
if ($cmd=='merge-ticket') {
  include(PATH.'templates/system/tickets/tickets-merge.php');
  exit;
}
  
// Edit ticket..
if ($cmd=='edit-ticket') {
  if (isset($_POST['process'])) {
    $MSTICKET->updateSupportTicket();
    // Send to team members..
    $MSMAIL->addTag('{MEMBER}', $MSTEAM->name);
    $MSMAIL->addTag('{TICKET}', mswTicketNumber($SUPTICK->id));
    $MSMAIL->addTag('{SUBJECT}', $_POST['subject']);
    $MSMAIL->addTag('{DEPT}', mswGetDepartmentName($_POST['department']));
    $MSMAIL->addTag('{PRIORITY}', mswGetPriorityLevel($_POST['priority']));
    $MSMAIL->addTag('{STATUS}', mswGetTicketStatus($SUPTICK->ticketStatus,$SUPTICK->replyStatus));
    $MSMAIL->addTag('{COMMENTS}', mswTicketCommentsFilter($_POST['comments']));
    $MSMAIL->addTag('{MEM_COMMENTS}', ($_POST['explain'] ? mswTicketCommentsFilter($_POST['explain']) : 'N/A'));
    $MSMAIL->addTag('{ATTACHMENTS}', mswGetAttachments($SUPTICK->id));
    $MSMAIL->addTag('{ID}',$SUPTICK->id);
    // Send notification..
    if ($_POST['explain'] && !empty($userDeptAccess)) {
     $q_users = mysql_query("SELECT *,`".DB_PREFIX."users`.`name` AS person FROM ".DB_PREFIX."userdepts
                 LEFT JOIN ".DB_PREFIX."users
                 ON ".DB_PREFIX."userdepts.userID      = ".DB_PREFIX."users.id
                 WHERE `userID`                   NOT IN (1,".$MSTEAM->id.")
                 AND `notify`                          = 'yes'
                 AND `".DB_PREFIX."userdepts`.`deptID` = '{$_POST['department']}'
                 GROUP BY `".DB_PREFIX."users`.`name`,`".DB_PREFIX."users`.`email`
                 ORDER BY `".DB_PREFIX."users`.`name`
                 ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      while ($USERS = mysql_fetch_object($q_users)) {
        $MSMAIL->addTag('{NAME}', $USERS->person);
        $MSMAIL->sendMSMail($USERS->person,
                            $USERS->email,
                            $SETTINGS->website,
                            $SETTINGS->email,
                            str_replace(array('{ticket}','{website}'),
                                        array(mswTicketNumber($SUPTICK->id),$SETTINGS->website),
                                        $msg_viewticket52
                            ),
                            $MSMAIL->template(LANG_PATH.'ticket-edit-notification.txt')
                  );
       } 
      // Now send to global user..
      $GLOBAL = mswGetTableData('users','id',1,' AND `notify` = \'yes\'');
      if (isset($GLOBAL->name)) {
        $MSMAIL->addTag('{NAME}', $GLOBAL->name);
        $MSMAIL->sendMSMail($GLOBAL->name,
                            $GLOBAL->email,
                            $SETTINGS->website,
                            $SETTINGS->email,
                            str_replace(array('{ticket}','{website}'),
                                        array(mswTicketNumber($SUPTICK->id),$SETTINGS->website),
                                        $msg_viewticket52
                            ),
                            $MSMAIL->template(LANG_PATH.'ticket-edit-notification.txt')
                );
      }
    }
    // Silent notification..
    if (ENABLE_SILENT_EDIT_NOTIFICATION) {
      $GLOBAL = mswGetTableData('users','id',1);
      $MSMAIL->addTag('{NAME}', $GLOBAL->name);
      if (ENABLE_SILENT_EDIT_NOTIFICATION_EMAIL) {
        $split = array_map('trim',explode(',',ENABLE_SILENT_EDIT_NOTIFICATION_EMAIL));
        foreach ($split AS $e) {
          $MSMAIL->sendMSMail($GLOBAL->name,
                              $e,
                              $SETTINGS->website,
                              $SETTINGS->email,
                              str_replace(array('{ticket}','{website}'),
                                          array(mswTicketNumber($SUPTICK->id),$SETTINGS->website),
                                          $msg_viewticket52
                              ),
                              $MSMAIL->template(LANG_PATH.'ticket-edit-notification.txt')
                   );
        }
      } else {
        $MSMAIL->sendMSMail($GLOBAL->name,
                            $GLOBAL->email,
                            $SETTINGS->website,
                            $SETTINGS->email,
                            str_replace(array('{ticket}','{website}'),
                                        array(mswTicketNumber($SUPTICK->id),$SETTINGS->website),
                                        $msg_viewticket52
                            ),
                            $MSMAIL->template(LANG_PATH.'ticket-edit-notification.txt')
                 );
      }      
    }
    $OK = true;
  }
  include(PATH.'templates/system/tickets/tickets-edit.php');
  exit;
}
  
$title        = str_replace('{ticket}',mswTicketNumber($_GET['id']),($SUPTICK->isDisputed=='yes' ? $msg_viewticket80 : $msg_viewticket));
$loadGreyBox  = true;  
$loadAjax     = true;
$loadJQAPI    = true;
     
include(PATH.'templates/header.php');
include(PATH.'templates/system/tickets/tickets-view'.($SUPTICK->isDisputed=='yes' ? '-disputed' : '').'.php');
include(PATH.'control/system/core/footer.php');

?>