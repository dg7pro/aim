<?php if(!defined('PARENT')) { exit; } 
$filterBy    = '';
if (isset($_GET['priority']) && in_array($_GET['priority'],$levelPrKeys)) {
  $filterBy  .= "AND `priority` = '{$_GET['priority']}'";
}
if (isset($_GET['dept']) && in_array($_GET['dept'],$userDeptAccess)) {
  $mswDeptFilterAccess  = '';
  $filterBy         .= "AND `department` = '".(int)$_GET['dept']."'";
}

if (isset($OK)) {
  echo mswActionCompleted(str_replace('{count}',$processed,$msg_assign4));
}

?>

<div id="headWrapper">
  
  <div id="message">
   <p><?php echo str_replace('{count}',mswRowCount('tickets WHERE `assignedto` = \'waiting\' '.mswSQLDepartmentFilter($ticketFilterAccess).' '.$filterBy),$msg_assign2); ?></p>
  </div>
  
</div>

<div class="contentWrapper"> 
  
  <div id="filterWrapper">
  
    <div class="filterLeft">
      <p>
        <select onchange="location=this.options[this.selectedIndex].value">
        <?php
        // If global log in no filter necessary..
        if ($MSTEAM->id!='1') {
        ?>  
        <option value="0">- - - - - -</option>
        <?php
        } else {
        ?>
        <option value="?p=assign"><?php echo $msg_open2 ; ?></option>
        <?php
        }
        $q_dept = mysql_query("SELECT * FROM ".DB_PREFIX."departments ".mswSQLDepartmentFilter($mswDeptFilterAccess,'WHERE')." ORDER BY `name`") 
                  or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
        while ($DEPT = mysql_fetch_object($q_dept)) {
        ?>
        <option value="?p=assign&amp;dept=<?php echo $DEPT->id.(isset($_GET['priority']) ? '&amp;priority='.$_GET['priority'] : ''); ?>"<?php echo (isset($_GET['dept']) && $_GET['dept']==$DEPT->id ? ' selected="selected"' : ''); ?>><?php echo mswCleanData($DEPT->name); ?></option>
        <?php
        }
        ?>
        </select>
      </p>  
    </div>
    
    <div class="filterRight">
      <p>
        <select onchange="location=this.options[this.selectedIndex].value">
        <option value="?p=assign<?php echo (isset($_GET['dept']) ? '&amp;dept='.$_GET['dept'] : ''); ?>"><?php echo $msg_open3 ; ?></option>
        <?php
        foreach ($ticketLevelSel AS $k => $v) {
        ?>
        <option value="?p=assign&amp;priority=<?php echo $k.(isset($_GET['dept']) ? '&amp;dept='.$_GET['dept'] : ''); ?>"<?php echo (isset($_GET['priority']) && $_GET['priority']==$k ? ' selected="selected"' : ''); ?>><?php echo $v; ?></option>
        <?php
        }
        ?>
        </select>
      </p>
    </div>
  
    <br class="clear" />
  </div>
  
</div>

<form method="post" id="form" action="?p=assign" onsubmit="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')">
<div id="ticketsWrapper">
  <?php
  // Ger users..
  $userAssign   = array();
  $q_users      = mysql_query("SELECT * FROM ".DB_PREFIX."users WHERE `notify` = 'yes' ORDER BY `name`") 
                  or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  while ($USERS = mysql_fetch_object($q_users)) {
    $userAssign[$USERS->id] = mswCleanData($USERS->name);
  }               
                 
  $countedRows = 0;
  $q_tickets = mysql_query("SELECT * FROM ".DB_PREFIX."tickets 
               WHERE `ticketStatus` = 'open'
               AND `assignedto`     = 'waiting'
               ".$filterBy.mswSQLDepartmentFilter($ticketFilterAccess)."
               ".MYSQL_TICKET_ORDERING."
               ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  if (mysql_num_rows($q_tickets)>0) {
  while ($TICKETS = mysql_fetch_object($q_tickets)) {
  ?>
  <div class="ticketWrapper<?php echo ($TICKETS->priority=='high' ? '_high' : ''); ?>">
  
    <div class="subject_assign" id="subject_<?php echo $TICKETS->id; ?>">
      <p>
       <?php echo mswSpecialChars($TICKETS->name); ?><span class="from"><?php echo mswSpecialChars($TICKETS->subject); ?> <a href="#" onclick="ms_previewTicket('<?php echo $TICKETS->id; ?>');return false"><img src="templates/images/small-preview.png" alt="<?php echo mswSpecialChars($msg_script39); ?>" title="<?php echo mswSpecialChars($msg_script39); ?>" /></a></span>
      </p>
      <p class="ticketPreviewArea" id="preview_<?php echo $TICKETS->id; ?>">
        <span class="msg" id="preview_msg_<?php echo $TICKETS->id; ?>">&nbsp;</span>
        <span class="close"><a href="#" onclick="jQuery('#preview_<?php echo $TICKETS->id; ?>').hide('slow');return false" title="<?php echo mswSpecialChars($msg_script38); ?>"><?php echo $msg_script38; ?></a></span>
      </p>
    </div>
    
    <div class="assigned">
      <h2><?php echo $msg_assign3; ?></h2>
      <p>
      <input type="hidden" name="ticketID[]" value="<?php echo $TICKETS->id; ?>" />
      <?php
      if (!empty($userAssign)) {
        foreach ($userAssign AS $uI => $uN) {
        ?>
        <span><input type="checkbox" name="assign[<?php echo $TICKETS->id; ?>][]" value="<?php echo $uI; ?>" /> <?php echo $uN; ?></span>
        <?php
        }
      }
      ?>
      </p>
    </div>
    
    <div class="info">
      <p>
      <?php echo str_replace(array('{ticket}','{date}','{priority}','{dept}','{status}','{replies}','{id}'),
                             array(mswTicketNumber($TICKETS->id),mswDateDisplay($TICKETS->ts,$SETTINGS->dateformat),mswGetPriorityLevel($TICKETS->priority),
                                   mswGetDepartmentName($TICKETS->department),mswGetTicketStatus($TICKETS->ticketStatus,$TICKETS->replyStatus),
                                   number_format(mswRowCount('replies WHERE `ticketID` = \''.$TICKETS->id.'\'')),
                                   $TICKETS->id
                             ),
                             $msg_assign); 
      ?>
      </p>
    </div>
  </div>
  <?php
  }
  if (mysql_num_rows($q_tickets)>0) {
  ?>
  <p class="assignButtonsWrapper">
    <input type="hidden" name="process" value="1" />
    <input type="checkbox" name="mail" value="yes" checked="checked" /> <?php echo $msg_assign5; ?><br /><br />
    <input type="submit" class="assignbutton" id="button" value="<?php echo mswSpecialChars($msg_assign6); ?>" title="<?php echo mswSpecialChars($msg_assign6); ?>" />
  </p>
  <?php
  }
  } else {
  ?>
  <p class="nodata"><?php echo $msg_open10; ?></p>
  <?php
  }
  ?>
</div>
</form>