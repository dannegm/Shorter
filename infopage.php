<?php
	include_once('php/functions.php');

	$s = isset($_GET['s']) ? $_GET['s'] : 'not';
	$page = get_page_info($s);

	echo '<pre>' . "\n";
	echo $page['title'] . "\n";
	echo $page['content'][0];
	
	echo '</pre>' . "\n";
?>