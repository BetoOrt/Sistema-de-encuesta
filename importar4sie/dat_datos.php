<?php
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
   function Salir() { document.location.href="dat.php"; }
</script>
<style type="text/css" media="print">
   html { display:none; }
</style>

<?php
include("configuracion.php");
if(isset($_SESSION["manejo"]) && $_SESSION["manejo"]=="Si")
{  $_SESSION["manejo"]="No";

	$year =isset($_POST["year"])?$_POST["year"]:"";
	$month =isset($_POST["month"])?$_POST["month"]:"";
	$_SESSION["year"]=$year;
	$_SESSION["month"]=$month;
	
	$semestre ="$year$month";
	$siedbf   ="$semestre/sie/dbf/";    //esta es la ruta de la tablas del SIE en formato dbf
	$siecsv   ="$semestre/sie/csv/";    //esta es la ruta de la tablas del SIE en formato csv
   $preguntas="$semestre/preguntas/";  //esta es la ruta de la tablas de EVALDOC
	
	
	mostrarCSV("<font size='+3' color='blue'>PREGUNTAS RUBROS ALUMNOS</font><br/>",$preguntas,"PreguntasRubros",array(100,100));
   mostrarCSV("<font size='+3' color='blue'>PREGUNTAS ALUMNOS</font><br/>",       $preguntas,"Preguntas",array(100,100,100));
	
	/*expDBF2CSV($siedbf,$siecsv,"DALU","ALU_PAS");
	expDBF2CSV($siedbf,$siecsv,"DCAT");
	expDBF2CSV($siedbf,$siecsv,"DDEP");
	expDBF2CSV($siedbf,$siecsv,"DESP");
	expDBF2CSV($siedbf,$siecsv,"DGAU");
	expDBF2CSV($siedbf,$siecsv,"DLIS");
	expDBF2CSV($siedbf,$siecsv,"DPLA");
	expDBF2CSV($siedbf,$siecsv,"DRET");*/
	
   validar("<font size='+3' color='blue'>CONVERSIONES DEPTOS</font><br/>",  $siecsv,"DDEP",$deptos);
	validar("<font size='+3' color='blue'>CONVERSIONES CARRERAS</font><br/>",$siecsv,"DESP",$carreras);
	echo '<br /><br /><input name="bSalir" class="btn btn-success" style="width:200px" type="submit" value="Regresar" onClick="Salir()"><br><br>'; 
	
} else include("index.php");

function validar($letrero,$ori,$tabla,$datos)
{  $origen=$ori.$tabla.".CSV";
	echo "$letrero<br/>Mostrando...origen=$origen<br/>";
	
	echo "Abriendo CSV: $origen...</br>";
	
	$csv=csv_to_array($origen); 
	if($csv==NULL) die("ERROR de CSV: No se encontraron datos en: $origen...</br>");
	else
   {  $header=1;  $listaEncontrados=""; $listaNOencontrados="";
	   echo "<table border=1>";
      foreach($csv as $registro) 
      {  if($header==1)
         {  echo "<tr>";
            foreach($registro as $clave => $valor)echo "<th>$clave</th>";
            echo "</tr>";
            $header=0;
         }
         echo "<tr>"; 
         foreach($registro as $valor)echo "<td>$valor&nbsp;</td>";
         echo "</tr>";
			
			//Validando
			if($tabla=="DDEP")
			{  $encontrado=false; $depcve="";
				foreach($datos as $d => $dep) if($registro["DEP_CVE"]==$dep[0]){$encontrado=true; $depcve=$dep[1];}
			   if(!$encontrado) $listaNOencontrados.="<font size='+2' color='#c36a6a'>EL Depto: ".$registro["DEP_CVE"]." NO fue encontrado en la tabla de conversiones.</font><br />";
			   else             $listaEncontrados  .="<font size='+2' color='#6ac36a'>EL Depto: ".$registro["DEP_CVE"]." fue encontrado en la tabla de conversiones y asociado al cat&aacute;logo general como: $depcve.</font><br />";
			}
			else if($tabla=="DESP")
			{  $encontrado=false; $carcve="";
			   foreach($datos as $c => $car) if($registro["ESP_CVE"]==$car[0]){$encontrado=true; $carcve=$car[1];}
			   if(!$encontrado) $listaNOencontrados.="<font size='+2' color='#c36a6a'>La carrera: ".$registro["ESP_CVE"]." NO fue encontrada en la tabla de conversiones.</font><br />";
			   else             $listaEncontrados  .="<font size='+2' color='#6ac36a'>La carrera: ".$registro["ESP_CVE"]." fue encontrada en la tabla de conversiones y asociada al cat&aacute;logo general como: $carcve.</font><br />";
			}
			
      }
      echo "</table>";
		if($listaNOencontrados!="") die($listaNOencontrados);
		else                        echo $listaEncontrados;
		if     ($tabla=="DDEP") echo "<br />Deptos Validados.<br/>";
		else if($tabla=="DESP") echo "<br />Carreras Validadas.<br/>";
   }
	echo "<br/>Terminado...$origen<br/><br/><br/>";
}

