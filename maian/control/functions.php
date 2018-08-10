<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: functions.php
  Description: Functions

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

// Database connection..
function mswDBConnector() {
  $connect = @mysql_connect(trim(DB_HOST),trim(DB_USER),trim(DB_PASS));
  if (!$connect) {
	  die((ENABLE_MYSQL_ERRORS ? 'Code: '.mysql_errno().' Error: '.mysql_error() : MYSQL_DEFAULT_ERROR));
  }
  if ($connect && !mysql_select_db(trim(DB_NAME),$connect)) {
    die((ENABLE_MYSQL_ERRORS ? 'Code: '.mysql_errno().' Error: '.mysql_error() : MYSQL_DEFAULT_ERROR));
  }
  if ($connect) {
    // Character set..
    if (defined('DB_CHAR_SET') && DB_CHAR_SET) {
      if (strtolower(DB_CHAR_SET)=='utf-8') {
        $change = 'utf8';
      }
      @mysql_query("SET CHARACTER SET '".(isset($change) ? $change : DB_CHAR_SET)."'");
      @mysql_query("SET NAMES '".(isset($change) ? $change : DB_CHAR_SET)."'");
    }
    // Locale..
    if (defined('DB_LOCALE')) {
      if (DB_CHAR_SET && DB_LOCALE) {
        @mysql_query("SET `lc_time_names` = '".DB_LOCALE."'");
      }
    }
  }
}

// Current timestamp..
function mswTimeStamp() {
  return time();
}

function mswDateDisplay($ts=0,$format) {
  global $timezones_php4;
  if ($ts==0) {
    $ts = mswTimeStamp();
  }
  // PHP5 date/time support..
  if (class_exists('DateTime')) {
    $dt = new DateTime(date('Y-m-d H:i:s',$ts).' UTC');
    $dt->setTimezone(new DateTimeZone(MSTZ_SET));
    return $dt->format($format);
  } else {
    // Legacy support..
    $gmt  = gmdate('Y-m-d H:i:s',
             mktime(
              date('H',$ts),
              date('i',$ts),
              date('s',$ts),
              date('m',$ts),
              date('d',$ts),
              date('Y',$ts)
             )
            );
    return date($format,strtotime($timezones_php4[MSTZ_SET].' hours',strtotime($gmt)));
  }
}

function mswTimeDisplay($ts=0,$format) {
  global $timezones_php4;
  if ($ts==0) {
    $ts = mswTimeStamp();
  }
  // PHP5 date/time support..
  if (class_exists('DateTime')) {
    $dt = new DateTime(date('Y-m-d H:i:s',$ts).' UTC');
    $dt->setTimezone(new DateTimeZone(MSTZ_SET));
    return $dt->format($format);
  } else {
    // Legacy support..
    $gmt  = gmdate('Y-m-d H:i:s',
             mktime(
              date('H',$ts),
              date('i',$ts),
              date('s',$ts),
              date('m',$ts),
              date('d',$ts),
              date('Y',$ts)
             )
            );
    return date($format,strtotime($timezones_php4[MSTZ_SET].' hours',strtotime($gmt)));
  }
}

function mswGMTDateTime() {
  $ts = time()+date('Z');
  return strtotime(gmdate('Y-m-d H:i:s',$ts));
}

function mswSQLDate() {
  return date('Y-m-d');
}

// JSON encode function for legacy versions..
if (!function_exists('json_encode')) {
  function json_encode($array) {
    $json = array();
    foreach ($array AS $k => $v) {
      $json[] = '"'.$v.'"';
    }
    return '['.implode(',',$json).']';
  }
}

