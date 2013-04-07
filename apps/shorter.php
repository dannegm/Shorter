<?php
include_once('../config.php');
include_once('../php/functions.php');
include_once('../class/short.php');

$short = new Short ();

$do = isset($_POST['do']) ? $_POST['do'] : 'not';
if ($do == 'it') {
	$data = $_POST['url'];

	$shorter = $short->shorter($data);
	if ($shorter){
		echo '1:' . $short->uid();
	}else{
		echo '0:' . $short->error();
	}
}
?>