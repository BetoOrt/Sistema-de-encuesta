<?php
/***********************************************************
************************************************************   
                 evaldepGraficasBarras.php
************************************************************
***********************************************************/
   if(!isset($_SESSION["Iniciada"]) || $_SESSION["Iniciada"]!="Iniciada")
	{	GuardarFallo("Index-Iniciada");
		die;
	}
?>
<style type="text/css">     
	@media print
	{  @page port { size: portrait; }
		.portrait  { page: port; }
		
		@page land { size: landscape; }
		.landscape { page: land; }                
		
		.break { page-break-before: always; }
	}
</style>
<?php  
	$titulo=$encabezado."&nbsp;&nbsp;".$aplicacion;
	 
///Inicia la gráfica.///Se salta a otra hoja
   $header="<div class='portrait break'>&nbsp;</div>"
	       ."<table border=1>"
          ."   <tr>"
          ."      <td align='center'>"
          ."         <table border=0 width=400>"
          ."            <tr><td align='center' nowrap='nowrap'><font size='+1'>$titulo</font></td></tr>"
			 ."            <tr>"
          ."               <td align='center' nowrap='nowrap'>"
			 ."                  <table border=1>"
          ."                     <tr><td nowrap='nowrap'>Folio: [$numero]&nbsp;&nbsp;Nombre: [$nombre]&nbsp;&nbsp;Depto: $departamento</td></tr>"
          ."                  </table>"
          ."               </td>"
	       ."            </tr>"
          ."         </table>"
          ."      </td>"
	       ."   </tr>"
			 ."</table>"
			 ."<table>";
	   
 	$SQL='SELECT comentario FROM '.$cfg['EncuestasPosgrado'].' INNER JOIN ConvertirDeptosaClave ON depto=CDC_CVE INNER JOIN '.$cfg['DDEP'].' ON CDC_DEP=DEP_CVE WHERE folio='.$_POST["grafProf"].' AND TRIM(comentario)<>"" ORDER BY numcues;';
	$dEncuestas=new ClassConsulta($SQL,$conexion);
	$imprimir=true; $color=true; $número=0; //$contador=0;
	while($Registro=$dEncuestas->fila())
	{  if($imprimir)
	   {  /*echo "</table>";*/
			echo $header;
			$imprimir=false;
		}
		echo "<tr bgcolor='#".($color?"EEEEEE":"FFFFFF")."'><td valign='top' align='center'><font size='1'>".(++$número)."</font></td><td><font size='2'>".$Registro['comentario']."</font></td></tr>";
		$color=!$color;
		/*$contador++;
		if($contador>=44)
		{  $contador=0;
			$imprimir=true;
		}*/
	}
	/*if($imprimir && $contador>0)
	{  echo "</table>";
	   //echo '<div class="portrait break">&nbsp;</div>';
		echo $header;
		$imprimir=false;
	}*/
           
   echo "</table>";
	//if($letrero!="") echo "</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>";
?>
