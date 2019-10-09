<?php
	session_start();
	//header('Content-Type: text/html; charset=iso-8859-1');
	$_SESSION["Alumno"]=""; $_POST["Alumno"]=""; unset($_SESSION["Alumno"]); unset($_POST["Alumno"]); 
	$_SESSION["Clave"]=""; $_POST["Clave"]=""; unset($_SESSION["Clave"]); unset($_POST["Clave"]); 
	$_SESSION["Proceso"]=""; unset($_SESSION["Proceso"]);
	$_SESSION["NoMatri"]=0; unset($_SESSION["NoMatri"]); 
	unset($_SESSION["Guardado"]); unset($_SESSION["intentos"]);
	$Alumno=null; $Clave=null; $Materia=null; $Grupo=null; $Maestro=null;
	session_destroy();
	
// Si está usando session_name("algo"), ¡no lo olvide ahora!
/*session_start(); // Inicializar la sesión.
$_SESSION = array(); // Destruir todas las variables de sesión.
// Si se desea destruir la sesión completamente, borre también la cookie de sesión.
// Nota: ¡Esto destruirá la sesión, y no la información de la sesión!
if (ini_get("session.use_cookies")) 
{   $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}
session_destroy(); // Finalmente, destruir la sesión.*/
	/***********************************************************
	************************************************************   
  	                    A  G  R  A  D  E  C  E
	************************************************************
	***********************************************************/
    include("class/conexionesDB.php"); 
	include("configuracion.php"); $semestre=$cfg['semestre']; $año=$cfg['año']; $tec=$cfg['instituto']; $lema=$cfg['lema']; $index=$cfg['index']; unset($cfg);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
      <title>Evaluación Docente <?php echo $year;?></title>
      <?php include("estilo/styles.php"); ?>
   </head>
<body class="fondo"  style="font-family:SoberanaSans;">


  <?php include("estilo/header.php"); ?>
  
  <center>
	  <table><tr bgcolor="#e0e0e0"><td align="center"><font  size="+2">&nbsp;&nbsp;Evaluación de los Profesores &nbsp;&nbsp;</font></td></tr>
			<tr bgcolor="#e0e0e0"><td align="center"><font size="+2">Período Escolar: <?php echo $semestre.' '.$year; ?></font></td></tr>
      </table>
	  <table width="750">
		<tr> 
            <td align="center" valign="top">

			<div align="justify" style="width:730px"> 
			  <ol><li><p>· Recuerda que el llenado completo de la encuesta es requisito indispensable para tu reinscripción. Si no la has completado, puedes continuarla desde donde la dejaste.</p></li>
			      <li><p>· En caso de tener problemas para acceder a la evaluación, acudir a la <font color="#336600">&quot;Coordinación Académica&quot;</font> con una identificación oficial.</p></li></ol>
			  <p>El <font color="#336600"><?php echo $tec;?></font> agradece 
				la entusiasta participación de sus alumnos y maestros durante la <font color="#336600">&quot;Evaluación 
				de los Profesores&quot;</font>.</p>
			  <p>As&iacute; mismo, hace hincapi&eacute; que todas las encuestas realizadas 
				son an&oacute;nimas y manejadas bajo confidencialidad. Siempre seguros del 
				bienestar que representa para nuestro quehacer educativo.</p>
			  <p>Atentamente.</p>
			  <p><font color="#336600"><?php echo $tec;?></font><br>
				<font color="#336600"><?php echo '"'.$lema.'"';?></font></p>
			</div>
			
			</td>
		</tr>
	 </table>
  </center>
  
  <?php include("estilo/footer.php"); ?>
  
</body>
</html>
  
