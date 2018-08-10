<?php if(!defined('PARENT')) { exit; } 
if (isset($_GET['edit'])) {
  $_GET['edit'] = (int)$_GET['edit'];
  $EDIT         = mswGetTableData('departments','id',$_GET['edit']);
}

if (isset($OK)) {
  echo mswActionCompleted($msg_dept7);
}

if (isset($OK2)) {
  echo mswActionCompleted($msg_dept12);
}

if (isset($OK3)) {
  if ($count>0) {
    echo mswActionCompleted($msg_dept13);
  }
}

if (isset($OK4)) {
  echo mswActionCompleted($msg_dept21);
}

?>

<div id="headWrapper">
  
  <div id="message">
   <p><?php echo $msg_dept9; ?></p>
  </div>
  
</div>

<form method="post" action="?p=dept<?php echo (isset($_GET['edit']) ? '&amp;edit='.$_GET['edit'] : ''); ?>">
<div class="contentWrapper"> 
  
  <h2><?php echo (isset($EDIT->id) ? $msg_dept5 : $msg_dept2); ?></h2>
       
  <div class="formWrapper" style="padding-bottom:0"> 
  
    <div class="doubleWrapper">
     <div class="formLeft">
      <label><?php echo $msg_dept19; ?> <?php echo mswDisplayHelpTip($msg_javascript149,'RIGHT'); ?></label>
      <input type="text" class="box" maxlength="100" name="name" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo (isset($EDIT->name) ? mswSpecialChars($EDIT->name) : ''); ?>" />
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <label><?php echo $msg_dept17; ?> <?php echo mswDisplayHelpTip($msg_javascript150,'LEFT'); ?></label>
      <input type="text" class="box" name="dept_subject" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo (isset($EDIT->dept_subject) ? mswSpecialChars($EDIT->dept_subject) : ''); ?>" />
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
    <p class="answer" style="margin:10px 0 0 0">
     <label><?php echo $msg_dept18; ?> <?php echo mswDisplayHelpTip($msg_javascript151,'RIGHT'); ?>
     </label>
     <textarea rows="8" cols="40" name="dept_comments" id="dept_comments" tabindex="<?php echo (++$tabIndex); ?>"><?php echo (isset($EDIT->dept_comments) ? mswSpecialChars($EDIT->dept_comments) : ''); ?></textarea><br /><br />
    </p>
    
  </div>
  
  <div class="formWrapper" style="padding-top:0"> 
  
    <div class="doubleWrapper">
     <div class="formLeft">
      <label><?php echo $msg_dept15; ?> <?php echo mswDisplayHelpTip($msg_javascript106,'RIGHT'); ?></label>
      <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="showDept" value="yes"<?php echo (isset($EDIT->id) && $EDIT->showDept=='yes' ? ' checked="checked"' : (!isset($EDIT->id) ? ' checked="checked"' : '')); ?> /> <?php echo $msg_script5; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="showDept" value="no"<?php echo (isset($EDIT->id) && $EDIT->showDept=='no' ? ' checked="checked"' : ''); ?> />
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <label><?php echo $msg_dept22; ?> <?php echo mswDisplayHelpTip($msg_javascript158,'LEFT'); ?></label>
      <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="manual_assign" value="yes"<?php echo (isset($EDIT->id) && $EDIT->manual_assign=='yes' ? ' checked="checked"' : ''); ?> /> <?php echo $msg_script5; ?> <input<?php echo (isset($EDIT->id) && $EDIT->manual_assign=='yes' ? ' onclick="if (this.checked) {alert(\''.mswSpecialChars($msg_javascript159).'\')}" ' : ' '); ?>tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="manual_assign" value="no"<?php echo (isset($EDIT->id) && $EDIT->manual_assign=='no' ? ' checked="checked"' : (!isset($EDIT->id) ? ' checked="checked"' : '')); ?> />
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>  
    
  </div>  
    
  <div class="formWrapper"> 
    
    <p class="buttonWrapper"> 
      <input type="hidden" tabindex="<?php echo (++$tabIndex); ?>" name="<?php echo (isset($EDIT->id) ? 'update' : 'process'); ?>" value="1" />
      <input class="button" tabindex="<?php echo (++$tabIndex); ?>" type="submit" value="<?php echo mswSpecialChars((isset($EDIT->id) ? $msg_dept10 : $msg_dept2)); ?>" title="<?php echo mswSpecialChars((isset($EDIT->id) ? $msg_dept10 : $msg_dept2)); ?>" />
      <?php
      if (isset($EDIT->id)) {
      ?>
      <input tabindex="<?php echo (++$tabIndex); ?>" class="cancelbutton" type="button" value="<?php echo mswSpecialChars($msg_dept11); ?>" title="<?php echo mswSpecialChars($msg_dept11); ?>" onclick="window.location='?p=dept'" />
      <?php
      }
      ?>
    </p>
    
  </div>
  
