<?php
class Short
{
	private $_uid;

	private $_db_server = db_server;
	private $_db_user = db_user;
	private $_db_pass = db_password;
	private $_db_bdata = db_bdata;
	private $_tb_short = tb_short;

	private $_mysqli;
	private $_error = "No hay error";

	public function __construct (){
		$mysqli = new mysqli($this->_db_server, $this->_db_user, $this->_db_pass, $this->_db_bdata);
		if ( mysqli_connect_errno ()) {
			$this->_error = "No se pudo conectar con la base de datos";
			return false;
		}else{
			$this->_mysqli = $mysqli;
			return true;
		}
	}

	// Getter

	public function uid (){
		return $this->_uid;
	}

	public function getUrl($uid){
		return $this->consult('url', $uid);
	}

	public function error (){
		return $this->_error;
	}

	public function consult ($what, $who) {
		$query = "SELECT `{$what}` FROM `{$this->_tb_short}` WHERE `uid` = '{$who}'";
		$conexion = $this->_mysqli;
		if ($get_data = $conexion->query($query)){
			while($result = $get_data->fetch_assoc()){
				return $result[$what];
			}
		}
	}

	public function listar ($step) {
		$conexion = $this->_mysqli;

		$step = $step -1;
		$offset = $step * 10;

		$query = "SELECT * FROM `{$this->_tb_short}` ORDER BY `id` DESC LIMIT {$offset},10";

		$conexion = $this->_mysqli;
		if ($get_data = $conexion->query($query)){
			$res = Array();
			while($result = $get_data->fetch_assoc()){
				$res[] = Array(
					'index' => $result['id'],
					'id' => $result['uid'],
					'url' => $result['url'],
					'date' => $result['date']
				);
			}
			return $res;
		}
	}

	// Functions

	public function shorter ($data){
		$conexion = $this->_mysqli;

		$uid = genKey();
			$this->_uid = $uid;

		$url = $data;

		date_default_timezone_set("America/Mexico_City");
			$date = date("w j-m-Y g:i:s:a");

		$query = "INSERT INTO `{$this->_tb_short}` (`uid`, `url`, `date`)"
			. "VALUES (?, ?, ?)"
		;
		$ins = $conexion->prepare($query);
		$ins->bind_param( 'sss', $uid, $url, $date );
		$insert = $ins->execute();

		if ( !$insert ) {
			$this->_error = "No se crear url corta";
			return false;
		}else{
			return true;
		}
	}

	private function _update ($who, $what, $newVal){
		$conexion = $this->_mysqli;
		$query = "UPDATE `{$this->_tb_short}` SET `{$what}` = ? WHERE `uid` = '{$who}'";
		$up = $conexion->prepare($query);
		$up->bind_param ( 's', $newVal );
		$upd = $up->execute();
		if ( !$upd ) {
			$this->_error = "No se pudo actualizar";
			return false;
		}else{
			return true;
		}
	}

	public function close (){
		$conexion = $this->_mysqli;
		$conexion->close();
	}
}