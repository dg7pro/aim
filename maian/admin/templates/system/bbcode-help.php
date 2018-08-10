<?php if (!defined('PARENT')) { die('You do not have permission to view this file!!'); }
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
<title><?php echo mswSpecialChars($title); ?></title>
<link rel="stylesheet" href="stylesheet.css" type="text/css" />
<link href="../bbcode.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/overlib.js"><!-- overLIB (c) Erik Bosrup --></script>
</head>

<body>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>

<div id="bodyOverride">
<div id="windowWrapper">

<h1>
 <?php
 if (isset($_GET['return'])) {
 ?>
 <span class="float">
  <a class="return" href="javascript:history.go(-1)"><?php echo $msg_script41; ?></a>
 </span>
 <?php 
 }
 echo $msg_bbcode; 
 ?>:
</h1>

<div class="bbInfo">
  <p><?php echo $msg_bbcode2; ?></p>
</div>

<h1 style="margin:5px 0 0 0"><?php echo $msg_bbcode16; ?>:</h1>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[b]</b> <?php echo $msg_bbcode3; ?> <b>[/b]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><b><?php echo $msg_bbcode3; ?></b></p>
  </div>
  
  <br class="clear" />

</div> 

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[u]</b> <?php echo $msg_bbcode4; ?> <b>[/u]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="text-decoration:underline"><?php echo $msg_bbcode4; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[i]</b> <?php echo $msg_bbcode5; ?> <b>[/i]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="font-style:italic"><?php echo $msg_bbcode5; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[s]</b> <?php echo $msg_bbcode6; ?> <b>[/s]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="text-decoration:line-through"><?php echo $msg_bbcode6; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[del]</b> <?php echo $msg_bbcode7; ?> <b>[/del]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="text-decoration:line-through;color:red"><?php echo $msg_bbcode7; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[ins]</b> <?php echo $msg_bbcode8; ?> <b>[/ins]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="background:yellow"><?php echo $msg_bbcode8; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[em]</b> <?php echo $msg_bbcode9; ?> <b>[/em]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="font-style:italic;font-weight:bold"><?php echo $msg_bbcode9; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[color=#FF0000]</b> <?php echo $msg_bbcode10; ?><b> [/color]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="color:red"><?php echo $msg_bbcode10; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[color=blue]</b> <?php echo $msg_bbcode11; ?> <b>[/color]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="color:blue"><?php echo $msg_bbcode11; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[h1]</b> <?php echo $msg_bbcode12; ?> <b>[/h1]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="font-weight:bold;font-size:22px"><?php echo $msg_bbcode12; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[h2]</b> <?php echo $msg_bbcode13; ?> <b>[/h2]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="font-weight:bold;font-size:20px"><?php echo $msg_bbcode13; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[h3]</b> <?php echo $msg_bbcode14; ?> <b>[/h3]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="font-weight:bold;font-size:18px"><?php echo $msg_bbcode14; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[h4]</b> <?php echo $msg_bbcode15; ?> <b>[/h4]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="font-weight:bold;font-size:16px"><?php echo $msg_bbcode15; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<h1 style="margin:5px 0 0 0">
  <?php echo $msg_bbcode17; ?>:
</h1>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[url=http://www.google.co.uk]</b> Google <b>[/url]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><a href="http://www.google.co.uk">Google</a></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[url]</b> http://www.google.co.uk <b>[/url]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><a href="http://www.google.co.uk">http://www.google.co.uk</a></p>
  </div>
  
  <br class="clear" />

</div> 

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[urlnew=http://www.google.co.uk]</b> Google <b>[/urlnew]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><a href="http://www.google.co.uk">Google</a> (<?php echo $msg_bbcode28; ?>)</p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[urlnew]</b> http://www.google.co.uk <b>[/urlnew]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><a href="http://www.google.co.uk">http://www.google.co.uk</a> (<?php echo $msg_bbcode28; ?>)</p>
  </div>
  
  <br class="clear" />

</div> 

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[email]</b> myname@mydomain.com <b>[/email]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><a href="mailto:myname@mydomain.com">myname@mydomain.com</a></p>
  </div>
  
  <br class="clear" />

</div> 

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[email=myname@mydomain.com]</b> My Email Address <b>[/email]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><a href="mailto:myname@mydomain.com"><?php echo $msg_bbcode26; ?></a></p>
  </div>
  
  <br class="clear" />

</div> 

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[img]</b> http://www.mydomain.com/images/logo.png <b>[/img]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><img src="templates/images/logo.png" style="width:300px" alt="" title="" /></p>
  </div>
  
  <br class="clear" />

</div>

<h1 style="margin:5px 0 0 0">
  <?php echo $msg_bbcode28; ?>:
</h1>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[youtube]</b><?php echo $msg_bbcode30; ?><b>[/youtube]</b> [<a href="javascript:void(0);" onmouseover="return overlib('<img src=\'../templates/images/yt-info.gif\' alt=\'\' title=\'\' />','',RIGHT,ol_offsety = 5, ol_offsetx = 25);" onmouseout="nd();">?</a>]</p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><?php echo $msg_bbcode29; ?></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[vimeo]</b><?php echo $msg_bbcode30; ?><b>[/vimeo]</b> [<a href="javascript:void(0);" onmouseover="return overlib('<img src=\'../templates/images/vimeo-info.gif\' alt=\'\' title=\'\' />','',RIGHT,ol_offsety = 5, ol_offsetx = 25);" onmouseout="nd();">?</a>]</p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><?php echo $msg_bbcode29; ?></p>
  </div>
  
  <br class="clear" />

</div>

<h1 style="margin:5px 0 0 0">
  <?php echo $msg_bbcode18; ?>:
</h1>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[list]</b><br /><b>&nbsp;[*]</b> <?php echo $msg_bbcode20; ?> 1 <b>[/*]<br />&nbsp;[*]</b> <?php echo $msg_bbcode20; ?> 2 <b>[/*]<br />&nbsp;[*]</b> <?php echo $msg_bbcode20; ?> 3 <b>[/*]<br />[/list]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <div><ul style="list-style-type:disc"><li><?php echo $msg_bbcode20; ?> 1</li><li><?php echo $msg_bbcode20; ?> 2</li><li><?php echo $msg_bbcode20; ?> 3</li></ul></div>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[list=n]</b><br /><b>&nbsp;[*]</b> <?php echo $msg_bbcode21; ?> 1 <b>[/*]<br />&nbsp;[*]</b> <?php echo $msg_bbcode21; ?> 2 <b>[/*]<br />&nbsp;[*]</b> <?php echo $msg_bbcode21; ?> 3 <b>[/*]<br />[/list]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <div><ul style="list-style-type:decimal"><li><?php echo $msg_bbcode21; ?> 1</li><li><?php echo $msg_bbcode21; ?> 2</li><li><?php echo $msg_bbcode21; ?> 3</li></ul></div>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[list=a]</b><br /><b>&nbsp;[*]</b> <?php echo $msg_bbcode22; ?> 1 <b>[/*]<br />&nbsp;[*]</b> <?php echo $msg_bbcode22; ?> 2 <b>[/*]<br />&nbsp;[*]</b> <?php echo $msg_bbcode22; ?> 3 <b>[/*]<br />[/list]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <div><ul style="list-style-type:lower-alpha"><li><?php echo $msg_bbcode22; ?> 1</li><li><?php echo $msg_bbcode22; ?> 2</li><li><?php echo $msg_bbcode22; ?> 3</li></ul></div>
  </div>
  
  <br class="clear" />

</div>

<h1 style="margin:5px 0 0 0">
  <?php echo $msg_bbcode19; ?>:
</h1>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[b][u]</b><?php echo $msg_bbcode23; ?> <b>[/u][/b]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="text-decoration:underline;font-weight:bold"><?php echo $msg_bbcode23; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[color=blue][b][u]</b> <?php echo $msg_bbcode24; ?> <b>[/u][/b][/color]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="text-decoration:underline;font-weight:bold;color:blue"><?php echo $msg_bbcode24; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

</div>
</div>

</body>
</html>