<?php
if (!defined('INDEX')) exit('No direct script access allowed');

include_once 'php/database.php';

if(isset($_SESSION['userid'])) {
	header("location:index.php");
}

$error = "";
if(isset($_POST['register'])) {
	if(register_user($_POST['user'], $_POST['password'], 
		$_POST['nombre'], $_POST['apellidos'], 
		$_POST['dni'], $_POST['fecha_nacimiento'], 
		$_POST['email'], $_POST['dni'], 0,$result)) {
			if(login($_POST['user'], $_POST['password'], $result)) {
				$_SESSION['userid'] = $result->ID;
			    header("location:index.php");
			}else
			{
				$error =  '<div class="error">Error en el registro.</div>';
			}
	} else
	{
		$error =  '<div class="error">Error en el registro.</div>';
	}
}

$head = '<style>
	#register_contenedor {
		top: 50px;
		position: relative;
	}
form.register {
    background: none repeat scroll 0 0 #F1F1F1;
    border: 1px solid #DDDDDD;
    font-family: sans-serif;
    margin: 0 auto;
    padding: 20px;
	width: 300px;
}
form.register div {
    margin-bottom: 15px;
    overflow: hidden;
}
form.register div label {
    display: block;
    float: left;
    line-height: 25px;
}
form.register div input[type="text"], form.register div input[type="password"], form.register div input[type="date"], form.register div input[type="email"] {
    border: 1px solid #DCDCDC;
    float: right;
    padding: 4px;
}
form.register div input[type="submit"] {
    background: none repeat scroll 0 0 #DEDEDE;
    border: 1px solid #C6C6C6;
    float: right;
    font-weight: bold;
    padding: 4px 20px;
}
</style>';

$contenido = '<div id = "register_contenedor">
<form action="" method="post" class="register">
		<div><label>Login</label><input name="user" type="text" ></div>
		<div><label>Password</label><input name="password" type="password"></div>
		<div><label>Nombre</label><input name="nombre" type="text" ></div>
		<div><label>Apellidos</label><input name="apellidos" type="text" ></div>
		<div><label>DNI</label><input name="dni" type="text" ></div>
		<div><label>Fecha de Nacimiento</label><input name="fecha_nacimiento" type="date" ></div>
		<div><label>E-Mail</label><input name="email" type="email" ></div>
		<div><input name="register" type="submit" value="register"></div>
</form>'
.$error.'
</div>';
$cabecera = '<a href="index.php?page=login" style="float:right; margin-top:12px; margin-right: 12px;">Iniciar Sesión</a>';

?>

