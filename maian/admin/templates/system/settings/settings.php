<?php if(!defined('PARENT')) { exit; } 

if (isset($OK)) {
  echo mswActionCompleted($msg_settings8);
}

?>

<div id="headWrapper">
  
  <div id="message">
   <p><?php echo $msg_settings10; ?></p>
  </div>
  
</div>

<form method="post" action="index.php?p=settings">
<script type="text/javascript"> 
//<![CDATA[
gCalculator = new Calculator();
//]]>  
</script>
<div class="contentWrapper"> 
  <script type="text/javascript">
  //<![CDATA[
  <?php
  include(PATH.'templates/date-pickers.php');
  ?>
  //]]>
  </script>
  <h2><?php echo $msg_settings22; ?></h2>
       
  <div class="formWrapper"> 
  
    <div class="doubleWrapper">
     <div class="formLeft">
      <label><?php echo $msg_settings9; ?> <?php echo mswDisplayHelpTip($msg_javascript5,'RIGHT'); ?></label>
      <input type="text" class="box" maxlength="150" name="website" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($SETTINGS->website); ?>" />
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <label><?php echo $msg_settings21; ?> <?php echo mswDisplayHelpTip($msg_javascript6,'LEFT'); ?></label>
      <input type="text" class="box" maxlength="250" name="email" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($SETTINGS->email); ?>" />
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
    <div class="doubleWrapper" style="margin-top:10px">
     <div class="formLeft">
      <label><?php echo $msg_settings20; ?> <?php echo mswDisplayHelpTip($msg_javascript7,'RIGHT'); ?></label>
      <input type="text" class="box" maxlength="250" name="scriptpath" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo $SETTINGS->scriptpath; ?>" />
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <label><?php echo $msg_settings6; ?> <?php echo mswDisplayHelpTip($msg_javascript8,'LEFT'); ?></label>
      <select name="language" tabindex="<?php echo (++$tabIndex); ?>">
      <?php
      $showlang = opendir(REL_PATH.'templates/language');
      while (false!==($read=readdir($showlang))) {
        if (is_dir(REL_PATH.'templates/language/'.$read) && !in_array($read,array('.','..'))) {
        ?>
        <option<?php echo ($read==$SETTINGS->language ? ' selected="selected"' : ''); ?>><?php echo $read; ?></option>
        <?php
        }
      }
      closedir($showlang);
      ?>
      </select>
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
    <div class="doubleWrapper" style="margin-top:10px">
     <div class="formLeft">
      <label><a href="http://php.net/manual/en/function.date.php" onclick="window.open(this);return false" title="<?php echo mswSpecialChars($msg_settings2); ?>"><?php echo $msg_settings2; ?></a> <?php echo mswDisplayHelpTip($msg_javascript9,'RIGHT'); ?></label>
      <input type="text" class="box" name="dateformat" maxlength="20" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo $SETTINGS->dateformat; ?>" style="width:20%" /> /
      <input type="text" class="box" name="timeformat" maxlength="15" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo $SETTINGS->timeformat; ?>" style="width:20%" />
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <label><?php echo $msg_settings12; ?> <?php echo mswDisplayHelpTip($msg_javascript14,'LEFT'); ?></label>
      <select name="timezone" tabindex="<?php echo (++$tabIndex); ?>">
      <?php
      // TIMEZONES..
      foreach ($timezones AS $k => $v) {
      ?>
      <option value="<?php echo $k; ?>"<?php echo ($SETTINGS->timezone==$k ? ' selected="selected"' : ''); ?>><?php echo $v; ?></option>
      <?php
      }
      ?>
      </select>
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
    <div class="doubleWrapper" style="margin-top:10px">
     <div class="formLeft">
      <label><?php echo $msg_settings13; ?> <?php echo mswDisplayHelpTip($msg_javascript13,'RIGHT'); ?></label>
      <input type="text" class="smallbox" name="autoClose" maxlength="5" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo $SETTINGS->autoClose; ?>" />
      &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $msg_settings75; ?> <input type="checkbox" name="autoCloseMail" value="yes"<?php echo ($SETTINGS->autoCloseMail=='yes' ? ' checked="checked"' : ''); ?> />
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <label><?php echo $msg_settings58; ?> <?php echo mswDisplayHelpTip($msg_javascript57,'LEFT'); ?></label>
      <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="enableBBCode" value="yes"<?php echo ($SETTINGS->enableBBCode=='yes' ? ' checked="checked"' : ''); ?> /> <?php echo $msg_script5; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="enableBBCode" value="no"<?php echo ($SETTINGS->enableBBCode=='no' ? ' checked="checked"' : ''); ?> />
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
     
    <div class="doubleWrapper" style="margin-top:10px">
     <div class="formLeft">
      <label><?php echo $msg_settings31; ?> <?php echo mswDisplayHelpTip($msg_javascript65,'RIGHT'); ?></label>
      <input type="text" class="smallbox" maxlength="5" name="portalpages" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo $SETTINGS->portalpages; ?>" />
      <br class="clear" />
     </div>
     <div class="formRight">
      <label><?php echo $msg_settings59; ?> <?php echo mswDisplayHelpTip($msg_javascript118,'LEFT'); ?></label>
      <input type="text" class="box" maxlength="100" id="apiKey" name="apiKey" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo $SETTINGS->apiKey; ?>" />
      <br class="clear" />
     </div> 
     <br class="clear" />
    </div>
    
    <div class="doubleWrapper" style="margin-top:10px">
     <div class="formLeft">
      <label><?php echo $msg_settings64; ?> <?php echo mswDisplayHelpTip($msg_javascript123,'RIGHT'); ?></label>
      <?php echo $msg_settings65; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="weekStart" value="sun"<?php echo ($SETTINGS->weekStart=='sun' ? ' checked="checked"' : ''); ?> /> <?php echo $msg_settings66; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="weekStart" value="mon"<?php echo ($SETTINGS->weekStart=='mon' ? ' checked="checked"' : ''); ?> />
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <label><?php echo $msg_settings69; ?>: <?php echo mswDisplayHelpTip($msg_javascript144,'LEFT'); ?></label>
      <select name="jsDateFormat" tabindex="<?php echo ++$tabIndex; ?>">
      <?php
      foreach (array('DD-MM-YYYY','DD/MM/YYYY','YYYY-MM-DD','YYYY/MM/DD','MM-DD-YYYY','MM/DD/YYYY') AS $jsf) {
      ?>
      <option value="<?php echo $jsf; ?>"<?php echo ($SETTINGS->jsDateFormat==$jsf ? ' selected="selected"' : ''); ?>><?php echo $jsf; ?></option>
      <?php
      }
      ?>
      </select>
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
    <div class="doubleWrapper">
     <div class="formLeft">
      <label><?php echo $msg_settings30; ?> <?php echo mswDisplayHelpTip($msg_javascript64,'RIGHT'); ?></label>
      <input type="text" class="box" maxlength="50" tabindex="<?php echo (++$tabIndex); ?>" name="afolder" value="<?php echo $SETTINGS->afolder; ?>" />
      <br class="clear" />
     </div>
    
     <div class="formRight">
     </div>
     <br class="clear" />
    </div>
    
  </div>
  
