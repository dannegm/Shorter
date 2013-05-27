<?php

$s = isset($_GET['s']) ? $_GET['s'] : 'not';

if(
	($s == 'not') ||
	($s == null) ||
	($s == '') ||
	(empty($s))
):

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
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-30390599-2', 'dnn.im');
		ga('send', 'pageview');
	</script>
</head>
<body>
	<section id="sidebar">
		<h1><a href="http://dannegm.pro">Dannegm</a></h1>
		<h2>Shorter</h2>

		<form>
			<input id="url" type="url" placeholder="http://" />
			<button class="btn" id="shorter">Shorter</button>

			<span id="elink" class="label label-inverse">
	 			<a id="newLink" target="_blank"></a>
			</span>

			<span id="hasCopy">Se ha copiado al portapapeles</span>
			<span id="exist">Ya existía en nuestra base de datos</span>

			<figure>
				<img id="qr" src="apps/qr.php" />
			</figure>
		</form>

		<p>
			<span>Proyecto desarollodado por <a href="http://github.com/dannegm">@dannegm</a>, no se te olvide seguir el proyecto en github.</span>
			<iframe class="github-btn" src="http://ghbtns.com/github-btn.html?user=dannegm&repo=Shorter&type=fork&count=true&size=large" allowtransparency="true" frameborder="0" scrolling="0" width="260px" height="30px"></iframe>
		</p>
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

	$short->addVisita($s);
	header('location: ' . $url);

	echo "Redireccionando a (" . $s . ")" . $url;

endif;
?>