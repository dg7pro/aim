<div id="wrapper">
    
  <div id="boxes">
     
    <div id="leftBoxPortal">
    
    <h2><span class="setts"><a href="#" onclick="jQuery('.timezones').slideDown('slow');return false" title="<?php echo $this->TEXT[13]; ?>"><?php echo $this->TEXT[13]; ?></a></span><?php echo $this->MESSAGE[1]; ?></h2>
      
    <p class="timezones">
    <?php echo $this->TEXT[14]; ?>: <select name="timezone" onchange="ms_SetTimezone(this.value)">
    <option value="0">- - - - - - -</option>
    <?php
    // TIMEZONES..
    foreach ($this->TIMEZONES AS $k => $v) {
    ?>
    <option value="<?php echo $k; ?>"<?php echo ($this->CURRENT_TS==$k ? ' selected="selected"' : ''); ?>><?php echo $v; ?></option>
    <?php
    }
    ?>
    </select> [<a href="#" onclick="jQuery('.timezones').slideUp('slow');return false">X</a>]
    </p>  
      
    <p><?php echo $this->TEXT[2]; ?></p>
      
    <br class="clear" />     
    </div>
     
    <div id="rightBoxPortal">
      
    <h2><?php echo $this->MESSAGE[0]; ?></h2>
    
    <div class="mainDisplay" id="mainDisplay">
    
     <ul>
       <li class="stats">
        <ul>
         <li class="open"><?php echo $this->TEXT[6]; ?></li>
         <li class="opendis"><?php echo $this->TEXT[7]; ?></li>
        </ul>
        <br class="clear" />
       </li>  
       <li class="linksArea">
        <ul>
         <li class="pass"><a href="#" onclick="showHideBoxes('show-pass');return false" title="<?php echo $this->TEXT[1]; ?>"><?php echo $this->TEXT[1]; ?></a></li>
         <li class="email"><a href="#" onclick="showHideBoxes('show-email');return false" title="<?php echo $this->TEXT[5]; ?>"><?php echo $this->TEXT[5]; ?></a></li>
         <li class="tickets"><a href="?p=vt" title="<?php echo $this->TEXT[8]; ?>"><?php echo $this->TEXT[8]; ?></a></li>
         <li class="disputes"><a href="?p=vd" title="<?php echo $this->TEXT[9]; ?>"><?php echo $this->TEXT[9]; ?></a></li>
        </ul>
        <br class="clear" />
       </li>   
     </ul>  
    
    </div>
      
    <div id="passArea" style="display:none">
     <p>
     <label><?php echo $this->TEXT[0]; ?></label>
     <input class="box" type="password" name="upass" id="upass" value="" onkeyup="jQuery('#eError').hide('slow')" />
     
     </p>
     <p class="buttonWrapper">
      <input class="button" onclick="ms_updatePass()" type="button" value="<?php echo $this->TEXT[1]; ?> &raquo;" title="<?php echo $this->TEXT[1]; ?>" />
      <input onclick="showHideBoxes('close-pass')" class="button2" type="button" value="X" title="X" />
     </p>
    </div>
    
    <div id="emailArea" style="display:none">
     <p>
     <label><?php echo $this->TEXT[5]; ?></label>
     <input class="box" type="text" name="uemail" id="uemail" value="" onkeyup="jQuery('#eError').hide('slow')" />
     
     </p>
     <p class="buttonWrapper">
      <input class="button" onclick="ms_updateEmail()" type="button" value="<?php echo $this->TEXT[5]; ?> &raquo;" title="<?php echo $this->TEXT[5]; ?>" />
      <input onclick="showHideBoxes('close-email')" class="button2" type="button" value="X" title="X" />
     </p>
    </div>
      
    <br class="clear" />
    </div>

  
    <br class="clear" />
  </div> 
  
  <div id="yourTickets">
  
    <div id="ticketList">
  
      <h2>
      <span><?php echo $this->TEXT[3]; ?></span>
      <select onchange="location=this.options[this.selectedIndex].value">
       <option value="?p=portal"><?php echo $this->TEXT[10]; ?></option>
       <option value="?p=portal&amp;display=tickets"<?php echo (isset($_GET['display']) && $_GET['display']=='tickets' ? ' selected="selected"' : ''); ?>><?php echo $this->TEXT[11]; ?></option>
       <option value="?p=portal&amp;display=disputes"<?php echo (isset($_GET['display']) && $_GET['display']=='disputes' ? ' selected="selected"' : ''); ?>><?php echo $this->TEXT[12]; ?></option>
      </select>
      </h2>
      
    </div>
    
    <div id="ticketsWrapper">
     
     <?php 
     // ALL OPEN TICKETS/DISPUTES
     // templates/html/portal-tickets.htm
     echo $this->TICKETS; 
     ?>
     
    </div>
    
    <?php
    // PAGE NUMBERS
    // classes/page.php
    if ($this->PAGES) {
      echo $this->PAGES;
    }
    ?>
    
  </div>
     
</div> 
