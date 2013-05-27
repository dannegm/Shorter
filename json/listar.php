<?php
include_once('../config.php');
include_once('../php/functions.php');
include_once('../class/short.php');

$step = isset($_GET['step']) ? $_GET['step'] : '1';
$short = new Short ();

$json = $short->listar($step);
$json = json_encode($json);

header('Content-type: text/javascript');

echo $json;

?>