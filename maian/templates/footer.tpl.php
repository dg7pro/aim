<?php
// Anything entered in this file loads before the closing </body> tag.
// This is useful if you need to add Google Analytics code or something similar
?>
<div class="footer">
  <p>
   <?php
   // IMPORTANT!!
   // The footer copyright should remain in place unless a commercial licence is purchased.
   // Removing the footer link could potentially invalidate any support in the free version
   echo $this->FOOTER;
   ?>
  </p>
</div> 

<?php
// Is scroll to top widget enabled..
// Can be disabled in 'control/user-defined/defined2.inc.php'
if ($this->SCROLL_TO_TOP=='yes') {
?>
<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function() {
 jQuery().UItoTop();
});
//]]>
</script>
<?php
}
?>

</body>
</html>
