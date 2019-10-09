// JavaScript Document
$(function() {
	//scripts docentes
	$(document).on("click", "a#mostrarDepto", function(){ mostrarDeptos(this); });	
	$(document).on("click", "a#regresarDepto", function(){ regresarDeptos(this); });	
	$(document).on("click", "a#grafPlantel", function(){ graficarPlantel(this); });	
	$(document).on("click", "a#grafDepto", function(){ graficarDeptos(this); });	
	$(document).on("click", "a#grafProf", function(){ graficarDocentes(this); });	
	$(document).on("click", "a#faltantesProf", function(){ faltantesDocentes(this); });	
	$(document).on("click", "a#faltantesAlum", function(){ faltantesAlumnos(this); });	
});

function mostrarDeptos(element) {
	var dep=$(element).attr('depto');
	openWindowWithPost("index.php", "_self",new Array("grafDepto"),new Array(dep));
}
function regresarDeptos(element) {
	openWindowWithPost("index.php", "_self",new Array(),new Array());
}
function graficarPlantel(element) {
	var pla=$(element).attr('plantel');
	openWindowWithPost("indexGraficarPlantel.php", "_blank",new Array("grafPlantel"),new Array(pla));
}
function graficarDeptos(element) {
	var dep=$(element).attr('depto');
	openWindowWithPost("indexGraficarDepto.php", "_blank",new Array("grafDepto"),new Array(dep));
}
function graficarDocentes(element) {
	var fol=$(element).attr('folio');
	openWindowWithPost("indexGraficarDocente.php", "_blank",new Array("grafProf"),new Array(fol));
}
function faltantesDocentes(element) {
	var fol=$(element).attr('folio');
	openWindowWithPost("indexFaltantesDocente.php", "_blank",new Array("faltantesProf"),new Array(fol));
}
function faltantesAlumnos(element) {
	var fol=$(element).attr('folio');
	openWindowWithPost("indexFaltantesAlumnos.php", "_blank",new Array("faltantesAlum"),new Array(fol));
}

function openWindowWithPost(url,target,keys,values)
{   var newWindow = window.open(url, target);
	 if(!newWindow) return false;
    var html="<html><head></head><body><form id='formid' method='post' action='" +url+"'>";
    if(keys && values && (keys.length == values.length))
        for (var i=0; i < keys.length; i++)
            html+="<input type='hidden' name='" + keys[i] + "' value='" + values[i] + "'/>";
    html+="</form><script type='text/javascript'>document.getElementById(\"formid\").submit()</sc"+"ript></body></html>";
    newWindow.document.write(html);
	 return newWindow;
}