<?php if(!defined('PARENT')) { exit; } 
if (isset($_GET['edit'])) {
  $_GET['edit']  = (int)$_GET['edit'];
  $EDIT          = mswGetTableData('faqattach','id',$_GET['edit']);
}

if (isset($OK)) {
  echo mswActionCompleted(str_replace('{count}',$count,$msg_attachments10));
}

if (isset($OK2)) {
  echo mswActionCompleted($msg_attachments13);
}

if (isset($OK3) && $cnt>0) {
  echo mswActionCompleted($msg_attachments14);
}

?>

<div id="headWrapper">
  
  <div id="message">
   <p><?php echo $msg_attachments; ?></p>
  </div>
  
</div>

<div class="contentWrapper"> 
  
  <?php
  if (isset($EDIT->id)) {
  ?>
  <h2><?php echo $msg_attachments12; ?></h2>
  <?php
  } else {
  ?>
  <h2><span class="float"><a href="#" onclick="faqAttachBox('add');return false"><img src="templates/images/add-attachment.png" title="<?php echo mswSpecialChars($msg_attachments6); ?>" alt="<?php echo mswSpecialChars($msg_attachments6); ?>" /></a> <a href="#" onclick="faqAttachBox('remove');return false"><img src="templates/images/rem-attachment.png" title="<?php echo mswSpecialChars($msg_attachments7); ?>" alt="<?php echo mswSpecialChars($msg_attachments7); ?>" /></a></span><?php echo $msg_attachments2; ?></h2>
  <?php
  }
  ?>   
  <div class="formWrapper" id="faqAttachArea"> 
  
    <form method="post" action="index.php?p=attachments<?php echo (isset($_GET['edit']) ? '&amp;edit='.$_GET['edit'] : ''); ?>" enctype="multipart/form-data">
    
    <div class="doubleWrapper" style="margin-bottom:10px">
     <div class="formLeft" style="width:33%">
      <label><?php echo $msg_attachments3; ?> <?php echo mswDisplayHelpTip($msg_javascript161,'RIGHT'); ?></label>
      <input type="text" class="box" name="name[]" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo (isset($EDIT->name) ? mswSpecialChars($EDIT->name) : ''); ?>" />
      <br class="clear" />
     </div>
     
     <div class="formLeft" style="width:33%">
      <label><?php echo $msg_attachments4; ?> <?php echo mswDisplayHelpTip($msg_javascript162); ?></label>
      <input type="text" class="filebox" name="remote[]" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo (isset($EDIT->remote) ? mswSpecialChars($EDIT->remote) : ''); ?>" />
      <br class="clear" />
     </div>
    
     <div class="formRight" style="width:33%">
      <label><?php echo $msg_attachments5; ?> <?php echo mswDisplayHelpTip($msg_javascript163,'LEFT'); ?></label>
      <input type="file" class="filebox" name="file[]" tabindex="<?php echo (++$tabIndex); ?>" value="" />
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
    <p class="buttonWrapper"> 
     <input type="hidden" name="<?php echo (isset($EDIT->id) ? 'update' : 'process'); ?>" value="1" />
     <input type="hidden" name="old_path" value="<?php echo (isset($EDIT->path) ? $EDIT->path : ''); ?>" />
     <input type="hidden" name="old_size" value="<?php echo (isset($EDIT->size) ? $EDIT->size : ''); ?>" />
     <input class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars((isset($EDIT->id) ? $msg_attachments12 : $msg_attachments2)); ?>" title="<?php echo mswSpecialChars((isset($EDIT->id) ? $msg_attachments12 : $msg_attachments2)); ?>" />
     <?php
     if (isset($EDIT->id)) {
     ?>
     <input class="cancelbutton" type="button" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_kbasecats11); ?>" title="<?php echo mswSpecialChars($msg_kbasecats11); ?>" onclick="window.location='?p=attachments'" />
     <?php
     }
     ?>
    </p> 
    
    </form>
    
  </div>
  
</div>  

<div class="contentWrapper"> 
  
  <?php
  $limit       = MAX_FAQATT_ENTRIES;
  $limitvalue  = $page * $limit - ($limit);
  $q_att       = mysql_query("SELECT SQL_CALC_FOUND_ROWS * FROM ".DB_PREFIX."faqattach ORDER BY `name` LIMIT $limitvalue,".MAX_FAQATT_ENTRIES) 
                 or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $c            = mysql_fetch_object(mysql_query("SELECT FOUND_ROWS() AS rows"));
  $countedRows  =  (isset($c->rows) ? $c->rows : '0');
  ?>
  
  <h2><?php echo $msg_attachments8; ?> (<?php echo $countedRows; ?>)</h2>
  
  <div id="dataWrapper">
   <?php
   if (mysql_num_rows($q_att)>0) {
   while ($ATT = mysql_fetch_object($q_att)) {
   $ext = substr(strrchr(($ATT->path ? $ATT->path : $ATT->remote), '.'),1);
   ?>
   <p class="dataBlock">
    <span class="float">
    <a class="preview" href="<?php echo ($ATT->remote ? $ATT->remote : '../templates/attachments/faq/'.$ATT->path); ?>" onclick="window.open(this);return false"><?php echo $msg_kbase12; ?></a>
    <a class="edit" href="?p=attachments&amp;edit=<?php echo $ATT->id; ?>" title="<?php echo mswSpecialChars($msg_kbasecats6); ?>"><?php echo $msg_kbasecats6; ?></a>
    <?php
    if (USER_DEL_PRIV=='yes') {
    ?>
    <a class="delete" href="?p=attachments&amp;delete=<?php echo $ATT->id; ?>&amp;file=<?php echo $ATT->path; ?>" title="<?php echo mswSpecialChars($msg_kbasecats3); ?>" onclick="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')"><?php echo $msg_kbasecats3; ?></a>
    <?php
    }
    ?>
    </span>
    <?php echo ($ATT->name ? mswSpecialChars($ATT->name) : $ATT->path); ?>
    <span class="summary"><span class="count">
     <?php echo str_replace(
                 array(
                  '{type}',
                  '{size}',
                  '{questions}'
                 ),
                 array(
                  strtoupper($ext),
                  ($ATT->size>0 ? mswFileSizeConversion($ATT->size) : 'N/A'),
                  mswRowCount('faqattassign WHERE `attachment` = \''.$ATT->id.'\'')
                ),
                $msg_attachments11); 
     ?>
    </span></span>
    <br class="clear" />
   </p>
   <?php
   }
   } else {
   ?>
   <p class="nodata"><?php echo $msg_attachments9; ?></p>
   <?php
   }
   ?>
  </div>

</div> 
<?php
define('PER_PAGE',MAX_FAQATT_ENTRIES);
if ($countedRows>0 && $countedRows>MAX_FAQATT_ENTRIES) {
  $PTION = new pagination($countedRows,'?p='.$cmd.'&amp;next=');
  echo $PTION->display();
}
?>