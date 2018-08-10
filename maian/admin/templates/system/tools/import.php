<?php if(!defined('PARENT')) { exit; } 

if (isset($OK)) {
  echo mswActionCompleted(str_replace('{count}',$total,$msg_import13));
}

if (isset($OK2)) {
  echo mswActionCompleted(str_replace('{count}',$total,$msg_import14));
}

?>

<div id="headWrapper">
  
  <div id="message">
   <p><?php echo $msg_import3; ?></p>
  </div>
  
</div>

<div class="contentWrapper"> 
  
  <h2><span class="float"><a class="example" href="templates/examples/response.csv" title="<?php echo mswSpecialChars($msg_import15); ?>"><?php echo $msg_import15; ?></a></span><?php echo $msg_import; ?></h2>
       
  <div class="formWrapper">
  
    <form method="post" action="?p=import" onsubmit="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')" enctype="multipart/form-data">
    <div class="doubleWrapper">
    
     <div class="formLeft" style="width:33%">
       <label><?php echo $msg_import5; ?> <?php echo mswDisplayHelpTip($msg_javascript70,'RIGHT'); ?></label>
       <input class="box" type="file" name="file" tabindex="<?php echo (++$tabIndex); ?>" />
       <br class="clear" />
     </div>
     
     <div class="formLeft" style="width:33%">
       <label><?php echo $msg_tools7; ?> <?php echo mswDisplayHelpTip($msg_javascript73); ?></label>
       <select name="dept" tabindex="<?php echo (++$tabIndex); ?>">
       <?php
       // If global log in no filter necessary..
       if ($MSTEAM->id!='1') {
       ?>  
       <option value="0">- - - - - -</option>
       <?php
       } else {
       ?>
       <option value="0"><?php echo $msg_tools10; ?></option>
       <?php
       }
       $q_dept = mysql_query("SELECT * FROM ".DB_PREFIX."departments ".mswSQLDepartmentFilter($mswDeptFilterAccess,'WHERE')." ORDER BY `name`") 
                 or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
       while ($DEPT = mysql_fetch_object($q_dept)) {
       ?>
       <option value="<?php echo $DEPT->id; ?>"><?php echo mswSpecialChars($DEPT->name); ?></option>
       <?php
       }
       ?>
       </select>
       <br class="clear" />
     </div>
     
     <div class="formLeft" style="width:33%">
       <label><?php echo $msg_import4; ?> <?php echo mswDisplayHelpTip($msg_javascript76,'LEFT'); ?></label>
       <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="clear" value="yes" /> <?php echo $msg_script5; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="clear" value="no" checked="checked" />
       <br class="clear" />
     </div>
     
     <br class="clear" />
    </div> 
    
    <div class="doubleWrapper" style="margin-top:10px">
    
     <div class="formLeft" style="width:33%">
       <label><?php echo $msg_import6; ?> <?php echo mswDisplayHelpTip($msg_javascript75,'RIGHT'); ?></label>
       <input class="box" type="text" name="lines" tabindex="<?php echo (++$tabIndex); ?>" style="width:40%" value="5000" />
       <br class="clear" />
     </div>
     
     <div class="formLeft" style="width:33%">
       <label><?php echo $msg_import7; ?> <?php echo mswDisplayHelpTip($msg_javascript71); ?></label>
       <input class="box" type="text" name="delimiter" tabindex="<?php echo (++$tabIndex); ?>" style="width:10%" value="," />
       <br class="clear" />
     </div>
     
     <div class="formLeft" style="width:33%">
       <label><?php echo $msg_import8; ?> <?php echo mswDisplayHelpTip($msg_javascript72,'LEFT'); ?></label>
       <input class="box" type="text" name="enclosed" tabindex="<?php echo (++$tabIndex); ?>" style="width:10%" value="&quot;" />
       <br class="clear" />
     </div>
     
     <br class="clear" />
     <p class="buttonWrapper" style="padding-top:10px"> 
      <input type="hidden" name="process" value="1" />
      <input class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_import9); ?>" title="<?php echo mswSpecialChars($msg_import9); ?>" />
     </p>
     
     <br class="clear" />
    </div> 
    </form>
    
  </div>  
  
