<?php
include_once('../php/phpqrcode/qrlib.php');

$s = isset($_GET['s']) ? $_GET['s'] : 'http://dnn.im';
QRcode::png($s, false, 'H', 5, 2);

?>