<div id="wrapper">

<div id="newTicketWrapperMessage">
    <script type="text/javascript">
    //<![CDATA[
    jQuery(document).ready(function() {
      if (typeof name!=undefined && jQuery('#name').val()=='') {
        jQuery('#name').focus();
      } else {
        if (typeof subject!=undefined) {
          jQuery('#subject').focus();
        }
      }
      <?php
      // If form had errors, reload custom fields and populate data entered..
      if (isset($_POST['process']) && (int)$_POST['dept']>0) {
      ?>
      deptLoader('<?php echo $_POST['dept']; ?>','yes');
      <?php
      }
      ?>
    });
    //]]>
    </script>
    
    <p class="message">
     <?php 
     echo $this->TEXT[0]; 
     
     // Show error message if form not completed correctly on submission..
     if (!empty($this->E_ARRAY)) {
     ?>
     <span class="formErrors"><?php echo $this->TEXT[12]; ?>:</span>
     <?php
     }
     ?>
    </p>
    
  </div>
  
  <div id="newTicketWrapper">
  
  <h2><?php echo $this->TEXT[1]; ?></h2>
  
  <form method="post" action="index.php?p=ticket"<?php echo $this->MULTIPART; ?>>
  
  <div class="ticketForm">
     <div class="boxArea">
       
       <div class="boxLeft">
        
        <label>* <?php echo $this->TEXT[3]; ?></label>
        <input class="box" type="text" name="name" id="name" tabindex="1" maxlength="250" value="<?php echo $this->VALUE[0]; ?>" onkeyup="jQuery('#e_name').hide('slow')"<?php echo $this->READONLY_NAME; ?> />
        <?php echo (in_array('name',$this->E_ARRAY) ? '<span class="error" id="e_name">'.$this->ERRORS[0].'</span>' : ''); ?>
        
        <label>* <?php echo $this->TEXT[2]; ?></label>
        <select name="dept" tabindex="3" id="dept" onchange="if(this.value>0){deptLoader(this.value,'no');jQuery('#e_dept').hide('slow')}">
        <option value="0">- - - -</option>
        <?php echo $this->DEPARTMENTS; ?>
        </select>
        <?php echo (in_array('dept',$this->E_ARRAY) ? '<span class="error" id="e_dept">'.$this->ERRORS[6].'</span>' : ''); ?>
        
        <br class="clear" />
       </div> 
       
       <div class="boxRight">
        
        <label>* <?php echo $this->TEXT[4]; ?></label>
        <input class="box" type="text" name="email" id="email" tabindex="2" maxlength="250" value="<?php echo $this->VALUE[1]; ?>" onkeyup="jQuery('#e_email').hide('slow')"<?php echo $this->READONLY_EMAIL; ?> />
        <?php echo (in_array('email',$this->E_ARRAY) ? '<span class="error" id="e_email">'.$this->ERRORS[1].'</span>' : ''); ?>
       
        <label>* <?php echo $this->TEXT[5]; ?></label>
        <input class="box" type="text" name="subject" id="subject" tabindex="4" maxlength="250" value="<?php echo $this->VALUE[2]; ?>" onkeyup="jQuery('#e_subject').hide('slow')" />
        <?php echo (in_array('subject',$this->E_ARRAY) ? '<span class="error" id="e_subject">'.$this->ERRORS[2].'</span>' : ''); ?>
        
        <br class="clear" />
       </div>
      
       <br class="clear" />
      </div>
    
  </div>
  
  <div class="ticketFormOther">  
      <div class="boxArea"> 
       
       <label>*
       <?php 
       echo $this->TEXT[6]; 
       ?>
       </label>
       <p>
       <?php
       // BB CODE
       // templates/html/bbcode-buttons.htm
       echo $this->BBCODE;
       ?>
       <textarea rows="12" cols="40" name="comments" id="comments" tabindex="5" onkeyup="jQuery('#e_comments').hide('slow')"><?php echo $this->VALUE[3]; ?></textarea>
       <?php echo (in_array('comments',$this->E_ARRAY) ? '<span class="error" id="e_comments">'.$this->ERRORS[3].'</span>' : ''); ?>
       </p>
       
      </div>
      
      <div class="boxArea">  
       
       <label>* <?php echo $this->TEXT[7]; ?></label>
       <p>
       <select name="priority" tabindex="6">
        <?php
        foreach ($this->PRIORITY_LEVELS AS $k => $v) {
        ?>
        <option value="<?php echo $k; ?>"<?php echo ($this->PRIORITY_LEVEL_SELECTED==$k ? ' selected="selected"' : ''); ?>><?php echo $v; ?></option>
        <?php
        }
        ?>
       </select>
       <?php echo (in_array('priority',$this->E_ARRAY) ? '<span class="error" id="e_priority">'.$this->ERRORS[7].'</span>' : ''); ?>
       </p>
      
      </div>
      
      <?php 
      // CUSTOM FIELDS
      // templates/html/custom-fields/*
      echo $this->CUSTOM_FIELDS;
      
      // ATTACHMENTS
      // templates/html/attachments.htm
      // templates/html/attachments-links.htm
      echo $this->ATTACHMENTS; 
      
      // SPAM PREVENTION IF RECAPTCHA ENABLED
      // templates/html/recaptcha.htm
      echo $this->SHOW_RECAPTCHA; 
      ?>
      
      <p class="buttonWrapper">
       <input type="hidden" name="process" value="1" />
       <?php
       // HIDDEN FIELDS. DO NOT REMOVE
       echo $this->HIDDEN_FIELDS; 
       ?>
       <input class="button" type="submit" tabindex="100" value="<?php echo $this->TEXT[11]; ?>" title="<?php echo $this->TEXT[11]; ?>" />
       <input onclick="ms_ticketPreview('ticket','comments')" class="button_preview" type="button" tabindex="101" value="<?php echo $this->TEXT[13]; ?>" title="<?php echo $this->TEXT[13]; ?>" />
      </p> 

  </div>
  </form>
    
  </div>
  
</div>  