</div>

<div class="contentWrapper"> 
  
  <h2><?php echo $msg_settings70; ?></h2>
       
  <div class="formWrapper"> 
  
    <div class="doubleWrapper">
     <div class="formLeft">
      <label><?php echo $msg_settings74; ?> <?php echo mswDisplayHelpTip($msg_javascript164,'RIGHT'); ?></label>
      <?php echo $msg_settings71; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="sysstatus" value="yes"<?php echo ($SETTINGS->sysstatus=='yes' ? ' checked="checked"' : ''); ?> /> <?php echo $msg_settings72; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="sysstatus" value="no"<?php echo ($SETTINGS->sysstatus=='no' ? ' checked="checked"' : ''); ?> />
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <label><?php echo $msg_settings73; ?> <?php echo mswDisplayHelpTip($msg_javascript165,'LEFT'); ?></label>
      <input type="text" class="smallbox" maxlength="5" tabindex="<?php echo (++$tabIndex); ?>" id="from" name="autoenable" value="<?php echo ($SETTINGS->autoenable!='0000-00-00' ? mswConvertMySQLDate($SETTINGS->autoenable) : ''); ?>" />
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
  </div>
  
</div> 

<div class="contentWrapper"> 
  
  <h2><span class="float"><a href="https://www.google.com/recaptcha/admin/create?domains=<?php echo $_SERVER['HTTP_HOST']; ?>&amp;app=<?php echo $msg_script; ?>" title="<?php echo mswSpecialChars($msg_settings63); ?>" class="recapkeys" onclick="window.open(this);return false"><?php echo $msg_settings63; ?></a></span><?php echo $msg_settings62; ?></h2>
       
  <div class="formWrapper"> 
  
    <div class="doubleWrapper">
     <div class="formLeft">
      <label><?php echo $msg_settings60; ?> <?php echo mswDisplayHelpTip($msg_javascript120,'RIGHT'); ?></label>
      <input type="text" class="box" maxlength="250" name="recaptchaPublicKey" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($SETTINGS->recaptchaPublicKey); ?>" /><br /><br />
      
      <label><?php echo $msg_settings67; ?> <?php echo mswDisplayHelpTip($msg_javascript139,'RIGHT'); ?></label>
      <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="enCapLogin" value="yes"<?php echo ($SETTINGS->enCapLogin=='yes' ? ' checked="checked"' : ''); ?> /> <?php echo $msg_script5; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="enCapLogin" value="no"<?php echo ($SETTINGS->enCapLogin=='no' ? ' checked="checked"' : ''); ?> />
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <label><?php echo $msg_settings61; ?> <?php echo mswDisplayHelpTip($msg_javascript119,'LEFT'); ?></label>
      <input type="text" class="box" maxlength="250" name="recaptchaPrivateKey" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($SETTINGS->recaptchaPrivateKey); ?>" />
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
  </div>
  