function mostrarCSV($letrero,$ori,$tabla,$tamanos)
{  $origen=$ori.$tabla.".csv";
	echo "$letrero<br/>Mostrando...origen=$origen<br/>";
	
	echo "Abriendo DBF: $origen...</br>";
	$csv=csv_to_array($origen); 
   if($csv==NULL) die("ERROR de CSV: No se encontraron datos en: $origen...</br>");
	else
   {  $header=1;
      echo "<table border=1>";
      foreach($csv as $registro) 
      {  if($header==1)
         {  echo "<tr>"; $i=0;
            foreach($registro as $clave => $valor){echo "<th style='max-width:".(isset($tamanos[$i])?$tamanos[$i]:300)."px'>$clave</th>"; $i++;}
            echo "</tr>";
            $header=0;
         }
         echo "<tr>"; $i=0;
         foreach($registro as $valor){echo "<td style='max-width:".(isset($tamanos[$i])?$tamanos[$i]:300)."px'>$valor&nbsp;</td>"; $i++;}
         echo "</tr>";
      }
      echo "</table>";
   }
	echo "<br/>Terminado...$origen<br/><br/><br/>";

}

function csv_to_array($filename='', $delimiter=',')
{   $data = array();
    if(file_exists($filename) && is_readable($filename))
    {  $header=NULL;
       $data  =array();
       if (($handle = fopen($filename, 'r')) !== FALSE)
       {   //$i=0;
           while (($row = fgetcsv($handle, 2000, $delimiter)) !== FALSE)
           {
               if(!$header)
                   $header = $row;
               else
               {  //$i++; echo "$i<br/>";
                  $data[] = array_combine($header, $row);
               }
           }
           fclose($handle);
       }
    }
    return $data;
}

function expDBF2CSV($ori,$des,$tabla,$encriptar="")
{  $origen =$ori.$tabla.".DBF";
	$destino=$des.$tabla.".CSV";
	echo "<br/>Exportando...origen=$origen<br/>";
	
	echo "Abriendo DBF: $origen...</br>";
	$dbf=dbase_open($origen, 0) or die("Error al abrir el dbf.");
	echo "DBF $origen abierto con el ID:$dbf</br>";
	
	if($dbf) 
	{//Creando la Lista de datos como arreglo
		$lista=array();
		$numero_registros=dbase_numrecords     ($dbf);
	   $numero_campos   =dbase_numfields      ($dbf);
		$nombre_campos   =dbase_get_header_info($dbf);
		$encabezado=array(); for($j=0; $j<$numero_campos; $j++)array_push($encabezado,$nombre_campos[$j]["name"]);
		array_push($lista,$encabezado);
		
		for($i=1; $i<=$numero_registros; $i++)
		{  $fila=dbase_get_record($dbf, $i); 
			$registro=array(); 
			for($j=0; $j<$numero_campos; $j++){
				$fila[$j]=str_replace("'","´",$fila[$j]); 
				$fila[$j]=str_replace('"',"´",$fila[$j]); 
				array_push($registro,trim($nombre_campos[$j]["name"]==$encriptar?md5(trim($fila[$j])):$fila[$j]));}
			array_push($lista,$registro);
		}
		dbase_close($dbf);
		
		///Mostrando la lista
		print_r($lista);
		
		///Creando el CSV
		$fp = fopen(strtolower($destino), 'w');
		foreach ($lista as $registro) 
		{  fputcsv($fp, $registro);
		}
		fclose($fp);
	}
	echo "<br/>Terminado...$origen<br/><br/><br/>";
}
?>