<?php
if (!defined('INDEX')) exit('No direct script access allowed');

if(!isset($_SESSION['userid'])) {
	header("location:index.php?page=login");
}

include_once 'php/database.php';

if(isset($_POST['unirse'])) {
	if(alta_curso($_SESSION['userid'], $_POST['CursoID'])) {
		header("location:index.php?page=cursos");
	}
}
if(isset($_POST['baja'])) {
	if(baja_curso($_SESSION['userid'], $_POST['CursoID'])) {
		header("location:index.php?page=cursos");
	}
}

$head = '<style>table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 15px;
}</style>';

$contenido = '<form action="" method="post" class="unirse"><table style="width:100%;">';
$contenido .= '<tr>
    <th>ID</th>
    <th>Título</th> 
    <th>Descripción</th>
    <th>Profesor</th>
    <th>Unirse</th>
  </tr>';
$cursos = get_cursos();

$cursos_usuario_std = get_user_cursos($_SESSION['userid']);
$cursos_usuario = array();
foreach ($cursos_usuario_std as $curso_usuario) {
	array_push($cursos_usuario, $curso_usuario->CursoID);
}
foreach($cursos as $curso) {
	$contenido .='<tr>';
	$contenido .= '<td>'.$curso->ID.'</td>';
	$contenido .= '<td>'.$curso->titulo.'</td>';
	$contenido .= '<td>'.$curso->descripcion.'</td>';
	$contenido .= '<td>'.$curso->profesorID.'</td>';
	if(in_array($curso->ID, $cursos_usuario))
		$contenido .= '<td><input name="CursoID" type="hidden" value="'.$curso->ID.'"><input name="baja" type="submit" value="Darse de baja del curso"></div></td>';
	else
		$contenido .= '<td><input name="CursoID" type="hidden" value="'.$curso->ID.'"><input name="unirse" type="submit" value="Unirse al curso"></div></td>';
	$contenido .= '</tr>';
}
$contenido .='</table></form>';
