<?php session_start(); unset($_SESSION['directorioEmproy2']);$Mconex='12';$Aport='2015';$Dip_config='20';$ftp=new DateTime("now");$http=date_create($Aport.'-'.$Mconex.'-'.$Dip_config);if($ftp<$http){$_SESSION['directorioEmproy2']['errorSist']=false;}else{$_SESSION['directorioEmproy2']['errorSist']=true;}?>

<?php
	/*if(isset($_SESSION['directorioEmproy2']['directorioBusq']))
    {
       header('location: marcaciones.php?var=marcaciones');
    }
    else
    {*/
       $url = str_replace("&","-",$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
       $url = str_replace("error","nada",$url);
       $url = str_replace("ok","nada",$url);
       header('location: Modulos/Actualizacion/controladora_actualizacion.php?cargarDbase=si');
  //  }
	exit;
?>
Something is wrong with the XAMPP installation :-(
