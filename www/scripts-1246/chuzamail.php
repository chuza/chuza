<?php

include('../config.php');
include(mnminclude.'external_post.php');
include_once(mnminclude.'log.php');
include_once(mnminclude.'ban.php');


$s = "SELECT comment_id as max_id, comment_user_id, comment_link_id, comment_date FROM `comments` WHERE comment_date > DATE_SUB(NOW(), INTERVAL 3 DAY)  ORDER BY comment_date";

$r = $db->get_results($s);

$s = "ALTER TABLE chuzamail DROP chm_id";
$r2 = $db->query($s);


foreach($r as $kay=>&$val) {
    $s= "REPLACE INTO chuzamail (chm_comment_id, chm_user_id, chm_link_id, chm_date) VALUES ('".$val->max_id."','".$val->comment_user_id."','".$val->comment_link_id."','".$val->comment_date."');";
    $db->query($s);
    
}

$s = "DELETE FROM chuzamail WHERE chm_date < DATE_SUB(NOW(), INTERVAL 3 DAY)";
$r = $db->query($s);

$s = "ALTER TABLE `chuzamail` ADD `chm_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST ;";
$r = $db->query($s);

$s = "SELECT MAX(chm_comment_id), chm_user_id FROM `chuzamail` WHERE chm_link_id IN (SELECT chm_link_id FROM chuzamail WHERE chm_user_id = 20) GROUP BY chm_link_id HAVING chm_user_id <> 20";


?>