</div>

<div class="contentWrapper"> 
  
  <h2><?php echo $msg_settings23; ?></h2>
       
  <div class="formWrapper"> 
  
    <div class="doubleWrapper">
     <div class="formLeft">
      <label><?php echo $msg_settings3; ?> <?php echo mswDisplayHelpTip($msg_javascript15,'RIGHT'); ?></label>
      <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="attachment" value="yes"<?php echo ($SETTINGS->attachment=='yes' ? ' checked="checked"' : ''); ?> /> <?php echo $msg_script5; ?> <input type="radio" name="attachment" value="no"<?php echo ($SETTINGS->attachment=='no' ? ' checked="checked"' : ''); ?> />
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <label><?php echo $msg_settings4; ?> <?php echo mswDisplayHelpTip($msg_javascript16,'LEFT'); ?></label>
      <input type="text" class="box" name="filetypes" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo $SETTINGS->filetypes; ?>" />
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
    <div class="doubleWrapper" style="margin-top:10px">
     <div class="formLeft">
      <label><?php echo $msg_settings5; ?> <?php echo mswDisplayHelpTip($msg_javascript17,'RIGHT'); ?></label>
      <?php echo mswBuildCalculator('maxsize'); ?>
      <input type="text" class="box" id="maxsize" tabindex="<?php echo (++$tabIndex); ?>" name="maxsize" value="<?php echo $SETTINGS->maxsize; ?>" /> <img style="cursor:pointer" onclick="document.getElementById('maxsize').value = '';toggle_box('calendar');return false" src="templates/images/calculator.gif" title="<?php echo mswSpecialChars($msg_settings36); ?>" alt="<?php echo mswSpecialChars($msg_settings36); ?>" />
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <label><?php echo $msg_settings25; ?> <?php echo mswDisplayHelpTip($msg_javascript18,'LEFT'); ?></label>
      <input type="text" class="smallbox" maxlength="3" name="attachboxes" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo $SETTINGS->attachboxes; ?>" />
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
    <div class="doubleWrapper" style="margin-top:10px">
     <div class="formLeft">
      <label><?php echo $msg_settings27; ?> <?php echo mswDisplayHelpTip($msg_javascript54,'RIGHT'); ?></label>
      <input type="text" class="box" name="attachpath" maxlength="250" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo $SETTINGS->attachpath; ?>" />
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <label><?php echo $msg_settings76; ?> <?php echo mswDisplayHelpTip($msg_javascript168,'LEFT'); ?></label>
      <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="rename" value="yes"<?php echo ($SETTINGS->rename=='yes' ? ' checked="checked"' : ''); ?> /> <?php echo $msg_script5; ?> <input type="radio" name="rename" value="no"<?php echo ($SETTINGS->rename=='no' ? ' checked="checked"' : ''); ?> />
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
  </div>
  
