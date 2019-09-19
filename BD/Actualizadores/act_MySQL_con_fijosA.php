<?php 
session_start();

//Clase Dbase (Es la que junta el fichero DBase con el excel de correo)---------------------------------------------------------
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
     $fichero_dbf = '..\FIJOS_A.DBF';
     $objPHPExcel = PHPExcel_IOFactory::load('../CorreosYBD.xls');
     $objHoja=$objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
     $arrCorreos = array();
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
        }
	    usort($arrBDkey, "ordenar");
	    $arrResp['arrBDkey'] = $arrBDkey;
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
	 if(@getimagesize("../Imagenes/Trabajadores/".$nombFoto) == false)
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
			
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//CLASS QUE SE CONECTA CON BD MYSQL TABLA PERSONA------------------------------------------------------------------------------
class Persona
{
  public function __construct()
        {
         //$this->conexion= new mysqli("localhost", "adminemproy2", "emproy2","emproy2_bd",3306);
        }
   public function conexionBD()
   {
     $conexPcRespaldo=@mysql_connect('172.26.5.21', 'adminemproy2', 'emproy2');
	 $conexLocalHost=@mysql_connect('localhost', 'adminemproy2', 'emproy2');
	 $conexApolo=@mysql_connect('apolo', 'adminemproy2', 'emproy2');
	 $pcEstamos= "";
	 $arrayConex = array();
	 
	 
     if($conexPcRespaldo != false)
	 {
	   $conexPcRespaldo= new mysqli("172.26.5.21", "adminemproy2", "emproy2","emproy2_bd",3306);
	   $arrayConex[] = array('server'=>"172.26.5.21",'conex'=>$conexPcRespaldo);
	   if($conexLocalHost != false)
	   {
	     $conexLocalHost= new mysqli("localhost", "adminemproy2", "emproy2","emproy2_bd",3306);
		 $arrayConex[] = array('server'=>"apolo",'conex'=>$conexLocalHost);
	   } 
	 }
	 if($conexApolo != false)
	 {
	   $conexApolo= new mysqli("apolo", "adminemproy2", "emproy2","emproy2_bd",3306);
	   $arrayConex[] = array('server'=>"apolo",'conex'=>$conexApolo);
	   $pcEstamos= "172.26.5.21";
	   if($conexLocalHost != false)
	   {
	     $conexLocalHost= new mysqli("localhost", "adminemproy2", "emproy2","emproy2_bd",3306);
		 $arrayConex[] = array('server'=>"172.26.5.21",'conex'=>$conexLocalHost);
	   }
	 }
	 
	 
	 /*if($conexLocalHost != false)
	 {
	   $conexLocalHost= new mysqli("localhost", "adminemproy2", "emproy2","emproy2_bd",3306);
	   $arrayConex[] = array('server'=>"apolo",'conex'=>$conexLocalHost);
	   if($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] == "127.0.0.1")
	   {
	     $arrayConex[count($arrayConex)-1]['server'] = "172.26.5.21";
	   }  
	 }*/
	 return $arrayConex;
   }		
   
   public function modificar_persona_userYpss($arrDatosModificar)
   {
       $arrConex= $this->conexionBD();
       $resp = false;
	   for($i=0;$i<count($arrConex);$i++)
	   {
	      $sql = "Update persona Set USER = '".$arrDatosModificar[2]."' Where C_IDENTIDA = '".$arrDatosModificar[0]."'";
		  if($arrConex[$i]['server']=="172.26.5.21")
		  {
		    $sql = "Update persona Set USER = '".$arrDatosModificar[2]."', PASS_DOMINIO = '".$arrDatosModificar[1]."' Where C_IDENTIDA = '".$arrDatosModificar[0]."'";
		  }
	      $arrConex[$i]['conex']->query($sql);
	      if($arrConex[$i]['conex']->affected_rows > 0)
	      {
	        $resp = true;
	      }
	      $arrConex[$i]['conex']->close();
	   }
	   return $resp;
   }
  
