<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: imap.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

$pipes = array(0,0,0,0);
if (IMAP_URL_PARAMETER=='') {
  echo $msg_piping5;
  exit;
}

// Check imap..
if (!function_exists('imap_open')) {
  die('PHP <a href="http://php.net/manual/en/book.imap.php">imap functions</a> not found! Your server must be compiled with imap support for this function to run!');
}

// Memory/timeouts..
if (IMAP_MEMORY_OVERRIDE) {
  @ini_set('memory_limit',IMAP_MEMORY_OVERRIDE);
}
if (IMAP_TIMEOUT_OVERRIDE>0) {
  @set_time_limit(IMAP_TIMEOUT_OVERRIDE);
}

$pipeID    = (isset($_GET[IMAP_URL_PARAMETER]) ? $_GET[IMAP_URL_PARAMETER] : (isset($imapPipeID) ? $imapPipeID : ''));
$langPref  = (isset($_GET['lang']) && is_dir(PATH.'templates/language/'.$_GET['lang']) ? $_GET['lang'] : (defined('IMAP_LANG') ? IMAP_LANG : $SETTINGS->language));

// Legacy check..
if (!is_numeric($pipeID) || $pipeID=='yes' || $pipeID=='') {
  $pipeID = '1';
}

// Get imap data..
$IMAP_DATA = mswGetTableData('imap','id',$pipeID);

if (!isset($IMAP_DATA->id)) {
  die($pipeID.' is an invalid imap id. Check url');
}

if ($IMAP_DATA->im_piping=='no') {
  die('Imap account not active. Please enable in settings');
}

