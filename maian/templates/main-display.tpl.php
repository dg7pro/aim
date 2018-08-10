<div id="wrapper">
  
  <script type="text/javascript">
  //<![CDATA[
  jQuery(document).ready(function() {
    if (jQuery('#email').val()!='' && jQuery('#upass').val()=='') {
      jQuery('#upass').focus();
    } else {
      if (jQuery('#email').val()=='') {
        jQuery('#email').focus();
      }
    }
  });
  //]]>
  </script>
  
  <div id="boxes">
     
    <div id="leftBox">
      
    <h2><?php echo $this->MESSAGE[0]; ?></h2>
      
    <div class="ticketForm">
     <form method="post" action="index.php">
     
     <p>
     <label><?php echo $this->TEXT[0]; ?></label>
     <input class="box" type="text" id="email" name="email" value="<?php echo $this->VALUE[0]; ?>" onkeyup="jQuery('#eError').hide('slow')" />
     <?php echo $this->ERROR[0]; ?>
     </p>
     
     <p id="pbox">
     <label><?php echo $this->TEXT[1]; ?></label>
     <input class="box" type="password" name="upass" id="upass" value="<?php echo $this->VALUE[1]; ?>" onkeyup="jQuery('#pError').hide('slow')" />
     <?php echo $this->ERROR[1]; ?>
     </p>
     
     <p class="buttonWrapper" id="viewTickets">
      <span class="forgot"><a href="#" title="<?php echo $this->TEXT[4]; ?>" onclick="toggleBoxes('on')" rel="nofollow"><?php echo $this->TEXT[4]; ?></a></span>
      <input type="hidden" name="process" value="1" />
      <input class="button" type="submit" value="<?php echo $this->TEXT[2]; ?> &raquo;" title="<?php echo $this->TEXT[2]; ?>" />
     </p>
     
     <p class="buttonWrapper" id="newPass" style="display:none">
      <input class="button3" type="button" value="<?php echo $this->JS[0]; ?> &raquo;" title="<?php echo $this->JS[0]; ?>" onclick="sendNewPassword()" /> 
      <input onclick="toggleBoxes('off')" class="button2" type="button" value="X" title="X" />
     </p>
     
     </form>
    </div>
      
    <br class="clear" />     
    </div>
     
    <div id="rightBox">
      
    <h2><?php echo $this->MESSAGE[1]; ?></h2>
      
    <div class="ticketForm">
     
     <p class="openNewTicket">
     <?php echo $this->TEXT[7]; ?>
     <span class="link"><a href="?p=ticket" title="<?php echo $this->TEXT[8]; ?>" rel="nofollow"><?php echo $this->TEXT[8]; ?></a></span>
     <?php echo $this->TEXT[9]; ?>
     </p>
    
    </div>
    
    <br class="clear" />
    </div>
  <br class="clear" />
  </div> 
  
  <?php
  // Show FAQ only if enabled..
  if ($this->SETTINGS->kbase=='yes') {
  ?>
  <div class="kbWrapper">
   
   <div id="questions">
   
     <h2 class="faq"><span class="float"><a href="?p=faq" title="<?php echo $this->TEXT[10]; ?>"><?php echo $this->TEXT[10]; ?></a></span><?php echo $this->MESSAGE[2]; ?></h2>
     
     <div class="faqWrapper">
      
      <ul class="ques">
      <?php
      // Links..
      // templates/html/faq-article-link.htm
      echo $this->QUESTIONS; 
      ?>
      </ul>
     
     </div>
   
   </div>  
  
  </div>
  <?php
  }
  ?>
  
</div>