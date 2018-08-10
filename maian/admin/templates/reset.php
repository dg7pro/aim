<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=<?php echo $msg_charset; ?>" />
<title><?php echo ($title ? mswSpecialChars($title).': ' : '').mswSpecialChars($msg_script.' '.$msg_script2).' - '.mswSpecialChars($msg_adheader).(LICENCE_VER!='unlocked' ? ' (Free Version)' : '').(mswCheckBetaVersion()=='yes' ? ' - BETA VERSION' : ''); ?></title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.js"></script>
<script type="text/javascript" src="templates/js/js_code.js"></script>
<link rel="SHORTCUT ICON" href="favicon.ico" />
<script type="text/javascript">
//<![CDATA[
function showHidePass(id) {
  var cur = jQuery('#'+id).attr('type');
  switch (cur) {
    case 'text':
    jQuery('#'+id)[0].type = 'password';
    break;
    case 'password':
    jQuery('#'+id)[0].type = 'text';
    break;
  }
}
//]]>
</script>
</head>

<body>

<form method="post" action="?p=reset">
<div class="passReset">

  <h1><?php echo $msg_adheader36; ?></h1>
  
  <?php
  if (isset($OK)) {
    echo mswActionCompletedReset($msg_passreset6);
  }
  ?>
  
  <p><?php echo $msg_passreset; ?></p>
  
  <div class="users">
  <?php
  $q = mysql_query("SELECT * FROM ".DB_PREFIX."users ORDER BY `id`")
       or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  while ($U = mysql_fetch_object($q)) {
  ?>
  <div class="user">
  
    <h2><?php echo mswSpecialChars($U->name); ?></h2>
    
    <div class="left">
      <?php echo $msg_passreset2; ?>: <input type="text" name="email[]" value="<?php echo $U->email; ?>" class="box" />
      <input type="hidden" name="id[]" value="<?php echo $U->id; ?>" />
    </div>
    
    <div class="right">
      <?php echo $msg_passreset3; ?>: <input type="password" id="ps_<?php echo $U->id; ?>" name="password[]" value="" class="box" />
      <input type="hidden" name="password2[]" value="<?php echo $U->accpass; ?>" />
      <img onclick="showHidePass('ps_<?php echo $U->id; ?>')" src="templates/images/small-preview.png" alt="<?php echo mswSpecialChars($msg_passreset5); ?>" title="<?php echo mswSpecialChars($msg_passreset5); ?>" />
    </div>
    
    <br class="clear" />
  
  </div>
  <?php
  }
  ?>
  </div>
  
  <div class="buttonWrapper" style="padding-bottom:20px"> 
    <input type="hidden" name="process" value="1" />
    <input class="button" type="submit" value="<?php echo mswSpecialChars($msg_passreset4); ?>" title="<?php echo mswSpecialChars($msg_passreset4); ?>" />
  </div> 

</div>
</form>

</body>
</html>