// Fixes settings fields if manual schema was run..
function mswManSchemaFix($SETTINGS) {
  if ($SETTINGS->email=='' && $SETTINGS->scriptpath=='' && $SETTINGS->attachpath=='') {
    $hdeskPath = 'http://www.example.com/helpdesk';  
    if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
      $hdeskPath   = 'http'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 's' : '').'://'.$_SERVER['HTTP_HOST'].substr($_SERVER['PHP_SELF'],0,-10);
    } 
    $attachPath = mswSafeImportString(PATH.'templates/attachments');
    mysql_query("UPDATE ".DB_PREFIX."settings SET
    `website`             = 'My Help Desk',
    `email`               = 'email@example.com',
    `scriptpath`          = '$hdeskPath',
    `attachpath`          = '$attachPath',
    `adminFooter`         = 'To add your own footer code, click &lt;Settings&gt; from the above menu',
    `publicFooter`        = 'To add your own footer code, log in to your admin area and click &lt;Settings&gt;',
    `prodKey`             = '".mswProdKeyGen()."',
    `encoderVersion`      = '".(function_exists('ioncube_loader_version') ? ioncube_loader_version() : 'XX')."',
    `softwareVersion`     = '".SCRIPT_VERSION."'
    LIMIT 1
    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    // Insert user..
    if (mswRowCount('users')==0) {
      mysql_query("INSERT INTO `".DB_PREFIX."users` (
      `id`, `ts`, `name`, `email`, `accpass`, `signature`, `notify`, `pageAccess`, `emailSigs`, `notePadEnable`, `delPriv`,
      `nameFrom`, `emailFrom`, `assigned`, `timezone`
      ) VALUES (
      1, UNIX_TIMESTAMP(UTC_TIMESTAMP), 'admin', 'admin@email.com', '".md5(SECRET_KEY.'admin')."', '', 'yes', '', 'no', 'yes', 'yes',
      '', '', 'no', 'Europe/London'
      )");
    }
    // Page reload..
    header("Location: index.php");
    exit;
  }
}

// DB Schema..
function mswDBSchemaArray() {
  return array(
   DB_PREFIX.'attachments',
   DB_PREFIX.'faqattassign',
   DB_PREFIX.'categories',
   DB_PREFIX.'cusfields',
   DB_PREFIX.'departments',
   DB_PREFIX.'disputes',
   DB_PREFIX.'faq',
   DB_PREFIX.'faqattach',
   DB_PREFIX.'imap',
   DB_PREFIX.'levels',
   DB_PREFIX.'log',
   DB_PREFIX.'portal',
   DB_PREFIX.'replies',
   DB_PREFIX.'responses',
   DB_PREFIX.'settings',
   DB_PREFIX.'ticketfields',
   DB_PREFIX.'tickets',
   DB_PREFIX.'userdepts',
   DB_PREFIX.'users'
  );
}

// BBCode cleaner..
function mswBBCodeCleaner($text) {
  $tagList = array(
  '[b]','[u]','[i]','[s]','[del]','[ins]','[em]','[h1]','[h2]','[h3]','[h4]','[list]','[list=n]','[list=a]','[*]','[B]','[U]','[I]','[S]',
  '[DEL]','[INS]','[EM]','[H1]','[H2]','[H3]','[H4]','[LIST]','[LIST=N]','[LIST=A]','[/b]','[/u]','[/i]','[/s]','[/del]','[/ins]','[/em]',
  '[/h1]','[/h2]','[/h3]','[/h4]','[/list]','[/list]','[/list]','[/B]','[/U]','[/I]','[/S]','[/DEL]','[/INS]','[/EM]','[/H1]','[/H2]','[/H3]','[/H4]','[/LIST]',
  '[/LIST]','[/LIST]','[/*]','[colour]','[color]','[/color]','[/colour]','[urlnew]','[url]','[/urlnew]','[/url]','[email]','[/email]','[img]','[/img]',
  '[youtube]','[/youtube]','[vimeo]','[/vimeo]'
  );
  return str_replace($tagList,array(),$text);
}

// Message filter for ticket comments..
function mswTicketCommentsFilter($comments) {
  global $SETTINGS;
  if (HTML_EMAILS) {
    $comments = nl2br(mswSpecialChars($comments));
  }
  return ($SETTINGS->enableBBCode=='yes' ? mswBBCodeCleaner($comments) : $comments);
}

