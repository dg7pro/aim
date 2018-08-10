<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: page.php
  Description: Class File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

class pagination {

function pagination($count,$query) {
  global $msg_script42;
  $this->total      = $count;
  $this->start      = 0;
  $this->text       = $msg_script42;
  $this->query      = $query;
  $this->split      = 10;
}

function display() {
  global $page;
  $html            = '';
  // How many pages?
  $this->num_pages = ceil($this->total/PER_PAGE);
  // If pages less than or equal to 1, display nothing..
  if ($this->num_pages <= 1) {
    return $html;
  }
  // Build pages..
  $current_page  = $page;
  $begin         = $current_page-$this->split;
  $end           = $current_page+$this->split;
  if ($begin<1) {
    $begin = 1;
    $end   = $this->split*2;
  }
  if ($end>$this->num_pages) {
    $end   = $this->num_pages;
    $begin = $end-($this->split*2);
    $begin++;
    if ($begin < 1) {
      $begin = 1;
    }
  }
  if ($current_page!=1) {
    $html .= '<a class="first" title="'.mswSpecialChars($this->text[0]).'" href="'.$this->query.'1">&laquo;</a>';
    $html .= '<a class="prev" title="'.mswSpecialChars($this->text[1]).'" href="'.$this->query.($current_page-1).'">'.$this->text[1].'</a>';
  } else {
    $html .= '<span class="disabled_first" title="'.mswSpecialChars($this->text[0]).'">&laquo;</span>';
    $html .= '<span class="disabled_prev" title="'.mswSpecialChars($this->text[1]).'">'.$this->text[1].'</span>';
  }
  for ($i=$begin; $i<=$end; $i++) {
    if ($i!=$current_page) {
      $html .= '<a title="'.$i.'" href="'.$this->query.$i.'">'.$i.'</a>';
    } else {
      $html .= '<span class="current">'.$i.'</span>';
    }
  }
  if ($current_page!=$this->num_pages) {
    $html .= '<a class="next" title="'.mswSpecialChars($this->text[2]).'" href="'.$this->query.($current_page+1).'">'.$this->text[2].'</a>';
    $html .= '<a class="last" title="'.mswSpecialChars($this->text[3]).'" href="'.$this->query.$this->num_pages.'">&raquo;</a>';
  } else {
    $html .= '<span class="disabled_next" title="'.mswSpecialChars($this->text[2]).'">'.$this->text[2].'</span>';
    $html .= '<span class="disabled_last" title="'.mswSpecialChars($this->text[3]).'">&raquo;</span>';
  }
  return '<div class="pagination"><p>'.$html.'</p></div>';
}

}

?>