<?php if(!defined('PARENT')) { exit; } 
if (isset($OK)) {
  echo mswActionCompleted(str_replace(array('{count}','{count2}','{count3}'),
                                   array(number_format($counts[0]),number_format($counts[1]),number_format($counts[2])),
                                   $msg_tools8)
                       );
}

if (isset($OK2)) {
  echo mswActionCompleted(str_replace('{count}',number_format($count),$msg_tools9));
}

if (USER_DEL_PRIV=='yes') {
?>

<div id="headWrapper">
  
  <div id="message">
   <p><?php echo $msg_tools; ?></p>
  </div>
  
</div>

<div class="contentWrapper"> 
  
  <h2><?php echo $msg_tools2; ?></h2>
       
  <div class="formWrapper">
  
    <form method="post" action="?p=tools" id="form" onsubmit="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')">
    <div class="doubleWrapper">
    
     <div class="formLeft" style="width:33%">
       <label><?php echo $msg_tools3; ?> <?php echo mswDisplayHelpTip($msg_javascript37,'RIGHT'); ?></label>
       <input class="smallbox" type="text" name="days" tabindex="<?php echo (++$tabIndex); ?>" />
       <br class="clear" />
     </div>
     
     <div class="formLeft" style="width:39%">
       <label><?php echo $msg_tools7; ?> <?php echo mswDisplayHelpTip($msg_javascript38); ?></label>
       <div class="overflow">
       <input type="checkbox" name="log" value="all" onclick="selectAll('form')" tabindex="<?php echo (++$tabIndex); ?>" /> <b><?php echo $msg_tools10; ?></b><br />
       <?php
       $q_dept = mysql_query("SELECT * FROM ".DB_PREFIX."departments ".mswSQLDepartmentFilter($mswDeptFilterAccess,'WHERE')." ORDER BY `name`") 
                 or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
       while ($DEPT = mysql_fetch_object($q_dept)) {
       ?>
       <input type="checkbox" name="dept[]" value="<?php echo $DEPT->id; ?>" tabindex="<?php echo (++$tabIndex); ?>" /> <?php echo mswSpecialChars($DEPT->name); ?><br />
       <?php
       }
       ?>
       </div>
       <br class="clear" />
     </div>
     
     <div class="formLeft" style="width:17%">
       <label><?php echo $msg_tools5; ?> <?php echo mswDisplayHelpTip($msg_javascript39,'LEFT'); ?></label>
       <input type="checkbox" name="clear" value="yes" tabindex="<?php echo (++$tabIndex); ?>" />
       <br class="clear" />
     </div>
     
     <div class="formRight" style="width:10%;text-align:right">
       <input type="hidden" name="process" value="1" />
       <input class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_tools4); ?>" title="<?php echo mswSpecialChars($msg_tools4); ?>" />
     </div>
    
     <br class="clear" />
    </div> 
    </form>
    
  </div>
  
</div>  

<div class="contentWrapper"> 
  
  <h2><?php echo $msg_tools6; ?></h2>
       
  <div class="formWrapper">
  
    <form method="post" action="?p=tools" id="form2" onsubmit="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')">
    <div class="doubleWrapper">
    
     <div class="formLeft" style="width:33%">
       <label><?php echo $msg_tools3; ?> <?php echo mswDisplayHelpTip($msg_javascript40,'RIGHT'); ?></label>
       <input class="smallbox" type="text" name="days" tabindex="<?php echo (++$tabIndex); ?>" />
       <br class="clear" />
     </div>
     
     <div class="formLeft" style="width:55%">
       <label><?php echo $msg_tools7; ?> <?php echo mswDisplayHelpTip($msg_javascript41); ?></label>
       <div class="overflow">
       <input type="checkbox" name="log" value="all" onclick="selectAll('form2')" tabindex="<?php echo (++$tabIndex); ?>" /> <b><?php echo $msg_tools10; ?></b><br />
       <?php
       $q_dept = mysql_query("SELECT * FROM ".DB_PREFIX."departments ".mswSQLDepartmentFilter($mswDeptFilterAccess,'WHERE')." ORDER BY `name`") 
                 or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
       while ($DEPT = mysql_fetch_object($q_dept)) {
       ?>
       <input type="checkbox" name="dept[]" value="<?php echo $DEPT->id; ?>" tabindex="<?php echo (++$tabIndex); ?>" /> <?php echo mswSpecialChars($DEPT->name); ?><br />
       <?php
       }
       ?>
       </div>
       <br class="clear" />
     </div>
     
     <div class="formRight" style="width:10%;text-align:right">
       <input type="hidden" name="process2" value="1" />
       <input class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_tools4); ?>" title="<?php echo mswSpecialChars($msg_tools4); ?>" />
     </div>
    
     <br class="clear" />
    </div>
    </form> 
  
  </div>
  
</div>
<?php
} else {
?>
<div id="headWrapper">
  
  <div id="message">
   <p><?php echo $msg_tools11; ?></p>
  </div>
  
</div>
<?php
}
?>