<?php 
	//http://localhost/evaldoc4sie/dat.php
	/***********************************************************
	************************************************************   
  	                     I  N  D  E  X
	************************************************************
	***********************************************************/
   session_start(); error_reporting(E_ALL); @ini_set('display_errors', '1'); 
	//header('Content-Type: text/html; charset=iso-8859-1');
	include("configuracion.php");
if($activo && isset($_SESSION["manejo"]) && $_SESSION["manejo"]=="Si")
{  
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	   <title>Evaluación Docente <?php echo $semestre;?></title>
	   
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
		$user="user";    //$user=isset($_POST["user"])?$_POST["user"]:$user;
		$pass="pass";    //$pass=isset($_POST["pass"])?$_POST["pass"]:$pass;
		$year =isset($_POST["year"])?$_POST["year"]:isset($_SESSION["year"])?$_SESSION["year"]:$year;
		$month =isset($_POST["month"])?$_POST["month"]:isset($_SESSION["month"])?$_SESSION["month"]:$month;
		//$semestre=($mes=="may"?"ENE-JUN":"AGO-DIC").' '.$año;
			
		include("estilo/header.php");
	   $_SESSION["intentos"]=((isset($_SESSION["intentos"]))?$_SESSION["intentos"]+($user!=""?1:0):0);
		if($_SESSION["intentos"]<3)
		{  
			$_SESSION["importacion"]="Si";
			echo '<form name="fLogin" method="POST" action="importardesdesie.php">';
			echo '<div class="wraper"><table class="tec" border="0" cellspacing="0" cellpadding="0" width="100%">';
			echo '<tr><td align="center"><center><table><tr bgcolor="#e0e0e0"><td align="center"><font size="+2">&nbsp;&nbsp;Evaluación de los Profesores de la Educación Superior Tecnológica&nbsp;&nbsp;</font></td></tr>';
			echo '<tr bgcolor="#e0e0e0"><td align="center"><font size="+2">Período Escolar: '.$semestre.'</font></td></tr></table><br /><br />';
			echo '<table border="0" width="750">';
			echo '<tr><td bgcolor="#6ac36a" align="center"><font color="#ffffff"><b>Proceso de Importación</b></font></td></tr>';
			echo '<tr><td bgcolor="#fafafa" align="center">';
			echo '<table bgcolor="#fafafa" border="0" width="200"><tr><td>&nbsp;</td></tr>';
			echo '<tr><td align="left">Host:</td><td>&nbsp;</td><td align="right"><input type="password" style="width:200px" name="host" size="10" value="'.$host.'"></td></tr>';
			echo '<tr><td align="left">User:</td><td>&nbsp;</td><td align="right"><input type="password" style="width:200px" name="user" size="10" value="'.$user.'"></td></tr>';
			echo '<tr><td align="left">Pass:</td><td>&nbsp;</td> <td align="right"><input type="password" style="width:200px" name="pass" size="10" value="'.$pass.'"></td></tr><tr><td>&nbsp;</td></tr>';
			echo '<tr><td align="left">Año :</td><td>&nbsp;</td><td align="left"><select style="width:150px" name="year">'; for($years=date("Y")-2;$years<date("Y")+4;$years++) echo '<option value="'.$years.'"'.($years==$year?" selected":"").'>'.$years.'</option>'; echo '</select></td></tr>';
			echo '<tr><td align="left">Mes :</td><td>&nbsp;</td><td align="left"><select style="width:150px" name="month">';
			foreach($SEMM as $sm=>$sm2)
			{
				$sel='';
				if($month==$sm)$sel=' selected';
				echo"<option value='$sm' $sel>$sm2</option>";
			}
			//<option value="may"'.($month=="may"?" selected":"").'>Mayo</option>
			//<option value="nov"'.($month=="nov"?" selected":"").'>Noviembre</option>
			echo'</select></td></tr>';
			echo '<tr><td align="left">Deptos:</td><td>&nbsp;</td><td align="left"><select style="width:150px"><option value="-">Depto|Dígito|Pass</option>'; foreach($deptos as $d => $dep) echo '<option>'.$dep[0].'|'.$dep[1].'|'.$dep[2].'</option>'; echo '</select></td></tr>';
			echo '<tr><td align="left">Carrera:</td><td>&nbsp;</td><td align="left"><select style="width:150px"><option value="-">Carrera|DGEST|Nivel</option>'; foreach($carreras as $c => $car) echo '<option>'.$car[0].'|'.$car[1].'|'.$car[2].'</option>'; echo '</select></td></tr>';
			echo '</table><ol type="a"><li><p align="justify">*Asegúrese de tener la Base de Datos del SIE y las preguntas en el directorio correspondiente, de acuerdo al año y al mes seleccionado (Ejemplo: <b>'.$year.$month.'/sie/csv/</b> y <b>'.$year.$month.'/preguntas/</b>)</p></li>';
			echo '<li><p align="justify">*Verifique que el directorio (<b>preguntas/</b>) contenga las preguntas actualizadas y relacionadas con sus rubros correspondientes.</p></li>';
			echo '<li><p align="justify">*Verifique que las conversiones de DEPTO&lt;=&gt;DIGITO&lt;=&gt;PASS sean correctas. Así mismo las conversiones de CARRERAS&lt;=&gt;DGEST sean correctas.</p></li>';
			echo '<li><p align="justify">*El usuario debe tener privilegios para crear Bases de Datos en MySQL.</p></li>';
			echo '<li><p align="justify">*Al terminar el Proceso de Importación aparecerá: "PROCESO TERMINADO CON ÉXITO". Si no aparece esta leyenda verifique y corrija el error para poder continuar.</p></li></ol>';
			echo '<center><input class="btn btn-success" style="width:250px" type="submit" value="Importar desde SIE a Evaldoc" /><br /><br /></center>';
			echo '</td></tr></table></center></td></tr></table></div></form>';
		}
		else
		{  $_SESSION["importacion"]="No";
		   include("index.php");
		}

	?>

	<?php include("estilo/footer.php"); ?>

	</body>
	</html>
<?php 
}else include("index.php");
?>