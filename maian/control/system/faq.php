<?php

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  Script: Maian Support
  Programmed & Designed by: David Ian Bennett
  E-Mail: support@maianscriptworld.co.uk
  Software Website: http://www.maiansupport.com
  Script Portal: http://www.maianscriptworld.co.uk

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
  This File: faq.php
  Description: System File

  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

if (!defined('PARENT')) {
  msw403();
}

$title       = $msg_adheader17;
$limit       = $SETTINGS->quePerPage;
$limitvalue  = $page * $limit - ($limit);
$pageNumbers = '';
define('PER_PAGE',$SETTINGS->quePerPage);
  
if ($SETTINGS->multiplevotes=='yes' && isset($_COOKIE[md5(SECRET_KEY).'_que'])) {
  @setcookie(md5(SECRET_KEY).'_que','');
  unset($_COOKIE[md5(SECRET_KEY).'_que']);
}
  
// Article..
if (isset($_GET['a'])) {
  if (strpos($_GET['a'],'-')!==false) {
    $s = explode('-',$_GET['a']);
    mswCheckDigit($s[0]);
    mswCheckDigit($s[1]);
  } else {
    mswCheckDigit($_GET['a']);
  }
  $QUE = mswGetTableData('faq','id',$_GET['a'],'AND `enFaq` = \'yes\'','*');
  if (!isset($QUE->question)) {
    msw404();
  }
  if ($QUE->category>0 || isset($s[1])) {
    $CAT = mswGetTableData('categories','id',(isset($s[1]) ? (int)$s[1] : $QUE->category),'AND `enCat` = \'yes\'');
    if (!isset($CAT->name)) {
      msw404();
    }
  } else {
    $CAT->name = $msg_pkbase7;
  }
  $title         = $QUE->question.' - '.$CAT->name.' - '.$msg_adheader17;
  $nameOverRide  = mswSpecialChars($QUE->question);
}

// Category..
if (isset($_GET['c'])) {
  mswCheckDigit($_GET['c']);
  $CAT = mswGetTableData('categories','id',$_GET['c'],'AND `enCat` = \'yes\'');
  if (!isset($CAT->name)) {
    msw404();
  }
  $title         = $CAT->name.' - '.$msg_adheader17;
  $nameOverRide  = mswSpecialChars($CAT->name);
  $pageCount     = mswRowCount('faq WHERE category IN (\''.$_GET['c'].'\',\'0\') AND `enFaq` = \'yes\'');
  if ($pageCount>$SETTINGS->quePerPage) {
    $PTION       = new pagination($pageCount,'?p=faq&amp;c='.$_GET['c'].'&amp;next=');
    $pageNumbers = $PTION->display();
  }
}
// Search..
if (isset($_GET['q'])) {
  if (trim($_GET['q'])) {
    if (isset($_GET['sc'])) {
      mswCheckDigit($_GET['sc']);
    }
    $sQuery        = true;
    $CAT           = new stdclass();
    $CAT->id       = $_GET['sc'];
    $title         = $msg_adheader17;
    $pageCount     = $FAQ->buildLinks($CAT->id,$_GET['q'],true);
    if ($pageCount>$SETTINGS->quePerPage) {
      $PTION       = new pagination($pageCount,'?p=faq&amp;q='.urlencode($_GET['q']).'&amp;sc='.$CAT->id.'&amp;next=');
      $pageNumbers = $PTION->display();
    }
    $nameOverRide  = str_replace('{count}',$pageCount,$msg_pkbase6);
    
  } else {
    header("Location: index.php?p=faq");
    exit;
  }
}
// Vote..
if (isset($_GET['v']) && isset($_GET['vote']) && in_array($_GET['vote'],array('yes','no'))) {
  if (is_numeric($_GET['v']) && mswRowCount('faq WHERE `id` = \''.$_GET['v'].'\' AND `enFaq` = \'yes\'')>0) {
    if ($SETTINGS->enableVotes=='yes') {
      $FAQ->addVote($_GET['v'],$_GET['vote']);
      $NUMS =    $FAQ->getPercentages($_GET['v']);
      $arr  =    array(
       '0'    =>   $NUMS[0],
       '1'    =>   $NUMS[1],
       '2'    =>   mswSpecialChars($msg_script4),
       '3'    =>   mswSpecialChars($msg_script5),
       '4'    =>   mswSpecialChars($msg_javascript58)
      );
      echo json_encode($arr);
      exit;
    }
  }
}
  
include(PATH.'control/header.php');

// Var override..
if ($cmd=='faq') {
  $msg_main17 = $msg_main23;
}

$tpl = mswGetSavant();
$tpl->assign('MESSAGE', array($msg_pkbase,$msg_main2,
                              str_replace('{count}',mswRowCount('categories WHERE `enCat` = \'yes\' AND `subcat` = \'0\''),$msg_pkbase4),
                              (isset($nameOverRide) ? $nameOverRide : str_replace('{count}',$SETTINGS->popquestions,$msg_pkbase5)),
                              $msg_pkbase14
                        ));
$tpl->assign('TEXT', array($msg_pkbase2,$msg_pkbase3,$msg_main6,$msg_pkbase7,$msg_pkbase12,$msg_pkbase17,$msg_pkbase18,mswSpecialChars($msg_main16),
                           mswSpecialChars($msg_main2),mswSpecialChars($msg_main17),mswSpecialChars($msg_main21),mswSpecialChars($msg_main22)));
$tpl->assign('JS',array_map('mswFilterJS',array((isset($nameOverRide) ? $nameOverRide : ''))));
$tpl->assign('CATEGORIES', $FAQ->buildCategories());
$tpl->assign('SUB_CATEGORIES', (isset($_GET['c']) || isset($_GET['sb']) ? $FAQ->buildSubCategories((isset($_GET['sb']) ? (int)$_GET['sb'] : (int)$_GET['c'])) : ''));
$tpl->assign('SELECT_CATEGORIES', $FAQ->buildCategories(true));
$tpl->assign('KEYS',(isset($_GET['q']) ? mswCleanData($_GET['q']) : ''));
$tpl->assign('QUESTIONS',$FAQ->buildLinks(isset($CAT->id) ? $CAT->id : 0,isset($sQuery) ? $_GET['q'] : false));
$tpl->assign('IS_QUESTION',(isset($QUE->category) ? 'yes' : 'no'));
$tpl->assign('SEARCH_HELP',$msg_pkbase15);
$tpl->assign('CLOSE_SEARCH_HELP',$msg_pkbase16);
if (isset($QUE->category)) {
$tpl->assign('ATTACHMENTS', $FAQ->buildAttachments($QUE->id));
$tpl->assign('ANSWER', mswTxtParsingEngine($QUE->answer));
$tpl->assign('DATE_ADDED', str_replace('{date}',mswDateDisplay($QUE->ts,$SETTINGS->dateformat),$msg_pkbase11));
$tpl->assign('IN_CATEGORY', str_replace('{category}',mswSpecialChars($CAT->name),$msg_pkbase19));
$tpl->assign('VOTING', ($SETTINGS->enableVotes=='yes' ? $FAQ->votingSystem($QUE->id) : ''));
}
$tpl->assign('PAGES', $pageNumbers);
$tpl->display('templates/faq.tpl.php');
include(PATH.'control/footer.php');  

?>