$MSPIPE            = new emailPipe($IMAP_DATA);
$MSPIPE->settings  = $SETTINGS;
$mailbox = $MSPIPE->connectToMailBox();
if ($mailbox) {
  $count = imap_num_msg($mailbox);
  $loop  = ($count>$IMAP_DATA->im_messages ? $IMAP_DATA->im_messages : $count);
  // Process messages in reverse order so last message is latest..
  for ($i=$loop; $i>0; $i--) {
    $replyID       = 0;
    $attachString  = '';
    $userPass      = '';
    $aCount        = 0;
    $message       = $MSPIPE->readMailBox($mailbox,$i);
    // Assign post vars..
    $_POST['dept']       = $IMAP_DATA->im_dept;
    $_POST['name']       = $message['from'];
    $_POST['email']      = $message['email'];
    $_POST['subject']    = $MSPIPE->decodeString($message['subject']);
    $_POST['priority']   = $IMAP_DATA->im_priority;
    $_POST['quoteBody']  = trim(substr($message['body'],0,30)); // Experimental..
    // Ignore blank e-mails..
    if ($message['body']!='') {
      $pipes[0] = ++$pipes[0];
      // Is this a brand new message or a reply..
      if ($message['ticketID'][0]=='no') {
        // Department preferences..
        $MAN_ASSIGN = mswGetDepartmentName($_POST['dept'],true);
        // Is this first ticket from user email..
        if (!$MSTICKET->isPortal($message['email'])) {
          $userPass = $MSTICKET->createPortalLogin($message['email']);
        }
        $_POST['comments']  = $MSPIPE->decodeString($message['body']);
        $thisTicket         = $MSTICKET->openNewTicket(true,false,$MAN_ASSIGN->manual_assign);
        $mailSubject        = '[#'.mswTicketNumber($thisTicket).'] '.$msg_newticket29;
        $mailTemplate       = PATH.'templates/language/'.$langPref.'/email/new-ticket-notification-imap.txt';
        $pipes[1]           = ++$pipes[1];
        // Mail tags..
        $MSMAIL->addTag('{TICKET}', mswTicketNumber($thisTicket));
        $MSMAIL->addTag('{SUBJECT}', $_POST['subject']);
        $MSMAIL->addTag('{EMAIL}', $_POST['email']);
        $MSMAIL->addTag('{NAME}', $_POST['name']);
        $MSMAIL->addTag('{DEPT}', mswGetDepartmentName($_POST['dept']));
        $MSMAIL->addTag('{PRIORITY}', mswGetPriorityLevel($_POST['priority']));
        $MSMAIL->addTag('{PASSWORD}', $userPass);
        // Send auto responders for new tickets..
        $MSMAIL->sendMSMail($_POST['name'],
                            $_POST['email'],
                            $SETTINGS->website,
                            $IMAP_DATA->im_email,
                            '[#'.mswTicketNumber($thisTicket).'] '.$msg_newticket29,
                            $MSMAIL->template(PATH.'templates/language/'.$langPref.'/email/'.($userPass ? 'first-' : '').'auto-responder-imap.txt')
                 );
        define('ADMIN_SEND','yes');         
      } else {
        $_POST['comments']  = $MSPIPE->decodeString($message['body']);
        $thisTicket         = $message['ticketID'][1];
        $_GET['t']          = $message['ticketID'][1];
        $replyID            = $MSTICKET->addTicketReply(true);
        $mailSubject        = '[#'.mswTicketNumber($thisTicket).'] '.$msg_newticket29;
        $mailTemplate       = PATH.'templates/language/'.$langPref.'/email/ticket-reply-notification-imap.txt';
        $pipes[2]           = ++$pipes[2];
        $TICKET_INFO        = mswGetTableData('tickets','id',$_GET['t']); 
      }
      // Add attachments..
      if ($IMAP_DATA->im_attach=='yes') {
        $attachments = $MSPIPE->readAttachments($mailbox,$i);
        if (!empty($attachments) && LICENCE_VER=='locked' && count($attachments)>RESTR_ATTACH) {
          $countOfBoxes = RESTR_ATTACH;
        }
        if (!empty($attachments)) {
          for ($j=0; $j<(isset($countOfBoxes) ? $countOfBoxes : count($attachments)); $j++) {
            ++$aCount;
            // Check for valid file type..
            if ($MSTICKET->checkFileType($attachments[$aCount]['file'])) {
              $n       = $MSTICKET->getAttachmentName($attachments[$aCount]['ext'],$thisTicket,$attachments[$aCount]['file'],$replyID,($j+0));
              // At this point we must upload the file to get file size..
              $folder  = $MSPIPE->uploadEmailAttachment($n,$attachments[$aCount]['attachment']);
              // If file upload now exists, check file size..
              if (file_exists($SETTINGS->attachpath.'/'.$folder.$n)) {
                if ($SETTINGS->maxsize>0 && filesize($SETTINGS->attachpath.'/'.$folder.$n)>$SETTINGS->maxsize) {
                  @unlink($SETTINGS->attachpath.'/'.$folder.$n);
                } else {
                  $s             = filesize($SETTINGS->attachpath.'/'.$folder.$n);
                  $attachString .= $SETTINGS->scriptpath.'/templates/attachments/'.$folder.$n.' ('.mswFileSizeConversion($s).')'.mswDefineNewline();
                  $pipes[3]      = ++$pipes[3];
                  // Add attachment data to database..
                  $MSPIPE->addAttachmentToDB($thisTicket,$replyID,$n,$s);
                }
              }
            }
          }
        }
      }
      // Build mail tags..
      $MSMAIL->addTag('{NAME}', $_POST['name']);
      $MSMAIL->addTag('{TICKET}', mswTicketNumber($thisTicket));
      $MSMAIL->addTag('{SUBJECT}', $_POST['subject']);
      $MSMAIL->addTag('{EMAIL}', $_POST['email']);
      $MSMAIL->addTag('{COMMENTS}', (function_exists('quoted_printable_decode') ? quoted_printable_decode($_POST['comments']) : $_POST['comments']));
      $MSMAIL->addTag('{DEPT}', mswGetDepartmentName($_POST['dept']));
      $MSMAIL->addTag('{PRIORITY}', mswGetPriorityLevel($_POST['priority']));
      $MSMAIL->addTag('{STATUS}', $msg_showticket23);
      $MSMAIL->addTag('{ATTACHMENTS}', ($attachString ? trim($attachString) : $msg_script17));
      $MSMAIL->addTag('{IS_EMAIL}',$msg_script4);
      // Send message to support team if manual assign is off..
      // This doesn`t include global user..
      if (isset($MAN_ASSIGN->manual_assign) && $MAN_ASSIGN->manual_assign=='no') {
        $q_users = mysql_query("SELECT *,".DB_PREFIX."users.name AS person FROM ".DB_PREFIX."userdepts
                   LEFT JOIN ".DB_PREFIX."departments
                   ON ".DB_PREFIX."userdepts.deptID  = ".DB_PREFIX."departments.id
                   LEFT JOIN ".DB_PREFIX."users
                   ON ".DB_PREFIX."userdepts.userID  = ".DB_PREFIX."users.id
                   WHERE `deptID`  = '{$_POST['dept']}'
                   AND `userID`   != '1'
                   AND `notify`    = 'yes'
                   ORDER BY ".DB_PREFIX."users.name
                   ");
      } else {
        if (isset($TICKET_INFO->assignedto) && $TICKET_INFO->assignedto) {
          $q_users = mysql_query("SELECT *,".DB_PREFIX."users.name AS person FROM ".DB_PREFIX."userdepts
                     LEFT JOIN ".DB_PREFIX."departments
                     ON ".DB_PREFIX."userdepts.deptID  = ".DB_PREFIX."departments.id
                     LEFT JOIN ".DB_PREFIX."users
                     ON ".DB_PREFIX."userdepts.userID  = ".DB_PREFIX."users.id
                     WHERE `userID`  IN (".$TICKET->assignedto.")
                     AND `notify`     = 'yes'
                     ORDER BY ".DB_PREFIX."users.name
                     ");
        } else {
          $q_users = mysql_query("SELECT *,".DB_PREFIX."users.name AS person FROM ".DB_PREFIX."userdepts
                     LEFT JOIN ".DB_PREFIX."departments
                     ON ".DB_PREFIX."userdepts.deptID  = ".DB_PREFIX."departments.id
                     LEFT JOIN ".DB_PREFIX."users
                     ON ".DB_PREFIX."userdepts.userID  = ".DB_PREFIX."users.id
                     WHERE `deptID`  = '{$_POST['dept']}'
                     AND `userID`   != '1'
                     AND `notify`    = 'yes'
                     ORDER BY ".DB_PREFIX."users.name
                     ");
        }
      }
      while ($USERS = mysql_fetch_object($q_users)) {
        $MSMAIL->sendMSMail($USERS->person,
                            $USERS->email,
                            $SETTINGS->website,
                            $SETTINGS->email,
                            $mailSubject,
                            $MSMAIL->template($mailTemplate)
                 );
      }
      // Now send to global user..
      if (defined('ADMIN_SEND')) {
        $GLOBAL = mswGetTableData('users','id',1,' AND `notify` = \'yes\'');
        if (isset($GLOBAL->name)) {
          $MSMAIL->sendMSMail($GLOBAL->name,
                              $GLOBAL->email,
                              $SETTINGS->website,
                              $SETTINGS->email,
                              $mailSubject,
                              $MSMAIL->template($mailTemplate)
                   );
        }
      }
    }
    // Are we moving message..
    if ($IMAP_DATA->im_move && $IMAP_DATA->im_protocol=='imap') {
      $MSPIPE->moveMail($mailbox,$i);
    } else {
      // Flag message for deletion...
      $MSPIPE->flagMessage($mailbox,$i);
    }
  }
  // Close mailbox..closes mailbox and removes messages marked for deletion..
  $MSPIPE->closeMailbox($mailbox);
  // Is cron output required..
  if (DISPLAY_IMAP_CRON_OUTPUT) {
    echo str_replace(array('{datetime}','{count}','{count2}','{count3}'),
                     array(mswDateDisplay(0,$SETTINGS->dateformat).' @ '.mswTimeDisplay(0,$SETTINGS->timeformat),
                           number_format($pipes[1]),
                           number_format($pipes[2]),
                           number_format($pipes[3])
                     ),
                     $msg_piping8
        );
  }
}

?>