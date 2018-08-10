<?php if(!defined('PARENT')) { exit; } 
$_GET['view'] = (int)$_GET['view'];
$KB           = mswGetTableData('faq','id',$_GET['view']);
$yes          = ($KB->kviews>0 ? number_format($KB->kuseful/$KB->kviews*100,VOTING_DECIMAL_PLACES) : 0);
$no           = ($KB->kviews>0 ? number_format($KB->knotuseful/$KB->kviews*100,VOTING_DECIMAL_PLACES) : 0);
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
<script type="text/javascript" src="templates/js/js_code.js"></script>
</head>

<body>

<div id="bodyOverride">

<div id="windowWrapper">

  <h1><?php echo mswSpecialChars($KB->question); ?></h1>
  
  <div class="windowContent">
    <p>
    <?php 
    echo mswTxtParsingEngine($KB->answer); 
    ?>
    </p>
  </div>
  
  <p class="windowFooter">
    <?php echo str_replace(array('{count}','{helpful}','{nothelpful}','{cat}'),array($KB->kviews,$yes,$no,mswSpecialChars(mswFaqCat($KB->category))),$msg_kbase18); ?><br /><br />
    <span class="updated"><?php echo $msg_response18.': '.mswDateDisplay($KB->ts,$SETTINGS->dateformat).' / '.mswTimeDisplay($KB->ts,$SETTINGS->timeformat); ?></span>
    <a href="javascript:window.print()" title="<?php echo mswSpecialChars($msg_script14); ?>"><img src="templates/images/print.png" alt="<?php echo mswSpecialChars($msg_script14); ?>" title="<?php echo mswSpecialChars($msg_script14); ?>" /></a>
  </p> 
  
</div>  

</div>

</body>

</html>
