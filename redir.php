<?php
$s = isset($_GET['s']) ? $_GET['s'] : 'not';
if(
	($s == 'not') ||
	($s == null) ||
	($s == '') ||
	(empty($s))
){
	header('location: http://dnn.im');
}else{
	include_once('config.php');
	include_once('php/functions.php');
	include_once('class/short.php');

	$short = new Short ();
	$url = $short->getUrl($s);

	if($url == ''){
		header('location: http://dnn.im');
	}

	$short->addVisita($s);
	header('User-Agent: DannegmBot/Alpha 1.0')
	header('location: ' . $url);
}
?>