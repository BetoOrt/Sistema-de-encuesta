<?php
/***********************************************************
************************************************************   
        indexGraficarDepto.php
************************************************************
***********************************************************/
   session_start();
	include("class/conexionesDB.php"); include("evaldocAutentica.php"); 
	
if(!isset($_SESSION["Iniciada"]) || $_SESSION["Iniciada"]!="Iniciada")
{	GuardarFallo("Index-GrafPla");
	die;
}
else
{//Arreglo de objetos que ser�n desbloqueados en la captura de la encuesta.
?><script language="Javascript">var aDesbloquear=["INPUT"];</script>

<html>
   <head>
      <title>Evaluaci�n Docente <?php echo $a�o;?></title>
      
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
   include("configuracion.php"); $semestre=strtoupper($cfg['semestre']); $a�o=$cfg['a�o']; $tec=strtoupper($cfg['instituto']); $lema=$cfg['lema']; $index=$cfg['index'];
	$encabezado="<b>SEP</b>    RESULTADOS DE LA EVALUACION DE LOS PROFESORES    <b>SES-TNM</b><br>".
               "A�O $a�o, APLICACION DE $semestre<br>".
               "CUESTIONARIO PARA ALUMNOS DE POSGRADO<br>".
               "INSTITUTO TECNOLOGICO $tec<br>";
   $aplicacion="REPORTE POR PLANTEL";
	$imprimir=true;
	include("estilo/header.php");
	unset($imprimir);
		
///Inicia la gr�fica.
   echo "<div class='wraper'>";
   echo "   <center>";
   
	///Filtrando las encuestas del Profesor 
	   $conexion=new ClassConexion_DB($cfg['usuario'],$cfg['password'],$cfg['base'],"mysql",$cfg['host']);
	   $SQL='SELECT DEP_NOM,respuestas FROM '.$cfg['EncuestasPosgrado'].' INNER JOIN ConvertirDeptosaClave ON depto=CDC_CVE INNER JOIN '.$cfg['DDEP'].' ON CDC_DEP=DEP_CVE WHERE plantel="'.$_POST["grafPlantel"].'" ORDER BY folio;';
	   $dEncuestas=new ClassConsulta($SQL,$conexion);	
		
	///Preparando los datos para generar una sola ([*Esto puede omitirse*]o dos) gr�fica.   
		unset($comentario);
		unset($departamento);
		unset($numero);
		$dep_acum=array();
		$largo   =0;
		$isInicio=1;
		$contador=0;
		$contadores=array();
		$columnas=array("PLANTEL","EVALUARON");
		while($Registro=$dEncuestas->fila())
	   {  $doc_resp=$Registro['respuestas'];
			$contador++;  
					   
		///Prepara las variables de los datos del Departamento e inicializa los acumuladores.
			if($isInicio==1)
			{  $isInicio=0;
				$largo       =strlen($doc_resp);
				$departamento="INSTITUTO TECNOLOGICO $tec";
				for($i=0;$i<$largo;$i++)
				{  $dep_acum[$i]["suma"]=0;
					$dep_acum[$i]["cont"]=0;
				}
			}
			
		///Calcula las suma y el contador totales.
			for($i=0;$i<$largo;$i++)
			{  $doc_let=substr($doc_resp,$i,1);
				if($doc_let!="N") //Si el rubro est� aplicado.
				{  $Inc=5-strpos("ABCDE",$doc_let); //A:5, B=4, C:3, D:2, E:1
					$dep_acum[$i]["suma"]+=$Inc;
					$dep_acum[$i]["cont"]++;
				}
			}  
		}		
		$contadores["TOTAL DE ALUMNOS:"]=$contador;
			
	///Calcula la letra para el plantel seg�n el promedio alcanzado.
		$global_prom=array();
		for($i=0;$i<$largo;$i++)
		{//Promedia la suma entre el contador.
			$prom=($dep_acum[$i]["cont"]>0?($dep_acum[$i]["suma"]/$dep_acum[$i]["cont"]):0);
			$global_prom[$i]=$prom;
		}
		
	///Genera la Gr�fica de Barras
		require("indexGraficaBarras.php");
   unset($cfg);  
}
?>