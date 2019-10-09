<?php
/***********************************************************
************************************************************   
        indexFaltantesDocente.php
************************************************************
***********************************************************/
   session_start();
	include("class/conexionesDB.php"); include("evaldocAutentica.php"); 
	
if(!isset($_SESSION["Iniciada"]) || $_SESSION["Iniciada"]!="Iniciada")
{	GuardarFallo("Index-FaltAlu");
	die;
}
else
{  include("configuracion.php"); $semestre=strtoupper($cfg['semestre']); $año=$cfg['año']; $tec=strtoupper($cfg['instituto']); $lema=$cfg['lema']; $index=$cfg['index'];

	///Filtrando las encuestas del Profesor 
	   $conexion=new ClassConexion_DB($cfg['usuario'],$cfg['password'],$cfg['base'],"mysql",$cfg['host']);
		
		$prof=strval($_POST["faltantesAlum"]);
	
	   $SQL='SELECT DISTINCT folio,nom_prof,DEP_NOM FROM '.$cfg['EncuestasAlumnos'].' INNER JOIN ConvertirDeptosaClave ON depto=CDC_CVE INNER JOIN '.$cfg['DDEP'].' ON CDC_DEP=DEP_CVE WHERE folio="'.$prof.'";';
	   $dEncuestas=new ClassConsulta($SQL,$conexion);
		$numero      ="";
		$nombre      ="";
		$departamento="";			
		if($Registro=$dEncuestas->fila())
	   {  $numero      =$Registro['folio'];
			$nombre      =$Registro['nom_prof'];
			$departamento=$Registro['DEP_NOM'];
		}
		$encabezado="Evaluación Docente $semestre de $año | Folio: $numero | Nombre: $nombre";
	
///Arreglo de objetos que serán desbloqueados en la captura de la encuesta.
?><script language="Javascript">var aDesbloquear=["INPUT"];</script>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <head>
      <title><?php echo $encabezado;?></title>
      
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
   </head>
   <body class="fondo" oncontextmenu="return false" style="font-family:SoberanaSans;">
<?php 
   $encabezado="<b>SEP</b>    RESULTADOS DE LA EVALUACION DE LOS PROFESORES<br>".
               "AÑO $año, APLICACION DE $semestre<br>".
               "CUESTIONARIO PARA ALUMNOS<br>".
               "$tec<br>";
   $aplicacion="REPORTE DE ALUMNOS POR PROFESOR";
	$imprimir=true;
	include("estilo/header.php");
	unset($imprimir);
		
///Inicia la gráfica.
   echo "<div class='wraper'>";
   echo "   <center>";
	
   ///Contando total de alumnos del Profesor
		$DEPTOS        =$cfg["DDEP"];
		$PROFESORES    =$cfg["DCAT"];
		$GRUPOS        =$cfg["DGAU"];
		$MATERIAS      =$cfg["DRET"];
		$LISTAS        =$cfg["DLIS"];
		$tblEncuestas  =$cfg['baseañoperiodo']."EncuestasAlumnos";
		$tblRegistrados=$cfg['baseañoperiodo']."EncuestasRegistradosAlu";
		
	///Filtrando las encuestas del Profesor 
	   $SQL="SELECT DEP_NOM, CAT_CVE AS Folio,CAT_NOM AS Nombre, CONCAT(GPO_MAT,'-',GPO_GPO) AS Clave, RET_NOM AS Materia, LIS_CTR AS Alumno, alumno As Encuesta ".
			  "FROM $PROFESORES INNER JOIN $DEPTOS ON CAT_DEP=DEP_CVE ".
			  "                 INNER JOIN $GRUPOS ON CAT_CVE=GPO_CAT ".
			  "                 INNER JOIN $MATERIAS ON GPO_MAT=RET_CVE ".
			  "                 INNER JOIN $LISTAS ON GPO_MAT=LIS_MAT AND GPO_GPO=LIS_GPO ".
			  "                 LEFT  JOIN $tblRegistrados ON LIS_CTR=alumno AND LIS_MAT=materia AND LIS_GPO=grupo ".
			  "WHERE CAT_CVE='$prof' AND LEFT(LIS_CTR,1)='M' AND alumno IS NULL ".
			  "ORDER BY CAT_CVE,GPO_MAT,GPO_GPO,LIS_CTR;";	  
	   $dEncuestas=new ClassConsulta($SQL,$conexion);	
		
	///Preparando los datos para generar una sola ([*Esto puede omitirse*]o dos) gráfica.   
		$contador=0;
		$contadores=array();
		$columnas=array("MATERIA/ALUMNOS QUE FALTA LA ENCUESTA");
		$totales =array(); $mat="";
		while($Registro=$dEncuestas->fila())
	   {  if($contador==0)
		   {  $numero      =$Registro['Folio'];
				$nombre      =$Registro['Nombre'];
				$departamento=$Registro['DEP_NOM'];
			}
			if($Registro['Clave']!=$mat)
			{  $mat=$Registro['Clave'];
			   $contadores[$contador][$columnas[0]]=$mat."-".$Registro['Materia'];
				$contador++;
			}
			$contadores[$contador][$columnas[1]]=$Registro['Alumno'];
			$contador++;
		///Prepara las variables de los datos del Departamento e inicializa los acumuladores.
		}
		
	///Genera la Estadística
		require("indexFaltantesResultados.php");
   unset($cfg);  
}
?>