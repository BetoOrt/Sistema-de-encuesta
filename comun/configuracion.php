<?php
   $activo=1; //Activo es =>1 para dar acceso a la importación. Y es =>0 para desactivarla
   
   $tec   ="Instituto Tecnol�gico Superior de Teposcolula";
   $tec2 = "ITS. Teposcolula";
   $estado="27";
   $lema  ="Innovaci�n Tecnol�gica y Desarrollo Regional Sustentable"; //Lema Institución;
   $index ="http://192.168.10.13/evaltec";     //URL de la Página del Tec;
      
   //Parámetros de acceso a la Base de Datos
   $host ="localhost"; //'localhost';      //MODIFICABLE - MySQL Host
   $user ='evaldoc';   //'evaldoc';        //MODIFICABLE - MySQL Usuario
   $pass ='evaldoc';   //'evaldoc';        //MODIFICABLE - MySQL Password
   $year ='2019';      //'Año (4 dígitos)' //MODIFICABLE - Año
   $month='may';       //'Mes (may o nov)' //MODIFICABLE - Mes
   $SEMX = array("may"=>"ENE-JUN","nov"=>"AGO-DIC");
   $SEMM = array("may"=>"MAYO","nov"=>"NOVIEMBRE");
	$PERX=$SEMX[$month];
	$semestre=$PERX." ".$year;
	
	/*
	comun/configuracion
	importar4sie/dat.php
	importar4sie/dat_sie2evaldoc.php
	*/
?>
