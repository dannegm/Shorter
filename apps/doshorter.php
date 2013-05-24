<?php
include_once('../config.php');
include_once('../php/functions.php');
include_once('../class/short.php');

$short = new Short ();

$url = isset($_GET['url']) ? $_GET['url'] : 'not';
if ($url != 'not') {

	$shorter = $short->shorter($url);

	header('Content-type: text/javascript');
	if ($shorter){
		echo '{"result": 1, "uid": "' . $short->uid() . '", "url": "' . $url . '"}';
	}else{
		echo '{"result": 0, "error": "' . $short->error() . '"}';
	}
}
?>