// Generates 60 character product key..
function mswProdKeyGen() {
  $_SERVER['HTTP_HOST']    = (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] ? $_SERVER['HTTP_HOST'] : uniqid(rand(),1));
  $_SERVER['REMOTE_ADDR']  = (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR'] : uniqid(rand(),1));
  if (function_exists('sha1')) {
    $c1       = sha1($_SERVER['HTTP_HOST'].date('YmdHis').$_SERVER['REMOTE_ADDR'].time());
    $c2       = sha1(uniqid(rand(),1).time());
    $prodKey  = substr($c1.$c2,0,60);
  } elseif (function_exists('md5')) {
    $c1       = md5($_SERVER['HTTP_POST'].date('YmdHis').$_SERVER['REMOTE_ADDR'].time());
    $c2       = md5(uniqid(rand(),1),time());
    $prodKey  = substr($c1.$c2,0,60);
  } else {
    $c1       = str_replace('.','',uniqid(rand(),1));
    $c2       = str_replace('.','',uniqid(rand(),1));
    $c3       = str_replace('.','',uniqid(rand(),1));
    $prodKey  = substr($c1.$c2.$c3,0,60);
  }
  return strtoupper($prodKey);
}

// Login credentials..
function mswIsUserLoggedIn() {
  return (isset($_SESSION[md5(SECRET_KEY).'_msw_support']) && 
    mswIsValidEmail($_SESSION[md5(SECRET_KEY).'_msw_support']) &&
    mswRowCount('portal WHERE `email` = \''.$_SESSION[md5(SECRET_KEY).'_msw_support'].'\'')>0 ? 
    $_SESSION[md5(SECRET_KEY).'_msw_support'] : 
    ''
  );
}

// Check valid email..
function mswIsValidEmail($em) {
  if (function_exists('filter_var') && !filter_var($em,FILTER_VALIDATE_EMAIL)) {
    return false;
  } else {
    if (!preg_match("/^[_.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z.-]+.)+[a-zA-Z]{2,6}$/i", $em)) {
      return false;
    }
  }
  return true;
}

// Convert us date to specified date..
function mswConvertMySQLDate($sql) {
  global $SETTINGS;
  $split = explode('-',$sql);
  switch ($SETTINGS->jsDateFormat) {
    case 'DD-MM-YYYY':
    return $split[2].'-'.$split[1].'-'.$split[0];
    break;
    case 'DD/MM/YYYY':
    return $split[2].'/'.$split[1].'/'.$split[0]; 
    break;
    case 'YYYY-MM-DD':
    return $sql;
    break;
    case 'YYYY/MM/DD':
    return str_replace('-','/',$sql);
    break;
    case 'MM-DD-YYYY':
    return $split[1].'-'.$split[2].'-'.$split[0]; 
    break;
    case 'MM/DD/YYYY':
    return $split[1].'/'.$split[2].'/'.$split[0];
    break;
  }
}

// Calendar picker format..
function mswDatePickerFormat($sql='') {
  global $SETTINGS;
  // Convert into js format dates..
  switch ($SETTINGS->jsDateFormat) {
    case 'DD-MM-YYYY':
    $formatJS  = ($sql ? substr($sql,6,4).'-'.substr($sql,3,2).'-'.substr($sql,0,2) : 'dd-mm-yy');
    break;
    case 'DD/MM/YYYY':
    $formatJS  = ($sql ? substr($sql,6,4).'-'.substr($sql,3,2).'-'.substr($sql,0,2) : 'dd/mm/yy');
    break;
    case 'YYYY-MM-DD':
    $formatJS  = ($sql ? $sql : 'yy-mm-dd');
    break;
    case 'YYYY/MM/DD':
    $formatJS  = ($sql ? str_replace('/','-',$sql) : 'yy/mm/dd');
    break;
    case 'MM-DD-YYYY':
    $formatJS  = ($sql ? substr($sql,6,4).'-'.substr($sql,0,2).'-'.substr($sql,3,2) : 'mm-dd-yy');
    break;
    case 'MM/DD/YYYY':
    $formatJS  = ($sql ? substr($sql,6,4).'-'.substr($sql,0,2).'-'.substr($sql,3,2) : 'mm/dd/yy'); 
    break;
    default:
    $formatJS  = ($sql ? mswSQLDate() : 'dd/mm/yy');
    break;
  }
  return $formatJS;
}

