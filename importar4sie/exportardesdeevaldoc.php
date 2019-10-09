<?php
//http://localhost/evaldoc2sie/dat.php
session_start();
?>
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

<?php
if(isset($_SESSION["exportacion"]) && $_SESSION["exportacion"]=="Si")
{   $_SESSION["exportacion"]="No";

    $host=isset($_POST["host"])?$_POST["host"]:"";
	$user=isset($_POST["user"])?$_POST["user"]:"";
	$pass=isset($_POST["pass"])?$_POST["pass"]:"";
	$año =isset($_POST["año"])?$_POST["año"]:(isset($_SESSION["año"])?$_SESSION["año"]:"");
	$mes =isset($_POST["mes"])?$_POST["mes"]:(isset($_SESSION["mes"])?$_SESSION["mes"]:"");
	$_SESSION["año"]=$año;
	$_SESSION["mes"]=$mes;
	
	//echo $host.",".$user.",".$pass.",".$año.",".$mes."<br />";

	$semestre ="$año$mes";
	$basedatos="evaldoc$semestre";
	$prefijo  =$basedatos.".".$semestre;
	
	$con=@mysql_connect($host,$user,$pass) or include("index.php");
	if($con)
	{	echo "Conectado al Servidor<br />";
		echo "Conectado a la base de datos: $basedatos ...<br />";
		$db=mysql_select_db($basedatos,$con) or die("Error al conectar: $basedatos");
		if($db)
		{  echo "Base de Datos seleccionada: $basedatos<br />";
		   run("TRUNCATE TABLE ".$prefijo."EncuestasAlumnosFiltrada;","Truncando Filtrada.");
			run("INSERT INTO ".$prefijo."EncuestasAlumnosFiltrada"
			     ."(   SELECT * FROM ".$prefijo."EncuestasAlumnos WHERE nom_prof NOT LIKE '%ACADEMIA%' AND nom_prof NOT LIKE  '%NECESIDAD%');","Copiando a Filtrada");

			
			crear("evalum",array(array("PERIODO", "C", 3),
                              array("CARRERA", "C", 3),
                              array("FOLIO", "C", 4),
                              array("NOM_PROF", "C", 40),
                              array("MATERIA", "C", 3),
                              array("DEPTO", "N", 1, 0),
                              array("CICLO", "C", 1),
                              array("SEMESTRE", "C", 2),
                              array("RESPUESTA", "C", 80),
                              array("NUM_CUES", "C", 5)),$semestre);
			exportar("evalum","EncuestasAlumnosFiltrada",
                           array("`periodo`",
                                 "`carrera`",
                                 "`folio`",
                                 "`nom_prof`",
                                 "`materia`",
                                 "`depto`",
                                 "`ciclo`",
                                 "`semestre`",
                                 "`respuestas`",
                                 "`numcues`"),$semestre);
			run("TRUNCATE TABLE ".$prefijo."EncuestasAlumnosPorcentaje;","Truncando Porcentaje.");
			run("INSERT INTO ".$prefijo."EncuestasAlumnosPorcentaje"
				."(   SELECT periodo,ciclo,maestro,evaluados,total,CAST(evaluados*100/total AS DECIMAL(6,2)) AS porcent"
				."    FROM"
				."    (   SELECT periodo,ciclo,folio as maestro,CAST(folio AS DECIMAL(4,0)) AS fol,COUNT(numcues) AS evaluados"
				."        FROM ".$prefijo."EncuestasAlumnosFiltrada"
				."        GROUP BY folio"
				."    ) a,"
				."    (   SELECT GPO_CAT, COUNT(LIS_CTR) as total"
				."        FROM       ".$prefijo."DGAU"
				."        INNER JOIN ".$prefijo."DLIS"
				."           ON LIS_MAT=GPO_MAT AND LIS_GPO=GPO_GPO"
				."        GROUP BY GPO_CAT"
				."    ) b"
				."    WHERE fol=GPO_CAT AND maestro>0"
				.");","LLenando porcentaje.");
			crear("porcent",array(array("PERIODO", "C", 3),
                               array("CICLO", "C", 1),
                               array("MAESTRO", "C", 4),
                               array("EVALUADOS", "C", 4),
                               array("TOTAL", "C", 4),
                               array("PORCENT", "C", 6)),$semestre);
			exportar("porcent","EncuestasAlumnosPorcentaje",
                           array("`PERIODO`",
                                 "`CICLO`",
                                 "`MAESTRO`",
                                 "`EVALUADOS`",
                                 "`TOTAL`",
                                 "`PORCENT`"),$semestre);
			/*exportar2("porcent","EncuestasAlumnos",
                            array("`periodo`",
                                  "`ciclo`",
                                  "`folio`"),
                            "EncuestasAlumnosPorcentaje",
                            array("`PORCENTAJE`"),"folio=MAESTRO",$semestre);*/
		   crear("dcat",array(array("CAT_CVE", "N", 4,0),
                               array("CAT_DEP", "N", 3,0),
                               array("CAT_NOM", "C", 40)),$semestre);		
		   exportar("dcat","DCAT",
                           array("`CAT_CVE`",
                                 "`CAT_DEP`",
                                 "`CAT_NOM`"),$semestre);
								 
			/*crear("evasdoc",array(array("periodo", "C", 3),
                              array("carrera", "C", 3),
                              array("folio", "C", 4),
                              array("nom_prof", "C", 40),
                              array("materia", "C", 3),
                              array("depto", "C", 1),
                              array("ciclo", "C", 1),
                              array("semestre", "C", 2),
                              array("respuesta", "C", 80),
                              array("num_cues", "C", 5) ),$semestre);*/		

            /*crear("evasdoc",array(array("PERIODO", "C", 4),
  	                        array("PLANTEL", "C", 40),
                            array("CARRERA", "C", 3),
                            array("FOLIO", "N", 4,0),
                            array("NOM_PROF", "C", 40),
                            array("MATERIA", "C", 3),
                            array("DEPTO", "C", 1),
                            array("CICLO", "C", 2),
                            array("ESTADO", "C", 2),
							array("SEMESTRE", "C", 2),
                            array("NUMCUES", "C", 5),
							array("RESPUESTA", "C", 80)),$semestre);*/
			/*exportarEvalDep("evasdoc","EncuestasDeptos",
                            array("`periodo`",
                                  "`plantel`",
                                  "`carrera`",
                                  "`folio`",
                                  "`nom_prof`",
                                  "`materia`",
                                  "`depto`",
                                  "`ciclo`",
							 	  "`estado`",
                                  "`semestre`",
                                  "`numcues`",
                                  "`respuestas`"),$semestre);*/
								  
			mysql_close();
			
			echo "<br /><br /><font size='+6' color='#6ac36a'>PROCESO TERMINADO CON ÉXITO.</font><br /><br />";
		}
	}
} else include("index.php");

