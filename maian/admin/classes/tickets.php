<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: tickets.php
  Description: Class File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

class supportTickets {

var $settings;

function searchBatchUpdate() {
  $cnt = 0;
  $bd  = array();
  if (!empty($_POST['ticket'])) {
    if ($_POST['department']!='no-change' || $_POST['priority']!='no-change' || $_POST['status']!='no-change') {
      if ($_POST['department']!='no-change') {
        $bd[] = '`department` = \''.$_POST['department'].'\'';
        mysql_query("UPDATE ".DB_PREFIX."attachments SET
        `department` = '{$_POST['department']}'
        WHERE `ticketID` IN (".implode(',',$_POST['ticket']).")
        ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      }
      if ($_POST['priority']!='no-change') {
        $bd[] = '`priority` = \''.$_POST['priority'].'\'';
      }
      if ($_POST['status']!='no-change') {
        $bd[] = '`ticketStatus` = \''.$_POST['status'].'\'';
      } 
      if (!empty($bd)) {
        mysql_query("UPDATE ".DB_PREFIX."tickets SET
        `lastrevision` = UNIX_TIMESTAMP(UTC_TIMESTAMP),
        ".implode(',',$bd)."
        WHERE `id` IN (".implode(',',$_POST['ticket']).")
        ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
        return mysql_affected_rows();
      }
    }
  }
  return $cnt;
}

function updateAssignedTicketUsers() {
  $_GET['ticketAssigned'] = (int)$_GET['ticketAssigned'];
  mysql_query("UPDATE ".DB_PREFIX."tickets SET
  `lastrevision` = UNIX_TIMESTAMP(UTC_TIMESTAMP),
  `assignedto`   = '".(!empty($_POST['assigned']) ? implode(',',$_POST['assigned']) : '')."'
  WHERE `id`     = '{$_GET['ticketAssigned']}'
  LIMIT 1
  ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
}

function ticketUserAssign($id,$users) {
  mysql_query("UPDATE ".DB_PREFIX."tickets SET
  `lastrevision` = UNIX_TIMESTAMP(UTC_TIMESTAMP),
  `assignedto`   = '$users'
  WHERE `id`     = '$id'
  LIMIT 1
  ");
}

function forceDownloadAttachment() {
}

function ticketPostPrivileges($id,$pv) {
  if ($pv>0) {
    // Get current status..
    $q = mysql_query("SELECT * FROM ".DB_PREFIX."disputes
         WHERE `id`      = '$pv'
         AND `ticketID`  = '$id'
         LIMIT 1
         ");
    $U = mysql_fetch_object($q);
    // Now update..
    $status = (isset($U->postPrivileges) && $U->postPrivileges=='yes' ? 'no' : 'yes');
    mysql_query("UPDATE ".DB_PREFIX."disputes SET
    `postPrivileges` = '$status'
    WHERE `id`       = '$pv'
    AND `ticketID`   = '$id'
    LIMIT 1
    ");
  } else {
    // Get current status..
    $q = mysql_query("SELECT * FROM ".DB_PREFIX."tickets
         WHERE `id` = '$id'
         LIMIT 1
         ");
    $U = mysql_fetch_object($q);
    // Now update..
    $status = (isset($U->disPostPriv) && $U->disPostPriv=='yes' ? 'no' : 'yes');
    mysql_query("UPDATE ".DB_PREFIX."tickets SET
    `lastrevision` = UNIX_TIMESTAMP(UTC_TIMESTAMP),
    `disPostPriv`  = '$status'
    WHERE `id`     = '$id'
    LIMIT 1
    ");
  }
  return $status;
}

function enableAccount() {
  mysql_query("UPDATE ".DB_PREFIX."portal SET
  `enabled`      = 'yes'
  WHERE `email`  = '".mswSafeImportString($_GET['enable'])."'
  ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $rows = mysql_affected_rows();
  return $rows;
}

function disableAccount() {
  mysql_query("UPDATE ".DB_PREFIX."portal SET
  `enabled`      = 'no'
  WHERE `email`  = '".mswSafeImportString($_POST['email'])."'
  ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $rows = mysql_affected_rows();
  return $rows;
}

function getDisputeUsers($id) {
  $users  = array();
  $q      = mysql_query("SELECT * FROM ".DB_PREFIX."disputes 
            WHERE ticketID = '$id'
            ORDER BY userName
            ")
            or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  while ($U = mysql_fetch_object($q)) {
    $users[] = mswCleanData($U->userName).'#####'.$U->userEmail;
  }
  return $users;
}

function updateTicketNotes() {
  $_GET['ticketNotes'] = (int)$_GET['ticketNotes'];
  mysql_query("UPDATE ".DB_PREFIX."tickets SET
  `lastrevision` = UNIX_TIMESTAMP(UTC_TIMESTAMP),
  `ticketNotes`  = '".mswSafeImportString($_POST['notes'])."'
  WHERE `id`     = '{$_GET['ticketNotes']}'
  LIMIT 1
  ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  return mysql_affected_rows();
}

function addDisputeUserPortal($name,$email,$pass) {
  mysql_query("INSERT INTO ".DB_PREFIX."portal (
  `ts`,`email`,`userPass`
  ) VALUES (
  UNIX_TIMESTAMP(UTC_TIMESTAMP),'$email','".md5(SECRET_KEY.$pass)."'
  )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
}

function editDisputeUser($name,$email) {
  $_GET['id'] = (int)$_GET['id'];
  mysql_query("UPDATE ".DB_PREFIX."disputes SET
  `userName`   = '".mswSafeImportString($name)."',
  `userEmail`  = '".mswSafeImportString($email)."'
  WHERE id     = '{$_GET['id']}'
  LIMIT 1
  ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  return mysql_affected_rows();
}

function addDisputeUser($name,$email) {
  mysql_query("INSERT INTO ".DB_PREFIX."disputes (
  `ticketID`,
  `userName`,
  `userEmail`,
  `postPrivileges`
  ) VALUES (
  '{$_GET['disputeUsers']}',
  '".mswSafeImportString($name)."',
  '$email',
  'yes'
  )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
}

function updateDisputeUsers() {
  switch($_POST['options']) {
    case 'en_post':
    mysql_query("UPDATE ".DB_PREFIX."disputes SET
    `postPrivileges` = 'yes'
    WHERE `id`      IN (".implode(',',$_POST['remove']).")
    AND `ticketID`   = '{$_GET['disputeUsers']}'
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));   
    break;
    case 'dis_post':
    mysql_query("UPDATE ".DB_PREFIX."disputes SET
    `postPrivileges` = 'no'
    WHERE `id`      IN (".implode(',',$_POST['remove']).")
    AND `ticketID`   = '{$_GET['disputeUsers']}'
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    break;
    case 'delete':
    mysql_query("DELETE FROM ".DB_PREFIX."disputes 
    WHERE `id`     IN (".implode(',',$_POST['remove']).")
    AND `ticketID`  = '{$_GET['disputeUsers']}'
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    if (mswRowCount('disputes')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."disputes");
    }
    break;
  }
}

function removeDisputeUsersFromTicket() {
  mysql_query("DELETE FROM ".DB_PREFIX."disputes 
  WHERE `ticketID`  = '{$_GET['cdis']}'
  ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  if (mswRowCount('disputes')==0) {
    @mysql_query("TRUNCATE TABLE ".DB_PREFIX."disputes");
  }
}

function deleteAttachments() {
  $ids   = implode(',',$_POST['id']);
  $query = mysql_query("SELECT `fileName`,DATE(FROM_UNIXTIME(`ts`)) AS `addDate` FROM ".DB_PREFIX."attachments WHERE `id` IN ($ids)") 
  or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  while ($A = mysql_fetch_object($query)) {
    $split    = explode('-',$A->addDate);
    $folder   = '';
    // Check for newer folder structure..
    if (file_exists($this->settings->attachpath.'/'.$split[0].'/'.$split[1].'/'.$A->fileName)) {
      $folder  = $split[0].'/'.$split[1].'/';
    }
    if (is_writeable($this->settings->attachpath) && file_exists($this->settings->attachpath.'/'.$folder.$A->fileName)) {
      @unlink($this->settings->attachpath.'/'.$folder.$A->fileName);
    }
  }
  // Delete all attachment data..
  mysql_query("DELETE FROM ".DB_PREFIX."attachments WHERE id IN ($ids)") 
  or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  if (mswRowCount('attachments')==0) {
    @mysql_query("TRUNCATE TABLE ".DB_PREFIX."attachments");
  }
}

function exportPortal() {
  $file  = PATH.'export/portal-'.date('Ymd-his').'.csv';
  $data  = '';
  $sepr  = ',';
  if (!is_writeable(PATH.'export')) {
    die('<b>export</b> directory must be writeable for this operation. Check and try again..');
  }
  $q_portal = mysql_query("SELECT * FROM ".DB_PREFIX."portal
              ORDER BY `id`
              ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  while ($PORTAL = mysql_fetch_object($q_portal)) {
    $line = '';
    if (isset($_POST['name'])) {
      $q_name = mysql_query("SELECT `name` FROM ".DB_PREFIX."tickets 
                WHERE `email` = '{$PORTAL->email}' 
                ORDER BY `id` DESC 
                LIMIT 1
                ") 
                or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      $NM     = mysql_fetch_object($q_name);
      $line  .= (isset($NM->name) ? mswCleanCSV($NM->name,$sepr).(isset($_POST['email']) ? ',' : mswDefineNewline()) : '');
    }
    if (isset($_POST['email'])) {
      $line .= $PORTAL->email.mswDefineNewline();
    }
    $data .= $line;
  }
  // Save file to server and download..
  $fp = fopen($file, 'ab');
  if ($fp) {
    fwrite($fp,trim($data));
    fclose($fp);
  }
  if(@ini_get('zlib.output_compression')) {
    @ini_set('zlib.output_compression', 'Off');
  }
  header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
  header('Pragma: public');
  header('Expires: 0');
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  header('Cache-Control: private',false);
  header('Content-Type: '.mswGetMimeType());
  header('Content-Type: application/force-download');
  header('Content-Disposition: attachment; filename='.basename($file).';');
  header('Content-Transfer-Encoding: binary');
  header('Content-Length: '.filesize($file));
  @ob_end_flush();
  readfile($file);
  // Remove file after download..
  @unlink($file);
  exit;
}

function purgeTickets() {
  $t    = 0;
  $r    = 0;
  $a    = 0;
  $sql  = '';
  $ts   = strtotime(mswSQLDate());
  if ($_POST['days']>0) {
    $date   = date('Y-m-d',strtotime('-'.$_POST['days'].' days',$ts));
    // Departments..
    if (!empty($_POST['dept'])) {
      if (!in_array('all',$_POST['dept'])) {
        $sql  = "WHERE `department` IN (".implode(',',$_POST['dept']).")";
      }
    }
    $sql .= ($sql ? ' AND ' : 'WHERE ').'DATE(FROM_UNIXTIME(`ts`)) <= \''.$date.'\'';
    // Delete tickets/replies..
    $tickets = mysql_query("SELECT * FROM ".DB_PREFIX."tickets $sql AND `ticketStatus` != 'open'")
    or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    while ($TK = mysql_fetch_object($tickets)) {
      // Delete all replies..
      mysql_query("DELETE FROM ".DB_PREFIX."replies WHERE `ticketID` = '{$TK->id}'")
      or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      $r = ($r+mysql_affected_rows());
      // Delete ticket..
      mysql_query("DELETE FROM ".DB_PREFIX."tickets WHERE `id` = '{$TK->id}'")
      or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      $t = ($t+mysql_affected_rows());
      // Delete attachments..
      if (isset($_POST['clear'])) {
        $query = mysql_query("SELECT `fileName`,DATE(FROM_UNIXTIME(`ts`)) AS `addDate` FROM ".DB_PREFIX."attachments WHERE `ticketID` = '{$TK->id}'") 
        or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
        while ($A = mysql_fetch_object($query)) {
          $split    = explode('-',$A->addDate);
          $folder   = '';
          // Check for newer folder structure..
          if (file_exists($this->settings->attachpath.'/'.$split[0].'/'.$split[1].'/'.$A->fileName)) {
            $folder  = $split[0].'/'.$split[1].'/';
          }
          if (is_writeable($this->settings->attachpath) && file_exists($this->settings->attachpath.'/'.$folder.$A->fileName)) {
            @unlink($this->settings->attachpath.'/'.$folder.$A->fileName);
          }
        }
        mysql_query("DELETE FROM ".DB_PREFIX."attachments WHERE `ticketID` = '{$TK->id}'")
        or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
        $a = ($a+mysql_affected_rows());
      }
      // Delete disputes..
      mysql_query("DELETE FROM ".DB_PREFIX."disputes WHERE `ticketID`  = '{$TK->id}'") 
      or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      // Delete all custom data..
      mysql_query("DELETE FROM ".DB_PREFIX."ticketfields WHERE `ticketID` = '{$TK->id}'")
      or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    }
    if (mswRowCount('tickets')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."tickets");
    }
    if (mswRowCount('attachments')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."attachments");
    }
    if (mswRowCount('replies')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."replies");
    }
    if (mswRowCount('disputes')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."disputes");
    }
    if (mswRowCount('cusfields')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."cusfields");
    }
    if (mswRowCount('ticketfields')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."ticketfields");
    }
  }
  return array($t,$r,$a);
}

function purgeAttachments() {
  $count  = 0;
  $sql    = '';
  $ts     = strtotime(mswSQLDate());
  if ($_POST['days']>0) {
    $date   = date('Y-m-d',strtotime('-'.$_POST['days'].' days',$ts));
    // Departments..
    if (!empty($_POST['dept'])) {
      if (!in_array('all',$_POST['dept'])) {
        $sql  = "WHERE `department` IN (".implode(',',$_POST['dept']).")";
      }
    }
    $sql .= ($sql ? ' AND ' : 'WHERE ').'DATE(FROM_UNIXTIME(`ts`)) <= \''.$date.'\'';
    // Delete attachment files..
    $query = mysql_query("SELECT `fileName`,DATE(FROM_UNIXTIME(`ts`)) AS `addDate` FROM ".DB_PREFIX."attachments $sql") 
    or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    while ($A = mysql_fetch_object($query)) {
      $split    = explode('-',$A->addDate);
      $folder   = '';
      // Check for newer folder structure..
      if (file_exists($this->settings->attachpath.'/'.$split[0].'/'.$split[1].'/'.$A->fileName)) {
        $folder  = $split[0].'/'.$split[1].'/';
      }
      if (is_writeable($this->settings->attachpath) && file_exists($this->settings->attachpath.'/'.$folder.$A->fileName)) {
        @unlink($this->settings->attachpath.'/'.$folder.$A->fileName);
      }
    }
    // Delete all attachment data..
    mysql_query("DELETE FROM ".DB_PREFIX."attachments $sql")
    or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    $count = mysql_affected_rows();
    if (mswRowCount('attachments')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."attachments");
    }
  }
  return $count;
}

function deleteTickets() {
  $count = 0;
  if (!empty($_POST['ticket'])) {
    $tIDs = implode(',',$_POST['ticket']);
    // Delete attachment files..
    $query = mysql_query("SELECT *,DATE(FROM_UNIXTIME(`ts`)) AS `addDate` FROM ".DB_PREFIX."attachments WHERE `ticketID` IN ($tIDs)") 
    or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    while ($A = mysql_fetch_object($query)) {
      $split    = explode('-',$A->addDate);
      $folder   = '';
      // Check for newer folder structure..
      if (file_exists($this->settings->attachpath.'/'.$split[0].'/'.$split[1].'/'.$A->fileName)) {
        $folder  = $split[0].'/'.$split[1].'/';
      }
      if (is_writeable($this->settings->attachpath) && file_exists($this->settings->attachpath.'/'.$folder.$A->fileName)) {
        @unlink($this->settings->attachpath.'/'.$folder.$A->fileName);
      }
    }
    // Delete all replies..
    mysql_query("DELETE FROM ".DB_PREFIX."replies WHERE `ticketID` IN ($tIDs)")
    or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    // Delete all attachment data..
    mysql_query("DELETE FROM ".DB_PREFIX."attachments WHERE `ticketID` IN ($tIDs)")
    or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    // Delete all tickets..
    mysql_query("DELETE FROM ".DB_PREFIX."tickets WHERE `id` IN ($tIDs)")
    or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    // Delete all custom data..
    mysql_query("DELETE FROM ".DB_PREFIX."ticketfields WHERE `ticketID` IN ($tIDs)")
      or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    // Delete disputes..
    mysql_query("DELETE FROM ".DB_PREFIX."disputes WHERE `ticketID` IN ($tIDs)") 
    or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    // Truncate tables to start at 1..
    if (mswRowCount('tickets')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."tickets");
    }
    if (mswRowCount('attachments')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."attachments");
    }
    if (mswRowCount('replies')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."replies");
    }
    if (mswRowCount('cusfields')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."cusfields");
    }
    if (mswRowCount('ticketfields')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."ticketfields");
    }
    if (mswRowCount('disputes')==0) {
      @mysql_query("TRUNCATE TABLE ".DB_PREFIX."disputes");
    }
    ++$count;
  }
  return $count;
}

function reOpenTicket() {
  // Update ticket status..
  if (is_numeric($_GET['open'])) {
    mysql_query("UPDATE ".DB_PREFIX."tickets SET
    `lastrevision`  = UNIX_TIMESTAMP(UTC_TIMESTAMP),
    `ticketStatus`  = 'open'
    WHERE `id`      = '{$_GET['open']}'
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    return mysql_affected_rows();
  }
  return '0';
}

function addReplyAttachments($temp,$name,$size,$id,$dept) {
  if (!is_dir($this->settings->attachpath)) {
    die('Attachment Path Incorrect: &quot;'.$this->settings->attachpath.'&quot; does not exist. Check settings and try again..');
  }
  if (is_writeable($this->settings->attachpath)) {
    if (is_uploaded_file($temp)) {
      $U  = $this->settings->attachpath.'/'.$id.'-'.$name;
      $R  = $id.'-'.$name;
      $Y  = date('Y',mswTimeStamp());
      $M  = date('m',mswTimeStamp());
      // Create folders..
      if (!is_dir($this->settings->attachpath.'/'.$Y)) {
        $omask = @umask(0); 
        @mkdir($this->settings->attachpath.'/'.$Y,ATTACH_CHMOD_VALUE);
        @umask($omask);
      }
      if (is_dir($this->settings->attachpath.'/'.$Y)) {
        if (!is_dir($this->settings->attachpath.'/'.$Y.'/'.$M)) {
          $omask = @umask(0); 
          @mkdir($this->settings->attachpath.'/'.$Y.'/'.$M,ATTACH_CHMOD_VALUE);
          @umask($omask);
        }
        if (is_dir($this->settings->attachpath.'/'.$Y.'/'.$M)) {
          $U = $this->settings->attachpath.'/'.$Y.'/'.$M.'/'.$id.'-'.$name;
          $R = $Y.'/'.$M.'/'.$id.'-'.$name;
        }
      }
      move_uploaded_file($temp, $U);
      // Required by some servers to make image viewable and accessible via FTP..
      @chmod($U,0644);
    }
    if (file_exists($U)) {
      // Add to database..
      mysql_query("INSERT INTO ".DB_PREFIX."attachments (
      `ts`,
      `ticketID`,
      `replyID`,
      `department`,
      `fileName`,
      `fileSize`
      ) VALUES (
      UNIX_TIMESTAMP(UTC_TIMESTAMP),
      '{$_GET['id']}',
      '$id',
      '$dept',
      '".$id."-".$name."',
      '$size'
      )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      // Remove temp file..
      if (file_exists($temp)) {
        @unlink($temp);
      }
      return $R;
    }
  } else {
    die('Error: &quot;'.$this->settings->attachpath.'&quot; folder NOT writeable! Please Update!');
  }
}

function addTicketReply() {
  global $MSTEAM;
  $_GET['id'] = is_numeric($_GET['id']) ? $_GET['id'] : '0';
  $array      = array('no',$_GET['id'],'');
  // Are we merging this ticket..
  if (isset($_POST['mergeid']) && $_POST['mergeid']) {
    $mergeID = mswReverseTicketNumber($_POST['mergeid']);
    if (mswRowCount('tickets WHERE `id` = \''.$mergeID.'\'')>0) {
      // Get original ticket and convert it to a reply..
      $OTICKET = mswGetTableData('tickets','id',$_GET['id']);
      // Get new parent data for department..
      $MERGER  = mswGetTableData('tickets','id',$mergeID);
      mysql_query("INSERT INTO ".DB_PREFIX."replies (
      `ts`,
      `ticketID`,
      `comments`,
      `replyType`,
      `replyUser`,
      `isMerged`,
      `ipAddresses` 
      ) VALUES (
      '".mswTimeStamp()."',
      '$mergeID',
      '".mswSafeImportString($OTICKET->comments)."',
      'visitor',
      '0',
      'yes',
      '{$OTICKET->ipAddresses}' 
      )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      // Now remove original ticket
      mysql_query("DELETE FROM ".DB_PREFIX."tickets WHERE `id` = '{$_GET['id']}' LIMIT 1") 
      or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      // Move any replies attached to original ticket to new parent..
      mysql_query("UPDATE ".DB_PREFIX."replies SET
      `ticketID`        = '$mergeID',
      `isMerged`        = 'yes'
      WHERE `ticketID`  = '{$_GET['id']}'
      ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      // Move attachments to new ticket id..
      mysql_query("UPDATE ".DB_PREFIX."attachments SET
      `ticketID`        = '$mergeID',
      `department`      = '{$MERGER->department}'
      WHERE `ticketID`  = '{$_GET['id']}'
      ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      // Move custom field data to new ticket..
      mysql_query("UPDATE ".DB_PREFIX."ticketfields SET
      `ticketID`        = '$mergeID'
      WHERE `ticketID`  = '{$_GET['id']}'
      ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      // Move any dispute user data to new ticket..
      // Ignore any users that already exist..
      $qDU = mysql_query("SELECT * FROM ".DB_PREFIX."disputes 
             WHERE `ticketID` = '{$_GET['id']}'
             ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      while ($DU = mysql_fetch_object($qDU)) {
        if (mswRowCount('disputes WHERE `ticketID` = \''.$mergeID.'\' AND `userEmail` = \''.$DU->userEmail.'\'')==0) {
          mysql_query("UPDATE ".DB_PREFIX."disputes SET
          `ticketID`        = '$mergeID'
          WHERE `ticketID`  = '{$_GET['id']}'
          AND `userEmail`   = '{$DU->userEmail}'
          ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
        } else {
          mysql_query("DELETE FROM ".DB_PREFIX."disputes
          WHERE `ticketID` = '{$_GET['id']}'
          AND `userEmail`  = '{$DU->userEmail}'
          LIMIT 1
          ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
        }
      }
      // Overwrite array..
      $array = array('yes',$mergeID,mswSpecialChars($OTICKET->subject));
    }
  }
  // Add new reply..
  mysql_query("INSERT INTO ".DB_PREFIX."replies (
  `ts`,
  `ticketID`,
  `comments`,
  `replyType`,
  `replyUser`,
  `isMerged`,
  `ipAddresses` 
  ) VALUES (
  '".mswTimeStamp()."',
  '".(isset($mergeID) ? $mergeID : $_GET['id'])."',
  '".mswSafeImportString($_POST['comments'])."',
  'admin',
  '{$MSTEAM->id}',
  'no',
  '".mswIPAddresses()."' 
  )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $newReply = mysql_insert_id();
  // Custom field data..
  if (!empty($_POST['customField'])) {
    // Check to see if any checkboxes arrays are now blank..
    // If there are, create empty array to prevent ommission in loop..
    if (!empty($_POST['hiddenBoxes'])) {
      foreach ($_POST['hiddenBoxes'] AS $hb) {
        if (!isset($_POST['customField'][$hb])) {
         $_POST['customField'][$hb] = array();
        }
      }
    }
    foreach ($_POST['customField'] AS $k => $v) {
      $data = '';
      // If value is array, its checkboxes..
      if (is_array($v)) {
        if (!empty($v)) {
          $data = implode('#####',$v);
        }
      } else {
        $data = $v;
      }
      // If data exists, update or add entry..
      // If blank or 'nothing-selected', delete if exists..
      if ($data!='' && $data!='nothing-selected') {
        if (mswRowCount('ticketfields WHERE `ticketID`  = \''.$_GET['id'].'\' AND `fieldID` = \''.$k.'\' AND `replyID` = \''.$newReply.'\'')>0) { 
          mysql_query("UPDATE ".DB_PREFIX."ticketfields SET
          `fieldData`       = '".mswSafeImportString($data)."'
          WHERE `ticketID`  = '".(isset($mergeID) ? $mergeID : $_GET['id'])."'
          AND `fieldID`     = '$k'
          AND `replyID`     = '$newReply'
          LIMIT 1
          ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
        } else {
          mysql_query("INSERT INTO ".DB_PREFIX."ticketfields (
          `fieldData`,`ticketID`,`fieldID`,`replyID`
          ) VALUES (
          '".mswSafeImportString($data)."','".(isset($mergeID) ? $mergeID : $_GET['id'])."','$k','$newReply'
          )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
        }
      } else {
        mysql_query("DELETE FROM ".DB_PREFIX."ticketfields
        WHERE `ticketID`  = '".(isset($mergeID) ? $mergeID : $_GET['id'])."'
        AND `fieldID`     = '$k'
        AND `replyID`     = '$newReply'
        LIMIT 1
        ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
        if (mswRowCount('ticketfields')==0) {
          @mysql_query("TRUNCATE TABLE ".DB_PREFIX."ticketfields");
        }
      }
    }
  }
  // Update ticket status..
  mysql_query("UPDATE ".DB_PREFIX."tickets SET
  `lastrevision`  = UNIX_TIMESTAMP(UTC_TIMESTAMP),
  `ticketStatus`  = '{$_POST['status']}',
  `replyStatus`   = 'visitor'
  WHERE `id`      = '".(isset($mergeID) ? $mergeID : $_GET['id'])."'
  LIMIT 1
  ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  // If specified, add reply as standard response..
  if (isset($_POST['response']) && $_POST['response']=='yes') {
    $rUpdateAllowed = 'no';
    // Permission to add response based on version..
    if (LICENCE_VER=='unlocked') {
      $rUpdateAllowed = 'yes';
    } else {
      if (mswRowCount('responses')+1<=RESTR_RESPONSES) {
        $rUpdateAllowed = 'yes';
      }
    }
    // Add response..
    if ($rUpdateAllowed=='yes') {
      $OTICKET = mswGetTableData('tickets','id',(isset($mergeID) ? $mergeID : $_GET['id']));
      mysql_query("INSERT INTO ".DB_PREFIX."responses (
      `ts`,
      `title`,
      `answer`,
      `department`
      ) VALUES (
      UNIX_TIMESTAMP(UTC_TIMESTAMP),
      '".mswSafeImportString((isset($_POST['response_title']) ? $_POST['response_title'] : $OTICKET->subject))."',
      '".mswSafeImportString($_POST['comments'])."',
      '{$OTICKET->department}'
      )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    }
  }
  $array[] = $newReply;
  return $array;
}

function deleteReply() {
  $_GET['id']     = is_numeric($_GET['id']) ? $_GET['id'] : '0';
  $_GET['delete'] = is_numeric($_GET['delete']) ? $_GET['delete'] : '0';
  if (!is_dir($this->settings->attachpath)) {
    die('Attachment path in settings incorrect! Please fix the following:<br />&quot;'.$this->settings->attachpath.'&quot;');
  }
  mysql_query("DELETE FROM ".DB_PREFIX."replies
  WHERE `id`  = '{$_GET['delete']}'
  LIMIT 1
  ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $gone = mysql_affected_rows();
  // Delete attachments..
  $query = mysql_query("SELECT *,DATE(FROM_UNIXTIME(`ts`)) AS `addDate` FROM ".DB_PREFIX."attachments
           WHERE `ticketID`  = '{$_GET['id']}'
           AND `replyID`     = '{$_GET['delete']}'
           ORDER BY `id`
           ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  while ($ATT = mysql_fetch_object($query)) {
    $split    = explode('-',$ATT->addDate);
    $folder   = '';
    // Check for newer folder structure..
    if (file_exists($this->settings->attachpath.'/'.$split[0].'/'.$split[1].'/'.$ATT->fileName)) {
      $folder  = $split[0].'/'.$split[1].'/';
    }
    if (file_exists($this->settings->attachpath.'/'.$folder.$ATT->fileName)) {
      @unlink($this->settings->attachpath.'/'.$folder.$ATT->fileName);
    }
  }
  mysql_query("DELETE FROM ".DB_PREFIX."attachments
  WHERE `replyID`  = '{$_GET['delete']}'
  ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  // If all replies have been deleted. ticket should be set back to start..
  if (mswRowCount('replies WHERE `ticketID` = \''.$_GET['id'].'\'')==0) {
    mysql_query("UPDATE ".DB_PREFIX."tickets SET
    `lastrevision` = UNIX_TIMESTAMP(UTC_TIMESTAMP),
    `replyStatus`  = 'start'
    WHERE `id`     = '{$_GET['id']}'
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
  mysql_query("DELETE FROM ".DB_PREFIX."ticketfields
  WHERE `replyID`  = '{$_GET['delete']}'
  ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  if (mswRowCount('attachments')==0) {
    @mysql_query("TRUNCATE TABLE ".DB_PREFIX."attachments");
  }
  if (mswRowCount('ticketfields')==0) {
    @mysql_query("TRUNCATE TABLE ".DB_PREFIX."ticketfields");
  }
  if (mswRowCount('replies')==0) {
    @mysql_query("TRUNCATE TABLE ".DB_PREFIX."replies");
  }
  return $gone;
}

function updateTicketReply() {
  $_POST['edit']  = (int)$_POST['edit'];
  mysql_query("UPDATE ".DB_PREFIX."replies SET
  `comments`  = '".mswSafeImportString($_POST['comments'])."'
  WHERE `id`  = '{$_POST['edit']}'
  LIMIT 1
  ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  // Custom field data..
  if (!empty($_POST['customField'])) {
    // Check to see if any checkboxes arrays are now blank..
    // If there are, create empty array to prevent ommission in loop..
    if (!empty($_POST['hiddenBoxes'])) {
      foreach ($_POST['hiddenBoxes'] AS $hb) {
        if (!isset($_POST['customField'][$hb])) {
          $_POST['customField'][$hb] = array();
        }
      }
    }
    foreach ($_POST['customField'] AS $k => $v) {
      $data = '';
      // If value is array, its checkboxes..
      if (is_array($v)) {
        if (!empty($v)) {
          $data = implode('#####',$v);
        }
      } else {
        $data = $v;
      }
      // If data exists, update or add entry..
      // If blank or 'nothing-selected', delete if exists..
      if ($data!='' && $data!='nothing-selected') {
        if (mswRowCount('ticketfields WHERE `ticketID`  = \''.$_GET['id'].'\' AND `fieldID` = \''.$k.'\' AND `replyID` = \''.$_POST['edit'].'\'')>0) { 
          mysql_query("UPDATE ".DB_PREFIX."ticketfields SET
          `fieldData`       = '".mswSafeImportString($data)."'
          WHERE `ticketID`  = '{$_GET['id']}'
          AND `fieldID`     = '$k'
          AND `replyID`     = '{$_POST['edit']}'
          LIMIT 1
          ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
        } else {
          mysql_query("INSERT INTO ".DB_PREFIX."ticketfields (
          `fieldData`,`ticketID`,`fieldID`,`replyID`
          ) VALUES (
          '".mswSafeImportString($data)."','{$_GET['id']}','$k','{$_POST['edit']}'
          )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
        }
      } else {
        mysql_query("DELETE FROM ".DB_PREFIX."ticketfields
        WHERE `ticketID`  = '{$_GET['id']}'
        AND `fieldID`     = '$k'
        AND `replyID`     = '{$_POST['edit']}'
        LIMIT 1
        ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
        if (mswRowCount('ticketfields')==0) {
          @mysql_query("TRUNCATE TABLE ".DB_PREFIX."ticketfields");
        }
      }
    }
  }
}

function getAllPostalEmails() {
  $emails = array();
  $query = mysql_query("SELECT `email` FROM ".DB_PREFIX."portal
           ".($_GET['autoComplete']=='e4' ? 'WHERE `enabled` = \'yes\'' : '')."
           ORDER BY `email`
           ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  while ($E = mysql_fetch_object($query)) {
    $emails[] = $E->email;
  }
  return array_unique($emails);
}

function moveTickets($from,$to) {
  mysql_query("UPDATE ".DB_PREFIX."tickets SET
  `lastrevision` = UNIX_TIMESTAMP(UTC_TIMESTAMP),
  `email`        = '$to'
  WHERE `email`  = '$from'
  ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $rows = mysql_affected_rows();
  mysql_query("DELETE FROM ".DB_PREFIX."portal
  WHERE `email` = '$from'
  LIMIT 1
  ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  mysql_query("UPDATE ".DB_PREFIX."disputes SET
  `userEmail`        = '$to'
  WHERE `userEmail`  = '$from'
  ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  return $rows;
}

function updateTicketDisputeStatus() {
  $status = (isset($_GET['odis']) ? 'yes' : 'no');
  if (is_numeric($_GET['id'])) {
    mysql_query("UPDATE ".DB_PREFIX."tickets SET
    `lastrevision` = UNIX_TIMESTAMP(UTC_TIMESTAMP),
    `isDisputed`   = '$status'
    WHERE `id`     = '{$_GET['id']}'
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
}

function updateTicketStatus() {
  $status = (isset($_GET['close']) ? 'close' : (isset($_GET['open']) ? 'open' : (isset($_GET['lock']) ? 'closed' : 'open')));
  if (is_numeric($_GET['id'])) {
    mysql_query("UPDATE ".DB_PREFIX."tickets SET
    `lastrevision`  = UNIX_TIMESTAMP(UTC_TIMESTAMP),
    `ticketStatus`  = '$status'
    WHERE `id`      = '{$_GET['id']}'
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
}

function checkEmailExists($email,$id) {
  if (is_numeric($id)) {
    $query = mysql_query("SELECT `email` FROM ".DB_PREFIX."tickets 
             WHERE `email`  = '".mswSafeImportString($email)."' 
             AND `id`      != '$id'
             LIMIT 1
             ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    return (mysql_num_rows($query)>0 ? true : false);
  }
}

function updateSupportTicket() {
  $_GET['id'] = is_numeric($_GET['id']) ? $_GET['id'] : '0';
  mysql_query("UPDATE ".DB_PREFIX."tickets SET
  `lastrevision` = UNIX_TIMESTAMP(UTC_TIMESTAMP),
  `department`   = '{$_POST['department']}',
  `name`         = '".mswSafeImportString($_POST['name'])."',
  `email`        = '".mswSafeImportString($_POST['email'])."',
  `subject`      = '".mswSafeImportString($_POST['subject'])."',
  `comments`     = '".mswSafeImportString($_POST['comments'])."',
  `priority`     = '{$_POST['priority']}'
  WHERE `id`     = '{$_GET['id']}'
  LIMIT 1
  ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  // Custom field data..
  if (!empty($_POST['customField'])) {
    // Check to see if any checkboxes arrays are now blank..
    // If there are, create empty array to prevent ommission in loop..
    if (!empty($_POST['hiddenBoxes'])) {
      foreach ($_POST['hiddenBoxes'] AS $hb) {
        if (!isset($_POST['customField'][$hb])) {
          $_POST['customField'][$hb] = array();
        }
      }
    }
    foreach ($_POST['customField'] AS $k => $v) {
      $data = '';
      // If value is array, its checkboxes..
      if (is_array($v)) {
        if (!empty($v)) {
          $data = implode('#####',$v);
        }
      } else {
        $data = $v;
      }
      // If data exists, update or add entry..
      // If blank or 'nothing-selected', delete if exists..
      if ($data!='' && $data!='nothing-selected') {
        if (mswRowCount('ticketfields WHERE `ticketID`  = \''.$_GET['id'].'\' AND `fieldID` = \''.$k.'\' AND `replyID` = \'0\'')>0) { 
          mysql_query("UPDATE ".DB_PREFIX."ticketfields SET
          `fieldData`       = '".mswSafeImportString($data)."'
          WHERE `ticketID`  = '{$_GET['id']}'
          AND `fieldID`     = '$k'
          AND `replyID`     = '0'
          LIMIT 1
          ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
        } else {
          mysql_query("INSERT INTO ".DB_PREFIX."ticketfields (
          `fieldData`,`ticketID`,`fieldID`,`replyID`
          ) VALUES (
          '".mswSafeImportString($data)."','{$_GET['id']}','$k','0'
          )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
        }
      } else {
        mysql_query("DELETE FROM ".DB_PREFIX."ticketfields
        WHERE `ticketID`  = '{$_GET['id']}'
        AND `fieldID`     = '$k'
        AND `replyID`     = '0'
        LIMIT 1
        ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
        if (mswRowCount('ticketfields')==0) {
          @mysql_query("TRUNCATE TABLE ".DB_PREFIX."ticketfields");
        }
      }
    }
  }
  // If department was changed, update attachments..
  if ($_POST['department']!=$_POST['odeptid']) {
    $_POST['department'] = (int)$_POST['department'];
    mysql_query("UPDATE ".DB_PREFIX."attachments SET
    `department`      = '{$_POST['department']}'
    WHERE `ticketID`  = '{$_GET['id']}'
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    // Check assignment..If department has assign disabled, we need to clear assigned values from ticket..
    if (mswRowCount('departments WHERE `id` = \''.$_POST['department'].'\' AND `manual_assign` = \'no\'')>0) {
      mysql_query("UPDATE ".DB_PREFIX."tickets SET
      `assignedto`  = ''
      WHERE `id`    = '{$_GET['id']}'
      LIMIT 1
      ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    }
  }
}

}

?>