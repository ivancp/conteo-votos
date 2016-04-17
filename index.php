<?php
session_start();

if(empty($_SESSION['dni']) && !$login){
	header('Location: login.php');
	exit;
}

$msg = "";
$error = "";
if(isset($_POST['guardar'])){
	//echo '<pre>';
	//print_r($_POST);
	//exit;
	$mesa = $_POST['mesa'];
	require "config.php";

	$sql = "select count(*) as total from votos where mesa = '$mesa'";
	$res = mysqli_query($link,$sql);
	$row = mysqli_fetch_assoc($res);

	if($row['total'] > 0){
		$error = "Mesa '$mesa' ya fue registrada, si quiere volver a ingresar por favor avisar a central";
	}else{
		if(!empty($_POST['blancos']) && $_POST['blancos'] > 0){
					$sql = "insert into votos(mesa, partido, cantidato, cantidad) 
							values ('$mesa',0,0,".$_POST['blancos'].")";
					mysqli_query($link,$sql) or die( mysqli_error($link));

		}
		for($i = 1 ; $i <= 12; $i++){
			for($j = 0 ; $j < 5; $j++){
				$index = 'v'.$i.'_'.$j;
				if(!empty($_POST[$index]) && $_POST[$index] > 0){
					$sql = "insert into votos(mesa, partido, cantidato, cantidad,dni) 
									values ('$mesa',$i,$j,".$_POST[$index].",'".$_SESSION['dni']."')";
					mysqli_query($link,$sql) or die( mysqli_error($link));
					$msg = "Se ha registrado correctamente la mesa '$mesa'";
		//			echo $sql . "\n";
				}
			}
		}

	}


	//echo '</pre>';
}

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
<li class="menu-text">Registrar Votos</li>
<li><a href="estadisticas.php">Estadisticas</a></li>
</ul>
</div>
</div>
 
<form method=POST  id="datos">
<div class="row medium-8 large-7 ">
<input type="hidden" name="guardar" value="1">

	<?php

	if (!empty($error)) {
		echo '<div class="alert callout">
		  <p><i class="fi-alert"></i> '.$error.'</p>
		</div>';
	}
	if (!empty($msg)) {
		echo '<div class="success callout">
		  <p> '.$msg.'</p>
		</div>';
	}
	?>

<table style="width:100%">
	<tr bgcolor="gray">
		<td colspan=2 align="center">CONGRESO</td>
	</tr>
	<tr>

		<td class="logo" >
			Mesa</td>
		<td><input type="number" name="mesa" required id=mesa onblur="checkMesa();">
			<div id="mensaje" style="color:red;display:none;">Mesa ya registrada</div>
		</td>
	</tr>

	<tr>

		<td  colspan=2>
			Escriba la cantidad de votos por CADA CANDIDATO segun como aparece en el acta.</td>
		<td>
		
	</tr>
<?php
	

	for($i = 1 ; $i <= 12; $i++){
		echo '	<tr>

			<td class="logo" valign=top>
				<img src="logos/'.$i.'.png" width=40 height=40 border=0 alt='.$i.'></td>

			<td>';

			echo '<div class="input-group">
			  <span class="input-group-label">Total</span>
			  <input class="input-group-field" type="number" name="v'.$i.'_0">
			</div>';
	
		for($j = 1 ; $j < 5; $j++){
			//echo  "$j : <input class=val type=\"number\" name=\"marca{$j}b\"><br>\n";

			echo '<div class="input-group">
			  <span class="input-group-label">'.$j.'</span>
			  <input class="input-group-field" type="number" name="v'.$i.'_'.$j.'">
			</div>';
		}


			echo '</tr>';	
	}

?>

	<tr>

		<td class="logo" colspan=3>
			Enviado desde  <?php echo $_SERVER['REMOTE_ADDR']. ' DNI: '.$_SESSION['dni'] ; ?>
			<input type="hidden" name="ip" value="<?php echo $_SERVER['REMOTE_ADDR']?>">
		</td>
	</tr>
	<tr>

		<td colspan=3 align=center><input type="submit" class="button" value="Guardar"
			></td>
	</tr>

</table>

</div>

</form>
<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="//dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.js"></script>
<script>
function enviarDatos(b){
	b.preventDefault();
    if (confirm("Desea guardar?")) {
    	$("#datos").submit();
    }
}

 $(document).foundation();


function checkMesa(){
	var m = $('#mesa').val();

    var post_data = {'mesa':m};
    $.ajax({
            url: 'check.php',
            type: 'GET',
            cache: false,
            data: post_data,
            success: function(data) {
            	if (data == 'ok') {
					$('#mensaje').hide();
            	}else{
            		$('#mensaje').show();
            	}                
            },
            error:function(err)
            {
                //$('.class-submit').attr('disabled',false);
                //$('#appt_search :input').attr('disabled',false);
                alert("Something wrong happen, please contact site admin.");
            }                                
    });    
}



</script>
</body>
</html>
