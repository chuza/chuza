<?php

include('../config.php');
include(mnminclude.'external_post.php');
include_once(mnminclude.'log.php');
include_once(mnminclude.'ban.php');

$s = "SELECT * FROM `links` WHERE link_status = 'abuse' ORDER BY link_date LIMIT 100";
$r = $db->get_results($s);

echo "<pre>";
print_r($r);

$s = "DELETE FROM `links` WHERE link_status = 'abuse' ORDER BY link_date LIMIT 100";
$r = $db->query($s);


$s = "SELECT *
FROM `comments`
LEFT JOIN links ON comment_link_id = link_id
WHERE link_id IS NULL
LIMIT 30";
$r = $db->get_results($s);

print_r($r);

$s = "DELETE comments
FROM `comments`
LEFT JOIN links ON comment_link_id = link_id
WHERE link_id IS NULL ";

$r = $db->query($s);


$s = "DELETE FROM `posts` WHERE post_karma < 0";
$r = $db->query($s);

$s = "DELETE users FROM users LEFT JOIN links ON user_id = link_author LEFT JOIN comments ON user_id = comment_user_id LEFT JOIN posts ON user_id = post_user_id 
WHERE link_author IS NULL
AND comment_user_id IS NULL
AND post_user_id IS NULL
AND user_modification < DATE_SUB(NOW(), INTERVAL 2 YEAR)
AND user_avatar = 0";
$r = $db->query($s);

echo "Fin do script";

