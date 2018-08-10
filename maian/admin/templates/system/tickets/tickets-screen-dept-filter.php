        <?php
        if(!defined('PARENT')) { exit; } 
        // If global log in no filter necessary..
        if ($MSTEAM->id!='1') {
        ?>  
        <option value="0">- - - - - -</option>
        <?php
        } else {
        ?>
        <option value="?p=<?php echo $_GET['p']; ?>"><?php echo $msg_open2 ; ?></option>
        <?php
        }
        $q_dept = mysql_query("SELECT * FROM ".DB_PREFIX."departments ".mswSQLDepartmentFilter($mswDeptFilterAccess,'WHERE')." ORDER BY `name`") 
                  or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
        while ($DEPT = mysql_fetch_object($q_dept)) {
        ?>
        <option value="?p=<?php echo $_GET['p']; ?>&amp;dept=<?php echo $DEPT->id.(isset($_GET['priority']) ? '&amp;priority='.$_GET['priority'] : ''); ?>"<?php echo (isset($_GET['dept']) && $_GET['dept']==$DEPT->id ? ' selected="selected"' : ''); ?>><?php echo mswCleanData($DEPT->name); ?></option>
        <?php
        }
        // For administrator, show all assigned users in filter..
        if ($MSTEAM->id=='1') {
        $q_users     = mysql_query("SELECT * FROM ".DB_PREFIX."users ORDER BY `name`") 
                       or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
        while ($U = mysql_fetch_object($q_users)) {
        ?>
        <option value="?p=<?php echo $_GET['p']; ?>&amp;dept=u<?php echo $U->id.(isset($_GET['priority']) ? '&amp;priority='.$_GET['priority'] : ''); ?>"<?php echo (isset($_GET['dept']) && $_GET['dept']=='u'.$U->id ? ' selected="selected"' : ''); ?>><?php echo $msg_open31.' '.mswCleanData($U->name); ?></option>
        <?php
        }
        }
        ?>