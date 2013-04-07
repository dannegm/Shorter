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

	<link rel="stylesheet" href="css/bootstrap.css" />
	<link rel="stylesheet/less" href="less/default.less" />

	<script src="js/jquery.min.js"></script>
	<script src="js/less.min.js"></script>
	<script src="js/script.js"></script>
</head>
<body>
	<div class="container">
		<div class="header">
			<h1>
				<img src="img/logo.png" />
				<span>Dannegm Shorter</h1>
			</h1>
			<form>
				<div class="input-append">
					<input class="span4" id="url" type="url" placeholder="http://" />
					<button class="btn btn-large" id="shorter">Shorter!!</button>
				</div>
			</form>
			<div class="innerCenter">
				<span id="elink" class="label label-inverse">
		 			<a id="newLink" target="_blank"></a>
				</span>
			</div>
		</div>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Url corta</th>
					<th>Url real</th>
				</tr>
			</thead>
			<tbody id="lister"></tbody>
		</table>
		<div class="pagination pagination-large">
			<ul>
				<li class="previous">
					<a href="#" id="back">&larr;</a>
				</li>
				<li class="next">
					<a href="#" id="next">&rarr;</a>
				</li>
			</ul>
		</div>
	</div>
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