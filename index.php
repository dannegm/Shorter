<?php

$s = isset($_GET['s']) ? $_GET['s'] : 'not';

if($s == 'not'):

?>
<!doctype html>
<!-- [ Power By Dannegm (c) 2012 - http://dannegm.com ] -->
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Dannegm Shorter</title>

	<link rel="stylesheet/less" href="less/default.less" />

	<script src="js/jquery.min.js"></script>
	<script src="js/less.min.js"></script>
	<script src="js/script.js"></script>
</head>
<body>
	<section id="sidebar">
		<h1>Dannegm</h1>
		<h2>Shorter</h2>

		<form>
			<input id="url" type="url" placeholder="http://" />
			<button class="btn" id="shorter">Shorter</button>

			<span id="elink" class="label label-inverse">
	 			<a id="newLink" target="_blank"></a>
			</span>
		</form>
	</section>

	<section id="container">
		<table>
			<thead>
				<tr>
					<th>#</th>
					<th>Url corta</th>
					<th>Url real</th>
				</tr>
			</thead>
			<tbody id="lister"></tbody>
		</table>
	</section>
</body>
</html>

<?php
else:
	include_once('config.php');
	include_once('php/functions.php');
	include_once('class/short.php');

	$short = new Short ();
	$url = $short->getUrl($s);

	if($s == ''){
		header('location: ..');
	}

	header('location: ' . $url);

	echo "Redireccionando a " . $url;

endif;
?>