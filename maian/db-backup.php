<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: db-backup.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

// ERROR REPORTING..
include(dirname(__FILE__).'/control/error-reporting.php');

// SET PATH TO HELPDESK FOLDER..
define('PATH', dirname(__FILE__).'/');
define('PARENT', 1);

// TIMEOUT..
@ini_set('memory_limit', '100M');
@set_time_limit(0);

// DATABASE CONNECTION..
include(PATH.'control/connect.inc.php');
include(PATH.'control/system/core/c2.php');
include(PATH.'control/functions.php');
include(PATH.'control/system/core/mail.php');           

// CONNECT
mswDBConnector();

// LOAD SETTINGS DATA..
$SETTINGS = @mysql_fetch_object(
              mysql_query("SELECT * FROM ".DB_PREFIX."settings LIMIT 1")
             );
             
include(PATH.'control/user-defined/defined.inc.php');
include(PATH.'control/user-defined/defined2.inc.php');    
include(PATH.'control/user-defined/defined3.inc.php');         
             
// CHECK INSTALLER..
if (!isset($SETTINGS->language)) {
  echo 'Settings table not found, did you run the installer?';
  exit;
} 

// TIMEZONE..
define('MSTZ_SET',$SETTINGS->timezone);

// LOAD LANGUAGE FILES..
include_once(PATH.'templates/language/'.$SETTINGS->language.'/lang1.php');
include_once(PATH.'templates/language/'.$SETTINGS->language.'/lang2.php');
include_once(PATH.'templates/language/'.$SETTINGS->language.'/lang3.php');

// FILE PATH..
if (!is_writeable(PATH.'backups') || !is_dir(PATH.'backups')) {
  die ('"<b>'.PATH.'backups'.'</b>" folder must exist and be writeable. Please check directory and permissions..');
}

$time     = date('H:i:s');
$filepath = PATH.'backups/'.$msg_script33.'-'.date('d-m-y',mswTimeStamp()).'.gz';

// BACKUP CLASS..
include(PATH.'classes/db-backup.php');
$BACKUP            = new dbBackup($filepath,true);
$BACKUP->settings  = $SETTINGS;

// DO BACKUP..
$BACKUP->doDump();

// SEND E-MAILS IF SMTP ENABLED..
if ($SETTINGS->smtp=='yes' && BACKUP_CRON_EMAILS && file_exists($filepath)) {
  $emails = array();
  if (strpos(BACKUP_CRON_EMAILS,',')!==FALSE) {
    $emails = explode(',',BACKUP_CRON_EMAILS);
  } else {
    $emails[] = BACKUP_CRON_EMAILS;
  }
  foreach ($emails AS $send) {
    $MAILER             = new PHPMailer();
    $MAILER->IsSMTP();
    $MAILER->IsHTML(false);
    $MAILER->Port       = ($SETTINGS->smtp_port ? $SETTINGS->smtp_port : '25');
    $MAILER->Host       = ($SETTINGS->smtp_host ? $SETTINGS->smtp_host : 'localhost');
    $MAILER->SMTPAuth   = ($SETTINGS->smtp_user && $SETTINGS->smtp_pass ? true : false);
    $MAILER->Username   = $SETTINGS->smtp_user;
    $MAILER->Password   = $SETTINGS->smtp_pass;
    $MAILER->From       = $SETTINGS->email;
    $MAILER->FromName   = mswCleanData($SETTINGS->website);
    $MAILER->AddReplyTo($SETTINGS->email,mswCleanData($SETTINGS->website));
    $MAILER->AddAddress($send,$send);
    $MAILER->WordWrap   = 1000;
    $MAILER->Subject    = str_replace(array('{website}','{date}','{time}'),
                                      array(
                                       mswCleanData($SETTINGS->website),
                                       mswDateDisplay(0,$SETTINGS->dateformat),
                                       $time
                                      ),
                                      $msg_script31
                          );
    $MAILER->Body       = str_replace(array('{HELPDESK}','{DATE_TIME}','{VERSION}','{FILE}','{SCRIPT}'),
                                      array(
                                       mswCleanData($SETTINGS->website),
                                       mswDateDisplay(0,$SETTINGS->dateformat).' @ '.$time,
                                       SCRIPT_VERSION,
                                       basename($filepath),
                                       SCRIPT_NAME
                                      ),
                                      file_get_contents(PATH.'templates/language/'.$SETTINGS->language.'/email/backup.txt')
                          );
    $MAILER->AddAttachment($filepath,basename($filepath));
    $MAILER->Send();
  }
  @unlink($filepath);
}

echo $msg_script32;

?>