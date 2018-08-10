<?php if(!defined('PARENT')) { exit; }
if (isset($_GET['attachments'])) { 
  $_GET['attachments'] = (int)$_GET['attachments'];
}
if (isset($_GET['attach'])) { 
  $_GET['attach'] = (int)$_GET['attach'];
}
if (file_exists(PATH.'templates/header-custom.php')) {
  include_once(PATH.'templates/header-custom.php');
} else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
}
?>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=<?php echo $msg_charset; ?>" />
<title><?php echo mswSpecialChars($msg_settings23); ?></title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.js"></script>
<script type="text/javascript" src="templates/js/js_code.js"></script>
</head>

<body>

<div id="bodyOverride">

<div id="windowWrapper">
  <?php
  if (isset($_GET['attach'])) {
    $SQL = "`replyID`  = '{$_GET['attach']}'";
    $ID  = $_GET['attach'];
  } else {
    $SQL = "`ticketID` = '{$_GET['attachments']}' AND `replyID` = '0'";
    $ID  = $_GET['attachments'];
  }
  $query = mysql_query("SELECT *,DATE(FROM_UNIXTIME(`ts`)) AS `addDate` FROM ".DB_PREFIX."attachments
           WHERE $SQL
           ORDER BY `fileName`
           ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  ?>
  <h1><?php echo str_replace(array('{count}','{ticket}'),array(mysql_num_rows($query),mswTicketNumber($ID)),$msg_viewticket29); ?></h1>
  <?php
  if (mysql_num_rows($query)>0) {
  ?>
  <form method="post" id="form" action="?p=view-ticket&amp;<?php echo (isset($_GET['attach']) ? 't='.$_GET['t'].'&amp;attach' : 'attachments'); ?>=<?php echo $ID; ?>" onsubmit="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')">
  <div class="attachment">
  <ul>
   <li class="title"><span class="float"><?php echo $msg_viewticket33; ?></span>
   <?php
   if (USER_DEL_PRIV=='yes') {
   ?>
   <input onclick="selectAll('form')" name="log" type="checkbox" value="1" />&nbsp;&nbsp;&nbsp;<?php echo $msg_viewticket32; ?>
   <?php
   } else {
   echo '&nbsp;';
   }
   ?>
   </li>
  <?php
  $dual = 0;
  while ($ATT = mysql_fetch_object($query)) {
  $ext     = strrchr($ATT->fileName, '.');
  $split   = explode('-',$ATT->addDate);
  $folder  = '';
  // Check for newer folder structure..
  if (file_exists($SETTINGS->attachpath.'/'.$split[0].'/'.$split[1].'/'.$ATT->fileName)) {
    $folder  = $split[0].'/'.$split[1].'/';
  }
  ?>
  <li class="<?php echo (++$dual%2==0 ? 'odd' : 'even'); ?>"><span class="float"><?php echo mswFileSizeConversion($ATT->fileSize); ?></span>
  <?php
  if (USER_DEL_PRIV=='yes') {
  ?>
  <input type="checkbox" name="id[]" value="<?php echo $ATT->id; ?>" />&nbsp;&nbsp;&nbsp;
  <?php
  }
  ?>
  <span class="highlight">[<?php echo substr(strtoupper($ext),1); ?>]</span> <a href="../templates/attachments/<?php echo $folder.$ATT->fileName; ?>" title="<?php echo mswSpecialChars($msg_viewticket50); ?>" onclick="window.open(this);return false"><?php echo substr($ATT->fileName,0,strpos($ATT->fileName,'.')); ?></a></li>
  <?php
  }
  ?>
  </ul>
  <br class="clear" />
  </div>
  <?php
  if (USER_DEL_PRIV=='yes') {
  ?>
  <p class="buttonWrapper">
   <input type="hidden" name="process" value="1" />
   <input class="button" type="submit" value="<?php echo mswSpecialChars($msg_viewticket34); ?>" title="<?php echo mswSpecialChars($msg_viewticket34); ?>" />
  </p> 
  <?php
  }
  ?>
  </form>
  <?php
  } else {
  ?>
  <div class="windowContent">
    <p><?php echo (isset($_GET['attach']) ? $msg_viewticket44 : $msg_viewticket31); ?></p>
  </div>
  <?php
  }
  ?>  
</div>  

</div>

</body>

</html>
