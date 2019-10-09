<?php 
	//http://localhost/evaldoc2sie/dat.php
	/***********************************************************
	************************************************************   
  	                     I  N  D  E  X
	************************************************************
	***********************************************************/
    session_start(); //error_reporting(E_ALL); @ini_set('display_errors', '1'); 
//	header('Content-Type: text/html; charset=iso-8859-1');
	include("configuracion.php");
if($activo)
{   
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<head>
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
		$user=isset($_POST["user"])?$_POST["user"]:$user;
		$pass=isset($_POST["pass"])?$_POST["pass"]:$pass;
		$year =isset($_POST["year"])?$_POST["year"]:isset($_SESSION["year"])?$_SESSION["year"]:$year;
		$month =isset($_POST["month"])?$_POST["month"]:isset($_SESSION["month"])?$_SESSION["month"]:$month;
      			
		include("estilo/header.php");
		echo '<div class="wraper"><table class="tec" border="0" cellspacing="0" cellpadding="0" width="100%">';
		echo '<tr><td align="center"><center><table width="100%"><tr bgcolor="#e0e0e0"><td align="center"><font size="+2">&nbsp;&nbsp;Evaluación de los Profesores &nbsp;&nbsp;</font></td></tr>';
		echo '<tr bgcolor="#e0e0e0"><td align="center"><font size="+2">Período Escolar: '.$semestre.'</font></td></tr></table><br /><br />';
		echo '<table border="0" width="750">';
		echo '<tr><td bgcolor="#6ac36a" align="center"><font color="#ffffff"><b>Manejo de Datos</b></font></td></tr>';
		echo '<tr><td bgcolor="#fafafa" align="center">';
		echo '<table bgcolor="#fafafa" border="0" width="200"><tr><td>&nbsp;</td></tr>';
		echo '<tr><td align="left"><br /><form name="fLogin" method="POST" action="dat_sie2evaldoc.php"><input class="btn btn-success" style="width:300px" type="submit" value="Importar desde SIE a Evaldoc" /></form></td></tr>';
		/*echo '<tr><td align="left"><form name="fLogin" method="POST" action="dat_evaldoc2dgest.php"><input class="btn btn-success" style="width:300px" type="submit" value="Exportar desde Evaldoc a DGEST" /></form></td></tr>';*/
		echo '<tr><td align="center"><table bgcolor="#fafafa" border="0" width="200"><tr><td align="center"><form name="fLogin" method="POST" action="dat_datos.php">';
		echo '<tr><td align="left">Año :</td><td>&nbsp;</td><td align="left"><select style="width:150px" name="year">'; for($years=date("Y")-2;$years<date("Y")+4;$years++) echo '<option value="'.$years.'"'.($years==$year?" selected":"").'>'.$years.'</option>'; echo '</select></td></tr>';
		echo '<tr><td align="left">Mes :</td><td>&nbsp;</td><td align="left"><select style="width:150px" name="month">';
			foreach($SEMM as $sm=>$sm2)
			{
				$sel='';
				if($month==$sm)$sel=' selected';
				echo"<option value='$sm' $sel>$sm2</option>";
			}
		echo'</select></td></tr>';
		echo '<tr><td align="center" colspan="3"><input class="btn btn-success" style="width:200px" type="submit" value="Verificar datos del Semestre" /><br /><br /></td></tr></form></td></tr></table></td></tr>';
		echo '</table><ol type="a"><li><p align="justify">*Asegúrese de tener la Base de Datos del SIE y las preguntas en el directorio correspondiente de acuerdo al año y al mes seleccionado (Ejemplo: <b>'.$year.$month.'/sie/csv/</b> y <b>'.$year.$month.'/preguntas/</b>)</p></li>';
		echo '<li><p align="justify">*Verifique que el directorio (preguntas/) contenga actualizadas las preguntas, los rubros y las conversiones correspondientes.</p></li></ol>';
		echo '</td></tr></table></center></td></tr></table></div>';
		
		$_SESSION["manejo"]="Si"; $_SESSION["intentos"]=0;
	?>

	<?php include("estilo/footer.php"); ?>

	</body>
	</html>
<?php 
}else include("index.php");
?>