<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>ITVillahermosa</title>
<link rel="icon" type="image/png" href="images/favicon.ico" />
<!--[if lt IE 9]>
<script src="scripts/ie9.js">IE7_PNG_SUFFIX=".png";</script>
<![endif]-->
<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="stylesheets/style.css"> 
<link rel="stylesheet" href="stylesheets/responsive.css">
<link href="stylesheets/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css" />

<script src="scripts/jquery.min.js"></script> 
<script src="scripts/jquery.bxSlider.min.js"></script>
<script src="scripts/jquery.blackandwhite.min.js"></script>
<script src="scripts/js_func.js"></script>
<script src="scripts/bootstrap.js"></script>
<script src="scripts/bootstrap.min.js"></script>
<script>
$(function(){
	$('.features_slider').bxSlider({
		auto: false,
		displaySlideQty: 5,
		moveSlideQty: 1,
    	speed : 1000
	});
	$('.intro_slider').bxSlider({
		auto: false,
		controls : false,
		mode: 'fade',
		pager: true
	});	
    $('.bwWrapper').BlackAndWhite({
        hoverEffect : true,
        webworkerPath : false,
        responsive:true,
        invertHoverEffect:false
    });
});
</script>
</head>
<body>
<div class="wraper">
<header class="encabezado">
	<div class="imagen1">
  		<img src="images/logosep1.png">
	</div>
       
  	<div class="titulo1">
    <p>Instituto Tecnológico de Villahermosa</p>
    </div>
    <div class="titulo2">
    <p>"Tierra, Tiempo, Trabajo y Tecnología"</p>
    </div>
   
  </header>
 <?php include("navigation.php"); ?>
   
</div> 

<div class="content_block">
 <!-- top_title -->
 <div class="top_title">
  <div class="wraper">
   <h2>Servicio Social Agosto - Diciembre 2013<span></span></h2>
  </div>
 </div>
 <center>
 <table width=60% align=center><tr><td>
<center><font size="5" color="#6AC36A"><b>FORMATOS</b></font></center>
<br/>
<!--<p align="justify"><h6>Para descargar estos documentos, dé <b>clic derecho</b> con el mouse y a continuación seleccione <b>"Guardar destino como.."</b> y seleccione la ubicación donde desea guardar el documento.</h6></p>-->
<div align="center">
<?php
function Option($doc,$name) {
		echo "<tr>";
		echo "<td width='8%' valign='top'><img src='images/closed.png'></td>";
		echo "<td width='100%'>$name</td>";
		echo "<td valign='top'><a href='$doc'><button class='btn-info' type='button'>Descargar</button></a></td>";
		echo "</tr>";
	}
	
function FormatPDF($doc,$name) {
		echo "<tr>";
		echo "<td valign='top'><a href='$doc'><img src='/images/iconpdf.gif' border=0></a></td>";
		echo "<td valign='top'><font size=2><a href='$doc'>$name</a></td>";
		echo "</tr>";
	}	 

	function FormatWord($doc,$name) {
		echo "<tr>";
		echo "<td valign='top'><a href='$doc'><img src='/images/iconword.gif' border=0></a></td>";
		echo "<td valign='top'><font size=2><a href='$doc'>$name</a></td>";
		echo "</tr>";
	}

	function FormatExcel($doc,$name) {
		echo "<tr>";
		echo "<td valign='top'><a href='$doc'><img src='/images/iconexcel.gif' border=0></a></td>";
		echo "<td valign='top'><font size=2><a href='$doc'>$name</a></td>";
		echo "</tr>";
	}

	function FormatPowerPoint($doc,$name) {
		echo "<tr>";
		echo "<td valign='top'><a href='$doc'><img src='/images/iconpowerpnt.gif' border=0></a></td>";
		echo "<td valign='top'><font size=2><a href='$doc'>$name</a></td>";
		echo "</tr>";
	}
?>

