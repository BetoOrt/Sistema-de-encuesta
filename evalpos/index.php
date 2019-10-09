<?php 
	/***********************************************************
	************************************************************   
  	                     I  N  D  E  X
	************************************************************
	***********************************************************/
   session_start(); //error_reporting(E_ALL); @ini_set('display_errors', '1'); 
	//header('Content-Type: text/html; charset=iso-8859-1');
	include("class/conexionesDB.php"); include("class/zfunciones.php"); include("evaldocAutentica.php"); 

   $ip = getenv("REMOTE_ADDR");
	include("configuracion.php");     
	  $activo = $cfg['activoreportes'];
	unset($cfg);

if(!$activo){ echo '<script type="text/javascript">document.location.href="evaldocAgradece.php";</script>'; die; }

if(BuscarIntrusoPorHora())
{  unset($imprimir); include("configuracion.php"); $semestre=$cfg['semestre']; $año=$cfg['año']; $tec=$cfg['instituto']; $lema=$cfg['lema']; $index=$cfg['index']; unset($cfg);
   ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <head>
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
      $DesAca =(isset($_POST["Admin"])?$_POST["Admin"]:((isset($_SESSION["Admin"]))?$_SESSION["Admin"]:"")); 
      $Clave  =(isset($_POST["Clave"])?$_POST["Clave"]:((isset($_SESSION["Clave"]))?$_SESSION["Clave"]:"")); $_SESSION["Iniciada"]=null; unset($_SESSION["Iniciada"]); 
      include("estilo/header.php");
      
      if(!BuscarAdmin($DesAca,$Clave) || $DesAca=="" || $Clave=="")    
      {  $_SESSION["intentos"]=((isset($_SESSION["intentos"]))?$_SESSION["intentos"]+($DesAca!=""?1:0):0);
         echo '<form name="fLogin" method="POST" action="index.php">';
         echo '<div class="wraper"><table class="tec" border="0" cellspacing="0" cellpadding="0" width="100%">';
         echo '<tr><td align="center"><center><table><tr bgcolor="#e0e0e0"><td align="center"><font size="+2">&nbsp;&nbsp;Evaluación de los Profesores de la Educación Superior Tecnológica&nbsp;&nbsp;</font></td></tr>';
         echo '<tr bgcolor="#e0e0e0"><td align="center"><font size="+2">Período Escolar: '.$semestre.' '.$año.'</font></td></tr></table><br /><br />';
         echo '<table border="0" width="750">';
         echo '<tr><td bgcolor="#6ac36a" align="center"><font color="#ffffff"><b>Ingreso al Cuestionario</b></font></td></tr>';
         echo '<tr><td bgcolor="#fafafa" align="center">';
         if($_SESSION["intentos"]<3)
         {  echo '<table bgcolor="#fafafa" border="0" width="200"><tr><td>&nbsp;</td></tr>';
            echo '<tr><td align="left">Usuario:</td> <td>&nbsp;</td><td align="right"><input type="password" style="width:100px" name="Admin" size="20" maxlength="20"  value=""></td></tr>';
            echo '<tr><td align="left">Password:</td><td>&nbsp;</td><td align="right"><input type="password" style="width:100px" name="Clave" size="20" maxlength="20" value=""></td></tr><tr><td>&nbsp;</td></tr>';
            //echo '<tr><td bgcolor="#DCDCDC" nowrap="nowrap"><b>El periodo de evaluación inicia el Martes</b></td></tr>';
            echo '</table><center><input class="btn btn-success" style="width:200px" type="submit" value="Ingreso" /><br /><br /></center>';
            //echo '<p align="justify">NOTAS:</p>';
            echo '<ol type="a"><li><p align="justify">*Recuerda que el llenado completo de la encuesta al desempeño docente es requisito&nbsp;&nbsp;&nbsp; indispensable para tu reinscripción.</p></li>';
            echo '<li><p align="justify">*En caso de tener problemas de acceso, acudir a la Jefatura de Centro de Computo con una&nbsp;&nbsp;&nbsp;&nbsp; identificación oficial.</p></li></ol>';
         }
         else GuardarFallo("Index-MásDe3Intentos"); 
         echo '</td></tr></table></center></td></tr></table></div></form>';
                        unset($_SESSION["Admin"]); unset($_POST["Admin"]); unset($_SESSION["Clave"]); unset($_POST["Clave"]); unset($_SESSION["Proceso"]); unset($_SESSION["NoMatri"]);
      }
      else
      {  $_SESSION["Admin"]=$DesAca; $_SESSION["Clave"]=$Clave; unset($_SESSION["intentos"]);
         $_SESSION["Iniciada"]="Iniciada"; 
   ?>
         <center>
               <table><tr bgcolor="#e0e0e0"><td align="center"><font size="+2">&nbsp;&nbsp;Evaluación de los Profesores de la Educación Superior Tecnológica&nbsp;&nbsp;</font></td></tr>
                      <tr bgcolor="#e0e0e0"><td align="center"><font size="+2">Período Escolar: <?php echo $semestre.' '.$año; ?></font></td></tr>
                </table>
           <table>
           <tr> 
                   <td align="center" valign="top">
               <form name='fPreguntas' method='POST' onsubmit='return Revisar()' action="indexGuardar.php">
                 <table>
                   <tr><td><?php include("indexEncabezado.php"); ?></td></tr>
                  </table>							  
               </form>
             <td>
            </tr>
            </table>
         </center>
   <?php
         echo '<script type="text/javascript" src="class/zcodigoRevisar.js"></script>';
         echo '<script>window.scrollTo(0,0);</script>';
      }
   ?>
      
   <?php include("estilo/footer.php"); ?>
      
   </body>
   </html>
<?php
}
?>
