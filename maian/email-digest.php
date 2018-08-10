<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: email-digest.php
  Description: Email Digest

++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

// ERROR REPORTING..
include(dirname(__FILE__).'/control/error-reporting.php');

define('PATH', dirname(__FILE__).'/');
define('PARENT',1);
define('EMAIL_DIGEST',1);

include(PATH.'control/system/core/init.php');

// OMITION LIST..
$omit = array();
if (OMIT_USERS_EMAIL_DIGEST) {
  $omit = explode(',',OMIT_USERS_EMAIL_DIGEST);
}

// AUTO CLOSE TICKETS..
include(PATH.'close-tickets.php');

// LOOP USERS..
$qU = mysql_query("SELECT * FROM ".DB_PREFIX."users
      WHERE `notify`    = 'yes'
      ".(!empty($omit) ? 'AND `id` NOT IN ('.implode(',',$omit).')' : '')."
      ORDER BY `name`
      ");
while ($USERS = mysql_fetch_object($qU)) {

  // Build..
  $emailDigest = array('','','','','','','');
  $counts      = array(0,0,0);
  $dept        = array();

  // User departments..
  if ($USERS->id!='1') {
    $qUD = mysql_query("SELECT * FROM ".DB_PREFIX."userdepts 
           WHERE userID = '{$USERS->id}'
           ");
    while ($UD = mysql_fetch_object($qUD)) {
      $dept[] = $UD->deptID;
    }
  }

  // Awaiting assignment..
  $q = mysql_query("SELECT * FROM ".DB_PREFIX."tickets 
       WHERE `assignedto` = 'waiting'
       ".(!empty($dept) ? 'AND `department` IN ('.implode(',',$dept).')' : '')."
       ".ALL_TICKETS_ORDER
       );
  if (mysql_num_rows($q)>0) {
    while ($TICKETS = mysql_fetch_object($q)) {
      ++$counts[2];
      $link = '';
      if (EMAIL_DIGEST_LINKS) {
        $link  = mswDefineNewline();
        if (HTML_EMAILS) {
          $link .= '<a href="'.$SETTINGS->scriptpath.'/'.$SETTINGS->afolder.'/?ticket='.$TICKETS->id.'">'.$msg_edigest7.'</a>';
        } else {
          $link .= $SETTINGS->scriptpath.'/'.$SETTINGS->afolder.'/?ticket='.$TICKETS->id;
        }
      }
      $qLT1  = mysql_query("SELECT * FROM ".DB_PREFIX."replies 
               WHERE `ticketID` = '{$TICKETS->id}' 
               ORDER BY id DESC 
               LIMIT 1
               ")
               or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      $LT1   = mysql_fetch_object($qLT1);
      $emailDigest[6] .= mswCleanData($TICKETS->subject).mswDefineNewline();
      $emailDigest[6] .= str_replace(array('{name}','{priority}','{updated}'),
                                     array(mswSpecialChars($TICKETS->name),
                                           mswGetPriorityLevel($TICKETS->priority),
                                           (isset($LT1->ts) ? mswDateDisplay($LT1->ts,$SETTINGS->dateformat) : 'N/A')
                                     ),
                                     $msg_edigest5
                         ).$link.mswDefineNewline().mswDefineNewline();
    }
  } else {
    $emailDigest[6] = $msg_edigest;
  }
  
  // Whitespace cleanup..
  $emailDigest[6] = rtrim($emailDigest[6]);

  // New tickets..
  $q = mysql_query("SELECT * FROM ".DB_PREFIX."tickets 
       WHERE `replyStatus` IN ('start') 
       AND `ticketStatus`   = 'open' 
       AND `isDisputed`     = 'no'
       AND `assignedto`    != 'waiting'
       ".(!empty($dept) ? 'AND `department` IN ('.implode(',',$dept).')' : '')."
       ".ALL_TICKETS_ORDER
       );
  if (mysql_num_rows($q)>0) {
    while ($TICKETS = mysql_fetch_object($q)) {
      ++$counts[0];
      $link = '';
      if (EMAIL_DIGEST_LINKS) {
        $link  = mswDefineNewline();
        if (HTML_EMAILS) {
          $link .= '<a href="'.$SETTINGS->scriptpath.'/'.$SETTINGS->afolder.'/?ticket='.$TICKETS->id.'">'.$msg_edigest7.'</a>';
        } else {
          $link .= $SETTINGS->scriptpath.'/'.$SETTINGS->afolder.'/?ticket='.$TICKETS->id;
        }
      }
      $qLT1  = mysql_query("SELECT * FROM ".DB_PREFIX."replies 
               WHERE `ticketID` = '{$TICKETS->id}' 
               ORDER BY id DESC 
               LIMIT 1
               ")
               or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      $LT1   = mysql_fetch_object($qLT1);
      $emailDigest[0] .= mswCleanData($TICKETS->subject).mswDefineNewline();
      $emailDigest[0] .= str_replace(array('{name}','{priority}','{updated}'),
                                     array(mswSpecialChars($TICKETS->name),
                                           mswGetPriorityLevel($TICKETS->priority),
                                           (isset($LT1->ts) ? mswDateDisplay($LT1->ts,$SETTINGS->dateformat) : 'N/A')
                                     ),
                                     $msg_edigest5
                         ).$link.mswDefineNewline().mswDefineNewline();
    }
  } else {
    $emailDigest[0] = $msg_edigest;
  }
  
  // Whitespace cleanup..
  $emailDigest[0] = rtrim($emailDigest[0]);

  // Tickets - Awaiting admin response..
  $q = mysql_query("SELECT * FROM ".DB_PREFIX."tickets 
       WHERE `replyStatus` IN ('admin') 
       AND `ticketStatus`   = 'open' 
       AND `isDisputed`     = 'no'
       AND `assignedto`    != 'waiting'
       ".(!empty($dept) ? 'AND `department` IN ('.implode(',',$dept).')' : '')."
       ".ALL_TICKETS_ORDER
       );
  if (mysql_num_rows($q)>0) {
    while ($TICKETS = mysql_fetch_object($q)) {
      ++$counts[0];
      $link = '';
      if (EMAIL_DIGEST_LINKS) {
        $link  = mswDefineNewline();
        if (HTML_EMAILS) {
          $link .= '<a href="'.$SETTINGS->scriptpath.'/'.$SETTINGS->afolder.'/?ticket='.$TICKETS->id.'">'.$msg_edigest7.'</a>';
        } else {
          $link .= $SETTINGS->scriptpath.'/'.$SETTINGS->afolder.'/?ticket='.$TICKETS->id;
        }
      }
      $qLT2  = mysql_query("SELECT * FROM ".DB_PREFIX."replies 
               WHERE `ticketID` = '{$TICKETS->id}' 
               ORDER BY id DESC 
               LIMIT 1
               ")
               or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      $LT2   = mysql_fetch_object($qLT2);
      $emailDigest[1] .= mswCleanData($TICKETS->subject).mswDefineNewline();
      $emailDigest[1] .= str_replace(array('{name}','{priority}','{updated}'),
                                     array(mswSpecialChars($TICKETS->name),
                                           mswGetPriorityLevel($TICKETS->priority),
                                           (isset($LT2->ts) ? mswDateDisplay($LT2->ts,$SETTINGS->dateformat) : 'N/A')
                                     ),
                                     $msg_edigest5
                         ).$link.mswDefineNewline().mswDefineNewline();
    }
  } else {
    $emailDigest[1] = $msg_edigest;
  }
  
  // Whitespace cleanup..
  $emailDigest[1] = rtrim($emailDigest[1]);

  // Tickets - Awaiting visitor response..
  $q = mysql_query("SELECT * FROM ".DB_PREFIX."tickets 
       WHERE `replyStatus` IN ('visitor') 
       AND `ticketStatus`   = 'open' 
       AND `isDisputed`     = 'no'
       AND `assignedto`    != 'waiting'
       ".(!empty($dept) ? 'AND `department` IN ('.implode(',',$dept).')' : '')."
       ".ALL_TICKETS_ORDER
       );
  if (mysql_num_rows($q)>0) {
    while ($TICKETS = mysql_fetch_object($q)) {
      ++$counts[0];
      $link = '';
      if (EMAIL_DIGEST_LINKS) {
        $link  = mswDefineNewline();
        if (HTML_EMAILS) {
          $link .= '<a href="'.$SETTINGS->scriptpath.'/'.$SETTINGS->afolder.'/?ticket='.$TICKETS->id.'">'.$msg_edigest7.'</a>';
        } else {
          $link .= $SETTINGS->scriptpath.'/'.$SETTINGS->afolder.'/?ticket='.$TICKETS->id;
        }
      }
      $qLT3  = mysql_query("SELECT * FROM ".DB_PREFIX."replies 
               WHERE `ticketID` = '{$TICKETS->id}' 
               ORDER BY id DESC 
               LIMIT 1
               ")
               or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      $LT3   = mysql_fetch_object($qLT3);
      $emailDigest[2] .= mswCleanData($TICKETS->subject).mswDefineNewline();
      $emailDigest[2] .= str_replace(array('{name}','{priority}','{updated}'),
                                     array(mswSpecialChars($TICKETS->name),
                                           mswGetPriorityLevel($TICKETS->priority),
                                           (isset($LT3->ts) ? mswDateDisplay($LT3->ts,$SETTINGS->dateformat) : 'N/A')
                                     ),
                                     $msg_edigest5
                         ).$link.mswDefineNewline().mswDefineNewline();
    }
  } else {
    $emailDigest[2] = $msg_edigest;
  }
  
  // Whitespace cleanup..
  $emailDigest[2] = rtrim($emailDigest[2]);
  
  // New disputes..
  $q = mysql_query("SELECT * FROM ".DB_PREFIX."tickets 
       WHERE `replyStatus` IN ('start') 
       AND `ticketStatus`   = 'open' 
       AND `isDisputed`     = 'yes'
       AND `assignedto`    != 'waiting'
       ".(!empty($dept) ? 'AND `department` IN ('.implode(',',$dept).')' : '')."
       ".ALL_DISPUTES_ORDER
       );
  if (mysql_num_rows($q)>0) {
    while ($TICKETS = mysql_fetch_object($q)) {
      $tcnt            = number_format(mswRowCount('disputes WHERE ticketID = \''.$TICKETS->id.'\''));
      ++$counts[1];
      $link = '';
      if (EMAIL_DIGEST_LINKS) {
        $link  = mswDefineNewline();
        if (HTML_EMAILS) {
          $link .= '<a href="'.$SETTINGS->scriptpath.'/'.$SETTINGS->afolder.'/?ticket='.$TICKETS->id.'">'.$msg_edigest7.'</a>';
        } else {
          $link .= $SETTINGS->scriptpath.'/'.$SETTINGS->afolder.'/?ticket='.$TICKETS->id;
        }
      }
      $qLT4  = mysql_query("SELECT * FROM ".DB_PREFIX."replies 
               WHERE `ticketID` = '{$TICKETS->id}' 
               ORDER BY id DESC 
               LIMIT 1
               ")
               or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      $LT4   = mysql_fetch_object($qLT4);
      $emailDigest[3] .= mswCleanData($TICKETS->subject).mswDefineNewline();
      $emailDigest[3] .= str_replace(array('{name}','{priority}','{count}','{updated}'),
                                     array(mswSpecialChars($TICKETS->name),
                                           mswGetPriorityLevel($TICKETS->priority),
                                           ($tcnt+1),
                                           (isset($LT4->ts) ? mswDateDisplay($LT4->ts,$SETTINGS->dateformat) : 'N/A')
                                     ),
                                     $msg_edigest6
                         ).$link.mswDefineNewline().mswDefineNewline();
    }
  } else {
    $emailDigest[3] = $msg_edigest2;
  }
  
  // Whitespace cleanup..
  $emailDigest[3] = rtrim($emailDigest[3]);
  
  // Disputes - Awaiting admin response..
  $q = mysql_query("SELECT * FROM ".DB_PREFIX."tickets 
       WHERE `replyStatus` IN ('admin') 
       AND `ticketStatus`   = 'open' 
       AND `isDisputed`     = 'yes'
       AND `assignedto`    != 'waiting'
       ".(!empty($dept) ? 'AND `department` IN ('.implode(',',$dept).')' : '')."
       ".ALL_DISPUTES_ORDER
       );
  if (mysql_num_rows($q)>0) {
    while ($TICKETS = mysql_fetch_object($q)) {
      $tcnt            = number_format(mswRowCount('disputes WHERE ticketID = \''.$TICKETS->id.'\''));
      ++$counts[1];
      $link = '';
      if (EMAIL_DIGEST_LINKS) {
        $link  = mswDefineNewline();
        if (HTML_EMAILS) {
          $link .= '<a href="'.$SETTINGS->scriptpath.'/'.$SETTINGS->afolder.'/?ticket='.$TICKETS->id.'">'.$msg_edigest7.'</a>';
        } else {
          $link .= $SETTINGS->scriptpath.'/'.$SETTINGS->afolder.'/?ticket='.$TICKETS->id;
        }
      }
      $qLT5  = mysql_query("SELECT * FROM ".DB_PREFIX."replies 
               WHERE `ticketID` = '{$TICKETS->id}' 
               ORDER BY id DESC 
               LIMIT 1
               ")
               or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      $LT5   = mysql_fetch_object($qLT5);
      $emailDigest[4] .= mswCleanData($TICKETS->subject).mswDefineNewline();
      $emailDigest[4] .= str_replace(array('{name}','{priority}','{count}','{updated}'),
                                     array(mswSpecialChars($TICKETS->name),
                                           mswGetPriorityLevel($TICKETS->priority),
                                           ($tcnt+1),
                                           (isset($LT5->ts) ? mswDateDisplay($LT5->ts,$SETTINGS->dateformat) : 'N/A')
                                     ),
                                     $msg_edigest6
                         ).$link.mswDefineNewline().mswDefineNewline();
    }
  } else {
    $emailDigest[4] = $msg_edigest2;
  }
  
  // Whitespace cleanup..
  $emailDigest[4] = rtrim($emailDigest[4]);
  
  // Disputes - Awaiting visitor response..
  $q = mysql_query("SELECT * FROM ".DB_PREFIX."tickets 
       WHERE `replyStatus` IN ('visitor') 
       AND `ticketStatus`   = 'open' 
       AND `isDisputed`     = 'yes'
       AND `assignedto`    != 'waiting'
       ".(!empty($dept) ? 'AND `department` IN ('.implode(',',$dept).')' : '')."
       ".ALL_DISPUTES_ORDER
       );
  if (mysql_num_rows($q)>0) {
    while ($TICKETS = mysql_fetch_object($q)) {
      $tcnt            = number_format(mswRowCount('disputes WHERE ticketID = \''.$TICKETS->id.'\''));
      ++$counts[1];
      $link = '';
      if (EMAIL_DIGEST_LINKS) {
        $link  = mswDefineNewline();
        if (HTML_EMAILS) {
          $link .= '<a href="'.$SETTINGS->scriptpath.'/'.$SETTINGS->afolder.'/?ticket='.$TICKETS->id.'">'.$msg_edigest7.'</a>';
        } else {
          $link .= $SETTINGS->scriptpath.'/'.$SETTINGS->afolder.'/?ticket='.$TICKETS->id;
        }
      }
      $qLT6  = mysql_query("SELECT * FROM ".DB_PREFIX."replies 
               WHERE `ticketID` = '{$TICKETS->id}' 
               ORDER BY id DESC 
               LIMIT 1
               ")
               or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      $LT6   = mysql_fetch_object($qLT6);
      $emailDigest[5] .= mswCleanData($TICKETS->subject).mswDefineNewline();
      $emailDigest[5] .= str_replace(array('{name}','{priority}','{count}','{updated}'),
                                     array(mswSpecialChars($TICKETS->name),
                                           mswGetPriorityLevel($TICKETS->priority),
                                           ($tcnt+1),
                                           (isset($LT6->ts) ? mswDateDisplay($LT6->ts,$SETTINGS->dateformat) : 'N/A')
                                     ),
                                     $msg_edigest6
                         ).$link.mswDefineNewline().mswDefineNewline();
    }
  } else {
    $emailDigest[5] = $msg_edigest2;
  }
  
  // Whitespace cleanup..
  $emailDigest[5] = rtrim($emailDigest[5]);
  
  // Send auto responder to person who opened ticket..
  $MSMAIL->addTag('{COUNT}', $counts[0]);
  $MSMAIL->addTag('{COUNT_DIS}', $counts[1]);
  $MSMAIL->addTag('{COUNT_ASG}', $counts[2]);
  $MSMAIL->addTag('{NEW}', (HTML_EMAILS ? nl2br($emailDigest[0]) : $emailDigest[0]));
  $MSMAIL->addTag('{TICK_ADMIN}', (HTML_EMAILS ? nl2br($emailDigest[1]) : $emailDigest[1]));
  $MSMAIL->addTag('{TICK_VIS}', (HTML_EMAILS ? nl2br($emailDigest[2]) : $emailDigest[2]));
  $MSMAIL->addTag('{NEW_DIS}', (HTML_EMAILS ? nl2br($emailDigest[3]) : $emailDigest[3]));
  $MSMAIL->addTag('{DIS_ADMIN}', (HTML_EMAILS ? nl2br($emailDigest[4]) : $emailDigest[4]));
  $MSMAIL->addTag('{DIS_VIS}', (HTML_EMAILS ? nl2br($emailDigest[5]) : $emailDigest[5]));
  $MSMAIL->addTag('{ASSIGN}', (HTML_EMAILS ? nl2br($emailDigest[6]) : $emailDigest[6]));
  $MSMAIL->addTag('{TIME}', mswTimeDisplay(0,$SETTINGS->timeformat));
  
  // Still sending for 0 counts?
  if (!EMAIL_DIGEST_ZERO_COUNT_MAIL && $counts[0]==0 && $counts[1]==0) {
    echo $msg_edigest8;
    exit;
  }
  
  $MSMAIL->sendMSMail($USERS->name,
                      $USERS->email,
                      $SETTINGS->website,
                      $SETTINGS->email,
                      str_replace('{website}',$SETTINGS->website,$msg_edigest3),
                      $MSMAIL->template(PATH.'templates/language/'.$SETTINGS->language.'/email/email-digest.txt')
          );

}

echo $msg_edigest4;

?>