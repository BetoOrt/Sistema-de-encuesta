<?php 
   $activo=1; //Activo es =>1 para dar acceso a la importación. Y es =>0 para desactivarla
 
  
   	include("../comun/configuracion.php");
   //////////////////////////////////////////////////////////////
   ///////////////////   T A B L A S    D E  ////////////////////
   ///////////////////C O N V E R S I O N E S////////////////////
   //////////////////////////////////////////////////////////////
   
   
   /*:::::::::::::::: LISTADO DE DEPARTAMENTOS ::::::::::::::::::::
   :::::::::::::::::: Tabla: ConvertirDeptosaClave ::::::::::::::::
   ::: Convirtiendo de la clave del SIE a la clave de un DÍGITO :::
   ::::::: Asignando PASSWORD para la ceptura en EVALDEP ::::::::::
                        SIE   DÍGITO  PASSWORD    
                      CDC_DEP CDC_CVE CDC_PAS		*/
   $deptos=array(array("101",  "1"),  //div                
			array("102",  "2"),  //div 
			array("103",  "3"),  //div 







			array("105", "5"),
			array("104",  "4")  //div 
			); //
                 
   
    /*:::::::::::::::::::: LISTADO DE CARRERAS :::::::::::::::::::::
    :::::::::::::::::: Tabla: ConvertirPlanesaCarreras :::::::::::::
    ::: Convirtiendo de la clave del SIE a la clave de un DGEST  :::
                         SIE    DGEST   NIVEL
                       CPC_PLA CPC_CAR CPC_NIV		*/			
	$carreras=array(array("91",   "091",   "1" ),  //ing admon
                   array("92",  "092",   "1" ),  //ing des com.
			  	   array("93",  "093",   "1" ),  //ing sis com  
array("95","095","1"),
                   array("94",  "094",   "1" )  //gastronomia 
                   ); //-
?>
