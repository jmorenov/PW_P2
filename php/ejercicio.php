<?php
if (!defined('INDEX')) exit('No direct script access allowed');

if(!isset($_SESSION['userid'])) {
	header("location:index.php?page=login");
}

if(!isset($_GET['id'])) {
	header("location:index.php?page=miscursos");
}
include_once 'php/database.php';

$EjercicioID = $_GET['id'];
$ejercicio = get_ejercicio($EjercicioID);
$curso = get_curso($ejercicio[0]->CursoID);
$CursoID = $curso[0]->ID;

$cursos_usuario_std = get_user_cursos($_SESSION['userid']);
$cursos_usuario = array();
foreach ($cursos_usuario_std as $curso_usuario) {
	array_push($cursos_usuario, $curso_usuario->CursoID);
}
if(!in_array($CursoID, $cursos_usuario)) {
	header("location:index.php?page=miscursos");
}

if(isset($_POST['subir_solucion'])) {
	$target_dir = "videos/";
	$target_file = $target_dir . basename($_FILES["file_video"]["name"]);
	move_uploaded_file($_FILES["file_video"]["tmp_name"], $target_file);
	$error = "";
	if(!create_solucion($EjercicioID,
	$_SESSION['userid'], 
		$target_file, $error))
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
form.subir_solucion {
    background: none repeat scroll 0 0 #F1F1F1;
    border: 1px solid #DDDDDD;
    font-family: sans-serif;
    margin: 0 auto;
    padding: 20px;
	width: 500px;
}
form.subir_solucion div {
    margin-bottom: 15px;
    overflow: hidden;
}
form.subir_solucion div label {
    display: block;
    float: left;
    line-height: 25px;
}
form.subir_solucion div input[type="file"] {
    border: 1px solid #DCDCDC;
    float: right;
    padding: 4px;
}
form.subir_solucion div input[type="submit"] {
    background: none repeat scroll 0 0 #DEDEDE;
    border: 1px solid #C6C6C6;
    float: right;
    font-weight: bold;
    padding: 4px 20px;
}
</style>
<script type="text/javascript" src="js/video.js"></script>
	<link rel="stylesheet" type="text/css" href="css/video.css">
';

$contenido = '<div id="titulo">'.$ejercicio->titulo.'</div>';
$contenido .= '<div id="enunciado">'.$ejercicio->descripcion.'</div>';
$contenido .= '
<table style="width:70%;">
<tr>
    <th>Video</th>
    <th>Alumno</th>
    <th>Calificación Media</th> 
    <th>Evaluaciones</th> 
  </tr>';
$soluciones = get_soluciones($EjercicioID);
$soluciones_id = array();
foreach($soluciones as $solucion) {
	$evaluaciones = get_evaluaciones($EjercicioID, $solucion->AlumnoID);
	if(count($evaluaciones) > 0) {
		$calificacion = 0;
		foreach($evaluaciones as $evaluacion) {
			$calificacion += $evaluacion->calificacion;
		}
		$calificacion /= count($evaluaciones);
	} else $calificacion = "Sin evaluar.";
	$contenido .= '<tr>';
	$contenido .= '<td><button id="'.$solucion->file_video.'" onclick="show_video(\''.$solucion->file_video.'\');">VIDEO</button></td>';
	$contenido .= '<td>'.$solucion->AlumnoID.'</td>';
	$contenido .= '<td>'.$calificacion.'</td>';
	$contenido .= '<td><a href = "index.php?page=solucion&EjercicioID='.$EjercicioID.'&AlumnoID='.$solucion->AlumnoID.'">Ver evaluaciones</a></td>';
	$contenido .= '</tr>';
	array_push($soluciones_id,$solucion->AlumnoID);
}
$contenido .='</table>';


if(!in_array($_SESSION['userid'], $soluciones_id)) {
$contenido .= '<div style="position: absolute; bottom:0;"><form action="" method="post" class="subir_solucion" enctype="multipart/form-data">
		<div><label>Archivo de video</label><input name="file_video" id="file_video" type="file" ></div>
		<div><input name="subir_solucion" type="submit" value="Subir solución"></div>
</form></div>';
} else $contenido .= "Ya has subido una solución.";
