<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: imap.php
  Description: Class File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

class emailPipe {

function emailPipe($imap) {
  $this->imapController = $imap;
}

// Decode string..does nothing..
function decodeString($instr) {
  return $instr;
}

// Connect to mailbox..
function connectToMailBox() {
  global $msg_piping,$msg_piping2,$msg_piping3,$msg_piping4,$msg_piping9;
  $connect = @imap_open('{'.$this->imapController->im_host.':'.$this->imapController->im_port.'/'.$this->imapController->im_protocol.
                         ($this->imapController->im_ssl=='yes' ? '/ssl' : '').
                         ($this->imapController->im_flags ? $this->imapController->im_flags : '').
                       '}'.$this->imapController->im_name,
                       $this->imapController->im_user,
                       $this->imapController->im_pass
             );
  if (!$connect) {
    if (ENABLE_IMAP_DEBUG) {
      @imap_close($connect); 
      // Silent errors..
      @imap_errors();
      @imap_alerts();
      die('Connection to <b>'.strtoupper($this->imapController->im_protocol).'</b> Mail Server (<b>'.$this->imapController->im_host.'</b>) 
           @ Port <b>'.$this->imapController->im_port.'</b> Failed!
         <ul>
           <li>'.$msg_piping.'</li>
           <li>'.$msg_piping2.'</li>
           <li>'.$msg_piping3.'</li>
           <li>'.$msg_piping4.'</li>
         </ul>
        ');
    } else {
      $connect = '';
    }
  }
  // Calling imap_errors here clears stack and prevents notice errors of empty mailbox..
  imap_errors();
  return $connect;
}

// Add attachment to database..
function addAttachmentToDB($ticket,$reply,$n,$s) {
  global $SETTINGS;
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
  '{$this->imapController->im_dept}',
  '$n',
  '$s'
  )");
}

// Upload e-mail attachment..
function uploadEmailAttachment($file,$attachment) {
  global $SETTINGS;
  $folder  = '';
  $U       = $SETTINGS->attachpath.'/'.$file;
  $Y       = date('Y',mswTimeStamp());
  $M       = date('m',mswTimeStamp());
  // Create folders..
  if (!is_dir($SETTINGS->attachpath.'/'.$Y)) {
    $omask = @umask(0); 
    @mkdir($SETTINGS->attachpath.'/'.$Y,ATTACH_CHMOD_VALUE);
    @umask($omask);
  }
  if (is_dir($SETTINGS->attachpath.'/'.$Y)) {
    if (!is_dir($SETTINGS->attachpath.'/'.$Y.'/'.$M)) {
      $omask = @umask(0); 
      @mkdir($SETTINGS->attachpath.'/'.$Y.'/'.$M,ATTACH_CHMOD_VALUE);
      @umask($omask);
    }
    if (is_dir($SETTINGS->attachpath.'/'.$Y.'/'.$M)) {
      $U       = $SETTINGS->attachpath.'/'.$Y.'/'.$M.'/'.$file;
      $folder  = $Y.'/'.$M.'/';
    }
  }
  $fp = @fopen($U,'ab');
  if ($fp) {
    @fwrite($fp,trim($attachment));
    @fclose($fp);
  }
  return $folder;
}

// Read mailbox..
function readMailBox($connection,$msg) {
  $other             = array();
  $headers           = emailPipe::extractHeaderData(imap_header($connection,$msg));
  $enc               = emailPipe::getParams(imap_fetchstructure($connection,$msg));
  $other['ticketID'] = emailPipe::getTicketID($headers['subject'],$headers['email']);
  $other['body']     = emailPipe::getMessageBody($msg,$connection);
  return array_merge($headers,$enc,$other);
}

// Move mail..
function moveMail($connection,$msg) {
  @imap_mail_move($connection,$msg,$this->imapController->im_move);
}

// Extract header data..
function extractHeaderData($h) {
  global $msg_piping6;
  $sender      = $h->from[0];
  return       array (
  'from'       => emailPipe::mimeDecode($sender->personal),
  'email'      => strtolower($sender->mailbox).'@'.$sender->host,
  'subject'    => ($h->subject ? emailPipe::mimeDecode($h->subject) : $msg_piping6),
  'messageID'  => $h->message_id,
  'timestamp'  => strtotime($h->date)
  );
}

// Get ticket id from e-mail subject..
function getTicketID($subject,$email) {
  $ticketid = 0;
  if(preg_match("[[#][0-9]{1,12}]",$subject,$regs)) {
    $ticketid = mswReverseTicketNumber(trim(preg_replace('/[^0-9]/','',$regs[0])));
    if (mswRowCount('tickets WHERE `id` = \''.$ticketid.'\' AND `email` = \''.$email.'\'')>0) {
      return array('yes',$ticketid);
    }
  }
  return array('no',0);
}

// Assign mail parameters..
function getParams($h) {
  global $msg_pipe_charset;
  $mimeTypes   = array('TEXT','MULTIPART','MESSAGE','APPLICATION','AUDIO','IMAGE','VIDEO','OTHER');
  $params      = (isset($h->parameters[0]) ? $h->parameters[0] : '');
  return       array(
  'charset'    => (isset($h->ifparameters) ? $params->value : $msg_pipe_charset),
  'bytes'      => (isset($h->bytes) ? $h->bytes : ''),
  'encoding'   => (isset($h->encoding) ? $h->encoding : ''),
  'type'       => (isset($h->type) ? $h->type : ''),
  'attribute'  => (isset($params->attribute) ? $params->attribute : ''),
  'mime'       => (!isset($h->subtype) || $h->subtype=='' ? 'TEXT/PLAIN' : (isset($mimeTypes[$h->type]) ? $mimeTypes[$h->type].'/'.(isset($h->subtype) ? $h->subtype : 'TEXT/PLAIN') : 'TEXT/PLAIN'))
  );
}

// Attempt to remove reply quote..
function removeReplyQuote($text,$reply) {
  if (strrpos($text,trim($reply))!==FALSE) {
    return substr($text,0,strrpos($text,trim($reply)));
  } else {
    return $text;
  }
}

// Get message body of e-mail..
function getMessageBody($msg,$connection) {
  global $msg_pipe_charset;
  $message  = '';
  $message  = emailPipe::getPart($msg,'TEXT/PLAIN',$connection,$msg_pipe_charset);
  if (!$message) {
    $message =  emailPipe::getPart($msg,'TEXT/HTML',$connection,$msg_pipe_charset);
    $message =  str_replace('</DIV><DIV>',"\n",$message);
    $message =  str_replace(array('<br>','<br />','<BR>','<BR />'),"\n", $message);
    return strip_tags(html_entity_decode($message));
  }
  return trim($message);
}

// Read mail..
function getPart($mid,$mimeType,$connection,$encoding=false,$struct='',$partNumber=''){
  if(!$struct && $mid) {
    $struct = imap_fetchstructure($connection,$mid);
  }
  if ($struct && !$struct->ifdparameters && in_array($mimeType,array('TEXT/PLAIN','TEXT/HTML'))) {
    $partNumber = ($partNumber ? $partNumber : 1);
    if ($text = imap_fetchbody($connection,$mid,$partNumber)) {
      if ($struct->encoding==3 or $struct->encoding==4) {
        $text    = emailPipe::decodeText($struct->encoding,$text);
        $charset = null;
        if($encoding) {
          if($struct->ifparameters) {
            if(!strcasecmp($struct->parameters[0]->attribute,'CHARSET') && strcasecmp($struct->parameters[0]->value,'US-ASCII')) {
              $charset = trim($struct->parameters[0]->value);
            }
            $text = emailPipe::mimeEncode($text,$charset,$encoding);
          }
        }
      }
      return $text;
    }
    // Do recursive search
    $text = '';
    if ($struct && !empty($struct->parts)) {
      while (list($i,$substruct) = each($struct->parts)) {
        if($partNumber) {
          $prefix = $partNumber.'.';
          if(($result = $this->getPart($mid,$mimeType,$encoding,$substruct,$prefix.($i+1),$partNumber))) {
            $text .= $result;
          }
        }
      }
    } 
    return $text;
  }
}

// Close mailbox..
function closeMailbox($connection) {
  imap_expunge($connection);
  imap_close($connection); 
  imap_errors();
  imap_alerts();
}

// Flag message..
function flagMessage($connection,$msg) {
  imap_setflag_full($connection,imap_uid($connection,$msg),"\\Seen",ST_UID);
  // Delete if move option not set..
  imap_delete($connection,$msg);
}

// Assign mime encoding..
function mimeEncode($text,$charset='',$enc='utf-8') {
  global $msg_pipe_charset;
  if ($enc=='' || $enc=='0') {
    $enc = $msg_pipe_charset;
  }
  if ($charset=='') {
    $charset = $msg_pipe_charset;
  }
  $encodings = array('UTF-8','WINDOWS-1251','ISO-8859-5','ISO-8859-1','KOI8-R');
  if (function_exists("iconv") && $text) {
    if($charset) {
      return iconv($charset,$enc.'//IGNORE',$text);
    } elseif (function_exists('mb_detect_encoding')) {
      return iconv(mb_detect_encoding($text,$encodings),$enc,$text);
    }
    return utf8_encode(quoted_printable_decode($text));
  }
}

// Mime encoding..
function mimeDecode($text) {
  $a    = imap_mime_header_decode($text);
  $str  = '';
  foreach ($a as $k => $part) {
    $str .= $part->text;
  }
  return $str ? $str : imap_utf8($text);  
}

// Decode text..
function decodeText($encoding,$text) {
  switch($encoding) {
    case 1:
    $text = imap_8bit($text);
    break;
    case 2:
    $text = imap_binary($text);
    break;
    case 3:
    $text = imap_base64($text);
    break;
    case 4:
    $text = imap_qprint($text);
    break;
    case 5:
    default:
    $text = $text;
    break;
  } 
  return $text;
}

// Read mail attachments into array..
function readAttachments($connection,$msg) {
  $attachments  = array();
  $att          = emailPipe::extractAttachments($connection,$msg);
  $count        = 0;
  if (!empty($att)) {
    for ($j=0; $j<count($att); $j++) {
      if (isset($att[$j]['is_attachment']) && isset($att[$j]['attachment'])) {
        if ($att[$j]['is_attachment']==1 && $att[$j]['attachment']!='') {
          ++$count;
          if (LICENCE_VER=='locked' && $count<=RESTR_ATTACH) {
            $attachments[$count]['file']        = $att[$j]['filename'];
            $attachments[$count]['attachment']  = $att[$j]['attachment'];
            $attachments[$count]['ext']         = (strpos($att[$j]['filename'],'.')!==FALSE ? strrchr(strtolower($att[$j]['filename']),'.') : '.txt');
          } else {
            if (LICENCE_VER=='unlocked') {
              $attachments[$count]['file']        = $att[$j]['filename'];
              $attachments[$count]['attachment']  = $att[$j]['attachment'];
              $attachments[$count]['ext']         = (strpos($att[$j]['filename'],'.')!==FALSE ? strrchr(strtolower($att[$j]['filename']),'.') : '.txt');
            }
          }
        }
      }
    }
  }
  return $attachments;
}

// Extract attachments from email..
function extractAttachments($connection,$message_number) {
  $attachments = array();
  $structure   = imap_fetchstructure($connection,$message_number);
  if(isset($structure->parts) && count($structure->parts)) {
    for($i=0; $i<count($structure->parts); $i++) {
      $attachments[$i] = array('is_attachment' => false,
                               'filename'      => '',
                               'name'          => '',
                               'attachment'    => ''
                         );
      if($structure->parts[$i]->ifdparameters>0) {
        foreach($structure->parts[$i]->dparameters as $object) {
          if(strtolower($object->attribute)=='filename') {
            $attachments[$i]['is_attachment'] = true;
            $attachments[$i]['filename']      = $object->value;
          }
        }
      }
      if($structure->parts[$i]->ifparameters>0) {
        foreach($structure->parts[$i]->parameters as $object) {
          if(strtolower($object->attribute)== 'name') {
            $attachments[$i]['is_attachment'] = true;
            $attachments[$i]['name']          = $object->value;
          }
        }
      }
      if($attachments[$i]['is_attachment']) {
        $attachments[$i]['attachment'] = imap_fetchbody($connection, $message_number, $i+1);
        if($structure->parts[$i]->encoding==3) { // 3 = BASE64
          $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
        } elseif($structure->parts[$i]->encoding==4) { // 4 = QUOTED-PRINTABLE
          $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
        }
      }
    }
  }
  return $attachments;
}

}

?>