<?php if(!defined('PARENT')) { exit; } 

if (isset($OK)) {
  echo mswActionCompleted($msg_systemportal11);
}
if (isset($OK2)) {
  echo mswActionCompleted(str_replace('{count}',$moved,$msg_systemportal13));
}
if (isset($OK3)) {
  echo mswActionCompleted($msg_systemportal22);
}
if (isset($OK4) && $cnt>0) {
  echo mswActionCompleted($msg_systemportal24);
}

?>

<div id="headWrapper">

  <div id="message">
   <p><?php echo $msg_systemportal4; ?></p>
  </div>
  
</div>

<div class="contentWrapper"> 
  
  <h2><?php echo $msg_systemportal3; ?></h2>
       
  <div class="formWrapper">
  
    <form method="post" action="?p=portal" onsubmit="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')">
    <div class="doubleWrapper">
    
     <div class="formLeft" style="width:33%">
       <label><?php echo $msg_systemportal; ?> <?php echo mswDisplayHelpTip($msg_javascript49,'RIGHT'); ?></label>
       <input class="box" type="text" tabindex="<?php echo (++$tabIndex); ?>" name="email" onkeyup="ms_autoComplete('e1')" id="e1" value="<?php echo (isset($_POST['email']) ? mswSpecialChars($_POST['email']) : ''); ?>" />
       <?php echo (in_array('email',$eString) && isset($_POST['process']) ? '<span class="error">'.$msg_systemportal12.'</span>' : ''); ?>
       <br class="clear" />
     </div>
     
     <div class="formLeft" style="width:39%">
       <label><?php echo $msg_user12; ?> <?php echo mswDisplayHelpTip($msg_javascript50); ?></label>
       <span class="pass" id="pass"><input class="box" type="password" tabindex="<?php echo (++$tabIndex); ?>" name="accpass" id="accpass" value="<?php echo (isset($_POST['accpass']) ? mswSpecialChars($_POST['accpass']) : ''); ?>" /></span>
       <span class="passOptions" id="passOptions" style="display:none;width:90%">
       <?php echo $msg_user47; ?> <input type="checkbox" id="letters" name="letters" value="yes" checked="checked" />
       <?php echo $msg_user52; ?> <input type="checkbox" id="letters2" name="letters2" value="yes" checked="checked" />
       <?php echo $msg_user48; ?> <input type="checkbox" id="numbers" name="numbers" value="yes" checked="checked" />
       <?php echo $msg_user49; ?> <input type="checkbox" id="special" name="special" value="yes" checked="checked" />
       <select id="chars" name="chars" style="margin-left:10px">
       <?php
       foreach (range(6,20) AS $char) {
       ?>
       <option value="<?php echo $char; ?>"<?php echo (USER_AUTO_PASS_CHAR_DEFAULT==$char ? ' selected="selected"' : ''); ?>><?php echo $char; ?></option>
       <?php
       }
       ?>
       </select>
       <input class="buttonpass" type="button" onclick="mswgenerateAutoPass()" value="<?php echo mswSpecialChars($msg_user50); ?>" title="<?php echo mswSpecialChars($msg_user50); ?>" />
       </span>
     </div>
     
     <div class="formLeft" style="width:17%">
       <label><?php echo $msg_systemportal5; ?> <?php echo mswDisplayHelpTip($msg_javascript51,'LEFT'); ?></label>
       <input type="checkbox" name="mail" tabindex="<?php echo (++$tabIndex); ?>" value="yes"<?php echo (isset($_POST['mail']) ? ' selected="selected"' : ''); ?> />
       <br class="clear" />
     </div>
     
     <div class="formRight" style="width:10%;text-align:right">
       <input type="hidden" name="process" value="1" />
       <input class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_systemportal9); ?>" title="<?php echo mswSpecialChars($msg_systemportal9); ?>" />
     </div>
    
     <br class="clear" />
    </div> 
    </form>
    
  </div>
  
</div>  

