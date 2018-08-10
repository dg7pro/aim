<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: defined.inc.php
  Description: User Defined Admin Functions

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/


/*
 Relative path to files in the support root. In most cases this will NOT need changing.
 Some servers may require the full server path. If this is the case enter the path below.
 Example:
 define('REL_PATH', '/home/serverpath/public_html/support/');
*/ 
define('REL_PATH', '../');

/*
 Max tickets to show per page in the admin area
*/ 
define('MAX_ENTRIES', 30);

/*
 Max log entries to show per page in the admin area
*/ 
define('LOG_ENTRIES', 30);

/*
 Preferred MySQL ordering for ticket display on opened and closed ticket pages.
 Can be any MySQL fields in any combination. Escape apostrophes with a backslash.
 Examples:
 id DESC
 subject
 subject DESC,id DESC
*/
define('MYSQL_TICKET_ORDERING', 'ORDER BY ticketStatus,FIELD(priority,\'high\',\'medium\',\'low\'),id DESC'); 

/*
  Do you wish to show help tips in the admin area?
  1 = Enabled, 0 = Disabled
*/      
define('HELP_TIPS', 1);

/*
 Enable or disable entry log.
 1 = Enabled, 0 = Disabled
*/
define('ENABLE_ENTRY_LOG', 1); 

/*
  Do you wish to omit certain users from being logged in the entry log if the entry log is enabled?
  Enter user ID numbers separated with a comma to restrict. Leave blank to log all.
  Examples:
  define('ENTRY_LOG_RESTRICTION', '1'); - Doesn`t log user 1
  define('ENTRY_LOG_RESTRICTION', '1,2,5'); - Doesn`t log users 1,2 or 5 
*/
define('ENTRY_LOG_RESTRICTION', '');

/* 
  Do you want the flash stats to be visible to other users?
  1 = Yes, available to ALL, 0 = No, visible only to global user
*/
define('DISPLAY_FLASH_STATS', 1);  

/*
  Sizes for pop up div windows when editing tickets, replies 
  or viewing attachments. Increase or decrease as required.
  Must be numeric values. No px or % symbols.
*/ 
define('GREYBOX_WIDTH', 900);
define('GREYBOX_HEIGHT', 550);

define('GREYBOX_WIDTH_REPLY', 900);
define('GREYBOX_HEIGHT_REPLY', 550);

define('GREYBOX_WIDTH_ATTACHMENTS', 900);
define('GREYBOX_HEIGHT_ATTACHMENTS', 500);

/*
  Do you wish to enable the messenger option so that users can send e-mails to other users?
  Accessed via the email icon top right in the admin area.
  1 = Enabled, 0 = Disabled
*/
define('ENABLE_MESSENGER', 1);  

/*
 If a support team member clicks on an e-mail ticket link and is directed to the admin log in
 page, do you want them to be directed to the ticket after login? Can save time locating
 tickets and be a big time saver.
 1 = Enabled, 0 = Disabled
*/ 
define('REDIRECT_TO_TICKET_ON_LOGIN', 1);

?>