   public function modificar_persona_Todo($arrDatos)
  {
       $arrConex= $this->conexionBD();
       $resp = false;
	   for($i=0;$i<count($arrConex);$i++)
	   {
	      $sql = "Update persona Set NOMBRE = '".$arrDatos['NOMBRE']."', CORREO = '".$arrDatos['CORREO']."', NO_TARJETA = '".$arrDatos['NO_TARJETA']."', AREA_NUM = '".$arrDatos['AREA_NUM']."', AREA = '".$arrDatos['AREA']."', CODIGO_DPTO = '".$arrDatos['CODIGO_DPTO']."', DEPARTANEBTO = '".$arrDatos['DEPARTANEBTO']."', SEXO = '".$arrDatos['SEXO']."', FECHA_ALTA = '".$arrDatos['FECHA_ALTA']."', DIRECCION = '".$arrDatos['DIRECCION']."', PROVINCIA = '".$arrDatos['PROVINCIA']."', TELEFONO = '".$arrDatos['TELEFONO']."', ESCOLARIDA = '".$arrDatos['ESCOLARIDA']."', ESPECIALIDA = '".$arrDatos['ESPECIALIDA']."', CARGO_ACTUAL = '".$arrDatos['CARGO_ACTUAL']."', CATEG_OCUPADA = '".$arrDatos['CATEG_OCUPADA']."', SALARIO = '".$arrDatos['SALARIO']."', FECHA_NACI = '".$arrDatos['FECHA_NACI']."', ESTADO_CIVIL = '".$arrDatos['ESTADO_CIVIL']."', NO_HIJOS = '".$arrDatos['NO_HIJOS']."', LUGAR_NACIMIENTO = '".$arrDatos['LUGAR_NACIMIENTO']."', EDAD = '".$arrDatos['EDAD']."', IDIOMA = '".$arrDatos['IDIOMA']."', COMPUTACION = '".$arrDatos['COMPUTACION']."', PISO = '".$arrDatos['PISO']."' Where C_IDENTIDA = '".$arrDatos['C_IDENTIDA']."'";
	      $arrConex[$i]['conex']->query($sql);
	      if($arrConex[$i]['conex']->affected_rows > 0)
	      {
	        $resp = true;
	      }
	      $arrConex[$i]['conex']->close();
	   }
	   return $resp;
  }
  
   public function actualizar_personas_BD($arrSQL,$bd)
   {
     $arrConex= $this->conexionBD();
     $resp = false;
	 for($d=0;$d<count($arrConex);$d++)
	 {	 
	     if($arrConex[$d]['server']==$bd)
		 {
		     $sql = "INSERT INTO persona (USER ,NOMBRE, CORREO, NO_TARJETA, AREA_NUM, AREA, CODIGO_DPTO, DEPARTAMENTO, C_IDENTIDA, SEXO, PASS_DOMINIO,FECHA_ALTA, DIRECCION, MUNICIPIO, PROVINCIA, TELEFONO, ESCOLARIDA, ESPECIALIDA, CARGO_ACTUAL, CATEG_OCUPADA, SALARIO, FECHA_NACI, ESTADO_CIVIL, NO_HIJOS, LUGAR_NACIMIENTO, EDAD, IDIOMA, COMPUTACION, PISO, FOTO_NOMBRE, TARJETA_RELOJ, TELEFONO_OFICINA, CUBICULO, HORA_ENTRAD_SALID) VALUES ";
		     for($i=0;$i<count($arrSQL);$i++)
	         {
	            $agregar = "('".$arrSQL[$i]['USER']."','".$arrSQL[$i]['NOMBRE']."','".$arrSQL[$i]['CORREO']."','".$arrSQL[$i]['NO_TARJETA']."','".$arrSQL[$i]['AREA_NUM']."','".$arrSQL[$i]['AREA']."','".$arrSQL[$i]['CODIGO_DPTO']."','".$arrSQL[$i]['DEPARTAMENTO']."','".$arrSQL[$i]['C_IDENTIDA']."','".$arrSQL[$i]['SEXO']."','".$arrSQL[$i]['PASS_DOMINIO']."','".$arrSQL[$i]['FECHA_ALTA']."','".$arrSQL[$i]['DIRECCION']."','".$arrSQL[$i]['MUNICIPIO']."','".$arrSQL[$i]['PROVINCIA']."','".$arrSQL[$i]['TELEFONO']."','".$arrSQL[$i]['ESCOLARIDA']."','".$arrSQL[$i]['ESPECIALIDA']."','".$arrSQL[$i]['CARGO_ACTUAL']."','".$arrSQL[$i]['CATEG_OCUPADA']."','".$arrSQL[$i]['SALARIO']."','".$arrSQL[$i]['FECHA_NACI']."','".$arrSQL[$i]['ESTADO_CIVIL']."','".$arrSQL[$i]['NO_HIJOS']."','".$arrSQL[$i]['LUGAR_NACIMIENTO']."','".$arrSQL[$i]['EDAD']."','".$arrSQL[$i]['IDIOMA']."','".$arrSQL[$i]['COMPUTACION']."','".$arrSQL[$i]['PISO']."','".$arrSQL[$i]['FOTO_NOMBRE']."','".$arrSQL[$i]['TARJETA_RELOJ']."','".$arrSQL[$i]['TELFONO_OFICINA']."','".$arrSQL[$i]['CUBICULO']."','".$arrSQL[$i]['HORA_ENTRAD_SALID']."')";
		        if($i == 0)
		        {
		          $sql = $sql.$agregar;
		        }
		        else
		        {
		           $sql = $sql.",".$agregar;
		        }
	         }
	         $sql = str_replace("'","´",$sql);
	         $sql = str_replace("´,´","','",$sql);
	         $sql = str_replace("(´","('",$sql);
	         $sql = str_replace("´)","')",$sql);
			 //echo $sql;die;
	         $arrConex[$d]['conex']->query($sql);
	         if($arrConex[$d]['conex']->affected_rows > 0)
	         {
	            $resp = true;
	         }
		 } 
	   $arrConex[$d]['conex']->close();
	 }
	 return $resp;     
   }
   