<table class="table table-hover" cellspacing=10 cellmargin=0 border=0 width="85%">
<?php
Option("/doc/GAFETE GYM PROP 2013.ppt","Gafete Gimnasio 2013");
Option("/doc/serviciosocial/DependenciasServicioSocial.doc","Dependencias para Realizar el Servicio Social");
?>
</table>
<br/><br/>
<h5>** Formatos para Planes por Competencias (2010) **</h5>
<table class="table table-hover" cellspacing=10 cellmargin=0 border=0 width="85%">
<?php
Option("/doc/serviciosocial/ITVH-VI-PO-004-01_SolicitudServicioSocialPorCompetencias.docx","Solicitud Servicio Social con enfoque por Competencias");
Option("/doc/serviciosocial/ITVH-VI-PO-004-02_CartaCompromisoDeServicoSocial.docx","Carta Compromiso de Servicio Social");
Option("/doc/serviciosocial/ITVH-VI-PO-004-05_EvaluacionDeServicioSocialBimestraloFinal.docx","Evaluación de Servicio Social Bimestral o Final");
Option("/doc/serviciosocial/ITVH-VI-PO-004-06_CartaDeTerminacionDeLaOrganizacion.doc","Carta de Terminación de la Organización");
?>
</table>
<br/><br/>
<!--<font size="3" color="#008000"><B>--><h5>** Formatos para Planes Tradicionales (2004) **</h5><!--</B></font>-->
<table class="table table-hover" cellspacing=10 cellmargin=0 border=0 width="85%">
<?php
Option("/doc/serviciosocial/ITVH-VI-PO-002-01.DOC","Solicitud Servicio Social");
Option("/doc/serviciosocial/ITVH-VI-PO-002-02.DOC","Carta Compromiso de Servicio Social");
Option("/doc/serviciosocial/ITVH-VI-PO-002-04.DOC","Reporte Bimestral de Servicio Social");
?>
</table>
</td></tr></table>
</br></br></br></br></br></br>
</center>
<!-- footer -->
<!-- social block -->
<div class="social_block">
 <div class="wraper">
  <p>Mantente informado en las redes sociales!</p>
  <ul>
   <li class="facebook"><a href="http://www.facebook.com/ITVillahermosa1">Facebook</a></li>
   <li class="twitter"><a href="http://twitter.com/itvh">Twitter</a></li>
    </ul>
 </div>
</div>
<!-- /social block -->

<div class="footer">
        	<footer>
            	<!-- bottom about -->
                <div class="bottom_about">
                	<table cellpadding="4" border="0"><tr>
                    <th width="88"><img src="images/itvh.png" width="100%"/></th>
                    <th width="160" align="left">Instituto Tecnológico de Villahermosa</th>
                    </tr></table>
                    
                </div>
                <!-- /bottom about -->
                
                <!-- recent tweets -->
                <div class="recent_tweets">
                 <h3><span>Tweets Recientes</span></h3>
                	<!--<h3>ITVillahermosa en Twitter:</h3>-->
                    <a class="twitter-timeline" data-dnt="true" href="https://twitter.com/itvh"  data-widget-id="354073721813729281">Tweets por @itvh</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				</div>
                <!-- /recent tweets -->
                
                <!-- recent posts -->
                <div class="recent_posts">
                <h3><span>Enlaces Institucionales</span></h3>
                	
                    <ul>
                       	<li><a href="http://www.sep.gob.mx">Secretaria de Educación Pública</a></li>
                        <li><a href="http://www.dgest.gob.mx">DGEST</a></li>
                        <li><a href="http://www.presidencia.gob.mx">Presidencia</a></li>
                         
                    </ul>
                </div>
                <!-- /recent posts -->
                
                <!-- subscribe block -->
                
                <div class="subscribe_block">
                	<h3><span>Suscribete</span></h3>
                    <form method="post" action="#">
                    <p><input type="text" id="name" value="NAME ..." /></p>
                    <p><input type="text" id="email" value="EMAIL ..." /></p>
                    <p><input type="submit" class="btn_s"  value="Suscribe" /></p>
                    </form>
                </div>
                <!-- /subscribe block -->
                
         
            </footer>
        </div>

<!-- copyright -->
<div class="copyright">
 <div class="wraper">
  <p><span>Copyright &copy; 2013</span>Todos los derechos reservados<a href="#">ITVillahermosa</a><a href="#">ISO-9001-2008</a></p>
  <a class="top" href="#">Regresar arriba</a>
 </div>
</div>
<!-- /copyright -->
<!-- /footer -->
</body>
</html> 
