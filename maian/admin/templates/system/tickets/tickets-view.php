<?php if(!defined('PARENT')) { exit; } 
$_GET['id'] = (int)$_GET['id'];
if (isset($OK)) {
  echo mswActionCompleted($msg_viewticket47);
}

if (isset($OK2)) {
  echo mswActionCompleted($msg_viewticket46);
}

if (isset($OK3)) {
  echo mswActionCompleted($msg_viewticket90);
}

?>

<div id="headWrapper">
  
  <div id="message">
   <p class="ticketLinkArea"><span class="float">
      <?php
      if ($SUPTICK->ticketStatus!='open') {
      ?>
      <a class="open" href="?p=view-ticket&amp;open=<?php echo $_GET['id']; ?>" title="<?php echo mswSpecialChars($msg_viewticket26); ?>"><?php echo $msg_viewticket26; ?></a> 
      <?php
      } else {
      ?>
      <a class="reply" href="#" onclick="scrollToArea('replyArea');jQuery('#comments').focus();return false" title="<?php echo mswSpecialChars($msg_viewticket75); ?>"><?php echo $msg_viewticket75; ?></a> 
      <a class="close" href="?p=view-ticket&amp;close=<?php echo $_GET['id']; ?>" title="<?php echo mswSpecialChars($msg_viewticket27); ?>"><?php echo $msg_viewticket27; ?></a>
      <a class="lock" href="?p=view-ticket&amp;lock=<?php echo $_GET['id']; ?>" title="<?php echo mswSpecialChars($msg_viewticket28); ?>"><?php echo $msg_viewticket28; ?></a>
      <a class="dispute" href="?p=view-ticket&amp;odis=<?php echo $_GET['id']; ?>" onclick="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')" title="<?php echo mswSpecialChars($msg_disputes3); ?>"><?php echo $msg_disputes3; ?></a>
      <?php
      }
      ?>
     </span>
     <?php echo str_replace('{ticket}',mswTicketNumber($_GET['id']),$msg_viewticket10); ?> (<span class="highlight"><?php echo mswGetTicketStatus($SUPTICK->ticketStatus,$SUPTICK->replyStatus); ?></span>)
   </p>
  </div>
  
</div>