// Get savant..
function mswGetSavant() {
  if (phpversion()>=5) { 
    $tpl  = new Savant3();
  } else {
    $tpl  = new Savant2();
  }
  return $tpl;
}

// Display text based on whats enabled..
function mswTxtParsingEngine($text) {
  global $MCBB,$SETTINGS;
  $text = trim($text);
  if ($SETTINGS->enableBBCode=='yes') {
    return $MCBB->bbParser($text);
  } else {
    if (AUTO_PARSE_HYPERLINKS) {
      return (AUTO_PARSE_LINE_BREAKS ? nl2br(mswAutoLinkParser($text)) : mswAutoLinkParser($text));
    } else {
      return (AUTO_PARSE_LINE_BREAKS ? nl2br(mswSpecialChars($text)) : mswSpecialChars($text));
    }
  }
}

function mswCallBackParams() {
  global $cmd;
  // Knowledge base..
  if (isset($_GET['a']) || isset($_GET['c']) || isset($_GET['q']) || isset($_GET['v'])) {
    $cmd        = 'faq';
    $_GET['p']  = 'faq';
  }
  // View ticket..
  if (isset($_GET['t'])) {
    $cmd = 'view-ticket';
  }
  // View dispute..
  if (isset($_GET['d'])) {
    $cmd = 'view-dispute';
  }
  // All tickets..
  if (isset($_GET['p']) && $_GET['p']=='vt') {
    $cmd = 'tickets';
  }
  // All disputes..
  if (isset($_GET['p']) && $_GET['p']=='vd') {
    $cmd = 'disputes';
  }
  // Imap..
  if (isset($_GET[IMAP_URL_PARAMETER])) {
    $cmd = IMAP_URL_PARAMETER;
  }
  // BB code..
  if (isset($_GET['bbhelp'])) {
    $cmd = 'home';
  }
  return $cmd;
}

function mswDetectSSLConnection() {
  return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'yes' : 'no');
}

// Detect date timezone for PHP 5
function mswDateTimeDetect($zone=0) {
  global $SETTINGS;
  if (function_exists('date_default_timezone_set')) {
    date_default_timezone_set(($zone!='0' ? $zone : $SETTINGS->timezone));
  } 
}

// Variable sanitation..
function mswDigit($no) {
  return (int)$no;
}

// Get department name..
function mswGetDepartmentName($id,$object=false) {
  global $msg_script30;
  $DEPT = mswGetTableData('departments','id',$id);
  if ($object) {
    return $DEPT;
  }
  return (isset($DEPT->name) ? mswSpecialChars($DEPT->name) : $msg_script30);
}

