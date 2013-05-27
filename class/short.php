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
		return $this->_consult('url', $uid);
	}

	public function error (){
		return $this->_error;
	}

	private function _consult ($what, $who) {
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
		$offset = $step * 20;

		$query = "SELECT * FROM `{$this->_tb_short}` ORDER BY `id` DESC LIMIT {$offset},20";

		$conexion = $this->_mysqli;
		if ($get_data = $conexion->query($query)){
			$res = Array();
			while($result = $get_data->fetch_assoc()){
				$res[] = Array(
					'index' => $result['id'],
					'id' => $result['uid'],
					'url' => $result['url'],
					'date' => $result['date'],
					'views' => $result['visitas']
				);
			}
			return $res;
		}
	}



	private function _giveMeUID () {
		$uid = genKey();
		$existe = $this->_exist($uid);
		if ($existe){
			$this->_giveMeUID();
		}else{
			return $uid;
		}
	}

	// Functions

	public function shorter ($data){

				$f_cero = long_text($data, 256);
				if ($f_cero){

					$f_uno = validate_url($data);
					if($f_uno){

						$f_dos = validate_site_exist($data);
						if ($f_dos){

							$f_tres = black_list_filter($data);
							if ( !$f_tres ){

								$f_cuatro = $this->_exist_url($data);
								if ( !$f_cuatro ) {
									$conexion = $this->_mysqli;

									$uid = $this->_giveMeUID();
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
										$this->_error = "No se pudo crear url corta";
										return false;
									}else{
										return true;
									}
								}else{
									$this->_error = "url_exist";
									return false;
								}
							}else{
								$this->_error = "Esta url no está permitida";
								return false;
							}
						}else{
							$this->_error = "El sitio no existe";
							return false;
						}
					}else{
						$this->_error = "No es una url válida";
						return false;
					}
				}else{
					$this->_error = "El texto es demasiado grande";
					return false;
				}
			//}
		//}
	}

	private function _exist ($who){
		$conexion = $this->_mysqli;
		$sql = "SELECT * FROM `{$this->_tb_short}` WHERE `uid` = '{$who}'";
		$conexion->query($sql);
		$n = $conexion->affected_rows;
		if ($n > 1) {
			return true;
		}else{
			return false;
		}
	}

	private function _exist_url ($who){
		$conexion = $this->_mysqli;
		$sql = "SELECT * FROM `{$this->_tb_short}` WHERE `url` = '{$who}'";
		$conexion->query($sql);
		$n = $conexion->affected_rows;
		$n++;
		if ($n > 1) {
			return true;
		}else{
			return false;
		}
	}

	public function find_url ($who){
		$query = "SELECT * FROM `{$this->_tb_short}` WHERE `url` = '{$who}'";
		$conexion = $this->_mysqli;
		if ($get_data = $conexion->query($query)){
			while($result = $get_data->fetch_assoc()){
				return $result['uid'];
			}
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

	public function addVisita ($who) {
		$actuales = $this->_consult('visitas', $who);
		$nueva = $actuales + 1;
		$this->_update($who, 'visitas', $nueva);
	}

	public function close (){
		$conexion = $this->_mysqli;
		$conexion->close();
	}
}