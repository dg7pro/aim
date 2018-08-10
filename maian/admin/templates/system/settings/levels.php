<?php if(!defined('PARENT')) { exit; } 
if (isset($_GET['edit'])) {
  $_GET['edit'] = (int)$_GET['edit'];
  $EDIT         = mswGetTableData('levels','id',$_GET['edit']);
}

if (isset($OK)) {
  echo mswActionCompleted($msg_levels7);
}

if (isset($OK2)) {
  echo mswActionCompleted($msg_levels12);
}

if (isset($OK3)) {
  if ($count>0) {
    echo mswActionCompleted($msg_levels13);
  }
}

if (isset($OK4)) {
  echo mswActionCompleted($msg_levels20);
}

?>

<div id="headWrapper">
  
  <div id="message">
   <p><?php echo $msg_levels9; ?></p>
  </div>
  
</div>

<form method="post" action="?p=levels<?php echo (isset($_GET['edit']) ? '&amp;edit='.$_GET['edit'] : ''); ?>">
<div class="contentWrapper"> 
  
  <h2><?php echo (isset($EDIT->id) ? $msg_levels5 : $msg_levels2); ?></h2>
       
  <div class="formWrapper" style="padding-bottom:0"> 
  
    <div class="doubleWrapper">
     <div class="formLeft">
      <label><?php echo $msg_levels19; ?> <?php echo mswDisplayHelpTip($msg_javascript170,'RIGHT'); ?></label>
      <input type="text" class="box" maxlength="100" name="name" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo (isset($EDIT->name) ? mswSpecialChars($EDIT->name) : ''); ?>" />
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <label><?php echo $msg_levels15; ?> <?php echo mswDisplayHelpTip($msg_javascript169,'LEFT'); ?></label>
      <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="display" value="yes"<?php echo (isset($EDIT->display) && $EDIT->display=='yes' ? ' checked="checked"' : (!isset($EDIT->display) ? ' checked="checked"' : '')); ?> /> <?php echo $msg_script5; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="display" value="no"<?php echo (isset($EDIT->display) && $EDIT->display=='no' ? ' checked="checked"' : ''); ?> />
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
  </div>
  
  <div class="formWrapper"> 
    
    <p class="buttonWrapper"> 
      <input type="hidden" tabindex="<?php echo (++$tabIndex); ?>" name="<?php echo (isset($EDIT->id) ? 'update' : 'process'); ?>" value="1" />
      <input class="button" tabindex="<?php echo (++$tabIndex); ?>" type="submit" value="<?php echo mswSpecialChars((isset($EDIT->id) ? $msg_levels10 : $msg_levels2)); ?>" title="<?php echo mswSpecialChars((isset($EDIT->id) ? $msg_levels10 : $msg_levels2)); ?>" />
      <?php
      if (isset($EDIT->id)) {
      ?>
      <input tabindex="<?php echo (++$tabIndex); ?>" class="cancelbutton" type="button" value="<?php echo mswSpecialChars($msg_levels11); ?>" title="<?php echo mswSpecialChars($msg_levels11); ?>" onclick="window.location='?p=levels'" />
      <?php
      }
      ?>
    </p>
    
  </div>
  
</div>  
</form> 
        
<form method="post" id="form" action="index.php?p=levels">
<div class="contentWrapper"> 
  
  <?php
  // If global log in no filter necessary..
  $limit        = MAX_LEVEL_ENTRIES;
  $limitvalue   = $page * $limit - ($limit);
  $q_level      = mysql_query("SELECT SQL_CALC_FOUND_ROWS * FROM ".DB_PREFIX."levels 
                  ORDER BY `orderBy` 
                  LIMIT $limitvalue,".MAX_LEVEL_ENTRIES) 
                  or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $c            = mysql_fetch_object(mysql_query("SELECT FOUND_ROWS() AS rows"));
  $countedRows  =  (isset($c->rows) ? $c->rows : '0');
            
  ?> 
  
  <h2><?php echo $msg_levels4; ?> (<?php echo $countedRows; ?>)</h2>
  
  <div id="dataWrapper">
   <?php
   while ($LEV = mysql_fetch_object($q_level)) {
   ?>
   <p class="dataBlock">
    <input type="hidden" name="id[]" value="<?php echo $LEV->id; ?>" />
    <span class="float">
    <a class="edit" href="?p=levels&amp;edit=<?php echo $LEV->id; ?>" title="<?php echo mswSpecialChars($msg_levels6); ?>"><?php echo $msg_levels6; ?></a>
    <?php
    if (USER_DEL_PRIV=='yes' && $LEV->id>3) {
    ?>
    <a class="delete" href="?p=levels&amp;delete=<?php echo $LEV->id; ?>" title="<?php echo mswSpecialChars($msg_levels3); ?>" onclick="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')"><?php echo $msg_levels3; ?></a>
    <?php
    }
    ?>
    </span>
    <select name="order[]" style="margin:0 10px 0 0">
    <?php
    for ($i=1; $i<(mysql_num_rows($q_level)+1); $i++) {
    ?>
    <option value="<?php echo $i; ?>"<?php echo ($LEV->orderBy==$i ? ' selected="selected"' : ''); ?>><?php echo $i; ?></option>
    <?php
    }
    $whatsOn = array($msg_script5);
    if ($LEV->display=='yes') {
      $whatsOn[0] = $msg_script4;
    }
    ?>
    </select>
    <?php echo mswSpecialChars($LEV->name); ?>
    <span class="summary"><span class="count"><?php echo str_replace(array('{visible}','{id}'),array($whatsOn[0],($LEV->marker ? $LEV->marker : $LEV->id)),$msg_levels16); ?></span></span>
    <br class="clear" />
   </p>
   <?php
   }
   ?>
   <p class="buttonWrapper">
     <input type="hidden" name="update_order" value="1" />
     &nbsp;&nbsp;&nbsp;<input class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_levels8); ?>" title="<?php echo mswSpecialChars($msg_levels8); ?>" />
   </p>  
  </div>
</div>
</form>    
<?php
define('PER_PAGE',MAX_LEVEL_ENTRIES);
if ($countedRows>0 && $countedRows>MAX_LEVEL_ENTRIES) {
  $PTION = new pagination($countedRows,'?p='.$cmd.'&amp;next=');
  echo $PTION->display();
}
?>