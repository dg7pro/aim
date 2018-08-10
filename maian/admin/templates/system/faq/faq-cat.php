<?php if(!defined('PARENT')) { exit; } 
if (isset($_GET['edit'])) {
  $_GET['edit'] = (int)$_GET['edit'];
  $EDIT         = mswGetTableData('categories','id',$_GET['edit']);
}

if (isset($OK) || isset($REST)) {
  if (isset($REST)) {
    echo mswActionCompletedRestriction($msg_script22);
  } else {
    echo mswActionCompleted($msg_kbasecats);
  }
}

if (isset($OK2)) {
  echo mswActionCompleted($msg_kbasecats7);
}

if (isset($OK3)) {
  if ($count>0) {
    echo mswActionCompleted($msg_kbasecats12);
  }
}

if (isset($OK4)) {
  echo mswActionCompleted($msg_kbase30);
}

if (isset($OK5)) {
  echo mswActionCompleted($msg_kbase31);
}

if (isset($OK6)) {
  echo mswActionCompleted($msg_kbase34);
}

?>

<div id="headWrapper">
  
  <div id="message">
   <p><?php echo $msg_kbasecats9; ?></p>
  </div>
  
</div>

<div class="contentWrapper"> 
  
  <h2><?php echo (isset($EDIT->id) ? $msg_kbasecats5 : $msg_kbasecats2); ?></h2>
       
  <div class="formWrapper">     
       
    <form method="post" action="?p=faq-cat<?php echo (isset($_GET['edit']) ? '&amp;edit='.$_GET['edit'] : ''); ?>">
    <div class="doubleWrapper">
     <div class="formLeft" style="width:48%">
      <label><?php echo $msg_kbase17; ?> <?php echo mswDisplayHelpTip($msg_javascript55,'RIGHT'); ?></label>
      <input class="box" type="text" name="name" tabindex="<?php echo (++$tabIndex); ?>" maxlength="100" value="<?php echo (isset($EDIT->name) ? mswSpecialChars($EDIT->name) : ''); ?>" />
      <br class="clear" />
     </div>
    
     <div class="formRight" style="width:48%">
      <label><?php echo $msg_kbase15; ?> <?php echo mswDisplayHelpTip($msg_javascript56); ?></label>
      <input class="box" type="text" name="summary" tabindex="<?php echo (++$tabIndex); ?>" maxlength="250" value="<?php echo (isset($EDIT->summary) ? mswSpecialChars($EDIT->summary) : ''); ?>" />
      <br class="clear" />
     </div>
     <br class="clear" />
    </div> 
     
    <div class="doubleWrapper" style="margin-top:10px"> 
     <div class="formLeft" style="width:48%">
      <label><?php echo $msg_kbase38; ?> <?php echo mswDisplayHelpTip($msg_javascript157,'RIGHT'); ?></label>
      <select name="subcat">
       <option value="0"><?php echo $msg_kbase36; ?></option>
       <optgroup label="<?php echo mswSpecialChars($msg_kbase37); ?>">
       <?php
       $q_cat = mysql_query("SELECT * FROM ".DB_PREFIX."categories WHERE `subcat` = 0 ORDER BY `name`") 
               or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
       while ($CAT = mysql_fetch_object($q_cat)) {
       ?>
       <option<?php echo (isset($EDIT->id) && $EDIT->subcat==$CAT->id ? ' selected="selected" ' : ' '); ?>value="<?php echo $CAT->id; ?>"><?php echo mswCleanData($CAT->name); ?></option>
       <?php
       }
       ?>
       </optgroup>
      </select>
      <br class="clear" />
     </div>
     <div class="formRight" style="width:48%">
      <label><?php echo $msg_kbase24; ?> <?php echo mswDisplayHelpTip($msg_javascript107); ?></label>
      <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="enCat" value="yes"<?php echo (isset($EDIT->enCat) && $EDIT->enCat=='yes' ? ' checked="checked"' : (!isset($EDIT->enCat) ? ' checked="checked"' : '')); ?> /> <?php echo $msg_script5; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="enCat" value="no"<?php echo (isset($EDIT->enCat) && $EDIT->enCat=='no' ? ' checked="checked"' : ''); ?> />
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
    <p class="buttonWrapper">
     <input type="hidden" name="<?php echo (isset($EDIT->id) ? 'update' : 'process'); ?>" value="1" />
     <input class="button" type="submit" value="<?php echo mswSpecialChars((isset($EDIT->id) ? $msg_kbasecats5 : $msg_kbase16)); ?>" title="<?php echo mswSpecialChars((isset($EDIT->id) ? $msg_kbasecats5 : $msg_kbase16)); ?>" />
     <?php
     if (isset($EDIT->id)) {
     ?>
     <input class="cancelbutton" type="button" value="<?php echo mswSpecialChars($msg_kbasecats11); ?>" title="<?php echo mswSpecialChars($msg_kbasecats11); ?>" onclick="window.location='?p=faq-cat'" />
     <?php
     }
     ?>
    </p>
    </form>
  
  </div>
  
</div>   
        
