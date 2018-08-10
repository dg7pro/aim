<?php if(!defined('PARENT')) { exit; } 

if (isset($OK)) {
  echo mswActionCompleted($msg_backup15);
}
$totalBackup = 0;
?>

<div id="headWrapper">
  
  <div id="message">
   <p><?php echo $msg_backup; ?></p>
  </div>
  
</div>

<form method="post" action="?p=backup" id="form" onsubmit="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')">
<div class="contentWrapper"> 

  <h2><?php echo $msg_backup2; ?></h2>
  
  <div class="mysqlSchema">

  <div class="infoRow">
  
   <span style="width:235px"><?php echo $msg_backup3; ?></span>
   <span style="width:75px"><?php echo $msg_backup4; ?></span>
   <span style="width:85px"><?php echo $msg_backup5; ?></span>
   <span style="width:180px"><?php echo $msg_backup6; ?></span>
   <span style="width:180px"><?php echo $msg_backup7; ?></span>
   <span style="width:85px"><?php echo $msg_backup8; ?></span>
   
   <br class="clear" />
  </div>
  
  <div class="schema">
  <?php
  $query = mysql_query("SHOW TABLE STATUS FROM ".DB_NAME);
  while ($DB = mysql_fetch_object($query)) {
   $SCHEMA = (array)$DB;
   if (in_array($SCHEMA['Name'],mswDBSchemaArray())) {
   $size   = ($SCHEMA['Rows']>0 ? $SCHEMA['Data_length']+$SCHEMA['Index_length'] : '0');
   $ctTS   = strtotime($SCHEMA['Create_time']);
   $utTS   = strtotime($SCHEMA['Update_time']);
   ?>
   <div class="infoRowSchema">
    <span style="width:235px"><?php echo $SCHEMA['Name']; ?></span>
    <span style="width:75px"><?php echo $SCHEMA['Rows']; ?></span>
    <span style="width:85px"><?php echo ($SCHEMA['Rows']>0 ? mswFileSizeConversion($size) : '0'); ?></span>
    <span style="width:180px"><?php echo date($SETTINGS->dateformat,$ctTS); ?></span>
    <span style="width:180px"><?php echo date($SETTINGS->dateformat,$utTS); ?></span>
    <span style="width:85px"><?php echo $SCHEMA['Engine']; ?></span>
    <br class="clear" />
   </div>
   <?php
   $totalBackup = ($totalBackup+$size);
   }
  }
  $tabIndex = 0;
  ?>
  </div>
  
  </div>
  
</div> 

<div class="contentWrapper"> 

  <h2><span class="float"><?php echo $msg_backup10; ?>: <b><?php echo mswFileSizeConversion($totalBackup); ?></b></span><?php echo mswSpecialChars($msg_backup9); ?>:</h2>
  
  <div class="formWrapper">
  
    <div class="doubleWrapper">
    
     <div class="formLeft" style="width:30%">
      <label><?php echo $msg_backup11; ?>: <?php echo mswDisplayHelpTip($msg_javascript134,'RIGHT'); ?></label>
      <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo ++$tabIndex; ?>" name="download" value="yes" checked="checked" /> <?php echo $msg_script5; ?> <input tabindex="<?php echo ++$tabIndex; ?>" type="radio" name="download" value="no" />
      <br class="clear" />
     </div>
     
     <div class="formLeft" style="width:30%">
      <label><?php echo $msg_backup13; ?>: <?php echo mswDisplayHelpTip($msg_javascript135); ?></label>
      <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo ++$tabIndex; ?>" name="compress" value="yes" checked="checked"/> <?php echo $msg_script5; ?> <input tabindex="<?php echo ++$tabIndex; ?>" type="radio" name="compress" value="no" />
      <br class="clear" />
     </div>
     
     <div class="formRight" style="width:39%">  
      <label><?php echo $msg_backup12; ?>: <?php echo mswDisplayHelpTip($msg_javascript136,'LEFT'); ?></label>
      <input type="text" tabindex="<?php echo ++$tabIndex; ?>" name="emails" class="box" value="" />
      <br class="clear" />
     </div>
     
     <br class="clear" />
    </div>
    
    <p class="buttonWrapper" style="padding-top:10px"> 
     <input type="hidden" name="process" value="yes" />
     <input tabindex="<?php echo (++$tabIndex); ?>" class="button" type="submit" value="<?php echo mswSpecialChars($msg_backup14); ?>" title="<?php echo mswSpecialChars($msg_backup14); ?>" />
    </p>
  
  </div>
  
</div>  
 
</form>