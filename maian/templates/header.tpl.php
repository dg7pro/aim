<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=<?php echo $this->CHARSET; ?>" />
<title><?php echo $this->TITLE; ?></title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
<link href="bbcode.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.js"></script>
<script type="text/javascript" src="templates/js/js_code.js"></script>
<?php
if ($this->SCROLL_TO_TOP=='yes') {
?>
<script type="text/javascript" src="templates/js/scrolltotop.js"></script>
<?php
}
// Only show the greybox code when required..
// BBCode popups/Message previews..
if ($this->GREYBOX=='yes') {
?>
<script type="text/javascript" src="templates/js/drag.js"></script>
<script type="text/javascript" src="templates/greybox/greybox.js"></script>
<link href="greybox.css" rel="stylesheet" type="text/css" media="all" />
<?php
}
?>
<!--[if lt IE 8]>
<link rel="stylesheet" href="ie.css" type="text/css" />
<![endif]-->
<link rel="SHORTCUT ICON" href="favicon.ico" />
</head>

<body>

<div id="header">

  <div class="left">
    <p><a href="index.php"><img src="templates/images/logo.png" alt="<?php echo $this->TITLE; ?>" title="<?php echo $this->TITLE; ?>" /></a></p>
  </div>
  
  <?php
  // Only show this block if a user is logged in..
  if ($this->LOGGED_IN=='yes') {
  ?>
  <div class="right">
   <p>
     <span class="logged"><?php echo $this->TEXT[2]; ?></span>
     <span class="links">
      <a class="account" href="?p=portal" title="<?php echo $this->MY_ACCOUNT; ?>"><?php echo $this->MY_ACCOUNT; ?></a>
      <a class="new" href="?p=ticket" title="<?php echo $this->TEXT[3]; ?>"><?php echo $this->TEXT[3]; ?></a>
      <a class="search" href="#" onclick="jQuery('#searchBar').slideToggle('slow');jQuery('#keys').focus();return false" title="<?php echo $this->SEARCH; ?>"><?php echo $this->SEARCH; ?></a>
      <a class="faq" href="?p=faq" title="<?php echo $this->TEXT[4]; ?>"><?php echo $this->TEXT[4]; ?></a>
      <a class="logout" href="?p=logout" title="<?php echo $this->LOGOUT; ?>"><?php echo $this->LOGOUT; ?></a>
     </span>
   </p>
  </div>
  <?php
  }
  ?>
  <br class="clear" />
  
</div>

<?php
// The search bar is hidden until the 'Search Tickets' link is clicked..
// If you want the search box always visible, remove the style tag.. 
// Search is only available if logged into portal..
if ($this->LOGGED_IN=='yes') {
?>
<div id="searchBar"<?php echo (!isset($_GET['keys']) ? ' style="display:none"' : ''); ?>>
 
 <form method="get" action="index.php">
  <p class="float">
   <input class="button" type="submit" value="<?php echo $this->SEARCH_TICKETS; ?>" title="<?php echo $this->SEARCH_TICKETS; ?>" />
  </p>
  <p>
   <?php echo $this->TEXT[0]; ?>: <input class="box" type="text" name="keys" id="keys" value="<?php echo (isset($_GET['keys']) ? mswSpecialChars($_GET['keys']) : ''); ?>" />
  </p>
 </form>

</div>
<?php
}
?>