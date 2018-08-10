<?php if(!defined('PARENT')) { exit; } 
$_GET['view'] = (int)$_GET['view'];
$q_user = mysql_query("SELECT * FROM ".DB_PREFIX."users
          WHERE `id` = '{$_GET['view']}'
          ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
$USER = mysql_fetch_object($q_user);
$q_stamp = mysql_query("SELECT `ts` FROM ".DB_PREFIX."replies
           WHERE `replyUser` = '{$_GET['view']}'
           ORDER BY `id` DESC
           LIMIT 1
           ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
$LAST = mysql_fetch_object($q_stamp);
$q_login = mysql_query("SELECT `ts` FROM ".DB_PREFIX."log
           WHERE `userID` = '{$_GET['view']}'
           ORDER BY `id` DESC
           LIMIT 1
           ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
$LOGIN = mysql_fetch_object($q_login);
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
<title><?php echo mswSpecialChars($msg_kbase12); ?></title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div id="bodyOverride">

<div id="windowWrapper">

  <h1><span class="float"><a class="responses" href="?p=users&amp;responses=<?php echo $_GET['view']; ?>" title="<?php echo mswSpecialChars($msg_user25); ?>"><?php echo $msg_user25; ?></a> <a class="graph" href="?p=users&amp;graph=<?php echo $_GET['view']; ?>" title="<?php echo mswSpecialChars($msg_user31); ?>"><?php echo $msg_user31; ?></a></span><?php echo mswSpecialChars($USER->name); ?> <span class="highlight_normal">(<a href="mailto:<?php echo mswCleanData($USER->email); ?>" title="<?php echo mswSpecialChars($USER->email); ?>"><?php echo mswCleanData($USER->email); ?></a>)</span></h1>
  
  <div class="windowContentUser">
  
    <div class="windowContentUserLeft">
    
      <fieldset>
        <legend><?php echo $msg_user5; ?></legend>
        <p>
        <?php
        if ($_GET['view']=='1') {
          echo $msg_user26;
        } else {
          $q_dept = mysql_query("SELECT * FROM ".DB_PREFIX."userdepts
                    LEFT JOIN ".DB_PREFIX."departments
                    ON ".DB_PREFIX."userdepts.`deptID` = ".DB_PREFIX."departments.`id`
                    WHERE `userID`                     = '{$_GET['view']}'
                    ORDER BY `name`
                    ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
          while ($DEPT = mysql_fetch_object($q_dept)) {
            echo mswSpecialChars($DEPT->name).(++$count!=mysql_num_rows($q_dept) ? ', ' : '');
          }
          $pageAccess = mswGetUserPageAccess($_GET['view']);
        }
        ?>
        </p>
      </fieldset>
      
      <fieldset style="margin:10px 0 0 0">
        <legend><?php echo $msg_user69; ?></legend>
        <p><?php echo ($USER->assigned=='yes' ? $msg_script4 : $msg_script5); ?> (<a href="?p=users&amp;view=<?php echo $_GET['view']; ?>&amp;set_assigned=<?php echo ($USER->assigned=='yes' ? 'no' : 'yes'); ?>" title="<?php echo mswSpecialChars($msg_user39); ?>"><?php echo $msg_user39; ?></a>)</p>
      </fieldset>
      
      <fieldset style="margin:10px 0 0 0">
        <legend><?php echo $msg_user18; ?></legend>
        <p><?php echo ($USER->notify=='yes' ? $msg_script4 : $msg_script5); ?> (<a href="?p=users&amp;view=<?php echo $_GET['view']; ?>&amp;set_notify=<?php echo ($USER->notify=='yes' ? 'no' : 'yes'); ?>" title="<?php echo mswSpecialChars($msg_user39); ?>"><?php echo $msg_user39; ?></a>)</p>
      </fieldset>
      
      <fieldset style="margin:10px 0 0 0">
        <legend><?php echo $msg_user54; ?></legend>
        <p><?php echo ($USER->notePadEnable=='yes' ? $msg_script4 : $msg_script5); ?> (<a href="?p=users&amp;view=<?php echo $_GET['view']; ?>&amp;set_pad=<?php echo ($USER->notePadEnable=='yes' ? 'no' : 'yes'); ?>" title="<?php echo mswSpecialChars($msg_user39); ?>"><?php echo $msg_user39; ?></a>)</p>
      </fieldset>
      
      <?php
      if (USER_DEL_PRIV=='yes') {
      ?>
      <fieldset style="margin:10px 0 0 0">
        <legend><?php echo $msg_user64; ?></legend>
        <p><?php echo ($USER->delPriv=='yes' ? $msg_script4 : $msg_script5); ?> (<a href="?p=users&amp;view=<?php echo $_GET['view']; ?>&amp;set_priv=<?php echo ($USER->delPriv=='yes' ? 'no' : 'yes'); ?>" title="<?php echo mswSpecialChars($msg_user39); ?>"><?php echo $msg_user39; ?></a>)</p>
      </fieldset>
      <?php
      }
      ?>
      <fieldset style="margin:10px 0 0 0">
        <legend><?php echo $msg_user19; ?></legend>
        <p><?php echo ($USER->signature ? (AUTO_PARSE_LINE_BREAKS ? nl2br($USER->signature) : $USER->signature) : mswSpecialChars($msg_script17)); ?></p>
      </fieldset>
     
    </div>
    
    <div class="windowContentUserRight">
      
      <fieldset>
        <legend><?php echo $msg_user24; ?></legend>
        <p>
        <?php 
        if ($_GET['view']==1) {
          echo $msg_user27;
        } else {
          $count = 0;
          $match = mswGetAdminPages();
          if (!empty($pageAccess)) {
            foreach ($pageAccess AS $pA) {
              if (isset($match[$pA])) {
                echo $match[$pA].(++$count!=count($pageAccess) ? ', ' : '');
              }
            }   
          }
          if ($count==0) {
            echo $msg_user68;
          }
        }
        ?>
        </p>
      </fieldset>
      
      <fieldset style="margin:10px 0 0 0">
        <legend><?php echo $msg_user70; ?></legend>
        <p>
        <select name="timezone" onchange="location=this.options[this.selectedIndex].value">
        <option value="?p=users&amp;view=<?php echo $_GET['view']; ?>&amp;set_timezone=0">- - - - - - -</option>
        <?php
        // TIMEZONES..
        foreach ($timezones AS $k => $v) {
        ?>
        <option value="?p=users&amp;view=<?php echo $_GET['view']; ?>&amp;set_timezone=<?php echo $k; ?>"<?php echo ($USER->timezone==$k ? ' selected="selected"' : ''); ?>><?php echo $v; ?></option>
        <?php
        }
        ?>
        </select>
        </p>
      </fieldset>
      
      <fieldset style="margin:10px 0 0 0">
        <legend><?php echo $msg_user45; ?></legend>
        <p><?php echo ($USER->emailSigs=='yes' ? $msg_script4 : $msg_script5); ?> (<a href="?p=users&amp;view=<?php echo $_GET['view']; ?>&amp;set_sig=<?php echo ($USER->emailSigs=='yes' ? 'no' : 'yes'); ?>" title="<?php echo mswSpecialChars($msg_user39); ?>"><?php echo $msg_user39; ?></a>)</p>
      </fieldset>
      
      <fieldset style="margin:10px 0 0 0">
        <legend><?php echo $msg_user67; ?></legend>
        <p><?php echo ($USER->nameFrom ? $USER->nameFrom : 'N/A'); ?> / <?php echo ($USER->emailFrom ? $USER->emailFrom : 'N/A'); ?></p>
      </fieldset>
      
      <fieldset style="margin:10px 0 0 0">
        <legend><?php echo $msg_user36; ?></legend>
        <p>
         <?php echo $msg_user28; ?>  <span class="highlight2"><?php echo mswDateDisplay($USER->ts,$SETTINGS->dateformat); ?></span><br />
         <?php echo $msg_user35; ?>: <span class="highlight2"><?php echo number_format(mswRowCount('replies WHERE `replyUser` = \''.$_GET['view'].'\'')); ?></span><br /><br />
         <?php echo $msg_user37; ?>: <span class="highlight2"><?php echo (isset($LAST->ts) ? mswDateDisplay($LAST->ts,$SETTINGS->dateformat).' / '.mswTimeDisplay($LAST->ts,$SETTINGS->timeformat) : 'N/A'); ?></span><br />
         <?php echo $msg_user38; ?>: <span class="highlight2"><?php echo (isset($LOGIN->ts) ? mswDateDisplay($LOGIN->ts,$SETTINGS->dateformat).' / '.mswTimeDisplay($LOGIN->ts,$SETTINGS->timeformat) : '- -'); ?></span>
        </p>
      </fieldset>
      
    </div>
  
    <br class="clear" />
  </div>
  
  <p class="windowFooter" style="margin-top:20px">
   <a href="javascript:window.print()" title="<?php echo mswSpecialChars($msg_script14); ?>"><img src="templates/images/print.png" alt="<?php echo mswSpecialChars($msg_script14); ?>" title="<?php echo mswSpecialChars($msg_script14); ?>" /></a>
  </p> 
  
</div>  

</div>

</body>
</html>