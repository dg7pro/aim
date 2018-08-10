<?php if(!defined('PARENT')) { exit; } 
if (isset($_GET['edit'])) {
  $_GET['edit']  = (int)$_GET['edit'];
  $EDIT          = mswGetTableData('responses','id',$_GET['edit']);
}
if (isset($OK) || isset($REST)) {
  if (isset($REST)) {
    echo mswActionCompletedRestriction($msg_script22);
  } else {
    echo mswActionCompleted($msg_response7);
  }
}
if (isset($OK2)) {
  echo mswActionCompleted($msg_response8);
}
if (isset($OK3)) {
  echo mswActionCompleted($msg_response10);
}
if (isset($OK4)) {
  echo mswActionCompleted($msg_response16);
}
if (isset($OK5)) {
  echo mswActionCompleted($msg_response17);
}
?>

<div id="headWrapper">
  
  <div id="message">
   <p><?php echo $msg_response14; ?></p>
  </div>
  
</div>

<div class="contentWrapper"> 
  
  <h2><?php echo (isset($EDIT->id) ? $msg_response13 : $msg_response3); ?></h2>
       
  <div class="formWrapper"> 
  
    <form method="post" action="index.php?p=standard-responses<?php echo (isset($_GET['edit']) ? '&amp;edit='.$_GET['edit'] : ''); ?>">
    
    <div class="doubleWrapper">
     <div class="formLeft" style="width:65%">
      <label><?php echo $msg_response; ?> <?php echo mswDisplayHelpTip($msg_javascript34,'RIGHT'); ?></label>
      <input type="text" class="box" name="title" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo (isset($EDIT->id) ? mswSpecialChars($EDIT->title) : ''); ?>" />
      <br class="clear" />
     </div>
    
     <div class="formRight" style="width:30%">
      <label><?php echo $msg_response5; ?> <?php echo mswDisplayHelpTip($msg_javascript35,'LEFT'); ?></label>
      <select name="dept" tabindex="<?php echo (++$tabIndex); ?>">
      <?php
      if ($MSTEAM->id==1 || (mswRowCount('departments')==count($userDeptAccess))) {
      ?>
      <option value="0"><?php echo $msg_response6; ?></option>
      <?php
      }
      // If global log in no filter necessary..
      $q_dept = mysql_query("SELECT * FROM ".DB_PREFIX."departments ".mswSQLDepartmentFilter($mswDeptFilterAccess,'WHERE')." ORDER BY `name`") 
                or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      while ($DEPT = mysql_fetch_object($q_dept)) {
      ?>
      <option<?php echo (isset($EDIT->id) && $EDIT->department==$DEPT->id ? ' selected="selected" ' : ' '); ?>value="<?php echo $DEPT->id; ?>"><?php echo mswSpecialChars($DEPT->name); ?></option>
      <?php
      }
      ?>
      </select>
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
    <p class="answer">
     <label>
     <?php
     echo $msg_response2; ?> <?php echo mswDisplayHelpTip($msg_javascript36,'RIGHT'); 
     ?>
     </label>
     <?php
     if ($SETTINGS->enableBBCode=='yes') {
       define('BB_BOX','answer');
       include(PATH.'templates/system/bbcode-buttons.php');
     }
     ?>
     <textarea rows="8" cols="40" name="answer" id="answer" tabindex="<?php echo (++$tabIndex); ?>"><?php echo (isset($EDIT->id) ? mswSpecialChars($EDIT->answer) : ''); ?></textarea><br /><br />
     <?php echo $msg_kbase28; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="enResponse" value="yes"<?php echo (isset($EDIT->enResponse) && $EDIT->enResponse=='yes' ? ' checked="checked"' : (!isset($EDIT->enResponse) ? ' checked="checked"' : '')); ?> /> <?php echo $msg_kbase29; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="enResponse" value="no"<?php echo (isset($EDIT->enResponse) && $EDIT->enResponse=='no' ? ' checked="checked"' : ''); ?> />&nbsp;&nbsp;&nbsp;<?php echo mswDisplayHelpTip($msg_javascript128,'RIGHT'); ?>
    </p>
    
    <p class="buttonWrapper"> 
     <input type="hidden" name="<?php echo (isset($EDIT->id) ? 'update' : 'process'); ?>" value="1" />
     <input class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars((isset($EDIT->id) ? $msg_response13 : $msg_response3)); ?>" title="<?php echo mswSpecialChars((isset($EDIT->id) ? $msg_response13 : $msg_response3)); ?>" />
     <input onclick="ms_ticketPreview('standard-responses','answer')" tabindex="<?php echo (++$tabIndex); ?>" class="button" type="button" value="<?php echo mswSpecialChars($msg_kbase26); ?>" title="<?php echo mswSpecialChars($msg_kbase26); ?>" style="margin-left:30px" />
     <?php
     if (isset($EDIT->id)) {
     ?>
     <input class="cancelbutton" type="button" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_kbasecats11); ?>" title="<?php echo mswSpecialChars($msg_kbasecats11); ?>" onclick="window.location='?p=standard-responses'" />
     <?php
     }
     ?>
    </p> 
    
    </form>
    
  </div>
  
