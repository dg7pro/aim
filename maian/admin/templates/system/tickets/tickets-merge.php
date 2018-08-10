<?php if(!defined('PARENT')) { exit; } 
$_GET['id'] = (int)$_GET['id'];
if (file_exists(PATH.'templates/header-custom.php')) {
  include_once(PATH.'templates/header-custom.php');
} else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
}
?>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=<?php echo $msg_charset; ?>" />
<title><?php echo mswSpecialChars($msg_script9); ?></title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.js"></script>
<script type="text/javascript" src="templates/js/js_code.js"></script>
<script type="text/javascript" src="templates/greybox/greybox.js"></script>
<script type="text/javascript" src="templates/js/overlib.js"><!-- overLIB (c) Erik Bosrup --></script>
</head>

<body>

<div id="bodyOverride">

<div id="windowWrapper">

  <h1><select onchange="location=this.options[this.selectedIndex].value">
        <?php
        // If global log in no filter necessary..
        if ($MSTEAM->id!='1') {
        ?>  
        <option value="0">- - - - - -</option>
        <?php
        } else {
        ?>
        <option value="index.php?p=merge-ticket&amp;id=<?php echo $_GET['id']; ?>"><?php echo $msg_open2 ; ?></option>
        <?php
        }
        $q_dept = mysql_query("SELECT * FROM ".DB_PREFIX."departments ".mswSQLDepartmentFilter($mswDeptFilterAccess,'WHERE')." ORDER BY `name`") 
                  or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
        while ($DEPT = mysql_fetch_object($q_dept)) {
        ?>
        <option value="?p=merge-ticket&amp;id=<?php echo $_GET['id']; ?>&amp;dept=<?php echo $DEPT->id; ?>"<?php echo (isset($_GET['dept']) && $_GET['dept']==$DEPT->id ? ' selected="selected"' : ''); ?>><?php echo mswCleanData($DEPT->name); ?></option>
        <?php
        }
        ?>
        </select>
    <span class="float">
    <?php echo ($SUPTICK->isDisputed=='yes' ? $msg_merge3 : $msg_merge); ?>
    </span>
    </h1>
  
    <div id="ticketsWrapper" style="margin-top:10px">
    <?php
    $countedRows = 0;
    // Filters..
    $filterBy = "WHERE `ticketStatus` = 'open' ";
    if ($SUPTICK->isDisputed=='yes') {
      $filterBy .= "AND `isDisputed` = 'yes' ";
    }
    if (isset($_GET['dept']) && in_array($_GET['dept'],$userDeptAccess)) {
      $filterBy .= "AND `department` = '{$_GET['dept']}' ";
    }
    // Count for pages..
    $q_tickets = mysql_query("SELECT SQL_CALC_FOUND_ROWS * FROM ".DB_PREFIX."tickets 
                 ".$filterBy.mswSQLDepartmentFilter($ticketFilterAccess,($filterBy ? 'AND' : 'WHERE'))."
                 AND `id`         != '{$_GET['id']}'
                 AND `assignedto` != 'waiting'
                 ".MYSQL_TICKET_ORDERING."
                 LIMIT $limitvalue,".MAX_ENTRIES."
                 ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    if (mysql_num_rows($q_tickets)>0) {
    $c            = mysql_fetch_object(mysql_query("SELECT FOUND_ROWS() AS rows"));
    $countedRows  =  (isset($c->rows) ? $c->rows : '0');
    while ($TICKETS = mysql_fetch_object($q_tickets)) {
    ?>
    <div class="ticketWrapper<?php echo ($TICKETS->priority=='high' ? '_high' : ''); ?>">
  
     <div class="subject">
      <p><?php echo mswSpecialChars($TICKETS->subject); ?><span class="from"><?php echo $msg_open9; ?> <?php echo mswSpecialChars($TICKETS->name); ?></span></p>
     </div>
    
     <div class="view">
      <p><img style="cursor:pointer" src="templates/images/load-ticket.png" alt="<?php echo mswSpecialChars(($SUPTICK->isDisputed=='yes' ? $msg_merge4 : $msg_merge2)).' #'.mswTicketNumber($TICKETS->id); ?>" title="<?php echo mswSpecialChars(($SUPTICK->isDisputed=='yes' ? $msg_merge4 : $msg_merge2)).' #'.mswTicketNumber($TICKETS->id); ?>" onclick="jQuery('#mergebox', top.document).val('<?php echo mswTicketNumber($TICKETS->id); ?>');jQuery('#GB_window,#GB_overlay', top.document).remove();return false" /></p>
     </div>
    
     <div class="info">
      <?php
      if ($SUPTICK->isDisputed=='yes') {
      ?>
      <p>
      <?php 
      $tcnt = number_format(mswRowCount('disputes WHERE `ticketID` = \''.$TICKETS->id.'\''));
      echo str_replace(array('{ticket}','{date}','{priority}','{dept}','{status}','{replies}','{dispute}'),
                       array(mswTicketNumber($TICKETS->id),mswDateDisplay($TICKETS->ts,$SETTINGS->dateformat),mswGetPriorityLevel($TICKETS->priority),
                             mswGetDepartmentName($TICKETS->department),mswGetTicketStatus($TICKETS->ticketStatus,$TICKETS->replyStatus),
                             number_format(mswRowCount('replies WHERE `ticketID` = \''.$TICKETS->id.'\'')),
                             mswUsersInDispute($TICKETS,$tcnt)
                       ),
                       $msg_open22
           ); 
      ?>
      </p>
      <?php
      } else {
      ?>
      <p><?php echo str_replace(array('{ticket}','{date}','{priority}','{dept}','{status}','{replies}'),
                                array(mswTicketNumber($TICKETS->id),mswDateDisplay($TICKETS->ts,$SETTINGS->dateformat),mswGetPriorityLevel($TICKETS->priority),
                                      mswGetDepartmentName($TICKETS->department),mswGetTicketStatus($TICKETS->ticketStatus,$TICKETS->replyStatus),
                                      number_format(mswRowCount('replies WHERE `ticketID` = \''.$TICKETS->id.'\''))
                                ),
                                $msg_open8); ?>
      </p>
      <?php
      }
      ?>
     </div>
    </div>
    <?php
    }
    } else {
    ?>
    <p class="nodata"><?php echo ($SUPTICK->isDisputed=='yes' ? $msg_merge5 : $msg_open10); ?></p>
    <?php
    }
    ?>
</div>

</div>
<?php
define('PER_PAGE',MAX_ENTRIES);
if ($countedRows>0 && $countedRows>MAX_ENTRIES) {
  $PTION = new pagination($countedRows,'?p='.$cmd.'&amp;id='.$_GET['id'].'&amp;next=');
  echo $PTION->display();
}
?>
</div>

</body>

</html>