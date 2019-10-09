<?php
   /***********************************************************
   ************************************************************   
                       P R E G U N T A S
   ************************************************************
   ***********************************************************/
if($Materia!=null)
{  //Lee las preguntas y muestra el Número de preguntas de la evaluación
   include("configuracion.php");
   	$conexion=new ClassConexion_DB($cfg['usuario'],$cfg['password'],$cfg['base'],"mysql",$cfg['host']);
	   if     ($Proceso==$cfg['LICENCIATURA'])  $tipo='A';
	   else if($Proceso==$cfg['POSGRADO'] )     $tipo='P';
      $SQL="SELECT rubtexto, ".$cfg['Preguntas'].".* FROM ".$cfg['PreguntasRubros']." INNER JOIN ".$cfg['Preguntas']." ON ".$cfg['PreguntasRubros'].".rubtipo=".$cfg['Preguntas'].".tipo AND ".$cfg['PreguntasRubros'].".rubclave=".$cfg['Preguntas'].".rubro WHERE tipo='".$tipo."';";
	  $dPreguntas=new ClassConsulta($SQL,$conexion);
	  $PREG['nPreg']=$dPreguntas->numfilas;
          echo '<center><table class="capturando"><tr><td>Número de preguntas de la evaluación: ';
          echo '<input style="width:50px" type="text" name="nPreguntas" size="1" maxlength="2" readonly value="'.$PREG['nPreg'].'">';
		  echo '</td></tr></table></center>';
   unset($cfg);  
      if($PREG['nPreg'])
	  {  $num_prgs=0; 
		 while($Registro=$dPreguntas->fila())
		    $PREG[$num_prgs++]=$Registro;
	  }
   //Muestra las preguntas
   $RubroNombre=null;
   if($PREG['nPreg'])
   {  for($i=0;$i<$PREG['nPreg'];$i++)
      {  if($RubroNombre!=$PREG[$i][0])
		 {  $RubroNombre=$PREG[$i][0];
			echo "<tr><td>".Repetir("<br>",($i>0?6:2))."</td></tr>";
			echo "<tr><td><hr><hr></td></tr>";
			echo "<tr><td bgcolor='#a0a0a0'><br><font class='rubros'>&nbsp;&nbsp;&nbsp;&nbsp;&laquo;$RubroNombre&raquo;&nbsp;&nbsp;&nbsp;&nbsp;</font><br><br></td></tr>";
			echo "<tr><td ><br></td></tr>";
		 }
		 $PregNum=$PREG[$i][3]; $PregTexto=$PREG[$i][4];
		 echo "<tr><td class='preguntas' bgcolor='#c9c9c9'><table><tr><td class='preguntas'>$PregNum.-</td><td class='preguntas'>$PregTexto</td></tr></table></td></tr>";
		 echo "<tr><td bgcolor='#fafafa'><table border=0 class='respuestas'><tr>";
		 if($i<$PREG['nPreg']-1){ $FinRubro=abs($PREG[$i][0]!=$PREG[$i+1][0]); for($j=5;$j<10;$j++) if($PREG[$i][$j]) echo "<td onMouseUp='Elige(".($i+1)." ,".($j-5)." ,".($FinRubro).")'><input class='radio' type='radio' name='R".($i+1)."' value='".chr(65+$j-5)."'>".$PREG[$i][$j].Repetir("&nbsp;",6)."</td>";}
		 else echo "<td><textarea style='width:1100px' name='R".$PREG['nPreg']."' cols='75%' rows='5' onKeyPress='maxlength(this,255)' onKeyUp='maxlength(this,255)'></textarea></td>";
		 echo "</tr></table><center></center></td></tr>";
		 echo "<tr><td><br><br></td></tr>";
      }
   }
}
else 
?>
<script> function maxlength(obj,largo) { if(!(obj.value.length<largo+1)) obj.value = obj.value.substring(0, largo);} </script>