// Priority levels array..
function mswGetPriorityLevel($level,$arr=false,$keys=false,$filter=false) {
  $level  = strtolower($level);
  $levels = array();
  $q      = mysql_query("SELECT * FROM ".DB_PREFIX."levels
            ".($filter ? 'WHERE `display` = \'yes\'' : '')."
            ORDER BY `orderBy`
            ")
            or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  while ($L = mysql_fetch_object($q)) {
    $levels[($L->marker ? $L->marker : $L->id)] = mswSpecialChars($L->name);
  }
  if ($keys) {
    return array_keys($levels);
  } else {
    if ($arr) {
      return $levels;
    } else {
      return (isset($levels[$level]) ? $levels[$level] : $levels['low']);
    }
  }
}

// Catch MySQL errors..
function mswMysqlErrMsg($code,$error,$file,$line) {
  global $msg_script61,$SETTINGS;
  echo '<p style="color:red;border:2px solid red;padding:10px;font-size:12px;line-height:20px;background:#f2f2f2 url('.(isset($SETTINGS->scriptpath) ? $SETTINGS->scriptpath.'/' : '').'templates/images/alert.png) no-repeat 98% 50%">';
  echo '<b style="color:black">MYSQL DATABASE ERROR:</b><br />';
  echo '<b>'.(isset($msg_script61[0]) ? $msg_script61[0] : 'Code').'</b>: '.$code.'<br />';
  echo '<b>'.(isset($msg_script61[1]) ? $msg_script61[1] : 'Error').'</b>: '.$error.'<br />';
  echo '<b>'.(isset($msg_script61[2]) ? $msg_script61[2] : 'File').'</b>: '.$line.'<br />';
  echo '<b>'.(isset($msg_script61[3]) ? $msg_script61[3] : 'Line').'</b>: '.$file.'<br />';
  echo '</p>';
  exit;
}

// Reverses ticket number and removes zeros..
function mswReverseTicketNumber($num) {
  return ltrim($num,'0'); 
}

// File size..
function mswFileSizeConversion($size=0,$base='1048576') {
  global $msg_script19;
  if ($size>0) {
    if ($size>1023987) {
      return number_format($size/$base,1).'MB';
    } else if ($size<1024) {
      return $size.' '.$msg_script19;
    } else {
      return number_format($size/1024,0).'KB';
    }
  } else {
    return '0KB';
  }
}

// Remote file size..
function mswFileRemoteSizeConversion($url) {
  // PHP 5+ only..
  if (function_exists('get_headers')) {
    $array = get_headers($url,1);
    return (isset($array['Content-Length']) ? $array['Content-Length'] : '0');
  } else {
    // If thats no good, try curl..
    if (function_exists('curl_init')) {
      $ch = @curl_init();
      @curl_setopt($ch, CURLOPT_URL, $url);
      @curl_setopt($ch, CURLOPT_HEADER, true);
      @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $site = @curl_exec($ch);
      @curl_close($ch);
      $data = substr($site,0,strpos($site,'Content-Type'));
      if ($data) {
        $string = strrchr($data,':');
        $string = trim(substr($string,1));
        $string = trim($string);
        return ((int)$string>0 ? (int)$string : '0');
      }
    }
  }
  // Nothing doing I guess..
  return 'N/A';
}

// Builds xml response headers for ajax..
function mswXMLResponse($tags) {
  @ob_start();
  header('Content-Type: text/xml');
  echo '<?xml version="1.0" encoding="utf-8" standalone="yes" ?>';
  echo '<response>'.$tags.'</response>';
  @ob_end_flush();
  exit;
}

// Page not found..
function msw404() {
  include(PATH.'control/system/response-headers/404.php');
  exit;
}

// Forbidden..
function msw403() {
  include(PATH.'control/system/response-headers/403.php');
  exit;
}

// Digit check..
function mswCheckDigit($id) {
  global $msg_script6;
  if (!is_numeric($id)) {
    header("HTTP/1.0 404 Not Found");
    echo '<h1>'.$msg_script6.'</h1>';
    exit;
  }
}

// Assign ticket status based on value..
function mswGetTicketStatus($tstatus,$rstatus,$dispute='no') {
  global $msg_open11,$msg_open12,$msg_open13,$msg_open14,$msg_open30;
  switch ($tstatus) {
    case 'open':
    return ($rstatus=='admin' || $rstatus=='start' ? ($dispute=='yes' ? $msg_open30 : $msg_open11) :  $msg_open12);
    break;
    case 'close':
    return $msg_open13;
    break;
    case 'closed':
    return $msg_open14;
    break;
  }
}

// Calculate ticket number based on digits..
function mswTicketNumber($num) {
  $zeros = '';
  if (MIN_DIGITS_TICKETS>0 && MIN_DIGITS_TICKETS>strlen($num)) {
    for ($i=0; $i<MIN_DIGITS_TICKETS-strlen($num); $i++) {
      $zeros .= 0;
    }
  }
  return $zeros.$num;
}

// Filter for some javascript routines
function mswFilterJS($data) {
  $data  = str_replace("'","\'",$data);
  $data  = mswSpecialChars($data);
  return $data;
}

// Help tip..
function mswDisplayHelpTip($text,$align='CENTER') {
  if (!HELP_TIPS) {
    return '';
  }
  global $msg_javascript4;
  // Tip positioning...
  switch (strtoupper($align)) {
    case 'RIGHT':
    $xy = 'ol_offsety = 5, ol_offsetx = 25';
    break;
    case 'LEFT':
    $xy = 'ol_offsety = 10, ol_offsetx = 10';
    break;
    default:
    $xy = 'ol_offsety = 20, ol_offsetx = 10';
    break;
  }
  $html = '<div class="toolTip">'.$text.'</div>';
  return '<a href="javascript:void(0);" onmouseover="return overlib(\''.mswSpecialChars($html).'\',\''.mswSpecialChars($msg_javascript4).'\', '.$align.', '.$xy.');" onmouseout="nd();"><img style="cursor:help;vertical-align:bottom" src="templates/images/help.png" alt="" title="" /></a>';
}

// Gets data based on param criteria..
function mswGetTableData($table,$row,$id,$and='',$params='*') {
  $query = mysql_query("SELECT $params FROM ".DB_PREFIX.$table."
           WHERE $row  = '$id'
           $and
           LIMIT 1
           ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  return mysql_fetch_object($query);
}

// Gets row count..
function mswRowCount($table,$where='',$format=true) {
  $query = mysql_query("SELECT count(*) AS r_count FROM ".DB_PREFIX.$table.$where."") 
           or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $row = mysql_fetch_object($query);
  if ($format) {
    return number_format($row->r_count);
  } else {
    return $row->r_count;
  }
}

// Clean data..
function mswCleanData($data) {
  if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
    $sybase  = strtolower(@ini_get('magic_quotes_sybase'));
    if (empty($sybase) || $sybase=='off') {
      // Fixes issue of new line chars not parsing between single quotes..
      $data = str_replace('\n','\\\n',$data);
      return stripslashes($data);
    }
  }
  return trim($data);
}

// Clean evil tags from incoming post data..
function mswCleanEvilTags($data) {
  if (CLEAN_HARMFUL_TAGS) {
    $data = preg_replace("/onmouseover/i", "&#111;nmouseover",$data);
    $data = preg_replace("/onclick/i", "&#111;nclick",$data);
    $data = preg_replace("/onload/i", "&#111;nload",$data);
    $data = preg_replace("/onsubmit/i", "&#111;nsubmit",$data);
    $data = preg_replace("/<body/i", "&lt;body",$data);
    $data = preg_replace("/<html/i", "&lt;html",$data);
    $data = preg_replace("/<script/i", "&lt;&#115;cript",$data);
  }
  return trim($data);
}

// Gets visitor IP address..
function mswIPAddresses() {
  $ip = array();
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip[] = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'],',')!==FALSE) {
      $split = explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']);
      foreach ($split AS $value) {
        $ip[] = $value;
      }
    } else {
      $ip[] = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
  } else {
    $ip[] = (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
  }
  return (!empty($ip) ? substr(implode(', ',$ip),0,250) : '');
}

// Define newline..
function mswDefineNewline() {
  if (defined('PHP_EOL')) {
    return PHP_EOL;
  }
  $unewline = "\r\n";
  if (strstr(strtolower($_SERVER["HTTP_USER_AGENT"]), 'win')) {
    $unewline = "\r\n";
  } else if (strstr(strtolower($_SERVER["HTTP_USER_AGENT"]), 'mac')) {
    $unewline = "\r";
  } else {
    $unewline = PHP_EOL;
  }
  return $unewline;
}

// Get browser type..
function mswGetBrowserType() {
  $agent = 'IE';
  if (isset($_SERVER['HTTP_USER_AGENT'])) {
    if (strpos($_SERVER['HTTP_USER_AGENT'],'OPERA')!==FALSE) {
      $agent = 'OPERA';
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'],'MSIE')!==FALSE) {
      $agent = 'IE';
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'],'OMNIWEB')!==FALSE) {
      $agent = 'OMNIWEB';
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'],'MOZILLA')!==FALSE) {
      $agent = 'MOZILLA';
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'],'KONQUEROR')!==FALSE) {
      $agent = 'KONQUEROR';
    } else {
      $agent = 'OTHER';
    }
  }
  return $agent;
}

// Get mime type..
function mswGetMimeType() {
  $agent     = mswGetBrowserType();
  $mime_type = ($agent == 'IE' || $agent == 'OPERA')
  ? 'application/octetstream'
  : 'application/octet-stream';
  return $mime_type;
}

// Convert bad multibyte chars..
function mswStripMultibyteChars($str) {
  $result = '';
  $length = strlen($str);
  for ($i = 0; $i < $length; $i++){
    $ord = ord($str[$i]);
    if ($ord >= 240 && $ord <= 244) {
      $result .= '?';
      $i += 3;
    } else {
      $result .= $str[$i];
    }
  }
  return $result;
}

// Safe mysql import..none array..
function mswSafeImportString($data) {
  if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
    $sybase  = strtolower(@ini_get('magic_quotes_sybase'));
    if (empty($sybase) || $sybase=='off') {
      $data  = stripslashes($data);
    } else {
      $data  = mswRemoveDoubleApostrophes($data);
    }
  }
  // Strip bad multibyte characters and replace with ?.
  if (DB_CHAR_SET=='utf8' && CONVERT_BAD_MULTIBYTE_CHARS) {
    $data = mswStripMultibyteChars($data);
  }
  // Fix microsoft word smart quotes..
  $data  = mswConvertSmartQuotes($data);
  // Fix grave accents..
  $data  = mysql_real_escape_string($data);
  return $data;
}

