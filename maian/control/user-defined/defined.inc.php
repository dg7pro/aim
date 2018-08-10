<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: defined.inc.php
  Description: User Defined Variables

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/*
  Enable imap functions debugging. If this is enabled, mail connection errors are
  shown on screen. Useful for testing, but should be disabled on a production website
  1 = Enabled, 0 = Disabled
*/
define('ENABLE_IMAP_DEBUG', 0);  

/* 
  Enable e-mails. This is a global switch to de-activate e-mails. Can be useful if you
  are testing on localhost and you don`t have a mail server installed
  This must be enabled when live
*/
define('ACTIVATE_EMAILS', 1);  

/*
  Minimum digits for ticket number
  The first ticket will be 1, but you might want to specify the ticket as 000001. 
  Set to 0 for tickets to have no additional prefixed zeros or enter amount to show.
*/
define('MIN_DIGITS_TICKETS', 5);  

/*
  Do you wish to send e-mail notification if someone changes their password?
  1 = Enabled, 0 = Disabled
*/  
define('CHANGE_PASS_NOTIFICATION', 1);

/*
  Do you wish to be able to use HTML in the e-mail templates? If enabled, HTML line 
  breaks will be required in the e-mail .txt files. ie: <br> or <br />
  1 = Enabled, 0 = Disabled
*/  
define('HTML_EMAILS', 0);

/*
  How many decimal places to show for vote stats. Examples:
  3 = 55.672%
  2 = 55.67%
  1 = 55.6%
  0 = 55%
*/  
define('VOTING_DECIMAL_PLACES', 0);

/*
  If a file is uploaded with no attachment file extension and no restrictions for extensions
  are set, do you want to append a default prefix to the file?
*/  
define('NO_ATTACHMENT_EXT_DEFAULT', '.txt');

/*
  When running the imap url as a cron, some servers require that the cron outputs data. If your
  server requires this, enable this option. Can also be useful for testing. If disabled, running
  the cron url (either via cron or browser url) will result in a blank screen or no output.
  1 = Enabled, 0 = Disabled
*/  
define('DISPLAY_IMAP_CRON_OUTPUT', 1);

/*
  Specify the imap cron url access parameters. See the docs for more help. If you are unsure,
  don`t change this option.
*/  
define('IMAP_URL_PARAMETER', 'pipe');

/*
  Set memory limit for imap. Uses the ini_set (memory_limit) function to overwrite PHP.ini settings. Increase
  if necessary. Do not change if you don`t understand this. Note that this has NO effect if
  ini_set is not enabled on the server.
  Leave blank for no override.
*/
define('IMAP_MEMORY_OVERRIDE', '10M');

/*
  Set timeout limit for imap. Uses the ini_set (set_time_limit) function to overwrite PHP.ini settings. Increase
  if necessary. Do not change if you don`t understand this. Note that this has NO effect if
  ini_set is not enabled on the server. 
  Enter time in seconds. ie: 120 = 120 seconds. 0 for no timeout limit
*/
define('IMAP_TIMEOUT_OVERRIDE', '120');   

/*
  Specify spam sum ranges if spam sum is enabled.
*/  
$sum1 = rand(1,9);
$sum2 = rand(11,99);

/*
  Default amount of characters for password creation.
*/  
define('PASS_CHARS', 6);

/*
  Displays the 'Powered by Maian Support' link in your browser title.
  You may disable this if you wish. If a commercial licence is paid, this will
  automatically be disabled and this option has no effect.
  1 = Enabled, 0 = Disabled
*/  
define('ENABLE_POWERED_BY_LINK', 1);

?>
