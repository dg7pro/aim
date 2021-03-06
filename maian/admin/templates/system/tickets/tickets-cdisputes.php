<?php if(!defined('PARENT')) { exit; } 
$filterBy    = '';
if (isset($_GET['priority']) && in_array($_GET['priority'],$levelPrKeys)) {
  $filterBy  .= "AND `priority` = '{$_GET['priority']}'";
}
if (isset($_GET['dept']) && substr($_GET['dept'],0,1)=='u') {
  $filterBy   .= "AND FIND_IN_SET('".(int)substr($_GET['dept'],1)."',`assignedto`) > 0";
} else {
  if (isset($_GET['dept']) && in_array($_GET['dept'],$userDeptAccess)) {
    $_GET['dept'] = (int)$_GET['dept'];
    $mswDeptFilterAccess   = '';
    $filterBy    .= "AND `department` = '".$_GET['dept']."'";
  }
}
$closedCount = mswRowCount('tickets WHERE `ticketStatus` != \'open\' AND `assignedto` != \'waiting\' AND `isDisputed` = \'yes\' '.mswSQLDepartmentFilter($ticketFilterAccess).' '.$filterBy);
if (isset($OK)) {
  echo mswActionCompleted($msg_open26);
}

if (isset($OK2) && $cnt>0) {
  echo mswActionCompleted($msg_open25);
}
?>

<form method="post" id="form" action="?p=cdisputes" onsubmit="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')">
<div id="headWrapper">
  
  <div id="message">
   <p><?php echo str_replace('{count}',$closedCount,$msg_disputes2); ?></p>
  </div>
  
</div>

<div class="contentWrapper"> 
  
  <div id="filterWrapper">
  
    <div class="filterLeft">
      <p>
        <select onchange="location=this.options[this.selectedIndex].value">
        <?php
        include(PATH.'templates/system/tickets/tickets-screen-dept-filter.php');
        ?>
        </select>
      </p>  
    </div>
    
    <div class="filterRight">
      <p>
        <select onchange="location=this.options[this.selectedIndex].value">
        <option value="?p=cdisputes<?php echo (isset($_GET['dept']) ? '&amp;dept='.$_GET['dept'] : ''); ?>"><?php echo $msg_open3 ; ?></option>
        <?php
        foreach ($ticketLevelSel AS $k => $v) {
        ?>
        <option value="?p=cdisputes&amp;priority=<?php echo $k.(isset($_GET['dept']) ? '&amp;dept='.$_GET['dept'] : ''); ?>"<?php echo (isset($_GET['priority']) && $_GET['priority']==$k ? ' selected="selected"' : ''); ?>><?php echo $v; ?></option>
        <?php
        }
        ?>
        </select>
      </p>
    </div>
  
    <br class="clear" />
  </div>
  
</div>

<div id="ticketsWrapper">
  <?php
  $countedRows = 0;
  $q_tickets = mysql_query("SELECT SQL_CALC_FOUND_ROWS * FROM ".DB_PREFIX."tickets
               WHERE `ticketStatus` != 'open' 
               AND `isDisputed`      = 'yes'
               AND `assignedto`     != 'waiting'
               ".$filterBy." ".mswSQLDepartmentFilter($mswDeptFilterAccess)."
               ".MYSQL_TICKET_ORDERING."
               LIMIT $limitvalue,".MAX_ENTRIES."
               ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  if (mysql_num_rows($q_tickets)>0) {
  $c            = mysql_fetch_object(mysql_query("SELECT FOUND_ROWS() AS rows"));
  $countedRows  =  (isset($c->rows) ? $c->rows : '0');
  while ($TICKETS = mysql_fetch_object($q_tickets)) {
  ?>
  <div class="ticketWrapper<?php echo ($TICKETS->priority=='high' ? '_high' : ''); ?>">
  
    <div class="subject" id="subject_<?php echo $TICKETS->id; ?>">
      <p>
       <?php echo mswSpecialChars($TICKETS->name); ?><span class="from"><?php echo mswSpecialChars($TICKETS->subject); ?> <a href="#" onclick="ms_previewTicket('<?php echo $TICKETS->id; ?>');return false"><img src="templates/images/small-preview.png" alt="<?php echo mswSpecialChars($msg_script39); ?>" title="<?php echo mswSpecialChars($msg_script39); ?>" /></a></span>
      </p>
      <p class="ticketPreviewArea" id="preview_<?php echo $TICKETS->id; ?>">
        <span class="msg" id="preview_msg_<?php echo $TICKETS->id; ?>">&nbsp;</span>
        <span class="close"><a href="#" onclick="jQuery('#preview_<?php echo $TICKETS->id; ?>').hide('slow');return false" title="<?php echo mswSpecialChars($msg_script38); ?>"><?php echo $msg_script38; ?></a></span>
      </p>
    </div>
    
    <div class="view">
      <p><a href="?p=view-dispute&amp;id=<?php echo $TICKETS->id; ?>"><img src="templates/images/view-ticket.png" alt="<?php echo mswSpecialChars($msg_open24).' #'.mswTicketNumber($TICKETS->id); ?>" title="<?php echo mswSpecialChars($msg_open24).' #'.mswTicketNumber($TICKETS->id); ?>" /></a></p>
    </div>
    
    <div class="info">
      <p>
      <?php
      if (USER_DEL_PRIV=='yes') {
      ?>
      <span class="delete"><input type="checkbox" name="ticket[]" value="<?php echo $TICKETS->id; ?>" /></span>
      <?php
      } 
      $tcnt = number_format(mswRowCount('disputes WHERE `ticketID` = \''.$TICKETS->id.'\''));
      echo str_replace(array('{ticket}','{date}','{priority}','{dept}','{status}','{replies}','{dispute}'),
                       array(mswTicketNumber($TICKETS->id),mswDateDisplay($TICKETS->ts,$SETTINGS->dateformat),mswGetPriorityLevel($TICKETS->priority),
                             mswGetDepartmentName($TICKETS->department),mswGetTicketStatus($TICKETS->ticketStatus,$TICKETS->replyStatus,$TICKETS->isDisputed),
                             number_format(mswRowCount('replies WHERE `ticketID` = \''.$TICKETS->id.'\'')),
                             mswUsersInDispute($TICKETS,$tcnt)
                       ),
                       $msg_open29
           ); 
      ?> (<a href="?p=cdisputes&amp;open=<?php echo $TICKETS->id; ?>" title="<?php echo mswSpecialChars($msg_open19).': #'.mswTicketNumber($TICKETS->id); ?>"><?php echo $msg_open19; ?></a>)
      </p>
    </div>
  </div>
  <?php
  }
  if (USER_DEL_PRIV=='yes') {
  ?>
  <p class="buttonWrapperTickets">
    <input type="hidden" name="process" value="1" />
    <input type="submit" class="delbutton" id="button" value="<?php echo mswSpecialChars($msg_open23); ?>" title="<?php echo mswSpecialChars($msg_open23); ?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="checkbox" name="log" onclick="selectAll('form')" />
  </p>
  <?php
  }
  define('PER_PAGE',MAX_ENTRIES);
  if ($countedRows>0 && $countedRows>MAX_ENTRIES) {
    $PTION = new pagination($countedRows,'?p='.$cmd.'&amp;next=');
    echo $PTION->display();
  }
  } else {
  ?>
  <p class="nodata"><?php echo $msg_disputes16; ?></p>
  <?php
  }
  ?>
</div>
</form>