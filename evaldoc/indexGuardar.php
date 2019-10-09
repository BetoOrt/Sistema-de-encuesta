<?php
   session_start(); 
	/***********************************************************
	************************************************************   
  	                     G U A R D A R
	************************************************************
	***********************************************************/
   include("class/conexionesDB.php"); include("class/zfunciones.php"); include("evaldocAutentica.php");
    
	include("configuracion.php");  
    $activo             = $cfg['activo'];
	$capturacookieclave = $cfg['capturacookieclave'];
	$capturacookievalor = $cfg['capturacookievalor'];
    $capturavalidar     = $cfg['capturavalidar'];
	unset($cfg);
	
if(!$activo){ echo '<script type="text/javascript">document.location.href="evaldocValida.php";</script>'; die; }

$Correcto="NO";
if ($_COOKIE)
{  foreach ($_COOKIE as $k => $v)
   {  $_COOKIE[$k] = trim (stripslashes ($v));
	  if($k==$capturacookieclave) $Correcto=$_COOKIE[$k];
   }
} 

if($capturavalidar && $Correcto!=$capturacookievalor) GuardarFallo("Guardar-CookieInválido");
else
{	if(isset($_SESSION["Proceso"]) && isset($_SESSION["Alumno"]) && isset($_POST["Alumno"]) && isset($_POST["Maestro"]) && isset($_POST["Materia"]) && isset($_POST["Grupo"]) )
	{   $Proceso=$_SESSION["Proceso"]; $Alumno=$_POST["Alumno"]; $Maestro=$_POST["Maestro"]; $Materia=$_POST["Materia"];  $Grupo=$_POST["Grupo"]; $nPreguntas=$_POST["nPreguntas"];
		for($i=1;$i<=$nPreguntas;$i++) $R[$i]=$_POST["R".$i]; 
        $_SESSION["Guardado"]=false;
		  include("configuracion.php"); 
		  $conexion=new ClassConexion_DB($cfg['usuario'],$cfg['password'],$cfg['base'],"mysql",$cfg['host']);
		  //Consigue la Carrera y el Semestre del Alumno
             $SQL='SELECT * FROM ConvertirPlanesaCarreras INNER JOIN '.$cfg['DALU'].' ON ConvertirPlanesaCarreras.CPC_PLA='.$cfg['ALU_PLA'].' WHERE '.$cfg['ALU_CTR'].'="'.$Alumno.'";'; //echo "Alumnos:".$SQL."<BR><BR><BR>";
		     $dAlumnos=new ClassConsulta($SQL,$conexion); 
			 if($Registro=$dAlumnos->fila()) 
			 {  $EncuestasCarrera =$Registro['CPC_CAR'];
			    $EncuestasSemestre=str_pad($Registro[soloCampo($cfg['ALU_SEM'])],2,"0",STR_PAD_LEFT); 
			 } 
		  //Consigue el Folio y el Nombre del Maestro
			 $SQL='SELECT * FROM ConvertirDeptosaClave INNER JOIN '.$cfg['DCAT'].' ON ConvertirDeptosaClave.CDC_DEP='.$cfg['CAT_DEP'].' WHERE '.$cfg['CAT_CVE'].'="'.$Maestro.'";'; //echo "Maestros:".$SQL."<BR><BR><BR>";
		     $dMaestros=new ClassConsulta($SQL,$conexion); 
			 if($Registro=$dMaestros->fila()) 
			 {  $EncuestasFolio   =str_pad($Registro[soloCampo($cfg['CAT_CVE'])],4,"0",STR_PAD_LEFT);
			    $EncuestasNom_prof=$Registro[soloCampo($cfg['CAT_NOM'])];
			    $EncuestasDepto   =$Registro['CDC_CVE'];
			 } 
		  //Consigue el Número Consecutivo de Materia
			 $SQL='SELECT * FROM '.$cfg['GruposaContinuo'].' WHERE GAC_MAT="'.$Materia.'" AND GAC_GPO="'.$Grupo.'";'; //echo "Materias:".$SQL."<BR><BR><BR>";
		     $dMaterias=new ClassConsulta($SQL,$conexion); 
			 if($Registro=$dMaterias->fila()) $numcons=$Registro['consecutivo'];
			 else
			 {  $SQL='SELECT MAX(GAC_CON) AS MAXMATERIA FROM '.$cfg['GruposaContinuo'].';'; //echo "Materias2:".$SQL."<BR><BR><BR>";
   		        $dMaterias=new ClassConsulta($SQL,$conexion); 
				if($Registro=$dMaterias->fila()) $numcons=strval($Registro['MAXMATERIA'])+1; else $numcons=1; 
			   $SQL='INSERT INTO '.$cfg['GruposaContinuo'].' VALUES(null,"'.$Materia.'","'.$Grupo.'","'.str_pad($numcons,4,"0",STR_PAD_LEFT ).'");'; //echo "Materias2:".$SQL."<BR><BR><BR>";
   		        $dMaterias=new ClassConsulta($SQL,$conexion); 
				
				$SQL='SELECT * FROM '.$cfg['GruposaContinuo'].' WHERE GAC_MAT="'.$Materia.'" AND GAC_GPO="'.$Grupo.'";'; //echo "Materias:".$SQL."<BR><BR><BR>";
		        $dMaterias=new ClassConsulta($SQL,$conexion); 
			    if($Registro=$dMaterias->fila()) $numcons=strval($Registro['consecutivo']);
			 }
			 $EncuestasMateria=str_pad($numcons,4,"0",STR_PAD_LEFT);
          $EncuestasCiclo  =$cfg['año'];
		  //Configura la Encuesta destino dependiendo de la variable $Proceso
		    if     ($Proceso==$cfg['LICENCIATURA']) { $Tipo='Alu'; $Encuestas=$cfg['EncuestasAlumnos']; }
			 else if($Proceso==$cfg['POSGRADO'])     { $Tipo='Pos'; $Encuestas=$cfg['EncuestasPosgrado'];}
		  //Verifica si la Materia del Alumno ya ha sido guardada en el registro 
		     $SQL='SELECT * FROM '.$cfg['EncuestasRegistrados'].$Tipo.' WHERE alumno="'.$Alumno.'" AND materia="'.$Materia.'" AND grupo="'.$Grupo.'";'; //echo "Registrados Existente:".$SQL."<BR><BR><BR>";
             $dEncuestasRegistrados=new ClassConsulta($SQL,$conexion);
			 if($Registro=$dEncuestasRegistrados->fila()) echo "Encuesta ya registrada...<br>";
		     else
			 {  //Consigue el Número Consecutivo de Encuesta
								//Pendienteeeeeeeeeeee************************************************************
								//Pendienteeeeeeeeeeee************************************************************
								//Pendienteeeeeeeeeeee************************************************************
								//Se debe asegurar que guarde correctamente el numero de encuesta consecutiva como
								// un solo bloque y no dar pauta a repetir el numero consecutivo de encuesta.
			    $SQL='SELECT MAX(numcues) AS MAXNUMCUES FROM '.$Encuestas; //echo "Consecutivo:".$SQL."<BR><BR><BR>";
		        $dConsecutivos=new ClassConsulta($SQL,$conexion); 
				if($Registro=$dConsecutivos->fila()) $numcues=strval($Registro['MAXNUMCUES'])+1; else $numcues=1; 
	            $EncuestasNumcues=str_pad($numcues,5,"0",STR_PAD_LEFT);
		        //Guarda la encuesta
		  	    $SQL='INSERT INTO '.$Encuestas.' VALUES (null,"'.$cfg['periodo'].'","'.$cfg['plantel'].'","'.$EncuestasCarrera.'","'.$EncuestasFolio.'","'.$EncuestasNom_prof.'","'.$EncuestasMateria.'","'.$EncuestasDepto.'","'.$EncuestasCiclo.'","'.$cfg['estado'].'","'.$EncuestasSemestre.'","'.$EncuestasNumcues.'","'; for($i=1;$i<$nPreguntas;$i++) $SQL.=$R[$i]; $R[$i]=str_replace("$","",$R[$i]); $R[$i]=str_replace('"',"'",$R[$i]); $SQL.='","'.$R[$i].'");'; //echo "Encuestas:".$SQL."<BR><BR><BR>";
//echo $SQL; die;
				$dEncuestas=new ClassConsulta($SQL,$conexion);
								//Pendienteeeeeeeeeeee************************************************************
								//Pendienteeeeeeeeeeee************************************************************
								//Pendienteeeeeeeeeeee************************************************************
		       //Guarda la Materia del Alumno en el registro 
				$ip = getenv("REMOTE_ADDR"); $d=date("Y/m/d"); $t=date("H:i:s");
			    $SQL='INSERT INTO '.$cfg['EncuestasRegistrados'].$Tipo.' VALUES ("'.$Alumno.'","'.$Materia.'","'.$Grupo.'","'.$ip.'","'.$d.'","'.$t.'","'.md5($Proceso.'-'.$EncuestasNumcues).'");'; //echo "Registrados:".$SQL."<BR><BR><BR>";
				//die("<br>". $SQL);
		        $dEncuestasRegistrados=new ClassConsulta($SQL,$conexion); 
				//El registro ha sido guardado 
			
				$_SESSION["Guardado"]=true; 
				
			 }
		unset($cfg);
		/**/ echo '<script type="text/javascript">document.location.href="index.php";</script>'; /**/
	}
	else GuardarFallo("Guardar-DatosFalsos");
}
?>
