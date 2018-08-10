<?php if(!defined('PARENT')) { exit; } 
if (file_exists(PATH.'templates/header-custom.php')) {
  include_once(PATH.'templates/header-custom.php');
} else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
}
$_GET['disputeUsers'] = (int)$_GET['disputeUsers'];
?>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=<?php echo $msg_charset; ?>" />
<title><?php echo mswSpecialChars($msg_disputes5); ?></title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.js"></script>
<script type="text/javascript" src="templates/js/js_code.js"></script>
<script type="text/javascript" src="templates/js/overlib.js"><!-- overLIB (c) Erik Bosrup --></script>
<script type="text/javascript">
//<![CDATA[
function updateDisputeUser(id) {
  jQuery(document).ready(function() {
    $.ajax({
      url: 'index.php',
      data: 'p=view-ticket&disUserField='+encodeURIComponent(jQuery('#userName_'+id).val())+'&disEmailField='+encodeURIComponent(jQuery('#userEmail_'+id).val())+'&id='+id,
      dataType: 'html',
      success: function (data) {
        if (data=='OK') {
          jQuery('#u_'+id).html(jQuery('#userName_'+id).val());
          jQuery('#e_'+id).html(jQuery('#userEmail_'+id).val());
          alert('<?php echo mswSpecialChars($msg_javascript121); ?>');
        }
        jQuery('#userdiv_'+id).hide('slow');
      },
      complete: function () {
      },
      error: function(xml,status,error) {
      }
    });
  });
  return false;
}
//]]>
</script>
</head>

<body onload="jQuery('#name_first').focus()">
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>

