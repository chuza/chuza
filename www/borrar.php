<?php

$homepage = file_get_contents('./css/es/mnm65.css');
$temp = explode("#", $homepage);
foreach ($temp as &$value) {
	$cod = explode(";", $value);
	$cod = $cod[0];
	if (!eregi(" ", $cod)){
		if (!eregi(":", $cod)){
			$color[$cod] = $cod;
		}
	}
}


echo "<pre>";
print_r($color);
echo "</pre>";




?>