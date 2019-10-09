<?php
    /***********************************************************
	************************************************************   
  	                     V  A  L  I  D  A  R
	************************************************************
	***********************************************************/
	include("class/conexionesDB.php"); include("configuracion.php");
   include("configuracion.php"); $semestre=$cfg['semestre']; $año=$cfg['año']; $tec=$cfg['instituto']; $lema=$cfg['lema']; $index=$cfg['index']; unset($cfg);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <head>
     <?php include("estilo/styles.php"); ?>
   </head>
<body class="fondo"  style="font-family:SoberanaSans;">

  <?php include("estilo/header.php"); ?>
  
  
  <center>
	  <table><tr bgcolor="#e0e0e0"><td align="center"><font  size="+2">&nbsp;&nbsp;Evaluación de los Profesores&nbsp;&nbsp;</font></td></tr>
			<tr bgcolor="#e0e0e0"><td align="center"><font size="+2">Período Escolar: <?php echo $semestre.' '.$año; ?></font></td></tr>
      </table>
	  <table width="750">
		<tr> 
            <td align="center" valign="top">

			<div align="justify" style="width:730px"> 
			  <p>El <font color="#336600">Servidor del <?php echo $tec;?></font>, ha detectado que
                                       <font color="#bb6600">&quot;usted ha intentado entrar varias veces a nuestro sistema sin los permisos adecuados&quot;;</font> 
 	                                    por lo mismo, le recomendamos lo siguiente:
     	                                 <ol><li>· Cierre <b>TODAS</b> las ventanas de su Navegador de Internet.</li>
                                       <li>· Posteriormente abra una nueva ventana con la p&aacute;gina de la evaluaci&oacute;n.</li>
		                                 <li>· Verifique que esté escribiendo correctamente sus contraseñas.</li>
                                       <li>· Es posible que tenga que esperar algo de tiempo a que el servidor le asigne nuevos permisos.</li>
		                                 <li>· Si no tiene sus contraseñas correctas no siga intent&aacute;ndolo, <font color="#bb6600"> de lo contrario podr&iacute;a bloquear definitivamente su acceso</font>.</li>
		                                 <li>· En caso de tener problemas para acceder a la evaluación, acudir a la <font color="#336600">&quot;Coordinación Académica&quot;</font> con una identificación oficial.</li></ol></p>
			  <p>El <font color="#336600"><?php echo $tec;?></font> agradece 
				la entusiasta participación de sus alumnos y maestros durante la <font color="#336600">&quot;Evaluación 
				de los Profesores &quot;</font>.</p>
			  <p>As&iacute; mismo, hace hincapi&eacute; que todas las encuestas realizadas 
				son an&oacute;nimas y manejadas bajo confidencialidad. Siempre seguros del 
				bienestar que representa para nuestro quehacer educativo.</p>
			  <p>Atentamente.</p>
			  <p><font color="#336600"> <?php echo $tec;?></font><br>
				<font color="#336600"><?php echo '"'.$lema.'"';?></font></p>
			</div>
			
			</td>
		</tr>
	 </table>
  </center>
  
  <?php include("estilo/footer.php"); ?>
  
</body>
</html>
<?php die;?>
  
