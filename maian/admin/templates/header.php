<?php if (!defined('PARENT')) { exit; } 
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
<title><?php echo ($title ? mswSpecialChars($title).': ' : '').mswSpecialChars($msg_script.' '.$msg_script2).' - '.mswSpecialChars($msg_adheader).(LICENCE_VER!='unlocked' ? ' (Free Version)' : '').(mswCheckBetaVersion()=='yes' ? ' - BETA VERSION' : ''); ?></title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
<link href="../bbcode.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.js"></script>
<?php
if (SCROLL_TO_TOP) {
?>
<script type="text/javascript" src="templates/js/scrolltotop.js"></script>
<?php
}
?>
<script type="text/javascript" src="templates/js/overlib.js"><!-- overLIB (c) Erik Bosrup --></script>
<?php
if (isset($loadJQAPI)) {
?>
<script type="text/javascript" src="templates/js/jquery-ui.js"></script>
<link href="jquery-ui.css" rel="stylesheet" type="text/css" />
<?php
}
?>
<script type="text/javascript" src="templates/js/menu.js"></script>
<link href="menu.css" rel="stylesheet" type="text/css" />
<?php
// Load menu..
include(PATH.'templates/navigation.php');
if (isset($loadGreyBox)) {
?>
<script type="text/javascript" src="templates/js/drag.js"></script>
<script type="text/javascript" src="templates/greybox/greybox.js"></script>
<link href="greybox.css" rel="stylesheet" type="text/css" media="all" />
<?php
}
if (isset($jqPlot)) {
?>
<!--[if lte IE 8]>
<script type="text/javascript" src="templates/js/jqplot/excanvas.js"></script>
<![endif]-->
<script type="text/javascript" src="templates/js/jqplot/jqplot.js"></script>
<script type="text/javascript" src="templates/js/jqplot/jqplot.pieRenderer.js"></script>
<script type="text/javascript" src="templates/js/jqplot/jqplot.categoryAxisRenderer.js"></script>
<script type="text/javascript" src="templates/js/jqplot/jqplot.canvasTextRenderer.js"></script>
<script type="text/javascript" src="templates/js/jqplot/jqplot.labelRenderer.js"></script>
<script type="text/javascript" src="templates/js/jqplot/jqplot.highlighter.js"></script>
<script type="text/javascript" src="templates/js/jqplot/jqplot.cursor.js"></script>
<?php
}
?>
<script type="text/javascript" src="templates/js/js_code.js"></script>
<link rel="SHORTCUT ICON" href="favicon.ico" />
</head>

<body>

<?php
if ($cmd!='home') {
?>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<?php
}
?>

<div id="topBar">

  <div class="inner">
  
    <div class="left">
      <p><?php echo date(HEADER_DATE_FORMAT,mswTimeStamp()); ?>
      <?php
      // Display version check option..
      // Disable for beta versions..
      if (mswCheckBetaVersion()=='yes') {
      ?>
      &nbsp;&nbsp;&nbsp;(v<?php echo $SETTINGS->softwareVersion; ?> - Beta <?php echo mswGetBetaVersion(); ?>)
      <?php
      } else {
      // Version check available only to administrative user..
      if (DISPLAY_SOFTWARE_VERSION_CHECK && $MSTEAM->id=='1') {
      ?>
      &nbsp;&nbsp;&nbsp;(v<?php echo $SETTINGS->softwareVersion; ?> - <a href="#" onclick="jQuery(document).ready(function(){$.ajax({url:'index.php',data: 'versionCheck=yes',dataType:'html',success: function (data) {alert(data)}});});return false" title="<?php echo mswSpecialChars($msg_adheader27); ?>"><?php echo $msg_adheader27; ?></a>)
      <?php
      }
      }
      ?>
      </p>
    </div>
  
    <div class="right">
      <p>
      <?php
      if (LICENCE_VER=='locked') {
      ?>
      <a href="?p=purchase" title="Purchase Full Version">Purchase Full Version</a> &#8226;
      <?php
      }
      ?>
      <a href="index.php" title="<?php echo mswSpecialChars($msg_adheader11); ?>"><?php echo $msg_adheader11; ?></a> &#8226;
      <a href="../index.php" title="<?php echo mswSpecialChars($msg_adheader31); ?>" onclick="window.open(this);return false"><?php echo $msg_adheader31; ?></a> &#8226;
      <a href="../docs/<?php echo (isset($_GET['p']) && isset($helpPages[$_GET['p']]) ? $helpPages[$_GET['p']].'.html' : (!isset($_GET['p']) ? 'admin.html' : 'index.html')); ?>" title="<?php echo mswSpecialChars($msg_adheader12); ?>" onclick="window.open(this);return false"><?php echo $msg_adheader12; ?></a> &#8226;
      <a href="?p=logout" title="<?php echo mswSpecialChars($msg_adheader10); ?>" onclick="return confirmMessage('<?php echo mswSpecialChars($msg_javascript2); ?>')"><?php echo $msg_adheader10; ?></a>
      </p>
    </div>
  
  </div>
  
  <br class="clear" />

