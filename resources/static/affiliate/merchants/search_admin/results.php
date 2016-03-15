<?php
/*
Christian Lavender
*/

$relative_script_path = '.';
$no_connect = 0;

if (is_file("$relative_script_path/includes/config.php")) {
    include "$relative_script_path/includes/config.php";
}
else {
    die("Cannot find config.php file.\n");
}

if (is_file("$relative_script_path/libs/search_function.php")) {
    include "$relative_script_path/libs/search_function.php";
}
else {
   die("Cannot find search_function.php file.\n");
}

// extract vars
extract(phpdigHttpVars(
     array('query_string'=>'string',
           'refine'=>'integer',
           'refine_url'=>'string',
           'site'=>'string', // set to integer later
           'limite'=>'integer',
           'option'=>'string',
           'lim_start'=>'integer',
           'browse'=>'integer',
           'path'=>'string'
           )
     ),EXTR_SKIP);

if (ALLOW_RSS_FEED) {
  $adlog_flag = 1;
  $rssout = phpdigSearch($id_connect, $query_string, $option, $refine,
              $refine_url, $lim_start, $limite, $browse,
              $site, $path, $relative_script_path, 'array', $adlog_flag, '', $template_demo);
  if (is_file("custom_rss.php")) {
    include "custom_rss.php";
    $rssdf = $thedir."/".$thefile;
  }
  else {
    die("Cannot find custom_rss.php file.\n");
  }
}
else {
  $adlog_flag = 0;
  $rssdf = "";
}

if ($template == "array") {
  $arrayout = phpdigSearch($id_connect, $query_string, $option, $refine,
              $refine_url, $lim_start, $limite, $browse,
              $site, $path, $relative_script_path, $template, $adlog_flag, $rssdf, $template_demo);
  if (is_file("custom_search.php")) {
    include "custom_search.php";
  }
  else {
    die("Cannot find custom_search.php file.\n");
  }
}
else {
  phpdigSearch($id_connect, $query_string, $option, $refine,
              $refine_url, $lim_start, $limite, $browse,
              $site, $path, $relative_script_path, $template, $adlog_flag, $rssdf, $template_demo);
}

?>
