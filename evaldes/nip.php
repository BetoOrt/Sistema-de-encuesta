<?php
   session_start();
	include("class/conexionesDB.php"); include("evaldocAutentica.php"); 
	
if(!isset($_SESSION["Iniciada"]) || $_SESSION["Iniciada"]!="Iniciada")
{	GuardarFallo("Index-NIP");
	die;
}
else
{  
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <head>
      <title>CAMBIO DE NIP</title>
	</head>
<body>
<?php

	include("configuracion.php"); 
	include("estilo/styles.php");
      include("estilo/header.php");

	echo "<div class='container'>";
	if($_POST['nc'] and $_POST['clave'])
	{
		
		$nc = $_POST['nc'];
		$clv =str_replace('"','',$clv);
		$clv = md5(trim(strtoupper($_POST['clave'])));
		//$sql = "update 2015novDALU set ALU_PAS='$clv' where ALU_CTR='$nc'";
		//echo $sql;
		//$data->Link->select_db("evaldoc2015nov");
	   $conexion=new ClassConexion_DB($cfg['usuario'],$cfg['password'],$cfg['base'],"mysql",$cfg['host']);
	   //print_r($conexion);
		$ta = $cfg['permes']."dalu";
	   $SQL="update {$ta} set ALU_PAS='$clv' where ALU_CTR='$nc'";
	   echo $SQL;
		if(new ClassConsulta($SQL,$conexion))
		{
			echo "<div class='alert alert-success'>Cambio Correcto </div>";
		}
		else
		{
			echo "<div class='alert alert-warning'>Algo salio mal</div>";
		}
		echo "<a href='index.php' class='btn btn-primary'>Regresar</a>";
	}
	else
	{
		echo "<div class='alert alert-info'>Cambio de NIP EVALDOC</div>";
		echo "<form name='frm' method='post' class='form-inline'>";
		echo "<strong>No. Control:</strong> <input type='text' name='nc' class='form-control'><br>";
		echo "<strong>Nueva Clave:</strong> <input type='password' name='clave' class='form-control'><br>";
		echo "<input type='submit' name='btn' value='Cambiar' class='btn btn-success'>";
		echo "</form>";
		//echo $cfg['DALU']."  - - ".$cfg['ALU_CTR'];
	}
   echo "</div>";
   include("estilo/footer.php"); 
   
   ?>
      
   </body>
   </html>
<?php

}
?>