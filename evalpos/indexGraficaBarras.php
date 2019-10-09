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
	echo "            <tr><td align='center' style='font-family:SoberanaTitular' nowrap='nowrap'>DIVISIÓN DE ESTUDIOS DE POSGRADO E INVESTIGACIÓN</td></tr>";
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
{	echo "   <tr><td align='center'><table border=1>";
	echo "<tr bgcolor='#e0e0e0'><th>&nbsp;&nbsp;".$columnas[0]."&nbsp;&nbsp;</th><th>&nbsp;&nbsp;".$columnas[1]."&nbsp;&nbsp;</th></tr>";
	foreach($contadores as $col1 => $col2)
      echo "<tr><td align='center'>$col1</td><td align='center'>$col2</td></tr>";
   echo "   </table></td></tr>";
}

///Selecciona y carga los Rubros en el arreglo "$aRubros".
///Calcula el número de Rubros en la variable: "$nRubros".
   $SQL="SELECT rubclave,rubtexto FROM ".$cfg["PreguntasRubros"]." WHERE rubtipo='A' ORDER BY rubclave;";
   $dRubros=new ClassConsulta($SQL,$conexion);
		
   $nRubros =0;
   while($Registro=$dRubros->fila())
	{//Obtener la letra del Rubro.
      $aRubros[$Registro["rubclave"]]=$Registro["rubtexto"];
      $nRubros++;
   }

///Selecciona y carga los rubros de cada Pregunta en el arreglo: "$aPreg".
///Calcula el inicio y final de cada rubro en la respuesta.
   $SQL="SELECT * FROM ".$cfg["Preguntas"]." WHERE tipo='A' ORDER BY rubro,numero;";
   $dPreg=new ClassConsulta($SQL,$conexion);

   $nPreg =0;
   unset($rango);
   while($Registro=$dPreg->fila())
   {  $aPreg    [$nPreg]        =$Registro["rubro"];
      $aContador[$aPreg[$nPreg]]=0;
      $aSuma    [$aPreg[$nPreg]]=0;
      $SumaFinal                =0;
   ///Calculando el inicio y final de cada rubro en la respuesta.
      if(!isset($rango[$aPreg[$nPreg]]["let"]))
      {  $rango[$aPreg[$nPreg]]["let"]=$aPreg[$nPreg];
         $rango[$aPreg[$nPreg]]["ini"]=$nPreg;
         $rango[$aPreg[$nPreg]]["fin"]=$nPreg;
      }
      else $rango[$aPreg[$nPreg]]["fin"]++;
      $nPreg++;
   }
   $nPreg--;                        //Restando uno porque la pregunta de Comentarios no debe contarse.
   $rango[$aPreg[$nPreg]]["fin"]--; //Restando uno porque la pregunta de Comentarios no debe contarse.

///Calcula las sumas totales y los contadores para cada pregunta.
///Esta sección es especial porque tiene varios criterios de aplicación, según sea el Rubro.
   $global_rubro=array();
   for($i=0; $i<$nPreg; $i++)
   {//Calcula la letra y su valor de acuerdo a la posición.
      $letra=substr($resp,$i,1);
		if($letra!="N")
      {  $Inc=5-strpos("ABCDE",$letra); //A:5, B=4, C:3, D:2, E:1
         $aSuma    [$aPreg[$i]]+=$Inc;
         $aContador[$aPreg[$i]]++;
			$global_rubro[$aPreg[$i]]+=$global_prom[$i];
	   }
   }
	
///Se calcula el Totales para cada rubro.
	$global_acumulado=array();
   $nR=0;
   for($i=0; $i<$nRubros; $i++)
   {  $rub=chr($i+65); //A,B,C,...

      if($aSuma[$rub]>=0) 
      {  $global_acumulado[$rub]=$global_rubro[$rub]/$aContador[$rub];
         $SumaFinal+=$global_acumulado[$rub];
			$nR++;			
      }
      else $global_acumulado[$rub][$rub]=-1; 
      
	  $letraAcum       ="n";
	  $textoNivel      ="";
	  if     ($global_acumulado[$rub]>=4.75){$textoNivel="EXCELENTE";  $letraAcum="F";}
 	  else if($global_acumulado[$rub]>=4.25){$textoNivel="NOTABLE";    $letraAcum="E";}
	  else if($global_acumulado[$rub]>=3.75){$textoNivel="BUENO";      $letraAcum="D";}
	  else if($global_acumulado[$rub]>=3.25){$textoNivel="SUFICIENTE"; $letraAcum="C";}
	  else                                 {$textoNivel="DESEMPEÑO INSUFICIENTE"; $letraAcum="B";}
     $letraNivel[$rub]=$letraAcum; 			
	  $aNivel    [$rub]=$textoNivel;
   }
   
