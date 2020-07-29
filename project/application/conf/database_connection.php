<?php

class DatabaseConnection
{
	function readFile() {
		try {
			$path = __DIR__.'/config.json';
			$file = file_get_contents($path);
			$iterator = new RecursiveIteratorIterator(
			    new RecursiveArrayIterator(json_decode($file, TRUE)),
			    RecursiveIteratorIterator::SELF_FIRST);
			$arrConf = array();

			foreach ($iterator as $key => $val) {
			    if(!is_array($val)) {
			        $arrConf[$key] = $val;
			    }
			}
		} catch (Exception $e) {
			echo 'Ocurrió un error leyendo el archivo de configuración. ' . $e->getMessage();
		}

		return $arrConf;
	}

	public function connect() {
		try {
			$arrConf = $this->readFile();
			$host = $arrConf["host"];
			$user = $arrConf["user"];
			$password = $arrConf["password"];
			$database = $arrConf["database"];

			$connection = mysqli_connect($host, $user, $password, $database);

			if ( mysqli_connect_errno() ) {
				exit('Failed to connect to MySQL: ' . mysqli_connect_error());
			}
		} catch (Exception $e) {
			echo 'Ocurrió un error y no pudo conectar a la base de datos. ' . $e->getMessage();
		}

		return $connection;
	}

	public function listadoUsuarios() {
		$usuario = $_SESSION['name'];

		try {
			$connect = $this->connect();
			$sql = 'SELECT id, usuario FROM usuarios WHERE usuario != ? AND email != ?';
			$result = $connect->prepare($sql);
			$result->bind_param("ss", $usuario, $usuario);
			$result->execute();
			$result = $result->get_result();
		} catch (Exception $e) {
			echo 'Ocurrió un error obteniendo el listado de usuarios. ' . $e->getMessage();
		}

		return $result;
	}

	public function datosUsuarioLogueado($usuario) {
		$datos = array();

		try {
			$connect = $this->connect();
			$sql = 'SELECT usuario, email FROM usuarios WHERE usuario = ? OR email = ?';
			$result = $connect->prepare($sql);
			$result->bind_param("ss", $usuario, $usuario);
			$result->execute();
			$result->bind_result($datos['usuario'], $datos['email']);
			$result->fetch();
			$result->close();
		} catch (Exception $e) {
			echo 'Ocurrió un error obteniendo los datos del usuario. ' . $e->getMessage();
		}

		return $datos;
	}

	public function registrarUsuario($data) {
		$respuesta = array();

		try {
			$connect = $this->connect();
			$usuario = $data['usuario'];
			$pass = $data['password'];
			$email = $data['email'];
			$sql = 'SELECT id, password FROM usuarios WHERE usuario = ? or email = ?';
			$result = $connect->prepare($sql);
			$result->bind_param('ss', $usuario, $email);
			$result->execute();
			$result->store_result();

			if ($result->num_rows > 0) {
				$respuesta['estatus'] = 2;
				$respuesta['mensaje'] = 'El nombre de usuario ya existe o el correo ya esta registrado!';
			} else {
				$sql = 'INSERT INTO usuarios (usuario, password, email) VALUES (?, ?, ?)';
				$insert = $connect->prepare($sql);

				if ($insert) {
					$password = password_hash($pass, PASSWORD_DEFAULT);
					$insert->bind_param('sss', $usuario, $password, $email);
					$insert->execute();
				}

				$respuesta['estatus'] = 1;
				$respuesta['mensaje'] = 'Usuario registrado exitosamente!';
			}

			$result->close();

			$connect->close();
		} catch (Exception $e) {
			echo 'Ocurrió un error registrando los datos del usuario. ' . $e->getMessage();
		}

		return $respuesta;
	}

	public function login($data) {
		session_start();
		$respuesta = array();

		try {
			$connect = $this->connect();
			$usuario = $data['usuario'];
			$pass = $data['password'];
			$sql = 'SELECT id, password FROM usuarios WHERE usuario = ? OR email = ?';
			$result = $connect->prepare($sql);
			$result->bind_param('ss', $usuario, $usuario);
			$result->execute();
			$result->store_result();

			if ($result->num_rows > 0) {
				$result->bind_result($id, $password);
				$result->fetch();

				if (password_verify($pass, $password)) {
					session_regenerate_id();
					$_SESSION['loggedin'] = TRUE;
					$_SESSION['name'] = $usuario;
					$_SESSION['id'] = $id;
					$respuesta['estatus'] = 1;
					$respuesta['mensaje'] = 'inicio.php';
				} else {
					$respuesta['estatus'] = 2;
					$respuesta['mensaje'] = 'Contraseña incorrecta';
				}
			} else {
				$respuesta['estatus'] = 2;
				$respuesta['mensaje'] = 'Usuario o correo incorrecto';
			}

			$result->close();
		} catch (Exception $e) {
			echo 'Ocurrió un error ingresando al sistema. ' . $e->getMessage();
		}

		return $respuesta;
	}

