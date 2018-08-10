<?php if(!defined('PARENT')) { exit; } 
// Error/Warning/Messages..
if (isset($_GET['noaccess'])) {
?>
<div class="errorHeader">
  <p class="noaccess"><?php echo $msg_home11; ?></p>
</div>
<?php
}
if (DEV_STATUS=='OFF') {
if (is_dir(REL_PATH.'install') && $MSTEAM->id=='1') {
?>
<div class="errorHeader" id="ew_1">
  <p class="noaccess"><?php echo $msg_home23; ?></p>
</div>
<?php
}
if (ENABLE_MYSQL_ERRORS && $MSTEAM->id=='1') {
?>
<div class="errorHeader" id="ew_3">
  <p class="noaccess"><?php echo $msg_home24; ?></p>
</div>
<?php
}
}
// For graphs..
$buildGraph  = $MSGRAPH->homepageGraphData();
$boomOne     = explode(',',$buildGraph[0]);
$boomTwo     = explode(',',$buildGraph[1]);
if (!isset($_GET['range'])) {
  $_GET['range'] = ADMIN_HOME_DEFAULT_SALES_VIEW;
}
?>

<div class="homeWrapper">

  <div id="innerArea">
  
    <div id="homeLeft">
      
      <div class="graph">
        <h2 style="border-top:0">
         <span class="select">
          <select onchange="location=this.options[this.selectedIndex].value">
           <option value="?range=today"><?php echo $msg_home33; ?></option>
           <option value="?range=week"<?php echo (isset($_GET['range']) && $_GET['range']=='week' ? ' selected="selected"' : ''); ?>><?php echo $msg_home34; ?></option>
           <option value="?range=month"<?php echo (isset($_GET['range']) && $_GET['range']=='month' ? ' selected="selected"' : ''); ?>><?php echo $msg_home35; ?></option>
           <option value="?range=year"<?php echo (isset($_GET['range']) && $_GET['range']=='year' ? ' selected="selected"' : ''); ?>><?php echo $msg_home36; ?></option>
          </select>
         </span>
         <?php
         if ((in_array('open',$userAccess) && in_array('disputes',$userAccess)) || $MSTEAM->id=='1') {
         ?>
         <span class="ts"><?php echo $msg_home37; ?></span>
         <span class="ds"><?php echo $msg_home38; ?></span>
         <?php
         } else {
         if (in_array('open',$userAccess) || in_array('close',$userAccess)) {
         ?>
         <span class="ts"><?php echo $msg_home37; ?></span>
         <?php
         if (!in_array('disputes',$userAccess) && !in_array('cdisputes',$userAccess)) {
         ?>
         <span class="blank"></span>
         <?php
         }
         }
         if (in_array('disputes',$userAccess) || in_array('cdisputes',$userAccess) || $MSTEAM->id=='1') {
         ?>
         <span class="ds"><?php echo $msg_home38; ?></span>
         <?php
         if (!in_array('open',$userAccess) && !in_array('close',$userAccess)) {
         ?>
         <span class="blank"></span>
         <?php
         }
         }
         }
         ?>
        </h2>
        <div class="stats">
        <?php
        if (array_sum($boomOne)>0 || array_sum($boomTwo)>0) {
        ?>
        <div id="chartgraph"></div>
        <script type="text/javascript">
        //<![CDATA[
        jQuery(document).ready(function() {  
          <?php
          if (in_array('open',$userAccess) || $MSTEAM->id=='1') {
          ?>
          line1 = [<?php echo $buildGraph[0]; ?>];
          <?php
          }
          if (in_array('disputes',$userAccess) || $MSTEAM->id=='1') {
          ?>
          line2 = [<?php echo $buildGraph[1]; ?>];
          <?php
          }
          ?>
          ticks = [<?php echo $buildGraph[2]; ?>];
          <?php
          if ((in_array('open',$userAccess) && in_array('disputes',$userAccess)) || $MSTEAM->id=='1') {
          ?>
          plot1 = $.jqplot('chartgraph', [line1,line2], {
          <?php
          } else {
          if (in_array('open',$userAccess)) {
          ?>
          plot1 = $.jqplot('chartgraph', [line1], {
          <?php
          }
          if (in_array('disputes',$userAccess)) {
          ?>
          plot1 = $.jqplot('chartgraph', [line2], {
          <?php
          }
          }
          ?>
            grid: {
              borderWidth: 0,
              shadow: false
            },
            axes: {
              yaxis: {
                min: 0,
                tickOptions: {
                  formatString: '%d'
                }
              },
              xaxis: { 
                rendererOptions: {
                  tickRenderer: $.jqplot.CanvasAxisTickRenderer
                },
                ticks:ticks,
                  renderer: $.jqplot.CategoryAxisRenderer
                }
              },
              series: [{
                lineWidth: 1
              },{
              lineWidth: 1
            }],
            legend: {
              show: false
            }
          });
        });
        //]]>
        </script>
        <?php
        } else {
        ?>
        <div id="chartgraph_nostats"></div>
        <?php
        }
        ?>
        </div>
      </div>
      
      <?php
      if (ADMIN_HOME_LATEST_AD_TICKETS>0) {
      if (in_array('open',$userAccess) || $MSTEAM->id=='1') {
      ?>
      <div class="tickets">
        <h2 style="border-top:0"><?php echo str_replace('{count}',ADMIN_HOME_LATEST_AD_TICKETS,$msg_home31); ?></h2>
        <div class="data">
          <?php
          $qT1 = mysql_query("SELECT * FROM ".DB_PREFIX."tickets 
                 WHERE `replyStatus` IN ('start','admin') 
                 AND `ticketStatus`   = 'open' 
                 AND `isDisputed`     = 'no'
                 AND `assignedto`    != 'waiting'
                 ".mswSQLDepartmentFilter($ticketFilterAccess)."
                 ".ADMIN_HOME_TICKET_ORDERING."
                 LIMIT ".ADMIN_HOME_LATEST_AD_TICKETS."
                 ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
          if (mysql_num_rows($qT1)>0) {
          while ($TICKETS = mysql_fetch_object($qT1)) {
          $qLT1  = mysql_query("SELECT * FROM ".DB_PREFIX."replies 
                   WHERE `ticketID` = '{$TICKETS->id}' 
                   ORDER BY id DESC 
                   LIMIT 1
                   ")
                   or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
          $LT1   = mysql_fetch_object($qLT1);
          $date  = (isset($LT1->ts) ? mswDateDisplay($LT1->ts,$SETTINGS->dateformat) : 'N/A');
          ?>
          <p class="links">
           <a href="?p=view-ticket&amp;id=<?php echo $TICKETS->id; ?>" title="<?php echo mswSpecialChars($msg_open7); ?>"><?php echo mswSpecialChars($TICKETS->subject); ?></a>
           <span class="detailsBar"><?php echo str_replace(array('{name}','{priority}','{date}'),array(mswSpecialChars($TICKETS->name),mswGetPriorityLevel($TICKETS->priority),$date),$msg_home44); ?></span>
          </p>
          <?php
          }
          } else {
          ?>
          <p class="none"><?php echo $msg_home41; ?></p>
          <?php
          }
          ?>
        </div>
      </div>
      <?php
      }
      }
      
      if (ADMIN_HOME_LATEST_VIS_TICKETS>0) {
      if (in_array('open',$userAccess) || $MSTEAM->id=='1') {
      ?>
      <div class="tickets">
        <h2 style="border-top:0"><?php echo str_replace('{count}',ADMIN_HOME_LATEST_VIS_TICKETS,$msg_home39); ?></h2>
        <div class="data">
         <?php
          $qT2 = mysql_query("SELECT * FROM ".DB_PREFIX."tickets 
                 WHERE `replyStatus` IN ('visitor') 
                 AND `ticketStatus`   = 'open' 
                 AND `isDisputed`     = 'no'
                 AND `assignedto`    != 'waiting'
                 ".mswSQLDepartmentFilter($ticketFilterAccess)."
                 ".ADMIN_HOME_TICKET_ORDERING."
                 LIMIT ".ADMIN_HOME_LATEST_VIS_TICKETS."
                 ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
          if (mysql_num_rows($qT2)>0) {
          while ($TICKETS = mysql_fetch_object($qT2)) {
          $qLT2  = mysql_query("SELECT * FROM ".DB_PREFIX."replies 
                   WHERE `ticketID` = '{$TICKETS->id}' 
                   ORDER BY id DESC 
                   LIMIT 1
                   ")
                   or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
          $LT2   = mysql_fetch_object($qLT2);
          $date  = (isset($LT2->ts) ? mswDateDisplay($LT2->ts,$SETTINGS->dateformat) : 'N/A');
          ?>
          <p class="links">
           <a href="?p=view-ticket&amp;id=<?php echo $TICKETS->id; ?>" title="<?php echo mswSpecialChars($msg_open7); ?>"><?php echo mswSpecialChars($TICKETS->subject); ?></a>
           <span class="detailsBar"><?php echo str_replace(array('{name}','{priority}','{date}'),array(mswSpecialChars($TICKETS->name),mswGetPriorityLevel($TICKETS->priority),$date),$msg_home44); ?></span>
          </p>
          <?php
          }
          } else {
          ?>
          <p class="none"><?php echo $msg_home41; ?></p>
          <?php
          }
          ?>
        </div>
      </div>
      <?php
      }
      }
      
      if (ADMIN_HOME_LATEST_AD_DISPUTES>0) {
      if (in_array('disputes',$userAccess) || $MSTEAM->id=='1') {
      ?>
      <div class="tickets">
        <h2 style="border-top:0"><?php echo str_replace('{count}',ADMIN_HOME_LATEST_AD_DISPUTES,$msg_home32); ?></h2>
        <div class="data">
          <?php
          $qT3 = mysql_query("SELECT * FROM ".DB_PREFIX."tickets 
                 WHERE `replyStatus` IN ('start','admin') 
                 AND `ticketStatus`   = 'open' 
                 AND `isDisputed`     = 'yes'
                 AND `assignedto`    != 'waiting'
                 ".mswSQLDepartmentFilter($ticketFilterAccess)."
                 ".ADMIN_HOME_TICKET_ORDERING."
                 LIMIT ".ADMIN_HOME_LATEST_AD_DISPUTES."
                 ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
          if (mysql_num_rows($qT3)>0) {
          while ($TICKETS = mysql_fetch_object($qT3)) {
          $tcnt = number_format(mswRowCount('disputes WHERE ticketID = \''.$TICKETS->id.'\''));
          $qLT3  = mysql_query("SELECT * FROM ".DB_PREFIX."replies 
                   WHERE `ticketID` = '{$TICKETS->id}' 
                   ORDER BY id DESC 
                   LIMIT 1
                   ")
                   or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
          $LT3   = mysql_fetch_object($qLT3);
          $date  = (isset($LT3->ts) ? mswDateDisplay($LT3->ts,$SETTINGS->dateformat) : 'N/A');
          ?>
          <p class="links">
           <a href="?p=view-dispute&amp;id=<?php echo $TICKETS->id; ?>" title="<?php echo mswSpecialChars($msg_open24); ?>"><?php echo mswSpecialChars($TICKETS->subject); ?></a>
           <span class="detailsBar"><?php echo str_replace(array('{name}','{priority}','{count}','{date}'),array(mswSpecialChars($TICKETS->name),mswGetPriorityLevel($TICKETS->priority),mswUsersInDispute($TICKETS,$tcnt),$date),$msg_home45); ?></span>
          </p>
          <?php
          }
          } else {
          ?>
          <p class="none"><?php echo $msg_home41; ?></p>
          <?php
          }
          ?>
        </div>
      </div>
      <?php
      }
      }
      
      if (ADMIN_HOME_LATEST_VIS_DISPUTES>0) {
      if (in_array('disputes',$userAccess) || $MSTEAM->id=='1') {
      ?>
      <div class="tickets">
        <h2 style="border-top:0"><?php echo str_replace('{count}',ADMIN_HOME_LATEST_VIS_DISPUTES,$msg_home40); ?></h2>
        <div class="data">
          <?php
          $qT4 = mysql_query("SELECT * FROM ".DB_PREFIX."tickets 
                 WHERE `replyStatus` IN ('visitor') 
                 AND `ticketStatus`   = 'open' 
                 AND `isDisputed`     = 'yes'
                 AND `assignedto`    != 'waiting'
                 ".mswSQLDepartmentFilter($ticketFilterAccess)."
                 ".ADMIN_HOME_TICKET_ORDERING."
                 LIMIT ".ADMIN_HOME_LATEST_VIS_DISPUTES."
                 ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
          if (mysql_num_rows($qT4)>0) {
          while ($TICKETS = mysql_fetch_object($qT4)) {
          $tcnt  = number_format(mswRowCount('disputes WHERE `ticketID` = \''.$TICKETS->id.'\''));
          $qLT4  = mysql_query("SELECT * FROM ".DB_PREFIX."replies 
                   WHERE `ticketID` = '{$TICKETS->id}' 
                   ORDER BY id DESC 
                   LIMIT 1
                   ")
                   or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
          $LT4   = mysql_fetch_object($qLT4);
          $date  = (isset($LT4->ts) ? mswDateDisplay($LT4->ts,$SETTINGS->dateformat) : 'N/A');
          ?>
          <p class="links">
           <a href="?p=view-dispute&amp;id=<?php echo $TICKETS->id; ?>" title="<?php echo mswSpecialChars($msg_open24); ?>"><?php echo mswSpecialChars($TICKETS->subject); ?></a>
           <span class="detailsBar"><?php echo str_replace(array('{name}','{priority}','{count}','{date}'),array(mswSpecialChars($TICKETS->name),mswGetPriorityLevel($TICKETS->priority),mswUsersInDispute($TICKETS,$tcnt),$date),$msg_home45); ?></span>
          </p>
          <?php
          }
          } else {
          ?>
          <p class="none"><?php echo $msg_home41; ?></p>
          <?php
          }
          ?>
        </div>
      </div>
      <?php
      }
      }
      ?>
      
      <br class="clear" />
    </div>
  
    <div id="homeRight">
      <?php
      if (ADMIN_TICKET_OVERVIEW) {
      if (in_array('open',$userAccess) || in_array('close',$userAccess) || $MSTEAM->id=='1') {
      ?>
      <div class="homeRightInner">
       <h2 style="border-top:0" class="tickets"><?php echo $msg_home3; ?></h2>
       <?php
       if (in_array('assign',$userAccess) || $MSTEAM->id=='1') {
       define('M_T',1);
       ?>
       <p style="padding-top:10px"><?php echo $msg_home46; ?>: <span class="highlight"><a href="?p=assign"><?php echo mswRowCount('tickets WHERE `replyStatus` = \'start\' AND `ticketStatus` = \'open\' AND `assignedto` = \'waiting\' AND `isDisputed` = \'no\' '.mswSQLDepartmentFilter($ticketFilterAccess)); ?></a></span></p>
       <?php
       }
       if (in_array('open',$userAccess) || $MSTEAM->id=='1') {
       ?>
       <p<?php echo (!defined('M_T') ? ' style="padding-top:10px"' : ''); ?>><?php echo $msg_home4; ?>: <span class="highlight"><a href="?p=open&amp;status=start"><?php echo mswRowCount('tickets WHERE `replyStatus` = \'start\' AND `ticketStatus` = \'open\' AND `assignedto` != \'waiting\' AND `isDisputed` = \'no\' '.mswSQLDepartmentFilter($ticketFilterAccess)); ?></a></span></p>
       <p><?php echo $msg_home5; ?>: <span class="highlight"><a href="?p=open&amp;status=adminonly"><?php echo mswRowCount('tickets WHERE `replyStatus` = \'admin\' AND `ticketStatus` = \'open\' AND `assignedto` != \'waiting\' AND `isDisputed` = \'no\' '.mswSQLDepartmentFilter($ticketFilterAccess)); ?></a></span></p>
       <p><?php echo $msg_home6; ?>: <span class="highlight"><a href="?p=open&amp;status=visitor"><?php echo mswRowCount('tickets WHERE `replyStatus` = \'visitor\' AND `ticketStatus` = \'open\' AND `assignedto` != \'waiting\' AND `isDisputed` = \'no\' '.mswSQLDepartmentFilter($ticketFilterAccess)); ?></a></span></p>
       <?php
       }
       if (in_array('close',$userAccess) || $MSTEAM->id=='1') {
       ?>
       <p style="padding-bottom:10px"><?php echo $msg_home7; ?>: <span class="highlight"><a href="?p=close"><?php echo mswRowCount('tickets WHERE `ticketStatus` != \'open\' AND `assignedto` != \'waiting\' AND `isDisputed` = \'no\' '.mswSQLDepartmentFilter($ticketFilterAccess)); ?></a></span></p>
       <?php
       }
       ?>
      </div>
      <?php
      }
      }
      
      if (ADMIN_DISPUTE_OVERVIEW) {
      if (in_array('disputes',$userAccess) || in_array('cdisputes',$userAccess) || $MSTEAM->id=='1') {
      ?>
      <div class="homeRightInner" style="margin-top:5px">
       <h2 style="border-top:0" class="disputes"><?php echo $msg_home29; ?></h2>
       <?php
       if (in_array('assign',$userAccess) || $MSTEAM->id=='1') {
       $disWaitAssign = mswRowCount('tickets WHERE `replyStatus` = \'start\' AND `ticketStatus` = \'open\' AND `assignedto` = \'waiting\' AND `isDisputed` = \'yes\' '.mswSQLDepartmentFilter($ticketFilterAccess));
       if ($disWaitAssign>0) {
       define('M_T_1',1);
       ?>
       <p style="padding-top:10px"><?php echo $msg_home47; ?>: <span class="highlight"><a href="?p=assign"><?php echo $disWaitAssign; ?></a></span></p>
       <?php
       }
       }
       if (in_array('disputes',$userAccess) || $MSTEAM->id=='1') {
       ?>
       <p<?php echo (!defined('M_T_1') ? ' style="padding-top:10px"' : ''); ?>><?php echo $msg_home43; ?>: <span class="highlight"><a href="?p=disputes&amp;status=start"><?php echo mswRowCount('tickets WHERE `replyStatus` = \'start\' AND `ticketStatus` = \'open\' AND `assignedto` != \'waiting\' AND `isDisputed` = \'yes\' '.mswSQLDepartmentFilter($ticketFilterAccess)); ?></a></span></p>
       <p><?php echo $msg_home26; ?>: <span class="highlight"><a href="?p=disputes&amp;status=adminonly"><?php echo mswRowCount('tickets WHERE `replyStatus` IN (\'admin\',\'start\') AND `ticketStatus` = \'open\' AND `assignedto` != \'waiting\' AND `isDisputed` = \'yes\' '.mswSQLDepartmentFilter($ticketFilterAccess)); ?></a></span></p>
       <p><?php echo $msg_home27; ?>: <span class="highlight"><a href="?p=disputes&amp;status=visitor"><?php echo mswRowCount('tickets WHERE `replyStatus` = \'visitor\' AND `ticketStatus` = \'open\' AND `assignedto` != \'waiting\' AND `isDisputed` = \'yes\' '.mswSQLDepartmentFilter($ticketFilterAccess)); ?></a></span></p>
       <?php
       }
       if (in_array('cdisputes',$userAccess) || $MSTEAM->id=='1') {
       ?>
       <p style="padding-bottom:10px"><?php echo $msg_home28; ?>: <span class="highlight"><a href="?p=cdisputes"><?php echo mswRowCount('tickets WHERE `ticketStatus` != \'open\' AND `assignedto` != \'waiting\' AND `isDisputed` = \'yes\' '.mswSQLDepartmentFilter($ticketFilterAccess)); ?></a></span></p>
       <?php
       }
       ?>
      </div>
      <?php
      }
      }
      
      if (ADMIN_SYSTEM_OVERVIEW && $MSTEAM->id=='1') {
      ?>
      <div class="homeRightInner" style="margin-top:5px">
       <h2 style="border-top:0" class="system"><?php echo $msg_home2; ?></h2>
       <p style="padding-top:10px"><?php echo str_replace(array('{users}','{dept}'),array(mswRowCount('users'),mswRowCount('departments')),$msg_home8); ?></p>
       <p><?php echo str_replace(array('{imap}'),array(mswRowCount('imap')),$msg_home48); ?></p>
       <p><?php echo str_replace(array('{fields}'),array(mswRowCount('cusfields')),$msg_home49); ?></p>
       <p><?php echo str_replace(array('{responses}'),array(mswRowCount('responses')),$msg_home9); ?></p>
       <p style="padding-bottom:10px"><?php echo str_replace(array('{questions}','{cats}','{attachments}'),array(mswRowCount('faq'),mswRowCount('categories'),mswRowCount('faqattach')),$msg_home10); ?></p>
      </div>
      <?php
      }
      
      // Quick links..
      include(PATH.'templates/quick-links.php');
      ?>
      
      <br class="clear" />
    </div>
  
    <br class="clear" />
  </div>
  
</div>  