function crear($tabla,$estructura,$semestre)
{   $ruta="$semestre/";
	$destino=$ruta.$tabla.$semestre.".dbf";
	echo "<br />Creando...tabla=$destino<br />ESTRUCTURA:$estructura<br />";
	$dbf=dbase_create($destino, $estructura) or die("Error, no se puede crear la tabla:".$destino."\n");
	dbase_close($dbf);
	echo "Tabla creada.<br /><br />";
}

function exportar($destino,$origen,$campos,$semestre)
{	$ruta="$semestre/";
	$origen =$semestre.$origen;
	$destino=$ruta.$destino.$semestre.".dbf";
	echo "<br />Exportando...origen=$origen al destino=$destino<br />";
  
	$sql="SELECT ".implode(",", $campos)." FROM ".$origen.";";
	echo "<br />SQL:$sql<br />";
	$dInfo=mysql_query($sql) or die("Error al abrir tabla de mysql.1");
	echo "Tabla  elegida<br /><br />";
		
	echo "Abriendo DBF: $destino...<br />";
	$dbf=dbase_open($destino, 2) or die("Error al abrir el dbf.");
	if($dbf) 
	{  echo "DBF $destino abierto con el ID:$dbf<br />";
	 $número_registros=@mysql_num_rows($dInfo);
		$número_campos   =@mysql_num_fields($dInfo);
	 $reg=0; echo "Procesando: $número_registros registros con $número_campos campos...<br />"; 
	 while($fila=mysql_fetch_array($dInfo))
	 {  $registro=array(); for($i=0;$i<count($campos);$i++) $registro[$i]=$fila[$i];
		//echo ($reg++).":".str_replace(" ","_",implode(",",$registro))."<br />";
		echo ($reg++).",";
		dbase_add_record($dbf,$registro);
		if($reg>0 && $reg%100==0)echo "<br />";
	 }
		dbase_close($dbf);
	}
	echo "<br />Terminado...$destino<br /><br />";
}

