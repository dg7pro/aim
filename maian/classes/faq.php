<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Written by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: faq.php
  Description: Class File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

class faqSystem {

// Attachments..
function buildAttachments($id) {
  $html   = '';
  $q_att  = mysql_query("SELECT * FROM ".DB_PREFIX."faqattassign
            LEFT JOIN ".DB_PREFIX."faqattach
            ON ".DB_PREFIX."faqattassign.attachment    = ".DB_PREFIX."faqattach.id
            WHERE ".DB_PREFIX."faqattassign.`question` = '$id'
            GROUP BY ".DB_PREFIX."faqattassign.`attachment`
            ORDER BY ".DB_PREFIX."faqattach.`name`
            ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  while ($ATT = mysql_fetch_object($q_att)) {
    $ext   = substr(strrchr(($ATT->path ? $ATT->path : $ATT->remote), '.'),1);
    $type  = (file_exists(PATH.'templates/images/types/'.strtolower($ext).'.png') ? $ext : 'blank');
    $html .= str_replace(
              array(
               '{url}',
               '{name}',
               '{type}',
               '{size}',
               '{filetype}'
              ),
              array(
               ($ATT->remote ? $ATT->remote : 'templates/attachments/faq/'.$ATT->path),
               ($ATT->name ? mswSpecialChars($ATT->name) : basename(($ATT->remote ? $ATT->remote : 'templates/attachments/faq/'.$ATT->path))),
               $type,
               mswFileSizeConversion($ATT->size),
               strtoupper($ext)
              ),
              file_get_contents(PATH.'templates/html/faq-attachments-link.htm')
             ).mswDefineNewline();
  }
  return ($html ? str_replace('{attachments}',$html,file_get_contents(PATH.'templates/html/faq-attachments.htm')) : ''); 
}

// Get voting percentages..
function getPercentages($id) {
  $data = mswGetTableData('faq','id',$id);
  if ($data->kviews==0) {
    return array(0,0,0);
  }
  $yes  = @number_format($data->kuseful/$data->kviews*100,VOTING_DECIMAL_PLACES);
  $no   = @number_format($data->knotuseful/$data->kviews*100,VOTING_DECIMAL_PLACES);
  return array($yes,$no);
}

// Get all votes..
function getAllVotes() {
  $kbase = array();
  if (isset($_COOKIE[md5(SECRET_KEY).COOKIE_NAME])) {
    if (strpos($_COOKIE[md5(SECRET_KEY).COOKIE_NAME],'|')!==FALSE) {
      $kbase   = explode('|',$_COOKIE[md5(SECRET_KEY).COOKIE_NAME]);
    } else {
      $kbase[] = $_COOKIE[md5(SECRET_KEY).COOKIE_NAME];
    }
  }
  return $kbase;
}

// Add new vote..
function addVote($id,$vote) {
  global $SETTINGS;
  switch ($vote) {
    case 'yes':
    $table = '`kuseful` = (`kuseful`+1)';
    break;
    case 'no':
    $table = '`knotuseful` = (`knotuseful`+1)';
    break;
  }
  // As query is via ajax, we mask any potential mysql errors to prevent xml errors..
  @mysql_query("UPDATE ".DB_PREFIX."faq SET
  `kviews`    = (`kviews`+1),
  $table
  WHERE id  = '$id'
  LIMIT 1
  ");
  // If multiple votes are allowed, don`t set cookie and return..
  if ($SETTINGS->multiplevotes=='yes') {
    return;
  }
  $cookie    = faqSystem::getAllVotes();
  $cookie[]  = $id;
  if (isset($_COOKIE[md5(SECRET_KEY).COOKIE_NAME])) {
    setcookie(md5(SECRET_KEY).COOKIE_NAME,'');
    unset($_COOKIE[md5(SECRET_KEY).COOKIE_NAME]);
  }
  if (count($cookie)>1) {
    $c = implode('|',$cookie);
  } else {
    $c = $id;
  }
  setcookie(md5(SECRET_KEY).COOKIE_NAME,$c,time()+60*60*24*$SETTINGS->cookiedays);
}

// Load voting system for question..
function votingSystem($id) {
  global $msg_script4,$msg_script5,$msg_pkbase12,$msg_pkbase13;
  $kbase = faqSystem::getAllVotes();
  $nums  = array(0,0);
  if (in_array($id,$kbase)) {
    $nums  = faqSystem::getPercentages($id);
  }
  return str_replace(array('{text}','{yes}','{no}','{p1}','{p2}','{id}'),
                     array(in_array($id,$kbase) ? $msg_pkbase13 : $msg_pkbase12,
                           $msg_script4,
                           $msg_script5,
                           $nums[0],
                           $nums[1],
                           $id
                     ),
                     file_get_contents(PATH.'templates/html/voting-'.(in_array($id,$kbase) ? 'static' : 'links').'.htm')
         );
}

// Build knowledge base categories..
function buildCategories($select=false) {
  global $msg_pkbase10;
  $data   = '';
  $query  = mysql_query("SELECT * FROM ".DB_PREFIX."categories 
            WHERE `enCat` = 'yes' 
            AND `subcat`  = '0'
            ORDER BY `orderBy`
            ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  while ($CATS = mysql_fetch_object($query)) {
    $data .= str_replace(array('{cat}','{category}','{summary}','{count}','{selected}'),
                         array(
                          $CATS->id,
                          mswSpecialChars($CATS->name), 
                          mswSpecialChars($CATS->summary),
                          (!$select ? mswRowCount('faq WHERE `category` IN (0,'.$CATS->id.') AND `enFaq` = \'yes\'') : '0'),
                          (isset($_GET['sc']) && $_GET['sc']==$CATS->id ? ' selected="selected"' : '')
                         ),
                         file_get_contents(PATH.'templates/html/'.($select ? 'faq-search-cat' : 'faq-cat-link').'.htm')
             ); 
    // Sub categories for drop down..
    if ($select) {
      $query2  = mysql_query("SELECT * FROM ".DB_PREFIX."categories 
                 WHERE `enCat` = 'yes' 
                 AND `subcat`  = '{$CATS->id}'
                 ORDER BY `orderBy`
                 ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
      while ($SUB = mysql_fetch_object($query2)) {
        $data .= str_replace(array('{cat}','{category}','{summary}','{count}','{selected}'),
                             array(
                              $SUB->id,
                              mswSpecialChars($SUB->name), 
                              mswSpecialChars($SUB->summary),
                              '0',
                              (isset($_GET['sc']) && $_GET['sc']==$SUB->id ? ' selected="selected"' : '')
                             ),
                             file_get_contents(PATH.'templates/html/faq-search-subcat.htm')
                 );
      }
    }         
  }
  return ($data ? trim($data) : ($select ? '' : str_replace('{text}',$msg_pkbase10,file_get_contents(PATH.'templates/html/nothing-found.htm'))));
}

// Build knowledge base sub categories..
function buildSubCategories($id) {
  global $msg_pkbase20;
  $data   = '';
  $query  = mysql_query("SELECT * FROM ".DB_PREFIX."categories 
            WHERE `enCat` = 'yes' 
            AND `subcat`  = '$id'
            ORDER BY `orderBy`
            ") or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  while ($CATS = mysql_fetch_object($query)) {
    $data .= str_replace(array('{cat}','{category}','{summary}','{count}','{selected}','{parent}'),
                         array(
                          $CATS->id,
                          mswSpecialChars($CATS->name), 
                          mswSpecialChars($CATS->summary),
                          mswRowCount('faq WHERE `category` IN (0,'.$CATS->id.') AND `enFaq` = \'yes\''),
                          '',
                          $CATS->subcat
                         ),
                         file_get_contents(PATH.'templates/html/faq-subcat-link.htm')
             ); 
  }
  $txt   = str_replace('{count}',mysql_num_rows($query),$msg_pkbase20);
  $wrap  = str_replace(array('{text}','{subcats}'),array($txt,$data),file_get_contents(PATH.'templates/html/faq-subcats.htm'));
  return ($data ? trim($wrap) : '');
}

// Build category links..
function buildLinks($cat=0,$search='',$cnt=false) {
  global $msg_pkbase8,$msg_pkbase9,$SETTINGS,$limit,$limitvalue;
  $data   = '';
  $c      = array();
  if ($search) {
    $keys  = 'AND (`answer` LIKE \'%'.mswSafeImportString($search).'%\' OR `question` LIKE \'%'.mswSafeImportString($search).'%\')';
  }
  // If we aren`t filtering by cat, find all cats enabled...
  if ($cat==0) {
    $qC     = mysql_query("SELECT * FROM ".DB_PREFIX."categories WHERE `enCat` = 'yes'") 
              or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
    while ($CATEGORIES = mysql_fetch_object($qC)) {
      $c[] = $CATEGORIES->id;
    }
  }
  // Prevent sql error on install because of empty array..
  if (empty($c)) {
    $c[] = 0;
  }
  $query  = mysql_query("SELECT SQL_CALC_FOUND_ROWS * FROM ".DB_PREFIX."faq
            WHERE `enFaq` = 'yes'
            ".($cat>0 ? 'AND `category` IN (0,'.$cat.')' : 'AND `category` IN (0,'.implode(',',$c).')')."
            ".($search ? $keys : '')."
            ORDER BY ".($cat>0 || $search!='' ? CATEGORY_FAQ_ORDER_BY.' LIMIT '.$limitvalue.','.$SETTINGS->quePerPage : FAQ_POPULAR_ORDER_BY.' LIMIT '.$SETTINGS->popquestions)
            ) or die((ENABLE_MYSQL_ERRORS ? mswMysqlErrMsg(mysql_errno(),mysql_error(),__LINE__,__FILE__) : MYSQL_DEFAULT_ERROR));
  // Count of rows returned..
  $c            = mysql_fetch_object(mysql_query("SELECT FOUND_ROWS() AS rows"));
  $countedRows  =  (isset($c->rows) ? $c->rows : '0');
  if ($cnt) {
    return $countedRows;
  }
  while ($LINKS = mysql_fetch_object($query)) {
    $data .= str_replace(array('{article}','{question}','{count}','{sublink}'),
                         array(
                          $LINKS->id.($LINKS->category==0 && $cat>0 ? '-'.$cat : ''),
                          mswSpecialChars($LINKS->question),
                          number_format($LINKS->kviews),
                          (isset($_GET['sb']) && $_GET['sb']>0 ? '&amp;sb='.(int)$_GET['sb'] : '')
                         ),
                         file_get_contents(PATH.'templates/html/faq-article-link.htm')
             ); 
  }
  return ($data ? 
            trim($data) : 
              str_replace('{text}',
                ($search ? str_replace('{search}',mswCleanData($search),$msg_pkbase9) : $msg_pkbase8),
                  file_get_contents(PATH.'templates/html/nothing-found.htm')
                )
              );
}

}

?>