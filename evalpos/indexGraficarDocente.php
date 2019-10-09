<?php
/***********************************************************
************************************************************   
        indexGraficarDocente.php
************************************************************
***********************************************************/
   session_start();
	include("class/conexionesDB.php"); include("evaldocAutentica.php"); 
	
if(!isset($_SESSION["Iniciada"]) || $_SESSION["Iniciada"]!="Iniciada")
{	GuardarFallo("Index-GrafDoc");
	die;
}
else
{  include("configuracion.php"); $semestre=strtoupper($cfg['semestre']); $año=$cfg['año']; $tec=strtoupper($cfg['instituto']); $lema=$cfg['lema']; $index=$cfg['index'];

	///Filtrando las encuestas del Profesor 
	   $conexion=new ClassConexion_DB($cfg['usuario'],$cfg['password'],$cfg['base'],"mysql",$cfg['host']);
	
	   $SQL='SELECT DISTINCT folio,nom_prof,DEP_NOM FROM '.$cfg['EncuestasPosgrado'].' INNER JOIN ConvertirDeptosaClave ON depto=CDC_CVE INNER JOIN '.$cfg['DDEP'].' ON CDC_DEP=DEP_CVE WHERE folio="'.$_POST["grafProf"].'";';
	   $dEncuestas=new ClassConsulta($SQL,$conexion);
		$numero      ="";
		$nombre      ="";
		$departamento="";			
		if($Registro=$dEncuestas->fila())
	   {  $numero      =$Registro['folio'];
			$nombre      =$Registro['nom_prof'];
			$departamento=$Registro['DEP_NOM'];
		}
		$encabezado="Evaluación Docente:Posgrado $semestre de $año | Folio: $numero | Nombre: $nombre";
	
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
               "CUESTIONARIO PARA ALUMNOS DE POSGRADO<br>".
               "$tec<br>";
   $aplicacion="REPORTE POR PROFESOR";
	$imprimir=true;
	include("estilo/header.php");
	unset($imprimir);
		
///Inicia la gráfica.
   echo "<div class='wraper'>";
   echo "   <center>";
   
	///Filtrando las encuestas del Profesor 
	   $SQL='SELECT DEP_NOM,folio,nom_prof,depto,materia,respuestas FROM '.$cfg['EncuestasPosgrado'].' INNER JOIN ConvertirDeptosaClave ON depto=CDC_CVE INNER JOIN '.$cfg['DDEP'].' ON CDC_DEP=DEP_CVE WHERE folio="'.$_POST["grafProf"].'" ORDER BY materia;';
	   $dEncuestas=new ClassConsulta($SQL,$conexion);
		
		
	///Preparando los datos para generar una sola ([*Esto puede omitirse*]o dos) gráfica.   
		unset($comentario); 
		unset($departamento);
		unset($numero);
		$largo   =0;
		$isInicio=1;
		$doc_acum=array();
		$contador=0;
		$contadores=array();
		$columnas=array("MATERIA","EVALUARON");
		while($Registro=$dEncuestas->fila())
	   {  $doc_resp=$Registro['respuestas'];
			$contador++;  
		   if(!isset($contadores[$Registro['materia']]))$contadores[$Registro['materia']]=0;
			$contadores[$Registro['materia']]++;
		///Prepara las variables de los datos del Departamento e inicializa los acumuladores.
			if($isInicio==1)
			{  $isInicio=0;
				$largo       =strlen($doc_resp);
				$numero      =$Registro['folio'];
				$nombre      =$Registro['nom_prof'];
				$departamento=$Registro['DEP_NOM'];
				for($i=0;$i<$largo;$i++)
				{  $doc_acum[$i]["suma"]=0;
					$doc_acum[$i]["cont"]=0;
				}
			}
			
		///Calcula las suma y el contador totales.
			for($i=0;$i<$largo;$i++)
			{  $doc_let=substr($doc_resp,$i,1);
				if($doc_let!="N") //Si el rubro está aplicado.
				{  /*$Inc=($i==25)
				          ?strpos("ABCDE",$doc_let)
							 :(5-strpos("ABCDE",$doc_let)); //A:5, B=4, C:3, D:2, E:1*/
					$Inc=5-strpos("ABCDE",$doc_let); //A:5, B=4, C:3, D:2, E:1
					$doc_acum[$i]["suma"]+=$Inc;
					$doc_acum[$i]["cont"]++;
				}
			}  
		}
		$contadores["TOTAL DE ALUMNOS:"]=$contador;
		
	///Calcula la letra para el plantel según el promedio alcanzado.
		$global_prom=array();
		for($i=0;$i<$largo;$i++)
		{//Promedia la suma entre el contador.
			$prom=($doc_acum[$i]["cont"]>0?($doc_acum[$i]["suma"]/$doc_acum[$i]["cont"]):0);
			$global_prom[$i]=$prom;
		}
		
	///Genera la Gráfica de Barras
		require("indexGraficaBarras.php");
		
		$encabezado="$tec";
	   $aplicacion="Encuesta de Opinión del Estudiante ($semestre de $año)<br>";
		require("indexGraficaComentarios.php");
   unset($cfg);  
}
?>