</div> 

<div class="contentWrapper"> 
  
  <h2><?php echo $msg_settings29; ?></h2>
       
  <div class="formWrapper"> 
  
    <div class="doubleWrapper">
     <div class="formLeft">
      <label><?php echo $msg_settings; ?> <?php echo mswDisplayHelpTip($msg_javascript11,'RIGHT'); ?></label>
      <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="kbase" value="yes"<?php echo ($SETTINGS->kbase=='yes' ? ' checked="checked"' : ''); ?> /> <?php echo $msg_script5; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="kbase" value="no"<?php echo ($SETTINGS->kbase=='no' ? ' checked="checked"' : ''); ?> />
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <label><?php echo $msg_settings33; ?> <?php echo mswDisplayHelpTip($msg_javascript66,'LEFT'); ?></label>
      <input type="text" class="smallbox" maxlength="5" tabindex="<?php echo (++$tabIndex); ?>" name="popquestions" value="<?php echo $SETTINGS->popquestions; ?>" />
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
    <div class="doubleWrapper" style="margin-top:10px">
     <div class="formLeft">
      <label><?php echo $msg_settings57; ?> <?php echo mswDisplayHelpTip($msg_javascript99,'RIGHT'); ?></label>
      <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="enableVotes" value="yes"<?php echo ($SETTINGS->enableVotes=='yes' ? ' checked="checked"' : ''); ?> /> <?php echo $msg_script5; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="enableVotes" value="no"<?php echo ($SETTINGS->enableVotes=='no' ? ' checked="checked"' : ''); ?> />
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <label><?php echo $msg_settings34; ?> <?php echo mswDisplayHelpTip($msg_javascript68,'LEFT'); ?></label>
      <input type="text" class="smallbox" maxlength="5" tabindex="<?php echo (++$tabIndex); ?>" name="cookiedays" value="<?php echo $SETTINGS->cookiedays; ?>" />
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
    <div class="doubleWrapper" style="margin-top:10px">
     <div class="formLeft">
      <label><?php echo $msg_settings32; ?> <?php echo mswDisplayHelpTip($msg_javascript67,'RIGHT'); ?></label>
      <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="multiplevotes" value="yes"<?php echo ($SETTINGS->multiplevotes=='yes' ? ' checked="checked"' : ''); ?> /> <?php echo $msg_script5; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="multiplevotes" value="no"<?php echo ($SETTINGS->multiplevotes=='no' ? ' checked="checked"' : ''); ?> />
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <label><?php echo $msg_settings68; ?> <?php echo mswDisplayHelpTip($msg_javascript141,'LEFT'); ?></label>
      <input type="text" class="smallbox" maxlength="3" tabindex="<?php echo (++$tabIndex); ?>" name="quePerPage" value="<?php echo $SETTINGS->quePerPage; ?>" />
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
  
  </div>
  
