<?php if(!defined('PARENT')) { exit; }
// Check product key exists.. 
if ($SETTINGS->prodKey=='' || strlen($SETTINGS->prodKey)!=60) {
  $productKey = mswProdKeyGen();
  mysql_query("UPDATE ".DB_PREFIX."settings SET
  `prodKey` = '$productKey'
  ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  $SETTINGS->prodKey = $productKey;
}
// Update encoder version if not already..
if ($SETTINGS->encoderVersion=='XX' && function_exists('ioncube_loader_version')) {
  mysql_query("UPDATE ".DB_PREFIX."settings SET
  `encoderVersion` = '".ioncube_loader_version()."'
  ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
}
?>

<div class="homeWrapper">

  <div id="innerArea">
  
    <div id="homeLeft">
      
      <div class="purchase" style="line-height:20px">
      
        <h2>Purchase Commercial Version</h2>
        <p>If you would like show your support for this software and enjoy the benefits of the commercial version of <?php echo SCRIPT_NAME; ?>, please consider purchasing a licence. Thank you.<br /><br />
        <b>1</b> - Please visit the <a href="http://www.<?php echo SCRIPT_URL; ?>" title="<?php echo SCRIPT_NAME; ?>" onclick="window.open(this);return false"><?php echo SCRIPT_NAME; ?> Website</a> and use the &#039;<span class="highlighter">Purchase</span>&#039; option.<br /><br />
        <b>2</b> - Once payment has been completed you will be redirected to the <a href="https://www.maiangateway.com/login.html" onclick="window.open(this);return false">Maian Script World Licence Centre</a>. If you aren`t directed there after payment, wait awhile for the confirmation e-mail and click the link.<br /><br />
        <b>3</b> - Generate your &#039;<span class="highlighter">licence.lic</span>&#039; licence file using the onscreen instructions. To generate a licence file you will need the unique <span class="highlighter">60 character product key</span> shown below.<br /><br />
        <b>4</b> - Upload the &#039;<span class="highlighter">licence.lic</span>&#039; file into your support installation folder and replace the default one.<br /><br />
        <b>5</b> - Select &#039;<span class="highlighter">Settings>Edit Footers</span>&#039; from the above menu. (This is hidden in the free version).
        </p>
      
     </div>
     
     <div class="purchase" style="margin:10px 0 0 0">
       
       <h2>Your Product Key</h2>
       <p class="key"><?php echo strtoupper($SETTINGS->prodKey); ?></p>
       
     </div>
    
    </div>
  
    <div id="homeRight">
      
      <div class="homeRightInner">
       <h2 style="border-top:0" class="freevcom">Free v Commercial</h2>
       <p style="padding-top:10px;line-height:17px">Not sure if its worth upgrading? Check out the feature comparison matrix:</p>
       <p style="padding-bottom:10px"><a href="http://www.<?php echo SCRIPT_URL; ?>/features.html" title="Feature Matrix" onclick="window.open(this);return false"><b>Click for Feature Matrix</b></a><br /><br />
       Other incentives for upgrading:<span class="incentives">
       &#043; ALL Future upgrades FREE of Charge<br />
       &#043; Notifications of new version releases<br />
       &#043; All features unlocked and unlimited<br />
       &#043; Copyright removal included in price<br />
       &#043; No links in email footers<br />
       &#043; One off payment, no subscriptions</span>
       </p>
      </div>
      
      <br class="clear" />
    </div>
  
    <br class="clear" />
  </div>
  
</div>  

<div class="homeWrapper">
</div>
