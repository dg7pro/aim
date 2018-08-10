<?php if(!defined('PARENT')) { exit; } 
define('EDIT_BLOCK', true);
$_GET['id'] = (int)$_GET['id'];
if (!empty($eError)) {
  foreach ($_POST AS $key => $value) {
    $SUPTICK->$key = $value;
  }
}
$curDept = '';
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
<?php
if ($SETTINGS->enableBBCode=='yes') {
?>
<link href="../bbcode.css" rel="stylesheet" type="text/css" />
<?php
}
?>
<script type="text/javascript" src="templates/js/jquery.js"></script>
<script type="text/javascript" src="templates/js/js_code.js"></script>
<script type="text/javascript" src="templates/js/overlib.js"><!-- overLIB (c) Erik Bosrup --></script>
</head>

<body>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>

<div id="bodyOverride">
<?php
if (isset($OK)) {
  $SUPTICK = mswGetTableData('tickets','id',$_GET['id']);
  echo mswActionCompletedReload(($SUPTICK->isDisputed=='yes' ? $msg_viewticket86 : $msg_viewticket23),'p=view-'.($SUPTICK->isDisputed=='yes' ? 'dispute' : 'ticket').'&amp;id='.$_GET['id']);
}
?>
<div id="windowWrapper">
<?php
if (isset($NO_ACCESS)) {
?>
  <h1><?php echo str_replace('{ticket}',mswTicketNumber($_GET['id']),($SUPTICK->isDisputed=='yes' ? $msg_viewticket85 : $msg_viewticket20)); ?></h1>
  
  <div class="editWrapper">
  
    <p class="no_access"><?php echo $msg_viewticket53; ?></p>
  
  </div>
<?php
} else {
?>
  <h1><?php echo str_replace('{ticket}',mswTicketNumber($_GET['id']),($SUPTICK->isDisputed=='yes' ? $msg_viewticket85 : $msg_viewticket20)); ?></h1>
  
  <form method="post" action="?p=edit-ticket&amp;id=<?php echo $_GET['id']; ?>">
  <div class="editWrapper">
  
    <div class="editBlock">
      
      <div class="editLeft">
        
        <label><?php echo $msg_viewticket2; ?></label>
        <input type="text" class="box" name="name" maxlength="250" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($SUPTICK->name); ?>" />
        
        <br class="clear" />
      </div>
  
      <div class="editRight">
      
        <label<?php echo (isset($eError) ? ' style="color:red"' : ''); ?>><?php echo $msg_viewticket3; ?><?php echo (isset($eError) ? ' - '.$eError : ''); ?></label>
        <input type="text" class="box" maxlength="250" tabindex="<?php echo (++$tabIndex); ?>" name="email" value="<?php echo $SUPTICK->email; ?>"<?php echo (isset($eError) ? ' style="border:1px solid red;border-left:3px solid red;"' : ''); ?> />
        
        <br class="clear" />
      </div>
      <br class="clear" />
    </div>
    
    <div class="editBlock">
      
      <div class="editLeft">
        
        <label><?php echo $msg_viewticket4.($MSTEAM->id!='1' ? ' '.mswDisplayHelpTip($msg_javascript103,'RIGHT') : ''); ?></label>
        <select name="department" tabindex="<?php echo (++$tabIndex); ?>">
        <?php
        $q_dept = mysql_query("SELECT * FROM ".DB_PREFIX."departments ".mswSQLDepartmentFilter($mswDeptFilterAccess,'WHERE')." ORDER BY `name`") 
                  or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
        while ($DEPT = mysql_fetch_object($q_dept)) {
        if ($SUPTICK->department==$DEPT->id) {
          $curDept = mswCleanData($DEPT->name);
        }
        ?>
        <option value="<?php echo $DEPT->id; ?>"<?php echo ($SUPTICK->department==$DEPT->id ? ' selected="selected"' : ''); ?>><?php echo mswCleanData($DEPT->name); ?></option>
        <?php
        }
        ?>
        </select>
        
        <br class="clear" />
      </div>
  
      <div class="editRight">
      
        <label><?php echo $msg_viewticket9; ?></label>
        <select name="priority" tabindex="<?php echo (++$tabIndex); ?>">
         <?php
         foreach ($ticketLevelSel AS $k => $v) {
         ?>
         <option value="<?php echo $k; ?>"<?php echo ($SUPTICK->priority==$k ? ' selected="selected"' : ''); ?>><?php echo $v; ?></option>
         <?php
         }
         ?>
        </select>
      
        <br class="clear" />
      </div>
      <br class="clear" />
    </div>
    
    <div class="editBlock">
      
      <div class="editLeft">
        
        <label><?php echo $msg_viewticket25; ?></label>
        <input type="text" class="box" name="subject" maxlength="250" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($SUPTICK->subject); ?>" />
        
        <br class="clear" />
      </div>
      
      <div class="editRight">
        
        <label><?php echo $msg_viewticket79; ?> <?php echo mswDisplayHelpTip($msg_javascript126); ?></label>
        <select name="tickLang" tabindex="<?php echo (++$tabIndex); ?>">
        <?php
        $showlang = opendir(REL_PATH.'templates/language');
        while (false!==($read=readdir($showlang))) {
        if (is_dir(REL_PATH.'templates/language/'.$read) && !in_array($read,array('.','..'))) {
        ?>
        <option<?php echo ($read==$SUPTICK->tickLang ? ' selected="selected"' : ''); ?>><?php echo $read; ?></option>
        <?php
        }
        }
        closedir($showlang);
        ?>
        </select>
        
        <br class="clear" />
      </div>
    </div>
    
    <div class="editBlock">
      <label><?php echo $msg_viewticket22; ?></label>
      <?php
      if ($SETTINGS->enableBBCode=='yes') {
        define('INFO_LINK','yes');
        include(PATH.'templates/system/bbcode-buttons.php');
      }
      ?>
      <textarea rows="6" cols="40" name="comments" id="comments" tabindex="<?php echo (++$tabIndex); ?>"><?php echo mswSpecialChars($SUPTICK->comments); ?></textarea>
    </div>
    
    <?php
    // Custom fields..
    $qF = mysql_query("SELECT * FROM ".DB_PREFIX."cusfields
          WHERE FIND_IN_SET('ticket',`fieldLoc`) > 0
          AND `enField`                          = 'yes'
          ORDER BY `orderBy`
          ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    if (mysql_num_rows($qF)>0) {
    while ($FIELDS = mysql_fetch_object($qF)) {
      // Does data exist..
      $TF = mswGetTableData('ticketfields','ticketID',$_GET['id'],' AND `replyID` = \'0\' AND `fieldID` = \''.$FIELDS->id.'\'');
      switch ($FIELDS->fieldType) {
        case 'textarea':
        echo $MSFM->buildTextArea(mswCleanData($FIELDS->fieldInstructions),$FIELDS->id,(isset($TF->fieldData) ? $TF->fieldData : ''));
        break;
        case 'input':
        echo $MSFM->buildInputBox(mswCleanData($FIELDS->fieldInstructions),$FIELDS->id,(isset($TF->fieldData) ? $TF->fieldData : ''));
        break;
        case 'select':
        echo $MSFM->buildSelect(mswCleanData($FIELDS->fieldInstructions),$FIELDS->id,$FIELDS->fieldOptions,(isset($TF->fieldData) ? $TF->fieldData : ''));
        break;
        case 'checkbox':
        echo $MSFM->buildCheckBox(mswCleanData($FIELDS->fieldInstructions),$FIELDS->id,$FIELDS->fieldOptions,(isset($TF->fieldData) ? $TF->fieldData : ''));
        break;
      }
    }
    }
    
    // If more than a single user, add box for edit explanation..
    if (mswRowCount('users')>1) {
    ?>
    <div class="editBlock">
      <label><?php echo $msg_viewticket51; ?> <?php echo mswDisplayHelpTip($msg_javascript98,'RIGHT'); ?></label>
      <textarea rows="6" cols="40" name="explain" tabindex="<?php echo (++$tabIndex); ?>"></textarea>
    </div>
    <?php
    }
    ?>
    
    <p class="buttonWrapper">
      <input type="hidden" name="process" value="1" />
      <input type="hidden" name="odeptid" value="<?php echo $SUPTICK->department; ?>" />
      <input type="submit" class="button" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars(($SUPTICK->isDisputed=='yes' ? $msg_viewticket88 : $msg_viewticket21)); ?>" title="<?php echo mswSpecialChars(($SUPTICK->isDisputed=='yes' ? $msg_viewticket88 : $msg_viewticket21)); ?>" />
    </p> 
    <p>&nbsp;</p>
    
  </div>  
  </form>
<?php
}
?>
</div>

</div>

</body>

</html>