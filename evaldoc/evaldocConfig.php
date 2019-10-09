<?php
	/***********************************************************
	************************************************************   
                C  O  N  F  I  G  U  R  A  C  I  O  N
	************************************************************
	***********************************************************/

/**************************************************************************
************************ CLAVES PARA MYSQL ********************************
**************************************************************************/
   //Parámetros de acceso a la Base de Datos
   $cfg['host']    = $host;        //MySQL Host
   $cfg['usuario'] = $user;        //MySQL User
   $cfg['password']= $pass;        //MySQL Password
   $cfg['permes']  = $year.$month; //'Año(4 dígitos) y mes(may o nov)'
   $cfg['base']    = 'evaldoc'.$cfg['permes'];                    //MySQL Base de Datos 'evaldocAAAAmmm'
   $cfg['SIE']     = $cfg['base'];      //'sie'; //$cfg['base'];  //MODIFICABLE - Ubicación de la Base de Datos del SIE
   //$SIEPrefijoTablas  = 'zSIE_';      //'';    //'zSIE_';       //MODIFICABLE - Prefijo de Concatenacion de las tablas del SIE
   //$SIEPrefijoCampo   = '.SIE_';      //'.';   //'.SIE_';       //MODIFICABLE - Prefijo de Concatenacion de los campos del SIE

   $SIEPrefijoTablas  = $cfg['permes'];  //'2009nov';'';'zSIE_';  //MODIFICABLE - Prefijo de Concatenacion de las tablas del SIE
   $SIEPrefijoCampo   = '.';             //'.';   //'.SIE_';      //MODIFICABLE - Prefijo de Concatenacion de los campos del SIE
   
/***************************************************************************
***************************************************************************/

/**************************************************************************
************************* HISTORIAL  ***************************
**************************************************************************/
   $CFGnPeriodos=0;
   //$CFGPeriodos[$CFGnPeriodos++]='2002may';
   //$CFGPeriodos[$CFGnPeriodos++]='2002nov';
   //$CFGPeriodos[$CFGnPeriodos++]='2003may';
   //$CFGPeriodos[$CFGnPeriodos++]='2003nov';
   //$CFGPeriodos[$CFGnPeriodos++]='2004may';
   //$CFGPeriodos[$CFGnPeriodos++]='2004nov';
   //$CFGPeriodos[$CFGnPeriodos++]='2005may';
   //$CFGPeriodos[$CFGnPeriodos++]='2005nov';
   //$CFGPeriodos[$CFGnPeriodos++]='2006may';
   //$CFGPeriodos[$CFGnPeriodos++]='2006nov';
   //$CFGPeriodos[$CFGnPeriodos++]='2007may';
   //$CFGPeriodos[$CFGnPeriodos++]='2007nov';
   //$CFGPeriodos[$CFGnPeriodos++]='2008may';
   //$CFGPeriodos[$CFGnPeriodos++]='2008nov';
   //$CFGPeriodos[$CFGnPeriodos++]='2009may';
	//$CFGPeriodos[$CFGnPeriodos++]='2009nov';
	//$CFGPeriodos[$CFGnPeriodos++]='2010may';
	//$CFGPeriodos[$CFGnPeriodos++]='2010nov';
	//$CFGPeriodos[$CFGnPeriodos++]='2011may';
	//$CFGPeriodos[$CFGnPeriodos++]='2011nov';
	//$CFGPeriodos[$CFGnPeriodos++]='2012may';
	//$CFGPeriodos[$CFGnPeriodos++]='2012nov';
	//$CFGPeriodos[$CFGnPeriodos++]='2013may';
	//$CFGPeriodos[$CFGnPeriodos++]='2013nov';
	//$CFGPeriodos[$CFGnPeriodos++]='2014may';
   //$CFGPeriodos[$CFGnPeriodos++]='2014nov';
   //$CFGPeriodos[$CFGnPeriodos++]='2015may';
	$CFGPeriodos[$CFGnPeriodos++]=$cfg['permes'];
/**************************************************************************
***************************************************************************
**************************************************************************/


