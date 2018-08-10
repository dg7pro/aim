<?php if(!defined('PARENT')) { exit; } 

if (isset($OK)) {
  echo mswActionCompleted($msg_log5);
}

$pageCount = mswRowCount('log');

?>

<div id="headWrapper">
  
  <div id="message">
   <p><?php echo $msg_log; ?></p>
  </div>
  
</div>

<div class="contentWrapper"> 
  <?php
  if ($pageCount>0) {
  ?>
  <h2 class="logHeader"><span class="log_options">
      <a class="export_log" href="?p=log&amp;export=1<?php echo (isset($_GET['user']) ? '&amp;user='.(int)$_GET['user'] : ''); ?>" title="<?php echo mswSpecialChars($msg_log3); ?>"><?php echo $msg_log3; ?></a>
      <?php
      if (USER_DEL_PRIV=='yes') {
      ?>
      <a class="clear_log" href="?p=log&amp;clear=1<?php echo (isset($_GET['user']) ? '&amp;user='.(int)$_GET['user'] : ''); ?>" title="<?php echo mswSpecialChars($msg_log2); ?>" onclick="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')"><?php echo $msg_log2; ?></a>
      <?php
      }
      ?>
      </span>
      <select onchange="location=this.options[this.selectedIndex].value">
      <option value="?p=log"><?php echo $msg_log6; ?></option>
      <?php
      $q_users = mysql_query("SELECT * FROM ".DB_PREFIX."users GROUP BY `name` ORDER BY `name`") 
                 or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      while ($USER = mysql_fetch_object($q_users)) {
      ?>
      <option value="?p=log&amp;user=<?php echo $USER->id; ?>"<?php echo (isset($_GET['user']) && $_GET['user']==$USER->id ? ' selected="selected"' : ''); ?>><?php echo mswSpecialChars($USER->name); ?></option>
      <?php
      }
      ?>
      </select>
  </h2>
  <?php
  }
  ?>
  <div class="formWrapper">
    <?php
    $countedRows = 0;
    $limit       = LOG_ENTRIES;
    $limitvalue  = $page * $limit - ($limit);
    $q_log       = mysql_query("SELECT SQL_CALC_FOUND_ROWS *,".DB_PREFIX."log.ts AS lts FROM ".DB_PREFIX."log
                   LEFT JOIN ".DB_PREFIX."users
                   ON ".DB_PREFIX."log.`userID` = ".DB_PREFIX."users.`id` 
                   ".(isset($_GET['user']) && $_GET['user']>0 ? 'WHERE `userID` = \''.(int)$_GET['user'].'\'' : '')."
                   ORDER BY ".DB_PREFIX."log.`id` DESC
                   LIMIT $limitvalue,".LOG_ENTRIES."
                   ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    if (mysql_num_rows($q_log)>0) {
    $c            = mysql_fetch_object(mysql_query("SELECT FOUND_ROWS() AS rows"));
    $countedRows  =  (isset($c->rows) ? $c->rows : '0');
    while ($LOG = mysql_fetch_object($q_log)) {
    ?>
    <div class="logEntry">
      <p><span class="datetime"><?php echo mswDateDisplay($LOG->lts,$SETTINGS->dateformat).' / '.mswTimeDisplay($LOG->lts,$SETTINGS->timeformat); ?></span><?php echo mswSpecialChars($LOG->name); ?></p>
    </div>
    <?php
    }
    } else {
    ?>
    <p class="nodata"><?php echo $msg_log4; ?></p>
    <?php
    }
    ?>
  
  </div>
  
</div>  
<?php
define('PER_PAGE',LOG_ENTRIES);
if ($countedRows>0 && $countedRows>LOG_ENTRIES) {
  $PTION = new pagination($countedRows,'?p='.$cmd.'&amp;next=');
  echo $PTION->display();
}
?>