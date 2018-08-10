<?php if(!defined('PARENT')) { exit; } 
if (isset($_GET['edit'])) {
  $_GET['edit']  = (int)$_GET['edit'];
  $EDIT          = mswGetTableData('cusfields','id',$_GET['edit']);
  $deptS         = ($EDIT->departments=='all' ? array('all') : explode(',',$EDIT->departments));
}
if (isset($OK)) {
  echo mswActionCompleted($msg_customfields12);
}
if (isset($OK2)) {
  echo mswActionCompleted($msg_customfields13);
}
if (isset($OK3)) {
  if ($count>0) {
    echo mswActionCompleted($msg_customfields14);
  }
}
if (isset($OK4)) {
  echo mswActionCompleted($msg_customfields22);
}
if (isset($OK5)) {
  echo mswActionCompleted($msg_customfields25);
}
if (isset($OK6)) {
  echo mswActionCompleted($msg_customfields26);
}

?>

<div id="headWrapper">
  
  <div id="message">
   <p><?php echo $msg_customfields; ?></p>
  </div>
  
</div>

<div class="contentWrapper"> 
  
  <h2><?php echo (isset($EDIT->id) ? $msg_user14 : $msg_customfields2); ?></h2>
       
  <div class="formWrapper"> 
  
    <form method="post" action="index.php?p=fields<?php echo (isset($_GET['edit']) ? '&amp;edit='.$_GET['edit'] : ''); ?>">
    
    <div class="doubleWrapper">
     <div class="formLeft" style="width:33%">
      <label><?php echo $msg_customfields3; ?> <?php echo mswDisplayHelpTip($msg_javascript108,'RIGHT'); ?></label>
      <input type="text" class="box" maxlength="250" name="fieldInstructions" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo (isset($EDIT->id) ? mswSpecialChars($EDIT->fieldInstructions) : ''); ?>" /><br /><br />
      <label><?php echo $msg_customfields10; ?> <?php echo mswDisplayHelpTip($msg_javascript111,'RIGHT'); ?></label>
      <textarea rows="8" cols="40" name="fieldOptions" tabindex="<?php echo (++$tabIndex); ?>" style="height:164px;width:90%"><?php echo (isset($EDIT->id) ? mswSpecialChars($EDIT->fieldOptions) : ''); ?></textarea>
      
      <br class="clear" />
     </div>
    
     <div class="formLeft" style="width:33%">
      <label><?php echo $msg_customfields4; ?> <?php echo mswDisplayHelpTip($msg_javascript109); ?></label>
      <?php echo $msg_customfields5; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="fieldType" value="textarea"<?php echo (isset($EDIT->id) && $EDIT->fieldType=='textarea' ? ' checked="checked"' : ''); ?> /> 
      <?php echo $msg_customfields6; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="fieldType" value="input"<?php echo (isset($EDIT->id) && $EDIT->fieldType=='input' ? ' checked="checked"' : (!isset($EDIT->id) ? ' checked="checked"' : '')); ?> /> 
      <?php echo $msg_customfields7; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="fieldType" value="select"<?php echo (isset($EDIT->id) && $EDIT->fieldType=='select' ? ' checked="checked"' : ''); ?> />
      <?php echo $msg_customfields8; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="fieldType" value="checkbox"<?php echo (isset($EDIT->id) && $EDIT->fieldType=='checkbox' ? ' checked="checked"' : ''); ?> /><br /><br />
      
      <label style="margin-top:13px"><?php echo $msg_customfields31; ?> <?php echo mswDisplayHelpTip($msg_javascript166); ?></label>
      <div class="overflow">
      <?php
      $q_dept = mysql_query("SELECT * FROM ".DB_PREFIX."departments ".mswSQLDepartmentFilter($mswDeptFilterAccess,'WHERE')." ORDER BY `name`") 
                or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      while ($DEPT = mysql_fetch_object($q_dept)) {
      ?>
      <input type="checkbox" name="dept[]" value="<?php echo $DEPT->id; ?>" tabindex="<?php echo (++$tabIndex); ?>"<?php echo (isset($EDIT->id) && in_array($DEPT->id,$deptS) ? ' checked="checked"' : ''); ?> /> <?php echo mswSpecialChars($DEPT->name); ?><br />
      <?php
      }
      ?>
      </div>
      <br class="clear" />
     </div>
     
     <div class="formRight" style="width:33%">
      <label><?php echo $msg_customfields9; ?> <?php echo mswDisplayHelpTip($msg_javascript110,'LEFT'); ?></label>
      <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="fieldReq" value="yes"<?php echo (isset($EDIT->id) && $EDIT->fieldReq=='yes' ? ' checked="checked"' : ''); ?> /> <?php echo $msg_script5; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="fieldReq" value="no"<?php echo (isset($EDIT->id) && $EDIT->fieldReq=='no' ? ' checked="checked"' : (!isset($EDIT->id) ? ' checked="checked"' : '')); ?> /><br /><br />
      
      <label><?php echo $msg_customfields17; ?> <?php echo mswDisplayHelpTip($msg_javascript112,'LEFT'); ?></label>
      <?php echo $msg_customfields18; ?> <input type="checkbox" tabindex="<?php echo (++$tabIndex); ?>" name="fieldLoc[]" value="ticket"<?php echo (isset($EDIT->id) && strpos($EDIT->fieldLoc,'ticket')!==false ? ' checked="checked"' : (!isset($EDIT->id) ? ' checked="checked"' : '')); ?> /> 
      <?php echo $msg_customfields19; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="checkbox" name="fieldLoc[]" value="reply"<?php echo (isset($EDIT->id) && strpos($EDIT->fieldLoc,'reply')!==false ? ' checked="checked"' : ''); ?> />
      <?php echo $msg_customfields20; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="checkbox" name="fieldLoc[]" value="admin"<?php echo (isset($EDIT->id) && strpos($EDIT->fieldLoc,'admin')!==false ? ' checked="checked"' : ''); ?> /><br /><br />
      
      <label><?php echo $msg_customfields24; ?> <?php echo mswDisplayHelpTip($msg_javascript122,'LEFT'); ?></label>
      <?php echo $msg_customfields28; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="repeatPref" value="yes"<?php echo (isset($EDIT->id) && $EDIT->repeatPref=='yes' ? ' checked="checked"' : (!isset($EDIT->id) ? ' checked="checked"' : '')); ?> /> <?php echo $msg_customfields29; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="repeatPref" value="no"<?php echo (isset($EDIT->id) && $EDIT->repeatPref=='no' ? ' checked="checked"' : ''); ?> /><br /><br />
      
      <label><?php echo $msg_customfields27; ?> <?php echo mswDisplayHelpTip($msg_javascript127,'LEFT'); ?></label>
      <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="enField" value="yes"<?php echo (isset($EDIT->id) && $EDIT->enField=='yes' ? ' checked="checked"' : (!isset($EDIT->id) ? ' checked="checked"' : '')); ?> /> <?php echo $msg_script5; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="enField" value="no"<?php echo (isset($EDIT->id) && $EDIT->enField=='no' ? ' checked="checked"' : ''); ?> />
      
      
      <br class="clear" />
     </div>
     
     <br class="clear" />
    </div>
    
    <p class="buttonWrapper"> 
     <input type="hidden" name="<?php echo (isset($EDIT->id) ? 'update' : 'process'); ?>" value="1" />
     <input class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars((isset($EDIT->id) ? $msg_customfields11 : $msg_customfields2)); ?>" title="<?php echo mswSpecialChars((isset($EDIT->id) ? $msg_customfields11 : $msg_customfields2)); ?>" />
     <?php
     if (isset($EDIT->id)) {
     ?>
     <input class="cancelbutton" type="button" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_kbasecats11); ?>" title="<?php echo mswSpecialChars($msg_kbasecats11); ?>" onclick="window.location='?p=fields'" />
     <?php
     }
     ?>
    </p>
    
    </form>
    
  </div>
  
