<?php
if (!defined('INDEX')) exit('No direct script access allowed');

include_once 'php/database.php';

if(isset($_SESSION['userid'])) {
	header("location:index.php");
}

$error = "";
if(isset($_POST['login'])) {
	if(login_user($_POST['user'], $_POST['password'], $result)) {
		$_SESSION['userid'] = $result->ID;
		$_SESSION['nombre'] = $result->nombre;
		$_SESSION['apellidos'] = $result->apellidos;
		$_SESSION['dni'] = $result->dni;
		$_SESSION['fecha_nacimiento'] = $result->fecha_nacimiento;
		$_SESSION['email'] = $result->email;
	    header("location:index.php");
	} else
	{
		$error =  '<div class="error">Su usuario es incorrecto, intente nuevamente.</div>';
	}
}

$head = '<style>
	#login_contenedor {
		top: 50px;
		position: relative;
	}
form.login {
    background: none repeat scroll 0 0 #F1F1F1;
    border: 1px solid #DDDDDD;
    font-family: sans-serif;
    margin: 0 auto;
    padding: 20px;
	width: 278px;
}
form.login div {
    margin-bottom: 15px;
    overflow: hidden;
}
form.login div label {
    display: block;
    float: left;
    line-height: 25px;
}
form.login div input[type="text"], form.login div input[type="password"] {
    border: 1px solid #DCDCDC;
    float: right;
    padding: 4px;
}
form.login div input[type="submit"] {
    background: none repeat scroll 0 0 #DEDEDE;
    border: 1px solid #C6C6C6;
    float: right;
    font-weight: bold;
    padding: 4px 20px;
}
</style>';

$contenido = '<div id = "login_contenedor">
<form action="" method="post" class="login">
		<div><label>Login</label><input name="user" type="text" ></div>
		<div><label>Password</label><input name="password" type="password"></div>
		<div><input name="login" type="submit" value="login"></div>
</form>'
.$error.'
</div>';

$cabecera = '<a href="index.php?page=register" style="float:right; margin-top:12px; margin-right: 12px;">Registrarse</a>';

?>

