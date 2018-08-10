<?php if (!defined('PARENT')) { die('You do not have permission to view this file!!'); } 
$box = (defined('BB_BOX') ? BB_BOX : 'comments');
?>
<span class="bb_buttons">
  <input type="button" value="B" class="bold" onclick="ms_addTags('[b][/b]','bold','','<?php echo $box; ?>')" />
  <input type="button" value="I" class="italic" onclick="ms_addTags('[i][/i]','italic','','<?php echo $box; ?>')" />
  <input type="button" value="U" class="underline" onclick="ms_addTags('[u][/u]','underline','','<?php echo $box; ?>')" />
  <input type="button" value="<?php echo mswSpecialChars(str_replace("'","\'",$bb_code_buttons[2])); ?>" class="link" onclick="ms_addTags('-','url','<?php echo mswSpecialChars(str_replace("'","\'",$bb_code_buttons[6])); ?>','<?php echo $box; ?>')" />
  <input type="button" value="<?php echo mswSpecialChars(str_replace("'","\'",$bb_code_buttons[1])); ?>" class="email" onclick="ms_addTags('-','email','<?php echo mswSpecialChars(str_replace("'","\'",$bb_code_buttons[5])); ?>','<?php echo $box; ?>')" />
  <input type="button" value="<?php echo mswSpecialChars(str_replace("'","\'",$bb_code_buttons[0])); ?>" class="image" onclick="ms_addTags('-','img','<?php echo mswSpecialChars(str_replace("'","\'",$bb_code_buttons[4])); ?>','<?php echo $box; ?>')" />
  <input type="button" value="YouTube" class="youtube" onclick="ms_addTags('-','youtube','<?php echo mswSpecialChars(str_replace("'","\'",$bb_code_buttons[7])); ?>','<?php echo $box; ?>')" />
  <input type="button" value="Vimeo" class="vimeo" onclick="ms_addTags('-','vimeo','<?php echo mswSpecialChars(str_replace("'","\'",$bb_code_buttons[8])); ?>','<?php echo $box; ?>')" />
  <?php
  if (defined('INFO_LINK')) {
  ?>
  <input type="button" value="?" class="info" onclick="window.location='index.php?p=bbCode&amp;return=yes'" />
  <?php
  } else {
  ?>
  <input type="button" value="?" class="info" onclick="$.GB_hide();$.GB_show('index.php?p=bbCode', {height: 550,width: 900,caption: '<?php echo mswSpecialChars(str_replace("'","\'",$msg_viewticket56)); ?>'})" />
  <?php
  }
  ?>
</span>