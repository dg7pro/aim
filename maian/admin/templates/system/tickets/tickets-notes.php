<?php if(!defined('PARENT')) { exit; } 
$_GET['notes'] = (int)$_GET['notes'];
if ($_GET['notes']>0) {
  $NOTES = mswGetTableData('tickets','id',$_GET['notes']);
} else {
  exit;
}
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
<title><?php echo mswSpecialChars($msg_viewticket55); ?></title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div id="bodyOverride">
<?php
if (isset($OK)) {
  echo mswActionCompletedReload($msg_javascript117,'p=view-ticket&amp;id='.$NOTES->id);
}
?>
<div id="windowWrapper">

<h1><span class="float"><img style="cursor:pointer" onclick="window.print()" src="templates/images/print.png" alt="<?php echo mswSpecialChars($msg_script14); ?>" title="<?php echo mswSpecialChars($msg_script14); ?>" /></span><?php echo str_replace('{ticket}',mswTicketNumber($_GET['notes']),($NOTES->isDisputed=='yes' ? $msg_viewticket83 : $msg_viewticket74)); ?></h1>

<p style="padding:10px 5px 5px 5px">
<?php
echo (isset($NOTES->ticketNotes) && $NOTES->ticketNotes ? nl2br(mswSpecialChars($NOTES->ticketNotes)) : ($NOTES->isDisputed=='yes' ? $msg_viewticket82 : $msg_viewticket73)); 
?>
</p>

<form method="post" action="?p=view-ticket&amp;notes=<?php echo $_GET['notes']; ?>">

<h1 style="margin:10px 0 0 0"><?php echo $msg_viewticket77; ?></h1>
  
<div class="editNotes">
  <textarea rows="10" cols="40" name="notes" tabindex="<?php echo (++$tabIndex); ?>"><?php echo mswSpecialChars($NOTES->ticketNotes); ?></textarea>
</div>

<p class="buttonWrapper" style="text-align:center;padding:10px 0 10px 0">
  <input type="hidden" name="updateNotes" value="1" />
  <input type="submit" class="button" tabindex="<?php echo (++$tabIndex); ?>" value="<?php echo mswSpecialChars($msg_viewticket77); ?>" title="<?php echo mswSpecialChars($msg_viewticket77); ?>" />
</p>  

</form>

</div>  

</div>

</body>
</html>