</div>  

<div class="contentWrapper"> 
  
  <?php
  $SQL         = '';
  $limit       = MAX_SR_ENTRIES;
  $limitvalue  = $page * $limit - ($limit);
  if (isset($_GET['dept'])) {
    $SQL = 'WHERE (`department` = \''.(int)$_GET['dept'].'\')';
  }
  $q_str = mysql_query("SELECT SQL_CALC_FOUND_ROWS * FROM ".DB_PREFIX."responses $SQL ORDER BY `title` LIMIT $limitvalue,".MAX_SR_ENTRIES) 
           or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $c            = mysql_fetch_object(mysql_query("SELECT FOUND_ROWS() AS rows"));
  $countedRows  =  (isset($c->rows) ? $c->rows : '0');
  ?>
  
  <h2 style="text-align:right">
   <span style="float:left;padding-top:5px">
   <?php 
   echo $msg_response4; 
   ?> (<?php echo $countedRows; ?>)
   </span>
   <select onchange="if(this.value!= 0){location=this.options[this.selectedIndex].value}">
    <option value="?p=standard-responses"><?php echo $msg_response6; ?></option>
    <?php
    $q_dept = mysql_query("SELECT * FROM ".DB_PREFIX."departments ".mswSQLDepartmentFilter($mswDeptFilterAccess,'WHERE')." ORDER BY `name`") 
              or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    while ($DEPT = mysql_fetch_object($q_dept)) {
    ?>
    <option<?php echo (isset($_GET['dept']) && $_GET['dept']==$DEPT->id ? ' selected="selected" ' : ' '); ?>value="?p=standard-responses&amp;dept=<?php echo $DEPT->id; ?>"><?php echo mswSpecialChars($DEPT->name); ?></option>
    <?php
    }
    ?>
   </select>
  </h2>
  
  <form method="post" id="form" action="index.php?p=standard-responses<?php echo (isset($_GET['edit']) ? '&amp;edit='.$_GET['edit'] : ''); ?>" onsubmit="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')">
  <div id="dataWrapper">
   <?php
   if (mysql_num_rows($q_str)>0) {
   while ($SR = mysql_fetch_object($q_str)) {
   ?>
   <p class="dataBlock">
    <span class="float">
    <a class="preview" href="?p=standard-responses&amp;view=<?php echo $SR->id; ?>" title="<?php echo mswSpecialChars($msg_response12); ?>" onclick="$.GB_hide();$.GB_show(this.href, {height: <?php echo GREYBOX_HEIGHT; ?>,width: <?php echo GREYBOX_WIDTH; ?>,caption: this.title,close_text: '<?php echo str_replace(array('\'','&#039;'),array(),mswSpecialChars($msg_javascript3)); ?>'});return false;"><?php echo $msg_response12; ?></a>
    <a class="edit" href="?p=standard-responses&amp;edit=<?php echo $SR->id; ?>" title="<?php echo mswSpecialChars($msg_kbasecats6); ?>"><?php echo $msg_kbasecats6; ?></a>
    <?php
    if (USER_DEL_PRIV=='yes') {
    ?>
    <a class="delete" href="?p=standard-responses&amp;delete=<?php echo $SR->id; ?>" title="<?php echo mswSpecialChars($msg_kbasecats3); ?>" onclick="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')"><?php echo $msg_kbasecats3; ?></a>
    <?php
    }
    ?>
    </span>
    <input type="checkbox" name="id[]" value="<?php echo $SR->id; ?>" id="sr_<?php echo $SR->id; ?>" /> <?php echo mswSpecialChars($SR->title).($SR->enResponse=='no' ? '&nbsp;&nbsp;&nbsp;<span class="highlight_italic">'.$msg_kbase25.'</span>' : ''); ?>
    <span class="summary"><span class="count">(<?php echo mswSpecialChars(mswSrCat($SR->department)); ?>)</span></span>
    <br class="clear" />
   </p>
   <?php
   }
   ?>
   <p class="buttonWrapper" style="padding-left:5px">
     <input type="hidden" name="endis" value="1" />
     <input type="checkbox" name="reset" value="all" onclick="if(this.checked){checkBoxes('on','form')}else{checkBoxes('off','form')}" />
     &nbsp;&nbsp;&nbsp;<input name="enable" class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_kbase28); ?>" title="<?php echo mswSpecialChars($msg_kbase28); ?>" />
     &nbsp;&nbsp;&nbsp;<input name="disable" class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_kbase29); ?>" title="<?php echo mswSpecialChars($msg_kbase29); ?>" />
   </p>
   <?php
   } else {
   ?>
   <p class="nodata"><?php echo $msg_response9; ?></p>
   <?php
   }
   ?>
  </div>
  </form>
</div> 
<?php
define('PER_PAGE',MAX_SR_ENTRIES);
if ($countedRows>0 && $countedRows>MAX_SR_ENTRIES) {
  $PTION = new pagination($countedRows,'?p='.$cmd.'&amp;next=');
  echo $PTION->display();
}
?>