<?php
session_start();

	if(isset($_GET['urlIr']))
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
	  $url = str_replace("-","&",$_GET['urlIr']);
	  header ("location: http://".$url);
	}
	else
	{
	  header ("location: ../Plantilla/page.php?var=page");
	}
?>
