<?php if(!defined('PARENT')) { exit; } 

if (isset($_GET['edit'])) {
  $_GET['edit']  = (int)$_GET['edit'];
  $EDIT          = mswGetTableData('imap','id',$_GET['edit']);
}

if (isset($OK)) {
  echo mswActionCompleted($msg_imap22);
}

if (isset($OK2)) {
  echo mswActionCompleted($msg_imap23);
}

if (isset($OK3)) {
  if ($count>0) {
    echo mswActionCompleted($msg_imap24);
  }
}

if (isset($OK4)) {
  echo mswActionCompleted($msg_imap26);
}

if (isset($OK5)) {
  echo mswActionCompleted($msg_imap27);
}

?>

<div id="headWrapper">
  
  <div id="message">
   <p><?php echo $msg_imap2; ?></p>
  </div>
  
</div>

<form method="post" action="index.php?p=imap<?php echo (isset($_GET['edit']) ? '&amp;edit='.$_GET['edit'] : ''); ?>">

<div class="contentWrapper"> 
  
  <h2><?php echo (isset($EDIT->id) ? $msg_imap25 : $msg_imap); ?></h2>
       
  <div class="formWrapper"> 
  
    <div class="doubleWrapper">
     <div class="formLeft">
      <label><?php echo $msg_imap3; ?> <?php echo mswDisplayHelpTip($msg_javascript80,'RIGHT'); ?></label>
      <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="im_piping" value="yes"<?php echo (isset($EDIT->im_piping) && $EDIT->im_piping=='yes' ? ' checked="checked"' : (!isset($EDIT->im_piping) ? ' checked="checked"' : '')); ?> /> <?php echo $msg_script5; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="im_piping" value="no"<?php echo (isset($EDIT->im_piping) && $EDIT->im_piping=='no' ? ' checked="checked"' : ''); ?> />
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <label><?php echo $msg_imap4; ?> <?php echo mswDisplayHelpTip($msg_javascript81,'LEFT'); ?></label>
      <?php echo $msg_imap5; ?> <input onclick="ms_imapOptions('pop3')" type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="im_protocol" value="pop3"<?php echo (isset($EDIT->im_protocol) && $EDIT->im_protocol=='pop3' ? ' checked="checked"' : ''); ?> /> <?php echo $msg_imap6; ?> <input onclick="ms_imapOptions('imap')" tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="im_protocol" value="imap"<?php echo (isset($EDIT->im_protocol) && $EDIT->im_protocol=='imap' ? ' checked="checked"' : (!isset($EDIT->im_protocol) ? ' checked="checked"' : '')); ?> />
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
    <div class="doubleWrapper" style="margin-top:10px">
     <div class="formLeft">
      <label><?php echo $msg_imap7; ?> <?php echo mswDisplayHelpTip($msg_javascript82,'RIGHT'); ?></label>
      <input type="text" class="box" maxlength="100" name="im_host" id="im_host" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo (isset($EDIT->im_host) ? $EDIT->im_host : ''); ?>" />
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <label><?php echo $msg_imap8; ?> <?php echo mswDisplayHelpTip($msg_javascript83,'LEFT'); ?></label>
      <input type="text" class="box" maxlength="250" name="im_user" id="im_user" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo (isset($EDIT->im_user) ? $EDIT->im_user : ''); ?>" />
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
    <div class="doubleWrapper" style="margin-top:10px">
     <div class="formLeft">
      <label><?php echo $msg_imap9; ?> <?php echo mswDisplayHelpTip($msg_javascript84,'RIGHT'); ?></label>
      <input type="password" class="box" maxlength="100" name="im_pass" id="im_pass" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo (isset($EDIT->im_pass) ? $EDIT->im_pass : ''); ?>" />
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <label><?php echo $msg_imap10; ?> <?php echo mswDisplayHelpTip($msg_javascript85,'LEFT'); ?></label>
      <input type="text" class="smallbox" maxlength="5" name="im_port" id="im_port" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo (isset($EDIT->im_port) ? $EDIT->im_port : '143'); ?>" />
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
    <div class="doubleWrapper" style="margin-top:10px">
     <div class="formLeft">
      <label><?php echo $msg_imap11; ?> <?php echo mswDisplayHelpTip($msg_javascript86,'RIGHT'); ?></label>
      <input type="text" class="box" name="im_name" id="im_name" style="width:40%" maxlength="50" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo (isset($EDIT->im_name) ? $EDIT->im_name : 'inbox'); ?>" /> <a class="showFolders" href="#" onclick="if(folderCheck()){ms_showImapFolders('mailbox');return false;}else{alert('<?php echo mswSpecialChars($msg_javascript146); ?>');return false;}" title="<?php echo mswSpecialChars($msg_imap31); ?>"><?php echo $msg_imap31; ?></a>
      <div class="folderDisplay" id="nameFolders">
      </div>  
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <label><a href="http://www.php.net/manual/en/function.imap-open.php" onclick="window.open(this);return false" title="<?php echo mswSpecialChars($msg_imap12); ?>"><?php echo $msg_imap12; ?></a> <?php echo mswDisplayHelpTip($msg_javascript87,'LEFT'); ?></label>
      <input type="text" class="box" name="im_flags" id="im_flags" maxlength="250" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo (isset($EDIT->im_flags) ? $EDIT->im_flags : '/novalidate-cert'); ?>" />
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
    <div class="doubleWrapper" style="margin-top:10px">
     <div class="formLeft">
      <label><?php echo $msg_imap13; ?> <?php echo mswDisplayHelpTip($msg_javascript88,'RIGHT'); ?></label>
      <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="im_attach" value="yes"<?php echo (isset($EDIT->im_attach) && $EDIT->im_attach=='yes' ? ' checked="checked"' : ''); ?> /> <?php echo $msg_script5; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="im_attach" value="no"<?php echo (isset($EDIT->im_attach) && $EDIT->im_attach=='no' ? ' checked="checked"' : (!isset($EDIT->im_attach) ? ' checked="checked"' : '')); ?> />
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <label><?php echo $msg_imap14; ?> <?php echo mswDisplayHelpTip($msg_javascript89,'LEFT'); ?></label>
      <input type="text" class="box" maxlength="50" style="width:40%" tabindex="<?php echo (++$tabIndex); ?>" name="im_move" id="im_move" value="<?php echo (isset($EDIT->im_move) ? $EDIT->im_move : ''); ?>" /> <a class="showFolders" href="#" onclick="if(folderCheck()){ms_showImapFolders('move');return false;}else{alert('<?php echo mswSpecialChars($msg_javascript146); ?>');return false;}" title="<?php echo mswSpecialChars($msg_imap31); ?>"><?php echo $msg_imap31; ?></a>
      <div class="folderDisplay" id="moveFolders">
      </div>
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
    <div class="doubleWrapper">
     <div class="formLeft">
      <label><?php echo $msg_imap15; ?> <?php echo mswDisplayHelpTip($msg_javascript90,'RIGHT'); ?></label>
      <input type="text" class="smallbox" maxlength="3" tabindex="<?php echo (++$tabIndex); ?>" name="im_messages" value="<?php echo (isset($EDIT->im_messages) ? $EDIT->im_messages : '50'); ?>" />
      <br class="clear" />
     </div>
    
     <div class="formRight" style="margin-top:10px">
      <label><?php echo $msg_imap16; ?> <?php echo mswDisplayHelpTip($msg_javascript91,'LEFT'); ?></label>
      <?php echo $msg_script4; ?> <input type="radio" tabindex="<?php echo (++$tabIndex); ?>" name="im_ssl" value="yes"<?php echo (isset($EDIT->im_ssl) && $EDIT->im_ssl=='yes' ? ' checked="checked"' : ''); ?> /> <?php echo $msg_script5; ?> <input tabindex="<?php echo (++$tabIndex); ?>" type="radio" name="im_ssl" value="no"<?php echo (isset($EDIT->im_ssl) && $EDIT->im_ssl=='no' ? ' checked="checked"' : (!isset($EDIT->im_ssl) ? ' checked="checked"' : '')); ?> />
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
    <div class="doubleWrapper" style="margin-top:10px">
     <div class="formLeft">
      <label><?php echo $msg_imap17; ?> <?php echo mswDisplayHelpTip($msg_javascript92,'RIGHT'); ?></label>
      <select name="im_dept" tabindex="<?php echo (++$tabIndex); ?>">
      <?php
      $q_dept = mysql_query("SELECT * FROM ".DB_PREFIX."departments ORDER BY `name`") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      while ($DEPT = mysql_fetch_object($q_dept)) {
      ?>
      <option value="<?php echo $DEPT->id; ?>"<?php echo (isset($EDIT->im_dept) && $EDIT->im_dept==$DEPT->id ? ' selected="selected"' : ''); ?>><?php echo mswSpecialChars($DEPT->name); ?></option>
      <?php
      }
      ?>
      </select>
      <br class="clear" />
     </div>
     
     <div class="formRight">
      <label><?php echo $msg_imap18; ?> <?php echo mswDisplayHelpTip($msg_javascript93,'LEFT'); ?></label>
      <select name="im_priority" tabindex="<?php echo (++$tabIndex); ?>">
      <?php
      foreach ($ticketLevelSel AS $k => $v) {
      ?>
      <option value="low"<?php echo (isset($EDIT->im_priority) && $EDIT->im_priority==$k ? ' selected="selected"' : ''); ?>><?php echo $v; ?></option>
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
      <label><?php echo $msg_imap19; ?> <?php echo mswDisplayHelpTip($msg_javascript102,'RIGHT'); ?></label>
      <input type="text" class="box" maxlength="250" name="im_email" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars(isset($EDIT->im_email) ? $EDIT->im_email : ''); ?>" />
      <br class="clear" />
     </div>
    
     <div class="formRight">
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>     
    
    <p class="buttonWrapper" style="padding:10px 0 20px 0"> 
     <input type="hidden" name="<?php echo (isset($EDIT->id) ? 'update' : 'process'); ?>" value="1" />
     <input class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars((isset($EDIT->id) ? $msg_imap25 : $msg_imap)); ?>" title="<?php echo mswSpecialChars((isset($EDIT->id) ? $msg_imap25 : $msg_imap)); ?>" />
     <?php
     if (isset($EDIT->id)) {
     ?>
     <input class="cancelbutton" type="button" value="<?php echo mswSpecialChars($msg_dept11); ?>" title="<?php echo mswSpecialChars($msg_dept11); ?>" onclick="window.location='?p=imap'" />
     <?php
     }
     ?>
    </p>  
    
  </div>
  
</div>   

</form>

<div class="contentWrapper"> 
  
  <?php
  $limit       = MAX_IMAP_ENTRIES;
  $limitvalue  = $page * $limit - ($limit);
  $q_imap = mysql_query("SELECT SQL_CALC_FOUND_ROWS * FROM ".DB_PREFIX."imap ORDER BY `im_host`,`im_name` LIMIT $limitvalue,".MAX_IMAP_ENTRIES) 
            or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $c            = mysql_fetch_object(mysql_query("SELECT FOUND_ROWS() AS rows"));
  $countedRows  =  (isset($c->rows) ? $c->rows : '0');
  ?> 
  
  <h2><?php echo $msg_imap20; ?> (<?php echo $countedRows; ?>)</h2>
  
  <form method="post" id="form" action="index.php?p=imap<?php echo (isset($_GET['edit']) ? '&amp;edit='.$_GET['edit'] : ''); ?>" onsubmit="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')">
  <div id="dataWrapper">
   <?php
   if (mysql_num_rows($q_imap)>0) {
   while ($IMAP = mysql_fetch_object($q_imap)) {
   ?>
   <p class="dataBlock">
    <span class="float">
    <a class="checkmail" href="../?<?php echo IMAP_URL_PARAMETER.'='.$IMAP->id; ?>" title="<?php echo mswSpecialChars($msg_imap29); ?>" onclick="window.open(this);return false"><?php echo $msg_imap29; ?></a>
    <a class="edit" href="?p=imap&amp;edit=<?php echo $IMAP->id; ?>" title="<?php echo mswSpecialChars($msg_dept6); ?>"><?php echo $msg_dept6; ?></a>
    <?php
    if (USER_DEL_PRIV=='yes') {
    ?>
    <a class="delete" href="?p=imap&amp;delete=<?php echo $IMAP->id; ?>" title="<?php echo mswSpecialChars($msg_dept3); ?>" onclick="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')"><?php echo $msg_dept3; ?></a>
    <?php
    }
    ?>
    </span>
    <input type="checkbox" name="id[]" value="<?php echo $IMAP->id; ?>" id="imap_<?php echo $IMAP->id; ?>" />&nbsp;&nbsp;<?php echo '<span class="id">('.$msg_imap28.': '.$IMAP->id.')</span>&nbsp;&nbsp;'.mswSpecialChars($IMAP->im_host.' / '.$IMAP->im_user.' / '.strtoupper(($IMAP->im_protocol=='pop3' ? $msg_imap5 : $msg_imap6)).' / '.$IMAP->im_port).($IMAP->im_piping=='no' ? '&nbsp;&nbsp;&nbsp;<span class="highlight_italic">'.$msg_kbase25.'</span>' : ''); ?>
    <span class="summary"><span class="count">(<?php echo str_replace(array('{dept}','{attach}'),array(mswSpecialChars(mswSrCat($IMAP->im_dept)),($IMAP->im_attach=='yes' ? $msg_script4 : $msg_script5)),$msg_imap30); ?>)</span></span>
    <br class="clear" />
   </p>
   <?php
   }
   ?>
   <p class="buttonWrapper" style="padding-left:5px">
     <input type="hidden" name="endis" value="1" />
     <input type="checkbox" name="reset" value="all" onclick="if(this.checked){checkBoxes('on','form')}else{checkBoxes('off','form')}" />&nbsp;&nbsp;&nbsp;<input name="enable" class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_kbase28); ?>" title="<?php echo mswSpecialChars($msg_kbase28); ?>" />
     &nbsp;&nbsp;&nbsp;<input name="disable" class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_kbase29); ?>" title="<?php echo mswSpecialChars($msg_kbase29); ?>" />
   </p>
   <?php
   } else {
   ?>
   <p class="nodata"><?php echo $msg_imap21; ?></p>
   <?php
   }
   ?>
  </div>
  </form>
  
</div> 
<?php
define('PER_PAGE',MAX_IMAP_ENTRIES);
if ($countedRows>0 && $countedRows>MAX_IMAP_ENTRIES) {
  $PTION = new pagination($countedRows,'?p='.$cmd.'&amp;next=');
  echo $PTION->display();
}
?>