<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: bbCode.php
  Description: Class File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

class bbCode_Parser {

// General parser..
function bbParser($text) {
  // Check for square brackets. If not found, no bb code exists..
  if (strpos($text,'[')===false && strpos($text,']')===false) {
    return nl2br($text);
  }
  $tagList  = array(
  '[b]'       => '<span class="bbBold">',
  '[u]'       => '<span class="bbUnderline">',
  '[i]'       => '<span class="bbItalics">',
  '[s]'       => '<span class="bbStrike">',
  '[del]'     => '<span class="bbDel">',
  '[ins]'     => '<span class="bbIns">',
  '[em]'      => '<span class="bbEm">',
  '[h1]'      => '<span class="bbH1">',
  '[h2]'      => '<span class="bbH2">',
  '[h3]'      => '<span class="bbH3">',
  '[h4]'      => '<span class="bbH4">',
  '[list]'    => '<ul class="bbUl">',
  '[list=n]'  => '<ul class="bbUlNumbered">',
  '[list=a]'  => '<ul class="bbUlAlpha">',
  '[*]'       => '<li class="bbLi">',
  '[B]'       => '<span class="bbBold">',
  '[U]'       => '<span class="bbUnderline">',
  '[I]'       => '<span class="bbItalics">',
  '[S]'       => '<span class="bbStrike">',
  '[DEL]'     => '<span class="bbDel">',
  '[INS]'     => '<span class="bbIns">',
  '[EM]'      => '<span class="bbEm">',
  '[H1]'      => '<span class="bbH1">',
  '[H2]'      => '<span class="bbH2">',
  '[H3]'      => '<span class="bbH3">',
  '[H4]'      => '<span class="bbH4">',
  '[LIST]'    => '<ul class="bbUl">',
  '[LIST=N]'  => '<ul class="bbUlNumbered">',
  '[LIST=A]'  => '<ul class="bbUlAlpha">',
  '[/b]'     => '</span>',
  '[/u]'     => '</span>',
  '[/i]'     => '</span>',
  '[/s]'     => '</span>',
  '[/del]'   => '</span>',
  '[/ins]'   => '</span>',
  '[/em]'    => '</span>',
  '[/h1]'    => '</span>',
  '[/h2]'    => '</span>',
  '[/h3]'    => '</span>',
  '[/h4]'    => '</span>',
  '[/list]'  => '</ul>',
  '[/list]'  => '</ul>',
  '[/list]'  => '</ul>',
  '[/B]'     => '</span>',
  '[/U]'     => '</span>',
  '[/I]'     => '</span>',
  '[/S]'     => '</span>',
  '[/DEL]'   => '</span>',
  '[/INS]'   => '</span>',
  '[/EM]'    => '</span>',
  '[/H1]'    => '</span>',
  '[/H2]'    => '</span>',
  '[/H3]'    => '</span>',
  '[/H4]'    => '</span>',
  '[/LIST]'  => '</ul>',
  '[/LIST]'  => '</ul>',
  '[/LIST]'  => '</ul>',
  '[/*]'     => '</li>'
  );
  // Deal with potential slashes..
  $text = mswCleanData($text);
  // Kill html..
  $text = htmlspecialchars($text);
  // Parse colors..
  $text = bbCode_Parser::colorParser($text);
  // Parse urls..
  $text = bbCode_Parser::urlParser($text);
  // Parse youtube videos..
  $text = bbCode_Parser::youTubeParser($text);
  // Parse vimeo videos..
  $text = bbCode_Parser::vimeoParser($text);
  // Parse emails..
  $text = bbCode_Parser::emailParser($text);
  // Parse images..
  $text = bbCode_Parser::imageParser($text);
  // Also clean empty tags..
  $find = array('[u] [/u]','[i] [/i]','[b] [/b]','[u] [/u]<br />','[i] [/i]<br />','[b] [/b]<br />');
  $repl = array();
  $text = str_replace($find,$repl,$text);
  // Deal with other tags and return..
  $text = strtr($text,$tagList);  
  $text = (AUTO_PARSE_LINE_BREAKS ? nl2br(trim($text)) : trim($text));
  // Clean up <ul> & <li> tags which have invalid linebreaks..
  $find = array('<ul><br />','</ul><br />','<li><br />','</li><br />','<ul class="bbUl"><br />','<ul class="bbUlNumbered"><br />','<ul class="bbUlAlpha"><br />');
  $repl = array('<ul>','</ul>','<li>','</li>','<ul class="bbUl">','<ul class="bbUlNumbered">','<ul class="bbUlAlpha">');
  return str_replace($find,$repl,$text);
}

// For colour tags..
function colorParser($text) {
  $pattern[] = '#\[colou?r=([a-zA-Z]{3,20}|\#[0-9a-fA-F]{6}|\#[0-9a-fA-F]{3})](.*?)\[/colou?r\]#ms';
  $replace[] = '<span style="color: $1">$2</span>';
  return preg_replace($pattern,$replace,$text);
}

// For url tags..
function urlParser($text) {
  $text = preg_replace('#\[urlnew\=(.+)\](.+)\[\/urlnew\]#iUs','<a href="$1" title="$2" onclick="window.open(this);return false">$2</a>',$text);
  $text = preg_replace('#\[urlnew\](.+)\[/urlnew\]#iUs','<a href="$1" title="$1" onclick="window.open(this);return false">$1</a>',$text);
  $text = preg_replace('#\[url\=(.+)\](.+)\[\/url\]#iUs','<a href="$1" title="$2">$2</a>',$text);
  $text = preg_replace('#\[url\](.+)\[/url\]#iUs','<a href="$1" title="$1">$1</a>',$text);
  return $text;
}

// For YouTube tags..
function youTubeParser($text) {
  $text = preg_replace('#\[youtube\](.+)\[/youtube\]#iUs',str_replace('{CODE}','$1',YOU_TUBE_EMBED_CODE),$text);
  return $text;
}

// For Vimeo tags..
function vimeoParser($text) {
  $text = preg_replace('#\[vimeo\](.+)\[/vimeo\]#iUs',str_replace('{ID}','$1',VIMEO_EMBED_CODE),$text);
  return $text;
}

// For mailto tags..
function emailParser($text) {
  $pattern[] = '#\[email\]([^\[]*?)\[/email\]#';
  $pattern[] = '#\[email=([^\[]+?)\](.*?)\[/email\]#';
  $replace[] = '<a class="bbMailto" href="mailto:$1" title="$1">$1</a>';
  $replace[] = '<a class="bbMailto" href="mailto:$1" title="$2">$2</a>';
  return preg_replace($pattern,$replace,$text);
}

// For img tags..
function imageParser($text) {
  return preg_replace('#\[img\](.+)\[\/img\]#iUs','<img class="bbDisplayImg" src="$1" alt="" title="" />',$text); 
}

}

?>