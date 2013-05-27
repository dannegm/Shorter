<?php
// Generar Key
function genKey (){
	$rCh = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	$key = "";
	for ( $i = 0; $i < 5; $i++ ){
		$key .= $rCh{ rand(0,61) };
	}
	return $key;
}
function validate_url($url) {
    return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}
function long_text($txt, $long){
	if ( strlen($txt) > $long ){
		return false;
	}else{
		return true;
	}
}

function black_list_filter ($url) {
	$domain = explode('/', $url);

	if ( isset($domain[2]) ){
		$domain = $domain[2];
		$black_list = Array(
			'redtube.com',
			'xvideos.com',
			'pornhub.com',
			'poringa.com',
			'dnn.im'
		);
		if ( in_array($domain, $black_list) ){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}

function validate_site_exist ($url) {
	$fp = @fopen($url, "r");
	if( $fp ){
		return true;
	}else{
		return false;
	}
	@fclose($fp);
}

// Poner texto a los meses
function format_mes($mess){
	switch($mess){
		case '01': $mess = 'Enero'; break;
		case '02': $mess = 'Febrero'; break;
		case '03': $mess = 'Marzo'; break;
		case '04': $mess = 'Abril'; break;
		case '05': $mess = 'Mayo'; break;
		case '06': $mess = 'Junio'; break;
		case '07': $mess = 'Julio'; break;
		case '08': $mess = 'Agosto'; break;
		case '09': $mess = 'Septiembre'; break;
		case '10': $mess = 'Octubre'; break;
		case '11': $mess = 'Noviembre'; break;
		case '12': $mess = 'Diciembre'; break;
	}
	return $mess;
}

function format_date ( $_da ){
	$_mess = "";
	$_da = explode('-', $_da);
	$_dia = $_da[0];
	$_mes = $_da[1];
	$_ani = $_da[2];

	$_mess = format_mes($_mes);
	$res = $_dia . ' de ' . $_mess . ' del ' . $_ani;
	return $res;
}

// Poner texto a los dias de la semana
function set_day_text ( $day ){
	switch( $day ){
		case 0: $day = "Domingo"; break;
		case 1: $day = "Lunes"; break;
		case 2: $day = "Martes"; break;
		case 3: $day = "Miercoles"; break;
		case 4: $day = "Jueves"; break;
		case 5: $day = "Viernes"; break;
		case 6: $day = "Sabado"; break;
	}
	return $day;
}

function _httpget ($url){
	$_getStrings = explode('?', $url);
	$getStrings = $_getStrings[1];
	if ($getStrings) {
		$getKeys = explode('&', $getStrings);
		$get = array();

		for($i = 0; $i < count($getKeys); $i++){
			$tmp = explode('=', $getKeys[$i]);
			$get[$tmp[0]] = $tmp[1];
		}
		return $get;
	}else{
		return false;
	}
}
?>