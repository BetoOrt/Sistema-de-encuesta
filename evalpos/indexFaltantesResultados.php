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
 
///Prepara variable que muestra el PERIODO y el ESTATUS de la gráfica.
   $letrero="$Estatus";
   $Estatus="";
	$titulo=$encabezado."<br>".$aplicacion;
	
///Inicia la gráfica.
   echo "<table border=1>";
   echo "   <tr>";
   echo "      <td align='center'>";
   echo "         <table border=0 width=400>";
   echo "            <tr><td align='center' nowrap='nowrap'><br/><font size='+1'>$titulo</font></td></tr>";
if(isset($departamento))
{	echo "            <tr><td align='center' style='font-family:SoberanaTitular' nowrap='nowrap'>$departamento</td></tr>";
}  
if(isset($numero))     
{	echo "            <tr>";
   echo "               <td align='center' nowrap='nowrap'>";
	echo "                  <table border=1>";
   echo "                     <tr><td>N&uacute;mero</td><td nowrap='nowrap'>: [$numero]</td></tr>";
   echo "                     <tr><td>Nombre</td><td nowrap='nowrap'>: [$nombre]</td></tr>";
	echo "                  </table>";
   echo "               </td>";
	echo "            </tr>";
}else
{  echo "            <tr><td style='font-family:SoberanaTitular' align='center' nowrap='nowrap'>$nombre</td></tr>";
}  echo "         </table>";
   echo "      </td>";
	echo "   </tr>";
   
if(isset($contadores))
{	echo "   <tr><td align='center'>";
   echo "          <table border=1><tr bgcolor='#e0e0e0'>";
	foreach($columnas as $col)echo "<th>&nbsp;&nbsp;".$col."&nbsp;&nbsp;</th>";
	echo "             </tr>";
	foreach($contadores as $cols)
	{  echo "          <tr>";
    	foreach($cols as $colval)
      	echo "           <td align='center'>$colval</td>";
	   echo "          </tr>";
	}
	echo "              <tr bgcolor='#e0e0e0'>";
	foreach($totales as $tot)echo "<td align='center'>$tot</td>";
	echo "             </tr>";
   echo "   </table></td></tr></table>";
}
?>