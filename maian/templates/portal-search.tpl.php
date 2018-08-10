<div id="wrapper">
    
  <div id="topSearchBar">
    <p>
    <select  onchange="location=this.options[this.selectedIndex].value">
     <option value="?keys=<?php echo mswSpecialChars(urlencode($_GET['keys'])); ?>"><?php echo $this->TEXT[1]; ?></option>
     <option value="?keys=<?php echo mswSpecialChars(urlencode($_GET['keys'])); ?>&amp;f=ts"<?php echo (isset($_GET['f']) && $_GET['f']=='ts' ? ' selected="selected"' : ''); ?>><?php echo $this->TEXT[2]; ?></option>
     <option value="?keys=<?php echo mswSpecialChars(urlencode($_GET['keys'])); ?>&amp;f=ds"<?php echo (isset($_GET['f']) && $_GET['f']=='ds' ? ' selected="selected"' : ''); ?>><?php echo $this->TEXT[3]; ?></option>
    </select>
    <span class="text"><?php echo $this->TEXT[0]; ?></span>
    </p>
  </div>
  
  <div id="yourTickets">
  
    <div id="ticketsWrapper">
     
     <?php 
     // SEARCH RESULTS
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
