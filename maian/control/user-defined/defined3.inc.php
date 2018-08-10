<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: defined3.inc.php
  Description: User Defined Variables (2.2)

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/*
  YOUTUBE EMBED CODE
  Adjust code if required for Youtube embed code
  This is used in BB code tags.
  Where the code should be use {CODE}
*/
define('YOU_TUBE_EMBED_CODE','<iframe width="560" height="315" src="http://www.youtube.com/embed/{CODE}" frameborder="0" allowfullscreen></iframe>');

/*
  VIMEO EMBED CODE
  Adjust code if required for Vimeo embed code
  This is used in BB code tags.
  Where the video ID should be use {ID}
*/
define('VIMEO_EMBED_CODE', '<iframe src="http://player.vimeo.com/video/{ID}?title=0&amp;byline=0&amp;portrait=0" width="400" height="225" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>');

/*
  AUTO PARSE HYPERLINKS
  Do you want to auto convert hyperlinks to clickable links?
  This works ONLY if BBCode is disabled in settings
  0 = Disabled, 1 = Enabled
*/
define('AUTO_PARSE_HYPERLINKS', 1);  

/*
  CLEAN DATA
  Do you want to clean potentially harmful javascript tags from post data?
  0 = Disabled, 1 = Enabled
*/
define('CLEAN_HARMFUL_TAGS', 0);   

?>