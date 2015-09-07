<?php
if (!defined('INDEX')) exit('No direct script access allowed');

if(!isset($_SESSION['userid'])) {
	header("location:index.php?page=login");
}

if(!isset($_GET['id'])) {
	header("location:index.php?page=miscursos");
}
$CursoID = $_GET['id'];
include_once 'php/database.php';

$cursos_usuario_std = get_user_cursos($_SESSION['userid']);
$cursos_usuario = array();
foreach ($cursos_usuario_std as $curso_usuario) {
	array_push($cursos_usuario, $curso_usuario->CursoID);
}
if(!in_array($CursoID, $cursos_usuario)) {
	header("location:index.php?page=miscursos");
}

$curso = get_curso($CursoID);

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
}</style>';


$contenido = '<table style="width:100%;">';
$contenido .= '<tr>
    <th>ID</th>
    <th>Título</th> 
    <th>Descripción</th>
    <th>Profesor</th>
  </tr>';
$curso = get_curso($CursoID);
$curso = $curso[0];
$contenido .='<tr>';
$contenido .= '<td>'.$curso->ID.'</td>';
$contenido .= '<td>'.$curso->titulo.'</td>';
$contenido .= '<td>'.$curso->descripcion.'</td>';
$contenido .= '<td>'.$curso->profesorID.'</td>';
$contenido .= '</tr>';
$contenido .='</table>';
