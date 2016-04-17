<?php
session_start();
if(empty($_SESSION['dni']) && !$login){
	header('Location: login.php');
	exit;
}

require "config.php";


?><!doctype html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Conteo de Votos</title>
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
 
<div class="top-bar">
<div class="top-bar-left">
<ul class="menu">
<li><a href="index.php">Registrar Votos</a></li>
<li class="menu-text">Estadisticas</li>
</ul>
</div>
</div>
 
<div class="row medium-8 large-7 ">

<table style="width:100%">
	<tr bgcolor="gray">
		<td></td>
		<td align="center">Total</td>
		<td align="center">1</td>
		<td align="center">2</td>
		<td align="center">3</td>
		<td align="center">4</td>
	</tr>

<?php

$sql = "call get_votos()";

$res = mysqli_query($link,$sql);

while($row = mysqli_fetch_array($res)){
	echo "
	<tr>
		<td><img src=\"logos/{$row['id']}.png\" width=40 height=40 border=0 alt='{$row['id']}'></td>
		<td align='center'>{$row['c0']}</td>
		<td align='center'>{$row['c1']}</td>
		<td align='center'>{$row['c2']}</td>
		<td align='center'>{$row['c3']}</td>
		<td align='center'>{$row['c4']}</td>
	</tr>
	";
}

?>
</table>
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
