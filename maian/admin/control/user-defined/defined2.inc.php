<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: defined2_1.inc.php
  Description: User Defined Admin Functions Added in v2.1

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/*
  DATE DISPLAY FOR HEADER
  Date display format for top header
  Supports any parameters supported by the PHP date function:
  http://php.net/manual/en/function.date.php
*/
define('HEADER_DATE_FORMAT', 'D, j M, Y');

/*
  FAQ QUESTIONS PER PAGE
  Max FAQ questions to show per page in the admin area
*/ 
define('MAX_FAQ_ENTRIES', 30); 

/*
  FAQ CATEGORIES PER PAGE
  Max FAQ categories to show per page in the admin area
*/ 
define('MAX_FAQCAT_ENTRIES', 30);

/*
  FAQ ATTACHMENTS PER PAGE
  Max FAQ attachments to show per page in the admin area
*/ 
define('MAX_FAQATT_ENTRIES', 30);

/*
  STANDARD RESPONSES PER PAGE
  Max standard responses to show per page in the admin area
*/ 
define('MAX_SR_ENTRIES', 30);

/*
  IMAP ACCOUNTS PER PAGE
  Max imap accounts to show per page in the admin area
*/ 
define('MAX_IMAP_ENTRIES', 30);  

/*
  DEPARTMENTS PER PAGE
  Max departments to show per page in the admin area
*/ 
define('MAX_DEPT_ENTRIES', 30); 

/*
  USERS PER PAGE
  Max users to show per page in the admin area
*/ 
define('MAX_USER_ENTRIES', 30); 

/*
  USER RESPONSES PER PAGE
  Max user responses to show per page in the admin area
*/ 
define('MAX_USERRESP_ENTRIES', 30);

/*
  PRIORITY LEVELS PER PAGE
  Max departments to show per page in the admin area
*/ 
define('MAX_LEVEL_ENTRIES', 30);

/*
  CUSTOM FIELDS PER PAGE
  Custom fields to show per page in the admin area
*/ 
define('MAX_FIELD_ENTRIES', 30);

/*
  TICKET SEARCH AUTO CHECK OPTIONS
  Which ticket type checkboxes should be auto checked on search tickets page
*/
define('SEARCH_AUTO_CHECK_TICKETS', 'yes'); 
define('SEARCH_AUTO_CHECK_DISPUTES', 'yes');  

/*
  ADMIN HOMEPAGE DEFAULT SALES/TOTALS VIEW
  Specify the default view for the admin homepage
  Can be any of the following:
  today  = Today
  week   = This Week
  month  = This Month
  year   = This Year
*/
define('ADMIN_HOME_DEFAULT_SALES_VIEW', 'week'); 

/*
  USER DEFAULT GRAPH VIEW
  Specify the default view for the user graphs
  Can be any of the following:
  today  = Today
  week   = This Week
  month  = This Month
  year   = This Year
*/
define('USER_DEFAULT_GRAPH_VIEW', 'week'); 

/*
  LATEST TICKETS/DISPUTES ON ADMIN HOMEPAGE
  How many latest tickets/disputes to show on admin homepage
  0 to disable
*/
define('ADMIN_HOME_LATEST_AD_TICKETS', 5);
define('ADMIN_HOME_LATEST_VIS_TICKETS', 5);
define('ADMIN_HOME_LATEST_AD_DISPUTES', 5);
define('ADMIN_HOME_LATEST_VIS_DISPUTES', 5);
  
/*
  ADMIN HOMEPAGE SIDE BOX VIEW
  Which sideboxes do you wish to enable on the admin homepage?
  0 = Disabled, 1 = Enabled
*/
define('ADMIN_TICKET_OVERVIEW', 1);
define('ADMIN_DISPUTE_OVERVIEW', 1);
define('ADMIN_SYSTEM_OVERVIEW', 1);

/*
  ADMIN HOME LATEST TICKETS ORDERING
  How do you want to order the latest tickets?
  This won`t need changing unless you want to display the tickets in a particular order..
*/
define('ADMIN_HOME_TICKET_ORDERING', 'ORDER BY `id` DESC');

/*
  USER MANAGEMENT - AUTO PASS CHAR DEFAULT
  Default value for range drop down for auto pass option.
  Value of 6 to 20
*/
define('USER_AUTO_PASS_CHAR_DEFAULT', 6);

/*
  COMMENTS BY IN ADMIN TICKET REPLIES
  In admin reply emails, above comments it says 'Comments by XX'. 
  Do you want the user value the admin users email OR ticket 'From' name/
  0 = Username, 1 = Ticket 'From' Name
*/
define('COMMENTS_BY_TXT', 0);

/*
  AUTO CREATE API KEY - KEY LENGTH
  Max 100 characters
*/
define('API_KEY_LENGTH', 30);

/*
  ENABLE POST PRIVILEGE CONFIRMATION
  Do you want to enable the confirmation dialogue if dispute post permissions are changed?
  0 = Disabled, 1 = Enabled
*/
define('DISPUTE_POST_PRIVILEGE_CONFIRMATION', 1); 

/*
  AUTO CHECK 'OPEN DISPUTE NOTIFICATION'
  When adding dispute users to ticket, a checkbox is provided for notification to the 
  original ticket creator. Do you want this auto checked by default?
  0 = Disabled, 1 = Enabled
*/
define('AUTO_CHECK_DISPUTE_NOTIFICATION', 1); 

/*
  SILENT EDIT NOTIFICATION
  If enabled, always sends ticket edit notification to the administrative user.
  This can also be copied to other email addresses if preferred.
  Separate addresses with a comma.
*/
define('ENABLE_SILENT_EDIT_NOTIFICATION', 0);
define('ENABLE_SILENT_EDIT_NOTIFICATION_EMAIL', '');  

/*
  ENABLE SOFTWARE VERSION CHECK
  Displays on the top bar and is an easy check option to see if new versions have
  been release. You may wish to disable this for clients.
  0 = Disabled, 1 = Enabled
*/
define('DISPLAY_SOFTWARE_VERSION_CHECK', 1);  

/*
  LOG FILE NAME
  Specify file name for entry log when exporting. Use date parameters to include
  date/time
*/
define('ENTRY_LOG_FILENAME', 'log-'.date('dmY-his').'.csv');  

/*
  REPORT FILE NAME
  Specify file name for report log when exporting. Use date parameters to include
  date/time
*/
define('REPORT_LOG_FILENAME', 'reports-'.date('dmY-his').'.csv');  

/*
  ADMIN MAX ATTACHMENT BOXES
  Admin override for max attachments. Can be higher than visitor restriction.
  Applies only in commercial version.
*/  
define('ADMIN_ATTACH_BOX_OVERRIDE', 20);

?>