<div class="contentWrapper"> 
  
  <h2><?php echo $msg_systemportal6; ?></h2>
       
  <div class="formWrapper">
  
    <form method="post" action="?p=portal" onsubmit="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')">
    <div class="doubleWrapper">
    
     <div class="formLeft" style="width:33%">
       <label><?php echo $msg_systemportal7; ?> <?php echo mswDisplayHelpTip($msg_javascript52,'RIGHT'); ?></label>
       <input class="box" tabindex="<?php echo (++$tabIndex); ?>" type="text" name="email" onkeyup="ms_autoComplete('e2')" id="e2" value="<?php echo (isset($_POST['email']) ? mswSpecialChars($_POST['email']) : ''); ?>" />
       <?php echo (in_array('email',$eString) && isset($_POST['process2']) ? '<span class="error">'.$msg_systemportal12.'</span>' : ''); ?>
       <br class="clear" />
     </div>
     
     <div class="formLeft" style="width:39%">
       <label><?php echo $msg_systemportal8; ?> <?php echo mswDisplayHelpTip($msg_javascript53); ?></label>
       <input class="box" tabindex="<?php echo (++$tabIndex); ?>" type="text" name="email2" id="e3" onkeyup="ms_autoComplete('e3')" value="<?php echo (isset($_POST['email2']) ? mswSpecialChars($_POST['email2']) : ''); ?>" />
       <?php echo (in_array('email2',$eString) ? '<span class="error">'.$msg_systemportal12.'</span>' : ''); ?>
       <br class="clear" />
     </div>
     
     <div class="formLeft" style="width:17%">
       <label><?php echo $msg_systemportal5; ?> <?php echo mswDisplayHelpTip($msg_javascript51,'LEFT'); ?></label>
       <input type="checkbox" tabindex="<?php echo (++$tabIndex); ?>" name="mail" value="yes"<?php echo (isset($_POST['mail']) ? ' selected="selected"' : ''); ?> />
       <br class="clear" />
     </div>
     
     <div class="formRight" style="width:10%;text-align:right">
       <input type="hidden" name="process2" value="1" />
       <input class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_systemportal10); ?>" title="<?php echo mswSpecialChars($msg_systemportal10); ?>" />
     </div>
    
     <br class="clear" />
    </div>
    </form> 
  
  </div>
  
</div>

<div class="contentWrapper"> 
  
  <h2><?php echo $msg_systemportal15; ?></h2>
       
  <div class="formWrapper">
  
    <form method="post" action="?p=portal">
    <div class="doubleWrapper">
    
     <div class="formLeft" style="width:33%">
       <label><?php echo $msg_systemportal16; ?> <?php echo mswDisplayHelpTip($msg_javascript100,'RIGHT'); ?></label>
       <input type="checkbox" tabindex="<?php echo (++$tabIndex); ?>" name="name" value="yes" />
       <br class="clear" />
     </div>
     
     <div class="formLeft" style="width:33%">
       <label><?php echo $msg_systemportal17; ?> <?php echo mswDisplayHelpTip($msg_javascript101); ?></label>
       <input type="checkbox" tabindex="<?php echo (++$tabIndex); ?>" name="email" value="yes" />
       <br class="clear" />
     </div>
     
     <div class="formRight" style="width:10%;text-align:right">
       <input type="hidden" name="process3" value="1" />
       <input class="button" tabindex="<?php echo (++$tabIndex); ?>" type="submit" value="<?php echo mswSpecialChars($msg_systemportal18); ?>" title="<?php echo mswSpecialChars($msg_systemportal18); ?>" />
     </div>
    
     <br class="clear" />
    </div>
    </form> 
  
  </div>
  
</div>

<div class="contentWrapper"> 
  
  <h2><?php echo $msg_systemportal19; ?></h2>
       
  <div class="formWrapper">
  
    <form method="post" action="?p=portal" onsubmit="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')">
    <div class="doubleWrapper">
    
     <div class="formLeft" style="width:66%">
       <label><?php echo $msg_systemportal21; ?> <?php echo mswDisplayHelpTip($msg_javascript124,'RIGHT'); ?></label>
       <input class="box" tabindex="<?php echo (++$tabIndex); ?>" type="text" name="email" id="e4" onkeyup="ms_autoComplete('e4')" value="<?php echo (isset($_POST['email']) ? mswSpecialChars($_POST['email']) : ''); ?>" />
       <?php echo (in_array('email',$eString) && isset($_POST['process4']) ? '<span class="error">'.$msg_systemportal12.'</span>' : ''); ?>
       <br class="clear" />
     </div>
     
     <div class="formRight" style="width:10%;text-align:right">
       <input type="hidden" name="process4" value="1" />
       <input class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_systemportal20); ?>" title="<?php echo mswSpecialChars($msg_systemportal20); ?>" />
     </div>
    
     <br class="clear" />
    </div>
    </form> 
  
  </div>
  
  <div class="blocked">
   <?php
   $query = mysql_query("SELECT * FROM ".DB_PREFIX."portal WHERE `enabled` = 'no' ORDER BY `email`")
            or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
   if (mysql_num_rows($query)>0) {
     while ($E = mysql_fetch_object($query)) {
     ?>
     <p class="blocks"><?php echo $E->email; ?> (<a onclick="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')" href="?p=portal&amp;enable=<?php echo $E->email; ?>" title="<?php echo mswSpecialChars($msg_systemportal23); ?>"><?php echo $msg_systemportal23; ?></a>)</p>
     <?php
     }
   } else {
   ?>
   <p class="no_blocks"><?php echo $msg_systemportal25; ?></p>
   <?php
   }
   ?>
  </div>
  
</div>
