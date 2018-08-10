<?php if(!defined('PARENT')) { exit; } 
if (isset($OK)) {
  echo mswActionCompleted(str_replace('{count}',$cn,$msg_search16));
}
?>

<div id="headWrapper">
  
  <div id="message">
   <p><?php echo $msg_search; ?></p>
  </div>
  
</div>

<div class="contentWrapper">
  <script type="text/javascript">
  //<![CDATA[
  <?php
  include(PATH.'templates/date-pickers.php');
  ?>
  //]]>
  </script>

  <h2><?php echo $msg_search2; ?></h2>
       
  <div class="formWrapper"> 
  
    <form method="get" action="index.php">
    
    <div class="doubleWrapper">
     <div class="formLeft" style="width:43%">
      <label><?php echo $msg_search3; ?> <?php echo mswDisplayHelpTip($msg_javascript62,'RIGHT'); ?></label>
      <input type="text" class="box" name="keys" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo (isset($_GET['keys']) ? mswSpecialChars($_GET['keys']) : ''); ?>" />
      <br class="clear" />
     </div>
     
     <div class="formLeft" style="width:28%">
      <label><?php echo $msg_search4; ?></label>
      <select name="department" tabindex="<?php echo (++$tabIndex); ?>">
      <option value="0">- - - - -</option>
      <?php
      $q_dept = mysql_query("SELECT * FROM ".DB_PREFIX."departments ".mswSQLDepartmentFilter($mswDeptFilterAccess,'WHERE')." ORDER BY `name`") 
                or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      while ($DEPT = mysql_fetch_object($q_dept)) {
      ?>
      <option value="<?php echo $DEPT->id; ?>"<?php echo (isset($_GET['department']) && $_GET['department']==$DEPT->id ? ' selected="selected"' : ''); ?>><?php echo mswSpecialChars($DEPT->name); ?></option>
      <?php
      }
      ?>
      </select>
      <br class="clear" />
     </div>
    
     <div class="formRight" style="width:28%">
      <label><?php echo $msg_search5; ?></label>
      <select name="priority" tabindex="<?php echo (++$tabIndex); ?>">
      <option value="0">- - - - -</option>
      <?php
      foreach ($ticketLevelSel AS $k => $v) {
      ?>
      <option value="<?php echo $k; ?>"<?php echo (isset($_GET['priority']) && $_GET['priority']==$k ? ' selected="selected"' : ''); ?>><?php echo $v; ?></option>
      <?php
      }
      ?>
      </select>
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    <?php
    if ($MSTEAM->id=='1') {
    ?>
    <div class="doubleWrapper" style="clear:both;margin-top:10px">
     <div class="formLeft" style="width:43%">
      <label><?php echo $msg_search7; ?> <?php echo mswDisplayHelpTip($msg_javascript63,'RIGHT'); ?></label>
      <input type="text" class="box" id="from" tabindex="<?php echo (++$tabIndex); ?>" name="from" value="<?php echo (isset($_GET['from']) ? mswSpecialChars($_GET['from']) : ''); ?>" style="width:30%" />
      <input type="text" class="box" id="to" tabindex="<?php echo (++$tabIndex); ?>" name="to" value="<?php echo (isset($_GET['to']) ? mswSpecialChars($_GET['to']) : ''); ?>" style="width:30%" />
      <br class="clear" />
     </div>
     
     <div class="formLeft" style="width:28%">
      <label><?php echo $msg_search8; ?></label>
      <select name="status" tabindex="<?php echo (++$tabIndex); ?>">
      <option value="0">- - - - -</option>
      <option value="open"<?php echo (isset($_GET['status']) && $_GET['status']=='open' ? ' selected="selected"' : ''); ?>><?php echo $msg_viewticket14; ?></option>
      <option value="close"<?php echo (isset($_GET['status']) && $_GET['status']=='close' ? ' selected="selected"' : ''); ?>><?php echo $msg_viewticket15; ?></option>
      <option value="closed"<?php echo (isset($_GET['status']) && $_GET['status']=='closed' ? ' selected="selected"' : ''); ?>><?php echo $msg_viewticket16; ?></option>
      </select>
      <br class="clear" />
     </div>
    
     <div class="formRight" style="width:28%">
      <label><?php echo $msg_open31; ?></label>
      <select name="assign" tabindex="<?php echo (++$tabIndex); ?>">
      <option value="0">- - - - -</option>
      <?php
      $q_users  = mysql_query("SELECT * FROM ".DB_PREFIX."users ORDER BY `name`") 
                  or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      while ($U = mysql_fetch_object($q_users)) {
      ?>
      <option value="<?php echo $U->id; ?>"<?php echo (isset($_GET['assign']) && $_GET['assign']==$U->id ? ' selected="selected"' : ''); ?>><?php echo mswCleanData($U->name); ?></option>
      <?php
      }
      ?>
      </select>
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    
    <div class="doubleWrapper" style="clear:both;margin-top:10px">
     <div class="formLeft">
      <label><?php echo $msg_search11; ?></label>
      <?php
      if (in_array('open',$userAccess) || in_array('close',$userAccess) || $MSTEAM->id=='1') {
      ?>
      <input tabindex="<?php echo (++$tabIndex); ?>" type="checkbox" name="area[]" value="tickets"<?php echo (!empty($_GET['area']) && in_array('tickets',$_GET['area']) ? ' checked="checked"' : (empty($_GET['area']) && SEARCH_AUTO_CHECK_TICKETS=='yes' ? ' checked="checked"' : '')); ?> /> <?php echo $msg_search12; ?>&nbsp;&nbsp;
      <?php
      }
      if (in_array('disputes',$userAccess) || in_array('cdisputes',$userAccess) || $MSTEAM->id=='1') {
      ?>
      <input tabindex="<?php echo (++$tabIndex); ?>" type="checkbox" name="area[]" value="disputes"<?php echo (!empty($_GET['area']) && in_array('disputes',$_GET['area']) ? ' checked="checked"' : (empty($_GET['area']) && SEARCH_AUTO_CHECK_DISPUTES=='yes' ? ' checked="checked"' : '')); ?> /> <?php echo $msg_search13; ?>
      <?php
      }
      ?>
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    <?php
    } else {
    ?>
    <div class="doubleWrapper" style="clear:both;margin-top:10px">
     <div class="formLeft" style="width:43%">
      <label><?php echo $msg_search7; ?> <?php echo mswDisplayHelpTip($msg_javascript63,'RIGHT'); ?></label>
      <input type="text" class="box" id="from" tabindex="<?php echo (++$tabIndex); ?>" name="from" value="<?php echo (isset($_GET['from']) ? mswSpecialChars($_GET['from']) : ''); ?>" style="width:30%" />
      <input type="text" class="box" id="to" tabindex="<?php echo (++$tabIndex); ?>" name="to" value="<?php echo (isset($_GET['to']) ? mswSpecialChars($_GET['to']) : ''); ?>" style="width:30%" />
      <br class="clear" />
     </div>
     
     <div class="formLeft" style="width:28%">
      <label><?php echo $msg_search8; ?></label>
      <select name="status" tabindex="<?php echo (++$tabIndex); ?>">
      <option value="0">- - - - -</option>
      <option value="open"<?php echo (isset($_GET['status']) && $_GET['status']=='open' ? ' selected="selected"' : ''); ?>><?php echo $msg_viewticket14; ?></option>
      <option value="close"<?php echo (isset($_GET['status']) && $_GET['status']=='close' ? ' selected="selected"' : ''); ?>><?php echo $msg_viewticket15; ?></option>
      <option value="closed"<?php echo (isset($_GET['status']) && $_GET['status']=='closed' ? ' selected="selected"' : ''); ?>><?php echo $msg_viewticket16; ?></option>
      </select>
      <br class="clear" />
     </div>
    
     <div class="formRight" style="width:28%">
      <label><?php echo $msg_search11; ?></label>
      <?php
      if (in_array('open',$userAccess) || in_array('close',$userAccess) || $MSTEAM->id=='1') {
      ?>
      <input tabindex="<?php echo (++$tabIndex); ?>" type="checkbox" name="area[]" value="tickets"<?php echo (!empty($_GET['area']) && in_array('tickets',$_GET['area']) ? ' checked="checked"' : (empty($_GET['area']) && SEARCH_AUTO_CHECK_TICKETS=='yes' ? ' checked="checked"' : '')); ?> /> <?php echo $msg_search12; ?>&nbsp;&nbsp;
      <?php
      }
      if (in_array('disputes',$userAccess) || in_array('cdisputes',$userAccess) || $MSTEAM->id=='1') {
      ?>
      <input tabindex="<?php echo (++$tabIndex); ?>" type="checkbox" name="area[]" value="disputes"<?php echo (!empty($_GET['area']) && in_array('disputes',$_GET['area']) ? ' checked="checked"' : (empty($_GET['area']) && SEARCH_AUTO_CHECK_DISPUTES=='yes' ? ' checked="checked"' : '')); ?> /> <?php echo $msg_search13; ?>
      <?php
      }
      ?>
      <br class="clear" />
     </div>
     <br class="clear" />
    </div>
    <?php
    }
    ?>
    <p class="buttonWrapper"> 
     <input type="hidden" name="p" value="search" />
     <input class="button" type="submit" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_search2); ?>" title="<?php echo mswSpecialChars($msg_search2); ?>" />
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
  $filters       = array();
  $searchParams  = '';
  $countedRows   = 0;
  $area          = (empty($_GET['area']) ? array('tickets') : $_GET['area']);
  if (isset($_GET['keys'])) {
    // Filters..
    if ($_GET['keys']) {
      $_GET['keys']  = mswSafeImportString(strtolower($_GET['keys']));
      // Hash will cause search to fail for ticket number, so lets remove it..
      if (substr($_GET['keys'],0,1)=='#') {
        $_GET['keys'] = substr($_GET['keys'],1);
      }
      $filters[] = (is_numeric($_GET['keys']) ? "id = '".mswReverseTicketNumber($_GET['keys'])."'" : "LOWER(`name`) LIKE '%".$_GET['keys']."%' OR LOWER(`email`) LIKE '%".$_GET['keys']."%' OR LOWER(`comments`) LIKE '%".$_GET['keys']."%'");
    }
    if (in_array($_GET['priority'],$levelPrKeys)) {
      $filters[]  = "`priority` = '{$_GET['priority']}'";
    }
    if ($_GET['department']!=0 && $_GET['department']>0) {
      $filters[] = "`department` = '{$_GET['department']}'";
    }
    if (isset($_GET['assign'])) {
      if ($_GET['assign']!=0 && $_GET['assign']>0) {
        $filters[] = "FIND_IN_SET('{$_GET['assign']}',`assignedto`) > 0";
      }
    }
    if (in_array($_GET['status'],array('close','open','closed'))) {
      $filters[] = "`ticketStatus` = '{$_GET['status']}'";
    }
    if ($_GET['from'] && $_GET['to']) {
      $_GET['from']  = mswDatePickerFormat($_GET['from']);
      $_GET['to']    = mswDatePickerFormat($_GET['to']);
      $filters[]     = "DATE(FROM_UNIXTIME(`ts`)) BETWEEN '{$_GET['from']}' AND '{$_GET['to']}'";
    }
    if (count($area)>1) {
      $filters[] = "`isDisputed` IN ('yes','no')";
    } else {
      if (in_array('tickets',$area)) {
        $filters[] = "`isDisputed` = 'no'";
      } else {
        $filters[] = "`isDisputed` = 'yes'";
      }
    }
    // Build search string..
    if (!empty($filters)) {
      for ($i=0; $i<count($filters); $i++) {
        $searchParams .= ($i ? ' AND ' : 'WHERE ').$filters[$i];
      }
    }
    // Count for pages..
    $q_tickets = mysql_query("SELECT SQL_CALC_FOUND_ROWS * FROM ".DB_PREFIX."tickets 
                 ".($searchParams ? $searchParams.mswSQLDepartmentFilter($ticketFilterAccess) : '')."
                 ".mswDefineNewline().(!$searchParams ? 'WHERE ' : 'AND ')."`assignedto` != 'waiting'
                 ".MYSQL_TICKET_ORDERING."
                 LIMIT $limitvalue,".MAX_ENTRIES."
                 ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    $c            = mysql_fetch_object(mysql_query("SELECT FOUND_ROWS() AS rows"));
    $countedRows  =  (isset($c->rows) ? $c->rows : '0');
  }
  ?>
  <h2 class="round"><?php echo $msg_search6.' ('.$countedRows.')'; ?></h2>
  
</div>  

<form method="post" id="form" action="?p=search" onsubmit="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')">
<div id="ticketsWrapper">
  <?php
  if ($searchParams) {
  if (mysql_num_rows($q_tickets)>0) {
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
      <p><a href="?p=view-<?php echo ($TICKETS->isDisputed=='yes' ? 'dispute' : 'ticket'); ?>&amp;id=<?php echo $TICKETS->id; ?>"><img src="templates/images/view-ticket.png" alt="<?php echo mswSpecialChars($msg_open7).' #'.mswTicketNumber($TICKETS->id); ?>" title="<?php echo mswSpecialChars($msg_open7).' #'.mswTicketNumber($TICKETS->id); ?>" /></a></p>
    </div>
    
    <div class="info">
      <p>
      <span class="delete">&nbsp;&nbsp;<input type="checkbox" name="ticket[]" value="<?php echo $TICKETS->id; ?>" /></span>
      <?php 
      $tcnt = number_format(mswRowCount('disputes WHERE `ticketID` = \''.$TICKETS->id.'\''));
      echo str_replace(array('{ticket}','{date}','{priority}','{dept}','{status}','{replies}','{dispute}'),
                       array(mswTicketNumber($TICKETS->id),mswDateDisplay($TICKETS->ts,$SETTINGS->dateformat),mswGetPriorityLevel($TICKETS->priority),
                             mswGetDepartmentName($TICKETS->department),mswGetTicketStatus($TICKETS->ticketStatus,$TICKETS->replyStatus,$TICKETS->isDisputed),
                             number_format(mswRowCount('replies WHERE `ticketID` = \''.$TICKETS->id.'\'')),
                             mswUsersInDispute($TICKETS,$tcnt)
                       ),
                       ($TICKETS->isDisputed=='yes' ? $msg_open22 : $msg_open8)); 
      if ($TICKETS->ticketStatus=='close') {
      if ($TICKETS->isDisputed=='yes') {
      ?>
      (<a href="?p=cdisputes&amp;open=<?php echo $TICKETS->id; ?>" title="<?php echo mswSpecialChars($msg_open19).': #'.mswTicketNumber($TICKETS->id); ?>"><?php echo $msg_open19; ?></a>)
      <?php
      } else {
      ?> (<a href="?p=close&amp;open=<?php echo $TICKETS->id; ?>" title="<?php echo mswSpecialChars($msg_open19).': #'.mswTicketNumber($TICKETS->id); ?>"><?php echo $msg_open19; ?></a>)
      <?php
      }
      }
      ?>
      </p>
    </div>
  </div>
  <?php
  }
  ?>
  <div class="batchOperations">
    <div class="b1">
    <p>
     <select name="department" tabindex="<?php echo (++$tabIndex); ?>">
     <option value="no-change"><?php echo $msg_search15; ?></option>
     <?php
     $q_dept = mysql_query("SELECT * FROM ".DB_PREFIX."departments ".mswSQLDepartmentFilter($mswDeptFilterAccess,'WHERE')." ORDER BY `name`") 
               or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
     while ($DEPT = mysql_fetch_object($q_dept)) {
     ?>
     <option value="<?php echo $DEPT->id; ?>"><?php echo mswCleanData($DEPT->name); ?></option>
     <?php
     }
     ?>
     </select>
    </p>
    </div>
    <div class="b2">
    <p>
     <select name="priority" tabindex="<?php echo (++$tabIndex); ?>">
     <option value="no-change"><?php echo $msg_search17; ?></option>
      <?php
     foreach ($ticketLevelSel AS $k => $v) {
     ?>
     <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
     <?php
     }
     ?>
     </select>
    </p>
    </div>
    <div class="b3">
    <p>
     <select name="status">
      <option value="no-change"><?php echo $msg_search18; ?></option>
      <option value="open"><?php echo $msg_viewticket14; ?></option>
      <option value="close"><?php echo $msg_viewticket15; ?></option>
      <option value="closed"><?php echo $msg_viewticket16; ?></option>
     </select>
    </p>
    </div>
    <br class="clear" />
  </div>
  <p class="buttonWrapper" style="text-align:center;padding-bottom:20px"> 
    <span style="float:right;padding-right:8px"><input type="checkbox" name="log" onclick="selectAll('form')" /></span>
    <input type="hidden" name="process" value="yes" />
    <input class="button" type="submit" value="<?php echo mswSpecialChars($msg_search14); ?>" title="<?php echo mswSpecialChars($msg_search14); ?>" />
  </p>
  <?php
  define('PER_PAGE',MAX_ENTRIES);
  if ($countedRows>0 && $countedRows>MAX_ENTRIES) {
  $s = '';
  foreach ($_GET AS $gK => $gV) {
    if (is_array($gV)) {
      foreach ($gV AS $gKA => $gVA) {
        $s .= '&amp;'.$gK.'[]='.$gVA;
      }
    } else {
      $s .= '&amp;'.$gK.'='.$gV;
    }
  }
  $PTION = new pagination($countedRows,'?p='.$cmd.'&amp;'.$s.'&amp;next=');
  echo $PTION->display();
  }
  } else {
  ?>
  <p class="nodata"><?php echo $msg_search10; ?></p>
  <?php
  }
  } else {
  ?>
  <p class="nodata"><?php echo $msg_search9; ?></p>
  <?php
  }
  ?>
</div>
</form>