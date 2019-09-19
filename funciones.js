function Buscar_almuerzo()
{   
    var resp = true;
    var arroz =document.frm_buscarAlmuezo.arroz;
	var diaIni =document.frm_buscarAlmuezo.diaIni;
	var mesIni =document.frm_buscarAlmuezo.mesIni;
	var annoIni =document.frm_buscarAlmuezo.annoIni;
	var diaFin =document.frm_buscarAlmuezo.diaFin;
	var mesFin =document.frm_buscarAlmuezo.mesFin;
	var annoFin =document.frm_buscarAlmuezo.annoFin;
    if(FechaValida(diaIni,mesIni,annoIni)==false || FechaValida(diaFin,mesFin,annoFin)==false)
	{
		alert("Las fecha Inicial y Final tienen que tener un formato dd/mm/AA o estar vacias totalmente");
		resp = false;
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




