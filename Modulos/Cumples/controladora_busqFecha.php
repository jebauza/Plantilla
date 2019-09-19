<?php session_start();?>
<?php
$entre = false;


if(isset($_POST['buscar_personas_fecha']))
{
 $entre = true;
 $arrPersona = $_SESSION['directorioEmproy2']['directorioBD']['key'];;
 $resp =array();
 unset($_SESSION['directorioEmproy2']['cumple']['busquedadPersona']);
 $_SESSION['directorioEmproy2']['cumple']['datosBusquedad'] = array('dia'=>$_POST['dia'],'mes'=>$_POST['mes'],'anno'=>$_POST['anno'],'diaIni'=>$_POST['diaIni'],'mesIni'=>$_POST['mesIni'],'annoIni'=>$_POST['annoIni'],'diaFin'=>$_POST['diaFin'],'mesFin'=>$_POST['mesFin'],'annoFin'=>$_POST['annoFin'],'edad'=>$_POST['edad']);
 if($_POST['tipoBusquedad'] != "vacio")
 {
         switch($_POST['tipoBusquedad']) 
			{
              case "busqFecha":
               $resp = busqFecha($arrPersona);
              break;
			  
			  case "busqIntervalo":
                $resp = busqIntervalo($arrPersona);
              break;
			  
			  case "busqEdad":
                $resp = busqEdad($arrPersona);
              break;
            }
 }
 //print_r($resp);die;
 usort($resp, "ordenarPersonasFechaCont");
 $_SESSION['directorioEmproy2']['cumple']['busquedadPersona'] = $resp;
  header ("location: cumples.php?var=cumplesBusq");
}

if (isset($_GET['felicitaciones'])) 
{
  $entre = true;
  //echo "todo bien";die;
 
}


if($entre == false)
{
  unset($_SESSION['directorioEmproy2']['directorioBD']['busqueda']);
  include 'modelo_Dbase.php';
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
  header ("location: cumples.php?var=cumples");


  
  
}














function busqFecha($arrPersona)
{
  for($i=0;$i<count($arrPersona);$i++)
  {
     $dia = substr($arrPersona[$i]['FECHA_NACI'], 6, 2); 
     if($_POST['dia']=="" || $_POST['dia']==($dia*1))
	 {
	    $mes = substr($arrPersona[$i]['FECHA_NACI'], 4, 2);
		if($_POST['mes']=="" || $_POST['mes']==($mes*1))
		{
		  $anno = substr($arrPersona[$i]['FECHA_NACI'], 0, 4);
		  if($_POST['anno']=="" || $_POST['anno']==$anno)
		  {
		     $resp[] = $arrPersona[$i];
		  }
		}
	 }
  }
  //print_r($resp);die;
  return $resp;
}

function busqEdad($arrPersona)
{
  $resp = array();
  //$resp[] = "<pre>";
  for($i=0;$i<count($arrPersona);$i++)
  {
     if(empty($_POST['edad']) || $_POST['edad']==$arrPersona[$i]['EDAD'])
	 {
	    $resp[] = $arrPersona[$i];
	 }
  }
  //$resp[] = "</pre>";
  //print_r($resp);die;
  return $resp;
}

function busqIntervalo($arrPersona)
{
  $fechaIni = date_create('1915-1-1');
  $fechaFin = new DateTime("now");
  if($_POST['diaIni']!="")
  {
    $fechaIni = date_create($_POST['annoIni'].'-'.$_POST['mesIni'].'-'.$_POST['diaIni']);
  }
  if($_POST['diaFin']!="")
  {
    $fechaFin = date_create($_POST['annoFin'].'-'.$_POST['mesFin'].'-'.$_POST['diaFin']);
  }
  for($i=0;$i<count($arrPersona);$i++)
  {
    $dia = substr($arrPersona[$i]['FECHA_NACI'], 6, 2);
    $mes = substr($arrPersona[$i]['FECHA_NACI'], 4, 2);
	$anno = substr($arrPersona[$i]['FECHA_NACI'], 0, 4);
	$fechaNacUser = date_create($anno.'-'.$mes.'-'.$dia);
	if($fechaNacUser >= $fechaIni && $fechaNacUser <= $fechaFin)
	{
	  $resp[] = $arrPersona[$i];
	}
  }
  //print_r($resp);die;
  return $resp;
}

function actualizarEdad($arrDatosPersona)
{
  $arrResp = $arrDatosPersona;
  $edad = date("Y")-substr($arrDatosPersona['FECHA_NACI'], 0, 4);
  $dia = substr($arrDatosPersona['FECHA_NACI'], 6, 2);
  $mes = substr($arrDatosPersona['FECHA_NACI'], 4, 2);
  if($dia+($mes*100)>date("j")+(date("n")*100))
  {
     $edad--;
  }
  $arrResp['EDAD'] = $edad;
  return $arrResp; 
}

function ordenarPersonasFechaCont($a, $b)
{
  if(isset($a['FECHA_NACI']) && isset($b['FECHA_NACI']))
  {
    if (substr($a['FECHA_NACI'], 6, 2) == substr($b['FECHA_NACI'], 6, 2)) 
	{
        return 0;
    }
	else
	{
	   return (substr($a['FECHA_NACI'], 6, 2) < substr($b['FECHA_NACI'], 6, 2)) ? -1 : 1;
	}
  }
}

function utilizar_BD_Dbase()
{

}

function utilizar_BD_MySQL()
{

}

?>

