<?php
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: quick-links.php
  Description: Add or remove quick links
  
  You can add as many links as you need, these can be internal admin pages or external
  web pages. Can be useful if you have other links you need to quickly jump to.
  
  To completely disable, simply remove the div below from this file

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

?>
      <div class="homeRightInner" style="margin-top:5px">
       <h2 style="border-top:0" class="links"><?php echo $msg_home42; ?></h2>
       <p style="padding-top:10px"><a href="http://www.<?php echo SCRIPT_URL; ?>" onclick="window.open(this);return false"><?php echo SCRIPT_NAME; ?> Website</a></p>
       <p><a href="http://www.maianscriptworld.co.uk" onclick="window.open(this);return false">Maian Script World Website</a></p>
       <p><a href="../index.php" onclick="window.open(this);return false">Your Helpdesk</a></p>
       <p style="padding-bottom:10px;font-style:italic">To Add/Remove see:<br />admin/templates/quick-links.php</p>
      </div>
