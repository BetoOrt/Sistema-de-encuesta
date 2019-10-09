<?php
   /***********************************************************
   ************************************************************   
                       E N C A B E Z A D O
   ************************************************************
   ***********************************************************/
   include("configuracion.php");
   if     ($Proceso==$cfg['LICENCIATURA']){ $cfg['EncuestasRegistrados']=$cfg['EncuestasRegistrados'].'Alu'; }
	else if($Proceso==$cfg['POSGRADO'])    { $cfg['EncuestasRegistrados']=$cfg['EncuestasRegistrados'].'Pos'; }
			 
     $conexion=new ClassConexion_DB($cfg['usuario'],$cfg['password'],$cfg['base'],"mysql",$cfg['host']);
//ALUMNO
      //$SQL='SELECT * FROM DALU WHERE ALU_CTR="'.$Alumno.'";';
	  $SQL='SELECT * FROM '.$cfg['DALU'].' WHERE '.$cfg['ALU_CTR'].'="'.$Alumno.'";';
//echo $SQL.'<br>xxxxxxxxxxxxxxxxxxx';   
	  $dAlumnos=new ClassConsulta($SQL,$conexion);
	  if($Registro=$dAlumnos->fila())
	  {   echo "<center><br />Datos del Estudiante:<br /><br />";
	      echo "<table border='0' class='datos' style='color:#ffffff;'><tr bgcolor='#6ac36a'><td>&nbsp;</td><td>&nbsp;</td></tr>";
	      echo "<tr bgcolor='#6ac36a'><td align='right'><b>&nbsp;&nbsp;Matrícula:</b></td><td>&nbsp;&nbsp;<input style='width:80px' type='text' name='Alumno' readonly value='$Alumno' size='9'>&nbsp;&nbsp;</td></tr>";
		  echo "<tr bgcolor='#6ac36a'><td align='right'><b>&nbsp;&nbsp;Nombre:</b></td><td>&nbsp;&nbsp;<input style='width:500px' type='text' name='AlumnoNombre' readonly value='".$Registro[soloCampo($cfg['ALU_NOM'])]."' size='60'>&nbsp;&nbsp;</td></tr>";
//NUMERO DE MATERIAS FALTANTES
          //'SELECT * FROM DLIS,DRET,DGAU,DCAT WHERE LIS_CTR="'.$Alumno.'" AND LIS_MAT=RET_CVE AND ord(substring(LIS_MAT,1,1))=Ord(substring(RET_CVE,1,1)) AND ord(substring(LIS_MAT,2,1))=Ord(substring(RET_CVE,2,1)) AND ord(substring(LIS_MAT,3,1))=Ord(substring(RET_CVE,3,1)) AND LIS_MAT=GPO_MAT AND ord(substring(LIS_MAT,1,1))=Ord(substring(GPO_MAT,1,1)) AND ord(substring(LIS_MAT,2,1))=Ord(substring(GPO_MAT,2,1)) AND ord(substring(LIS_MAT,3,1))=Ord(substring(GPO_MAT,3,1)) AND LIS_GPO=GPO_GPO AND GPO_CAT=CAT_CVE;',$conexion); 
		  //$SQL='SELECT * FROM '.$cfg['DLIS'].' LEFT JOIN '.$cfg['EncuestasRegistrados'].' ON '.$cfg['LIS_CTR'].'='.$cfg['EncuestasRegistrados'].'.alumno AND '.$cfg['LIS_MAT'].'='.$cfg['EncuestasRegistrados'].'.materia,'.$cfg['DRET'].','.$cfg['DGAU'].','.$cfg['DCAT'].' WHERE '.$cfg['LIS_CTR'].'="'.$Alumno.'" AND '.$cfg['LIS_MAT'].'='.$cfg['RET_CVE'].' AND '.$cfg['LIS_MAT'].'='.$cfg['GPO_MAT'].' AND '.$cfg['LIS_GPO'].' COLLATE _latin1 = '.$cfg['GPO_GPO'].' COLLATE _latin1 AND '.$cfg['GPO_CAT'].'='.$cfg['CAT_CVE'].' AND '.$cfg['EncuestasRegistrados'].'.alumno IS Null;';
		  //$SQL='SELECT * FROM '.$cfg['DLIS'].' LEFT JOIN '.$cfg['EncuestasRegistrados'].' ON '.$cfg['LIS_CTR'].'='.$cfg['EncuestasRegistrados'].'.alumno AND '.$cfg['LIS_MAT'].'='.$cfg['EncuestasRegistrados'].'.materia,'.$cfg['DRET'].','.$cfg['DGAU'].','.$cfg['DCAT'].' WHERE '.$cfg['LIS_CTR'].'="'.$Alumno.'" AND '.$cfg['LIS_MAT'].'='.$cfg['RET_CVE'].' AND '.$cfg['LIS_MAT'].'='.$cfg['GPO_MAT'].' AND HEX('.$cfg['LIS_GPO'].')=HEX('.$cfg['GPO_GPO'].') AND '.$cfg['GPO_CAT'].'='.$cfg['CAT_CVE'].' AND '.$cfg['EncuestasRegistrados'].'.alumno IS Null;';
		  $SQL='SELECT * FROM '.$cfg['DLIS'].' LEFT JOIN '.$cfg['EncuestasRegistrados'].' ON '.$cfg['LIS_CTR'].'='.$cfg['EncuestasRegistrados'].'.alumno AND '.$cfg['LIS_MAT'].'='.$cfg['EncuestasRegistrados'].'.materia,'.$cfg['DRET'].','.$cfg['DGAU'].','.$cfg['DCAT'].' WHERE '.$cfg['LIS_CTR'].'="'.$Alumno.'" AND '.$cfg['LIS_MAT'].'='.$cfg['RET_CVE'].' AND '.$cfg['LIS_MAT'].'='.$cfg['GPO_MAT'].' AND HEX('.$cfg['LIS_GPO'].')=HEX('.$cfg['GPO_GPO'].') AND '.$cfg['GPO_CAT'].'='.$cfg['CAT_CVE'].' AND '.$cfg['EncuestasRegistrados'].'.alumno IS Null;';
		  //echo $SQL;
	      $dAlumnos=new ClassConsulta($SQL,$conexion);
		     $NumMat=$dAlumnos->numfilas; 
		  $Registro=$dAlumnos->fila();
		  echo "</table>";
//MATERIAS FALTANTES
		  if($NumMat>0) 
		  {  echo "Lista de asignaturas faltantes:<br>";
		     echo "<table class='datos'><tr><td align='right'><b>Faltan evaluar:</b></td><td><input style='width:40px' type='text' readonly name='NumMat' value='$NumMat' size='1'> materias</td><td>&nbsp;</td></tr></table>";
			  echo "<table class='datos'><tr><td align='center'><b>Clave</b></td><td><b>Asignatura</b></td><td><b>Profesor</b></td></tr>";
			  for($i=1;$i<=$NumMat;$i++)
			  {   echo "<tr><td align='right'><b>[$i]. </b><input type='text' style='width:90px' readonly value='".$Registro[soloCampo($cfg['LIS_MAT'])]."' size='7'><input style='width:30px' type='text' readonly value='".$Registro[soloCampo($cfg['LIS_GPO'])]."' size='1'></td><td><input style='width:400px' type='text' readonly value='".$Registro[soloCampo($cfg['RET_NOM'])]."' size='50'></td><td><input style='width:400px' type='text' readonly value='".$Registro[soloCampo($cfg['CAT_NOM'])]."' size='50'></td></tr>";
				  $Registro=$dAlumnos->fila();  
			  }
			  echo "</table>";
		  } 
//MATERIA A CAPTURAR		  
		  $SQL='SELECT * FROM '.$cfg['DLIS'].' LEFT JOIN '.$cfg['EncuestasRegistrados'].' ON '.$cfg['LIS_CTR'].'='.$cfg['EncuestasRegistrados'].'.alumno AND '.$cfg['LIS_MAT'].'='.$cfg['EncuestasRegistrados'].'.materia,'.$cfg['DRET'].','.$cfg['DGAU'].','.$cfg['DCAT'].' WHERE '.$cfg['LIS_CTR'].'="'.$Alumno.'" AND '.$cfg['LIS_MAT'].'='.$cfg['RET_CVE'].' AND '.$cfg['LIS_MAT'].'='.$cfg['GPO_MAT'].' AND HEX('.$cfg['LIS_GPO'].')=HEX('.$cfg['GPO_GPO'].') AND '.$cfg['GPO_CAT'].'='.$cfg['CAT_CVE'].' AND '.$cfg['EncuestasRegistrados'].'.alumno IS Null;';
	      $dAlumnos=new ClassConsulta($SQL,$conexion); 
		  if($Registro=$dAlumnos->fila())
		  {   echo "<br><br><hr><br><table class='capturando'>";
		      $Materia=$Registro[soloCampo($cfg['LIS_MAT'])]; $Grupo=$Registro[soloCampo($cfg['LIS_GPO'])]; $Maestro=$Registro[soloCampo($cfg['CAT_CVE'])];
		      echo "<tr bgcolor='#faa732' style='color:#ffffff;'><td>&nbsp;</td><td>&nbsp;</td></tr><tr bgcolor='#faa732' style='color:#ffffff;'><td align='right'>&nbsp;&nbsp;&nbsp;<b>En este momento se está evaluando la materia:</td><td><input style='width:40px' type='text' readonly name='NumMatCap' value='1' size='1'> de <input style='width:40px' type='text' readonly value='$NumMat' size='1'>&nbsp;&nbsp;&nbsp;</b></td></tr>";
			  echo "</table><table border='1' class='capturando'>";
			  echo "<tr bgcolor='#faa732' style='color:#ffffff;'><td align='center'><b>Clave</b></td><td><b>Asignatura</b></td><td>&nbsp;</td><td><b>Profesor</b></td></tr>";
		      echo "<tr bgcolor='#faa732'><td><input style='width:90px' type='text' name='Materia' readonly value='".$Materia."' size='7'><input style='width:30px' type='text' name='Grupo' readonly value='".$Grupo."' size='1'></td><td><input style='width:400px' type='text' name='MateriaNombre' readonly value='".$Registro[soloCampo($cfg['RET_NOM'])]."' size='50'></td><td><input style='width:40px' type='text' name='Maestro' readonly value='".$Maestro."' size='4'></td><td><input style='width:400px' type='text' name='MaestroNombre' readonly value='".$Registro[soloCampo($cfg['CAT_NOM'])]."' size='50'></td></tr>";
			  echo "</table>";
          }
		  else
		  {  //Registra alumno evaluado en evaldoc.DALUEval
			  echo "<br><table class='capturando'><tr><td><br><b>&nbsp;Ya ha evaluado todas sus materias... GRACIAS&nbsp;</b><br><br></td></tr></table>";
			    $sqlsie="INSERT INTO evaldoc.DALUEval VALUES('".$Alumno."');";
				$conexionsie=new ClassConexion_DB($cfg['usuario'],$cfg['password'],'evaldoc',"mysql",$cfg['host']);
				new ClassConsulta($sqlsie,$conexionsie);
			  $_SESSION["Alumno"]=""; $_POST["Alumno"]=""; unset($_SESSION["Alumno"]); unset($_POST["Alumno"]); 
		      $_SESSION["Clave"]=""; $_POST["Clave"]=""; unset($_SESSION["Clave"]); unset($_POST["Clave"]); 
			  $_SESSION["Proceso"]=""; unset($_SESSION["Proceso"]);
			  $_SESSION["NoMatri"]=0; unset($_SESSION["NoMatri"]); unset($_SESSION["Guardado"]);			  
		  }
		  echo "</center>"; unset($cfg); 
	 }
	 else 
	 {   $_SESSION["Alumno"]=""; $_POST["Alumno"]=""; unset($_SESSION["Alumno"]); unset($_POST["Alumno"]); 
	     $_SESSION["Clave"]=""; $_POST["Clave"]=""; unset($_SESSION["Clave"]); unset($_POST["Clave"]); 
		 $_SESSION["Proceso"]=""; unset($_SESSION["Proceso"]); $_SESSION["NoMatri"]=1; unset($cfg); 
	     GuardarFallo("Index-Matrícula$Alumno");  
	 }
?>