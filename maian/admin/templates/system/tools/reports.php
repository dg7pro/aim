<?php if(!defined('PARENT')) { exit; } 

if (isset($OK)) {
  echo mswActionCompleted($msg_log5);
}

// Vars..
$from = (isset($_GET['from']) && mswDatePickerFormat($_GET['from'])!='0000-00-00' ? $_GET['from'] : mswConvertMySQLDate(date('Y-m-d',strtotime('-6 months',mswTimeStamp()))));
$to   = (isset($_GET['to']) && mswDatePickerFormat($_GET['to'])!='0000-00-00' ? $_GET['to'] : mswConvertMySQLDate(date('Y-m-d',mswTimeStamp())));
$view = (isset($_GET['view']) && in_array($_GET['view'],array('month','day')) ? $_GET['view'] : 'month');
$dept = (isset($_GET['dept']) ? $_GET['dept'] : '0');

?>

<div id="headWrapper">
  
  <div id="message">
   <p><?php echo $msg_reports; ?></p>
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
  
  <form method="get" action="index.php">
  <h2 class="repHeader">
   <span class="floater">
   <?php echo $msg_reports2; ?> <input type="hidden" name="p" value="reports" /><input type="text" class="box" id="from" name="from" value="<?php echo mswSpecialChars($from); ?>" />
   <?php echo $msg_reports3; ?> <input type="text" class="box" id="to" name="to" value="<?php echo mswSpecialChars($to); ?>" style="margin-right:10px" />
   <input type="radio" name="view" value="day"<?php echo ($view=='day' ? ' checked="checked"' : ''); ?> /> <?php echo $msg_reports4; ?> <input type="radio" name="view" value="month"<?php echo ($view=='month' ? ' checked="checked"' : ''); ?> /> <?php echo $msg_reports5; ?>
   <input class="button" type="submit" value="<?php echo mswSpecialChars($msg_reports6); ?>" title="<?php echo mswSpecialChars($msg_reports6); ?>" />
   </span>
   <select name="dept">
   <option value="0"><?php echo $msg_tools10; ?></option>
   <?php
   $q_dept = mysql_query("SELECT * FROM ".DB_PREFIX."departments ".mswSQLDepartmentFilter($mswDeptFilterAccess,'WHERE')." ORDER BY `name`") 
             or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
   while ($DEPT = mysql_fetch_object($q_dept)) {
   ?>
   <option value="<?php echo $DEPT->id; ?>"<?php echo (isset($_GET['dept']) && $_GET['dept']==$DEPT->id ? ' selected="selected"' : ''); ?>><?php echo mswSpecialChars($DEPT->name); ?></option>
   <?php
   }
   // For administrator, show all assigned users in filter..
   if ($MSTEAM->id=='1') {
   $q_users     = mysql_query("SELECT * FROM ".DB_PREFIX."users ORDER BY `name`") 
                  or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
   while ($U = mysql_fetch_object($q_users)) {
   ?>
   <option value="u<?php echo $U->id; ?>"<?php echo (isset($_GET['dept']) && $_GET['dept']=='u'.$U->id ? ' selected="selected"' : ''); ?>><?php echo $msg_open31.' '.mswSpecialChars($U->name); ?></option>
   <?php
   }
   }
   ?>
   </select>
   <br class="clear" />
  </h2>
  </form>
  
  <div class="reportBar">
   <ul>
    <li class="head1"><?php echo $msg_reports7; ?></li>
    <li class="head2"><?php echo $msg_reports8; ?></li>
    <li class="head3"><?php echo $msg_reports9; ?></li>
    <li class="head4"><?php echo $msg_reports10; ?></li>
    <li class="head5"><?php echo $msg_reports11; ?></li>
   </ul>
   <br class="clear" /> 
  </div>
  
  <div class="formWrapper">
    <?php
    $cns   = array(0,0,0,0);
    $where = 'WHERE DATE(FROM_UNIXTIME(`ts`)) BETWEEN \''.mswDatePickerFormat($from).'\' AND \''.mswDatePickerFormat($to).'\'';
    if (substr($dept,0,1)=='u') {
      $where .= mswDefineNewline().'AND FIND_IN_SET(\''.substr($dept,1).'\',`assignedto`) > 0';
    } else {
      if ($dept>0) {
        $where .= mswDefineNewline().'AND `department` = \''.$dept.'\'';
      }
    }
    $where .= mswDefineNewline().'AND `assignedto` != \'waiting\'';
    switch ($view) {
      case 'month':
      $qRE = mysql_query("SELECT *,MONTH(FROM_UNIXTIME(`ts`)) AS `m`,YEAR(FROM_UNIXTIME(`ts`)) AS `y` FROM ".DB_PREFIX."tickets 
             $where
             GROUP BY MONTH(FROM_UNIXTIME(`ts`)),YEAR(FROM_UNIXTIME(`ts`))
             ORDER BY 2
             ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      break;
      case 'day':
      $qRE = mysql_query("SELECT *,DATE(FROM_UNIXTIME(`ts`)) AS `d` FROM ".DB_PREFIX."tickets 
             $where
             GROUP BY DATE(FROM_UNIXTIME(`ts`))
             ORDER BY 2
             ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      break;
    }  
    while ($REP = mysql_fetch_object($qRE)) {
    switch ($view) {
      case 'month':
      // Open tickets..
      $C1 = mysql_fetch_object(
             mysql_query("SELECT COUNT(*) AS c FROM ".DB_PREFIX."tickets 
             $where
             AND `ticketStatus`             = 'open'
             AND `isDisputed`               = 'no'
             AND MONTH(FROM_UNIXTIME(`ts`)) = '{$REP->m}'
             AND YEAR(FROM_UNIXTIME(`ts`))  = '{$REP->y}'
             ")
            );
      // Closed tickets..      
      $C2 = mysql_fetch_object(
             mysql_query("SELECT COUNT(*) AS c FROM ".DB_PREFIX."tickets 
             $where
             AND `ticketStatus`             = 'close'
             AND `isDisputed`               = 'no'
             AND MONTH(FROM_UNIXTIME(`ts`)) = '{$REP->m}'
             AND YEAR(FROM_UNIXTIME(`ts`))  = '{$REP->y}'
             ")
            );      
      // Open disputes..
      $C3 = mysql_fetch_object(
             mysql_query("SELECT COUNT(*) AS c FROM ".DB_PREFIX."tickets 
             $where
             AND `ticketStatus`             = 'open'
             AND `isDisputed`               = 'yes'
             AND MONTH(FROM_UNIXTIME(`ts`)) = '{$REP->m}'
             AND YEAR(FROM_UNIXTIME(`ts`))  = '{$REP->y}'
             ")
            );
      // Closed disputes..      
      $C4 = mysql_fetch_object(
             mysql_query("SELECT COUNT(*) AS c FROM ".DB_PREFIX."tickets 
             $where
             AND `ticketStatus`             = 'close'
             AND `isDisputed`               = 'yes'
             AND MONTH(FROM_UNIXTIME(`ts`)) = '{$REP->m}'
             AND YEAR(FROM_UNIXTIME(`ts`))  = '{$REP->y}'
             ")
            ); 
      break;
      case 'day':
      // Open tickets..
      $C1 = mysql_fetch_object(
             mysql_query("SELECT COUNT(*) AS c FROM ".DB_PREFIX."tickets 
             $where
             AND `ticketStatus`             = 'open'
             AND `isDisputed`               = 'no'
             AND DATE(FROM_UNIXTIME(`ts`))  = '{$REP->d}'
             ")
            );
      // Closed tickets..      
      $C2 = mysql_fetch_object(
             mysql_query("SELECT COUNT(*) AS c FROM ".DB_PREFIX."tickets 
             $where
             AND `ticketStatus`             = 'close'
             AND `isDisputed`               = 'no'
             AND DATE(FROM_UNIXTIME(`ts`))  = '{$REP->d}'
             ")
            );      
      // Open disputes..
      $C3 = mysql_fetch_object(
             mysql_query("SELECT COUNT(*) AS c FROM ".DB_PREFIX."tickets 
             $where
             AND `ticketStatus`             = 'open'
             AND `isDisputed`               = 'yes'
             AND DATE(FROM_UNIXTIME(`ts`))  = '{$REP->d}'
             ")
            );
      // Closed disputes..      
      $C4 = mysql_fetch_object(
             mysql_query("SELECT COUNT(*) AS c FROM ".DB_PREFIX."tickets 
             $where
             AND `ticketStatus`             = 'close'
             AND `isDisputed`               = 'yes'
             AND DATE(FROM_UNIXTIME(`ts`))  = '{$REP->d}'
             ")
            ); 
      break;
    }  
    $cnt1 = (isset($C1->c) ? $C1->c : '0');
    $cnt2 = (isset($C2->c) ? $C2->c : '0');
    $cnt3 = (isset($C3->c) ? $C3->c : '0');
    $cnt4 = (isset($C4->c) ? $C4->c : '0');
    ?>
    <div class="reportsEntry">
      <ul>
       <li class="l1"><?php echo ($view=='day' ? date($SETTINGS->dateformat,strtotime($REP->d)) : $msg_script21[($REP->m-1)].' '.$REP->y); ?></li>
       <li class="l2"><?php echo number_format($cnt1); ?></li>
       <li class="l3"><?php echo number_format($cnt2); ?></li>
       <li class="l4"><?php echo number_format($cnt3); ?></li>
       <li class="l5"><?php echo number_format($cnt4); ?></li>
     </ul>
     <br class="clear" /> 
    </div>
    <?php
    $cns[0] = ($cns[0]+$cnt1);
    $cns[1] = ($cns[1]+$cnt2);
    $cns[2] = ($cns[2]+$cnt3);
    $cns[3] = ($cns[3]+$cnt4);
    }
    
    if (mysql_num_rows($qRE)>0) {
    ?>
    
    <div class="reportsTotals">
      <ul>
       <li class="l1">&nbsp;<?php echo $msg_reports12; ?></li>
       <li class="l2"><?php echo number_format($cns[0]); ?></li>
       <li class="l3"><?php echo number_format($cns[1]); ?></li>
       <li class="l4"><?php echo number_format($cns[2]); ?></li>
       <li class="l5"><?php echo number_format($cns[3]); ?></li>
     </ul>
     <br class="clear" /> 
    </div>
    
    <p style="margin-top:10px;padding-bottom:20px;text-align:right"> 
     <a class="export" href="index.php?p=reports&amp;ex=yes&amp;from=<?php echo $from; ?>&amp;to=<?php echo $to; ?>&amp;view=<?php echo $view; ?>&amp;dept=<?php echo $dept; ?>" title="<?php echo mswSpecialChars($msg_reports14); ?>"><?php echo $msg_reports14; ?></a>
    </p> 
    <?php
    } else {
    ?>
    <p class="nodata"><?php echo $msg_reports13; ?></p>
    <?php
    }
    ?>
    <p style="padding-top:20px">&nbsp;</p>
  </div>
  
</div>  