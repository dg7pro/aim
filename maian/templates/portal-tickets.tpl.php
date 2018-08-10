<div id="wrapper">
    
  <div class="topBar">
    <p>
    <span class="links"><a class="newticket" href="?p=ticket" title="<?php echo $this->TEXT[1]; ?>"><?php echo $this->TEXT[1]; ?></a></span>
    <?php echo $this->TEXT[0]; ?>
    </p>
  </div>
  
  <div id="yourTickets">
  
    <div id="ticketsWrapper">
     
     <?php 
     // SHOW TICKETS
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
