var PosicionMouseY=0;
document.onmousemove=function Coords(event)
{  if(document.all) PosicionMouseY=0; else PosicionMouseY=event.clientY;
}

document.onkeydown = function ManejadorCodigosTeclas()
{  if (window.event && (window.event.keyCode == 13))
   {  window.event.cancelBubble = true;
	  window.event.returnValue = false;
	  return false;
   }
}

function Elige(preg,opcion,finrubro)
{   document.forms["fPreguntas"]["R"+preg][opcion].checked=true;
	document.forms["fPreguntas"]["R"+preg][0].value=String.fromCharCode(65+opcion);	
	var mouseY;	if(!e) var e=window.event;
	/*no layers*/   if(window.event && !document.layers) { mouseY = event.clientY + document.body.scrollTop;	} 
    /*IE*/          else if(document.all && e.pageY)     { mouseY = e.pageY + 10; }   
	/*Mozilla*/ 	else if(PosicionMouseY)              { mouseY = PosicionMouseY  + document.body.scrollTop + document.documentElement.scrollTop; ; }
	/*Desconocido*/ else { MouseY=0; }
	if(finrubro==1) mouseY+=250;
	window.setTimeout("Scrollear("+mouseY+")", 200);
}

function Scrollear(mouseY)
{   var currentTop;
    if (document.all) currentTop=document.body.scrollTop;
    else              currentTop=window.pageYOffset;
    if(mouseY>currentTop+400) { window.scroll(0,currentTop+50); window.setTimeout("Scrollear("+mouseY+")", 200); }
	else return;
}

function Revisar()
{  var Checados=true,mensaje="",conector="";
   if(!(document.forms["fPreguntas"]["Alumno"].value!="" && document.forms["fPreguntas"]["Alumno"].value.length>4 && document.forms["fPreguntas"]["NumMat"].value!="" && document.forms["fPreguntas"]["Maestro"]!=null && document.forms["fPreguntas"]["Materia"]!=null && document.forms["fPreguntas"]["Grupo"]!=null))
	{  document.forms["fPreguntas"]["Alumno"].focus();
	   mensaje+=conector+"Los datos del Estudiante, Número de Materias, Profesor, Materia y Grupo deben ser capturados correctamente."+String.fromCharCode(10)+String.fromCharCode(10)+"Favor de capturarlos...";
      conector=String.fromCharCode(10)+String.fromCharCode(10);
		Checados=false;
	}
	var nPreguntas=document.forms["fPreguntas"]["nPreguntas"].value;
   var pregFaltantes="",contestada;
   for(var i=1;i<nPreguntas;i++)
   {  contestada=false;
      for(var j=0;!contestada && j<5;j++)
         if(document.forms["fPreguntas"]["R"+i][j]!=null)
            contestada=document.forms["fPreguntas"]["R"+i][j].checked;
      if(!contestada)
      {  if(pregFaltantes.length==0)
         {  if(i>1)document.forms["fPreguntas"]["R"+(i-1)][0].focus(); else document.forms["fPreguntas"]["Alumno"].focus();
            document.forms["fPreguntas"]["R"+i][0].focus()
         }				
         pregFaltantes+=(pregFaltantes.length>0?",":"")+i;
      }
   }
   if(pregFaltantes.length>0)
   {  Checados=false;
      if(pregFaltantes.length>2)mensaje+=conector+"Las preguntas: ["+pregFaltantes+"] no han sido contestadas... Favor de contestarlas.";
      else                      mensaje+=conector+"La pregunta: ["+pregFaltantes+"] no ha sido contestada... Favor de contestarla.";
   }
	
   if(Checados)	
	{  var datos="Le recordamos que sus datos son confidenciales y "+String.fromCharCode(10)+"serán desvinculados de su nombre en el momento "+String.fromCharCode(10)+"en que guarde."+String.fromCharCode(10)+String.fromCharCode(10)+"Esta guardando los datos del"+String.fromCharCode(10)+"Estudiante:"+String.fromCharCode(9)+"["+document.forms["fPreguntas"]["Alumno"].value+"] "+document.forms["fPreguntas"]["AlumnoNombre"].value+String.fromCharCode(10)+"Materia:"+String.fromCharCode(9)+"["+ document.forms["fPreguntas"]["Materia"].value+document.forms["fPreguntas"]["Grupo"].value+"] "+document.forms["fPreguntas"]["MateriaNombre"].value+String.fromCharCode(10)+"Maestro:"+String.fromCharCode(9)+"["+ document.forms["fPreguntas"]["Maestro"].value+"] "+document.forms["fPreguntas"]["MaestroNombre"].value;
	   Checados = window.confirm(datos+String.fromCharCode(10)+String.fromCharCode(10)+"¿Guardar los datos?");
	}
   else alert(mensaje);
	return Checados;
}
// JavaScript Document