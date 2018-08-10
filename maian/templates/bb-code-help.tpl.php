<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=<?php echo $this->CHARSET; ?>" />
<title><?php echo $this->TITLE; ?></title>
<link rel="stylesheet" href="stylesheet.css" type="text/css" />
<link href="bbcode.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/overlib.js"><!-- overLIB (c) Erik Bosrup --></script>
</head>

<body class="body">
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>

<div id="bbcodeWrapper">

<h1><?php echo $this->TEXT[1]; ?>:</h1>

<div class="bbInfo">
  <p><?php echo $this->TEXT[2]; ?></p>
</div>

<h1 style="margin:5px 0 0 0"><?php echo $this->TEXT[16]; ?>:</h1>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[b]</b> <?php echo $this->TEXT[3]; ?> <b>[/b]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><b><?php echo $this->TEXT[3]; ?></b></p>
  </div>
  
  <br class="clear" />

</div> 

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[u]</b> <?php echo $this->TEXT[4]; ?> <b>[/u]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="text-decoration:underline"><?php echo $this->TEXT[4]; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[i]</b> <?php echo $this->TEXT[5]; ?> <b>[/i]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="font-style:italic"><?php echo $this->TEXT[5]; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[s]</b> <?php echo $this->TEXT[6]; ?> <b>[/s]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="text-decoration:line-through"><?php echo $this->TEXT[6]; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[del]</b> <?php echo $this->TEXT[7]; ?> <b>[/del]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="text-decoration:line-through;color:red"><?php echo $this->TEXT[7]; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[ins]</b> <?php echo $this->TEXT[8]; ?> <b>[/ins]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="background:yellow"><?php echo $this->TEXT[8]; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[em]</b> <?php echo $this->TEXT[9]; ?> <b>[/em]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="font-style:italic;font-weight:bold"><?php echo $this->TEXT[9]; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[color=#FF0000]</b> <?php echo $this->TEXT[10]; ?><b> [/color]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="color:red"><?php echo $this->TEXT[10]; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[color=blue]</b> <?php echo $this->TEXT[11]; ?> <b>[/color]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="color:blue"><?php echo $this->TEXT[11]; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[h1]</b> <?php echo $this->TEXT[12]; ?> <b>[/h1]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="font-weight:bold;font-size:22px"><?php echo $this->TEXT[12]; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[h2]</b> <?php echo $this->TEXT[13]; ?> <b>[/h2]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="font-weight:bold;font-size:20px"><?php echo $this->TEXT[13]; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[h3]</b> <?php echo $this->TEXT[14]; ?> <b>[/h3]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="font-weight:bold;font-size:18px"><?php echo $this->TEXT[14]; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[h4]</b> <?php echo $this->TEXT[15]; ?> <b>[/h4]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="font-weight:bold;font-size:16px"><?php echo $this->TEXT[15]; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<h1 style="margin:5px 0 0 0">
  <?php echo $this->TEXT[17]; ?>:
</h1>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[url=http://www.google.co.uk]</b> Google <b>[/url]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><a href="http://www.google.co.uk" rel="nofollow">Google</a></p>
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
    <p><a href="http://www.google.co.uk" rel="nofollow">http://www.google.co.uk</a></p>
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
    <p><a href="mailto:myname@mydomain.com" rel="nofollow">myname@mydomain.com</a></p>
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
    <p><a href="mailto:myname@mydomain.com" rel="nofollow"><?php echo $this->TEXT[26]; ?></a></p>
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
  <?php echo $this->TEXT[27]; ?>:
</h1>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[youtube]</b><?php echo $this->TEXT[29]; ?><b>[/youtube]</b> [<a href="javascript:void(0);" onmouseover="return overlib('<img src=\'templates/images/yt-info.gif\' alt=\'\' title=\'\' />','',RIGHT,ol_offsety = 5, ol_offsetx = 25);" onmouseout="nd();">?</a>]</p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><?php echo $this->TEXT[28]; ?></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[vimeo]</b><?php echo $this->TEXT[29]; ?><b>[/vimeo]</b> [<a href="javascript:void(0);" onmouseover="return overlib('<img src=\'templates/images/vimeo-info.gif\' alt=\'\' title=\'\' />','',RIGHT,ol_offsety = 5, ol_offsetx = 25);" onmouseout="nd();">?</a>]</p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><?php echo $this->TEXT[28]; ?></p>
  </div>
  
  <br class="clear" />

</div>

<h1 style="margin:5px 0 0 0">
  <?php echo $this->TEXT[18]; ?>:
</h1>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[list]</b><br /><b>&nbsp;[*]</b> <?php echo $this->TEXT[20]; ?> 1 <b>[/*]<br />&nbsp;[*]</b> <?php echo $this->TEXT[20]; ?> 2 <b>[/*]<br />&nbsp;[*]</b> <?php echo $this->TEXT[20]; ?> 3 <b>[/*]<br />[/list]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <div><ul style="list-style-type:disc"><li><?php echo $this->TEXT[20]; ?> 1</li><li><?php echo $this->TEXT[20]; ?> 2</li><li><?php echo $this->TEXT[20]; ?> 3</li></ul></div>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[list=n]</b><br /><b>&nbsp;[*]</b> <?php echo $this->TEXT[21]; ?> 1 <b>[/*]<br />&nbsp;[*]</b> <?php echo $this->TEXT[21]; ?> 2 <b>[/*]<br />&nbsp;[*]</b> <?php echo $this->TEXT[21]; ?> 3 <b>[/*]<br />[/list]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <div><ul style="list-style-type:decimal"><li><?php echo $this->TEXT[21]; ?> 1</li><li><?php echo $this->TEXT[21]; ?> 2</li><li><?php echo $this->TEXT[21]; ?> 3</li></ul></div>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[list=a]</b><br /><b>&nbsp;[*]</b> <?php echo $this->TEXT[22]; ?> 1 <b>[/*]<br />&nbsp;[*]</b> <?php echo $this->TEXT[22]; ?> 2 <b>[/*]<br />&nbsp;[*]</b> <?php echo $this->TEXT[22]; ?> 3 <b>[/*]<br />[/list]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <div><ul style="list-style-type:lower-alpha"><li><?php echo $this->TEXT[22]; ?> 1</li><li><?php echo $this->TEXT[22]; ?> 2</li><li><?php echo $this->TEXT[22]; ?> 3</li></ul></div>
  </div>
  
  <br class="clear" />

</div>

<h1 style="margin:5px 0 0 0">
  <?php echo $this->TEXT[19]; ?>:
</h1>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[b][u]</b><?php echo $this->TEXT[23]; ?> <b>[/u][/b]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="text-decoration:underline;font-weight:bold"><?php echo $this->TEXT[23]; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

<div class="bbWrapper">

  <div class="leftBB">
    <p><b>[color=blue][b][u]</b> <?php echo $this->TEXT[24]; ?> <b>[/u][/b][/color]</b></p>
  </div>
  
  <div class="middleBB">
    <p>&nbsp;</p>
  </div>
  
  <div class="rightBB">
    <p><span style="text-decoration:underline;font-weight:bold;color:blue"><?php echo $this->TEXT[24]; ?></span></p>
  </div>
  
  <br class="clear" />

</div>

</div>

</body>
</html>