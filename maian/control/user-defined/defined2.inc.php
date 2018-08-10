<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: defined2.inc.php
  Description: User Defined Variables

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/*
  OMIT USERS FROM E-MAIL DIGEST
  If you wish to omit users from receiving email digest emails, enter ID numbers separated
  with a comma. Example to omit users 1,2 & 3:
  
  define('OMIT_USERS_EMAIL_DIGEST', '1,2,3'); 
  
  Leave blank to include all users.
*/
define('OMIT_USERS_EMAIL_DIGEST', ''); 

/*
  INCLUDE LINKS IN E-MAIL DIGESTS
  Do you wish to add an admin link beneath each ticket for the email digest?
  0 = Disabled, 1 = Enabled
*/
define('EMAIL_DIGEST_LINKS', 1); 

/*
  AUTO REDIRECT VISITORS TO TICKET
  If the ticket/dispute ID is passed in the url from the visitors email, do you want to
  redirect the visitor to this ticket on login?
  0 = Disabled, 1 = Enabled
*/
define('AUTO_VIS_TICKET_REDIRECT', 1);  

/*
  SEND DIGESTS FOR 0 COUNTS
  If there are no tickets and no disputes, do you still want to send emails?
  0 = Disabled, 1 = Enabled
*/
define('EMAIL_DIGEST_ZERO_COUNT_MAIL', 1); 

/*
  AUTO PARSE LINE BREAKS
  Do you want to auto parse line breaks?
  If yes, uses PHP nl2br() function
  0 = Disabled, 1 = Enabled
*/
define('AUTO_PARSE_LINE_BREAKS', 1); 

/*
  REQUIRED MARKER FOR CUSTOM FIELDS
  Reuqired fields marker for custom fields
*/
define('CUSTOM_REQUIRED_MARKER', '* '); 

/*
  ORDER PREFERENCE FOR 'VIEW ALL DISPUTES' page
  How do you wish to order the tickets?
  This can reference any field in the tickets table
  Use the FIELD function to determine ordering if standard doesn`t work as shown in the example default.
*/  
define('ALL_DISPUTES_ORDER',"ORDER BY FIELD(`ticketStatus`,'open','close','closed'),FIELD(`priority`,'high','medium','low'),FIELD(`replyStatus`,'visitor','admin','start'),`id` DESC");

/*
  ORDER PREFERENCE FOR 'VIEW ALL TICKETS' page
  How do you wish to order the tickets?
  This can reference any field in the tickets table
  Use the FIELD function to determine ordering if standard doesn`t work as shown in the example default.
*/  
define('ALL_TICKETS_ORDER',"ORDER BY FIELD(`ticketStatus`,'open','close','closed'),FIELD(`priority`,'high','medium','low'),FIELD(`replyStatus`,'visitor','admin','start'),`id` DESC");

/*
  MAX CHARS FOR RANDOM DATA WHEN RE-NAMING ATTACHMENTS
  When attachments are renamed, a part of the new name contains random data.
  How many characters do you want this to be?
  A sensible amount is 10/20. Prevents file names being overwritten accidentally
*/
define('MAX_CHARS_RENAME_RAND', 10);

/*
  BAD MULTIBYTE CHARACTERS
  As MySQL cannot properly handle four-byte characters with the default utf-8
  charset up until version 5.5.3, posts may be truncated with special characters.
  To fix this the script can convert these bad bytes to question marks ?
  
  Do you wish to enable this? This only applies if your db charset is utf8
  
  0 = Disabled, 1 = Enabled
*/
define('CONVERT_BAD_MULTIBYTE_CHARS', 0); 

/*
  DIVIDER FOR ALLOWED ATTACHMENT TYPES
  The database stores the allowed attachment file types (if any) as pipe delimited.
  Do you want to separate them with something else on ticket creation page
*/
define('ATTACH_TYPES_SEPERATOR', '&nbsp;,&nbsp;'); 

/*
  CHARACTER DISPLAY CUT-OFF
  If attachments have long file name, do you want to truncate the name to keep the display clean?
  Set to number higher than 0 to activate
*/
define('ATTACH_FILE_NAME_TRUNCATION', 30); 

/*
  CHMOD value for new folders created inside 'templates/attachments' folder. For linux servers.
  DO NOT change unless you know what you are doing and a different value is required.
*/
define('ATTACH_CHMOD_VALUE', 0777);  

/*
  ENABLE SCROLL TO TOP LINK
  When scrolling down an image auto appears bottom right to scroll to top
  Do you wish to enable this?
  0 = Disabled, 1 = Enabled
*/
define('SCROLL_TO_TOP', 1); 

/*
  BACKUP CRON E-MAILS
  If you are running the 'db-backup.php' file as a cron, enter emails here, separated with a comma for multiple addresses.
  The cron tab/job emails should not exist on the same server as your database.
  If this is left blank, backups are saved locally in the 'backups' folder.
  
  Examples:
  define('BACKUP_CRON_EMAILS', 'email@mysite.co.uk');
  define('BACKUP_CRON_EMAILS', 'email@mysite.co.uk,email2@mysite.co.uk');
  
*/
define('BACKUP_CRON_EMAILS', ''); 

/*
  Do you wish to send e-mail notification if someone changes their email?
  1 = Enabled, 0 = Disabled
*/  
define('CHANGE_EMAIL_NOTIFICATION', 1);

/*
  ORDER CATEGORY FAQ QUESTIONS
  How do you wish to order FAQ category questions?
  Can be any table field name
  id DESC, id ASC, question ASC, question DESC, kviews ASC, kviews DESC
*/
define('CATEGORY_FAQ_ORDER_BY', '`question`');

/*
  ORDER MOST POPULAR QUESTIONS
  How do you wish to order most popular questions?
  Can be any table field name
  id DESC, id ASC, question ASC, question DESC, kviews ASC, kviews DESC
*/
define('FAQ_POPULAR_ORDER_BY', '`kviews` DESC');

/*
  Enable language switcher and set cookie duration in days
  1 = Enabled, 0 = Disabled
*/
define('LANG_SWITCH_ENABLE', 0);
define('LANG_SWITCH_COOKIE', 180);  

?>