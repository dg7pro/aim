<?php if (!defined('PARENT')) { die('You do not have permission to view this file!!!'); } 
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
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=<?php echo $msg_charset; ?>" />
<title><?php echo ($title ? mswSpecialChars($title).': ' : '').mswSpecialChars($msg_login); ?></title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.js"></script>
<style type="text/css">
  body {
    padding-top:100px;
  }
</style>
<?php
if (COOKIE_NAME) {
?>
<script type="text/javascript" src="templates/js/overlib.js"><!-- overLIB (c) Erik Bosrup --></script>
<?php
}
?>
<link rel="SHORTCUT ICON" href="favicon.ico" />
</head>


<body onload="jQuery('#user').focus()">
<?php
if (COOKIE_NAME) {
?>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<?php
}
?>
<script type="text/javascript">
//<![CDATA[
function checkform(form) {
  var message = '';
  if (jQuery('#user').val()=='') {
    message += '- <?php echo mswSpecialChars($msg_login6); ?>\n';
  }
  if (jQuery('#pass').val()=='') {
    message +='- <?php echo mswSpecialChars($msg_login7); ?>\n';
  }
  if (message) {
    alert(message);
    return false;
  }
}
//]]>
</script>

<div id="loginWrapper">

<div id="loginHeader">
 <p><?php echo ($title ? $title.': ' : '').$msg_login; ?></p>
</div>

<div id="loginContent">
 <form method="post" id="form" action="?p=login" onsubmit="return checkform(this)">
 <p><label><?php echo $msg_login8; ?>:</label>
 <input tabindex="<?php echo (++$tabIndex); ?>" class="box" onkeyup="jQuery('#e_user').hide('slow')" type="text" id="user" name="user" value="<?php echo (isset($_POST['user']) ? mswSpecialChars($_POST['user']) : ''); ?>" />
 <?php echo (isset($U_ERROR) ? '<span class="error" id="e_user">'.$msg_login6.'</span>' : ''); ?>
 <label><?php echo $msg_login2; ?>:</label>
 <input tabindex="<?php echo (++$tabIndex); ?>" class="box" onkeyup="jQuery('#e_pass').hide('slow')" type="password" name="pass" id="pass" value="" />
 <?php echo (isset($P_ERROR) ? '<span class="error" id="e_pass">'.$msg_login4.'</span>' : '');
 // Is cookie set? 
 if (COOKIE_NAME) {
 ?>
 <span style="display:block;margin-top:10px"><input tabindex="<?php echo (++$tabIndex); ?>" type="checkbox" name="cookie" value="1" /> <?php echo $msg_login3; ?> <?php echo mswDisplayHelpTip($msg_javascript79); ?></span> 
 <?php
 } else {
 ?>
 <span style="display:block">&nbsp;</span>
 <?php
 }
 ?>
 <input type="hidden" name="process" value="1" /><br />
 <input class="button" tabindex="<?php echo (++$tabIndex); ?>" type="submit" value="<?php echo mswSpecialChars($msg_login5); ?> &raquo;" title="<?php echo mswSpecialChars($msg_login5); ?>" />
 </p>
 </form>
</div>

</div>

</body>

</html>
