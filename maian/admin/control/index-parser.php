<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: index-parser.php
  Description: Admin File
  
  You can add custom code to this file if you want other code to parse from main index file

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

switch ($cmd) {
  // System..
  case 'home':
  case 'messenger':
  case 'purchase':
  case 'bbCode':
  mswIsLoggedIn();
  include(PATH.'control/system/'.$cmd.'.php');
  break;
  // Settings..
  case 'imap':
  case 'settings':
  case 'fields':
  case 'levels':
  mswIsLoggedIn();
  include(PATH.'control/system/settings/'.$cmd.'.php');
  break;
  // Departments..
  case 'dept':
  mswIsLoggedIn();
  include(PATH.'control/system/dept/'.$cmd.'.php');
  break;
  // Users..
  case 'users':
  mswIsLoggedIn();
  include(PATH.'control/system/users/'.$cmd.'.php');
  break;
  // FAQ..
  case 'faq-cat':
  case 'faq':
  case 'attachments':
  mswIsLoggedIn();
  include(PATH.'control/system/faq/'.$cmd.'.php');
  break;
  // Tools..
  case 'tools':
  case 'import':
  case 'log':
  case 'portal':
  case 'stats':
  case 'backup':
  case 'reports':
  mswIsLoggedIn();
  include(PATH.'control/system/tools/'.$cmd.'.php');
  break;
  // Ticket Management..
  case 'view-ticket':
  case 'view-dispute':
  case 'edit-ticket':
  case 'merge-ticket':
  mswIsLoggedIn();
  include(PATH.'control/system/tickets/ticket-management.php');
  break;
  // Standard Responses..
  case 'standard-responses':
  mswIsLoggedIn();
  include(PATH.'control/system/tickets/'.$cmd.'.php');
  break;
  // Tickets..
  case 'assign':
  case 'open':
  case 'close':
  case 'search':
  case 'disputes':
  case 'cdisputes':
  mswIsLoggedIn();
  include(PATH.'control/system/tickets/ticket-'.$cmd.'.php');
  break;
  // Login events..
  case 'login':
  case 'logout':
  include(PATH.'control/system/access.php');
  break;
  // Password reset..
  case 'reset':
  isResetLoggedIn();
  include(PATH.'control/system/'.$cmd.'.php');
  break;
  // Default..
  default:
  msw403();
  break;
}

?>