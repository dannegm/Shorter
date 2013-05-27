<?php
$url = isset($_GET['url']) ? $_GET['url'] : 'http://dannegm.pro';
$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, 'DannegmBot/Alpha 1.0');
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$resp = curl_exec($ch);
	$site = explode("\n\r\n", $resp);
	$headers = $site[0];
	$body = $site[1];

curl_close($ch);

$headers_array = explode("\n", $headers);
	$http_code = $headers_array[0];

echo '<pre>' . "\n";
echo 'Hedaers de ' . $url . "\n";
echo '-----------------------------------------------------------------' . "\n";
echo $headers . "\n";

if ( preg_match('/OK/i', $http_code) ) {
	echo "\n\n"	. 'La pagina existe';
}else{
	echo $http_code;
}

echo '</pre>';
?>