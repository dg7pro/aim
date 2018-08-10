<div id="wrapper">

<div id="boxes">
     
    <div id="leftBox">
      
    <h2><?php echo $this->MESSAGE[0]; ?></h2>
      
    <div class="ticketForm">
     <form method="get" action="index.php">
     
     <p>
     <label><?php echo $this->TEXT[0]; ?></label>
     <input class="box" type="text" name="q" value="<?php echo $this->KEYS; ?>" />
     </p>
     
     <p>
     <label><?php echo $this->TEXT[10]; ?></label>
     <select name="sc">
     <option value="0"><?php echo $this->TEXT[11]; ?></option>
     <?php
     // CATEGORIES
     // templates/html/faq-search-cat.htm
     // templates/html/faq-search-subcat.htm
     echo $this->SELECT_CATEGORIES; 
     ?>
     </select>
     </p>
     
     <p class="buttonWrapper">
      <input class="button" type="submit" value="<?php echo $this->TEXT[1]; ?> &raquo;" title="<?php echo $this->TEXT[1]; ?>" />
     </p>
     
     </form>
    </div>
      
    <br class="clear" />     
    </div>
     
    <div id="rightBox">
      
    <h2><?php echo $this->MESSAGE[1]; ?></h2>
      
    <div class="ticketForm">
     <form method="post" action="index.php">
     
     <p class="openNewTicket">
     <?php echo $this->TEXT[7]; ?>
     <span class="link"><a href="?p=ticket" title="<?php echo $this->TEXT[8]; ?>" rel="nofollow"><?php echo $this->TEXT[8]; ?></a></span>
     <?php echo $this->TEXT[9]; ?>
     </p>
     
     </form>
    </div>
    <br class="clear" />
    </div>    

  <br class="clear" />
  </div> 

  <div class="kbWrapper">

   <div id="categories">
  
    <h2><?php echo $this->MESSAGE[2]; ?></h2>
    
    <div class="faqWrapper">
    
      <ul class="cats">
      <?php
      // F.A.Q CATEGORIES
      // templates/html/faq-cat-link.htm
      echo $this->CATEGORIES; 
      ?>
      </ul>
    
      <br class="clear" />
    </div>
    
    <?php
    // SUB CATEGORIES
    // templates/html/faq-subcats.htm
    // templates/html/faq-subcat-link.htm
    echo $this->SUB_CATEGORIES;
    ?>
  
   </div>
  
  </div> 
   
  <div class="kbWrapper">
   
    <div id="questions">
   
     <h2><?php echo $this->MESSAGE[3]; ?></h2>
     
     <div class="faqWrapper">
    
      <?php
      // If this is a question, show answer. Otherwise show lists..
      if ($this->IS_QUESTION=='yes') {
      ?>
      <p class="answer"><?php echo $this->ANSWER; ?></p>
      <?php
      // QUESTION ATTACHMENTS
      // templates/html/faq-attachments.htm
      // templates/html/faq-attachments-link.htm
      echo $this->ATTACHMENTS;
      ?>
      <p class="qfooter">
       <?php
       // CONTROLS VOTING AREA
       // templates/html/voting-links.htm
       // templates/html/voting-static.htm
       echo $this->VOTING;
       echo $this->DATE_ADDED; 
       echo $this->IN_CATEGORY; 
       ?>
       <span class="qfooterLinks">
       <a href="?a=<?php echo (int)$_GET['a']; ?>" onclick="addBookmark('<?php echo $this->JS[0]; ?>',this.href);return false" title="<?php echo $this->TEXT[5]; ?>" class="bookmark" rel="nofollow"><?php echo $this->TEXT[5]; ?></a>
       <a href="javascript:window.print()" title="<?php echo $this->TEXT[6]; ?>" class="print" rel="nofollow"><?php echo $this->TEXT[6]; ?></a>
       </span>
      </p>
      <?php
      } else {
      ?>
      <ul class="ques">
      <?php
      // LINKS
      // templates/html/faq-article-link.htm
      echo $this->QUESTIONS; 
      ?>
      </ul>
      <?php
      }
      ?>
    
      <br class="clear" />
    </div>
    
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