// Special char..
function mswSpecialChars($data) {
  return htmlspecialchars(mswCleanData($data));
}

// Fix Microsoft Word smart quotes..
function mswConvertSmartQuotes($string) { 
  $search   = array(chr(145),chr(146),chr(147),chr(148),chr(151)); 
  $replace  = array("'","'",'"','"','-'); 
  return str_replace($search,$replace,$string); 
} 

// Remove double apostrophes via magic quotes setting..
function mswRemoveDoubleApostrophes($data) {
  return str_replace("''","'",$data);
}

// Recursive way of handling multi dimensional arrays..
function mswMultiDimensionalArrayMap($func,$arr) {
  $newArr = array();
  if (!empty($arr)) {
    foreach($arr AS $key => $value) {
      $newArr[$key] = (is_array($value) ? mswMultiDimensionalArrayMap($func,$value) : $func($value));
    }
  }
  return $newArr;
}

// Get language..
function mswVisLang($lang='') {
  global $SETTINGS;
  if ($lang) {
    return (is_dir(PATH.'templates/language/'.$lang) ? strtolower($lang) : strtolower($SETTINGS->language));
  } else {
    return (isset($_COOKIE['mslang_'.md5(SECRET_KEY)]) && is_dir(PATH.'templates/language/'.$_COOKIE['mslang_'.md5(SECRET_KEY)]) ?
            strtolower($_COOKIE['mslang_'.md5(SECRET_KEY)]) :
            strtolower($SETTINGS->language)
    ); 
  }
}

