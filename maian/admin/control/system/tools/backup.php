<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: backup.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

include(REL_PATH.'classes/db-backup.php');

// Access..
if (!in_array('backup',$userAccess) && $MSTEAM->id!='1') {
  header("Location: index.php?noaccess=1");
  exit;
}   

// Backup..
if (isset($_POST['process'])) {
  if (!is_writeable(REL_PATH.'backups') || !is_dir(REL_PATH.'backups')) {
    die ('"<b>'.REL_PATH.'backups'.'</b>" folder must exist and be writeable. Please check directory and permissions..');
  }
  $time      = date('H:i:s');
  $download  = (isset($_POST['download']) ? $_POST['download'] : 'yes');
  $compress  = (isset($_POST['compress']) ? $_POST['compress'] : 'yes');
  // Force download if off and no emails..
  if ($download=='no' && $_POST['emails']=='') {
    $download = 'yes';
  }
  // If emails entered, download is always no..
  if ($_POST['emails']) {
    $download = 'no';
  }
  // File path..
  if ($compress=='yes') {
    $filepath  = REL_PATH.'backups/'.$msg_script33.'-'.date('d-M-Y',mswTimeStamp()).'-'.str_replace(':','-',$time).'.gz';
  } else {
    $filepath  = REL_PATH.'backups/'.$msg_script33.'-'.date('d-M-Y',mswTimeStamp()).'-'.str_replace(':','-',$time).'.sql';
  }
  // Save backup..
  $BACKUP            = new dbBackup($filepath,($compress=='yes' ? true : false));
  $BACKUP->settings  = $SETTINGS;
  $BACKUP->doDump();
  // Copy email addresses if set..
  if ($SETTINGS->smtp=='yes' && $_POST['emails'] && file_exists($filepath)) {
    $emails = array();
    if (strpos($_POST['emails'],',')!==FALSE) {
      $emails   = array_map('trim',explode(',',$_POST['emails']));
    } else {
      $emails[] = $_POST['emails'];
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
                                        array(mswCleanData($SETTINGS->website),
                                              mswDateDisplay(0,$SETTINGS->dateformat),
                                              $time
                                        ),
                                        $msg_script31
                            );
      $MAILER->Body       = str_replace(array('{HELPDESK}','{DATE_TIME}','{VERSION}','{FILE}','{SCRIPT}'),
                                        array(mswCleanData($SETTINGS->website),
                                              mswDateDisplay(0,$SETTINGS->dateformat).' @ '.$time,
                                              SCRIPT_VERSION,
                                              basename($filepath),
                                              SCRIPT_NAME
                                        ),
                                        file_get_contents(REL_PATH.'templates/language/'.$SETTINGS->language.'/email/backup.txt')
                            );
      $MAILER->AddAttachment($filepath,basename($filepath));
      $MAILER->Send();
    }
  }
  // Download..
  if ($download=='yes') {
    if(@ini_get('zlib.output_compression')) {
      @ini_set('zlib.output_compression', 'Off');
    }
    $type  = ($compress=='yes' ? 'application/x-compressed' : 'text/plain');
    header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private',false);
    header('Content-Type: '.$type);
    header('Content-Type: application/force-download');
    header('Content-Disposition: attachment; filename="'.basename($filepath).'";');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: '.filesize($filepath));
    @ob_end_flush();
    readfile($filepath);
    @unlink($filepath);
    exit;
  } else {
    @unlink($filepath);
    $OK = true;
  }
}
     
$title = $msg_adheader30;
  
include(PATH.'templates/header.php');
include(PATH.'templates/system/tools/backup.php');
include(PATH.'control/system/core/footer.php');

?>