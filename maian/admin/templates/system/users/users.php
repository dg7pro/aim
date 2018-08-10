<?php if(!defined('PARENT')) { exit; } 
if (isset($_GET['edit'])) {
  $_GET['edit']        = (int)$_GET['edit'];
  $EDIT                = mswGetTableData('users','id',$_GET['edit']);
  $ePageAccess         = mswGetUserPageAccess($_GET['edit']);
  $eDeptAccess         = mswGetDepartmentAccess($_GET['edit']);
  $mswDeptFilterAccess    = mswDeptFilterAccess($MSTEAM,$eDeptAccess,'department');
}
$accessPagesUser  = mswGetAdminPages();

if (isset($OK)) {
  echo mswActionCompleted($msg_user6);
}

if (isset($OK2)) {
  echo mswActionCompleted($msg_user13);
}

if (isset($OK3)) {
  echo mswActionCompleted($msg_user15);
}

if (isset($OK4)) {
  echo mswActionCompleted($msg_user43);
}

if (isset($OK5)) {
  echo mswActionCompleted($msg_user44);
}

?>

<div id="headWrapper">
  
  <div id="message">
   <p><?php echo $msg_user21; ?></p>
  </div>
  
</div>

<div class="contentWrapper"> 
  
  <h2><?php echo (isset($EDIT->id) ? $msg_user14 : $msg_user2); ?></h2>
       
  <div class="formWrapper"> 
  
    <form method="post" action="index.php?p=users<?php echo (isset($_GET['edit']) ? '&amp;edit='.$_GET['edit'] : ''); ?>" onsubmit="return checkUserEmail('<?php echo htmlspecialchars(str_replace("'","\'",$msg_javascript156)); ?>')">
    
    <div class="doubleWrapper">
     <div class="formLeft" style="width:33%">
      <label><?php echo $msg_user; ?> <?php echo mswDisplayHelpTip($msg_javascript27,'RIGHT'); ?></label>
      <input type="text" class="box" name="name" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo (isset($EDIT->name) ? mswSpecialChars($EDIT->name) : ''); ?>" /><br /><br />
      
      <label><?php echo $msg_user4; ?> <?php echo mswDisplayHelpTip($msg_javascript30,'RIGHT'); ?></label>
      <input type="text" class="box" name="email" id="email" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo (isset($EDIT->email) ? mswSpecialChars($EDIT->email) : ''); ?>" /><br /><br />
      
      <label><?php echo $msg_user12; ?> <?php echo mswDisplayHelpTip($msg_javascript31,'RIGHT'); ?></label>
      <span class="pass" id="pass"><input type="password" class="box" id="accpass" name="accpass" tabindex="<?php echo (++$tabIndex); ?>" value="" /></span>
      <span class="passOptions" id="passOptions" style="display:none">
       <?php echo $msg_user47; ?> <input type="checkbox" id="letters" name="letters" value="yes" checked="checked" />
       <?php echo $msg_user52; ?> <input type="checkbox" id="letters2" name="letters2" value="yes" checked="checked" />
       <?php echo $msg_user48; ?> <input type="checkbox" id="numbers" name="numbers" value="yes" checked="checked" />
       <?php echo $msg_user49; ?> <input type="checkbox" id="special" name="special" value="yes" checked="checked" />
       <select id="chars" name="chars" style="margin-left:10px" tabindex="<?php echo (++$tabIndex); ?>">
       <?php
       foreach (range(6,20) AS $char) {
       ?>
       <option value="<?php echo $char; ?>"<?php echo (USER_AUTO_PASS_CHAR_DEFAULT==$char ? ' selected="selected"' : ''); ?>><?php echo $char; ?></option>
       <?php
       }
       ?>
       </select>
       <input class="buttonpass" tabindex="<?php echo (++$tabIndex); ?>" type="button" onclick="mswgenerateAutoPass()" value="<?php echo mswSpecialChars($msg_user50); ?>" title="<?php echo mswSpecialChars($msg_user50); ?>" />
      </span>
      <br class="clear" />
     </div>
    
     <div class="formLeft" style="width:33%">
      <label><?php echo $msg_user5; ?> <?php echo mswDisplayHelpTip($msg_javascript28); ?></label>
      <div class="overflow" id="deptboxes">
      <input tabindex="<?php echo (++$tabIndex); ?>" onclick="if(this.checked){selectAllBoxes('dept','on')}else{selectAllBoxes('dept','off')}" type="checkbox" name="all" value="all"<?php echo (isset($eDeptAccess) && mswRowCount('departments')==count($eDeptAccess) ? ' checked="checked"' : ''); ?> /> <b><?php echo mswSpecialChars($msg_user56); ?></b><br />
      <?php
      // If global log in no filter necessary..
      $q_dept = mysql_query("SELECT * FROM ".DB_PREFIX."departments ".mswSQLDepartmentFilter($mswDeptFilterAccess,'WHERE')." ORDER BY `name`") 
                or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      while ($DEPT = mysql_fetch_object($q_dept)) {
      ?>
      <input tabindex="<?php echo (++$tabIndex); ?>" type="checkbox" name="dept[]" value="<?php echo $DEPT->id; ?>"<?php echo (isset($EDIT->id) && in_array($DEPT->id,$eDeptAccess) ? ' checked="checked"' : ''); ?> /> <?php echo mswSpecialChars($DEPT->name); ?><br />
      <?php
      }
      ?>
      </div>
      <br class="clear" />
     </div>
     
     <div class="formRight" style="width:33%">
      <label><?php echo $msg_user24; ?> <?php echo mswDisplayHelpTip($msg_javascript29,'LEFT'); ?></label>
      <div class="overflow" id="pageboxes">
      <input tabindex="<?php echo (++$tabIndex); ?>" onclick="if(this.checked){selectAllBoxes('pages','on')}else{selectAllBoxes('pages','off')}" type="checkbox" name="allpages" value="allpages" /> <b><?php echo mswSpecialChars($msg_user57); ?></b><br />
      <?php
      foreach ($accessPagesUser AS $key => $value) {
      if (in_array($key,$userAccess) || $MSTEAM->id=='1') {
      ?>
      <input tabindex="<?php echo (++$tabIndex); ?>" type="checkbox" name="pages[]" value="<?php echo $key; ?>"<?php echo (isset($EDIT->id) && in_array($key,$ePageAccess) ? ' checked="checked"' : ''); ?> /> <?php echo mswSpecialChars($value); ?><br />
      <?php
      }
      }
      ?>
      </div>
      <br class="clear" />
     </div>
     
     <br class="clear" />
    </div>
    
    <div class="doubleWrapper">
     <div class="formLeft" style="width:33%">
      <label><?php echo $msg_user65; ?> <?php echo mswDisplayHelpTip($msg_javascript152,'RIGHT'); ?></label>
      <input type="text" class="box" name="nameFrom" maxlength="250" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo (isset($EDIT->nameFrom) ? mswSpecialChars($EDIT->nameFrom) : ''); ?>" />
      <br class="clear" />
     </div>
    
     <div class="formLeft" style="width:33%">
      <label><?php echo $msg_user66; ?> <?php echo mswDisplayHelpTip($msg_javascript153); ?></label>
      <input type="text" class="box" name="emailFrom" maxlength="250" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo (isset($EDIT->emailFrom) ? mswSpecialChars($EDIT->emailFrom) : ''); ?>" />
      <br class="clear" />
     </div>
     
     <div class="formRight" style="width:33%">
      <label><?php echo $msg_user70; ?> <?php echo mswDisplayHelpTip($msg_javascript167,'LEFT'); ?></label>
      <select name="timezone" tabindex="<?php echo (++$tabIndex); ?>">
      <option value="0">- - - - - - -</option>
      <?php
      // TIMEZONES..
      foreach ($timezones AS $k => $v) {
      ?>
      <option value="<?php echo $k; ?>"<?php echo (isset($EDIT->timezone) && $EDIT->timezone==$k ? ' selected="selected"' : ''); ?>><?php echo $v; ?></option>
      <?php
      }
      ?>
      </select>
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
    <p class="answer" style="margin-top:10px">
     <label><?php echo $msg_user17; ?> <?php echo mswDisplayHelpTip($msg_javascript33,'RIGHT'); ?></label>
     <textarea rows="8" cols="40" name="signature" class="siggie" tabindex="<?php echo (++$tabIndex); ?>"><?php echo (isset($EDIT->signature) ? mswSpecialChars($EDIT->signature) : ''); ?></textarea>
    </p>
    
    <div class="doubleWrapper" style="margin-top:10px">
     <div class="formLeft" style="width:33%">
      <label><?php echo $msg_user54; ?> <?php echo mswDisplayHelpTip($msg_javascript113,'RIGHT'); ?></label>
      <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="notePadEnable" value="yes"<?php echo (isset($EDIT->notePadEnable) && $EDIT->notePadEnable=='yes' ? ' checked="checked"' : (!isset($EDIT->notePadEnable) ? ' checked="checked"' : '')); ?> /> <?php echo $msg_script5; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="notePadEnable" value="no"<?php echo (isset($EDIT->notePadEnable) && $EDIT->notePadEnable=='no' ? ' checked="checked"' : ''); ?> />
      <br class="clear" />
     </div>
     
     <div class="formLeft" style="width:33%">
       <label><?php echo $msg_user45; ?> <?php echo mswDisplayHelpTip($msg_javascript105); ?></label>
       <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="emailSigs" value="yes"<?php echo (isset($EDIT->emailSigs) && $EDIT->emailSigs=='yes' ? ' checked="checked"' : ''); ?> /> <?php echo $msg_script5; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="emailSigs" value="no"<?php echo (isset($EDIT->emailSigs) && $EDIT->emailSigs=='no' ? ' checked="checked"' : (!isset($EDIT->emailSigs) ? ' checked="checked"' : '')); ?> />
       <br class="clear" />
     </div>
    
     <div class="formLeft" style="width:33%">
      <label><?php echo $msg_user18; ?> <?php echo mswDisplayHelpTip($msg_javascript32,'LEFT'); ?></label>
      <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="notify" value="yes"<?php echo (isset($EDIT->notify) && $EDIT->notify=='yes' ? ' checked="checked"' : (!isset($EDIT->notify) ? ' checked="checked"' : '')); ?> /> <?php echo $msg_script5; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="notify" value="no"<?php echo (isset($EDIT->notify) && $EDIT->notify=='no' ? ' checked="checked"' : ''); ?> />
      <br class="clear" />
     </div>
     
     <br class="clear" />
    </div>
    
    <div class="doubleWrapper" style="margin-top:10px">
     <div class="formLeft" style="width:33%">
      <label><?php echo $msg_user69; ?> <?php echo mswDisplayHelpTip($msg_javascript160,'RIGHT'); ?></label>
      <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="assigned" value="yes"<?php echo (isset($EDIT->assigned) && $EDIT->assigned=='yes' ? ' checked="checked"' : ''); ?> /> <?php echo $msg_script5; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="assigned" value="no"<?php echo (isset($EDIT->assigned) && $EDIT->assigned=='no' ? ' checked="checked"' : (!isset($EDIT->assigned) ? ' checked="checked"' : '')); ?> />
      <br class="clear" />
     </div>
     
     <div class="formLeft" style="width:33%">
       <label><?php echo $msg_user64; ?> <?php echo mswDisplayHelpTip($msg_javascript145); ?></label>
       <?php
       if (USER_DEL_PRIV=='yes') {
       ?>
       <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="delPriv" value="yes"<?php echo (isset($EDIT->delPriv) && $EDIT->delPriv=='yes' ? ' checked="checked"' : ''); ?> /> <?php echo $msg_script5; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="delPriv" value="no"<?php echo (isset($EDIT->delPriv) && $EDIT->delPriv=='no' ? ' checked="checked"' : (!isset($EDIT->delPriv) ? ' checked="checked"' : '')); ?> />
       <?php
       } else {
         echo $msg_script5;
       }
       ?>
       <br class="clear" />
     </div>
     
     <br class="clear" />
    </div>
    
    <?php 
    if (!isset($EDIT->id)) {
    ?>
    <div class="doubleWrapperHighlight" style="margin-top:10px">
      <p><?php echo $msg_user46; ?> <input type="checkbox" name="sendMail" value="yes" checked="checked" tabindex="<?php echo (++$tabIndex); ?>" /></p>
    </div>
    <?php
    }
    ?>
     
    <p class="buttonWrapper"> 
     <input type="hidden" name="<?php echo (isset($EDIT->id) ? 'update' : 'process'); ?>" value="1" />
     <input class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars((isset($EDIT->id) ? $msg_user14 : $msg_user2)); ?>" title="<?php echo mswSpecialChars((isset($EDIT->id) ? $msg_user14 : $msg_user2)); ?>" />
     <?php
     if (isset($EDIT->id)) {
     ?>
     <input type="hidden" name="curPass" value="<?php echo $EDIT->accpass; ?>" />
     <input class="cancelbutton" type="button" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_kbasecats11); ?>" title="<?php echo mswSpecialChars($msg_kbasecats11); ?>" onclick="window.location='?p=users'" />
     <?php
     }
     ?>
    </p>
    
    </form>
    
  </div>
  
