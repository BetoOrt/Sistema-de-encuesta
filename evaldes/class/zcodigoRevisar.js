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
{   var Checados=false;
    if(!(document.forms["fPreguntas"]["Admin"].value!="" && document.forms["fPreguntas"]["Admin"].value.length>4 && document.forms["fPreguntas"]["NumMat"].value!="" && document.forms["fPreguntas"]["Maestro"]!=null && document.forms["fPreguntas"]["Materia"]!=null && document.forms["fPreguntas"]["Grupo"]!=null))
	{  document.forms["fPreguntas"]["Admin"].focus();
	   alert("Los datos del Alumno, Número de Materias, Catedrático, Materia y Grupo deben ser capturados correctamente."+String.fromCharCode(10)+String.fromCharCode(10)+"Favor de capturarlos...");
	}
	else
	{   var nPreguntas=document.forms["fPreguntas"]["nPreguntas"].value;
		for(var i=1;i<nPreguntas;i++)
		{   Checados=false;
			for(var j=0;j<5;j++)
			   if (!Checados && document.forms["fPreguntas"]["R"+i][j]!=null)
				  Checados=document.forms["fPreguntas"]["R"+i][j].checked; 
			if(!Checados) 
			{  if(i>1)document.forms["fPreguntas"]["R"+(i-1)][0].focus(); else document.forms["fPreguntas"]["Admin"].focus();
			   document.forms["fPreguntas"]["R"+i][0].focus()
			   alert("La pregunta: "+i+" no ha sido contestada... Favor de contestarla."); i=nPreguntas;
			}    
		}
	}
	if(Checados)	
	{  var datos="Le recordamos que sus datos son confidenciales y "+String.fromCharCode(10)+"serán desvinculados de su nombre en el momento "+String.fromCharCode(10)+"en que guarde."+String.fromCharCode(10)+String.fromCharCode(10)+"Esta guardando los datos del"+String.fromCharCode(10)+"Alumno:"+String.fromCharCode(9)+"["+document.forms["fPreguntas"]["Admin"].value+"] "+document.forms["fPreguntas"]["AlumnoNombre"].value+String.fromCharCode(10)+"Materia:"+String.fromCharCode(9)+"["+ document.forms["fPreguntas"]["Materia"].value+document.forms["fPreguntas"]["Grupo"].value+"] "+document.forms["fPreguntas"]["MateriaNombre"].value+String.fromCharCode(10)+"Maestro:"+String.fromCharCode(9)+"["+ document.forms["fPreguntas"]["Maestro"].value+"] "+document.forms["fPreguntas"]["MaestroNombre"].value;
	   Checados = window.confirm(datos+String.fromCharCode(10)+String.fromCharCode(10)+"¿Guardar los datos?");
	}
	return Checados;
}
