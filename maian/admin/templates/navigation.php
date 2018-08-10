<?php if (!defined('PARENT')) { exit; } 
?>
<script type="text/javascript">
//<![CDATA[
<?php
if (in_array('imap',$userAccess) || in_array('fields',$userAccess) || $MSTEAM->id=='1') {
?>
var settings=new Array()
<?php
if (in_array('imap',$userAccess) || $MSTEAM->id=='1') {
?>
settings[0]='<a href="?p=imap" title="<?php echo mswSpecialChars($msg_adheader24); ?>">- <?php echo mswSpecialChars($msg_adheader24); ?><\/a>'
<?php
}
if (in_array('fields',$userAccess) || $MSTEAM->id=='1') {
?>
settings[1]='<a href="?p=fields" title="<?php echo mswSpecialChars($msg_adheader26); ?>">- <?php echo mswSpecialChars($msg_adheader26); ?><\/a>'
<?php
}
if (in_array('levels',$userAccess) || $MSTEAM->id=='1') {
?>
settings[2]='<a href="?p=levels" title="<?php echo mswSpecialChars($msg_adheader35); ?>" style="border-bottom:0">- <?php echo mswSpecialChars($msg_adheader35); ?><\/a>'
<?php
}
}
if (in_array('assign',$userAccess) || in_array('open',$userAccess) || in_array('close',$userAccess) || in_array('disputes',$userAccess) || in_array('cdisputes',$userAccess) ||
    in_array('search',$userAccess) || in_array('standard-responses',$userAccess) || $MSTEAM->id=='1') {
?>
var tickets=new Array()
<?php
if (in_array('assign',$userAccess) || $MSTEAM->id=='1') {
?>
tickets[0]='<a href="?p=assign" title="<?php echo mswSpecialChars($msg_adheader32); ?>">- <?php echo mswSpecialChars($msg_adheader32); ?><\/a>'
<?php
}
if (in_array('open',$userAccess) || $MSTEAM->id=='1') {
?>
tickets[1]='<a href="?p=open" title="<?php echo mswSpecialChars($msg_adheader5); ?>">- <?php echo mswSpecialChars($msg_adheader5); ?><\/a>'
<?php
}
if (in_array('close',$userAccess) || $MSTEAM->id=='1') {
?>
tickets[2]='<a href="?p=close" title="<?php echo mswSpecialChars($msg_adheader6); ?>">- <?php echo mswSpecialChars($msg_adheader6); ?><\/a>'
<?php
}
if (in_array('disputes',$userAccess) || $MSTEAM->id=='1') {
?>
tickets[3]='<a href="?p=disputes" title="<?php echo mswSpecialChars($msg_adheader28); ?>">- <?php echo mswSpecialChars($msg_adheader28); ?><\/a>'
<?php
}
if (in_array('cdisputes',$userAccess) || $MSTEAM->id=='1') {
?>
tickets[4]='<a href="?p=cdisputes" title="<?php echo mswSpecialChars($msg_adheader29); ?>">- <?php echo mswSpecialChars($msg_adheader29); ?><\/a>'
<?php
}
if (in_array('search',$userAccess) || $MSTEAM->id=='1') {
?>
tickets[5]='<a href="?p=search" title="<?php echo mswSpecialChars($msg_adheader7); ?>">- <?php echo mswSpecialChars($msg_adheader7); ?><\/a>'
<?php
}
if (in_array('standard-responses',$userAccess) || $MSTEAM->id=='1') {
?>
tickets[6]='<a href="?p=standard-responses" title="<?php echo mswSpecialChars($msg_adheader13); ?>" style="border-bottom:0">- <?php echo mswSpecialChars($msg_adheader13); ?><\/a>'
<?php
}
}
if (in_array('faq-cat',$userAccess) || in_array('faq',$userAccess) || in_array('attach',$userAccess) || $MSTEAM->id=='1') {
?>
var faq=new Array()
<?php
if (in_array('faq-cat',$userAccess) || $MSTEAM->id=='1') {
?>
faq[0]='<a href="?p=faq-cat" title="<?php echo mswSpecialChars($msg_adheader16); ?>">- <?php echo mswSpecialChars($msg_adheader16); ?><\/a>'
<?php
}
if (in_array('faq',$userAccess) || $MSTEAM->id=='1') {
?>
faq[1]='<a href="?p=faq" title="<?php echo str_replace('&amp;amp;','&amp;',mswSpecialChars($msg_adheader8)); ?>">- <?php echo str_replace('&amp;amp;','&amp;',mswSpecialChars($msg_adheader8)); ?><\/a>'
<?php
}
if (in_array('attach',$userAccess) || $MSTEAM->id=='1') {
?>
faq[2]='<a href="?p=attachments" title="<?php echo str_replace('&amp;amp;','&amp;',mswSpecialChars($msg_adheader33)); ?>" style="border-bottom:0">- <?php echo str_replace('&amp;amp;','&amp;',mswSpecialChars($msg_adheader33)); ?><\/a>'
<?php
}
}
if ((in_array('tools',$userAccess) && USER_DEL_PRIV=='yes') || in_array('import',$userAccess) || in_array('portal',$userAccess) ||
    in_array('log',$userAccess) || in_array('reports',$userAccess) || $MSTEAM->id=='1') {
?>
var tools=new Array()
<?php
if (in_array('tools',$userAccess) || $MSTEAM->id=='1') {
if (USER_DEL_PRIV=='yes') {
?>
tools[0]='<a href="?p=tools" title="<?php echo mswSpecialChars($msg_adheader18); ?>">- <?php echo mswSpecialChars($msg_adheader18); ?><\/a>'
<?php
}
}
if (in_array('import',$userAccess) || $MSTEAM->id=='1') {
?>
tools[1]='<a href="?p=import" title="<?php echo mswSpecialChars($msg_adheader19); ?>">- <?php echo mswSpecialChars($msg_adheader19); ?><\/a>'
<?php
}
if (in_array('portal',$userAccess) || $MSTEAM->id=='1') {
?>
tools[2]='<a href="?p=portal" title="<?php echo mswSpecialChars($msg_adheader21); ?>">- <?php echo mswSpecialChars($msg_adheader21); ?><\/a>'
<?php
}
if (in_array('reports',$userAccess) || $MSTEAM->id=='1') {
?>
tools[3]='<a href="?p=reports" title="<?php echo mswSpecialChars($msg_adheader34); ?>">- <?php echo mswSpecialChars($msg_adheader34); ?><\/a>'
<?php
}
if (in_array('log',$userAccess) || $MSTEAM->id=='1') {
?>
tools[4]='<a href="?p=log" title="<?php echo mswSpecialChars($msg_adheader20); ?>">- <?php echo mswSpecialChars($msg_adheader20); ?><\/a>'
<?php
}
if (in_array('backup',$userAccess) || $MSTEAM->id=='1') {
?>
tools[5]='<a href="?p=backup" title="<?php echo mswSpecialChars($msg_adheader30); ?>" style="border-bottom:0">- <?php echo mswSpecialChars($msg_adheader30); ?><\/a>'
<?php
}
}
?>
//]]>
</script>