/**************************************************************************
************************* EXTRAE LOS PARAMETROS ***************************
**************************************************************************/
   $conexion=new ClassConexion_DB($cfg['usuario'],$cfg['password'],$cfg['base'],"mysql",$cfg['host']);
   $dparametros=new ClassConsulta("SELECT * FROM parametros",$conexion);
   $rparametros=$dparametros->fila();
      
/**************************************************************************/		

/***************************************************************************
*********************  A C T I V A R    E V A L D O C  *********************
***************************************************************************/
   $cfg['activo']        = $rparametros['activo'];    //true o false
	$cfg['activoreportes']= $rparametros['reportes'];  //true o false
/**************************************************************************/

/***************************************************************************
******************* PARAMETROS PARA GENERAR LOS RESULTADOS *****************
***************************************************************************/
   //Parámetros para la exportación de la Base de Datos
   $cfg['periodo']= $rparametros['periodo']; //'MAY' | 'NOV'  //Período
   $cfg['plantel']= $rparametros['plantel']; // Nombre del Plantel
   $cfg['estado'] = $rparametros['estado'];  // Número del Estado de la Republica
   $cfg['ciclo']  = $rparametros['anio'];     // Número del Ciclo es igual al año, no está en base al cuestionario de alumnos CuestAlumSup200X.doc
   
/***************************************************************************
***************************************************************************/
   
/***************************************************************************
************************ PARAMETROS PARA EL SISTEMA ************************
/**************************************************************************/
   $cfg['instituto']= $rparametros['instituto']; //Instituto
   $cfg['semestre'] = $rparametros['semestre'];  //Semestre  = Ene-Jun | Ago-Dic                         
   $cfg['año']      = $rparametros['anio'];       //Año  
   //echo  $cfg['ciclo'];
   //die();                                
   $cfg['lema']     = $rparametros['lema'];      //'Tierra, Tiempo, Trabajo y Tecnología'; //Lema
   $cfg['index']    = $rparametros['index'];     //'http://www.itvillahermosa.edu.mx';     //URL Tec
//	$cfg['preguntasdeptos']=16;       // Número de preguntas sin incluir los comentarios
/***************************************************************************
***************************************************************************/


