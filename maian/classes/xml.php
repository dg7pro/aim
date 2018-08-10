<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: xml.php
  Description: Class File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

class xmlDataPost {

function read($data) {
  if (!empty($data)) {
    return simplexml_load_string($data,'SimpleXMLElement',LIBXML_NOCDATA);; 
  }
  echo '<?xml version="1.0" encoding="utf-8"?><datapost><status>DATA-ERROR</status><reason>No incoming POST data received</reason></datapost>';
  exit;
}

function key($xml) {
  global $SETTINGS;
  return (isset($xml->api) && $xml->api==$SETTINGS->apiKey ? 'ok' : 'error');
}

function response($code) {
  switch ($code) {
    case 'key':
    $status = 'ERROR';
    $txt    = 'Invalid API key';
    echo '<?xml version="1.0" encoding="utf-8"?><datapost><status>'.$status.'</status><reason>'.$txt.'</reason></datapost>';
    break;
    case 'no-tickets':
    $status = 'ERROR';
    $txt    = 'No Tickets Created from XML. Check XML structure is correct. Name,Email,Subject and Comments are Required. Department number must be valid.';
    echo '<?xml version="1.0" encoding="utf-8"?><datapost><status>'.$status.'</status><reason>'.$txt.'</reason></datapost>';
    break;
    case 'ok':
    $status = 'OK';
    echo '<?xml version="1.0" encoding="utf-8"?><datapost><status>'.$status.'</status></datapost>';
    break;
  }
  exit;
}

function ticket($obj) {
  global $levelPrKeys;
  $obj                = (array)$obj;
  $ticket['name']     = (isset($obj['name']) ? $obj['name'] : '');
  $ticket['email']    = (isset($obj['email']) && mswIsValidEmail($obj['email']) ? $obj['email'] : '');
  $ticket['dept']     = (isset($obj['dept']) && mswRowCount('departments WHERE id = \''.(int)$obj['dept'].'\'')>0 ? (int)$obj['dept'] : '0');
  $ticket['subject']  = (isset($obj['subject']) ? $obj['subject'] : '');
  $ticket['comments'] = (isset($obj['comments']) ? $obj['comments'] : '');
  $ticket['priority'] = (isset($obj['priority']) && in_array(strtolower($obj['priority']),$levelPrKeys) ? $obj['priority'] : 'low');
  return $ticket;
}

function saveBase64Attachment($data,$ext,$ticket,$incr) {
  global $SETTINGS,$MSTICKET;
  $name   = $ticket.'-'.$incr.'.'.strtolower($ext);
  $folder = '';
  if (is_writeable($SETTINGS->attachpath)) {
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
    // Save base64 encoded data as file..
    $fp = fopen($U,'wb');
    if ($fp) {
      fwrite ($fp, base64_decode($data));
      fclose ($fp);
    }
    // Check file size..
    if (file_exists($U)) {
      $size = @filesize($U);
      if (!$MSTICKET->checkFileSize($size)) {
        @unlink($U);
        return array('ERR');
      } else {
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
        '0',
        '{$_POST['dept']}',
        '$name',
        '$size'
        )");
        return array('OK',$folder,$name,$size);
      }
    }  
  }
  return array('ERR');
}

function fields($obj) {
  $fields = array();
  if (!empty($obj)) {
    return (array)$obj;
  }
  return $fields;
}

function insertField($ticket,$field,$data) {
  mysql_query("INSERT INTO ".DB_PREFIX."ticketfields (
  `ticketID`,
	`fieldID`,
	`replyID`,
	`fieldData`
  ) VALUES (
  '$ticket',
  '$field',
  '0',
  '".mswSafeImportString($data)."'
  )");
}

}

?>