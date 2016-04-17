<?php
require "config.php";
$mesa = $_GET['mesa'];
$sql = "select count(*) as total from votos where mesa = '$mesa'";
$res = mysqli_query($link,$sql);
$row = mysqli_fetch_assoc($res);
//echo json_encode($row);

if ($row['total'] > 0 ){
	echo "fail";
}else{
	echo "ok";
}