</div>  

<div class="contentWrapper"> 
  
  <h2><span class="float"><a class="example" href="templates/examples/faq.csv" title="<?php echo mswSpecialChars($msg_import15); ?>"><?php echo mswSpecialChars($msg_import15); ?></a></span><?php echo mswSpecialChars($msg_import2); ?></h2>
       
  <div class="formWrapper">
  
    <form method="post" action="?p=import" onsubmit="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')" enctype="multipart/form-data">
    <div class="doubleWrapper">
    
     <div class="formLeft" style="width:33%">
       <label><?php echo $msg_import5; ?> <?php echo mswDisplayHelpTip($msg_javascript70,'RIGHT'); ?></label>
       <input class="box" type="file" name="file" tabindex="<?php echo (++$tabIndex); ?>" />
       <br class="clear" />
     </div>
     
     <div class="formLeft" style="width:33%">
       <label><?php echo $msg_import10; ?> <?php echo mswDisplayHelpTip($msg_javascript74); ?></label>
       <select name="cat" tabindex="<?php echo (++$tabIndex); ?>">
       <option value="0"><?php echo $msg_import12; ?></option>
       <?php
       $q_cat = mysql_query("SELECT * FROM ".DB_PREFIX."categories WHERE `subcat` = '0' ORDER BY `name`") 
                or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
       while ($CAT = mysql_fetch_object($q_cat)) {
       ?>
       <option value="<?php echo $CAT->id; ?>"><?php echo mswSpecialChars($CAT->name); ?></option>
       <?php
       $q_cat2 = mysql_query("SELECT * FROM ".DB_PREFIX."categories WHERE `subcat` = '{$CAT->id}' ORDER BY `name`") 
                 or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
       while ($SUB = mysql_fetch_object($q_cat2)) {
       ?>
       <option value="<?php echo $SUB->id; ?>">- <?php echo mswCleanData($SUB->name); ?></option>
       <?php
       }
       }
       ?>
       </select>
       <br class="clear" />
     </div>
     
     <div class="formLeft" style="width:33%">
       <label><?php echo $msg_import4; ?> <?php echo mswDisplayHelpTip($msg_javascript77,'LEFT'); ?></label>
       <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="clear" value="yes" /> <?php echo $msg_script5; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="clear" value="no" checked="checked" />
       <br class="clear" />
     </div>
     
     <br class="clear" />
    </div> 
    
    <div class="doubleWrapper" style="margin-top:10px">
    
     <div class="formLeft" style="width:33%">
       <label><?php echo $msg_import6; ?> <?php echo mswDisplayHelpTip($msg_javascript75,'RIGHT'); ?></label>
       <input class="box" type="text" name="lines" tabindex="<?php echo (++$tabIndex); ?>" style="width:40%" value="5000" />
       <br class="clear" />
     </div>
     
     <div class="formLeft" style="width:33%">
       <label><?php echo $msg_import7; ?> <?php echo mswDisplayHelpTip($msg_javascript71); ?></label>
       <input class="box" type="text" name="delimiter" tabindex="<?php echo (++$tabIndex); ?>" style="width:10%" value="," />
       <br class="clear" />
     </div>
     
     <div class="formLeft" style="width:33%">
       <label><?php echo $msg_import8; ?> <?php echo mswDisplayHelpTip($msg_javascript72,'LEFT'); ?></label>
       <input class="box" type="text" name="enclosed" tabindex="<?php echo (++$tabIndex); ?>" style="width:10%" value="&quot;" />
       <br class="clear" />
     </div>
     
     <br class="clear" />
     <p class="buttonWrapper" style="padding-top:10px"> 
      <input type="hidden" name="process2" value="1" />
      <input class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_import11); ?>" title="<?php echo mswSpecialChars($msg_import11); ?>" />
     </p>
     
     <br class="clear" />
    </div> 
    </form>
  
  </div>
  
</div>