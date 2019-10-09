<?php
   /***********************************************************
   ************************************************************   
                       E N C A B E Z A D O
   ************************************************************
   ***********************************************************/
	
	if(!isset($_SESSION["Iniciada"]) || $_SESSION["Iniciada"]!="Iniciada")
	{	GuardarFallo("Index-Iniciada");
		die;
	}
   include("configuracion.php");
   $conexion=new ClassConexion_DB($cfg['usuario'],$cfg['password'],$cfg['base'],"mysql",$cfg['host']);
	
	echo "<center>";
	if(isset($_POST["grafDepto"]))$SQL='SELECT DISTINCT plantel,DEP_NOM,folio,nom_prof,depto FROM '.$cfg['EncuestasPosgrado'].' INNER JOIN ConvertirDeptosaClave ON depto=CDC_CVE INNER JOIN '.$cfg['DDEP'].' ON CDC_DEP=DEP_CVE WHERE depto="'.$_POST["grafDepto"].'" ORDER BY depto,nom_prof;';
	else{ echo "<table border='1' class='datos'>"; $SQL='SELECT DISTINCT plantel,DEP_NOM,folio,nom_prof,depto FROM '.$cfg['EncuestasPosgrado'].' INNER JOIN ConvertirDeptosaClave ON depto=CDC_CVE INNER JOIN '.$cfg['DDEP'].' ON CDC_DEP=DEP_CVE ORDER BY depto,nom_prof;';}
	  $dEncuestas=new ClassConsulta($SQL,$conexion); $color=false; $dep=""; unset($pla);
	  while($Registro=$dEncuestas->fila())
	  {  if($dep!=$Registro["DEP_NOM"])
	  	  {  if(isset($_POST["grafDepto"]) && $dep!="")echo "</table>";
  		     $dep=$Registro["DEP_NOM"];		  
			  if(isset($_POST["grafDepto"]))
		     {  echo "<table border='1' class='datos' style='color:#ffffff;'>";
			  	  echo "<tr bgcolor='#6ac36a'><td colspan='4'><a style='color:#ffffff;' href='javascript:void(0);' id='grafDepto' depto='".$Registro['depto']."'><h3>$dep</h3></a></td></tr>";
			  	  echo "<tr bgcolor='#6ac36a'><td>Folio</td><td>Nombre Profesor</td><td>&nbsp;&nbsp;Avance</td><td>&nbsp;&nbsp;Faltantes</td></tr>";
			  }
			  else 
			  {  if(!isset($pla)){$pla=$Registro['plantel']; echo "<tr bgcolor='#6ac36a'><td align='left'><a style='color:#ffffff;' href='javascript:void(0);' id='grafPlantel' plantel='".$pla."'><h3>Plantel: $pla (Div.Est.Pos.Inv.)</h3></a></td></tr>"; }
			  	  echo "<tr bgcolor='#".($color?"888888":"aaaaaa")."'><td align='left'><a style='color:#ffffff;' href='javascript:void(0);' id='mostrarDepto' depto='".$Registro['depto']."'><h3>Elegir: $dep</h3></a></td></tr>";
			  }                                                                                                                                                                
			  $color=!$color;
		  }
	  	  if(isset($_POST["grafDepto"]))
		  {  echo "<tr bgcolor='#".($color?"888888":"aaaaaa")."'><td align='right'><a style='color:#ffffff;' href='javascript:void(0);' id='grafProf' folio='".$Registro['folio']."'>&nbsp;&nbsp;".$Registro['folio']."&nbsp;&nbsp;</a></td><td><a style='color:#ffffff;' href='javascript:void(0);' id='grafProf' folio='".$Registro['folio']."'>".$Registro['nom_prof']."</a></td><td><a style='color:#ffffff;' href='javascript:void(0);' id='faltantesProf' folio='".$Registro['folio']."'>&nbsp;&nbsp;Ver Avance&nbsp;&nbsp;</a></td><td><a style='color:#ffffff;' href='javascript:void(0);' id='faltantesAlum' folio='".$Registro['folio']."'>&nbsp;&nbsp;Ver Faltantes&nbsp;&nbsp;</a></td></tr>";
			  $color=!$color;
		  }		  
	  }
	 echo "</table></center>"; unset($cfg); 
?>