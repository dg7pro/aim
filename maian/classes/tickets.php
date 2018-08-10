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

// Staff assignment..
function staffAssignment($ids) {
  global $msg_viewticket94;
  $html = '';
  if ($ids!='waiting') {
    $q    = mysql_query("SELECT `name`,`nameFrom` FROM ".DB_PREFIX."users WHERE `id` IN (".$ids.") ORDER BY `name`")
            or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    while ($U = mysql_fetch_object($q)) {
      $html .= mswCleanData($U->name).'<br />';
    }
  }
  return ($html ? $html : $msg_viewticket94);
}

// Update IP..
function updateTicketIP($ticket) {
  $ip = mswIPAddresses();
  mysql_query("UPDATE ".DB_PREFIX."tickets SET
  `ipAddresses` = '$ip'
  WHERE `id`    = '$ticket'
  LIMIT 1
  ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  return $ip;
}

// Get dispute ids for logged in user..
function getDisputeIDs() {
  $ids   = array();
  $query = mysql_query("SELECT * FROM ".DB_PREFIX."disputes 
           WHERE `userEmail` = '".MS_PERMISSIONS."' 
           ORDER BY `userName`
           ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  while ($U = mysql_fetch_object($query)) {
    $ids[] = $U->ticketID;
  }
  return $ids;
}

// Get users in dispute..
function mswUsersInDispute($ticket) {
  $html = '';
  $query = mysql_query("SELECT * FROM ".DB_PREFIX."disputes 
           WHERE `ticketID` = '{$ticket->id}'
           ORDER BY `userName`
           ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  while ($U = mysql_fetch_object($query)) {
    $html .= str_replace(array('{user}','{email}'),
                         array(mswSpecialChars($U->userName),
                               $U->userEmail
                         ),
                         file_get_contents(PATH.'templates/html/users-in-dispute.htm')
             );
  }
  return trim($html);
}

// Pre-populate..
function prePopulate() {
  $html = array();
  $q_dept = mysql_query("SELECT * FROM ".DB_PREFIX."departments 
            WHERE `showDept` = 'yes' 
            AND `id`         = '".(int)$_GET['prePopulation']."'
            ORDER BY `name`
            ") 
            or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $DEPT   = mysql_fetch_object($q_dept);
  $html[] = (isset($DEPT->dept_subject) && $DEPT->dept_subject ? $DEPT->dept_subject : 'none');
  $html[] = (isset($DEPT->dept_comments) && $DEPT->dept_comments ? $DEPT->dept_comments : 'none');
  return $html;
}

// Build departments..
function ticketDepartments() {
  global $dept;
  $html = '';
  $q_dept = mysql_query("SELECT * FROM ".DB_PREFIX."departments 
            WHERE `showDept` = 'yes' 
            ORDER BY `orderBy`
            ") 
            or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  if (mysql_num_rows($q_dept)>0) {
    while ($DEPT = mysql_fetch_object($q_dept)) {
      $html .= '<option value="'.$DEPT->id.'"'.($dept==$DEPT->id ? ' selected="selected"' : '').'>'.mswSpecialChars($DEPT->name).'</option>'.mswDefineNewline();
    }
  }
  return $html;
}

// Build spam sum div...
function spamSumDiv($eFields,$eString,$capErr) {
  global $msg_newticket26,$SETTINGS;
  if (defined('DISABLE_CAPTCHA')) {
    return '';
  }
  $html = '';
  $api  = RECAPTCHA_API_SERVER;
  // Is this a secure server..
  if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') {
    $api = RECAPTCHA_API_SECURE_SERVER;
  }
  if ($SETTINGS->recaptchaPublicKey && $SETTINGS->recaptchaPrivateKey) {
    $html = str_replace(array('{msg_newticket27}','{error}','{public_key}','{api_url}'),
                        array($msg_newticket26,
                              (in_array('sum',$eFields) ? '<span class="error" id="e_sum">'.$eString[5].'</span>' : ''),
                              $SETTINGS->recaptchaPublicKey.$capErr,
                              $api
                        ),
                        file_get_contents(PATH.'templates/html/recaptcha.htm')
            );
  }
  return $html;
}

// Build attachments div..
function ticketAttachments($eFields,$eString) {
  global $msg_newticket33,$msg_newticket14,$msg_script12,$msg_newticket34,
         $SETTINGS,$msg_newticket35,$msg_newticket37,$msg_newticket38;
  $html = '';
  $max  = (LICENCE_VER=='unlocked' ? $SETTINGS->attachboxes : RESTR_ATTACH);
  if ($SETTINGS->attachment=='yes') {
    $links    = '';
    $types    = '';
    $maxsize  = '';
    if ($max>1) {
     $links = str_replace(array('{text}','{max}','{add_box}','{remove_box}'),
                           array($msg_newticket33,
                                 $max,
                                 mswSpecialChars($msg_newticket37),
                                 mswSpecialChars($msg_newticket38)
                           ),
                           file_get_contents(PATH.'templates/html/attachments-links.htm')
               );
    }
    if ($SETTINGS->filetypes) {
      $types = '<span class="allowed_file_types">'.$msg_newticket34.': <span class="types">'.str_replace('|',ATTACH_TYPES_SEPERATOR,str_replace('.','',$SETTINGS->filetypes)).'</span></span>';
    }
    if ($SETTINGS->maxsize>0) {
      $maxsize = '<span class="max_file_size">'.$msg_newticket35.': <span class="size">'.mswFileSizeConversion($SETTINGS->maxsize).'</span></span>';
    }
    $html = str_replace(array('{msg_showticket6}','{msg_script12}','{error}','{add_remove_links}','{allowed_file_types}','{max_file_size}'),
                        array($msg_newticket14,
                              $msg_script12,
                              (in_array('attach',$eFields) ? '<span class="error" id="e_attach">'.$eString[4].'</span>' : ''),
                              $links,
                              $types,
                              $maxsize
                        ),
                        file_get_contents(PATH.'templates/html/attachments.htm')
            );
  }
  return $html;
}

// Build bbcode link..
function bbCode() {
  global $SETTINGS,$bb_code_buttons;
  $html = '';
  if ($SETTINGS->enableBBCode=='yes') {
    return str_replace(array(
                        '{more}','{link}','{email}','{image}','{link_txt}',
                        '{email_txt}','{image_txt}','{yt_txt}','{vim_txt}'
                       ),
                       array(
                        mswSpecialChars(str_replace("'","\'",$bb_code_buttons[3])),
                        mswSpecialChars(str_replace("'","\'",$bb_code_buttons[2])),
                        mswSpecialChars(str_replace("'","\'",$bb_code_buttons[1])),
                        mswSpecialChars(str_replace("'","\'",$bb_code_buttons[0])),
                        mswSpecialChars(str_replace("'","\'",$bb_code_buttons[6])),
                        mswSpecialChars(str_replace("'","\'",$bb_code_buttons[5])),
                        mswSpecialChars(str_replace("'","\'",$bb_code_buttons[4])),
                        mswSpecialChars(str_replace("'","\'",$bb_code_buttons[7])),
                        mswSpecialChars(str_replace("'","\'",$bb_code_buttons[8]))
                       ),
                       file_get_contents(PATH.'templates/html/bbcode-buttons.htm')
           );
  }
  return $html;
}

// Builds ticket attachments..
function buildAttachmentLinks($ticket,$reply=0,$type) {
  global $SETTINGS;
  $data  = '';
  $query = mysql_query("SELECT *,DATE(FROM_UNIXTIME(`ts`)) AS `addDate` FROM ".DB_PREFIX."attachments 
           WHERE `ticketID`  = '$ticket' 
           AND `replyID`     = '$reply'
           ORDER BY `id`
           ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  if (mysql_num_rows($query)>0) {
    while ($ATT = mysql_fetch_object($query)) {
      $split    = explode('-',$ATT->addDate);
      $folder   = '';
      // Check for newer folder structure..
      if (file_exists($SETTINGS->attachpath.'/'.$split[0].'/'.$split[1].'/'.$ATT->fileName)) {
        $folder  = $split[0].'/'.$split[1].'/';
      }
      $fileName = substr($ATT->fileName,0,strpos($ATT->fileName,'.'));
      $data    .= str_replace(array('{ext}','{url}','{file}','{size}','{type}','{file_name}'),
                              array(substr(strrchr(strtoupper($ATT->fileName),'.'),1),
                                    $folder.$ATT->fileName,
                                    substr($ATT->fileName,0,strpos($ATT->fileName,'.')),
                                    mswFileSizeConversion($ATT->fileSize),
                                    $type,
                                    (ATTACH_FILE_NAME_TRUNCATION>0 ? (strlen($fileName)>ATTACH_FILE_NAME_TRUNCATION ? substr($fileName,0,ATTACH_FILE_NAME_TRUNCATION).'..' : $fileName) : $fileName)
                              ),
                              file_get_contents(PATH.'templates/html/ticket-attachment.htm')
                  );
    }
  }
  return $data;
}

// Get ticket replies..
function getTicketReplies($id,$name) {
  global $msg_showticket20,$msg_viewticket43,$msg_entitiesdecode,$msg_showticket21,$msg_showticket33,$MSFIELDS,$SETTINGS;
  $data = '';
  $q_replies = mysql_query("SELECT * FROM ".DB_PREFIX."replies
               WHERE `ticketID` = '$id'
               ORDER BY `id`
               ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  if (mysql_num_rows($q_replies)>0) {
    while ($REPLIES = mysql_fetch_object($q_replies)) {
      $siggie = '';
      if ($REPLIES->disputeUser>0) {
        $REPLIES->replyType = 'dispute';
      }
      switch ($REPLIES->replyType) {
        case 'admin':
        $USER       = mswGetTableData('users','id',$REPLIES->replyUser);
        $replyName  = (isset($USER->name) ? mswSpecialChars($USER->name) : $msg_viewticket43);
        // Does this user have a siggie..
        if ($USER->signature) {
          $siggie = str_replace('{signature}',
                                (AUTO_PARSE_LINE_BREAKS ? nl2br(mswCleanData($USER->signature)) : mswCleanData($USER->signature)),
                                file_get_contents(PATH.'templates/html/reply-admin-signature.htm')
                    );
        }
        break;
        case 'visitor':
        $replyName  = $name;
        break;
        case 'dispute':
        $D                   = mswGetTableData('disputes','id',$REPLIES->disputeUser);
        $replyName           = (isset($D->userName) ? mswSpecialChars($D->userName) : 'N/A');
        $REPLIES->replyType  = 'visitor';
        break;
      }
      $data .= str_replace(array('{type}','{comments}','{signature}','{text}','{name}','{datetime}',
                                 '{attachments}','{anchor}','{custom_fields}'
                           ),
                           array($REPLIES->replyType,
                                 mswTxtParsingEngine($REPLIES->comments),
                                 $siggie,
                                 $msg_showticket21,
                                 $replyName,
                                 mswDateDisplay($REPLIES->ts,$SETTINGS->dateformat).' / '.mswTimeDisplay($REPLIES->ts,$SETTINGS->timeformat),
                                 supportTickets::buildAttachmentLinks($id,$REPLIES->id,$REPLIES->replyType),
                                 $REPLIES->id,
                                 $MSFIELDS->display($id,$REPLIES->id)
                           ),
                           file_get_contents(PATH.'templates/html/ticket-reply.htm')
               );
    }
  }
  return ($data ? trim($data) : str_replace('{text}',(defined('DISPUTE_VIEW') ? $msg_showticket33 : $msg_showticket20),file_get_contents(PATH.'templates/html/no-replies.htm')));
}

// Builds hidden fields for ticket reply..
function replyHiddenFields($ticket) {
  return '<input type="hidden" name="id" value="'.$ticket->id.'" />
  <input type="hidden" name="name" value="'.mswSpecialChars($ticket->name).'" />
  <input type="hidden" name="ticketno" value="'.mswTicketNumber($ticket->id).'" />
  <input type="hidden" name="subject" value="'.mswSpecialChars($ticket->subject).'" />
  <input type="hidden" name="dept" value="'.mswGetDepartmentName($ticket->department).'" />
  <input type="hidden" name="deptid" value="'.$ticket->department.'" />
  <input type="hidden" name="priority" value="'.mswGetPriorityLevel($ticket->priority).'" />
  <input type="hidden" name="email" value="'.mswSpecialChars($ticket->email).'" />
  ';
}

// Build portal ticket list..
function buildClosedDisputeTickets($email,$disputeIDs,$count=false) {
  global $msg_portal44,$msg_portal42,$msg_portal8,$msg_portal9,$msg_portal10,$msg_portal43,$SETTINGS,
         $msg_portal11,$msg_portal12,$limitvalue,$msg_portal15,$msg_portal19,$msg_portal21,$msg_portal35;
  $data  = '';
  $query = mysql_query("SELECT SQL_CALC_FOUND_ROWS * FROM ".DB_PREFIX."tickets 
           WHERE (`email` = '$email'
            AND `isDisputed`  IN ('yes')
           ) OR (
            `id` IN (".(!empty($disputeIDs) ? implode(',',$disputeIDs) : '0').")
            AND `isDisputed`   = 'yes'
           )
           ".ALL_DISPUTES_ORDER."
           LIMIT $limitvalue,".$SETTINGS->portalpages."
           ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  if ($count) {
    $c = mysql_fetch_object(mysql_query("SELECT FOUND_ROWS() AS rows"));
    return (isset($c->rows) ? $c->rows : '0');
  }         
  while ($TICKETS = mysql_fetch_object($query)) {
    // Ticket starter..
    $starter = mswSpecialChars($TICKETS->name);
    // Determine url..
    if ($TICKETS->ticketStatus=='closed') {
      $url = str_replace('{closed}',$msg_portal15,file_get_contents(PATH.'templates/html/portal-closed-link.htm'));
    } else {
      $url = str_replace(array('{ticketid}','{view}'),
                         array($TICKETS->id,($TICKETS->isDisputed=='yes' ? $msg_portal35 : $msg_portal8)),
                         file_get_contents(PATH.'templates/html/portal-open-'.($TICKETS->isDisputed=='yes' ? 'dispute' : 'ticket').'-link.htm')
             );
    }
    // If this is a dispute, who started it..
    if ($TICKETS->isDisputed=='yes') {
      if ($TICKETS->email==MS_PERMISSIONS) {
        $starter  = mswSpecialChars($TICKETS->name);
      } else {
        $TSTAR    = mswGetTableData('tickets','id',$TICKETS->id);
        $starter  = mswSpecialChars($TSTAR->name);
      }
    }
    $data .= str_replace(array('{high}','{title}','{ticket_id}','{url}','{opened}',
                               '{date}','{priority}','{priority_value}','{dept}','{dept_value}','{status}','{status_value}',
                               '{replies}','{reply_value}','{type}'),
                         array(($TICKETS->priority=='high' ? '_high' : ''),
                               mswSpecialChars($TICKETS->subject),
                               str_replace(array('{ticketID}','{name}','{count}'),
                                           array(mswTicketNumber($TICKETS->id),
                                                 $starter,
                                                 (mswRowCount('disputes WHERE ticketID = \''.$TICKETS->id.'\'')+1)
                                           ),
                                           ($TICKETS->isDisputed=='yes' ? $msg_portal43 : $msg_portal42)
                               ),
                               $url,
                               $msg_portal9,
                               mswDateDisplay($TICKETS->ts,$SETTINGS->dateformat),
                               $msg_portal10,
                               mswGetPriorityLevel($TICKETS->priority),
                               $msg_portal11,
                               mswGetDepartmentName($TICKETS->department),
                               $msg_portal12,
                               mswGetTicketStatus($TICKETS->ticketStatus,$TICKETS->replyStatus,'yes'),
                               $msg_portal19,
                               number_format(mswRowCount('replies WHERE ticketID = \''.$TICKETS->id.'\'')),
                               ($TICKETS->isDisputed=='yes' ? 'dispute' : 'ticket'),
                         ),
                         file_get_contents(PATH.'templates/html/portal-tickets.htm')
             );            
  }
  return ($data ? trim($data) : 
          str_replace('{text}',$msg_portal44,
          file_get_contents(PATH.'templates/html/portal-no-data.htm'))
  );
}

// Build search list..
function buildSearchPortalTickets($email,$disputeIDs,$count=false) {
  global $msg_portal42,$msg_portal8,$msg_portal9,$msg_portal10,$msg_portal43,$SETTINGS,
         $msg_portal11,$msg_portal12,$limitvalue,$msg_portal15,$msg_portal19,$msg_portal21,$msg_portal35;
  $data  = '';
  $keys  = strtolower($_GET['keys']);
  if (isset($_GET['f']) && in_array($_GET['f'],array('ts','ds'))) {
    switch($_GET['f']) {
      case 'ts':
      $query = mysql_query("SELECT SQL_CALC_FOUND_ROWS * FROM ".DB_PREFIX."tickets 
               WHERE `email`      = '$email'
               AND `isDisputed`  IN ('no')
               AND (`id` LIKE '%".ltrim(mswSafeImportString($keys),'0')."%' OR LOWER(`name`) LIKE '%".mswSafeImportString($keys)."%' OR LOWER(`comments`) LIKE '%".mswSafeImportString($keys)."%' OR LOWER(`subject`) LIKE '%".mswSafeImportString($keys)."%')
               ".ALL_TICKETS_ORDER."
               LIMIT $limitvalue,".$SETTINGS->portalpages."
               ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      break;
      case 'ds':
      $query = mysql_query("SELECT SQL_CALC_FOUND_ROWS * FROM ".DB_PREFIX."tickets 
               WHERE (`email` = '$email'
                 AND `isDisputed`  IN ('yes')
                 AND (`id` LIKE '%".ltrim(mswSafeImportString($keys),'0')."%' OR LOWER(`name`) LIKE '%".mswSafeImportString($keys)."%' OR LOWER(`comments`) LIKE '%".mswSafeImportString($keys)."%' OR LOWER(`subject`) LIKE '%".mswSafeImportString($keys)."%')
               ) OR (
                 `id` IN (".(!empty($disputeIDs) ? implode(',',$disputeIDs) : '0').")
                 AND `isDisputed`   = 'yes'
                 AND (`id` LIKE '%".ltrim(mswSafeImportString($keys),'0')."%' OR LOWER(`name`) LIKE '%".mswSafeImportString($keys)."%' OR LOWER(`comments`) LIKE '%".mswSafeImportString($keys)."%' OR LOWER(`subject`) LIKE '%".mswSafeImportString($keys)."%')
               )
               ".ALL_DISPUTES_ORDER."
               LIMIT $limitvalue,".$SETTINGS->portalpages."
               ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      break;
    }
  } else {
    $query = mysql_query("SELECT SQL_CALC_FOUND_ROWS * FROM ".DB_PREFIX."tickets 
             WHERE (`email` = '$email'
               AND `isDisputed` IN ('yes','no')
               AND (`id` LIKE '%".ltrim(mswSafeImportString($keys),'0')."%' OR LOWER(`name`) LIKE '%".mswSafeImportString($keys)."%' OR LOWER(`comments`) LIKE '%".mswSafeImportString($keys)."%' OR LOWER(`subject`) LIKE '%".mswSafeImportString($keys)."%')
             ) OR (
               `id` IN (".(!empty($disputeIDs) ? implode(',',$disputeIDs) : '0').")
               AND `isDisputed`  = 'yes'
               AND (`id` LIKE '%".ltrim(mswSafeImportString($keys),'0')."%' OR LOWER(`name`) LIKE '%".mswSafeImportString($keys)."%' OR LOWER(`comments`) LIKE '%".mswSafeImportString($keys)."%' OR LOWER(`subject`) LIKE '%".mswSafeImportString($keys)."%')
             )
             ".ALL_TICKETS_ORDER."
             LIMIT $limitvalue,".$SETTINGS->portalpages."
             ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
  if ($count) {
    $c = mysql_fetch_object(mysql_query("SELECT FOUND_ROWS() AS rows"));
    return (isset($c->rows) ? $c->rows : '0');
  }         
  while ($TICKETS = mysql_fetch_object($query)) {
    // Ticket starter..
    $starter = mswSpecialChars($TICKETS->name);
    // Determine url..
    if ($TICKETS->ticketStatus=='closed') {
      $url = str_replace('{closed}',$msg_portal15,file_get_contents(PATH.'templates/html/portal-closed-link.htm'));
    } else {
      $url = str_replace(array('{ticketid}','{view}'),
                         array($TICKETS->id,($TICKETS->isDisputed=='yes' ? $msg_portal35 : $msg_portal8)),
                         file_get_contents(PATH.'templates/html/portal-open-'.($TICKETS->isDisputed=='yes' ? 'dispute' : 'ticket').'-link.htm')
             );
    }
    $data .= str_replace(array('{high}','{title}','{ticket_id}','{url}','{opened}',
                               '{date}','{priority}','{priority_value}','{dept}','{dept_value}','{status}','{status_value}',
                               '{replies}','{reply_value}','{type}'),
                         array(($TICKETS->priority=='high' ? '_high' : ''),
                               mswSpecialChars($TICKETS->subject),
                               str_replace(array('{ticketID}','{name}','{count}'),
                                           array(mswTicketNumber($TICKETS->id),
                                                 $starter,
                                                 (mswRowCount('disputes WHERE ticketID = \''.$TICKETS->id.'\'')+1)
                                           ),
                                           ($TICKETS->isDisputed=='yes' ? $msg_portal43 : $msg_portal42)
                               ),
                               $url,
                               $msg_portal9,
                               mswDateDisplay($TICKETS->ts,$SETTINGS->dateformat),
                               $msg_portal10,
                               mswGetPriorityLevel($TICKETS->priority),
                               $msg_portal11,
                               mswGetDepartmentName($TICKETS->department),
                               $msg_portal12,
                               mswGetTicketStatus($TICKETS->ticketStatus,$TICKETS->replyStatus),
                               $msg_portal19,
                               number_format(mswRowCount('replies WHERE ticketID = \''.$TICKETS->id.'\'')),
                               ($TICKETS->isDisputed=='yes' ? 'dispute' : 'ticket'),
                         ),
                         file_get_contents(PATH.'templates/html/portal-tickets.htm')
             );            
  }
  return ($data ? trim($data) : 
          str_replace('{text}',$msg_portal21,
          file_get_contents(PATH.'templates/html/portal-no-data.htm'))
  );
}

// Build portal ticket list..
function buildClosedPortalTickets($email,$count=false) {
  global $msg_portal7,$msg_portal42,$msg_portal8,$msg_portal9,$msg_portal10,$msg_portal43,$SETTINGS,
         $msg_portal11,$msg_portal12,$limitvalue,$msg_portal15,$msg_portal19,$msg_portal21,$msg_portal35;
  $data  = '';
  $query = mysql_query("SELECT SQL_CALC_FOUND_ROWS * FROM ".DB_PREFIX."tickets 
           WHERE `email`      = '$email'
           AND `isDisputed`  IN ('no')
           ".ALL_TICKETS_ORDER."
           LIMIT $limitvalue,".$SETTINGS->portalpages."
           ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  if ($count) {
    $c = mysql_fetch_object(mysql_query("SELECT FOUND_ROWS() AS rows"));
    return (isset($c->rows) ? $c->rows : '0');
  }         
  while ($TICKETS = mysql_fetch_object($query)) {
    // Ticket starter..
    $starter = mswSpecialChars($TICKETS->name);
    // Determine url..
    if ($TICKETS->ticketStatus=='closed') {
      $url = str_replace('{closed}',$msg_portal15,file_get_contents(PATH.'templates/html/portal-closed-link.htm'));
    } else {
      $url = str_replace(array('{ticketid}','{view}'),
                         array($TICKETS->id,($TICKETS->isDisputed=='yes' ? $msg_portal35 : $msg_portal8)),
                         file_get_contents(PATH.'templates/html/portal-open-'.($TICKETS->isDisputed=='yes' ? 'dispute' : 'ticket').'-link.htm')
             );
    }
    $data .= str_replace(array('{high}','{title}','{ticket_id}','{url}','{opened}',
                               '{date}','{priority}','{priority_value}','{dept}','{dept_value}','{status}','{status_value}',
                               '{replies}','{reply_value}','{type}'),
                         array(($TICKETS->priority=='high' ? '_high' : ''),
                               mswSpecialChars($TICKETS->subject),
                               str_replace(array('{ticketID}','{name}','{count}'),
                                           array(mswTicketNumber($TICKETS->id),
                                                 $starter,
                                                 (mswRowCount('disputes WHERE ticketID = \''.$TICKETS->id.'\'')+1)
                                           ),
                                           ($TICKETS->isDisputed=='yes' ? $msg_portal43 : $msg_portal42)
                               ),
                               $url,
                               $msg_portal9,
                               mswDateDisplay($TICKETS->ts,$SETTINGS->dateformat),
                               $msg_portal10,
                               mswGetPriorityLevel($TICKETS->priority),
                               $msg_portal11,
                               mswGetDepartmentName($TICKETS->department),
                               $msg_portal12,
                               mswGetTicketStatus($TICKETS->ticketStatus,$TICKETS->replyStatus),
                               $msg_portal19,
                               number_format(mswRowCount('replies WHERE ticketID = \''.$TICKETS->id.'\'')),
                               ($TICKETS->isDisputed=='yes' ? 'dispute' : 'ticket'),
                         ),
                         file_get_contents(PATH.'templates/html/portal-tickets.htm')
             );            
  }
  return ($data ? trim($data) : 
          str_replace('{text}',$msg_portal7,
          file_get_contents(PATH.'templates/html/portal-no-data.htm'))
  );
}

// Build portal ticket list..
function buildPortalTickets($email,$disputeIDs,$count=false) {
  global $msg_portal7,$msg_portal42,$msg_portal8,$msg_portal9,$msg_portal10,$msg_portal43,$msg_portal44,$SETTINGS,
         $msg_portal11,$msg_portal12,$limitvalue,$msg_portal15,$msg_portal19,$msg_portal21,$msg_portal35;
  $data  = '';
  if (isset($_GET['display'])) {
  switch($_GET['display']) {
    case 'tickets':
    $query = mysql_query("SELECT SQL_CALC_FOUND_ROWS * FROM ".DB_PREFIX."tickets 
             WHERE `email`      = '$email'
             AND `isDisputed`  IN ('no')
             AND `ticketStatus` = 'open'
             ".ALL_TICKETS_ORDER."
             LIMIT $limitvalue,".$SETTINGS->portalpages."
             ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    break;
    case 'disputes':
    $query = mysql_query("SELECT SQL_CALC_FOUND_ROWS * FROM ".DB_PREFIX."tickets 
             WHERE (`email` = '$email'
               AND `isDisputed`  IN ('yes')
               AND `ticketStatus` = 'open'
             ) OR (
               `id` IN (".(!empty($disputeIDs) ? implode(',',$disputeIDs) : '0').")
               AND `isDisputed`   = 'yes'
               AND `ticketStatus` = 'open'
             )
             ".ALL_DISPUTES_ORDER."
             LIMIT $limitvalue,".$SETTINGS->portalpages."
             ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    break;
  }
  } else {
  $query = mysql_query("SELECT SQL_CALC_FOUND_ROWS * FROM ".DB_PREFIX."tickets 
           WHERE (`email` = '$email'
             AND `isDisputed` IN ('yes','no')
             AND `ticketStatus` = 'open'
           ) OR (
             `id` IN (".(!empty($disputeIDs) ? implode(',',$disputeIDs) : '0').")
             AND `isDisputed`  = 'yes'
             AND `ticketStatus` = 'open'
           )
           ".ALL_TICKETS_ORDER."
           LIMIT $limitvalue,".$SETTINGS->portalpages."
           ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
  if ($count) {
    $c = mysql_fetch_object(mysql_query("SELECT FOUND_ROWS() AS rows"));
    return (isset($c->rows) ? $c->rows : '0');
  }         
  while ($TICKETS = mysql_fetch_object($query)) {
    // Ticket starter..
    $starter = mswSpecialChars($TICKETS->name);
    // Determine url..
    if ($TICKETS->ticketStatus=='closed') {
      $url = str_replace('{closed}',$msg_portal15,file_get_contents(PATH.'templates/html/portal-closed-link.htm'));
    } else {
      $url = str_replace(array('{ticketid}','{view}'),
                         array($TICKETS->id,($TICKETS->isDisputed=='yes' ? $msg_portal35 : $msg_portal8)),
                         file_get_contents(PATH.'templates/html/portal-open-'.($TICKETS->isDisputed=='yes' ? 'dispute' : 'ticket').'-link.htm')
             );
    }
    // If this is a dispute, who started it..
    if ($TICKETS->isDisputed=='yes') {
      if ($TICKETS->email==MS_PERMISSIONS) {
        $starter  = mswSpecialChars($TICKETS->name);
      } else {
        $TSTAR    = mswGetTableData('tickets','id',$TICKETS->id);
        $starter  = mswSpecialChars($TSTAR->name);
      }
    }
    $data .= str_replace(array('{high}','{title}','{ticket_id}','{url}','{opened}',
                               '{date}','{priority}','{priority_value}','{dept}','{dept_value}','{status}','{status_value}',
                               '{replies}','{reply_value}','{type}'),
                         array(($TICKETS->priority=='high' ? '_high' : ''),
                               mswSpecialChars($TICKETS->subject),
                               str_replace(array('{ticketID}','{name}','{count}'),
                                           array(mswTicketNumber($TICKETS->id),
                                                 $starter,
                                                 (mswRowCount('disputes WHERE ticketID = \''.$TICKETS->id.'\'')+1)
                                           ),
                                           ($TICKETS->isDisputed=='yes' ? $msg_portal43 : $msg_portal42)
                               ),
                               $url,
                               $msg_portal9,
                               mswDateDisplay($TICKETS->ts,$SETTINGS->dateformat),
                               $msg_portal10,
                               mswGetPriorityLevel($TICKETS->priority),
                               $msg_portal11,
                               mswGetDepartmentName($TICKETS->department),
                               $msg_portal12,
                               mswGetTicketStatus($TICKETS->ticketStatus,$TICKETS->replyStatus,$TICKETS->isDisputed),
                               $msg_portal19,
                               number_format(mswRowCount('replies WHERE ticketID = \''.$TICKETS->id.'\'')),
                               ($TICKETS->isDisputed=='yes' ? 'dispute' : 'ticket'),
                         ),
                         file_get_contents(PATH.'templates/html/portal-tickets.htm')
             );            
  }
  return ($data ? trim($data) : 
          str_replace('{text}',(isset($_GET['display']) && $_GET['display']=='disputes' ? $msg_portal44 : $msg_portal7),file_get_contents(PATH.'templates/html/portal-no-data.htm'))
  );
}

// Check if portal e-mail exists..
function isPortal($email) {
  $query = mysql_query("SELECT * FROM ".DB_PREFIX."portal
           WHERE `email` = '$email'
           LIMIT 1
           ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  return (mysql_num_rows($query)>0 ? true : false);
}

// Create portal login..
function createPortalLogin($email) {
  global $SETTINGS;
  $pass = substr (md5(uniqid(rand(),1)),3,PASS_CHARS);
  mysql_query("INSERT INTO ".DB_PREFIX."portal (
  `ts`,`email`,`userPass`
  ) VALUES (
  UNIX_TIMESTAMP(UTC_TIMESTAMP),'$email','".md5(SECRET_KEY.$pass)."'
  )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  return $pass;
}

// Check attachment file size..
function checkFileSize($size) {
  global $SETTINGS;
  if ($SETTINGS->maxsize==0) {
    return true;
  }
  return ($size<=$SETTINGS->maxsize ? true : false);
}

// Check attachment file type..
function checkFileType($file) {
  global $SETTINGS;
  if ($SETTINGS->filetypes=='') {
    return true;
  }
  $types  = explode("|",strtolower($SETTINGS->filetypes));
  $ext    = strrchr(strtolower($file), '.');
  return (in_array($ext,$types) ? true : false);
}

// Rename attachment..
function getAttachmentName($ext,$ticket,$name,$reply=0,$incr) {
  global $SETTINGS;
  if ($SETTINGS->rename=='no') {
    return $name;
  }
  $rand = substr(md5(uniqid(rand(),1)),3,MAX_CHARS_RENAME_RAND);
  return $ticket.($reply>0 ? '_'.$reply : '').'-'.$incr.'-'.$rand.($ext ? $ext : NO_ATTACHMENT_EXT_DEFAULT);
}

// Upload attachments..
function uploadFiles($temp,$name,$size,$ticket,$reply=0) {
  global $SETTINGS;
  $folder = '';
  if (!is_dir($SETTINGS->attachpath)) {
    die('Attachment Path Incorrect: &quot;'.$SETTINGS->attachpath.'&quot; does not exist. Check settings and try again..');
  }
  if (is_writeable($SETTINGS->attachpath)) {
    if (is_uploaded_file($temp)) {
      $U  = $SETTINGS->attachpath.'/'.$name;
      $Y  = date('Y',mswTimeStamp());
      $M  = date('m',mswTimeStamp());
      // Create folders..
      if (!is_dir($SETTINGS->attachpath.'/'.$Y)) {
        $omask = @umask(0); 
        @mkdir($SETTINGS->attachpath.'/'.$Y,0777);
        @umask($omask);
      }
      if (is_dir($SETTINGS->attachpath.'/'.$Y)) {
        if (!is_dir($SETTINGS->attachpath.'/'.$Y.'/'.$M)) {
          $omask = @umask(0); 
          @mkdir($SETTINGS->attachpath.'/'.$Y.'/'.$M,0777);
          @umask($omask);
        }
        if (is_dir($SETTINGS->attachpath.'/'.$Y.'/'.$M)) {
          $U       = $SETTINGS->attachpath.'/'.$Y.'/'.$M.'/'.$name;
          $folder  = $Y.'/'.$M.'/';
        }
      }
      // Upload file..
      move_uploaded_file($temp,$U);
      // Required by some servers to make image viewable and accessible via FTP..
      @chmod($U,0644);
    }
    if (isset($_POST['dept'])) {
      $_GET['dept'] = $_POST['dept'];
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
      '$ticket',
      '$reply',
      '{$_GET['dept']}',
      '$name',
      '$size'
      )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      // Remove temp file..
      if (file_exists($temp)) {
        @unlink($temp);
      }
    }
  } else {
    die('Error: &quot;'.$SETTINGS->attachpath.'&quot; folder NOT writeable! Please Update!');
  }
  return $folder;
}

// Open new ticket..
function openNewTicket($imap=false,$fields=false,$assign='no') {
  global $msg_piping7,$msg_script37,$SETTINGS;
  mysql_query("INSERT INTO ".DB_PREFIX."tickets (
  `ts`,
  `lastrevision`,
  `department`,
  `assignedto`,
  `name`,
  `email`,
  `subject`,
  `mailBodyFilter`,
  `comments`,
  `priority`,
  `replyStatus`,
  `ticketStatus`,
  `ipAddresses`,
  `tickLang`
  ) VALUES (
  UNIX_TIMESTAMP(UTC_TIMESTAMP),
  UNIX_TIMESTAMP(UTC_TIMESTAMP),
  '".(int)$_POST['dept']."',
  '".($assign=='yes' ? 'waiting' : '')."',
  '".mswSafeImportString($_POST['name'])."',
  '".mswSafeImportString($_POST['email'])."',
  '".mswSafeImportString($_POST['subject'])."',
  '".(isset($_POST['quoteBody']) ? mswSafeImportString($_POST['quoteBody']) : '')."',
  '".mswSafeImportString($_POST['comments'])."',
  '".mswSafeImportString($_POST['priority'])."',
  'start',
  'open',
  '".($imap ? $msg_piping7 : (defined('XML_DATA_POST') ? $msg_script37 : mswIPAddresses()))."',
  '".mswVisLang()."'
  )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $id = mysql_insert_id();
  // Custom fields..
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
      if ($data!='' && $data!='nothing-selected' && mswRowCount('ticketfields WHERE `ticketID` = \''.$id.'\' AND `fieldID` = \''.$k.'\' AND `replyID` = \'0\'')==0) {
        mysql_query("INSERT INTO ".DB_PREFIX."ticketfields (
        `fieldData`,`ticketID`,`fieldID`,`replyID`
        ) VALUES (
        '".mswSafeImportString($data)."','$id','$k','0'
        )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      }
    }
  }
  // Return new ticket id..
  return $id;
}

// Add ticket reply..
function addTicketReply($imap=false) {
  global $PRIV,$SETTINGS;
  if (isset($_GET['d'])) {
    $_GET['t'] = $_GET['d'];
  }
  global $msg_piping7;
  mysql_query("INSERT INTO ".DB_PREFIX."replies (
  `ts`,
  `ticketID`,
  `comments`,
  `mailBodyFilter`,
  `replyType`,
  `replyUser`,
  `isMerged`,
  `ipAddresses`,
  `disputeUser`
  ) VALUES (
  UNIX_TIMESTAMP(UTC_TIMESTAMP),
  '{$_GET['t']}',
  '".mswSafeImportString($_POST['comments'])."',
  '".(isset($_POST['quoteBody']) ? mswSafeImportString($_POST['quoteBody']) : '')."',
  'visitor',
  '0',
  'no',
  '".($imap ? $msg_piping7 : mswIPAddresses())."',
  '".(isset($PRIV->id) ? $PRIV->id : '0')."'
  )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $id = mysql_insert_id();
  // Are we closing ticket..
  if (isset($_POST['close'])) {
    mysql_query("UPDATE ".DB_PREFIX."tickets SET
    `lastrevision`  = UNIX_TIMESTAMP(UTC_TIMESTAMP),
    `ticketStatus`  = 'close',
    `replyStatus`   = 'admin'
    WHERE `id`      = '{$_GET['t']}'
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  } else {
    mysql_query("UPDATE ".DB_PREFIX."tickets SET
    `lastrevision`  = UNIX_TIMESTAMP(UTC_TIMESTAMP),
    `ticketStatus`  = 'open',
    `replyStatus`   = 'admin'
    WHERE `id`      = '{$_GET['t']}'
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  }
  // Custom fields..
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
      if ($data!='' && $data!='nothing-selected' && mswRowCount('ticketfields WHERE `ticketID` = \''.$_GET['t'].'\' AND `fieldID` = \''.$k.'\' AND `replyID` = \''.$id.'\'')==0) {
        mysql_query("INSERT INTO ".DB_PREFIX."ticketfields (
        `fieldData`,`ticketID`,`fieldID`,`replyID`
        ) VALUES (
        '".mswSafeImportString($data)."','{$_GET['t']}','$k','$id'
        )") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      }
    }
  }
  return $id;
}

}

?>