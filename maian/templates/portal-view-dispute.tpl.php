<div id="wrapper">

  <?php
  // Show error message if form not completed correctly on submission..
  if (!empty($this->E_ARRAY)) {
  ?>
  <div class="viewTicketErrors">
   <p class="formErrors"><?php echo $this->TEXT[10]; ?>:</p>
  </div> 
  <?php
  }
  ?>
  
  <div class="topBar">
    <p>
    <span class="links">
    <?php
    // POST PRIVILEGES
    if ($this->POST_PRIVILEGES=='yes') {
    ?>
    <a class="add" href="#" onclick="scrollToReply();return false" title="<?php echo $this->TEXT[11]; ?>"><?php echo $this->TEXT[11]; ?></a>
    <?php
    }
    ?>
    <a class="view-dispute" href="?p=vd" title="<?php echo $this->TEXT[12]; ?>"><?php echo $this->TEXT[12]; ?></a></span>
    <b><?php echo $this->TEXT[0]; ?></b>: <?php echo $this->TEXT_DATA[0]; ?> <span class="status">(<?php echo $this->TEXT_DATA[7]; ?>)</span>
    </p>
  </div>
  
  <div id="viewBoxes">
  
    <div id="viewLeft">
    
     <h2><?php echo $this->MESSAGE[0]; ?></h2>
     
     <div class="msg">
     <?php
     // ORIGINAL TICKET DATA.. 
     echo $this->TICKET_TEXT; 
     
     // CUSTOM FIELD DATA
     // templates/html/ticket-custom-field-data.htm
     // templates/html/ticket-custom-field-wrapper.htm
     echo $this->CUSTOM_FIELD_DATA;
     ?>
     </div>
     
     <?php
     // TICKET ATTACHMENTS
     // templates/html/ticket-attachment.htm
     if ($this->IS_ATTACHMENTS=='yes') {
     ?>
     <p class="attachments">
      <span class="files">
      <?php 
      echo $this->TICKET_ATTACHMENTS; 
      ?>
      </span>
      <span class="attachtext"><?php echo $this->TEXT[9]; ?></span>
      <br class="clear" />
     </p>
     <?php
     }
     ?>
     
    <br class="clear" /> 
    </div>
    
    <div id="viewRightDispute">
     
     <div class="users">
     
      <h2><?php echo $this->TEXT[13]; ?></h2>
    
      <div class="detailWrapper">
     
        <label class="first">- <?php echo $this->DISPUTE_STARTER; ?></label>
        
        <?php 
        // OTHER USERS IN DISPUTE
        // templates/html/users-in-dispute.htm
        echo $this->USERS_IN_DISPUTE; 
        ?>
        
      </div>  
     
     </div>
     
     <div class="info">
     
      <h2><?php echo $this->MESSAGE[1]; ?></h2>
    
      <div class="detailWrapper">
     
        <label class="first"><?php echo $this->TEXT[3]; ?></label>
        <p class="data"><?php echo $this->TEXT_DATA[3]; ?></p>
     
        <label><?php echo $this->TEXT[4]; ?></label>
        <p class="data"><?php echo $this->TEXT_DATA[4]; ?></p>
        
        <?php
        // IP shown only to original ticket creator..
        if ($this->SHOW_IP) {
        ?>
        <label><?php echo $this->TEXT[5]; ?></label>
        <p class="data"><?php echo $this->TEXT_DATA[5]; ?></p>
        <?php
        }
        ?>
     
        <label><?php echo $this->TEXT[6]; ?></label>
        <p class="data"><?php echo $this->TEXT_DATA[6]; ?></p>
        
        <?php
        // STAFF ASSIGNED
        if ($this->STAFF_ASSIGN) {
        ?>
        <label><?php echo $this->TEXT[16]; ?></label>
        <p class="data"><?php echo $this->STAFF_ASSIGN; ?></p>
        <?php
        }
        ?>
        
      </div>  
     
     </div> 
     
    </div>
  
    <br class="clear" /> 
  </div>
  
  <div id="ticketReplies">
    <?php echo 
    // TICKET REPLIES
    // templates/html/ticket-reply.htm
    // templates/html/no-replies.htm
    // templates/html/reply-admin-signature.htm
    // templates/html/ticket-attachment.htm
    $this->REPLY_DATA; 
    ?>
  </div>
  
  <?php
  // POST PRIVILEGES
  if ($this->POST_PRIVILEGES=='yes') {
  ?>
  <div id="replyBoxWrapper">
   
     <h2>
     <?php 
     echo $this->MESSAGE[2]; 
     ?>
     </h2>
     
     <div class="replyBox">
       
       <form method="post" id="form" action="?d=<?php echo (int)$_GET['d']; ?>"<?php echo $this->MULTIPART; ?>>
       <p>
         <?php
         // BB CODE
         // templates/html/bbcode-buttons.htm
         echo $this->BBCODE;
         ?>
         <textarea name="comments" tabindex="1" rows="15" id="comments" cols="40" onkeyup="jQuery('#e_comments').hide('slow')"><?php echo $this->COMMENTS; ?></textarea>
         <?php echo (in_array('comments',$this->E_ARRAY) ? '<span class="error" id="e_comments">'.$this->ERRORS[0].'</span>' : ''); ?>
       </p>
       <?php
       // CUSTOM FIELDS
       // templates/html/custom-fields/*
       echo $this->CUSTOM_FIELDS;
       
       // ATTACHMENT BOXES
       // templates/html/attachments.htm
       // templates/html/attachments-links.htm
       echo $this->ATTACHMENTS;
       
       // Only person who started ticket/dispute can close it..
       if ($this->CLOSE_PERMISSIONS=='yes') {
       ?>
       <p class="closeButton"><br />
        <input type="checkbox" name="close" value="1"<?php echo ($this->IS_CHECKED=='yes' ? ' checked="checked"' : ''); ?> /> <?php echo $this->TEXT[8]; ?>
       </p>
       <?php
       }
       ?>
       
       
       <p class="buttonWrapper">
         <?php
         // HIDDEN FIELDS. MUST NOT BE REMOVED
         echo $this->HIDDEN_FIELDS; 
         ?>
         <input type="hidden" name="process" value="1" />
         <input class="button" type="submit" tabindex="100" value="<?php echo $this->MESSAGE[2]; ?> &raquo;" title="<?php echo $this->MESSAGE[2]; ?>" />
         <input onclick="ms_ticketPreview('ticket','comments')" class="button_preview" type="button" tabindex="101" value="<?php echo $this->TEXT[15]; ?>" title="<?php echo $this->TEXT[15]; ?>" /><br /><br />
       </p>
       </form>
       
     </div>
   
   </div>
   <?php
   } else {
   ?>
   <p class="postOff"><?php echo $this->TEXT[14]; ?></p>
   <?php
   }
   ?>
   
</div>