// Language switcher..
function mswLangSwitcher() {
  if (LANG_SWITCH_ENABLE) {
    if (isset($_GET['l'])) {
      // Clean up..
      $_GET['l'] = (preg_replace('/[^A-Za-z0-9\s\s+\-]/','',$_GET['l']));
      if (is_dir(PATH.'templates/language/'.$_GET['l'])) {
        // Remove cookie if set..
        if (isset($_COOKIE['mslang_'.md5(SECRET_KEY)])) {
          @setcookie('mslang_'.md5(SECRET_KEY),'');
        }
        // Set cookie..
        @setcookie('mslang_'.md5(SECRET_KEY),$_GET['l'],time()+60*60*24*LANG_SWITCH_COOKIE);
      }
      header("Location: index.php");
      exit;
    }
  }
  // Clear cookies if language disabled..
  if (!LANG_SWITCH_ENABLE && isset($_COOKIE['mslang_'.md5(SECRET_KEY)])) {
    @setcookie('mslang_'.md5(SECRET_KEY),'');
  }
  // Forbidden message if someone attempts to load language with switch off..
  if (!LANG_SWITCH_ENABLE && isset($_GET['l'])) {
    msw403();
  }
}

// Make urls clickable..
function mswClickableUrl($matches) {
  $ret = '';
  $url = $matches[2];
  if (empty($url)) {
    return $matches[0];
  }
  // removed trailing [.,;:] from URL
  if (in_array(substr($url,-1),array('.', ',', ';', ':'))=== true) {
    $ret = substr($url,-1);
    $url = substr($url,0,strlen($url)-1);
  }
  return $matches[1].'<a href="'.$url.'" rel="nofollow" onclick="window.open(this);return false" title="'.$url.'">'.$url.'</a>'.$ret;
}
 
