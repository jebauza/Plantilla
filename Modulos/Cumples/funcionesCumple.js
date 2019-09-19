function prueba()
{   
	alert("Pincha");
	return false;
}

function felicitaciones()
{
	var resp = true;
	var comentario =document.fm_insertar_felicitacion.comentarioCumple;
	if(Esvacio(comentario))
	{
		resp = false;
		alert("El campo comentario no puede estar vacio");
	}
	return resp;
}

function Buscar_persona_cumple()
{   
    var resp = true;
    var dia =document.fm_buscar_persona_fecha.dia;
	var mes =document.fm_buscar_persona_fecha.mes;
	var anno =document.fm_buscar_persona_fecha.anno;
	
	var diaIni =document.fm_buscar_persona_fecha.diaIni;
	var mesIni =document.fm_buscar_persona_fecha.mesIni;
	var annoIni =document.fm_buscar_persona_fecha.annoIni;
	var diaFin =document.fm_buscar_persona_fecha.diaFin;
	var mesFin =document.fm_buscar_persona_fecha.mesFin;
	var annoFin =document.fm_buscar_persona_fecha.annoFin;
	
	var edad =document.fm_buscar_persona_fecha.edad;
	
    var arrInfo = hayUnSoloTipoBusquedad([[dia,mes,anno],[diaIni,mesIni,annoIni,diaFin,mesFin,annoFin],[edad]]);
	var funciones = ["validoBusquedadFecha([dia,mes,anno])","validoBusquedadIntervalo(diaIni,mesIni,annoIni,diaFin,mesFin,annoFin)","validoBusquedadEdad(edad)"]
	if(arrInfo[0]==-1)
	{
		alert('Solo puede escojer un tipo de busqueda "fecha, Intervalo o edad".');
		resp = false;
	}
	else
	{
		if(eval(funciones[arrInfo[1]]) == false)
		{
			switch(arrInfo[1]) 
			{
              case 0:
                alert("La fecha tiene que tener al menos un campo lleno");
              break;
			  
			  case 1:
                alert("Las fecha Inicial o Final tienen que tener un formato dd/mm/AA o estar vacia totalmente, ademas la fecha inicial debe ser menor que la final");
              break;
			  
			  case 2:
               alert("La edad tiene que ser solo numeros y estar entre 16 y 100 year");
              break;
            }	
			resp = false;
	    }
		
	}
	if(resp)
	{
		 switch(arrInfo[1]) 
			{
              case 0:
                document.getElementById("tipoBusquedad").value = "busqFecha";
              break;
			  
			  case 1:
               document.getElementById("tipoBusquedad").value = "busqIntervalo";
              break;
			  
			  case 2:
               document.getElementById("tipoBusquedad").value = "busqEdad";
              break;
            }
		   //alert(document.getElementById("tipoBusquedad").value);
	}
	return resp;
}






















function SonNumeros(valor)
{
	var numeros = "0123456789"; 
	var resp = true;
	for(var i=0;i<valor.length && resp == true;i++)
	{
		resp = false;
		for(var j=0;j<numeros.length && resp == false;j++)
	      {
		     if(valor.charAt(i) == numeros.charAt(j)) //Si valor en i es una letra tanto minuscula como mayuscula-toUpperCase()
			 {
				 resp = true;
			 }
	      }
	}
	return resp;
}


function Esvacio(valor)
{
	if(valor.value.length == 0 || valor.value.indexOf("  ") != -1 || valor.value.charAt(0)==" " || valor.value.charAt(valor.value.length -1)==" " || valor.value.split(" ").length < 1)
	{
		return true;
	}
	return false;
}

function FechaValida(dia,mes,anno)
{
	if(!(dia.value.length == 0 && mes.value.length == 0 && anno.value.length == 0) && !(dia.value.length != 0 && mes.value.length != 0 && anno.value.length != 0))
	{
		return false;
	}
	return true;
}

function validoBusquedadFecha(arrayDatos)
{
	return true;
}

function validoBusquedadIntervalo(diaIni,mesIni,annoIni,diaFin,mesFin,annoFin)
{
	var resp = true;
    if(FechaValida(diaIni,mesIni,annoIni)==false || FechaValida(diaFin,mesFin,annoFin)==false)
	{
		resp = false;
	}
	if(resp && !Esvacio(diaIni) && !Esvacio(diaFin))
	{
		var fechaIni = parseInt(diaIni.value)+parseInt(mesIni.value*10)+parseInt(annoIni.value*1000);
		var fechaFin = parseInt(diaFin.value)+parseInt(mesFin.value*10)+parseInt(annoFin.value*1000);
		//var mayor = "FechaFin";
		if(fechaIni >= fechaFin)
		{
			//mayor = "FechaIni";
			resp = false;
		}
		//alert("FechaInic: "+fechaIni+" / FechaFin: "+fechaFin+" / la fecha mayor es la: "+mayor);
	}
	return resp;
}

function validoBusquedadEdad(edad)
{
	var resp = SonNumeros(edad.value);
	if(resp == true && (edad.value < 16 || edad.value > 100))
	{
		resp = false;
	}
	return resp;
}

function hayUnSoloTipoBusquedad(arrayDatos)
{
	var resp = true;
	var seguir = true;
	var arr = [-1,""];
	for(i = 0;i<arrayDatos.length && resp == true;i++)
	{
		 seguir = true;
		 for(w = 0;w<arrayDatos[i].length && seguir == true;w++)
	     {
		    if(!Esvacio(arrayDatos[i][w]))
		    {
			   arr[0] = arr[0]+1;
			   arr[1] = i;
			   seguir = false;
			   if(arr[0] > 0)
			   {
				   arr[0] = -1;
			   }
		    }
	     }
	}
	return arr;
}