</div>  
</form> 
        
<form method="post" id="form" action="index.php?p=dept">
<div class="contentWrapper"> 
  
  <?php
  // If global log in no filter necessary..
  $limit       = MAX_DEPT_ENTRIES;
  $limitvalue  = $page * $limit - ($limit);
  $q_dept = mysql_query("SELECT SQL_CALC_FOUND_ROWS * FROM ".DB_PREFIX."departments ".mswSQLDepartmentFilter($mswDeptFilterAccess,'WHERE')." 
            ORDER BY `orderBy` 
            LIMIT $limitvalue,".MAX_DEPT_ENTRIES) 
            or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $c            = mysql_fetch_object(mysql_query("SELECT FOUND_ROWS() AS rows"));
  $countedRows  =  (isset($c->rows) ? $c->rows : '0');
            
  ?> 
  
  <h2><?php echo $msg_dept4; ?> (<?php echo $countedRows; ?>)</h2>
  
  <div id="dataWrapper">
   <?php
   if (mysql_num_rows($q_dept)>0) {
   while ($DEPT = mysql_fetch_object($q_dept)) {
   ?>
   <p class="dataBlock">
    <input type="hidden" name="id[]" value="<?php echo $DEPT->id; ?>" />
    <span class="float">
    <a class="edit" href="?p=dept&amp;edit=<?php echo $DEPT->id; ?>" title="<?php echo mswSpecialChars($msg_dept6); ?>"><?php echo $msg_dept6; ?></a>
    <?php
    if (USER_DEL_PRIV=='yes') {
    ?>
    <a class="delete" href="?p=dept&amp;delete=<?php echo $DEPT->id; ?>" title="<?php echo mswSpecialChars($msg_dept3); ?>" onclick="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')"><?php echo $msg_dept3; ?></a>
    <?php
    }
    ?>
    </span>
    <select name="order[]" style="margin:0 10px 0 0">
    <?php
    for ($i=1; $i<(mysql_num_rows($q_dept)+1); $i++) {
    ?>
    <option value="<?php echo $i; ?>"<?php echo ($DEPT->orderBy==$i ? ' selected="selected"' : ''); ?>><?php echo $i; ?></option>
    <?php
    }
    $whatsOn = array($msg_script5,$msg_script5);
    if ($DEPT->showDept=='yes') {
      $whatsOn[0] = $msg_script4;
    }
    if ($DEPT->manual_assign=='yes') {
      $whatsOn[1] = $msg_script4;
    }
    ?>
    </select>
    <?php echo mswSpecialChars($DEPT->name); ?>
    <span class="summary"><span class="count"><?php echo str_replace(array('{manual}','{visible}'),array($whatsOn[1],$whatsOn[0]),$msg_dept23); ?></span></span>
    <br class="clear" />
   </p>
   <?php
   }
   ?>
   <p class="buttonWrapper">
     <input type="hidden" name="update_order" value="1" />
     &nbsp;&nbsp;&nbsp;<input class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_dept20); ?>" title="<?php echo mswSpecialChars($msg_dept20); ?>" />
   </p>  
   <?php
   } else {
   ?>
   <p class="nodata"><?php echo $msg_dept8; ?></p>
   <?php
   }
   ?>
  </div>
</div>
</form>
<?php
define('PER_PAGE',MAX_DEPT_ENTRIES);
if ($countedRows>0 && $countedRows>MAX_DEPT_ENTRIES) {
  $PTION = new pagination($countedRows,'?p='.$cmd.'&amp;next=');
  echo $PTION->display();
}
?>