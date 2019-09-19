<?php session_start();?>
<?php

//Cargar todas las personas Dbase
if(isset($_GET['cargarDbase']) && $_GET['cargarDbase'] == "si")
{
  cargar_ENsession_BD_personas();
}

//Actualiza La BD MySQL con todas las personas de la BD Dbase
if(isset($_GET['actualizarBDMySQLconDBase']) && $_GET['actualizarBDMySQLconDBase'] == "si" /*&& isset($_SESSION['login']['user']) && $_SESSION['login']['user']=="bauza"*/)
{
	include '../../Class/modelo_persona.php';
	$ClassPersona = new Persona();
	$consulta = $ClassPersona->buscar_todas_personas();
	$arrBDMySQL = array();
    while($persona=$consulta->fetch_object())
    {
	   $arrBDMySQL[] = $persona;
    }
	include '../../Class/modelo_Dbase.php';
	$ClassDbase = new Dbase();
    $arrDbase = $ClassDbase->dar_BD_dbase_unida_correo()['arrBDkey'];
	$arrEntrarBDMySQL = actualizarBDMySQLconDBase($arrDbase,$arrBDMySQL);
	if(count($arrEntrarBDMySQL)>0 && ($ClassPersona->eliminar_todas_personas() || count($arrBDMySQL)==0))
    { 
        $ClassPersona->actualizar_personas_BD($arrEntrarBDMySQL);
    }
	header ("location: ../Plantilla/page.php?var=page");
}

//Actualizar RMS
if(isset($_GET['cargarMarcacionesRMS_Mes']) && $_GET['cargarMarcacionesRMS_Mes']="si")
{
   
   require("../../Class/modelo_RmsAccess.php");
   $ClassRMS = new RmsAccess();
   $ClassRMS->copiarRMSdeSEMANAparaMES();
   header ("location: ../Plantilla/page.php?var=page");
}

//--------------------------------FUNCIONES---------------------------------------------------------

function cargar_ENsession_BD_personas()
{
  unset($_SESSION['directorioEmproy2']['directorioBD']['busqueda']);
  include '../../Class/modelo_Dbase.php';
  $ClassDbase = new Dbase();
  $arrBDdbase = $ClassDbase->dar_BD_dbase_unida_correo();
  if(true)
  { 
     if(count($arrBDdbase)>0)
     {
        $_SESSION['directorioEmproy2']['directorioBusq'] = $arrBDdbase['arrBDkey'];
	    $_SESSION['directorioEmproy2']['directorioBD']['key'] = $arrBDdbase['arrBDkey'];
		$_SESSION['directorioEmproy2']['cumple']['cumplesHoy'] = $arrBDdbase['arrCumplesHoy'];
     }
	 else
	 {
	   $_SESSION['directorioEmproy2']['errorSist']=false;
	 }
  }
  header ("location: ../Plantilla/page.php?var=page");
}

