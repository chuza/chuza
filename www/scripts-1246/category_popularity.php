<?
include('../config.php');
include(mnminclude.'external_post.php');
include_once(mnminclude.'log.php');
include_once(mnminclude.'ban.php');

define('DEBUG', false);

header("Content-Type: text/html");
echo '<html><head><title>Category Popularity</title></head><body>';
ob_end_flush();


$s = "SELECT link_category, SUM( link_votes ) + SUM( link_comments ) AS s
  FROM `links`
  JOIN `categories` ON links.link_category = categories.category_id
  WHERE link_sent_date >= DATE_SUB( NOW() , INTERVAL 6 DAY )
  GROUP BY link_category";
$popular = $db->get_results($s);
$p = array();
foreach($popular as $kay => $val) {
  $p[$val->link_category] = $val->s;
}

$s = "SELECT * FROM categories";
$cats = $db->get_results($s);
$c = 0;
foreach($cats as $cat) {
  if ($p[$cat->category_id])  
    $v = $p[$cat->category_id];
  else
    $v = 0;

  $s = "UPDATE categories SET category_popularity = ".(int)$v." WHERE category_id = ".(int)$cat->category_id;
  echo $s."<br>";
  $db->get_var($s); 
  $c++;
}

echo $c." categories updated.";



