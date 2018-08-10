<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: close-tickets.php
  Description: Auto Closes Tickets

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

// If email digest is running, we don`t need to load system files..
if (!defined('EMAIL_DIGEST')) {
  include(dirname(__FILE__).'/control/error-reporting.php');

  define('PATH', dirname(__FILE__).'/');
  define('PARENT',1);

  include(PATH.'control/system/core/init.php');
}

if ($SETTINGS->autoClose>0) {
  $now = mswTimeStamp();
  $q = mysql_query("SELECT * FROM ".DB_PREFIX."tickets 
       WHERE `replyStatus`                      = 'visitor'
       AND `ticketStatus`                       = 'open'
       AND DATE(FROM_UNIXTIME(`lastrevision`)) != DATE(UTC_TIMESTAMP)
       ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  while ($T = mysql_fetch_object($q)) {
    // Get last reply date..
    $q2  = mysql_query("SELECT `id`,`ts` FROM ".DB_PREFIX."replies 
           WHERE `ticketID` = '{$T->id}' 
           ORDER BY `id` DESC 
           LIMIT 1
           ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    $R = mysql_fetch_object($q2);
    if (isset($R->id)) {
      $f  = strtotime(date('Y-m-d',$R->ts));
      $t  = strtotime(date('Y-m-d',$now));
      $c  = ceil(($t-$f)/86400);
      $lg = PATH.'templates/language/'.($T->tickLang ? $T->tickLang : $SETTINGS->language).'/';
      // If date is equal to or greater than limit, close..
      if ($c>=$SETTINGS->autoClose) {
        mysql_query("UPDATE ".DB_PREFIX."tickets SET
        `ticketStatus`  = 'close',
        `lastrevision`  = UNIX_TIMESTAMP(UTC_TIMESTAMP)
        WHERE `id`      = '{$T->id}'
        LIMIT 1
        ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
        // Email notification..
        // For disputes, notify all in dispute..
        if ($SETTINGS->autoCloseMail=='yes') {
          $MSMAIL->addTag('{NAME}', mswCleanData($T->name));
          $MSMAIL->addTag('{TICKET}', mswTicketNumber($T->id));
          $MSMAIL->addTag('{SUBJECT}', mswCleanData($T->subject));
          $MSMAIL->addTag('{ID}',$T->id);
          $MSMAIL->sendMSMail($T->name,
                              $T->email,
                              $SETTINGS->website,
                              $SETTINGS->email,
                              str_replace(array('{website}','{ticket}'),
                                          array($SETTINGS->website,mswTicketNumber($T->id)),
                                          $msg_newticket46
                              ),
                              $MSMAIL->template($lg.'email/auto-close-tickets.txt')
                 );
          // Check for disputed ticket..
          if ($T->isDisputed=='yes') {
            $q_d  = mysql_query("SELECT * FROM ".DB_PREFIX."disputes 
                    WHERE `ticketID` = '{$T->id}' 
                    ORDER BY `id` DESC 
                    LIMIT 1
                    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
            while ($DIS = mysql_fetch_object($q_d)) {
              $MSMAIL->addTag('{NAME}', mswCleanData($DIS->userName));
              $MSMAIL->sendMSMail($DIS->userName,
                                  $DIS->userEmail,
                                  $SETTINGS->website,
                                  $SETTINGS->email,
                                  str_replace(array('{website}','{ticket}'),
                                              array($SETTINGS->website,mswTicketNumber($T->id)),
                                              $msg_newticket46
                                  ),
                                  $MSMAIL->template($lg.'email/auto-close-tickets.txt')
                     );
            }
          }
        }
      }
    }
  }
}

if (!defined('EMAIL_DIGEST')) {
 echo $msg_script40;
}

?>