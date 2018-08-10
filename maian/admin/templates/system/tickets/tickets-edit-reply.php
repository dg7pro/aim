<?php if(!defined('PARENT')) { exit; } 
define('EDIT_BLOCK', true);
$_GET['id']    = (int)$_GET['id'];
$_GET['edit']  = (int)$_GET['edit'];
$EDIT          = mswGetTableData('replies','id',$_GET['edit']); 
if (file_exists(PATH.'templates/header-custom.php')) {
  include_once(PATH.'templates/header-custom.php');
} else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
}
$filterType = ($EDIT->replyType=='admin' ? 'admin' : 'reply');
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
</head>

<body>

<div id="bodyOverride">
<?php
if (isset($_GET['ok'])) {
  echo mswActionCompletedReload($msg_viewticket38,'p=view-'.($SUPTICK->isDisputed=='yes' ? 'dispute' : 'ticket').'&amp;id='.$_GET['id']);
}
?>
<div id="windowWrapper">

  <h1><?php echo str_replace('{ticket}',mswTicketNumber($_GET['id']),($SUPTICK->isDisputed=='yes' ? $msg_viewticket87 : $msg_viewticket36)); ?></h1>
  
  <form method="post" action="?p=view-ticket&amp;id=<?php echo $_GET['id']; ?>">
  <div class="editWrapper">
  
    <div class="editBlock">
      <label><?php echo $msg_viewticket22; ?></label>
      <?php
      if ($SETTINGS->enableBBCode=='yes') {
        define('INFO_LINK','yes');
        include(PATH.'templates/system/bbcode-buttons.php');
      }
      ?>
      <textarea rows="10" cols="40" name="comments" id="comments" tabindex="<?php echo (++$tabIndex); ?>"><?php echo (isset($EDIT->comments) ? mswSpecialChars($EDIT->comments) : ''); ?></textarea>
    </div> 
    
    <?php
    // Custom fields..
    $qF = mysql_query("SELECT * FROM ".DB_PREFIX."cusfields
          WHERE FIND_IN_SET('$filterType',`fieldLoc`) > 0
          AND `enField`                               = 'yes'
          ORDER BY `orderBy`
          ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    if (mysql_num_rows($qF)>0) {
    while ($FIELDS = mysql_fetch_object($qF)) {
      // Does data exist..
      $TF = mswGetTableData('ticketfields','ticketID',$_GET['id'],' AND replyID = \''.$_GET['edit'].'\' AND fieldID = \''.$FIELDS->id.'\'');
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
    ?>
    
    <p class="buttonWrapper"><br />
      <input type="hidden" name="process" value="1" />
      <input type="hidden" name="edit" value="<?php echo $_GET['edit']; ?>" />
      <input tabindex="<?php echo (++$tabIndex); ?>" type="submit" class="button" value="<?php echo mswSpecialChars(($SUPTICK->isDisputed=='yes' ? $msg_viewticket89 : $msg_viewticket37)); ?>" title="<?php echo mswSpecialChars(($SUPTICK->isDisputed=='yes' ? $msg_viewticket89 : $msg_viewticket37)); ?>" /><br /><br />
    </p> 
    
  </div>  
  </form>

</div>

</div>

</body>

</html>
