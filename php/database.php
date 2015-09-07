<?php
if (!defined('INDEX')) exit('No direct script access allowed');
define('DB_SERVER','localhost');
define('DB_NAME','PW');
define('DB_USER','ejercicio_pw');
define('DB_PASS','pass_ejercicio_pw');

class Database {
	private $servername;
	private $username;
	private $password;
	private $conn;
	private $table;
	
	function __construct($servername = DB_SERVER, $table = DB_NAME, $username = DB_USER, $password = DB_PASS)
    {
        $this->servername = $servername;
		$this->username = $username;
		$this->password = $password;
		$this->table = $table;
    }
	
	function connect() {
		$this->conn = mysql_connect($this->servername, $this->username, $this->password)
			or die(die("Connection failed"));
		$selected = mysql_select_db($this->table, $this->conn) 
  			or die(die("Connection failed2"));
	}
	
	function disconnect() {
		mysql_close($this->conn);
	}
	
	function query($exp, &$error = NULL) {
		$result =  mysql_query($exp) or NULL;
		if($result == NULL) $error = mysql_error();
		return $result;
	}
}

$db = new Database();
$db->connect();

function login_user($user,$password, &$result) {
	global $db;
   	$rec = $db->query("SELECT * FROM Usuarios WHERE ID = '$user' and pass = md5('$password')");
    $count = 0;

    while($row = mysql_fetch_object($rec))
    {
        $count++;
        $result = $row;
    }

    if($count == 1)
    {
        return true;
    }
    else
    {
		return false;
    }
}

function register_user($user,$password,$nombre,$apellidos,$dni,$fecha_nacimiento,$email,$dni,$privilegios, &$error = NULL) {
	if($user == $dni) return false;
	global $db;
   	$rec = $db->query("SELECT * FROM Usuarios WHERE ID = '$user'");
    $count = 0;

    while($row = mysql_fetch_object($rec))
    {
        $count++;
        $result = $row;
    }
    if($count > 0) return false;
    $rec = $db->query("INSERT INTO Usuarios (ID, pass, nombre, apellidos, dni, fecha_nacimiento, email, privilegios)
    VALUES ('$user', md5('$password'), '$nombre', '$apellidos', '$dni', '$fecha_nacimiento', '$email', '$privilegios')", $error);
	if($error == NULL) return true;
	return false;
}

function edit_user($user,$old_password, $password,$nombre,$apellidos,$dni,$fecha_nacimiento,$email,$dni,$privilegios, &$error = NULL) {
	if($user == $dni) return false;
	global $db;
	
	$rec = $db->query("SELECT * FROM Usuarios WHERE ID = '$user' and pass = md5('$old_password')");
    $count = 0;

    while($row = mysql_fetch_object($rec))
    {
        $count++;
        $result = $row;
    }

    if($count == 0)
    {
        return false;
    }
    else
    {
		$rec = $db->query("UPDATE Usuarios SET pass = md5('$password'), nombre = '$nombre', apellidos = '$apellidos',
    	dni = '$dni', fecha_nacimiento = '$fecha_nacimiento', email = '$email', privilegios = '$privilegios' WHERE ID = '$user' AND pass = '$old_password'", $error);
		if($error == NULL) return true;
		return false;
    }
}

function delete_user($user, $password, &$error = NULL) {
	
}

function get_cursos(&$error = NULL) {
	global $db;
   	$rec = $db->query("SELECT * FROM Cursos");
    $count = 0;
	$result = array();
    while($row = mysql_fetch_object($rec))
    {
        array_push($result, $row);
    }
	return $result;
}

function get_curso($CursoID, &$error = NULL) {
	global $db;
   	$rec = $db->query("SELECT * FROM Cursos WHERE ID = '$CursoID'");
    $count = 0;
	$result = array();
    while($row = mysql_fetch_object($rec))
    {
        array_push($result, $row);
    }
	return $result;
}

function get_user_cursos($UsuarioID, &$error = NULL) {
	global $db;
   	$rec = $db->query("SELECT CursoID FROM Alumnos WHERE UsuarioID = '$UsuarioID'");
    $count = 0;
	$result = array();
    while($row = mysql_fetch_object($rec))
    {
        array_push($result, $row);
    }
	return $result;
}

function edit_curso($id, $titulo, $descripcion, &$error = NULL) {
	
}

function create_curso($id, $titulo, $descripcion, $profesorID, &$error = NULL) {
	
}

function delete_curso($id, &$error = NULL) {
	
}

function get_ejercicios($CursoID, &$error = NULL) {
	global $db;
   	$rec = $db->query("SELECT * FROM Ejercicios WHERE CursoID = '$CursoID'");
    $count = 0;
	$result = array();
    while($row = mysql_fetch_object($rec))
    {
        array_push($result, $row);
    }
	return $result;
}

function get_ejercicio($EjercicioID, &$error = NULL) {
	global $db;
   	$rec = $db->query("SELECT * FROM Ejercicios WHERE ID = '$EjercicioID'");
    $count = 0;
	$result = array();
    while($row = mysql_fetch_object($rec))
    {
        array_push($result, $row);
    }
	return $result;
}

function create_ejercicio($ID, $CursoID, $titulo, $descripcion, &$error = NULL) {
	
}

function edit_ejercicio($titulo, $descripcion, &$error = NULL) {
	
}

function create_solucion($EjercicioID, $AlumnoID, $file_video, &$error = NULL) {
	global $db;
    $rec = $db->query("INSERT INTO Soluciones (EjercicioID, AlumnoID, file_video)
    VALUES ('$EjercicioID', '$AlumnoID', '$file_video')", $error);
	if($error == NULL) return true;
	return false;
}

function evaluar_solucion($AlumnoID, $SolucionEjercicioID, $SolucionAlumnoID, $calificacion, $lomejor, $lopeor, $observacion, &$error = NULL) {
	global $db;
    $rec = $db->query("INSERT INTO Evaluaciones (AlumnoID, SolucionEjercicioID, SolucionAlumnoID, calificacion, lomejor, lopeor, observacion)
    VALUES ('$AlumnoID', '$SolucionEjercicioID', '$SolucionAlumnoID', '$calificacion', '$lomejor', '$lopeor', '$observacion')", $error);
	if($error == NULL) return true;
	return false;
}

function get_evaluaciones($EjercicioID, $AlumnoID, &$error = NULL) {
	global $db;
   	$rec = $db->query("SELECT * FROM Evaluaciones WHERE SolucionEjercicioID = '$EjercicioID' AND SolucionAlumnoID = '$AlumnoID'");
    $count = 0;
	$result = array();
    while($row = mysql_fetch_object($rec))
    {
        array_push($result, $row);
    }
	return $result;
}

function get_soluciones($EjercicioID, &$error = NULL) {
	global $db;
   	$rec = $db->query("SELECT * FROM Soluciones WHERE EjercicioID = '$EjercicioID'");
    $count = 0;
	$result = array();
    while($row = mysql_fetch_object($rec))
    {
        array_push($result, $row);
    }
	return $result;
}

function alta_curso($AlumnoID, $CursoID, &$error = NULL) {
	global $db;
    $rec = $db->query("INSERT INTO Alumnos (UsuarioID, CursoID)
    VALUES ('$AlumnoID', '$CursoID')", $error);
	if($error == NULL) return true;
	return false;
}

function baja_curso($AlumnoID, $CursoID, &$error = NULL) {
	global $db;
    $rec = $db->query("DELETE FROM Alumnos WHERE UsuarioID = '$AlumnoID' AND CursoID = '$CursoID'", $error);
	if($error == NULL) return true;
	return false;
}

?>