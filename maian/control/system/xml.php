<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  XMP-RPC Handler

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

// Check simple xml is available..
if (!function_exists('simplexml_load_string')) {
  die('Error: <a href="http://php.net/manual/en/book.simplexml.php">Simple XML</a> functions required on server for this function to work. Recompile with simple xml support if running PHP5.');
}

$created = 0;
define('XML_DATA_POST', 1);

//--------------
// Incoming..
//--------------

$data  = urldecode(file_get_contents('php://input'));
//$data   = urldecode(file_get_contents(PATH.'example.xml'));

if ($data=='' || empty($_POST)) {
  die ('No post data received. Data sent must be sent as a http data post. See the <a href="docs/install_6.html">docs</a> for help');
}

$MSXML  = $DP->read($data); 

//-----------------
// Read XML..
//-----------------

if ($DP->key($MSXML)=='ok') {
  
  //----------------------
  // Loop ticket data..
  //----------------------
  
  for ($i=0; $i<count($MSXML->tickets->ticket); $i++) {
  
    //----------------------------------------
    // Load ticket data into variables..
    //----------------------------------------
    
    $newTicket          = $DP->ticket($MSXML->tickets->ticket[$i]);
    $_POST['name']      = $newTicket['name'];
    $_POST['email']     = $newTicket['email'];
    $_POST['dept']      = $newTicket['dept'];
    $_POST['subject']   = $newTicket['subject'];
    $_POST['comments']  = $newTicket['comments'];
    $_POST['priority']  = $newTicket['priority'];
    $attachString       = '';
    
    //------------------------------------------------
    // Department preferences..
    //------------------------------------------------
      
    $MAN_ASSIGN = mswGetDepartmentName($_POST['dept'],true); 
    
    //----------------------------------
    // Create ticket
    //----------------------------------
    
    if ($_POST['name'] && $_POST['email'] && $_POST['subject'] && $_POST['comments'] && $_POST['dept']>0) {
      ++$created;
      
      //---------------------
      // Create..
      //---------------------
      
      $ticketID = $MSTICKET->openNewTicket(false,false,$MAN_ASSIGN->manual_assign);
      
      //--------------------------------------------
      // First time user? Create login details..
      //--------------------------------------------
      
      $userPass = '';
      if (!$MSTICKET->isPortal($_POST['email'])) {
        $userPass = $MSTICKET->createPortalLogin($_POST['email']);
      }
      
      //-----------------------------------------
      // Build mail tags from post data..
      //-----------------------------------------
      
      foreach ($_POST AS $key => $value) {
        if (in_array($key,array('name','email','dept','subject','comments','priority'))) {
          $MSMAIL->addTag('{'.strtoupper($key).'}', $value);
          // If HTML emails are on, lets add line breaks to comments..
          // We`ll also convert character entities..
          if (HTML_EMAILS && $key=='comments') {
            $MSMAIL->addTag('{'.strtoupper($key).'}', mswTicketCommentsFilter($value));
          }
        }
      }
      
      //----------------------------------
      // Custom fields if any..
      //----------------------------------
    
      if (isset($MSXML->tickets->ticket[$i]->customfields) && $ticketID>0) {
        $newFields  = $DP->fields($MSXML->tickets->ticket[$i]->customfields);
        if (!empty($newFields)) {
          foreach ($newFields AS $key => $value) {
            $fieldID = substr($key,1);
            if (mswRowCount('cusfields WHERE `id` = \''.(int)$fieldID.'\'')>0) {
              $DP->insertField($ticketID,(int)$fieldID,$value);
            }
          }
        }
      }
      
      //----------------------------------
      // Attachments if any..
      //----------------------------------
    
      if (isset($MSXML->tickets->ticket[$i]->attachments) && $ticketID>0) {
        for ($a=0; $a<count($MSXML->tickets->ticket[$i]->attachments->file); $a++) {
          $ext  = $MSXML->tickets->ticket[$i]->attachments->file[$a]->ext;
          $data = $MSXML->tickets->ticket[$i]->attachments->file[$a]->data;
          $aErr = 0;
          // Check file extension. Name is irrelevant here, so we use test..
          if ($ext && $MSTICKET->checkFileType('test.'.$ext)) {
            // To check filesize, we first must save the image to the server..
            if ($data) {
              $SAVE = $DP->saveBase64Attachment(strtr($data,' ','+'),$ext,$ticketID,$a);
              // If OK, attachment is fine..
              if ($SAVE[0]=='OK') {
                $fileSize      = $SAVE[3];
                $fileName      = $SAVE[2];
                $folder        = $SAVE[1];
                $attachString .= $SETTINGS->scriptpath.'/templates/attachments/'.$folder.$fileName.' ('.mswFileSizeConversion($fileSize).')'.mswDefineNewline();
              }
            }
          }
        }
      }
      
      //---------------------------------------------------------
      // Line breaks for attachments for html emails..
      //---------------------------------------------------------
      
      if (HTML_EMAILS && $attachString) {
        $attachString = nl2br($attachString);
      }
      
      //----------------------
      // Build mail tags..
      //----------------------
      
      $MSMAIL->addTag('{TICKET}', mswTicketNumber($ticketID));
      $MSMAIL->addTag('{DEPT}', mswGetDepartmentName($_POST['dept']));
      $MSMAIL->addTag('{PRIORITY}', mswGetPriorityLevel($_POST['priority']));
      $MSMAIL->addTag('{PASSWORD}', $userPass);
      $MSMAIL->addTag('{IS_EMAIL}', $msg_script5);
      $MSMAIL->addTag('{CUSTOM}', $MSFIELDS->email($ticketID));
      $MSMAIL->addTag('{ATTACHMENTS}', ($attachString ? trim($attachString) : $msg_script17));
      $MSMAIL->addTag('{IP}',(mswIPAddresses()=='' ? $msg_script37 : mswIPAddresses()));
      
      //-----------------------------------------------------------------------
      // Send message to support team if manual assign is off for department..
      // This doesn`t include the global user..
      //-----------------------------------------------------------------------
      
      if ($MAN_ASSIGN->manual_assign=='no') {
        $q_users = mysql_query("SELECT *,".DB_PREFIX."users.name AS person FROM ".DB_PREFIX."userdepts
                   LEFT JOIN ".DB_PREFIX."departments
                   ON ".DB_PREFIX."userdepts.deptID  = ".DB_PREFIX."departments.id
                   LEFT JOIN ".DB_PREFIX."users
                   ON ".DB_PREFIX."userdepts.userID  = ".DB_PREFIX."users.id
                   WHERE `deptID`  = '{$_POST['dept']}'
                   AND `userID`   != '1'
                   AND `notify`    = 'yes'
                   ORDER BY ".DB_PREFIX."users.name
                   ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
        while ($USERS = mysql_fetch_object($q_users)) {
          $MSMAIL->sendMSMail($USERS->person,
                              $USERS->email,
                              $SETTINGS->website,
                              $SETTINGS->email,
                              str_replace(array('{website}','{ticket}'),
                                          array($SETTINGS->website,mswTicketNumber($ticketID)),
                                          $msg_newticket22
                              ),
                              $MSMAIL->template(E_LANG_PATH.'email/new-ticket-notification.txt')
                   );
        }
      }
      
      //--------------------------------
      // Now send to global user..
      //--------------------------------
      
      $GLOBAL = mswGetTableData('users','id',1,' AND `notify` = \'yes\'');
      if (isset($GLOBAL->name)) {
        $MSMAIL->sendMSMail($GLOBAL->name,
                            $GLOBAL->email,
                            $SETTINGS->website,
                            $SETTINGS->email,
                            str_replace(array('{website}','{ticket}'),
                                        array($SETTINGS->website,mswTicketNumber($ticketID)),
                                        $msg_newticket22
                            ),
                            $MSMAIL->template(E_LANG_PATH.'email/new-ticket-notification.txt')
                 );
      }
      // Send auto responder to person who opened ticket..
      $MSMAIL->sendMSMail($_POST['name'],
                          $_POST['email'],
                          $SETTINGS->website,
                          $SETTINGS->email,
                          str_replace(array('{website}','{ticket}'),
                                      array($SETTINGS->website,mswTicketNumber($ticketID)),
                                      $msg_newticket23
                          ),
                          $MSMAIL->template(E_LANG_PATH.'email/'.($userPass ? 'first-' : '').'auto-responder.txt')
               );
    
      }
  }
  
  if ($created>0) {
    echo $DP->response('ok');
  } else {
    echo $DP->response('no-tickets');
  }
  exit;
}

echo $DP->response('key');

?>