function run($sql, $msg)
{  echo "<br />Corriendo...consulta=$sql<br />";
   $dInfo=mysql_query($sql) or die("Error al correr: $msg<br />".mysql_error());
   echo "Consulta Corrida.<br /><br />";
}
/*function exportar2($destino,$origen,$campos,$origen2,$campos2,$igualdad,$semestre) //OJO IGUALDAD
{	$ruta="$semestre/";
	$origen =$semestre.$origen;
    $origen2=$semestre.$origen2;
	$destino=$ruta.$destino.$semestre.".dbf";
	echo "<br />Exportando...origen=$origen al destino=$destino<br />";
  
	$sql="SELECT DISTINCT ".implode(",", $campos).",".implode(",", $campos2)." FROM ".$origen.",".$origen2." WHERE ".$igualdad.";";
	echo "<br />SQL:$sql<br />";
	$dInfo=mysql_query($sql) or die("Error al abrir tabla de mysql");
	echo "Tabla  elegida<br /><br />";
		
	echo "Abriendo DBF: $destino...<br />";
	$dbf=dbase_open($destino, 2) or die("Error al abrir el dbf.");
	if($dbf) 
	{  echo "DBF $destino abierto con el ID:$dbf<br />";
	 $número_registros=@mysql_num_rows($dInfo);
		$número_campos   =@mysql_num_fields($dInfo);
	 $reg=0; echo "Procesando: $número_registros registros con $número_campos campos...<br />"; 
	 while($fila=mysql_fetch_array($dInfo))
	 {  $registro=array(); for($i=0;$i<count($campos)+count($campos2);$i++) $registro[$i]=$fila[$i];
		//echo ($reg++).":".str_replace(" ","_",implode(",",$registro))."<br />";
		echo ($reg++).",";
		dbase_add_record($dbf,$registro);
		if($reg>0 && $reg%100==0)echo "<br />";
	 }
		dbase_close($dbf);
	}
	echo "<br />Terminado...$destino<br /><br />";
}*/

function exportarEvalDep($destino,$origen,$campos,$semestre)
{	$ruta="$semestre/";
	$origen =$semestre.$origen;
	$destino=$ruta.$destino.$semestre.".dbf";
	echo "<br />Exportando...origen=$origen al destino=$destino<br />";
	
	$sql="SELECT ".implode(",", $campos)." FROM ".$origen." WHERE cancelado='0';"; //se agrego cancelado =0 para filtrar los 	registros correctos
	echo "<br />SQL:$sql<br />";
	$dInfo=mysql_query($sql) or die("Error al abrir tabla de mysql");
	echo "Tabla  elegida<br /><br />";
		
	echo "Abriendo DBF: $destino...<br />";
	$dbf=dbase_open($destino, 2) or die("Error al abrir el dbf.");
	if($dbf) 
	{  echo "DBF $destino abierto con el ID:$dbf<br />";
	 $número_registros=@mysql_num_rows($dInfo);
		$número_campos   =@mysql_num_fields($dInfo);
	 $reg=0; echo "Procesando: $número_registros registros con $número_campos campos...<br />"; 
	 while($fila=mysql_fetch_array($dInfo))
	 {  $registro=array(); for($i=0;$i<count($campos);$i++) $registro[$i]=$fila[$i];
		//echo ($reg++).":".str_replace(" ","_",implode(",",$registro))."<br />";
		echo ($reg++).",";
		dbase_add_record($dbf,$registro);
		if($reg>0 && $reg%100==0)echo "<br />";
	 }
		dbase_close($dbf);
	}
	echo "<br />Terminado...$destino<br /><br />";
}
?> 
