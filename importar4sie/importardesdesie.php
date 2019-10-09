<?php
//http://localhost/evaldoc2sie/sie2evaldoc.php
session_start(); include("configuracion.php"); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
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
</head>
<body>
<?php
echo $_SESSION["importacion"];
if(isset($_SESSION["importacion"]) && $_SESSION["importacion"]=="Si")
{  $_SESSION["importacion"]="No";

	$host=isset($_POST["host"])?$_POST["host"]:"";
	$user=isset($_POST["user"])?$_POST["user"]:"";
	$pass=isset($_POST["pass"])?$_POST["pass"]:"";
	$year =isset($_POST["year"])?$_POST["year"]:(isset($_SESSION["year"])?$_SESSION["year"]:"");
	$month =isset($_POST["month"])?$_POST["month"]:(isset($_SESSION["month"])?$_SESSION["month"]:"");
	$_SESSION["year"]=$year;
	$_SESSION["month"]=$month;
   
   $pass=str_replace("'","",$pass); $pass=str_replace('"',"",$pass);
	
	//echo $host.",".$user.",".$pass.",".$año.",".$mes."<br />";
		
	$semestre ="$year$month";
	$basedatos="evaldoc$semestre";	
	$siecsv   ="$semestre/sie/csv/";    //esta es la ruta de las tablas del sie en formato CSV
	$ed       ="$semestre/preguntas/";  //esta es la ruta de las tablas de evaldoc en formato CSV
   
	$con=@mysql_connect($host,$user,$pass) or include("index.php");
	if($con)
	{  echo "Conectando al Servidor: ...<br />";
		$_SESSION["intentos"]=0;
		echo "Conectado al Servidor: $host<br />";
	   $sql = "CREATE DATABASE $basedatos;";
		$db  = mysql_query($sql, $con) or die("Error al crear Base de Datos. La base de datos ya existe.");
		if($db){ echo "Base de Datos: $basedatos creada.<br />"; 
		         $db=mysql_select_db($basedatos,$con) or die("Error al conectar a la Base de Datos.");
			    }
		if($db)
		{  echo "Base de Datos seleccionada: $basedatos<br />";
			importarCSV($siecsv,"DALU","(`ALU_CTR` varchar(10) NOT NULL,
												  `ALU_NOM` varchar(40) DEFAULT NULL,
												  `ALU_ESP` int(11)     DEFAULT NULL,
												  `ALU_PLA` varchar(1)  DEFAULT NULL,
												  `ALU_SEM` int(11)     DEFAULT NULL,
												  `ELE_CRE` bigint(20)  DEFAULT NULL,
												  `ALU_PAS` varchar(32) DEFAULT NULL,
												  PRIMARY KEY (`ALU_CTR`)
												 )",$semestre);
			importarCSV($siecsv,"DCAT","(`CAT_CVE` int(11)     NOT NULL,
												  `CAT_DEP` int(11)     DEFAULT NULL,
												  `CAT_NOM` varchar(40) DEFAULT NULL,
													PRIMARY KEY (`CAT_CVE`)
												 )",$semestre);
			importarCSV($siecsv,"DDEP","(`DEP_CVE` int(11)   NOT NULL DEFAULT '0',
												  `DEP_NOM` char(120) CHARACTER SET utf8 DEFAULT NULL,
												  `DEP_NCO` char(45)  CHARACTER SET utf8 DEFAULT NULL,
													PRIMARY KEY (`DEP_CVE`)
												 )",$semestre,$deptos);
			importarCSV($siecsv,"DESP","(`ESP_CVE` int(11)     NOT NULL,
												  `ESP_NOM` varchar(80) DEFAULT NULL,
												  `ESP_NCO` varchar(15) DEFAULT NULL,
													PRIMARY KEY (`ESP_CVE`)
												 )",$semestre,$carreras);
			importarCSV($siecsv,"DGAU","(`GPO_MAT` varchar(10) NOT NULL,
												  `GPO_GPO` varchar(4)  NOT NULL,
												  `GPO_CAT` int(11)     NOT NULL,
												  `GPO_NUM` int(11)     DEFAULT NULL,
												  `GPO_LHR` int(11)     DEFAULT NULL,
												  `GPO_AUL` varchar(3)  DEFAULT NULL,
													PRIMARY KEY (`GPO_MAT`,`GPO_GPO`,`GPO_CAT`)
												 )",$semestre);
			importarCSV($siecsv,"DLIS","(`LIS_CTR` varchar(9)  NOT NULL,
												  `LIS_MAT` varchar(10) NOT NULL,
												  `LIS_GPO` varchar(4)  NOT NULL,
													PRIMARY KEY (`LIS_CTR`,`LIS_MAT`,`LIS_GPO`)
												 )",$semestre);
			/*importarCSV($siecsv,"DPLA","(`SIEDOS`    varchar(1) NOT NULL,
												  `SIEVISUAL` varchar(3) NOT NULL,
												  `CONSEC`    int(11)    NOT NULL,
													PRIMARY KEY (`SIEDOS`,`SIEVISUAL`,`CONSEC`)
												 )",$semestre);*/
			importarCSV($siecsv,"DRET","(`RET_CVE` varchar(10) NOT NULL,
												  `RET_NOM` varchar(60) DEFAULT NULL,
												  `RET_NCO` varchar(15) DEFAULT NULL,
													PRIMARY KEY (`RET_CVE`)
												 )",$semestre);
			crear("EncuestasAlumnos","(`id`         int(11)      NOT NULL AUTO_INCREMENT,
												`periodo`    char(3)      NOT NULL,
												`plantel`    char(40)     NOT NULL,
												`carrera`    char(3)      NOT NULL,
												`folio`      char(4)      NOT NULL,
												`nom_prof`   char(40)     NOT NULL,
												`materia`    char(4)      NOT NULL,
												`depto`      char(1)      NOT NULL,
												`ciclo`      char(4)      NOT NULL,
												`estado`     char(2)      NOT NULL,
												`semestre`   char(2)      NOT NULL,
												`numcues`    char(5)      NOT NULL,
												`respuestas` varchar(255) NOT NULL,
												`comentario` varchar(255) NOT NULL,
												 PRIMARY KEY (`id`)
											  ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;",$semestre);
			crear("EncuestasRegistradosAlu", "(`alumno`  char(9)  NOT NULL,
														  `materia` char(10) NOT NULL,
														  `grupo`   char(4)  NOT NULL,
														  `ip`      char(15) NOT NULL,
														  `fecha`   char(10) NOT NULL,
														  `hora`    char(8)  NOT NULL,
														  `codigo`  char(32) NOT NULL,
														   PRIMARY KEY (`alumno`,`materia`,`grupo`)
														 ) ENGINE=MyISAM DEFAULT CHARSET=latin1;",$semestre);					
			crear("EncuestasPosgrado","(`id`         int(11)      NOT NULL AUTO_INCREMENT,
												 `periodo`    char(3)      NOT NULL,
												 `plantel`    char(40)     NOT NULL,
												 `carrera`    char(3)      NOT NULL,
												 `folio`      char(4)      NOT NULL,
												 `nom_prof`   char(40)     NOT NULL,
												 `materia`    char(4)      NOT NULL,
												 `depto`      char(1)      NOT NULL,
												 `ciclo`      char(4)      NOT NULL,
												 `estado`     char(2)      NOT NULL,
												 `semestre`   char(2)      NOT NULL,
												 `numcues`    char(5)      NOT NULL,
												 `respuestas` varchar(255) NOT NULL,
												 `comentario` varchar(255) NOT NULL,
												  PRIMARY KEY (`id`)
											   ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;",$semestre);
		   	crear("EncuestasRegistradosPos", "(`alumno`  char(9)  NOT NULL,
														  `materia` char(10) NOT NULL,
														  `grupo`   char(4)  NOT NULL,
														  `ip`      char(15) NOT NULL,
														  `fecha`   char(10) NOT NULL,
														  `hora`    char(8)  NOT NULL,
														  `codigo`  char(32) NOT NULL,
														   PRIMARY KEY (`alumno`,`materia`,`grupo`)
														 ) ENGINE=MyISAM DEFAULT CHARSET=latin1;",$semestre);					
			crear("Fallos", "(`num`     int(11)    NOT NULL AUTO_INCREMENT,
									`donde`   char(50)   NOT NULL,
									`ip`      char(15)   NOT NULL,
									`fecha`   char(10)   NOT NULL,
									`hora`    char(8)    NOT NULL,
									`vigente` tinyint(4) DEFAULT NULL,
									 PRIMARY KEY (`num`)
								  ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;",$semestre);					
			importarCSV($ed,"Preguntas","(`tipo`   char(1)     NOT NULL,
												   `rubro`  char(1)     NOT NULL,
												   `numero` smallint(6) NOT NULL,
												   `texto`  char(255)   NOT NULL,
												   `a`      char(100)   DEFAULT NULL,
												   `b`      char(100)   DEFAULT NULL,
												   `c`      char(100)   DEFAULT NULL,
												   `d`      char(100)   DEFAULT NULL,
												   `e`      char(100)   DEFAULT NULL,
													PRIMARY KEY (`tipo`,`rubro`,`numero`)
												 )",$semestre);                     
            importarCSV($ed,"PreguntasRubros","(`rubtipo`  char(1)  NOT NULL,
														   `rubclave` char(1)  NOT NULL,
														   `rubtexto` char(50) NOT NULL,
															 PRIMARY KEY (`rubtipo`,`rubclave`)
														  )",$semestre);
			crear("GruposaContinuo", "(`consecutivo` int(11)  NOT NULL AUTO_INCREMENT,
												`GAC_MAT`     char(10) NOT NULL,
												`GAC_GPO`     char(12) NOT NULL,
												`GAC_CON`     char(4)  NOT NULL,
												 PRIMARY KEY (`consecutivo`)
											  ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;",$semestre);
			crear("ConvertirPlanesaCarreras", "(`CPC_PLA` smallint(6) NOT NULL DEFAULT '0',
														   `CPC_CAR` char(3)     DEFAULT NULL,
														   `CPC_NIV` smallint(1) NOT NULL,
															 PRIMARY KEY (`CPC_PLA`)
														  ) ENGINE=MyISAM DEFAULT CHARSET=latin1;","");
			$datoscarreras="";
			foreach($carreras as $c => $car) $datoscarreras.="('".$car[0]."','".$car[1]."','".$car[2]."'),\n";
			insertar("ConvertirPlanesaCarreras", $datoscarreras
											             ."('0', '0', '0');",
															 "ConvertirPlanesaCarreras");
											
            crear("ConvertirDeptosaClave", "(`CDC_DEP` char(3) NOT NULL DEFAULT '',
                                          `CDC_CVE` char(1) DEFAULT NULL,
                                           PRIMARY KEY (`CDC_DEP`)
                                         ) ENGINE=MyISAM DEFAULT CHARSET=latin1;","");
			$datosdeptos="";
			foreach($deptos as $d => $dep) $datosdeptos.="('".$dep[0]."','".$dep[1]."'),\n";
			insertar("ConvertirDeptosaClave", $datosdeptos
											          ."('0',   '0');",
														 "ConvertirDeptosaClave");
            crear("parametros",  "(`activo`           tinyint(1)  NOT NULL DEFAULT '0',
										  `reportes`         tinyint(1)  NOT NULL,
										  `procesodesaca`    char(15)    DEFAULT NULL,
										  `procesoposgrado`  char(15)    DEFAULT NULL,
										  `periodo`          char(9)     DEFAULT NULL,
										  `anio`              char(4)     DEFAULT NULL,
										  `semestre`         char(21)    DEFAULT NULL,
										  `plantel`          char(40)    DEFAULT NULL,
										  `estado`           char(6)     DEFAULT NULL,
										  `instituto`        char(150)   DEFAULT NULL,
										  `lema`             char(255)   DEFAULT NULL,
                                `index`            char(255)   DEFAULT NULL,
                                `maximofallos`     smallint(6) DEFAULT NULL,
										  `horasespera`      smallint(6) DEFAULT NULL,
										  `desacaadmin`      char(32)    DEFAULT NULL,
										  `desacapassword`   char(32)    DEFAULT NULL,
										  `posgradoadmin`    char(32)    DEFAULT NULL,
										  `posgradopassword` char(32)    DEFAULT NULL,
										   PRIMARY KEY (`activo`)
										 ) ENGINE=MyISAM CHARSET=latin1;","");
			insertar("parametros","('0', '0',
			                        'LICENCIATURA', 'POSGRADO',
                                 '".strtoupper($month)."',
                                 '$year',
                                 '".$PERX."',
                                 '$tec2',
                                 '$estado', 
                                 '$tec', '$lema', '$index',
											'3', '2',
											'".md5('desaca')  ."', '".md5('privilegiados1')."',
											'".md5('posgrado')."', '".md5('privilegiados2')."'
										  );","parametros");
								
			mysql_close();

			echo "IMPORTACIÓN TERMINADA. Se ha cerrado la Base de Datos.<br /><br /><br /><br />";
			
			echo "RECONECTANDO Y CONCEDIENDO PRIVILEGIOS.<br />";
			$con=mysql_connect($host,$user,$pass) or die("Error al reconectar al Servidor.");
			
			
			$sql='CREATE DATABASE IF NOT EXISTS `evaldoc`;';  //echo $sql."<br />";
			run($sql,"Error al crear la Base de Datos de Registros de EvalDoc para que el SIE valide si el alumno ha evaluado");	
			//$sql='GRANT SELECT,INSERT ON '.$basedatos.'.* TO evaldoc@localhost IDENTIFIED BY "'.$pass.'";';
         	$sql='GRANT SELECT,INSERT ON '.$basedatos.'.* TO evaldoc@localhost IDENTIFIED BY "evaldoc";';  //echo $sql."<br />";
			run($sql,"Error al conceder privilegios");	
			
			$sql="CREATE TABLE IF NOT EXISTS `evaldoc`.`DALUEval` ( ".
				  " `ALU_CTR` varchar(10) NOT NULL,".
				  "  PRIMARY KEY (`ALU_CTR`)".
				  ") ENGINE=MyISAM DEFAULT CHARSET=latin1"; //echo $sql."<br />";
			run($sql,"Error al crear la Tabla DALUEval de la Base de Datos de Registros de EvalDoc para que el SIE valide si el alumno ha evaluado");	
			
			$t=date("_Ymd_His");
			$tblNew="evaldoc`.`DALUEval".$t;
			$sql="CREATE TABLE `$tblNew` ( ".
					  " `ALU_CTR` varchar(10) NOT NULL,".
					  "  PRIMARY KEY (`ALU_CTR`)".
					  ") ENGINE=MyISAM DEFAULT CHARSET=latin1 ".
					"AS SELECT * FROM `evaldoc`.`DALUEval`"; //echo $sql."<br />";
			run($sql,"Error al crear la Base de Datos de Registros de EvalDoc para que el SIE valide si el alumno ha evaluado");	
			
			$sql="TRUNCATE `evaldoc`.`DALUEval`"; //echo $sql."<br />";
			run($sql,"Error al vaciar la Base de Datos de Registros de EvalDoc para que el SIE valide si el alumno ha evaluado");	
			
			$sql='GRANT SELECT,INSERT ON `evaldoc`.`DALUEval` TO evaldoc@localhost IDENTIFIED BY "evaldoc";';  //echo $sql."<br />";
			run($sql,"Error al conceder privilegios del Registro de EvalDoc para que el SIE valide si el alumno ha evaluado.");
         
			echo "<br /><br /><font size='+6' color='%236ac36a'>PROCESO TERMINADO CON ÉXITO.</font><br /><br />";
         
         echo '<br /><br /><input name="bSalir" class="btn btn-success" style="width:200px" type="submit" value="Regresar" onClick="Salir()"><br><br>'; 
		}
		else include("index.php");
	}
} else include("index.php");

function run($sql, $msg)
{  echo "<br />Corriendo...consulta=$sql<br />";
   $dInfo=mysql_query($sql) or die("Error al correr: $msg<br />".mysql_error());
   echo "Consulta Corrida.<br /><br />";
}

function crear($tabla,$sql,$semestre)
{	$destino=$semestre.$tabla;
	echo "<br />Creando...tabla=$destino<br />";
	
	$sql="CREATE TABLE `$destino` $sql";
	echo "<br />SQL:$sql<br />";
	$result=mysql_query($sql);
	if (!$result)
	{   echo "<br />crear->SQL INVALIDO:<br />".$sql;
		die('<br />ERROR: ' . mysql_error());
	}
	echo "Tabla creada<br /><br />";
}

function insertar($tabla,$sql,$destino)
{	echo "<br />Insertando...tabla=$destino<br />";
	
	$sql="INSERT INTO `$destino` VALUES $sql";
	echo "<br />SQL:$sql<br />";
	$result=mysql_query($sql);
	if (!$result)
	{   echo "<br />insertar->SQL INVALIDO:<br />".$sql;
		die('<br />ERROR: ' . mysql_error());
	}
	echo "Tabla creada<br /><br />";
}

function importarCSV($ori,$tabla,$sql,$semestre,$datos=null)
{  $origen=$ori.$tabla.".csv";
	$destino=$semestre.$tabla;
	echo "<br />Importando...origen=$origen al destino=$destino<br />";
	
	$sql="CREATE TABLE `$destino` $sql ENGINE=MyISAM DEFAULT CHARSET=latin1;";
	echo "<br />SQL:$sql<br />";
	$result=mysql_query($sql);
	echo "Tabla creada:$result<br /><br />";
		
	echo "Abriendo CSV: $origen...<br />";
	//$sql = "LOAD DATA INFILE '$origen' INTO TABLE `$destino` FIELDS TERMINATED BY ',' ENCLOSED BY '".'"'."' ESCAPED BY '\\\\' LINES TERMINATED BY '\\r\\n' IGNORE 1 LINES;";
   //echo "<br />SQL:$sql<br />";   
   //$result=mysql_query($sql);
	echo "CSV importado:$result<br />";   
   $csv=csv_to_array($origen); 
   if($csv!=NULL)
   {  $header=1; $i=0; $número_campos=0;
      foreach($csv as $fila) 
      {  if($header==1) $número_campos=count($fila);
         //foreach($fila as $valor)echo "$valor&nbsp;<br/>";
         $sql="INSERT INTO ".$destino." VALUES("; $j=0; foreach($fila as $valor){$valor=str_replace("'","´",$valor); $valor=str_replace('"',"´",$valor); $sql.="'$valor'".($j<$número_campos-1?",":");"); $j++;}
         //echo "SQL:$sql<br />"; //echo "SQL:$sql<br />";
         $result=mysql_query($sql);
         $header=0; $i++; echo "$i,"; if($i>0 && $i%100==0)echo "<br />";
      }
		
		if($tabla=="DDEP")
		{  echo "VALIDANDO:$destino<br />";
				$sql="SELECT * FROM ".$destino.";"; $listaEncontrados=""; $listaNOencontrados="";
				$result=mysql_query($sql);
				while($Registro=@mysql_fetch_array($result))
				{  $encontrado=false; $depcve="";
				   foreach($datos as $d => $dep) if($Registro["0"]==$dep[0]) {$encontrado=true; $depcve=$dep[1];}
				   if(!$encontrado) $listaNOencontrados.="<font size='+2' color='%23c36a6a'>EL Depto: ".$Registro["0"]." no fue encontrado en la tabla de conversiones.</font><br />";
				   else             $listaEncontrados  .="<font size='+2' color='%236ac36a'>EL Depto: ".$Registro["0"]." fue encontrado en la tabla de conversiones y asociado al cat&aacute;logo general como: $depcve.</font><br />";
				}
				if($listaNOencontrados!="") die($listaNOencontrados);
				else                        echo $listaEncontrados;
				echo "<br />Deptos Validados.<br /><br />";
				
				$sql="INSERT INTO ".$destino." VALUES('301','SUBDIRECCION ACADEMICA','SUBD.ACADEMICA');"; 
				echo "SQL:$sql<br />"; 
				$result=mysql_query($sql);
		}
		else if($tabla=="DESP")
		{  echo "VALIDANDO:$destino<br />";
				$sql="SELECT * FROM ".$destino.";"; $listaEncontrados=""; $listaNOencontrados="";
				$result=mysql_query($sql);
				while($Registro=@mysql_fetch_array($result))
				{  $encontrado=false; $carcve="";
				   foreach($datos as $c => $car) if($Registro["0"]==$car[0]){$encontrado=true; $carcve=$car[1];}
				   if(!$encontrado) $listaNOencontrados.="<font size='+2' color='%23c36a6a'>La carrera: ".$Registro["0"]." no fue encontrada en la tabla de conversiones.</font><br />";
				   else             $listaEncontrados  .="<font size='+2' color='%236ac36a'>La carrera: ".$Registro["0"]." fue encontrada en la tabla de conversiones y asociada al cat&aacute;logo general como: $carcve.</font><br />";
				}
				if($listaNOencontrados!="") die($listaNOencontrados);
				else                        echo $listaEncontrados;
				echo "<br />Carreras Validadas.<br /><br />";
		}
		else if($tabla=="DCAT")
		{   echo "VALIDANDO:$destino<br />";
				$sql="UPDATE ".$destino." SET CAT_DEP='301' WHERE CAT_DEP='0';";  
				echo "SQL:$sql<br />";
				$result=mysql_query($sql);
			echo "VALIDANDO:$destino<br />";	
				$sql="UPDATE ".$destino." SET CAT_CVE=-CAT_CVE,CAT_DEP='301'"
                                   ." WHERE CAT_CVE='9912'"
                                   ."    OR CAT_CVE='9914'"
                                   ."    OR CAT_CVE='9916'"
                                   ."    OR CAT_CVE='9915'"
                                   ."    OR CAT_CVE='9918';"; 
				echo "SQL:$sql<br />";	
				$result=mysql_query($sql);
		}
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

?>
</body>
</html>