/**************************************************************************
*************************** DEFINICION DE TABLAS **************************
**************************************************************************/
   //Periodo
   $cfg['añoperiodo']           = $cfg['año'].strtolower($cfg['periodo']);   //Año y periodo de captura
   //Tablas
   $cfg['EncuestasAlumnos']     = $cfg['base'].'.'.$cfg['añoperiodo'].'EncuestasAlumnos';     //Encuestas de Alumnos
   $cfg['EncuestasPosgrado']    = $cfg['base'].'.'.$cfg['añoperiodo'].'EncuestasPosgrado';    //Encuestas de Posgrado
   $cfg['EncuestasRegistrados'] = $cfg['base'].'.'.$cfg['añoperiodo'].'EncuestasRegistrados'; //Alumnos ya Registrados en la Encuesta
   $cfg['Fallos']               = $cfg['base'].'.'.$cfg['añoperiodo'].'Fallos';               //Fallos en la Encuesta
   $cfg['Preguntas']            = $cfg['base'].'.'.$cfg['añoperiodo'].'Preguntas';            //Preguntas en la Encuesta
   $cfg['PreguntasRubros']      = $cfg['base'].'.'.$cfg['añoperiodo'].'PreguntasRubros';      //Rubros de las Preguntas en las Encuesta
   $cfg['GruposaContinuo']      = $cfg['base'].'.'.$cfg['añoperiodo'].'GruposaContinuo';      //Rubros de las Preguntas en las Encuesta


   //Constantes de los Procesos de Captura
   $cfg['LICENCIATURA']     =$rparametros['procesodesaca'];
   $cfg['POSGRADO']         =$rparametros['procesoposgrado'];
   $cfg['NIVELLICENCIATURA']=1;  
	$cfg['NIVELPOSGRADO']    =2;
  
  
   //**************************************************************************
   //*********************** Campos necesarios del SIE ************************
   //**************************************************************************
   $cfg['DALU'] = 'DALU';  //'DALU';                                         //MODIFICABLE - Alumnos
      $cfg['DALU'] = $SIEPrefijoTablas.$cfg['DALU'];  //Alumnos
      $cfg['ALU_CTR'] = $cfg['DALU'].$SIEPrefijoCampo.'ALU_CTR';      //'ALU_CTR';  //MODIFICABLE - Alumnos.NumeroControl
	  $cfg['ALU_NOM'] = $cfg['DALU'].$SIEPrefijoCampo.'ALU_NOM';      //'ALU_NOM';  //MODIFICABLE - Alumnos.Nombre   
	  //$cfg['ALU_PLA'] = $cfg['DALU'].$SIEPrefijoCampo.'ALU_PLA';      //'ALU_PLA';  //MODIFICABLE - Alumnos.Plan
	  $cfg['ALU_PLA'] = $cfg['DALU'].$SIEPrefijoCampo.'ALU_ESP';      //'ALU_PLA';  //MODIFICABLE - Alumnos.Plan
	  $cfg['ALU_SEM'] = $cfg['DALU'].$SIEPrefijoCampo.'ALU_SEM';      //'ALU_SEM';  //MODIFICABLE - Alumnos.Semestre
	  $cfg['ALU_PAS'] = $cfg['DALU'].$SIEPrefijoCampo.'ALU_PAS';      //'ALU_PAS';  //MODIFICABLE - Alumnos.Password
      $cfg['DALU']    = $cfg['SIE'].'.'.$cfg['DALU'];  //Alumnos
	  
	  $cfg['SIE_DALU'] = $cfg['DALU'];  //Alumnos del SIE solo para el accesso  
	  $cfg['SIE_ALU_CTR'] = $cfg['ALU_CTR'];  //Alumnos del SIE - Alumnos.NumeroControl
	  $cfg['SIE_ALU_NOM'] = $cfg['ALU_NOM'];  //Alumnos del SIE - Alumnos.Nombre   
	  $cfg['SIE_ALU_SEM'] = $cfg['ALU_SEM'];  //Alumnos del SIE - Alumnos.Semestre
   $cfg['DCAT'] = 'DCAT';  //'DCAT';                                         //MODIFICABLE - Catedráticos
      $cfg['DCAT'] = $SIEPrefijoTablas.$cfg['DCAT'];  //Catedráticos
      $cfg['CAT_CVE'] = $cfg['DCAT'].$SIEPrefijoCampo.'CAT_CVE';  //'CAT_CVE';  //MODIFICABLE - Catedraticos.Clave
	  $cfg['CAT_NOM'] = $cfg['DCAT'].$SIEPrefijoCampo.'CAT_NOM';  //'CAT_NOM';  //MODIFICABLE - Catedraticos.Nombre   
	  $cfg['CAT_DEP'] = $cfg['DCAT'].$SIEPrefijoCampo.'CAT_DEP';  //'CAT_DEP';  //MODIFICABLE - Catedraticos.Depto
	  $cfg['DCAT'] = $cfg['SIE'].'.'.$cfg['DCAT']; //Catedráticos
   $cfg['DDEP'] = 'DDEP';  //'DDEP';                                         //MODIFICABLE - Departamentos
      $cfg['DDEP'] = $SIEPrefijoTablas.$cfg['DDEP'];  //Departamentos
      $cfg['DEP_CVE'] = $cfg['DDEP'].$SIEPrefijoCampo.'DEP_CVE';   //'DEP_CVE'; //MODIFICABLE - Deptos.Clave
	  $cfg['DEP_NOM'] = $cfg['DDEP'].$SIEPrefijoCampo.'DEP_NOM';   //'DEP_NOM'; //MODIFICABLE - Deptos.Nombre
	  $cfg['DDEP'] = $cfg['SIE'].'.'.$cfg['DDEP'];  //Departamentos
   $cfg['DGAU'] = 'DGAU';  //'DGAU';                                         //MODIFICABLE - Grupos
      $cfg['DGAU'] = $SIEPrefijoTablas.$cfg['DGAU'];  //Grupos
      $cfg['GPO_MAT'] = $cfg['DGAU'].$SIEPrefijoCampo.'GPO_MAT';   //'GPO_MAT'; //MODIFICABLE - Grupos.Materia
	  $cfg['GPO_GPO'] = $cfg['DGAU'].$SIEPrefijoCampo.'GPO_GPO';   //'GPO_GPO'; //MODIFICABLE - Grupos.Grupo
	  $cfg['GPO_CAT'] = $cfg['DGAU'].$SIEPrefijoCampo.'GPO_CAT';   //'GPO_CAT'; //MODIFICABLE - Grupos.Catedratico
	  $cfg['DGAU'] = $cfg['SIE'].'.'.$cfg['DGAU'];  //Grupos
   $cfg['DLIS'] = 'DLIS';  //'DLIS';                                         //MODIFICABLE - Listas 
      $cfg['DLIS'] = $SIEPrefijoTablas.$cfg['DLIS'];  //Listas
      $cfg['LIS_CTR'] = $cfg['DLIS'].$SIEPrefijoCampo.'LIS_CTR';   //'LIS_CTR'; //MODIFICABLE - Listas.NumeroControl
	  $cfg['LIS_MAT'] = $cfg['DLIS'].$SIEPrefijoCampo.'LIS_MAT';   //'LIS_MAT'; //MODIFICABLE - Listas.Materia
	  $cfg['LIS_GPO'] = $cfg['DLIS'].$SIEPrefijoCampo.'LIS_GPO';   //'LIS_GPO'; //MODIFICABLE - Listas.Grupo
	  $cfg['DLIS'] = $cfg['SIE'].'.'. $cfg['DLIS'];  //Listas
   $cfg['DPLA'] = 'DPLA';  //'DPLA';                                         //MODIFICABLE - Planes
      $cfg['DPLA'] = $SIEPrefijoTablas.$cfg['DPLA'];  //Planes
      $cfg['PLA_CVE'] = $cfg['DPLA'].$SIEPrefijoCampo.'PLA_CVE';   //'PLA_CVE'; //MODIFICABLE - Planes.Clave
	  $cfg['PLA_NOM'] = $cfg['DPLA'].$SIEPrefijoCampo.'PLA_NOM';   //'PLA_NOM'; //MODIFICABLE - Planes.Nombre
	  $cfg['DPLA'] = $cfg['SIE'].'.'.$cfg['DPLA'];  //Planes
   $cfg['DRET'] ='DRET';   //'DRET';                                         //MODIFICABLE - Materias 
      $cfg['DRET'] =$SIEPrefijoTablas.$cfg['DRET'];  //Materias 
      $cfg['RET_CVE'] = $cfg['DRET'].$SIEPrefijoCampo.'RET_CVE';   //'RET_CVE'; //MODIFICABLE - Materias.Clave
	  $cfg['RET_NOM'] = $cfg['DRET'].$SIEPrefijoCampo.'RET_NOM';   //'RET_NOM'; //MODIFICABLE - Materias.Nombre
	  $cfg['DRET'] = $cfg['SIE'].'.'.$cfg['DRET'];  //Materias
	  
