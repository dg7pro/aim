<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: index-parser.php
  Description: Loads via main index.php
  
  You can add custom code to this file if you want other code to parse from main index file

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

switch ($cmd) {
  case 'home':
  case 'logout':
  case 'ticket-new':
  case 'ticket-add':
  include(PATH.'control/system/main.php');
  break;
  
  case 'portal':
  case 'portal-new':
  include(PATH.'control/system/portal.php');
  break;
      
  case 'ticket':
  include(PATH.'control/system/create-ticket.php');
  break;
  
  case 'tickets':
  case 'disputes':
  case 'search':
  include(PATH.'control/system/'.$cmd.'.php');
  break;
      
  case 'view-ticket':
  case 'view-dispute':
  include(PATH.'control/system/'.$cmd.'.php');
  break;
  
  case 'faq':
  include(PATH.'control/system/faq.php');
  break;
  
  case 'xml':
  include(PATH.'control/system/xml.php');
  break;
  
  case IMAP_URL_PARAMETER:
  include(PATH.'control/system/imap.php');
  break;
  
  default:
  msw404();
  break;
}

?>