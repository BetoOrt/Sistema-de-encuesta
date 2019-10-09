<?php 
	date_default_timezone_set('America/Mexico_City');
	/***********************************************************
	************************************************************   
	                 A  U  T  E  N  T  I  C  A
	************************************************************
	***********************************************************/    
	function GuardarFallo($nNivel)
	{  include("configuracion.php");     
		  $conexion=new ClassConexion_DB($cfg['usuario'],$cfg['password'],$cfg['base'],"mysql",$cfg['host']);
		  $ip = getenv("REMOTE_ADDR");  $d=date("Y/m/d"); $t=date("H:i:s");
		  $SQL='INSERT INTO '.$cfg['Fallos'].' VALUES (null,"'.$nNivel.'","'.$ip.'","'.$d.'","'.$t.'",1)';
		  $dGuardar=new ClassConsulta($SQL,$conexion); 	  
		unset($cfg);
		echo '<script type="text/javascript">document.location.href="evaldocValida.php";</script>'; die;
	}
	
   function  BuscarIntruso() //Valida que la IP no sea de un intruso de administrador
	{   include("configuracion.php"); $nVeces=0; $ip = getenv("REMOTE_ADDR"); 
	    $SQL='SELECT COUNT(ip) AS VECES FROM '.$cfg['Fallos'].' WHERE ip="'.$ip.'" AND vigente;'; 		
		$dIntrusos=new ClassConsulta($SQL,$conexion);  if($Registro=$dIntrusos->fila()) $nVeces=$Registro['VECES']; 
		if($nVeces>=$cfg['maximofallos']) { echo '<script type="text/javascript">document.location.href="evaldocValida.php";</script>'; die; }
		unset($cfg);
		return true;
	}
	
	function  BuscarIntrusoPorDia() //Valida que la IP no sea de un intruso de listados
	{   include("configuracion.php"); $nVeces=0; $ip = getenv("REMOTE_ADDR"); $d=date("Y/m/d");
	    $SQL='SELECT COUNT(ip) AS VECES FROM '.$cfg['Fallos'].' WHERE ip="'.$ip.'" AND fecha="'.$d.'" AND vigente;';
		$dIntrusos=new ClassConsulta($SQL,$conexion);  if($Registro=$dIntrusos->fila()) $nVeces=$Registro['VECES']; 
//echo $SQL."<br>";
//echo "Veces=".$nVeces."<br>";
//echo "Max=".$cfg['maximofallos']."<br>";
//echo "Error=".($nVeces>=$cfg['maximofallos'])."<br>";
//die;
		if($nVeces>=$cfg['maximofallos']) { echo '<script type="text/javascript">document.location.href="evaldocValida.php";</script>'; die; }

		unset($cfg);
		return true;
	}	
			
	function BuscarIntrusoPorHora() //Valida que la IP no sea de un intruso en la captura
	{   include("configuracion.php"); $nVeces=0; $ip = getenv("REMOTE_ADDR"); $horasespera=$cfg['horasespera']; $mt=mktime(date("H")-$horasespera,date("i"),date("s"),date("m"),date("d"),date("Y")); $d=date("Y/m/d",$mt); $t=date("H:i:s",$mt); 
	    $SQL='SELECT COUNT(ip) AS VECES FROM '.$cfg['Fallos'].' WHERE ip="'.$ip.'"'; if(strval(date("H"))>=$horasespera) $SQL.=' AND fecha="'.$d.'" AND hora>"'.$t.'" AND vigente;';
		$dIntrusos=new ClassConsulta($SQL,$conexion);  if($Registro=$dIntrusos->fila()) $nVeces=$Registro['VECES']; 
//echo $SQL."<br>";
//echo "Veces=".$nVeces."<br>";
//echo "Max=".$cfg['maximofallos']."<br>";
//echo "Error=".($nVeces>=$cfg['maximofallos'])."<br>";
//die;
		if($nVeces>=$cfg['maximofallos']) { echo '<script type="text/javascript">document.location.href="evaldocValida.php";</script>'; die; }
		unset($cfg);
		return true;
	}
	
	function BuscarAlumno($bAlumno,$bClave,$Proceso)
	{   $resul=false; $Proceso='';
		
	    include("configuracion.php"); 
//echo ">>" . $bAlumno."<br>";
//echo ">>" . $bClave."<br>";
////echo ">>" . $cfg['SIE_DALU']."<br>";

		  $conexion=new ClassConexion_DB($cfg['usuario'],$cfg['password'],$cfg['base'],"mysql",$cfg['host']);		
		  //Validando Alumnos de Licenciatura y Posgrado
          $bAlumno=str_replace('"','',$bAlumno);
		  $bClave =str_replace('"','',$bClave);
  		  $SQL='SELECT * FROM '.$cfg['SIE_DALU'].',ConvertirPlanesaCarreras WHERE '.$cfg['ALU_CTR'].'="'.$bAlumno.'" AND '.$cfg['ALU_PAS'].'="'.md5(trim($bClave)).'" AND '.$cfg['ALU_PLA'].'=ConvertirPlanesaCarreras.CPC_PLA;'; //***/echo $SQL.'<br>';
//echo "<br>".  $SQL."<br>";
		  $dBuscar=new ClassConsulta($SQL,$conexion);
		  if($Registro=$dBuscar->fila())
		  {   $resul=true; 
//echo ">> adentro " . $bAlumno."<br>";
		      if($Registro['CPC_NIV']==$cfg['NIVELPOSGRADO']) $Proceso=$cfg['POSGRADO'];
		      else                                            $Proceso=$cfg['LICENCIATURA'];
		  }
		unset($cfg);
		return($resul?$Proceso:"");
	}
?>