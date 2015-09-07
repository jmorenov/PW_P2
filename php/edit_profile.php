<?php
if (!defined('INDEX')) exit('No direct script access allowed');

include_once 'php/database.php';

if(!isset($_SESSION['userid'])) {
	header("location:index.php");
}

$error = "";
if(isset($_POST['edit'])) {
	if($_POST['old_password'] != NULL && $_POST['password'] != NULL &&
	edit_user($_SESSION['userid'], $_POST['old_password'], $_POST['password'], 
		$_POST['nombre'], $_POST['apellidos'], 
		$_POST['dni'], $_POST['fecha_nacimiento'], 
		$_POST['email'], $_POST['dni'], 0,$result)) {
			$_SESSION['nombre'] = $result->nombre;
			$_SESSION['apellidos'] = $result->apellidos;
			$_SESSION['dni'] = $result->dni;
			$_SESSION['fecha_nacimiento'] = $result->fecha_nacimiento;
			$_SESSION['email'] = $result->email;
			header("location:index.php?page=edit_profile");
	} else
	{
		$error =  '<div class="error">Error al guardar datos.</div>';
	}
}

$head = '<style>
	#edit_contenedor {
		top: 50px;
		position: relative;
	}
form.edit {
    background: none repeat scroll 0 0 #F1F1F1;
    border: 1px solid #DDDDDD;
    font-family: sans-serif;
    margin: 0 auto;
    padding: 20px;
	width: 300px;
}
form.edit div {
    margin-bottom: 15px;
    overflow: hidden;
}
form.edit div label {
    display: block;
    float: left;
    line-height: 25px;
}
form.edit div input[type="text"], form.edit div input[type="password"], form.edit div input[type="date"], form.edit div input[type="email"] {
    border: 1px solid #DCDCDC;
    float: right;
    padding: 4px;
}
form.edit div input[type="submit"] {
    background: none repeat scroll 0 0 #DEDEDE;
    border: 1px solid #C6C6C6;
    float: right;
    font-weight: bold;
    padding: 4px 20px;
}
</style>';

$contenido = '<div id = "edit_contenedor">
<form action="" method="post" class="edit">
		<div><label>Antigua Password</label><input name="old_password" type="password"></div>
		<div><label>Nueva Password</label><input name="password" type="password"></div>
		<div><label>Nombre</label><input name="nombre" type="text" value="'.$_SESSION['nombre'].'"></div>
		<div><label>Apellidos</label><input name="apellidos" type="text" value="'.$_SESSION['apellidos'].'"></div>
		<div><label>DNI</label><input name="dni" type="text" value="'.$_SESSION['dni'].'"></div>
		<div><label>Fecha de Nacimiento</label><input name="fecha_nacimiento" type="date" value="'.$_SESSION['fecha_nacimiento'].'"></div>
		<div><label>E-Mail</label><input name="email" type="email" value="'.$_SESSION['email'].'"></div>
		<div><input name="edit" type="submit" value="Guardar"></div>
</form>'
.$error.'
</div>';

?>