	public function datosUsuarioModificar($idUsuario) {
		$respuesta = array();

		try {
			$connect = $this->connect();
			$sql = 'SELECT usuario, email FROM usuarios WHERE id = ?';
			$result = $connect->prepare($sql);
			$result->bind_param("i", $idUsuario);
			$result->execute();
			$result->store_result();
			$result->bind_result($respuesta['usuario'], $respuesta['email']);
			$result->fetch();
		} catch (Exception $e) {
			echo 'Ocurrió un error obteniendo los datos del usuario. ' . $e->getMessage();
		}

		return $respuesta;
	}

	public function modificarUsuario($data) {
		$respuesta = array();

		try{
			$connect = $this->connect();
			$idUsuario = $data['idUsuario'];
			$usuario = $data['usuario'];
			$pass = $data['password'];
			$email = $data['email'];
			$sql = 'SELECT id FROM usuarios WHERE usuario = ? OR email = ?';
			$result = $connect->prepare($sql);
			$result->bind_param('ss', $usuario, $usuario);
			$result->execute();
			$result->store_result();

			if ($result->num_rows > 0) {
				$result->bind_result($id);
				$result->fetch();
			}

			if (isset($id) && $id != $idUsuario) {
				$respuesta['estatus'] = 2;
				$respuesta['mensaje'] = "El usuario ya existe o el correo ya están registrados";
			}else if (!empty($pass)) {
				$sql = 'UPDATE usuarios SET usuario = ?, password = ?, email = ? WHERE id = ?';
				$result = $connect->prepare($sql);
				$password = password_hash($pass, PASSWORD_DEFAULT);
				$result->bind_param('sssi', $usuario, $password, $email, $idUsuario);
				$respuesta['estatus'] = 1;
				$respuesta['mensaje'] = "Datos modificados exitosamente";
			} else {
				$sql = 'UPDATE usuarios SET usuario = ?, email = ? WHERE id = ?';
				$result = $connect->prepare($sql);
				$result->bind_param('ssi', $usuario, $email, $idUsuario);
				$respuesta['estatus'] = 1;
				$respuesta['mensaje'] = "Datos modificados exitosamente";
			}

			if ($result) {
				$result->execute();
				$result->close();
			}

			$connect->close();
		} catch (Exception $e) {
			echo 'Ocurrió un error modificando los datos del usuario. ' . $e->getMessage();
		}

		return $respuesta;
	}

	public function eliminarUsuario($id) {
		$respuesta = array();

			try {
			$connect = $this->connect();
			$sql = "DELETE FROM usuarios WHERE id = $id";
			$result = $connect->query($sql);

			if ($result) {
				$respuesta['estatus'] = 1;
				$respuesta['mensaje'] = 'Usuario eliminado!';
			} else {
				$respuesta['estatus'] = 2;
				$respuesta['mensaje'] = 'Ocurrió un error al eliminar el usuario!';
			}

			$connect->close();
		} catch (Exception $e) {
			echo 'Ocurrió un error eliminando los datos del usuario. ' . $e->getMessage();
		}

		return $respuesta;
	}

	public function paginado() {
		$usuario = $_SESSION['name'];
		$datos = array();

		try {
			$connect = $this->connect();
			$sql = 'SELECT id, usuario FROM usuarios WHERE usuario != ? AND email != ?';
			$resp = $connect->prepare($sql);
			$resp->bind_param("ss", $usuario, $usuario);
			$resp->execute();
			$totalPages = $resp->get_result()->num_rows;
			$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
			$num_results_on_page = 10;
			$query = 'SELECT * FROM usuarios WHERE usuario != ? AND email != ? ORDER BY usuario LIMIT ?,?';
			$stmt = $connect->prepare($query);
			$calc_page = ($page - 1) * $num_results_on_page;
			$stmt->bind_param('ssii', $usuario, $usuario, $calc_page, $num_results_on_page);
			$stmt->execute(); 
			$result = $stmt->get_result();
			$datos['total_pages'] = $totalPages;
			$datos['num_results_on_page'] = $num_results_on_page;
			$datos['page'] = $page;
			$datos['result'] = $result;
		} catch (Exception $e) {
			echo 'Ocurrió un error obteniendo los datos. ' . $e->getMessage();
		}

		return $datos;
	}
}