/***************************************************************************
***************************************************************************/


/**************************************************************************
************** PARAMETROS PARA EL ACCESO CUANDO HAY FALLOS ****************
**************************************************************************/
   $cfg['maximofallos']  = $rparametros['maximofallos'];    //Número máximo de fallos tolerados
   $cfg['horasespera']   = $rparametros['horasespera'];     //Número de horas que un intruso debe esperar para volver a intentar la captura
/***************************************************************************
***************************************************************************/
   

/**************************************************************************
******************* CLAVES PARA ACCEDER A LOS LISTADOS ********************
**************************************************************************/
   //Usuario que permite la entrada a la captura
   $cfg['desacaadmin']     = $rparametros['desacaadmin'];         //Usuario para el Acceso a los Reportes de Alumnos de Licenciatura
   $cfg['desacapassword']  = $rparametros['desacapassword'];      //Password del Usuario para el Acceso a los Reportes de Alumnos de Licenciatura
   $cfg['posgradoadmin']   = $rparametros['posgradoadmin'];       //Usuario para el Acceso a los Reportes de Alumnos de Posgrado 
   $cfg['posgradopassword']= $rparametros['posgradopassword'];    //Password del Usuario para el Acceso a los Reportes de Alumnos  de Posgrado
/**************************************************************************
***************************************************************************/
?>