// Make FTP links clickable..
function mswClickableFTP($matches) {
  $ret   = '';
  $dest  = $matches[2];
  $dest  = 'http://'.$dest;
  if (empty($dest)) {
    return $matches[0];
  }
  // removed trailing [,;:] from URL
  if (in_array(substr($dest,-1),array('.', ',', ';', ':'))===true) {
    $ret   = substr($dest,-1);
    $dest  = substr($dest,0,strlen($dest)-1);
  }
  return $matches[1].'<a href="'.$dest.'" rel="nofollow" onclick="window.open(this);return false" title="'.$dest.'">'.$dest.'</a>'.$ret;
}

// Hyperlinks, no protocol..
function mswClickableUrlNP($matches) {
  $dest = $matches[2].'.'.$matches[3].$matches[4];
  return $matches[1].'<a href="http://'.$dest.'">'.$dest.'</a>';
}
 
// Make e-mail links clickable..
function mswClickableEmail($matches) {
  $email = $matches[2].'@'.$matches[3];
  return $matches[1].'<a href="mailto:'.$email.'" title="'.$email.'">'.$email.'</a>';
}

// Callback functions for link parsing..
function mswAutoLinkParser($data) {
  $data  = mswSpecialChars($data);
  $ext   = 'com|org|net|gov|edu|mil|co.uk|uk.com|us|info|biz|ws|name|mobi|cc|tv';
  // Auto parse links..borrowed from Wordpress..:)
  $data  = preg_replace_callback('#(?!<.*?)(?<=[\s>])(\()?(([\w]+?)://((?:[\w\\x80-\\xff\#$%&~/\-=?@\[\](+]|[.,;:](?![\s<])|(?(1)\)(?![\s<])|\)))+))(?![^<>]*?>)#is', 'mswClickableUrl', $data);
  $data  = preg_replace_callback( "#(?!<.*?)([\s{}\(\)\[\]>])([a-z0-9\-\.]+[a-z0-9\-])\.($ext)((?:[/\#?][^\s<{}\(\)\[\]]*[^\.,\s<{}\(\)\[\]]?)?)(?![^<>]*?>)#is",'mswClickableUrlNP', $data);
  $data  = preg_replace_callback('#([\s>])((www|ftp)\.[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', 'mswClickableFTP', $data);
  $data  = preg_replace_callback('#([\s>])([.0-9a-z_+-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})#i', 'mswClickableEmail', $data);
  // Clean links within links..
  $data  = preg_replace("#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i", "$1$3</a>", $data);
  return $data;
}

// Global filtering on post and get inputs using callback mechanism..
$_GET   = mswMultiDimensionalArrayMap('mswCleanEvilTags',$_GET);
$_GET   = mswMultiDimensionalArrayMap('htmlspecialchars',$_GET);
$_POST  = mswMultiDimensionalArrayMap('trim',$_POST);

// Security check for register globals being off..
// Unlikely, but just in case..
if (isset($_GET['isAyumiAlive'])) {
  msw403();
}

// Database connection..
mswDBConnector();

?>