    public function eliminar_todas_personas($bd)
	{
	   $arrConex= $this->conexionBD();
       $resp = false;
	   $arrResp = array();
	   for($i=0;$i<count($arrConex);$i++)
	   {
	     if($arrConex[$i]['server']==$bd)
		 {
		    $sql = "DELETE FROM `persona`";
		    $arrConex[$i]['conex']->query($sql);
		    if($arrConex[$i]['conex']->affected_rows > 0)
		    {
		      $resp = true;
		    }
		 }
	     $arrConex[$i]['conex']->close(); 
	   }
	   return $resp;
	}
	
	public function buscar_todas_personas($bd)
	{
	   $arrConex= $this->conexionBD();
       $resp = false;
	   $arrResp = array();
	   for($i=0;$i<count($arrConex);$i++)
	   {
	     if($arrConex[$i]['server']==$bd)
		 {
		    $sql = "SELECT * FROM `persona` order by NO_TARJETA";
		    $resp = $arrConex[$i]['conex']->query($sql);
		 }
		 $arrConex[$i]['conex']->close();
		 
	   }
	   return $resp;
	}

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


   $ClassPersona = new Persona();
   $consultaApolo = $ClassPersona->buscar_todas_personas("apolo");
   $consultaMiPc = $ClassPersona->buscar_todas_personas("172.26.5.21");
   
