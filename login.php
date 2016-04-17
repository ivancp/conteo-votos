<?php
session_start();
require "config.php";

$login = empty($_POST['login'])?false:$_POST['login'];
$dni = empty($_POST['dni'])?false:$_POST['dni'];
$pass = empty($_POST['pass'])?false:$_POST['pass'];

$logout = empty($_GET['logout'])?false:$_GET['logout'];

if ($logout) {
	$_SESSION = array();
}

if ($login) {
	$sql = "select usuarios.*, count(*) as total from usuarios where dni = '$dni' and pass = '$pass'";
	$res = mysqli_query($link,$sql);
	$row = mysqli_fetch_assoc($res);
	//print_r($sql);
	//print_r($row);
	if($row['total'] > 0){
		$_SESSION['dni'] = $row['dni'];
		$_SESSION['nombre'] = $row['nombre'];

		//print_r($_SESSION);
		//exit;
		header('Location: index.php');
	}
}

?><!doctype html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Inicio de sesion</title>
<link rel="stylesheet" href="http://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.min.css">
<style>
td.logo {
	/*padding: 0 0 3px 0;*/
	width: 80px;
}

.logo img{
	margin: 0  0 0 0 ;
}

.input-group {
    margin-bottom: 0 !important;
}
</style>
</head>
<body>
 
 
<div class="row medium-8 large-7 ">
<div class="row">&nbsp;</div>
<form method=post>
<table style="width:100%">
	<tr bgcolor="gray">
		<td colspan=2 align="center" style="color:white">Sistema de conteo de votos</td>
	</tr>

	<tr >
		<td>DNI</td>
		<td><input type=text name=dni required><input type=hidden name=login value="1"></td>
	</tr>
	<tr >
		<td>Contrase&ntilde;a</td>
		<td><input type=password name=pass ></td>
	</tr>
	<tr >
		<td colspan=2 align="center"><input class="button" type=submit value="Iniciar sesi&oacute;n"></td>
	</tr>
</form>

</div>

</form>
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="http://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.js"></script>
<script>
function enviarDatos(b){
	b.preventDefault();
    if (confirm("Desea guardar?")) {
    	$("#datos").submit();
    }
}

$(document).foundation();

</script>
</body>
</html>
