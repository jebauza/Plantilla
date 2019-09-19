<?php session_start();?>
<?php
$entre = false;

if(isset($_POST['buscar_personas']))
{
 $entre = true;
 Busqueda_dbase();
 header ("location: page.php?var=pageBusq");
}
if(isset($_GET['a']))
{
	
}









//-------------------------FUNCIONES-----------------------------------------------------------------------------------------------------


function actualizarMySQLconDbase($arrDbase,$arrDBMySQL,$nomBD)
{
    $arrMySQL = $arrDBMySQL;
	$arrResp = array();
    for ($i=0;$i<count($arrDbase);$i++)
	{
		$arrAux = array();
	    $nombre = trim($arrDbase[$i]['NOMBRES'])." ".trim($arrDbase[$i]['APELLIDO_1'])." ".trim($arrDbase[$i]['APELLIDO_2']);
		$arrDatos = array('USER'=>explode(" ",$nombre)[0]."-".trim($arrDbase[$i]['C_IDENTID']),'NOMBRE'=>$nombre,'CORREO'=>trim($arrDbase[$i]['correoEmp']),'NO_TARJETA'=>trim($arrDbase[$i]['NO_TARJETA']),'AREA_NUM'=>trim($arrDbase[$i]['AREA']),'AREA'=>trim($arrDbase[$i]['AREAD']),'CODIGO_DPTO'=>trim($arrDbase[$i]['CODPTO']),'DEPARTAMENTO'=>trim($arrDbase[$i]['DPTO']),'C_IDENTIDA'=>trim($arrDbase[$i]['C_IDENTID']),'SEXO'=>trim($arrDbase[$i]['SEXO']),'PASS_DOMINIO'=>null,'FECHA_ALTA'=>substr($arrDbase[$i]['FECHA_ALTA'], 0, 4)."-".substr($arrDbase[$i]['FECHA_ALTA'], 4, 2)."-".substr($arrDbase[$i]['FECHA_ALTA'], 6, 2),'DIRECCION'=>trim($arrDbase[$i]['DIRECCION']),'MUNICIPIO'=>trim($arrDbase[$i]['MUNICIPIO']),'PROVINCIA'=>trim($arrDbase[$i]['PROVINCIA']),'TELEFONO'=>trim($arrDbase[$i]['TELEFONO']),'ESCOLARIDA'=>trim($arrDbase[$i]['ESCOLARIDA']),'ESPECIALIDA'=>trim($arrDbase[$i]['ESPECIALID']),'CARGO_ACTUAL'=>trim($arrDbase[$i]['CARGO_ACTU']),'CATEG_OCUPADA'=>trim($arrDbase[$i]['CATEG_OCUP']),'SALARIO'=>trim($arrDbase[$i]['SALARIO']),'FECHA_NACI'=>substr($arrDbase[$i]['FECHA_NACI'], 0, 4)."-".substr($arrDbase[$i]['FECHA_NACI'], 4, 2)."-".substr($arrDbase[$i]['FECHA_NACI'], 6, 2),'ESTADO_CIVIL'=>trim($arrDbase[$i]['ESTADO_CIV']),'NO_HIJOS'=>trim($arrDbase[$i]['NO_HIJOS']),'LUGAR_NACIMIENTO'=>trim($arrDbase[$i]['LUGAR_NACI']),'EDAD'=>trim($arrDbase[$i]['EDAD']),'IDIOMA'=>trim($arrDbase[$i]['IDIO']),'COMPUTACION'=>trim($arrDbase[$i]['COMPUT']),'PISO'=>trim($arrDbase[$i]['PISO']),'FOTO_NOMBRE'=>trim($arrDbase[$i]['nombFoto']),'TARJETA_RELOJ'=>trim($arrDbase[$i]['RMS_NO']),'TELFONO_OFICINA'=>$arrDbase[$i]['TELEF_OFICINA'],'CUBICULO'=>$arrDbase[$i]['CUBICULO']);
		for($q = 0;$q<count($arrMySQL);$q++)
		{  
		  if($arrDatos['C_IDENTIDA']==$arrMySQL[$q]->C_IDENTIDA)
		  { 
		     $arrDatos['USER'] = $arrMySQL[$q]->USER;
			 if($nomBD == "172.26.5.21")
			 {  
			   $arrDatos['PASS_DOMINIO'] = $arrMySQL[$q]->PASS_DOMINIO;
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































function Busqueda_dbase()
{
 $todos = false;
 $encontro = true;
 $arrPersona = $_SESSION['directorioEmproy2']['directorioBD']['key'];
 $resp =array();
 unset($_SESSION['directorioEmproy2']['directorioBusq']);
 unset($_SESSION['directorioEmproy2']['directorioBD']['busqueda']);
 if(empty($_POST['nombre']) && empty($_POST['cargo']) && empty($_POST['municipio']) && empty($_POST['area']) && empty($_POST['piso']) && empty($_POST['cubiculo']) && empty($_POST['telefono']))
 {
     $todos = true;
 }
 
 //echo $_SESSION['directorioEmproy2'][0][7]."nada";die;
 for($i = 0; $i<count($arrPersona) && $todos==false; $i++)
 {  
  $encontro = true;
  if(!empty($_POST['nombre'])&& $encontro == true)
   {
     $_SESSION['directorioEmproy2']['directorioBD']['busqueda']['nombre'] = $_POST['nombre'];
     $nombre = $arrPersona[$i]['NOMBRES']." ".$arrPersona[$i]['APELLIDO_1']." ".$arrPersona[$i]['APELLIDO_2'];
     if(strstr(mb_strtolower($nombre), mb_strtolower($_POST['nombre']))==false)
	 {
	   $encontro=false;
	 } 	
   }
   
   if(!empty($_POST['municipio']) && $encontro == true)
   {
     $_SESSION['directorioEmproy2']['directorioBD']['busqueda']['municipio'] = $_POST['municipio'];
     if( strstr(mb_strtolower($arrPersona[$i]['MUNICIPIO']), mb_strtolower($_POST['municipio']))==false)
	 {
	   $encontro=false;
	 }
   }
   if(!empty($_POST['cargo']) && $encontro == true)
   { 
     $_SESSION['directorioEmproy2']['directorioBD']['busqueda']['cargo'] = $_POST['cargo'];
	 if( strstr(mb_strtolower($arrPersona[$i]['CARGO_ACTU']),mb_strtolower($_POST['cargo']))==false)
	 {
	  $encontro=false;
	 }
   }
   if(!empty($_POST['area']) && $encontro == true)
   {  
     $_SESSION['directorioEmproy2']['directorioBD']['busqueda']['area'] = $_POST['area'];
	 if(strstr(mb_strtolower($arrPersona[$i]['AREAD']),mb_strtolower($_POST['area']))==false)
	 {
	   $encontro=false;
	 }
   }
   if(!empty($_POST['piso']) && $encontro == true)
   { 
     $_SESSION['directorioEmproy2']['directorioBD']['busqueda']['piso'] = $_POST['piso'];
	 if($arrPersona[$i]['PISO'] != $_POST['piso'])
	 {
	   $encontro=false;
	 }
   }
   if(!empty($_POST['cubiculo']) && $encontro == true)
   {
     $_SESSION['directorioEmproy2']['directorioBD']['busqueda']['cubiculo'] = $_POST['cubiculo'];
	 if(strstr(mb_strtolower($arrPersona[$i]['CUBICULO']),mb_strtolower($_POST['cubiculo']))==false)
	 {
	   $encontro=false;
	 }
   }
   if(!empty($_POST['telefono']) && $encontro == true)
   {
     $_SESSION['directorioEmproy2']['directorioBD']['busqueda']['telefono'] = $_POST['telefono'];
	 $telefonoBD = str_replace(" ","",mb_strtolower($arrPersona[$i]['TELEF_OFICINA']));
	 $telefBusq = str_replace(" ","",mb_strtolower($_POST['telefono']));
	 if(strstr($telefonoBD,$telefBusq)==false)
	 {
	   $encontro=false;
	 }
   }
   if($encontro==true)
   {
   	 $resp[]=$arrPersona[$i];
   }  
 }
 if($todos == true)
 {
   $_SESSION['directorioEmproy2']['directorioBusq']= $_SESSION['directorioEmproy2']['directorioBD']['key'];
 }
 else
 {
   $_SESSION['directorioEmproy2']['directorioBusq']=$resp;
 }
}



?>

