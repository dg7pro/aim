<?php if(!defined('PARENT')) { exit; } 

if (isset($OK)) {
  echo mswActionCompleted($msg_messenger4);
}

?>

<div id="headWrapper">
  
  <div id="message">
   <p><?php echo $msg_messenger; ?></p>
  </div>
  
</div>

<form method="post" action="?p=messenger">
<div class="messageWrapper"> 
  <script type="text/javascript">
  //<![CDATA[
  jQuery(document).ready(function() {
    jQuery('#messagebox').focus();
  });
  //]]>
  </script>
  <div class="messageInner">
    <div class="msgLeft">
     <div>
     <?php
     $q_users = mysql_query("SELECT * FROM ".DB_PREFIX."users WHERE `id` != '{$MSTEAM->id}' AND `notify` = 'yes' ORDER BY `name`") 
                or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
     while ($USER = mysql_fetch_object($q_users)) {
     ?>
     <input type="checkbox" name="user[]" value="<?php echo $USER->id; ?>" checked="checked" /> <?php echo mswSpecialChars($USER->name); ?><br />
     <?php
     }
     echo '<span class="personalise">'.$msg_messenger7.'</span>';
     ?>
     </div>
    </div>
    
    <div class="msgRight">
    <textarea name="message" rows="5" cols="20" id="messagebox" tabindex="<?php echo (++$tabIndex); ?>"></textarea>
    </div>
    
    <br class="clear" />
  
  </div>
  
  <p class="buttonWrapper" style="padding:20px 0 20px 0;text-align:center"> 
    <input type="checkbox" name="copy" value="yes" checked="checked" tabindex="<?php echo (++$tabIndex); ?>" /> <?php echo str_replace('{email}',$MSTEAM->name.' &lt;'.$MSTEAM->email.'&gt;',$msg_messenger3); ?><br /><br />
    <input type="hidden" name="process" value="1" />
    <input tabindex="<?php echo (++$tabIndex); ?>" class="button" type="submit" value="<?php echo mswSpecialChars($msg_messenger2); ?>" title="<?php echo mswSpecialChars($msg_messenger2); ?>" />
  </p> 
    
</div>
</form>