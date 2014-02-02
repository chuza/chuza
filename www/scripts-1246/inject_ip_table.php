<?php

// get ip table from http://software77.net/geo-ip/

include('../config.php');
include(mnminclude.'external_post.php');
include_once(mnminclude.'log.php');
include_once(mnminclude.'ban.php');

include_once(mnminclude.'/predis/Predis.php');
include_once(mnminclude.'/predis/Predis_Compatibility.php');


$redis = new Predis_Client();

$TYPE = 2;

$file = "IpToCountry.csv";

echo "<pre>";

$f = fopen($file, "r");

$iptable = Array();

$k = 0;
while( $csv = fgetcsv($f, 255) ) {
  if ($csv[0][0] != '#') {
    print_r($csv[0].$csv[6]."/n");

    $redis->zadd($globals['enviroment'].'ips', $csv[0], $csv[6].'-'.$k);
    $k++;

  } else {
  }

}

fclose($f);
die;

print_r($iptable[0]);
print_r($iptable[1]);
print_r($iptable[2]);



switch($TYPE) {
  case 1:

    /*
     * Fill ip_countries table
     */
    foreach($iptable as &$val) {
        $db->query("INSERT INTO ip_countries (ipc_short_abrv, ipc_abrv, ipc_name) VALUES ('$val[4]','$val[5]','$val[6]');");
    }


    $s = "SELECT * FROM ip_countries";
    $r = $db->get_results($s);
    print_r($r);

    $countries = Array();
    foreach($r as $val) {
      $q = $val->ipc_abrv;
      $countries[$q] = $val->ipc_id;
    }

    foreach($iptable as $val) {
      $s = "INSERT INTO ip_addresses (ip_start, ip_end, ip_country_id) VALUES ($val[0],$val[1],".$countries[$val[5]].")";
      $db->query($s);

    }

    echo count($iptable);

    break;

  case 2:
    /*
     * Use redis
     */


    //$redis = new 'redisent\Redis'('localhost');

    break;


}



