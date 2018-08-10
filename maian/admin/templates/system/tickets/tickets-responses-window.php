<?php if(!defined('PARENT')) { exit; } 
$_GET['view']  = (int)$_GET['view'];
$ST            = mswGetTableData('responses','id',$_GET['view']);
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
<title><?php echo mswSpecialChars($msg_kbase12); ?></title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div id="bodyOverride">

<div id="windowWrapper">

  <h1><?php echo mswSpecialChars($ST->title); ?></h1>
  
  <div class="windowContent">
    <p>
    <?php 
    echo mswTxtParsingEngine($ST->answer); 
    ?>
    </p>
  </div>
  
  <p class="windowFooter">
   <span class="category"><?php echo str_replace('{dept}',mswSpecialChars(mswSrCat($ST->id)),$msg_response15); ?></span><br />
   <span class="updated"><?php echo $msg_response18.': '.mswDateDisplay($ST->ts,$SETTINGS->dateformat).' / '.mswTimeDisplay($ST->ts,$SETTINGS->timeformat); ?></span>
   <a href="javascript:window.print()" title="<?php echo mswSpecialChars($msg_script14); ?>"><img src="templates/images/print.png" alt="<?php echo mswSpecialChars($msg_script14); ?>" title="<?php echo mswSpecialChars($msg_script14); ?>" /></a>
  </p> 
  
</div>  

</div>

</body>

</html>
