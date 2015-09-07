<?php
class Usuario {
	public $id;
	public $nombre;
	public $apellidos;
	public $dni;
	public $fecha_nacimiento;
	public $email;
	public $privilegios;
	
	function create($id, $email, $nombre, $apellidos, $dni, $fecha_nacimiento, $password) {
		
	}
	
	function edit($id = "", $nombre = "", $apellidos = "", $dni = "", $fecha_nacimiento = "", $email = "") {
		
	}
	
	function load($id, $password) {
		
	}
	
	function delete($id, $password) {}
}

/*class Administrador extends Usuario {
	function crearUsuario()
}

class Profesor extends Usuario {
	
}

class Alumno extends Usuario {
	
}*/

?>