</div>

<div id="header">

  <div class="left">
    <p><a href="index.php"><img src="templates/images/logo.png" alt="<?php echo mswSpecialChars($msg_script." ".$msg_script2." - ".$msg_adheader); ?>" title="<?php echo mswSpecialChars($msg_script." ".$msg_script2." - ".$msg_adheader); ?>" /></a></p>
  </div>
  
  <div class="right">
   <p>
     <span class="logged"><?php echo $msg_adheader25; ?>: <span class="user"><?php echo $MSTEAM->name; ?></span></span>
     <span class="message"><a href="?p=messenger" title="<?php echo mswSpecialChars($msg_adheader23); ?>"><?php echo $msg_adheader23; ?></a></span>
   </p>
  </div>
  
  <br class="clear" />
  
</div>

<div id="wrapper">

<div id="menu">
<div id="dropmenudiv" style="visibility:hidden;width:185px;background-color:#dbdbbe" onmouseover="clearhidemenu()" onmouseout="dynamichide(event)"></div>
<table width="100%" cellspacing="0" cellpadding="0">
<tr>
  <td class="first"<?php echo (in_array('imap',$userAccess) || $MSTEAM->id=='1' ? ' onmouseover="dropdownmenu(this, event, settings, \'185px\')" onmouseout="delayhidemenu()"' : ''); ?>><?php echo (in_array('settings',$userAccess) || $MSTEAM->id=='1' ? '<a href="?p=settings" title="'.mswSpecialChars($msg_adheader2).'">'.$msg_adheader2.'</a>' : '<span class="feint" title="'.mswSpecialChars($msg_adheader2).' ('.mswSpecialChars($msg_adheader22).')">'.$msg_adheader2.'</span>'); ?></td>
  <td><?php echo (in_array('dept',$userAccess) || $MSTEAM->id=='1' ? '<a href="?p=dept" title="'.mswSpecialChars($msg_adheader3).'">'.$msg_adheader3.'</a>' : '<span class="feint" title="'.mswSpecialChars($msg_adheader3).' ('.mswSpecialChars($msg_adheader22).')">'.$msg_adheader3.'</span>'); ?></td>
  <td><?php echo (in_array('users',$userAccess) || $MSTEAM->id=='1' ? '<a href="?p=users" title="'.mswSpecialChars($msg_adheader4).'">'.$msg_adheader4.'</a>' : '<span class="feint" title="'.mswSpecialChars($msg_adheader3).' ('.mswSpecialChars($msg_adheader22).')">'.$msg_adheader4.'</span>'); ?></td>
  <td<?php echo (in_array('open',$userAccess) || in_array('close',$userAccess) || in_array('search',$userAccess) || in_array('standard-responses',$userAccess) || $MSTEAM->id=='1' ? ' onmouseover="dropdownmenu(this, event, tickets, \'185px\')" onmouseout="delayhidemenu()"' : ''); ?>><?php echo (in_array('open',$userAccess) || in_array('close',$userAccess) || in_array('search',$userAccess) || in_array('standard-responses',$userAccess) || $MSTEAM->id=='1' ? '<a href="#" title="'.mswSpecialChars($msg_adheader14).'">'.$msg_adheader14.'</a>' : '<span class="feint" title="'.mswSpecialChars($msg_adheader14).' ('.mswSpecialChars($msg_adheader22).')">'.$msg_adheader14.'</span>'); ?></td>
  <td style="width:15%"<?php echo (in_array('faq-cat',$userAccess) || in_array('faq',$userAccess) || $MSTEAM->id=='1' ? ' onmouseover="dropdownmenu(this, event, faq, \'185px\')" onmouseout="delayhidemenu()"' : ''); ?>><?php echo (in_array('faq-cat',$userAccess) || in_array('faq',$userAccess) || $MSTEAM->id=='1' ? '<a href="#" title="'.mswSpecialChars($msg_adheader17).'">'.$msg_adheader17.'</a>' : '<span class="feint" title="'.mswSpecialChars($msg_adheader17).' ('.$msg_adheader22.')">'.$msg_adheader17.'</span>'); ?></td>
  <td class="last" style="border-right:0"<?php echo (in_array('tools',$userAccess) || in_array('import',$userAccess) || in_array('portal',$userAccess) || in_array('log',$userAccess) || $MSTEAM->id=='1' ? ' onmouseover="dropdownmenu(this, event, tools, \'185px\')" onmouseout="delayhidemenu()"' : ''); ?>><?php echo (in_array('tools',$userAccess) || in_array('import',$userAccess) || in_array('portal',$userAccess) || in_array('log',$userAccess) || $MSTEAM->id=='1' ? '<a href="#" title="'.mswSpecialChars($msg_adheader15).'">'.$msg_adheader15.'</a>' : '<span class="feint" title="'.mswSpecialChars($msg_adheader15).' ('.mswSpecialChars($msg_adheader22).')">'.$msg_adheader15.'</span>'); ?></td>
</tr>
</table>
</div>