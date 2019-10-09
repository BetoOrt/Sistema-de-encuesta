<?php 
	//http://localhost/evaldoc2sie/dat.php
	/***********************************************************
	************************************************************   
  	                     I  N  D  E  X
	************************************************************
	***********************************************************/
    session_start(); error_reporting(E_ALL); @ini_set('display_errors', '1'); 
	header('Content-Type: text/html; charset=iso-8859-1');
	include("configuracion.php");
if($activo && isset($_SESSION["manejo"]) && $_SESSION["manejo"]=="Si")
{  
?>
	<html>
	<head>
	   <title>Evaluación Docente <?php echo $año;?></title>
	   
	   <?php include("estilo/styles.php"); ?>
	   
	   <script language="Javascript">
		   document.oncontextmenu = function(){return false};
		   document.onselectstart=new Function ("return false");
		   if (window.sidebar)
			{  document.onmousedown=function(e)
				{	var obj=e.target.tagName;
				   var result=false;
					if (obj=="INPUT" || obj=="TEXTAREA")
					{	result=true;
					}
					return result;
				}
		   }
		</script>
		<style type="text/css" media="print">
		   html { display:none; }
		</style>
	</head>
	<body class="fondo" oncontextmenu="return false" style="font-family:SoberanaSans;">

	<?php 
		$host=isset($_POST["host"])?$_POST["host"]:$host;
		$user="user"; //$user=isset($_POST["user"])?$_POST["user"]:$user;
		$pass="pass"; //$pass=isset($_POST["pass"])?$_POST["pass"]:$pass;
		$año =isset($_POST["año"])?$_POST["año"]:isset($_SESSION["año"])?$_SESSION["año"]:$año;
		$mes =isset($_POST["mes"])?$_POST["mes"]:isset($_SESSION["mes"])?$_SESSION["mes"]:$mes;
		$semestre=($mes=="may"?"ENE-JUN":"AGO-DIC").' '.$año;
		      
		include("estilo/header.php");
	    $_SESSION["intentos"]=((isset($_SESSION["intentos"]))?$_SESSION["intentos"]+($user!=""?1:0):0);
		if($_SESSION["intentos"]<3)
		{   $_SESSION["exportacion"]="Si";
			echo '<form name="fLogin" method="POST" action="exportardesdeevaldoc.php">';
			echo '<div class="wraper"><table class="tec" border="0" cellspacing="0" cellpadding="0" width="100%">';
			echo '<tr><td align="center"><center><table><tr bgcolor="#e0e0e0"><td align="center"><font size="+2">&nbsp;&nbsp;Evaluación de los Profesores de la Educación Superior Tecnológica&nbsp;&nbsp;</font></td></tr>';
			echo '<tr bgcolor="#e0e0e0"><td align="center"><font size="+2">Período Escolar: '.$semestre.'</font></td></tr></table><br /><br />';
			echo '<table border="0" width="750">';
			echo '<tr><td bgcolor="#6ac36a" align="center"><font color="#ffffff"><b>Proceso de Exportación</b></font></td></tr>';
			echo '<tr><td bgcolor="#fafafa" align="center">';
			echo '<table bgcolor="#fafafa" border="0" width="200"><tr><td>&nbsp;</td></tr>';
			echo '<tr><td align="left">Host:</td><td>&nbsp;</td><td align="right"><input type="password" style="width:200px" name="host" size="10" value="'.$host.'"></td></tr>';
			echo '<tr><td align="left">User:</td><td>&nbsp;</td><td align="right"><input type="password" style="width:200px" name="user" size="10" value="'.$user.'"></td></tr>';
			echo '<tr><td align="left">Pass:</td><td>&nbsp;</td> <td align="right"><input type="password" style="width:200px" name="pass" size="10" value="'.$pass.'"></td></tr><tr><td>&nbsp;</td></tr>';
			echo '<tr><td align="left">Año :</td><td>&nbsp;</td><td align="left"><select style="width:150px" name="año">'; for($year=date("Y")-2;$year<date("Y")+4;$year++) echo '<option value="'.$year.'"'.($year==$año?" selected":"").'>'.$year.'</option>'; echo '</select></td></tr>';
			echo '<tr><td align="left">Mes :</td><td>&nbsp;</td><td align="left"><select style="width:150px" name="mes"><option value="may"'.($mes=="may"?" selected":"").'>Mayo</option><option value="nov"'.($mes=="nov"?" selected":"").'>Noviembre</option></select></td></tr>';
			echo '</table><ol type="a"><li><p align="justify">*Asegúrese de tener el directorio destino correspondiente, de acuerdo al año y al mes seleccionado (Ejemplo: <b>'.$año.$mes.'/</b>)</p></li>';
			echo '<li><p align="justify">*El usuario debe tener privilegios para acceder a Bases de Datos en MySQL.</p></li>';
			echo '<li><p align="justify">*Al terminar el Proceso de Exportación aparecerá: "PROCESO TERMINADO CON ÉXITO". Si no aparece esta leyenda verifique y corrija el error para poder continuar.</p></li></ol>';
			echo '<center><input class="btn btn-success" style="width:250px" type="submit" value="Exportar desde Evaldoc a DGEST" /><br /><br /></center>';
			echo '</td></tr></table></center></td></tr></table></div></form>';
		}
		else
		{  $_SESSION["exportacion"]="No";
		   include("index.php");
		}

	?>

	<?php include("estilo/footer.php"); ?>

	</body>
	</html>
<?php 
}else include("index.php");
?>