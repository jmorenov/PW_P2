<?php
if (!defined('INDEX')) exit('No direct script access allowed');

if(!isset($_SESSION['userid'])) {
	header("location:index.php?page=login");
}

if(!isset($_GET['EjercicioID']) || !isset($_GET['AlumnoID'])) {
	header("location:index.php?page=miscursos");
}

include_once 'php/database.php';

$EjercicioID = $_GET['EjercicioID'];
$AlumnoID = $_GET['AlumnoID'];
$ejercicio = get_ejercicio($EjercicioID);
$curso = get_curso($ejercicio[0]->CursoID);
$CursoID = $curso[0]->ID;
$evaluaciones = get_evaluaciones($EjercicioID, $AlumnoID);

$cursos_usuario_std = get_user_cursos($_SESSION['userid']);
$cursos_usuario = array();
foreach ($cursos_usuario_std as $curso_usuario) {
	array_push($cursos_usuario, $curso_usuario->CursoID);
}
if(!in_array($CursoID, $cursos_usuario)) {
	header("location:index.php?page=miscursos");
}

if(isset($_POST['evaluar'])) {
	$error = "";
	if(!evaluar_solucion($_SESSION['userid'], 
		$EjercicioID, $AlumnoID, 
		$_POST['calificacion'], $_POST['lomejor'], 
		$_POST['lopeor'], $_POST['observaciones'], $error))
		echo $error;
}


$menulateral .= '</br></br>Lista de ejercicios:</br>';
$ejercicios = get_ejercicios($CursoID);
foreach($ejercicios as $ejercicio) {
	$menulateral .= '<a href="index.php?page=ejercicio&id='.$ejercicio->ID.'">'.$ejercicio->ID.'</a></br>';
}

$head = '<style>table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 15px;
}
form.evaluar {
    background: none repeat scroll 0 0 #F1F1F1;
    border: 1px solid #DDDDDD;
    font-family: sans-serif;
    margin: 0 auto;
    padding: 20px;
	width: 300px;
}
form.evaluar div {
    margin-bottom: 15px;
    overflow: hidden;
}
form.evaluar div label {
    display: block;
    float: left;
    line-height: 25px;
}
form.evaluar div input[type="text"], form.evaluar div input[type="number"] {
    border: 1px solid #DCDCDC;
    float: right;
    padding: 4px;
}
form.evaluar div input[type="submit"] {
    background: none repeat scroll 0 0 #DEDEDE;
    border: 1px solid #C6C6C6;
    float: right;
    font-weight: bold;
    padding: 4px 20px;
}

</style>
';

$contenido = '
<table style="width:70%;">
<tr>
    <th>Calificación</th> 
    <th>Lo mejor</th> 
    <th>Lo peor</th> 
    <th>Observaciones</th> 
  </tr>';
$evaluadores = array();
foreach($evaluaciones as $evaluacion) {
	$contenido .= '<tr>';
	$contenido .= '<td>'.$evaluacion->calificacion.'</td>';
	$contenido .= '<td>'.$evaluacion->lomejor.'</td>';
	$contenido .= '<td>'.$evaluacion->lopeor.'</td>';
	$contenido .= '<td>'.$evaluacion->observaciones.'</td>';
	$contenido .= '</tr>';
	array_push($evaluadores, $evaluacion->AlumnoID);
}
$contenido .='</table>';

if(!in_array($_SESSION['userid'], $evaluadores)) {
$contenido .= '<div style="position: absolute; bottom:0;"><form action="" method="post" class="evaluar">
		<div><label>Calificacion</label><input name="calificacion" type="number" ></div>
		<div><label>Lo mejor</label><input name="lomejor" type="test"></div>
		<div><label>Lo peor</label><input name="lopeor" type="text" ></div>
		<div><label>Observaciones</label><input name="observaciones" type="text" ></div>
		<div><input name="evaluar" type="submit" value="Evaluar"></div>
</form></div>';
} else $contenido .= "Ya has evaluado esta solución.";