</div> 

<div class="contentWrapper"> 
  
  <?php
  $SQL = '';
  if ($MSTEAM->id!='1') {
    $SQL = 'WHERE `id` > 1';
  }
  $limit       = MAX_USER_ENTRIES;
  $limitvalue  = $page * $limit - ($limit);
  $q_users     = mysql_query("SELECT SQL_CALC_FOUND_ROWS * FROM ".DB_PREFIX."users $SQL ORDER BY `id` LIMIT $limitvalue,".MAX_USER_ENTRIES) 
                 or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $c            = mysql_fetch_object(mysql_query("SELECT FOUND_ROWS() AS rows"));
  $countedRows  =  (isset($c->rows) ? $c->rows : '0');
  
  ?>
  
  <h2>
  <?php
  echo $msg_user3; 
  ?> (<?php echo $countedRows; ?>)
  </h2>
  
  <form method="post" id="form" action="index.php?p=users<?php echo (isset($_GET['edit']) ? '&amp;edit='.$_GET['edit'] : ''); ?>" onsubmit="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')">
  <div id="dataWrapper">
   <?php
   if (mysql_num_rows($q_users)>0) {
   while ($USER = mysql_fetch_object($q_users)) {
   ?>
   <p class="dataBlock">
    <span class="float">
    <a class="user" href="?p=users&amp;view=<?php echo $USER->id; ?>" title="<?php echo mswSpecialChars($msg_user10); ?>" onclick="$.GB_hide();$.GB_show(this.href, {height: <?php echo GREYBOX_HEIGHT; ?>,width: <?php echo GREYBOX_WIDTH; ?>,caption: this.title,close_text: '<?php echo str_replace(array('\'','&#039;'),array(),mswSpecialChars($msg_user10)); ?>'});return false;"><?php echo $msg_user10; ?></a>
    <a class="edit" href="?p=users&amp;edit=<?php echo $USER->id; ?>" title="<?php echo mswSpecialChars($msg_kbasecats6); ?>"><?php echo $msg_kbasecats6; ?></a>
    <?php
    if ($USER->id>1) {
    if (USER_DEL_PRIV=='yes') {
    ?>
    <a class="delete" href="?p=users&amp;delete=<?php echo $USER->id; ?>" title="<?php echo mswSpecialChars($msg_kbasecats3); ?>" onclick="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')"><?php echo $msg_kbasecats3; ?></a>
    <?php
    }
    }
    ?>
    </span>
    <input type="checkbox" name="id[]" value="<?php echo $USER->id; ?>" id="user_<?php echo $USER->id; ?>" /> <span class="id">(<?php echo $msg_customfields23; ?>: <?php echo $USER->id; ?>)</span> <?php echo mswSpecialChars($USER->name).($USER->id==1 ? ' ('.$msg_user40.')' : '').($USER->notify=='no' ? '&nbsp;&nbsp;&nbsp;<span class="highlight_italic">'.$msg_user55.'</span>' : ''); ?>
    <?php
    if ($USER->id==1) {
    ?>
    <span class="summary"><span class="count">(<?php echo $msg_user71; ?>)</span></span>
    <?php
    } else {
    $find = array('{notepad}','{siggie}','{notify}','{assigned}','{del}');
    $repl = array(
     ($USER->notePadEnable=='yes' ? $msg_script4 : $msg_script5),
     ($USER->signature=='yes' ? $msg_script4 : $msg_script5),
     ($USER->notify=='yes' ? $msg_script4 : $msg_script5),
     ($USER->assigned=='yes' ? $msg_script4 : $msg_script5),
     ($USER->delPriv=='yes' ? $msg_script4 : $msg_script5)
    );
    ?>
    <span class="summary"><span class="count">(<?php echo str_replace($find,$repl,$msg_user72); ?>)</span></span>
    <?php
    }
    ?>
    <br class="clear" />
   </p>
   <?php
   }
   ?>
   <p class="buttonWrapper" style="padding-left:5px">
     <input type="hidden" name="endis" value="1" />
     <input type="checkbox" name="reset" value="all" onclick="if(this.checked){checkBoxes('on','form')}else{checkBoxes('off','form')}" />&nbsp;&nbsp;&nbsp;<input name="enable" class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_user41); ?>" title="<?php echo mswSpecialChars($msg_user41); ?>" />
     &nbsp;&nbsp;&nbsp;<input name="disable" class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_user42); ?>" title="<?php echo mswSpecialChars($msg_user42); ?>" />
   </p>
   <?php
   } else {
   ?>
   <p class="nodata"><?php echo $msg_kbase9; ?></p>
   <?php
   }
   ?>
  </div>
  </form>
  
</div> 
<?php
define('PER_PAGE',MAX_USER_ENTRIES);
if ($countedRows>0 && $countedRows>MAX_USER_ENTRIES) {
  $PTION = new pagination($countedRows,'?p='.$cmd.'&amp;next=');
  echo $PTION->display();
}
?>