///Calcular los promedios Final y por Caso.
///Calcular el nivel alcanzado según la escala y el promedio.
   $PromedioFinal     =strval(sprintf("%4.2f",$nR>0?$SumaFinal/$nR:0));
   $nivelFinal        ="";
		if     ($PromedioFinal>=4.75)$nivelFinal="EXCELENTE"; 
		else if($PromedioFinal>=4.25)$nivelFinal="NOTABLE";   
		else if($PromedioFinal>=3.75)$nivelFinal="BUENO";    
		else if($PromedioFinal>=3.25)$nivelFinal="SUFICIENTE";
		else                         $nivelFinal="DESEMPEÑO INSUFICIENTE";

 ///Escala de la Gráfica
    $escala=30; 
	 
 ///Dibuja la gráfica
   echo "   <tr>"; 
   echo "      <td align='center'>";
   echo "         <table>";
   echo "            <tr align='center' valign='bottom'>";
   echo "               <td align='right'><img name='0' src='rcs/r0.jpg' height='330' style='height:".($escala*5+20)."px'></td>";
		for($i=0; $i<$nRubros; $i++)
		{  $rub =chr($i+65); //A,B,C,...
			$r   =strtolower($letraNivel[$rub]); //chr($i+97); //a,b,c,...
			$alto=$global_acumulado[$rub];
			if($alto>=0)
			{   echo "     <td>".sprintf("%4.2f",$alto)."<br>".
							      "<table>".
										"<tr><td colspan=3><img src='rcs/r$r"."1.jpg' height=2 style='height:2px' width='42'></td></tr>".
										"<tr><td colspan=3><img src='rcs/r$r"."1.jpg' height=2 style='height:2px' width='44'></td></tr>".
										"<tr>".
											"<td valign='top'><img src='rcs/r$r"."2.jpg' height='".($alto*$escala-4)."' style='height:".($alto*$escala-4)."px' width='2'></td>".
											"<td valign='top'><img src='rcs/r$r"."2.jpg' height='".($alto*$escala-2)."' style='height:".($alto*$escala-2)."px' width='2'></td>".
											"<td>             <img src='rcs/r$r.jpg'     height='".($alto*$escala)."'   style='height:".($alto*$escala)."px'   width='40'></td>".
										"</tr>".
									"</table>".
							   "</td>";
			}
		}
   echo "            </tr>";
   echo "            <tr align='center'>";
   echo "                <td>Rubro:</td>";
		for($i=0; $i<$nRubros; $i++)
		{  $rub=chr($i+65); //A,B,C,...
			if($global_acumulado[$rub]>=0)echo "<td>".$rub."</td>";
		}
   echo "            </tr>";
   echo "         </table>";
   echo "      </td>";
   echo "   </tr>";
	
///Generando la tabla de Resultados por Rubro
   echo "   <tr>";
   echo "      <td align=center><br/>";
   echo "         <table border=1>";
   echo "            <tr bgcolor='#CCCCCC'><td align='center'>ASPECTOS</td><td align='center'>PUNTAJE</td><td align='center'>NIVEL DE<br>DESEMPEÑO</td></tr>";
     for($i=0; $i<$nRubros; $i++)
        {  $rub=chr($i+65); //A,B,C,...
           if($global_acumulado[$rub]>=0)
			  {   echo "<tr><td>".$rub.":".$aRubros[$rub]."</td>".
			               "<td align='center'>".
								    sprintf("%4.2f",$global_acumulado[$rub]). 
                        "</td>".
								"<td align='center'>".$aNivel[$rub]."</td>".
							"</tr>";
			  }
        }
   echo "         </table><br/>";
   echo "         <table border=1>";
   echo "            <tr>".
	                     "<td><font size=3>Resultado Global ". //"(Caso".$caso.")".
                           ":</font>".
							   "</td>".
								"<td>".
								   "<font size='3'>". //"(".$PromedioFinal.")".
                                $PromedioFinal.
								   "</font>".
								"</td>".
								"<td><font size='3'>$nivelFinal</font></td>".
						   "</tr>";
   echo "         </table>";
   echo "         <br/>";
   echo "      </td>";
   echo "   </tr>";
                    
           
   echo "</table><br/>";
	//if($letrero!="") echo "</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>";
?>