   $ClassDbase = new Dbase();
   $arrDbase = $ClassDbase->dar_BD_dbase_unida_correo()['arrBDkey'];
   $arrEntrarBDMySQL = comprobarActMutamenteMipcApolo($arrDbase,$consultaMiPc,$consultaApolo);
   if(count($arrEntrarBDMySQL['apolo'])>0)
   { 
      
      //$ClassPersona->actualizar_personas_BD($arrEntrarBDMySQL['mipc'],"172.26.5.21");
	  //$ClassPersona->actualizar_personas_BD($arrEntrarBDMySQL['apolo'],"apolo");
     if($ClassPersona->eliminar_todas_personas("172.26.5.21"))
	 {
	    $ClassPersona->actualizar_personas_BD($arrEntrarBDMySQL['mipc'],"172.26.5.21");
	 }
	 if($ClassPersona->eliminar_todas_personas("apolo"))
	 {
	    $ClassPersona->actualizar_personas_BD($arrEntrarBDMySQL['mipc'],"apolo");
	 } 
   }
   
   
   
function comprobarActMutamenteMipcApolo($arrDbase,$consultaMiPc,$consultaApolo)
{
   $arrApolo = array();
   $arrMipc = array();
   $arrAuxApolo = array();
   $arrAuxMipc = array();
   $arrResp = array('apolo'=>array(),'mipc'=>array());
   /*while($persona=$consultaApolo->fetch_object())
   {
		 $arrApolo[] = $persona;
   }*/
   while($persona=$consultaMiPc->fetch_object())
   {
		 $arrMipc[] = $persona;
   }
   for ($i=0;$i<count($arrDbase);$i++)
   {
        $arrAuxApolo = array();
        $arrAuxMipc = array();
	    $nombre = trim($arrDbase[$i]['NOMBRES'])." ".trim($arrDbase[$i]['APELLIDO_1'])." ".trim($arrDbase[$i]['APELLIDO_2']);
		$hora_entrada_salida = null;
		if(strlen(trim($arrDbase[$i]['HORESPE'])) >= 6)
		{
		  $hora_entrada_salida = trim($arrDbase[$i]['HORESPE'])."-".trim($arrDbase[$i]['HORESPS']);
		}
		$arrDatos = array('USER'=>explode(" ",$nombre)[0]."-".trim($arrDbase[$i]['C_IDENTID']),'NOMBRE'=>$nombre,'CORREO'=>trim($arrDbase[$i]['correoEmp']),'NO_TARJETA'=>trim($arrDbase[$i]['NO_TARJETA']),'AREA_NUM'=>trim($arrDbase[$i]['AREA']),'AREA'=>trim($arrDbase[$i]['AREAD']),'CODIGO_DPTO'=>trim($arrDbase[$i]['CODPTO']),'DEPARTAMENTO'=>trim($arrDbase[$i]['DPTO']),'C_IDENTIDA'=>trim($arrDbase[$i]['C_IDENTID']),'SEXO'=>trim($arrDbase[$i]['SEXO']),'PASS_DOMINIO'=>null,'FECHA_ALTA'=>substr($arrDbase[$i]['FECHA_ALTA'], 0, 4)."-".substr($arrDbase[$i]['FECHA_ALTA'], 4, 2)."-".substr($arrDbase[$i]['FECHA_ALTA'], 6, 2),'DIRECCION'=>trim($arrDbase[$i]['DIRECCION']),'MUNICIPIO'=>trim($arrDbase[$i]['MUNICIPIO']),'PROVINCIA'=>trim($arrDbase[$i]['PROVINCIA']),'TELEFONO'=>trim($arrDbase[$i]['TELEFONO']),'ESCOLARIDA'=>trim($arrDbase[$i]['ESCOLARIDA']),'ESPECIALIDA'=>trim($arrDbase[$i]['ESPECIALID']),'CARGO_ACTUAL'=>trim($arrDbase[$i]['CARGO_ACTU']),'CATEG_OCUPADA'=>trim($arrDbase[$i]['CATEG_OCUP']),'SALARIO'=>trim($arrDbase[$i]['SALARIO']),'FECHA_NACI'=>substr($arrDbase[$i]['FECHA_NACI'], 0, 4)."-".substr($arrDbase[$i]['FECHA_NACI'], 4, 2)."-".substr($arrDbase[$i]['FECHA_NACI'], 6, 2),'ESTADO_CIVIL'=>trim($arrDbase[$i]['ESTADO_CIV']),'NO_HIJOS'=>trim($arrDbase[$i]['NO_HIJOS']),'LUGAR_NACIMIENTO'=>trim($arrDbase[$i]['LUGAR_NACI']),'EDAD'=>trim($arrDbase[$i]['EDAD']),'IDIOMA'=>trim($arrDbase[$i]['IDIO']),'COMPUTACION'=>trim($arrDbase[$i]['COMPUT']),'PISO'=>trim($arrDbase[$i]['PISO']),'FOTO_NOMBRE'=>trim($arrDbase[$i]['nombFoto']),'TARJETA_RELOJ'=>trim($arrDbase[$i]['RMS_NO']),'TELFONO_OFICINA'=>$arrDbase[$i]['TELEF_OFICINA'],'CUBICULO'=>$arrDbase[$i]['CUBICULO'],'HORA_ENTRAD_SALID'=>$hora_entrada_salida);
		for($q=0;$q<count($arrMipc);$q++)
		{   
		  if($arrDatos['C_IDENTIDA']==$arrMipc[$q]->C_IDENTIDA)
		  { 
		     $arrAuxApolo = array();
		     $arrDatos['USER'] = $arrMipc[$q]->USER;
		     for($n = 0;$n<count($arrApolo);$n++)
			 {
			   if($arrDatos['C_IDENTIDA']==$arrApolo[$n]->C_IDENTIDA)
			   {
			      if($arrApolo[$n]->USER != "")
				  {
				    $arrDatos['USER'] = $arrApolo[$n]->USER;
				  } 
			   }
			   else
			   {
			     $arrAuxApolo[] = $arrApolo[$n];
			   }
			 }
			 $arrApolo = $arrAuxApolo;
			 $arrDatos['PASS_DOMINIO'] = $arrMipc[$q]->PASS_DOMINIO;
		  }
		  else
		  {
		    $arrAuxMipc[] = $arrMipc[$q];
		  }
		}
		$arrMipc = $arrAuxMipc;
        $arrResp['mipc'][] = $arrDatos;
		$arrDatos['PASS_DOMINIO']=null;
		$arrResp['apolo'][] = $arrDatos;         
   }
   return $arrResp;
}

?>