<div class="contentWrapper"> 
  
  <?php
  $limit       = MAX_FAQCAT_ENTRIES;
  $limitvalue  = $page * $limit - ($limit);
  $q_cat       = mysql_query("SELECT SQL_CALC_FOUND_ROWS * FROM ".DB_PREFIX."categories WHERE `subcat` = '0' ORDER BY `orderBy` LIMIT $limitvalue,".MAX_FAQCAT_ENTRIES) 
                 or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $c            = mysql_fetch_object(mysql_query("SELECT FOUND_ROWS() AS rows"));
  $countedRows  =  (isset($c->rows) ? $c->rows : '0');
  
  ?>
  
  <h2><?php echo $msg_kbasecats4; ?> (<?php echo $countedRows; ?>)</h2>
  
  <form method="post" id="form" action="index.php?p=faq-cat<?php echo (isset($_GET['edit']) ? '&amp;edit='.$_GET['edit'] : ''); ?>" onsubmit="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')">
  <div id="dataWrapper">
   <?php
   if (mysql_num_rows($q_cat)>0) {
   while ($CAT = mysql_fetch_object($q_cat)) {
   $q_sat  = mysql_query("SELECT * FROM ".DB_PREFIX."categories WHERE `subcat` = '{$CAT->id}' ORDER BY `orderBy`") 
             or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
   ?>
   <div class="dataBlock">
    <input type="hidden" name="order_id[]" value="<?php echo $CAT->id; ?>" />
    <span class="float">
    <a class="edit" href="?p=faq-cat&amp;edit=<?php echo $CAT->id; ?>" title="<?php echo mswSpecialChars($msg_kbasecats6); ?>"><?php echo $msg_kbasecats6; ?></a>
    <?php
    if (USER_DEL_PRIV=='yes') {
    ?>
    <a class="delete" href="?p=faq-cat&amp;delete=<?php echo $CAT->id; ?>" title="<?php echo mswSpecialChars($msg_kbasecats3); ?>" onclick="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')"><?php echo $msg_kbasecats3; ?></a>
    <?php
    }
    ?>
    </span>
    <input type="checkbox" name="id[]" value="<?php echo $CAT->id; ?>" id="cat_<?php echo $CAT->id; ?>" />&nbsp;&nbsp;&nbsp;<select name="order[]" style="margin:0 10px 0 0">
    <?php
    for ($i=1; $i<(mysql_num_rows($q_cat)+1); $i++) {
    ?>
    <option value="<?php echo $i; ?>"<?php echo ($CAT->orderBy==$i ? ' selected="selected"' : ''); ?>><?php echo $i; ?></option>
    <?php
    }
    ?>
    </select><?php echo mswSpecialChars($CAT->name).($CAT->enCat=='no' ? '&nbsp;&nbsp;&nbsp;<span class="highlight_italic">'.$msg_kbase25.'</span>' : ''); ?>
    <br class="clear" />
    <?php
    // Sub categories..
    while ($SCAT = mysql_fetch_object($q_sat)) {
    ?>
    <p class="dataBlockSub">
    <input type="hidden" name="order_id[]" value="<?php echo $SCAT->id; ?>" />
    <span class="float">
    <a class="edit" href="?p=faq-cat&amp;edit=<?php echo $SCAT->id; ?>" title="<?php echo mswSpecialChars($msg_kbasecats6); ?>"><?php echo $msg_kbasecats6; ?></a>
    <?php
    if (USER_DEL_PRIV=='yes') {
    ?>
    <a class="delete" href="?p=faq-cat&amp;delete=<?php echo $SCAT->id; ?>" title="<?php echo mswSpecialChars($msg_kbasecats3); ?>" onclick="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')"><?php echo $msg_kbasecats3; ?></a>
    <?php
    }
    ?>
    </span>
    <input type="checkbox" name="id[]" value="<?php echo $SCAT->id; ?>" id="cat_<?php echo $SCAT->id; ?>" />&nbsp;&nbsp;&nbsp;<select name="order[]" style="margin:0 10px 0 0">
    <?php
    for ($i=1; $i<(mysql_num_rows($q_sat)+1); $i++) {
    ?>
    <option value="<?php echo $i; ?>"<?php echo ($SCAT->orderBy==$i ? ' selected="selected"' : ''); ?>><?php echo $i; ?></option>
    <?php
    }
    ?>
    </select><?php echo mswSpecialChars($SCAT->name).($SCAT->enCat=='no' ? '&nbsp;&nbsp;&nbsp;<span class="highlight_italic">'.$msg_kbase25.'</span>' : ''); ?>
    </p>
    <?php
    }
    ?>
   </div>
   <?php
   }
   ?>
   <p class="buttonWrapper" style="padding-left:5px">
     <input type="hidden" name="endis" value="1" />
     <input type="checkbox" name="endis" value="all" onclick="if(this.checked){checkBoxes('on','form')}else{checkBoxes('off','form')}" />
     &nbsp;&nbsp;&nbsp;<input name="enable" class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_kbase28); ?>" title="<?php echo mswSpecialChars($msg_kbase28); ?>" />
     &nbsp;&nbsp;&nbsp;<input name="disable" class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_kbase29); ?>" title="<?php echo mswSpecialChars($msg_kbase29); ?>" />
     &nbsp;&nbsp;&nbsp;<input class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_kbase35); ?>" title="<?php echo mswSpecialChars($msg_kbase35); ?>" />
   </p>
   <?php
   } else {
   ?>
   <p class="nodata"><?php echo $msg_kbasecats8; ?></p>
   <?php
   }
   ?>
  </div>
  </form>
</div>    
<?php
define('PER_PAGE',MAX_FAQCAT_ENTRIES);
if ($countedRows>0 && $countedRows>MAX_FAQCAT_ENTRIES) {
  $PTION = new pagination($countedRows,'?p='.$cmd.'&amp;next=');
  echo $PTION->display();
}
?>