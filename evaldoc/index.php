<?php 
	/***********************************************************
	************************************************************   
  	                     I  N  D  E  X
	************************************************************
	***********************************************************/
   session_start();// error_reporting(E_ALL); @ini_set('display_errors', '1'); 
	//header('Content-Type: text/html; charset=iso-8859-1');
	include("class/conexionesDB.php"); include("class/zfunciones.php"); include("evaldocAutentica.php"); 

   $ip = getenv("REMOTE_ADDR");
	include("configuracion.php");     
	$activo = $cfg['activo'];
	unset($cfg);

if(!$activo){ echo '<script type="text/javascript">document.location.href="evaldocAgradece.php";</script>'; die; }

if(BuscarIntrusoPorHora())
{
	include("configuracion.php");
	$semestre=$cfg['semestre']; $año=$cfg['año']; $tec=$cfg['instituto']; $lema=$cfg['lema']; $index=$cfg['index']; unset($cfg);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
      <title>Evaluación Docente <?php echo $year;?></title>
      
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
      $Alumno=strtoupper((isset($_POST["Alumno"])?$_POST["Alumno"]:((isset($_SESSION["Alumno"]))?$_SESSION["Alumno"]:""))); 
      $Clave =strtoupper((isset($_POST["Clave"])?$_POST["Clave"]:((isset($_SESSION["Clave"]))?$_SESSION["Clave"]:""))); 
      $Proceso=((isset($_SESSION["Proceso"]))?$_SESSION["Proceso"]:""); 
       
      //$Alumno=(strlen($Alumno)<5?'F'.str_pad(strval($Alumno),4,'0',STR_PAD_LEFT):$Alumno);
      //echo "<br>{$Alumno}<br>{$Clave}<br>{$Proceso}";
      
      include("estilo/header.php");
      
      if(($Proceso=BuscarAlumno($Alumno,$Clave,$Proceso))=="" || $Alumno=="" || $Clave=="")    
      {   $_SESSION["intentos"]=((isset($_SESSION["intentos"]))?$_SESSION["intentos"]+($Alumno!=""?1:0):0);
         echo '<form name="fLogin" method="POST" action="index.php">';
         echo '<div class="wraper"><table class="tec" border="0" cellspacing="0" cellpadding="0" width="100%">';
         echo '<tr><td align="center"><center><table width="100%"><tr bgcolor="#e0e0e0"><td align="center"><font size="+2">&nbsp;&nbsp;Evaluación de los Profesores&nbsp;&nbsp;</font></td></tr>';
         echo '<tr bgcolor="#e0e0e0"><td align="center"><font size="+2">Período Escolar: '.$semestre.' '.$año.'</font></td></tr></table><br /><br />';
         echo '<table border="0" width="750">';
         echo '<tr><td bgcolor="#6ac36a" align="center"><font color="#ffffff"><b>Ingreso al Cuestionario</b></font></td></tr>';
         echo '<tr><td bgcolor="#fafafa" align="center">';
         if($_SESSION["intentos"]<3)
         {   echo '<table bgcolor="#fafafa" border="0" width="200"><tr><td>&nbsp;</td></tr>';
            echo '<tr><td align="left">Matrícula:</td><td>&nbsp;</td><td align="right"><input type="text"     style="width:100px" name="Alumno" size="10" maxlength="12"  value=""></td></tr>';
            echo '<tr><td align="left">Password:</td><td>&nbsp;</td> <td align="right"><input  type="password" style="width:100px" name="Clave"  size="10" maxlength="15" value=""></td></tr><tr><td>&nbsp;</td></tr>';
            //echo '<tr><td bgcolor="#DCDCDC" nowrap="nowrap"><b>El periodo de evaluación inicia el Miercoles</b></td></tr>';
            echo '</table><center><input class="btn btn-success" style="width:200px" type="submit" value="Ingreso" /><br /><br /></center>';
            //echo '<p align="justify">NOTAS:</p>';
            echo '<ol type="a"><li><p align="justify">*Recuerda que el llenado completo de la encuesta al desempeño docente es requisito&nbsp;&nbsp;&nbsp; indispensable para tu reinscripción.</p></li>';
			echo "<li><p align='justify'>*El Password es el mismo que se tienes registrado en el Sistema de Integración Escolar <i>si aun no la ha cambiado es 2 últimos dígitos del AÑO y 2 dígitos del MES de nacimiento o en caso de no contar con su fecha de nacimiento en el sistema, su clave seria 0000</i></p></li>";
            echo '<li><p align="justify">*En caso de tener problemas de acceso, acudir a la Coordinación Académica con una&nbsp;&nbsp;&nbsp;&nbsp; identificación oficial.</p></li></ol>';
         }
         else GuardarFallo("Index-MásDe3Intentos"); 
         echo '</td></tr></table></center></td></tr></table></div></form>';
         if(isset($_SESSION["NoMatri"])) if($_SESSION["NoMatri"]==1) echo '<script type="text/javascript"> alert("Esta matrícula de estudiante no existe...");</script>'; 
         unset($_SESSION["Alumno"]); unset($_POST["Alumno"]); unset($_SESSION["Clave"]); unset($_POST["Clave"]); unset($_SESSION["Proceso"]); unset($_SESSION["NoMatri"]);
      }
      else
      {  $_SESSION["Alumno"]=$Alumno; $_SESSION["Clave"]=$Clave; $_SESSION["Proceso"]=$Proceso; unset($_SESSION["intentos"]); 
         $_SESSION["NoMatri"]=0; unset($_SESSION["NoMatri"]);
         $Materia=null; $Grupo=null; $Maestro=null;
         //include("configuracion.php"); $semestre=$cfg['semestre']; $año=$cfg['año']; unset($cfg);
   ?>
         <center>
               <table><tr bgcolor="#e0e0e0"><td align="center"><font size="+2">&nbsp;&nbsp;Evaluación de los Profesores de la Educación Superior Tecnológica&nbsp;&nbsp;</font></td></tr>
                      <tr bgcolor="#e0e0e0"><td align="center"><font size="+2">Período Escolar: <?php echo $semestre.' '.$año; ?></font></td></tr>
                      <tr bgcolor="#e0e0e0"><td align="center"><font size="+2">NIVEL <?php echo $Proceso;?></font></td></tr>
                </table>
           <table>
           <tr> 
                   <td align="center" valign="top">
               <form name='fPreguntas' method='POST' onsubmit='return Revisar()' action="indexGuardar.php">
                 <table>
                   <tr><td><?php include("indexAlumnoEncabezado.php"); ?></td></tr>
                   <tr><td><?php include("indexAlumnoPreguntas.php"); ?></td></tr>
                 </table>
                 <?php if($Materia!=null) echo '<input name="bGuardar" class="btn btn-success" style="width:200px" type="submit" value="Guardar"><br /><br /><br /><br />'; ?>
               </form>
               <?php 
               if($Materia==null) 
               {    
                   echo '<form name="fSalir" method="POST" action="evaldocAgradece.php">'; //indexSalir.php
                   echo ' <input name="bSalir" class="btn btn-success" style="width:200px" type="submit" value="Salir">';
                   echo '</form>';
               }
               ?> 
             <td>
            </tr>
            </table>
         </center>
   <?php
         echo '<script type="text/javascript" src="class/zcodigoRevisar.js"></script>';
         if(isset($_SESSION["Guardado"]))
         {  if($_SESSION["Guardado"]) echo '<script> if(document.forms["fPreguntas"]["R1"][0]!=null) document.forms["fPreguntas"]["R1"][0].focus(); alert("La evaluación de la materia ha sido guardada... Ahora continue con la siguiente materia."); </script>'; 
            $_SESSION["Guardado"]=null; 
         }
         else echo '<script>window.scrollTo(0,0);</script>';
      }
   ?>
      
   <?php include("estilo/footer.php"); ?>
      
   </body>
   </html>
<?php
}
?>