<div id="bodyOverride">
<?php
if (isset($OK)) {
  echo mswActionCompletedReload(str_replace('{count}',$added,$msg_viewticket68),'p=view-ticket&amp;id='.$_GET['disputeUsers']);
}
if (isset($OK2)) {
  echo mswActionCompletedReload(str_replace('{count}',count($_POST['remove']),$msg_viewticket69),'p=view-ticket&amp;id='.$_GET['disputeUsers']);
}
$SUPTICK   = mswGetTableData('tickets','id',$_GET['disputeUsers']);
$disCount  = mswRowCount('disputes WHERE `ticketID` = \''.$_GET['disputeUsers'].'\'');
?>
<div id="windowWrapper">

  <form method="post" id="form" action="?p=view-ticket&amp;disputeUsers=<?php echo $_GET['disputeUsers']; ?>" onsubmit="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')">
  <h1><?php echo mswCleanData($msg_viewticket58).' '.mswDisplayHelpTip($msg_javascript114,'RIGHT'); ?></h1>
  
  <div class="addDispute" id="name_1">
      
    <div class="left">
        
      <label><?php echo $msg_viewticket59; ?></label>
      <input id="name_first" maxlength="250" type="text" class="box" name="name[]" value="" tabindex="<?php echo (++$tabIndex); ?>" />
        
    </div>
  
    <div class="middle">
      
      <label><?php echo $msg_viewticket60; ?></label>
      <input type="text" maxlength="250" class="box" name="email[]" value="" tabindex="<?php echo (++$tabIndex); ?>" />
        
    </div>
    
    <div class="right">
      
      <input id="on_1" class="button" type="button" name="+" value="+" tabindex="<?php echo (++$tabIndex); ?>" onclick="ms_addDisputeUser('1')" />
        
    </div>
      
    <br class="clear" />
  
  </div>
  
  <p class="buttonWrapper" style="text-align:right">
  
   <span class="floater">
   
    <input tabindex="<?php echo (++$tabIndex); ?>" type="checkbox" name="notify" value="1"<?php echo (AUTO_CHECK_DISPUTE_NOTIFICATION ? ' checked="checked"' : ''); ?> /> <?php echo $msg_disputes15.' '.mswDisplayHelpTip($msg_javascript140,'RIGHT'); ?>
   
   </span>
   
   <input type="hidden" name="process_add" value="1" />
   <input type="hidden" name="oemail" value="<?php echo mswSpecialChars($SUPTICK->email); ?>" />
   <input type="hidden" name="oname" value="<?php echo mswSpecialChars($SUPTICK->name); ?>" />
   <input type="hidden" name="otitle" value="<?php echo mswSpecialChars($SUPTICK->subject); ?>" />
   <input type="hidden" name="olang" value="<?php echo $SUPTICK->tickLang; ?>" />
   <input class="button" tabindex="<?php echo (++$tabIndex); ?>" type="submit" value="<?php echo mswSpecialChars($msg_viewticket67); ?>" title="<?php echo mswSpecialChars($msg_viewticket67); ?>" />
  
  </p>
  
  </form>
  
  <form method="post" id="form2" action="?p=view-ticket&amp;disputeUsers=<?php echo $_GET['disputeUsers']; ?>" onsubmit="return confirmMessage('<?php echo mswSpecialChars($msg_javascript); ?>')">
  <h1 style="margin-top:5px">
   <?php
   if ($disCount>0) {
   ?>
   <span class="float"><input type="checkbox" name="log" onclick="selectAll('form2')" value="" /></span>
   <?php
   }
   ?>
   <?php echo str_replace(array('{users}','{original}'),array($disCount,mswSpecialChars($SUPTICK->name)),mswCleanData($msg_viewticket61)).' '.mswDisplayHelpTip($msg_javascript115,'RIGHT'); ?>
  </h1>
  <?php
  $q = mysql_query("SELECT * FROM ".DB_PREFIX."disputes WHERE `ticketID` = '{$_GET['disputeUsers']}' ORDER BY `userName`")
       or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  if (mysql_num_rows($q)>0) {
  while ($D_USER = mysql_fetch_object($q)) {
  ?>
  <div class="disputeUser">
      
    <div class="left">
        
      <p class="post_<?php echo $D_USER->postPrivileges; ?>" id="u_<?php echo $D_USER->id; ?>"><?php echo mswSpecialChars($D_USER->userName); ?></p>
        
    </div>
  
    <div class="middle">
      
      <p id="e_<?php echo $D_USER->id; ?>"><?php echo $D_USER->userEmail; ?></p>
        
    </div>
    
    <div class="right">
      
      <img onclick="jQuery('#userdiv_<?php echo $D_USER->id; ?>').show('slow')" class="edit_img" src="templates/images/edit.png" alt="<?php echo mswSpecialChars($msg_disputes11); ?>" title="<?php echo mswSpecialChars($msg_disputes11); ?>" />
      <input type="checkbox" name="remove[]" value="<?php echo $D_USER->id; ?>" />
        
    </div>
      
    <br class="clear" />
  
  </div>
  <div class="editUser" id="userdiv_<?php echo $D_USER->id; ?>" style="display:none">
      
    <div class="left">
        
      <p><input type="text" class="box" name="userName_<?php echo $D_USER->id; ?>" id="userName_<?php echo $D_USER->id; ?>" value="<?php echo mswSpecialChars($D_USER->userName); ?>" /></p>
        
    </div>
  
    <div class="middle">
      
      <p><input type="text" class="box" name="userEmail_<?php echo $D_USER->id; ?>" id="userEmail_<?php echo $D_USER->id; ?>" value="<?php echo $D_USER->userEmail; ?>" /></p>
        
    </div>
    
    <div class="right">
      
      <input onclick="updateDisputeUser('<?php echo $D_USER->id; ?>')" class="button" type="button" value="<?php echo mswSpecialChars($msg_disputes12); ?>" title="<?php echo mswSpecialChars($msg_disputes12); ?>" />
        
    </div>
      
    <br class="clear" />
  
  </div>
  <?php
  }
  ?>
  
  <p class="buttonWrapper" style="text-align:right">
  
   <span class="userFlags">
    <span class="on"><?php echo $msg_disputes10; ?></span>
    <span class="off"><?php echo $msg_disputes9; ?></span>
   </span>
  
   <select name="options" id="options" tabindex="50">
    <option value="0">- - - - - - - -</option>
    <option value="en_post"><?php echo $msg_viewticket63; ?></option>
    <option value="dis_post"><?php echo $msg_viewticket64; ?></option>
    <option value="delete"><?php echo $msg_viewticket65; ?></option>
   </select>
   
   <span class="butWrap">
    <input type="hidden" name="process_update" value="1" />
    <input class="button" type="submit" value="<?php echo mswSpecialChars($msg_viewticket62); ?>" title="<?php echo mswSpecialChars($msg_viewticket62); ?>" />
   </span> 
   
  </p>
  
  <?php
  } else {
  ?>
  <p class="nothing"><?php echo $msg_viewticket66; ?></p>
  <?php
  }
  ?> 
 
  </form>

</div>  

</div>

</body>
</html>
