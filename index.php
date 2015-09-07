<?php
	define('INDEX', rand());
	session_start();
	$cabecera = '<span style="float:left;margin-top:12px; margin-left: 12px;">Bienvenido '.$_SESSION['userid'].'.</span>
			<a href="index.php?page=logout" style="float:right; margin-top:12px; margin-right: 12px;">Logout</a>&nbsp;
			<a href="index.php?page=edit_profile" style="float:right; margin-top:12px; margin-right: 12px;">Editar perfil</a>';
	$menulateral = '<a href="index.php">Inicio</a></br>
	<a href="index.php?page=cursos">Cursos</a></br>
	<a href="index.php?page=miscursos">Mis Cursos</a>
	';
	$pie = '';
	if(isset($_GET['page'])) {
		switch($_GET['page']) {
			case "register": 
				include_once "php/register.php";
			break;
			case "logout":
				include_once "php/logout.php";
			break;
			case "edit_profile":
				include_once "php/edit_profile.php";
			break;
			case "cursos":
				include_once "php/cursos.php";
			break;
			case "miscursos":
				include_once "php/miscursos.php";
			break;
			case "curso":
				include_once "php/curso.php";
			break;
			case "ejercicio":
				include_once "php/ejercicio.php";
			break;
			case "solucion":
				include_once "php/solucion.php";
			break;
			default:
				include_once 'php/login.php';
			break;
		}
	}
	else {
		include_once "php/cursos.php";
	}
?>	

<head>
<style type="text/css">
	body {
		margin: 0;
		font-size: 14px;
	}
	#contenido {
		top:54px;
		bottom:54px;
		left:204px;
		right: 0;
		position: absolute;
	}
	#cabecera {
		background-color: green;
		height: 50px;
		top:0;
		right:0;
		left:0;
		position: absolute;
		border:2px solid black;
	}
	#pie {
		background-color: green;
		height: 50px;
		bottom:0;
		right:0;
		left:0;
		position: absolute;
		border:2px solid black;
	}
	#menulateral {
		background-color: green;
		width: 200px;
		top:52px;
		bottom:52px;
		left:0;
		position: absolute;
		border:2px solid black;
	}
	#menulateral a {
		margin-left: 10px;
		margin-top: 10px;
		font-size: 20px;
	}
	.error {
	    color: red;
	    font-weight: bold;
	    margin: 10px;
	    text-align: center;
	}
</style>
<?php echo $head; ?>
</head>
<body>
	<div id = "cabecera">
		<?php echo $cabecera; ?>
	</div>
	<div id = "menulateral">
		<?php echo $menulateral; ?>
	</div>
	<div id = "contenido">
		<?php echo $contenido; ?>
	</div>
	<div id = "pie">
		<?php echo $pie; ?>
	</div>
</body>