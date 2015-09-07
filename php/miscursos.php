<?php
if (!defined('INDEX')) exit('No direct script access allowed');

if(!isset($_SESSION['userid'])) {
	header("location:index.php?page=login");
}

include_once 'php/database.php';

$head = '';

$contenido = '';
$cursos =  get_user_cursos($_SESSION['userid']);
foreach($cursos as $curso) {
	$contenido .= '<a href="index.php?page=curso&id='.$curso->CursoID.'">'.$curso->CursoID.'</a></br>';
}