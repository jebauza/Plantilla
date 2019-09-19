<?php
class Dbase
{
  public function __construct()
        {
         //$this->conexion= new mysqli("localhost", "adminemproy2", "emproy2","emproy2_bd",3306);
        }
		
		
   public function dar_BD_dbase_unida_correo()
   {
     $arrResp = array();
     require_once '../../Class/PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php';
     $fichero_dbf = '..\..\BD\FIJOS_A.DBF';
	 $arrCorreos = array();
	 if(file_exists('../../BD/CorreosYBD.xls'))
	 {
		 $objPHPExcel = PHPExcel_IOFactory::load('../../BD/CorreosYBD.xls');
		 $objHoja=$objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		 foreach($objHoja as $iIndice=>$objCelda)
         {
            $arrCorreos[] = array('ci'=>$objCelda['A'],'correo'=>$objCelda['B'],'nombre'=>$objCelda['C'],'telefono_oficina'=>"",'cubiculo'=>""); 
	        if(isset($objCelda['D']))
		    {
		       $arrCorreos[count($arrCorreos)-1]['telefono_oficina'] = $objCelda['D'];
		    }  
		    if(isset($objCelda['E']))
		    {
		       $arrCorreos[count($arrCorreos)-1]['cubiculo'] = $objCelda['E'];
		    }       
         }
	 }
	 $conex= dbase_open($fichero_dbf, 0);
	 if($conex)
     {
        $arrBD = array();
	    $arrBDkey = array();
		$arrCumplesHoy = array();
        $total_registros = dbase_numrecords($conex);
        for ($i = 1; $i <= $total_registros; $i++)
	    {
            //$arrBD[] = dbase_get_record($conex,$i);
		    $arrBDkey[$i-1] = dbase_get_record_with_names($conex, $i);
		    $arrBDkey[$i-1]['correoEmp'] = "";
			$arrBDkey[$i-1]['TELEF_OFICINA'] = "";
			$arrBDkey[$i-1]['CUBICULO'] = "";
		    $arrAux = array();
		    for($q = 0;$q<count($arrCorreos);$q++)
		    {
		        if($arrBDkey[$i-1]['C_IDENTID']==$arrCorreos[$q]['ci'])
		        {
		           $arrBDkey[$i-1]['correoEmp'] = $arrCorreos[$q]['correo'];
				   $arrBDkey[$i-1]['TELEF_OFICINA'] = trim($arrCorreos[$q]['telefono_oficina']);
				   $arrBDkey[$i-1]['CUBICULO'] = trim($arrCorreos[$q]['cubiculo']);
		        }
		        else
		        {
		           $arrAux[] = $arrCorreos[$q];
		        }
		    }
		    $arrCorreos = $arrAux;
			$arrBDkey[$i-1] = $this->quitarEspaciosArrDatos($arrBDkey[$i-1]);
		    $arrBDkey[$i-1] = $this->actualizarEdad($arrBDkey[$i-1]);
			$arrBDkey[$i-1] = $this->agregarUrlImg($arrBDkey[$i-1]);
			if(strrpos($arrBDkey[$i-1]['FECHA_NACI'], date("m").date("d"), 4) !== false)
		    {
		       $arrCumplesHoy[] = $arrBDkey[$i-1];
		       $arrCumplesHoy[count($arrCumplesHoy)-1]['num_lista'] = $i-1;
		    }	
        }
	    //usort($arrBD, "ordenar");
	    usort($arrBDkey, "ordenar");
		usort($arrCumplesHoy, "ordenarPersonasFecha");
	    //$_SESSION['directorioAux']['num'] = $arrBD;
	    $arrResp['arrBDkey'] = $arrBDkey;
		$arrResp['arrCumplesHoy'] = $arrCumplesHoy;
     }
	 dbase_close($conex);
     return $arrResp;
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
   
   function agregarUrlImg($arrDatosPersona)
   {
     $arrResp = $arrDatosPersona;
	 $nombFoto = explode(" ",$arrDatosPersona['NOMBRES'])[0]."-".trim($arrDatosPersona['C_IDENTID']).".jpg";
	 $arrCaracteresEspeciales = array(array("Á","A"),array("É","E"),array("Í","I"),array("Ó","O"),array("Ú","U"),array("ñ","nn"));
	 for($i=0;$i<count($arrCaracteresEspeciales);$i++)
	 { 
		$nombFoto = str_replace($arrCaracteresEspeciales[$i][0],$arrCaracteresEspeciales[$i][1],$nombFoto);
	 }
	 $nombFoto = trim($nombFoto);
	 if(@getimagesize("../../BD/Imagenes/Trabajadores/".$nombFoto) == false)
     {

        if(substr(trim($arrDatosPersona['C_IDENTID']), 9, -1)%2==0)
	    {
	      $nombFoto = "hombre.jpg";
	    }
	    else
	    {
	      $nombFoto = "mujer.jpg";
	    } 
     }
     $arrResp['nombFoto'] = $nombFoto;
     return $arrResp; 
   }
   
   function quitarEspaciosArrDatos($arrDatosPersona)
   {
     $arrResp = $arrDatosPersona;
     $arrLlamada = array('NO_TARJETA','AREA','AREAD','CODPTO','DPTO','NOMBRES','APELLIDO_1','APELLIDO_2','C_IDENTID','SEXO','FECHA_ALTA','FALTACON','MOTALT','FECHA_BAJA','FBAJACON','MOT','DIRECCION','DIRECCION','PROVINCIA','TELEFONO','DIRECCR','MUNR','PROVR','TELR','N_PADRE','N_MADRE','ESCOLARIDA','ESPECIALID','INTEGRACIO','CARGO_ANTE','CARGO_ACTU','GRUPO_ESCA','CATEG_OCUP','SESC','SPER','SADIC','SCARG','SHIRR','SCOND','SOTROS','SALARIO','FECHA_NACI','ESTADO_CIV','NO_HIJOS','LUGAR_NACI','UBIC_DEFEN','DETA','EDAD','ANTIG','CP','AGRAD','PGRAD','IDIO','IDIO','DIANT','GRANT','PISO','ANOALTA','DIAS_TOT','TIPOTRAB','TIPOTRAB2','TIPOTRAB_A','TIPOTRAB2_','deleted');
	 for($i=0;$i<count($arrLlamada);$i++)
	 {
	    $arrResp[$arrLlamada[$i]] = trim($arrResp[$arrLlamada[$i]]);
	 }
     return $arrResp; 
   }
	
		
   
  
  
  public function pasar_sql($sql)
  {
   $conex= new mysqli("localhost", "root", "","web_cons",3306);
   $resp = false;
   if(mysqli_connect_errno())
	{
       printf("Connect failed: %s\n",mysqli_connect_error());
	   exit();
	}
	$resp = $conex->query($sql);
	$conex->close();
	return $resp;
  }

}

function ordenar($a, $b)
   {
      if(isset($a['NO_TARJETA']) && isset($b['NO_TARJETA']))
      {
         if ($a['NO_TARJETA'] == $b['NO_TARJETA']) 
	     {
            return 0;
         }
	     else
	     {
	        return ($a['NO_TARJETA'] < $b['NO_TARJETA']) ? -1 : 1;
	     }
      }
      else
      {
         if ($a[0] == $b[0]) 
	     {
            return 0;
         }
	     else
	     {
	       return ($a[0] < $b[0]) ? -1 : 1;
	     }
       }
    }
	
function ordenarPersonasFecha($a, $b)
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

?>
