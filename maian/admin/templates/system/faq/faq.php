<?php if(!defined('PARENT')) { exit; } 
if (isset($_GET['edit'])) {
  $_GET['edit']  = (int)$_GET['edit'];
  $EDIT          = mswGetTableData('faq','id',$_GET['edit']);
}

if (isset($OK)) {
  echo mswActionCompleted($msg_kbase7);
}

if (isset($OK2)) {
  echo mswActionCompleted($msg_kbase8);
}

if (isset($OK3)) {
  if ($count>0) {
    echo mswActionCompleted($msg_kbase10);
  }
}

if (isset($OK4)) {
  echo mswActionCompleted($msg_kbase22);
}

if (isset($OK5)) {
  echo mswActionCompleted($msg_kbase32);
}

if (isset($OK6)) {
  echo mswActionCompleted($msg_kbase33);
}

?>

<div id="headWrapper">
  
  <div id="message">
   <p><?php echo $msg_kbase14; ?></p>
  </div>
  
</div>

<div class="contentWrapper"> 
  
  <h2><?php echo (isset($EDIT->id) ? $msg_kbase13 : $msg_kbase3); ?></h2>
       
  <div class="formWrapper"> 
  
    <form method="post" action="index.php?p=faq<?php echo (isset($_GET['edit']) ? '&amp;edit='.$_GET['edit'] : ''); ?>">
    
    <div class="doubleWrapper">
     <div class="formLeft" style="width:40%">
      <label><?php echo $msg_kbase; ?> <?php echo mswDisplayHelpTip($msg_javascript24,'RIGHT'); ?></label>
      <input type="text" class="box" name="question" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo (isset($EDIT->id) ? mswSpecialChars($EDIT->question) : ''); ?>" />
      <br class="clear" />
     </div>
    
     <div class="formLeft" style="width:35%">
      <label><?php echo $msg_kbase5; ?> <?php echo mswDisplayHelpTip($msg_javascript25); ?></label>
      <select name="cat" tabindex="<?php echo (++$tabIndex); ?>">
      <option value="0"><?php echo $msg_kbase6; ?></option>
      <?php
      $q_cat = mysql_query("SELECT * FROM ".DB_PREFIX."categories WHERE `subcat` = '0' ORDER BY `name`") 
               or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      while ($CAT = mysql_fetch_object($q_cat)) {
      ?>
      <option<?php echo (isset($EDIT->id) && $EDIT->category==$CAT->id ? ' selected="selected" ' : ' '); ?>value="<?php echo $CAT->id; ?>"><?php echo mswCleanData($CAT->name); ?></option>
      <?php
      $q_cat2 = mysql_query("SELECT * FROM ".DB_PREFIX."categories WHERE `subcat` = '{$CAT->id}' ORDER BY `name`") 
               or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      while ($SUB = mysql_fetch_object($q_cat2)) {
      ?>
      <option<?php echo (isset($EDIT->id) && $EDIT->category==$SUB->id ? ' selected="selected" ' : ' '); ?>value="<?php echo $SUB->id; ?>">- <?php echo mswCleanData($SUB->name); ?></option>
      <?php
      }
      }
      ?>
      </select>
      <br class="clear" />
     </div>
     
     <div class="formRight" style="width:20%">
      <label><?php echo $msg_kbase39; ?> <?php echo mswDisplayHelpTip($msg_javascript125,'LEFT'); ?></label>
      <?php echo $msg_kbase28; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="enFaq" value="yes"<?php echo (isset($EDIT->enFaq) && $EDIT->enFaq=='yes' ? ' checked="checked"' : (!isset($EDIT->enFaq) ? ' checked="checked"' : '')); ?> /> <?php echo $msg_kbase29; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="enFaq" value="no"<?php echo (isset($EDIT->enFaq) && $EDIT->enFaq=='no' ? ' checked="checked"' : ''); ?> />
      <br class="clear" />
     </div>
     
     <br class="clear" />
    </div>
    
    <div class="answer">
     <label>
     <?php
     echo $msg_kbase2; ?> <?php echo mswDisplayHelpTip($msg_javascript26,'RIGHT'); 
     ?>
     </label>
     <?php
     if ($SETTINGS->enableBBCode=='yes') {
       define('BB_BOX','answer');
       include(PATH.'templates/system/bbcode-buttons.php');
     }
     ?>
     <textarea rows="8" cols="40" name="answer" id="answer" tabindex="<?php echo (++$tabIndex); ?>"><?php echo (isset($EDIT->id) ? mswSpecialChars($EDIT->answer) : ''); ?></textarea>
     <?php
     $howManyAtt = mswRowCount('faqattach');
     if ($howManyAtt>0) {
     ?>
     <div id="attachments" class="faqAttachments">
      <div id="attach-display"></div>
      <h2 id="h2A" title="<?php echo mswSpecialChars($msg_attachments15); ?>" onclick="showFAQAttachments('<?php echo (isset($EDIT->id) ? $EDIT->id : '0'); ?>')"><span id="signal">[+]</span> <?php echo $msg_adheader33; ?> (<?php echo $howManyAtt; ?>)</h2>
     </div>
     <?php
     }
     ?>
    </div>
    
    <p class="buttonWrapper"> 
     <input type="hidden" name="<?php echo (isset($EDIT->id) ? 'update' : 'process'); ?>" value="1" />
     <input class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars((isset($EDIT->id) ? $msg_kbase13 : $msg_kbase3)); ?>" title="<?php echo mswSpecialChars((isset($EDIT->id) ? $msg_kbase13 : $msg_kbase3)); ?>" />
     <input onclick="ms_ticketPreview('faq','answer')" class="button" type="button" value="<?php echo mswSpecialChars($msg_kbase26); ?>" title="<?php echo mswSpecialChars($msg_kbase26); ?>" style="margin-left:30px" />
     <?php
     if (isset($EDIT->id)) {
     ?>
     <input class="cancelbutton" type="button" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_kbasecats11); ?>" title="<?php echo mswSpecialChars($msg_kbasecats11); ?>" onclick="window.location='?p=faq'" />
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
  $limit       = MAX_FAQ_ENTRIES;
  $limitvalue  = $page * $limit - ($limit);
  if (isset($_GET['cat'])) {
    $_GET['cat']  = (int)$_GET['cat'];
    $SQL          = 'WHERE `category` = \''.$_GET['cat'].'\'';
  }
  $q_kbase = mysql_query("SELECT SQL_CALC_FOUND_ROWS * 
             FROM ".DB_PREFIX."faq
             $SQL
             ORDER BY `question`
             LIMIT $limitvalue,".MAX_FAQ_ENTRIES."
             ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $c            = mysql_fetch_object(mysql_query("SELECT FOUND_ROWS() AS rows"));
  $countedRows  =  (isset($c->rows) ? $c->rows : '0');
  ?>
  
  <h2 style="text-align:right">
   <span style="float:left">
   <?php
   echo $msg_kbase4; 
   ?> (<?php echo $countedRows; ?>)
   </span>
   <select onchange="if(this.value!= 0){location=this.options[this.selectedIndex].value}">
    <option value="?p=faq"<?php echo (isset($_GET['cat']) && $_GET['cat']=='0' ? ' selected="selected" ' : ' '); ?>><?php echo $msg_kbase6; ?></option>
    <?php
    $q_cat = mysql_query("SELECT * FROM ".DB_PREFIX."categories WHERE `subcat` = '0' ORDER BY `name`") 
             or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    while ($CAT = mysql_fetch_object($q_cat)) {
    ?>
    <option<?php echo (isset($_GET['cat']) && $_GET['cat']==$CAT->id ? ' selected="selected" ' : ' '); ?>value="?p=faq&amp;cat=<?php echo $CAT->id; ?>"><?php echo mswSpecialChars($CAT->name); ?></option>
    <?php
    $q_cat2 = mysql_query("SELECT * FROM ".DB_PREFIX."categories WHERE `subcat` = '{$CAT->id}' ORDER BY `name`") 
              or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    while ($SUB = mysql_fetch_object($q_cat2)) {
    ?>
    <option<?php echo (isset($_GET['cat']) && $_GET['cat']==$SUB->id ? ' selected="selected" ' : ' '); ?>value="?p=faq&amp;cat=<?php echo $SUB->id; ?>">- <?php echo mswCleanData($SUB->name); ?></option>
    <?php
    }
    }
    ?>
   </select>
  </h2>
  
  <form method="post" id="form" action="index.php?p=faq<?php echo (isset($_GET['edit']) ? '&amp;edit='.$_GET['edit'] : ''); ?>" onsubmit="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')">
  <div id="dataWrapper">
   <?php
   if (mysql_num_rows($q_kbase)>0) {
   while ($KB = mysql_fetch_object($q_kbase)) {
   $yes  = ($KB->kviews>0 ? @number_format($KB->kuseful/$KB->kviews*100,VOTING_DECIMAL_PLACES) : 0);
   $no   = ($KB->kviews>0 ? @number_format($KB->knotuseful/$KB->kviews*100,VOTING_DECIMAL_PLACES) : 0);
   ?>
   <p class="dataBlock">
    <span class="float">
    <a class="preview" href="?p=faq&amp;view=<?php echo $KB->id; ?>" title="<?php echo mswSpecialChars($msg_kbase12); ?>" onclick="$.GB_hide();$.GB_show(this.href, {height: <?php echo GREYBOX_HEIGHT; ?>,width: <?php echo GREYBOX_WIDTH; ?>,caption: this.title,close_text: '<?php echo str_replace(array('\'','&#039;'),array(),mswSpecialChars($msg_javascript3)); ?>'});return false;"><?php echo $msg_kbase12; ?></a>
    <a class="edit" href="?p=faq&amp;edit=<?php echo $KB->id; ?>" title="<?php echo mswSpecialChars($msg_kbasecats6); ?>"><?php echo $msg_kbasecats6; ?></a>
    <?php
    if (USER_DEL_PRIV=='yes') {
    ?>
    <a class="delete" href="?p=faq&amp;delete=<?php echo $KB->id; ?>" title="<?php echo mswSpecialChars($msg_kbasecats3); ?>" onclick="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')"><?php echo $msg_kbasecats3; ?></a>
    <?php
    }
    ?>
    </span>
    <input type="checkbox" name="id[]" value="<?php echo $KB->id; ?>" id="que_<?php echo $KB->id; ?>" /> <?php echo mswSpecialChars($KB->question).($KB->enFaq=='no' ? '&nbsp;&nbsp;&nbsp;<span class="highlight_italic">'.$msg_kbase25.'</span>' : ''); ?>
    <span class="summary"><span class="count"><?php echo str_replace(array('{count}','{helpful}','{nothelpful}','{cat}'),array($KB->kviews,$yes,$no,mswSpecialChars(mswFaqCat($KB->category))),$msg_kbase18); ?></span></span>
    <br class="clear" />
   </p>
   <?php
   }
   ?>
   <p class="buttonWrapper" style="padding-left:5px">
     <input type="hidden" name="reset" value="1" />
     <input type="checkbox" name="reset" value="all" onclick="if(this.checked){checkBoxes('on','form')}else{checkBoxes('off','form')}" />&nbsp;&nbsp;&nbsp;<input class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_kbase27); ?>" title="<?php echo mswSpecialChars($msg_kbase27); ?>" />
     &nbsp;&nbsp;&nbsp;<input name="enable" class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_kbase28); ?>" title="<?php echo mswSpecialChars($msg_kbase28); ?>" />
     &nbsp;&nbsp;&nbsp;<input name="disable" class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_kbase29); ?>" title="<?php echo mswSpecialChars($msg_kbase29); ?>" />
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
define('PER_PAGE',MAX_FAQ_ENTRIES);
if ($countedRows>0 && $countedRows>MAX_FAQ_ENTRIES) {
  $PTION = new pagination($countedRows,'?p='.$cmd.'&amp;next=');
  echo $PTION->display();
}
?>