function actualizarBDMySQLconDBase($arrDbase,$arrDBMySQL)
{
	/*echo '<pre>';
	print_r($arrDbase);
	echo '</pre>';*/
    $arrMySQL = $arrDBMySQL;
	$arrResp = array();
    for ($i=0;$i<count($arrDbase);$i++)
	{
		$arrAux = array();
	    $nombre = trim($arrDbase[$i]['NOMBRES'])." ".trim($arrDbase[$i]['APELLIDO_1'])." ".trim($arrDbase[$i]['APELLIDO_2']);
		$hora_entrada_salida = "";
		if(strlen(trim($arrDbase[$i]['HORESPE'])) != 0 && strlen(trim($arrDbase[$i]['HORESPS'])) != 0 && stristr($arrDbase[$i]['HORESPE'], ' m') == false && stristr($arrDbase[$i]['HORESPS'], ' m') == false)
		{
			$hora_entrada_salida = $arrDbase[$i]['HORESPE']."-".$arrDbase[$i]['HORESPS'];
		}
		$arrDatos = array('USER'=>explode(" ",$nombre)[0]."-".trim($arrDbase[$i]['C_IDENTID']),'NOMBRE'=>$nombre,'CORREO'=>trim($arrDbase[$i]['correoEmp']),'NO_TARJETA'=>trim($arrDbase[$i]['NO_TARJETA']),'AREA_NUM'=>trim($arrDbase[$i]['AREA']),'AREA'=>trim($arrDbase[$i]['AREAD']),'CODIGO_DPTO'=>trim($arrDbase[$i]['CODPTO']),'DEPARTAMENTO'=>trim($arrDbase[$i]['DPTO']),'C_IDENTIDA'=>trim($arrDbase[$i]['C_IDENTID']),'SEXO'=>trim($arrDbase[$i]['SEXO']),'PASS_DOMINIO'=>null,'FECHA_ALTA'=>substr($arrDbase[$i]['FECHA_ALTA'], 0, 4)."-".substr($arrDbase[$i]['FECHA_ALTA'], 4, 2)."-".substr($arrDbase[$i]['FECHA_ALTA'], 6, 2),'DIRECCION'=>trim($arrDbase[$i]['DIRECCION']),'MUNICIPIO'=>trim($arrDbase[$i]['MUNICIPIO']),'PROVINCIA'=>trim($arrDbase[$i]['PROVINCIA']),'TELEFONO'=>trim($arrDbase[$i]['TELEFONO']),'ESCOLARIDA'=>trim($arrDbase[$i]['ESCOLARIDA']),'ESPECIALIDA'=>trim($arrDbase[$i]['ESPECIALID']),'CARGO_ACTUAL'=>trim($arrDbase[$i]['CARGO_ACTU']),'CATEG_OCUPADA'=>trim($arrDbase[$i]['CATEG_OCUP']),'SALARIO'=>trim($arrDbase[$i]['SALARIO']),'FECHA_NACI'=>substr($arrDbase[$i]['FECHA_NACI'], 0, 4)."-".substr($arrDbase[$i]['FECHA_NACI'], 4, 2)."-".substr($arrDbase[$i]['FECHA_NACI'], 6, 2),'ESTADO_CIVIL'=>trim($arrDbase[$i]['ESTADO_CIV']),'NO_HIJOS'=>trim($arrDbase[$i]['NO_HIJOS']),'LUGAR_NACIMIENTO'=>trim($arrDbase[$i]['LUGAR_NACI']),'EDAD'=>trim($arrDbase[$i]['EDAD']),'IDIOMA'=>trim($arrDbase[$i]['IDIO']),'COMPUTACION'=>trim($arrDbase[$i]['COMPUT']),'PISO'=>trim($arrDbase[$i]['PISO']),'FOTO_NOMBRE'=>trim($arrDbase[$i]['nombFoto']),'TARJETA_RELOJ'=>trim($arrDbase[$i]['RMS_NO']),'TELFONO_OFICINA'=>$arrDbase[$i]['TELEF_OFICINA'],'CUBICULO'=>$arrDbase[$i]['CUBICULO'],'HORA_ENTRAD_SALID'=>$hora_entrada_salida);
		for($q = 0;$q<count($arrMySQL);$q++)
		{  
		  if($arrDatos['C_IDENTIDA']==$arrMySQL[$q]->C_IDENTIDA)
		  { 
		     if(isset($arrMySQL[$q]->USER))
			 {
				 $arrDatos['USER'] = $arrMySQL[$q]->USER;
			 }
			 if(isset($arrMySQL[$q]->PASS_DOMINIO))
			 {
				 $arrDatos['PASS_DOMINIO'] = $arrMySQL[$q]->PASS_DOMINIO;
			 }
			 if(isset($arrMySQL[$q]->TELEFONO_OFICINA))
			 {
				 $arrDatos['TELFONO_OFICINA'] = $arrMySQL[$q]->TELEFONO_OFICINA;
			 }
			 if(isset($arrMySQL[$q]->CUBICULO))
			 {
				 $arrDatos['CUBICULO'] = $arrMySQL[$q]->CUBICULO;
			 }
			 if(isset($arrMySQL[$q]->CORREO))
			 {
				 $arrDatos['CORREO'] = $arrMySQL[$q]->CORREO;
			 }	 
		  }
		  else
		  {
		    $arrAux[] = $arrMySQL[$q];
		  }
		}
		$arrMySQL = $arrAux;
        $arrResp[] = $arrDatos;	
    }
	return $arrResp;
}




?>

