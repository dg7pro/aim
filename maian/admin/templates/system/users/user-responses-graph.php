<?php if(!defined('PARENT')) { exit; } 
$_GET['graph'] = (int)$_GET['graph'];
$USER          = mswGetTableData('users','id',$_GET['graph']);
if (file_exists(PATH.'templates/header-custom.php')) {
  include_once(PATH.'templates/header-custom.php');
} else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
}
// For graphs..
$buildGraph = $MSUSERS->userGraphData();
if (!isset($_GET['range'])) {
  $_GET['range'] = USER_DEFAULT_GRAPH_VIEW;
}
?>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=<?php echo $msg_charset; ?>" />
<title><?php echo mswSpecialChars($msg_kbase12); ?></title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.js"></script>
<!--[if lte IE 8]>
<script type="text/javascript" src="templates/js/jqplot/excanvas.js"></script>
<![endif]-->
<script type="text/javascript" src="templates/js/jqplot/jqplot.js"></script>
<script type="text/javascript" src="templates/js/jqplot/jqplot.pieRenderer.js"></script>
<script type="text/javascript" src="templates/js/jqplot/jqplot.categoryAxisRenderer.js"></script>
<script type="text/javascript" src="templates/js/jqplot/jqplot.canvasTextRenderer.js"></script>
<script type="text/javascript" src="templates/js/jqplot/jqplot.labelRenderer.js"></script>
<script type="text/javascript" src="templates/js/jqplot/jqplot.highlighter.js"></script>
<script type="text/javascript" src="templates/js/jqplot/jqplot.cursor.js"></script>
</head>

<body>

<div id="bodyOverride">

<div id="windowWrapper">

  <h1><span class="float2"><a class="responses" href="?p=users&amp;responses=<?php echo $_GET['graph']; ?>" title="<?php echo mswSpecialChars($msg_user25); ?>"><?php echo $msg_user25; ?></a> <a class="userdetails" href="?p=users&amp;view=<?php echo $_GET['graph']; ?>" title="<?php echo mswSpecialChars($msg_user10); ?>"><?php echo $msg_user10; ?></a></span>
  <?php echo $msg_user32; ?> <select onchange="location=this.options[this.selectedIndex].value">
    <option value="?p=users&amp;graph=<?php echo $_GET['graph']; ?>&amp;range=today"><?php echo $msg_home33; ?></option>
    <option value="?p=users&amp;graph=<?php echo $_GET['graph']; ?>&amp;range=week"<?php echo (isset($_GET['range']) && $_GET['range']=='week' ? ' selected="selected"' : ''); ?>><?php echo $msg_home34; ?></option>
    <option value="?p=users&amp;graph=<?php echo $_GET['graph']; ?>&amp;range=month"<?php echo (isset($_GET['range']) && $_GET['range']=='month' ? ' selected="selected"' : ''); ?>><?php echo $msg_home35; ?></option>
    <option value="?p=users&amp;graph=<?php echo $_GET['graph']; ?>&amp;range=year"<?php echo (isset($_GET['range']) && $_GET['range']=='year' ? ' selected="selected"' : ''); ?>><?php echo $msg_home36; ?></option>
  </select> <?php echo $msg_user33.' <span class="highlight_normal">&quot;'.mswSpecialChars($USER->name); ?>&quot;</span>
  </h1>
  
  <div class="userReply">
  <?php
  $uCount = mswRowCount('replies WHERE `replyUser` = \''.$_GET['graph'].'\'');
  if ($uCount>0 && isset($buildGraph[0],$buildGraph[1],$buildGraph[2])) {
  ?>
  <div class="stats">
    <div id="chartgraph"></div>
    <script type="text/javascript">
    //<![CDATA[
    jQuery(document).ready(function() {  
      line1 = [<?php echo $buildGraph[0]; ?>];
      line2 = [<?php echo $buildGraph[1]; ?>];
      ticks = [<?php echo $buildGraph[2]; ?>];
      plot1 = $.jqplot('chartgraph', [line1,line2], {
        grid: {
          borderWidth: 0,
          shadow: false
        },
        axes: {
        yaxis: {
          min: 0,
          tickOptions: {
            formatString: '%d'
          }
        },
        xaxis: { 
          rendererOptions: {
            tickRenderer: $.jqplot.CanvasAxisTickRenderer
          },
          ticks:ticks,
            renderer: $.jqplot.CategoryAxisRenderer
          }
        },
        series: [{
          lineWidth: 1
        },{
          lineWidth: 1
        }],
        legend: {
          show: false
        }
      });
    });
    //]]>
    </script>
    </div>
  <?php
  } else {
  ?>
  <span class="none"><?php echo $msg_user22; ?></span>
  <?php
  }
  ?>
  </div>
  
  <div id="colors">
    <p>
    <span class="ts"><?php echo $msg_home37; ?></span>
    <span class="ds"><?php echo $msg_home38; ?></span>
    </p>
  </div>
  
</div>  

</div>

</body>
</html>