<div class="ticketArea">

  <div id="viewBoxes">
  
    <div id="viewLeft">
     <h2><span class="float"><a href="?p=edit-ticket&amp;id=<?php echo $_GET['id']; ?>" title="<?php echo mswSpecialChars($msg_script9); ?>" onclick="$.GB_hide();$.GB_show(this.href, {height: <?php echo GREYBOX_HEIGHT; ?>,width: <?php echo GREYBOX_WIDTH; ?>,caption: this.title});return false;"><img src="templates/images/edit.png" alt="<?php echo mswSpecialChars($msg_script9); ?>" title="<?php echo mswSpecialChars($msg_script9); ?>" /></a></span><?php echo mswSpecialChars($SUPTICK->subject); ?></h2>
     
     <div class="msg">
     <?php 
     echo mswTxtParsingEngine($SUPTICK->comments); 
     $qT       = mysql_query("SELECT * FROM ".DB_PREFIX."ticketfields
                 LEFT JOIN ".DB_PREFIX."cusfields
                 ON ".DB_PREFIX."ticketfields.`fieldID`   = ".DB_PREFIX."cusfields.`id`
                 WHERE `ticketID`                         = '{$_GET['id']}'
                 AND ".DB_PREFIX."ticketfields.`replyID`  = '0'
                 AND `enField`                            = 'yes'
                 ORDER BY `orderBy`
                 ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
     if (mysql_num_rows($qT)>0) {
     ?>
     <div class="cusTickFields">
     <ul>
     <?php
     while ($TS = mysql_fetch_object($qT)) {
       if ($TS->fieldData!='nothing-selected' && $TS->fieldData!='') {
         switch ($TS->fieldType) {
           case 'textarea':
           case 'input':
           case 'select':
           ?>
           <li><span class="head"><?php echo mswSpecialChars($TS->fieldInstructions); ?></span><?php echo mswTxtParsingEngine($TS->fieldData); ?></li>
           <?php
           break;
           case 'checkbox':
           ?>
           <li><span class="head"><?php echo mswSpecialChars($TS->fieldInstructions); ?></span><?php echo str_replace('#####','<br />',mswSpecialChars($TS->fieldData)); ?></li>
           <?php
           break;
         }  
       }
     }
     ?>
     </ul>
     </div>
     <?php
     }
     ?>
     </div>
     <?php
     // Does initial ticket have attachments..
     $aCount = mswRowCount('attachments WHERE `ticketID` = \''.$_GET['id'].'\' AND `replyID` = \'0\'');
     if ($aCount>0) {
     ?>
     <p class="ticket_attachments"><a class="attachlink" href="?p=view-ticket&amp;attachments=<?php echo $_GET['id']; ?>" title="<?php echo mswSpecialChars($msg_viewticket40); ?>" onclick="$.GB_hide();$.GB_show(this.href, {height: <?php echo GREYBOX_HEIGHT_ATTACHMENTS; ?>,width: <?php echo GREYBOX_WIDTH_ATTACHMENTS; ?>,caption: this.title});return false;"><?php echo str_replace('{count}',$aCount,$msg_viewticket41); ?></a></p>
     <?php
     }
     ?>
    <br class="clear" /> 
    </div>
    
    <div id="viewRight">
     
     <div class="rightInner">
      
      <h2><span class="float"><a href="?p=edit-ticket&amp;id=<?php echo $_GET['id']; ?>" title="<?php echo mswSpecialChars($msg_script9); ?>" onclick="$.GB_hide();$.GB_show(this.href, {height: <?php echo GREYBOX_HEIGHT; ?>,width: <?php echo GREYBOX_WIDTH; ?>,caption: this.title});return false;"><img src="templates/images/edit.png" alt="<?php echo mswSpecialChars($msg_script9); ?>" title="<?php echo mswSpecialChars($msg_script9); ?>" /></a></span><?php echo $msg_viewticket8; ?></h2>
    
      <div class="detailWrapper">
     
       <label><?php echo $msg_viewticket2; ?></label>
       <p class="data"><?php echo mswSpecialChars($SUPTICK->name); ?></p>
     
       <label><?php echo $msg_viewticket3; ?></label>
       <p class="data"><?php echo $SUPTICK->email; ?></p>
     
       <label><?php echo $msg_viewticket4; ?></label>
       <p class="data"><?php echo mswGetDepartmentName($SUPTICK->department); ?></p>
       
       <label><?php echo $msg_viewticket9; ?></label>
       <p class="data"><?php echo mswGetPriorityLevel($SUPTICK->priority); ?></p>
     
       <label><?php echo $msg_viewticket5; ?></label>
       <p class="data"><?php echo mswDateDisplay($SUPTICK->ts,$SETTINGS->dateformat).' / '.mswTimeDisplay($SUPTICK->ts,$SETTINGS->timeformat); ?></p>
   
       <label><?php echo $msg_viewticket6; ?></label>
       <p class="data"><?php echo $SUPTICK->ipAddresses; ?></p>
     
      </div> 
     </div>
     <?php
     
     // Ticket assigned to users..?
     if (($MSTEAM->id=='1' || in_array('assign',$userAccess)) && mswRowCount('departments WHERE `id` = \''.$SUPTICK->department.'\' AND `manual_assign` = \'yes\'')>0) {
     ?>
     <div class="rightInner" style="margin-top:5px">
     <h2><?php echo $msg_viewticket92; ?></h2>
     <div class="assignWrapper" id="assignWrapper">
     <form method="post" action="#" id="form2">
     <?php
     $boomUsers    = explode(',',$SUPTICK->assignedto);
     $q_users      = mysql_query("SELECT * FROM ".DB_PREFIX."users ORDER BY `name`") 
                     or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
     while ($USERS = mysql_fetch_object($q_users)) {
     ?>
     <p><input onclick="ms_updateAssignedUsers('<?php echo $_GET['id']; ?>')" type="checkbox" name="assigned[]" value="<?php echo $USERS->id; ?>"<?php echo (in_array($USERS->id,$boomUsers) ? ' checked="checked"' : ''); ?> /> <?php echo mswCleanData($USERS->name); ?></p>
     <?php
     } 
     ?>
     </form>
     </div>
     </div>
     <?php
     }
     
     // Can user view notes..
     if ($MSTEAM->notePadEnable=='yes' || $MSTEAM->id=='1') {
     ?>
     <div class="rightInner" style="margin-top:5px">
     <h2 class="notesHeader" id="notesHeader"><span class="float"><a href="?p=view-ticket&amp;notes=<?php echo $_GET['id']; ?>" onclick="$.GB_hide();$.GB_show(this.href, {height: <?php echo GREYBOX_HEIGHT; ?>,width: <?php echo GREYBOX_WIDTH; ?>,caption: this.title});return false;"><img src="templates/images/view-notes.png" alt="<?php echo mswSpecialChars($msg_viewticket72); ?>" title="<?php echo mswSpecialChars($msg_viewticket72); ?>" /></a></span><?php echo $msg_viewticket54; ?></h2>
     
     <div class="notesWrapper" id="notesWrapper">
     <form method="post" action="#" id="form">
     <p><textarea name="notes" cols="20" rows="20" id="notes" onkeyup="jQuery('#sysAction').hide()" onblur="ms_updateTicketNotes('<?php echo $_GET['id']; ?>')"><?php echo mswSpecialChars($SUPTICK->ticketNotes); ?></textarea></p>
     </form>
     <div class="sysAction" id="sysAction"></div> 
     </div> 
     </div>
     <?php
     }
     
     ?>
     <br class="clear" /> 
    </div>
  
  <br class="clear" /> 
  </div>

  <br class="clear" />
</div>

<div id="ticketReplies">
  <?php
  // Replies..
  $q_replies = mysql_query("SELECT * FROM ".DB_PREFIX."replies
               WHERE `ticketID` = '{$_GET['id']}'
               ORDER BY `id`
               ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  if (mysql_num_rows($q_replies)>0) {
  while ($REPLIES = mysql_fetch_object($q_replies)) {
  switch ($REPLIES->replyType) {
    case 'admin':
    $USER       = mswGetTableData('users','id',$REPLIES->replyUser);
    $replyName  = (isset($USER->name) ? mswSpecialChars($USER->name) : $msg_viewticket43);
    $ip         = ($REPLIES->ipAddresses ? '('.$REPLIES->ipAddresses.')' : '');
    break;
    case 'visitor':
    $replyName  = mswSpecialChars($SUPTICK->name);
    $ip         = ($REPLIES->ipAddresses ? '('.$REPLIES->ipAddresses.')' : '');
    break;
  }
  // Count attachments for reply..
  $arCount = 0;
  if ($SETTINGS->attachment=='yes') {
    $arCount = mswRowCount('attachments WHERE `ticketID` = \''.$_GET['id'].'\' AND `replyID` = \''.$REPLIES->id.'\'');
  }
  ?>
  <div class="reply_<?php echo $REPLIES->replyType; ?>">
    
    <div class="text">
     <div class="repHead"><?php echo $replyName; ?></div>
     <div class="msg">
     <?php echo mswTxtParsingEngine($REPLIES->comments); 
     $qT       = mysql_query("SELECT * FROM ".DB_PREFIX."ticketfields
                LEFT JOIN ".DB_PREFIX."cusfields
                ON ".DB_PREFIX."ticketfields.`fieldID`   = ".DB_PREFIX."cusfields.`id`
                WHERE `ticketID`                         = '{$_GET['id']}'
                AND ".DB_PREFIX."ticketfields.`replyID`  = '{$REPLIES->id}'
                AND `enField`                            = 'yes'
                ORDER BY `orderBy`
                ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
     if (mysql_num_rows($qT)>0) {
     ?>
     <div class="cusTickFields">
     <ul>
     <?php
     while ($TS = mysql_fetch_object($qT)) {
       if ($TS->fieldData!='nothing-selected' && $TS->fieldData!='') {
         switch ($TS->fieldType) {
           case 'textarea':
           case 'input':
           case 'select':
           ?>
           <li><span class="head"><?php echo mswSpecialChars($TS->fieldInstructions); ?></span><?php echo mswTxtParsingEngine($TS->fieldData); ?></li>
           <?php
           break;
           case 'checkbox':
           ?>
           <li><span class="head"><?php echo mswSpecialChars($TS->fieldInstructions); ?></span><?php echo str_replace('#####','<br />',mswSpecialChars($TS->fieldData)); ?></li>
           <?php
           break;
         }  
       }
     }
     ?>
     </ul>
     </div>
     <?php
     }
      ?>
      </div>
      <?php
      if ($REPLIES->replyType=='admin' && $USER->signature) {
      ?>
      <p class="signature"><?php echo (AUTO_PARSE_LINE_BREAKS ? nl2br(mswCleanData($USER->signature)) : mswSpecialChars($USER->signature)); ?></p>
      <?php
      }
      ?>
    </div>
    
    <div class="info">
     <span class="edit"><?php echo ($arCount>0 ? '<a class="attachlink" href="?p=view-ticket&amp;t='.$REPLIES->ticketID.'&amp;attach='.$REPLIES->id.'" title="'.mswSpecialChars($msg_viewticket40).'" onclick="$.GB_hide();$.GB_show(this.href, {height: '.GREYBOX_HEIGHT_ATTACHMENTS.',width: '.GREYBOX_WIDTH_ATTACHMENTS.',caption: this.title});return false;">'.str_replace('{count}',$arCount,$msg_viewticket41).'</a>' : ''); ?><a href="?p=view-ticket&amp;id=<?php echo $_GET['id']; ?>&amp;edit=<?php echo $REPLIES->id; ?>" onclick="$.GB_hide();$.GB_show(this.href, {height: <?php echo GREYBOX_HEIGHT_REPLY; ?>,width: <?php echo GREYBOX_WIDTH_REPLY; ?>,caption: this.title});return false;" title="<?php echo mswSpecialChars($msg_script9); ?>" ><?php echo $msg_script9; ?></a><?php echo (USER_DEL_PRIV=='yes' ? ' | <a onclick="return confirmMessage(\''.mswSpecialChars($msg_javascript).'\')" href="?p=view-ticket&amp;id='.$_GET['id'].'&amp;delete='.$REPLIES->id.'" title="'.mswSpecialChars($msg_script8).'">'.$msg_script8.'</a>' : ''); ?>
     </span><?php echo mswDateDisplay($REPLIES->ts,$SETTINGS->dateformat).' / '.mswTimeDisplay($REPLIES->ts,$SETTINGS->timeformat); ?> <?php echo $ip; ?>
    </div>
    
  </div>
  <?php
  }
  } else {
  ?>
  <p class="nodata"><?php echo $msg_viewticket39; ?></p>
  <?php
  }
  ?>
</div>

<?php
if ($SUPTICK->ticketStatus=='open') {
?>
<div id="replyArea">

  <form method="post" action="?p=view-ticket&amp;id=<?php echo $_GET['id']; ?>" enctype="multipart/form-data" onsubmit="return addResponseBox('<?php echo mswSpecialChars($msg_javascript96); ?>','<?php echo mswSpecialChars($msg_javascript97); ?>','<?php echo mswSpecialChars($msg_javascript98); ?>','<?php echo mswRowCount('responses'); ?>','<?php echo RESTR_RESPONSES; ?>','<?php echo LICENCE_VER; ?>')">
  <div class="replyInner">
  
    <h2>
    <span class="float">
     <a class="standard" onclick="jQuery('#standardResponses').toggle('slow');return false" href="#" title="<?php echo mswSpecialChars($msg_viewticket12); ?>"><?php echo $msg_viewticket12; ?></a>
    </span>
    <?php echo $msg_viewticket11; ?>
    </h2>
    
    <div class="standardResponse" id="standardResponses" style="display:none">
     <p>
     <?php
     $SQL    = 'WHERE `department` IN (0,'.$SUPTICK->department.') AND `enResponse` = \'yes\'';
     $q_str  = mysql_query("SELECT * FROM ".DB_PREFIX."responses $SQL ORDER BY `title`") 
               or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
     if (mysql_num_rows($q_str)>0) {
     ?>
     <select id="response" onchange="getStandardResponse()">
      <option value="0">- - - - -</option>
      <?php
      while ($RESPONSES = mysql_fetch_object($q_str)) {
      ?>
      <option value="<?php echo $RESPONSES->id; ?>"><?php echo mswSpecialChars($RESPONSES->title); ?></option>
      <?php
      }
      ?>
     </select> <a href="#" onclick="jQuery('#standardResponses').hide('slow');return false" title="<?php echo mswSpecialChars($msg_script15); ?>">X</a>
     <?php
     } else {
     ?>
     <span class="no_responses"><?php echo $msg_viewticket57; ?> <a onclick="jQuery('#standardResponses').hide('slow');return false" href="#" title="<?php echo mswSpecialChars($msg_script15); ?>"><?php echo $msg_script15; ?></a></span>
     <?php
     }
     ?>
     </p>
    </div>
    
    <div class="replyBoxArea" id="replyBoxArea">
    
      <p>
      <?php
      if ($SETTINGS->enableBBCode=='yes') {
        include(PATH.'templates/system/bbcode-buttons.php');
      }
      ?>
      <textarea name="comments" rows="15" cols="40" id="comments"></textarea></p>
      
      <?php
      // Custom fields..
      $qF = mysql_query("SELECT * FROM ".DB_PREFIX."cusfields
            WHERE FIND_IN_SET('admin',`fieldLoc`) > 0
            AND `enField`                         = 'yes'
            ORDER BY `orderBy`
            ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      if (mysql_num_rows($qF)>0) {
      ?>
      <div class="customFields">
      <?php
      while ($FIELDS = mysql_fetch_object($qF)) {
        switch ($FIELDS->fieldType) {
          case 'textarea':
          echo $MSFM->buildTextArea(mswCleanData($FIELDS->fieldInstructions),$FIELDS->id);
          break;
          case 'input':
          echo $MSFM->buildInputBox(mswCleanData($FIELDS->fieldInstructions),$FIELDS->id);
          break;
          case 'select':
          echo $MSFM->buildSelect(mswCleanData($FIELDS->fieldInstructions),$FIELDS->id,$FIELDS->fieldOptions);
          break;
          case 'checkbox':
          echo $MSFM->buildCheckBox(mswCleanData($FIELDS->fieldInstructions),$FIELDS->id,$FIELDS->fieldOptions);
          break;
        }
      }
      ?>
      </div>
      <?php
      }
      ?>
      
      <div class="replyFooter">
      
        <div class="attachments">
          <p class="attachBoxes">
          <?php
          echo $msg_viewticket78;
          ?>
          <span class="bx"><input type="file" class="box" name="attachment[]" /></span>
          </p>
          <?php
          if (LICENCE_VER=='unlocked') {
          ?>
          <p class="attachlinks">
          <a class="add" href="#" title="<?php echo mswSpecialChars($msg_newticket37); ?>" onclick="ms_attachBox('add','<?php echo ADMIN_ATTACH_BOX_OVERRIDE; ?>');return false"><?php echo mswSpecialChars($msg_newticket37); ?></a> 
          <a class="remove" href="#" title="<?php echo mswSpecialChars($msg_newticket37); ?>" onclick="ms_attachBox('remove');return false"><?php echo mswSpecialChars($msg_newticket38); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
          </p>
          <?php
          }
          ?>
        </div>
        
        <div class="options">
        
          <div class="status">
            <label><?php echo $msg_viewticket17; ?> <?php echo mswDisplayHelpTip($msg_javascript45); ?></label>
            <select name="status">
              <option value="open"><?php echo $msg_viewticket14; ?></option>
              <option value="close"><?php echo $msg_viewticket15; ?></option>
              <option value="closed"><?php echo $msg_viewticket16; ?></option>
            </select>
          </div>
          
          <div class="response">
            <label><?php echo $msg_viewticket35; ?> <?php echo mswDisplayHelpTip($msg_javascript78); ?></label>
            <input type="radio" id="r1" name="response" value="yes" /> <?php echo $msg_script4; ?> <input id="r2" type="radio" name="response" value="no" checked="checked" /> <?php echo $msg_script5; ?>
          </div>
          
          <div class="mail">
            <label><?php echo $msg_viewticket18; ?> <?php echo mswDisplayHelpTip($msg_javascript46); ?></label>
            <input type="radio" name="mail" value="yes" checked="checked" /> <?php echo $msg_script4; ?> <input type="radio" name="mail" value="no" /> <?php echo $msg_script5; ?>
          </div>
          
          <div class="merge">
            <label><?php echo $msg_viewticket19; ?> <?php echo mswDisplayHelpTip($msg_javascript47,'LEFT'); ?></label>
            <input type="text" class="box" title="<?php echo mswSpecialChars($msg_javascript44); ?>" name="mergeid" id="mergebox" onclick="$.GB_hide();$.GB_show('?p=merge-ticket&amp;id=<?php echo $_GET['id']; ?>', {height: <?php echo GREYBOX_HEIGHT; ?>,width: <?php echo GREYBOX_WIDTH; ?>,caption: this.title});return false;" />
          </div>
        
          <br class="clear" />
        </div>
        
        <br class="clear" />
      
        <p class="buttonWrapper"> 
         <span id="prompt"></span>
         <input type="hidden" name="process_add" value="1" />
         <input type="hidden" name="isDisputed" value="no" /><br />
         <input class="button" type="submit" value="<?php echo mswSpecialChars($msg_viewticket13); ?>" title="<?php echo mswSpecialChars($msg_viewticket13); ?>" />
         <input onclick="ms_ticketPreview('view-ticket','comments')" class="button" type="button" value="<?php echo mswSpecialChars($msg_viewticket55); ?>" title="<?php echo mswSpecialChars($msg_viewticket55); ?>" style="margin-left:30px" />
        </p>
      
      </div>
      
    </div>
    
  </div>
  </form>  

</div>
<?php
} else {
?>
<div id="replyArea">

  <p class="nodata"><?php echo $msg_viewticket45; ?></p>

</div>
<?php
}
?>