</div> 

<form method="post" id="form" action="index.php?p=fields<?php echo (isset($_GET['edit']) ? '&amp;edit='.$_GET['edit'] : ''); ?>" onsubmit="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')">
<div class="contentWrapper"> 
  
  <?php
  $sql         = '';
  $limit       = MAX_FIELD_ENTRIES;
  $limitvalue  = $page * $limit - ($limit);
  if (isset($_GET['d']) && $_GET['d']>0) {
    $sql = 'WHERE (`departments` = \'all\' OR FIND_IN_SET(\''.(int)$_GET['d'].'\',`departments`) > 0)';
  }
  $q_fields = mysql_query("SELECT SQL_CALC_FOUND_ROWS * FROM ".DB_PREFIX."cusfields $sql ORDER BY `orderBy` LIMIT $limitvalue,".MAX_FIELD_ENTRIES) 
              or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $c            = mysql_fetch_object(mysql_query("SELECT FOUND_ROWS() AS rows"));
  $countedRows  =  (isset($c->rows) ? $c->rows : '0');
  ?> 
  
  <h2 style="text-align:right">
   <span style="float:left">
   <?php
   echo $msg_customfields15; 
   ?> (<?php echo mysql_num_rows($q_fields); ?>)
   </span>
   <select onchange="if(this.value!= 0){location=this.options[this.selectedIndex].value}">
   <option value="?p=fields"><?php echo $msg_tools10; ?></option>
   <?php
   $q_dept = mysql_query("SELECT * FROM ".DB_PREFIX."departments ".mswSQLDepartmentFilter($mswDeptFilterAccess,'WHERE')." ORDER BY `name`") 
            or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
   while ($DEPT = mysql_fetch_object($q_dept)) {
   ?>
   <option value="?p=fields&amp;d=<?php echo $DEPT->id; ?>"<?php echo (isset($_GET['d']) && $_GET['d']==$DEPT->id ? ' selected="selected"' : ''); ?>><?php echo mswCleanData($DEPT->name); ?></option>
   <?php
   }
   ?>
   </select>
  </h2>
  
  <div id="dataWrapper">
   <?php
   if (mysql_num_rows($q_fields)>0) {
   while ($FIELD = mysql_fetch_object($q_fields)) {
   ?>
   <p class="dataBlock">
    <input type="hidden" name="id[]" value="<?php echo $FIELD->id; ?>" />
    <span class="float">
    <a class="edit" href="?p=fields&amp;edit=<?php echo $FIELD->id; ?>" title="<?php echo mswSpecialChars($msg_dept6); ?>"><?php echo $msg_dept6; ?></a>
    <?php
    if (USER_DEL_PRIV=='yes') {
    ?>
    <a class="delete" href="?p=fields&amp;delete=<?php echo $FIELD->id; ?>" title="<?php echo mswSpecialChars($msg_dept3); ?>" onclick="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')"><?php echo $msg_dept3; ?></a>
    <?php
    }
    ?>
    </span>
    <input type="checkbox" name="fid[]" value="<?php echo $FIELD->id; ?>" id="field_<?php echo $FIELD->id; ?>" />&nbsp;&nbsp;&nbsp;<select name="order[]" style="margin:0 10px 0 0">
    <?php
    for ($i=1; $i<(mysql_num_rows($q_fields)+1); $i++) {
    ?>
    <option value="<?php echo $i; ?>"<?php echo ($FIELD->orderBy==$i ? ' selected="selected"' : ''); ?>><?php echo $i; ?></option>
    <?php
    }
    ?>
    </select>
    <span class="id">(<?php echo $msg_customfields23; ?>: <?php echo $FIELD->id; ?>)</span> <?php echo mswSpecialChars($FIELD->fieldInstructions).($FIELD->enField=='no' ? '&nbsp;&nbsp;&nbsp;<span class="highlight_italic">'.$msg_kbase25.'</span>' : ''); ?>
    <span class="summary"><span class="count"><?php echo mswFieldInformation($FIELD); ?></span></span>
    <br class="clear" />
   </p>
   <?php
   }
   ?>
   <p class="buttonWrapper">
     <input type="hidden" name="update_order" value="1" />
     &nbsp;<input type="checkbox" name="endis" value="all" onclick="if(this.checked){checkBoxes('on','form')}else{checkBoxes('off','form')}" />
     &nbsp;&nbsp;&nbsp;<input name="enable" class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_kbase28); ?>" title="<?php echo mswSpecialChars($msg_kbase28); ?>" />
     &nbsp;&nbsp;&nbsp;<input name="disable" class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_kbase29); ?>" title="<?php echo mswSpecialChars($msg_kbase29); ?>" />
     &nbsp;&nbsp;&nbsp;<input class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_customfields21); ?>" title="<?php echo mswSpecialChars($msg_customfields21); ?>" />
   </p>
   <?php
   } else {
   ?>
   <p class="nodata"><?php echo $msg_customfields16; ?></p>
   <?php
   }
   ?>
  </div>
</div> 
</form>
<?php
define('PER_PAGE',MAX_FIELD_ENTRIES);
if ($countedRows>0 && $countedRows>MAX_FIELD_ENTRIES) {
  $PTION = new pagination($countedRows,'?p='.$cmd.'&amp;next=');
  echo $PTION->display();
}
?>