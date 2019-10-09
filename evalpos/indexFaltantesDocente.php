<?php
/***********************************************************
************************************************************   
        indexFaltantesDocente.php
************************************************************
***********************************************************/
   session_start();
	include("class/conexionesDB.php"); include("evaldocAutentica.php"); 
	
if(!isset($_SESSION["Iniciada"]) || $_SESSION["Iniciada"]!="Iniciada")
{	GuardarFallo("Index-FaltDoc");
	die;
}
else
{  include("configuracion.php"); $semestre=strtoupper($cfg['semestre']); $año=$cfg['año']; $tec=strtoupper($cfg['instituto']); $lema=$cfg['lema']; $index=$cfg['index'];

	///Filtrando las encuestas del Profesor 
	   $conexion=new ClassConexion_DB($cfg['usuario'],$cfg['password'],$cfg['base'],"mysql",$cfg['host']);
		
		$prof=strval($_POST["faltantesProf"]);
	
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
   $encabezado="<b>SEP</b>    RESULTADOS DE LA EVALUACION DE LOS PROFESORES <br>".
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
		$LISTAS        =$cfg["DLIS"];
		$tblEncuestas  =$cfg['baseañoperiodo']."Encuestasposgrado";
		$tblRegistrados=$cfg['baseañoperiodo']."EncuestasRegistradospos";
		
	///Filtrando las encuestas del Profesor 
	   $SQL="SELECT DEP_NOM, CAT_CVE AS Folio,CAT_NOM AS Nombre,CONCAT(GPO_MAT,'-',GPO_GPO) AS Materia, ".
			  "		 (SELECT COUNT(LIS_CTR) FROM $LISTAS WHERE GPO_MAT=LIS_MAT AND GPO_GPO=LIS_GPO) AS Total, ".
			  "		 (SELECT COUNT(alumno)  FROM $tblRegistrados WHERE GPO_MAT=materia AND GPO_GPO=grupo)                    AS Evaluaron ".
			  "FROM $PROFESORES INNER JOIN $GRUPOS ON CAT_CVE=GPO_CAT ".
			  "                 INNER JOIN $DEPTOS ON CAT_DEP=DEP_CVE ".
			  "WHERE CAT_CVE='$prof' ".
			  "GROUP BY CAT_CVE,GPO_MAT,GPO_GPO;";	
			  //echo $SQL;  
	   $dEncuestas=new ClassConsulta($SQL,$conexion);	
		
	///Preparando los datos para generar una sola ([*Esto puede omitirse*]o dos) gráfica.   
		$contador=0;
		$contadores=array();
		$columnas=array("MATERIA","TOTAL","EVALUARON","FALTANTES","PORCENTAJE");
		$totales =array(0,0,0,0,0);
		while($Registro=$dEncuestas->fila())
	   {  if($contador==0)
		   {  $numero      =$Registro['Folio'];
				$nombre      =$Registro['Nombre'];
				$departamento=$Registro['DEP_NOM'];
			}
			if($Registro['Total']>0)
			{  $contadores[$contador][$columnas[0]]=$Registro['Materia'];
					$totales[0]++; 
				$contadores[$contador][$columnas[1]]=$Registro['Total'];
					$totales[1]+=$contadores[$contador][$columnas[1]]; 
				$contadores[$contador][$columnas[2]]=$Registro['Evaluaron'];
					$totales[2]+=$contadores[$contador][$columnas[2]]; 
				$contadores[$contador][$columnas[3]]=$Registro['Total']-$Registro['Evaluaron'];
					$totales[3]+=$contadores[$contador][$columnas[3]];
				$contadores[$contador][$columnas[4]]=sprintf("%.2f",($Registro['Evaluaron']/$Registro['Total'])*100)."%";
				$contador++;
			}
		///Prepara las variables de los datos del Departamento e inicializa los acumuladores.
		}
		$totales[4]=sprintf("%.2f",($totales[2]/$totales[1])*100)."%";
		
	///Genera la Estadística
		require("indexFaltantesResultados.php");
   unset($cfg);  
}
?>