</div> 

<div class="contentWrapper"> 
  
  <h2><?php echo $msg_settings24; ?></h2>
       
  <div class="formWrapper"> 
  
    <div class="doubleWrapper">
     <div class="formLeft">
      <label><?php echo $msg_settings15; ?> <?php echo mswDisplayHelpTip($msg_javascript19,'RIGHT'); ?></label>
      <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="smtp" value="yes"<?php echo ($SETTINGS->smtp=='yes' ? ' checked="checked"' : ''); ?> /> <?php echo $msg_script5; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="smtp" value="no"<?php echo ($SETTINGS->smtp=='no' ? ' checked="checked"' : ''); ?> />
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <label><?php echo $msg_settings16; ?> <?php echo mswDisplayHelpTip($msg_javascript20,'LEFT'); ?></label>
      <input type="text" class="box" name="smtp_host" maxlength="100" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo $SETTINGS->smtp_host; ?>" />
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
    <div class="doubleWrapper" style="margin-top:10px">
     <div class="formLeft">
      <label><?php echo $msg_settings17; ?> <?php echo mswDisplayHelpTip($msg_javascript21,'RIGHT'); ?></label>
      <input type="text" class="box" name="smtp_user" maxlength="100" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo $SETTINGS->smtp_user; ?>" />
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <label><?php echo $msg_settings18; ?> <?php echo mswDisplayHelpTip($msg_javascript22,'LEFT'); ?></label>
      <input type="password" class="box" name="smtp_pass" maxlength="100" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo $SETTINGS->smtp_pass; ?>" />
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
    <div class="doubleWrapper" style="margin-top:10px">
     <div class="formLeft">
      <label><?php echo $msg_settings19; ?> <?php echo mswDisplayHelpTip($msg_javascript23,'RIGHT'); ?></label>
      <input type="text" class="smallbox" name="smtp_port" maxlength="4" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo $SETTINGS->smtp_port; ?>" />
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
    <?php
    if (LICENCE_VER!='unlocked') {
    ?>
    <p class="buttonWrapper" style="padding-bottom:20px"> 
     <input type="hidden" name="process" value="1" />
     <input tabindex="<?php echo (++$tabIndex); ?>" class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_settings7); ?>" title="<?php echo mswSpecialChars($msg_settings7); ?>" />
    </p>
    <?php
    }
    ?>
  
  </div>
  
</div>  
<?php
// Show if version is licenced..
if (LICENCE_VER=='unlocked') {
?>
<div class="contentWrapper"> 
  
  <h2><?php echo $msg_settings56; ?></h2>
       
  <div class="formWrapper"> 
  
    <div class="doubleWrapper">
     <div class="formLeft">
      <label><?php echo $msg_settings54; ?> <?php echo mswDisplayHelpTip($msg_javascript94,'RIGHT'); ?></label>
      <textarea name="adminFooter" rows="5" cols="20" tabindex="<?php echo (++$tabIndex); ?>"><?php echo mswSpecialChars($SETTINGS->adminFooter); ?></textarea>
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <label><?php echo $msg_settings55; ?> <?php echo mswDisplayHelpTip($msg_javascript95,'LEFT'); ?></label>
      <textarea name="publicFooter" rows="5" cols="20" tabindex="<?php echo (++$tabIndex); ?>"><?php echo mswSpecialChars($SETTINGS->publicFooter); ?></textarea>
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
    <p class="buttonWrapper" style="padding-bottom:20px"> 
     <input type="hidden" name="process" value="1" />
     <input class="button" tabindex="<?php echo (++$tabIndex); ?>" type="submit" value="<?php echo mswSpecialChars($msg_settings7); ?>" title="<?php echo mswSpecialChars($msg_settings7); ?>" />
    </p> 
    
  </div>
  
</div>
<?php
}
?>
</form>