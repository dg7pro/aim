<?php if(!defined('PARENT')) { exit; } 
$_GET['responses'] = (int)$_GET['responses'];
$USER = mswGetTableData('users','id',$_GET['responses']);
if (file_exists(PATH.'templates/header-custom.php')) {
  include_once(PATH.'templates/header-custom.php');
} else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
}
$filter = '';
if (isset($_GET['f']) && in_array($_GET['f'],array('t','d'))) {
  switch ($_GET['f']) {
    case 't':
    $filter = 'AND `isDisputed` = \'no\'';
    break;
    case 'd':
    $filter = 'AND `isDisputed` = \'yes\'';
    break;
  }
}
if (isset($_GET['from']) && isset($_GET['to']) && $_GET['from'] && $_GET['to']) {
  $filter .= 'AND DATE(FROM_UNIXTIME('.DB_PREFIX.'replies.ts)) BETWEEN \''.mswDatePickerFormat($_GET['from']).'\' AND \''.mswDatePickerFormat($_GET['to']).'\'';
}
?>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=<?php echo $msg_charset; ?>" />
<title><?php echo mswSpecialChars($msg_kbase12); ?></title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.js"></script>
<script type="text/javascript" src="templates/greybox/greybox.js"></script>
<script type="text/javascript" src="templates/js/jquery-ui.js"></script>
<link href="jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
//<![CDATA[
<?php  
include(PATH.'templates/date-pickers.php');
?>
//]]>
</script>
</head>

<body>

<div id="bodyOverride">

<div id="windowWrapper">
  <?php
  $countedRows = 0;
  $limit       = MAX_USERRESP_ENTRIES;
  $limitvalue  = $page * $limit - ($limit);
  $query = mysql_query("SELECT SQL_CALC_FOUND_ROWS *,".DB_PREFIX."replies.`id` AS repid,".DB_PREFIX."replies.`comments` AS repcomms 
           FROM ".DB_PREFIX."replies
           LEFT JOIN ".DB_PREFIX."tickets
           ON ".DB_PREFIX."replies.ticketID = ".DB_PREFIX."tickets.id
           WHERE `replyType`                = 'admin'
           AND `replyUser`                  = '{$_GET['responses']}'
           $filter
           GROUP BY ".DB_PREFIX."replies.`id`,".DB_PREFIX."replies.`ticketID`
           ORDER BY ".DB_PREFIX."replies.`id` DESC
           LIMIT $limitvalue,".MAX_USERRESP_ENTRIES."
           ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $c            = mysql_fetch_object(mysql_query("SELECT FOUND_ROWS() AS rows"));
  $countedRows  =  (isset($c->rows) ? $c->rows : '0');
  ?>         
  <h1><span class="float2"><a class="graph" href="?p=users&amp;graph=<?php echo $_GET['responses']; ?>" title="<?php echo mswSpecialChars($msg_user31); ?>"><?php echo $msg_user31; ?></a> <a class="userdetails" href="?p=users&amp;view=<?php echo $_GET['responses']; ?>" title="<?php echo mswSpecialChars($msg_user10); ?>"><?php echo $msg_user10; ?></a></span><?php echo mswSpecialChars($USER->name); ?> <span class="highlight_normal">(<?php echo $countedRows.' '.$msg_user34; ?>)</span></h1>
  
  <form method="get" action="index.php">
  <div class="filters">
    <p>
     <input type="hidden" name="p" value="users" />
     <input type="hidden" name="responses" value="<?php echo $_GET['responses']; ?>" />
     <select id="filter" name="f" onchange="window.location='?p=users&amp;responses=<?php echo $_GET['responses']; ?>&amp;f='+jQuery('#filter').val()+'&amp;from=<?php echo (isset($_GET['from']) ? mswSpecialChars($_GET['from']) : ''); ?>&amp;to=<?php echo (isset($_GET['to']) ? mswSpecialChars($_GET['to']) : ''); ?>'">
      <option value="all"><?php echo $msg_user60; ?></option>
      <option value="t"<?php echo (isset($_GET['f']) && $_GET['f']=='t' ? ' selected="selected"' : ''); ?>><?php echo $msg_user61; ?></option>
      <option value="d"<?php echo (isset($_GET['f']) && $_GET['f']=='d' ? ' selected="selected"' : ''); ?>><?php echo $msg_user62; ?></option>
     </select>
     <?php echo $msg_user63; ?>: <input id="from" class="box" type="text" name="from" value="<?php echo (isset($_GET['from']) ? mswSpecialChars($_GET['from']) : ''); ?>" /> &amp; <input id="to" class="box" type="text" name="to" value="<?php echo (isset($_GET['to']) ? mswSpecialChars($_GET['to']) : ''); ?>" /> <input type="submit" value=" &raquo; " class="button" />
     <br class="clear" />
    </p>
  </div>
  </form>
  
  <?php
  if (mysql_num_rows($query)>0) {
  while ($REPLY = mysql_fetch_object($query)) {
  ?>
  <div class="userReply">
    <p><?php echo mswTxtParsingEngine($REPLY->repcomms); ?></p>
    <p class="replyBase"><span class="<?php echo ($REPLY->isDisputed=='yes' ? 'viewdispute' : 'view'); ?>"><a href="#" onclick="parent.window.location='?p=view-<?php echo ($REPLY->isDisputed=='yes' ? 'dispute' : 'ticket'); ?>&amp;id=<?php echo $REPLY->ticketID; ?>'" title="<?php echo mswSpecialChars(($REPLY->isDisputed=='yes' ? $msg_user59 : $msg_user29)); ?>"><?php echo ($REPLY->isDisputed=='yes' ? $msg_user59 : $msg_user29); ?></a></span><?php echo ($REPLY->isDisputed=='yes' ? $msg_user58 : $msg_user30).': #'.mswTicketNumber($REPLY->ticketID).' - '.mswDateDisplay($REPLY->ts,$SETTINGS->dateformat).' / '.mswTimeDisplay($REPLY->ts,$SETTINGS->timeformat); ?></p>
  </div>
  <?php
  }
  } else {
  ?>
  <p class="nodata"><?php echo $msg_user22; ?></p>
  <?php
  }
  ?>
  
</div>  
<?php
define('PER_PAGE',MAX_USERRESP_ENTRIES);
if ($countedRows>0 && $countedRows>MAX_USERRESP_ENTRIES) {
  $PTION = new pagination($countedRows,'?p='.$cmd.'&amp;responses='.$_GET['responses'].'&amp;next=');
  echo $PTION->display();
}
?>
</div>

</body>

</html>