<?php
	if (!defined('INDEX')) exit('No direct script access allowed');
	session_start();
	$_SESSION = array();
	session_destroy();
	header("location:index.php");
?>