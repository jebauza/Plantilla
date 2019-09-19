<?php
class Persona
{
  public function __construct()
        {
         //$this->conexion= new mysqli("localhost", "adminemproy2", "emproy2","emproy2_bd",3306);
        }
   public function conexionBD()
   {
	 $conexLocalHost=@mysql_connect('localhost', 'adminemproy2', 'emproy2');
	 if($conexLocalHost != false)
	 {
	   $conexLocalHost= new mysqli("localhost", "adminemproy2", "emproy2","emproy2_bd",3306);
	 }
	 return $conexLocalHost;
   }	
					
	public function buscar_persona_CI($ci)
    {
       $conexLocalHost= $this->conexionBD();
       $resp = false;
	   if($conexLocalHost != false)
	   {
		   $sql = "SELECT * FROM `persona` WHERE C_IDENTIDA = ".$ci;
		   $persona = $conexLocalHost->query($sql);
		   $obj=$persona->fetch_object();
	       if(!empty($obj->C_IDENTIDA))
	       {
	         $resp = $obj;
	       }  
	   }
	   $conexLocalHost->close();
	   return $resp;
    }
	
	public function buscar_persona_userCorreo($userCorreo)
    {
       $conexLocalHost= $this->conexionBD();
       $resp = false;
	   if($conexLocalHost != false)
	   {
		   $sql = "SELECT * FROM `persona` WHERE CORREO = '".$userCorreo."@emproy2.co.cu'";
		   $persona = $conexLocalHost->query($sql);
		   $obj=$persona->fetch_object();
	       if(!empty($obj->C_IDENTIDA))
	       {
	         $resp = $obj;
	       }  
	   }
	   $conexLocalHost->close();
	   return $resp;
    }
	
	public function buscar_persona_Usuario($user)
    {
       $conexLocalHost= $this->conexionBD();
       $resp = false;
	   if($conexLocalHost != false)
	   {
		   $sql = "SELECT * FROM `persona` WHERE USER = '".$user."'";
		   $persona = $conexLocalHost->query($sql);
		   $obj=$persona->fetch_object();
	       if(!empty($obj->C_IDENTIDA))
	       {
	         $resp = $obj;
	       }  
	   }
	   $conexLocalHost->close();
	   return $resp;
    }
	
	public function buscar_persona_SinMaquina($user,$pass)
    {
       $conexLocalHost= $this->conexionBD();
       $resp = false;
	   if($conexLocalHost != false)
	   {
		   $sql = "SELECT * FROM `persona` WHERE USER = '".$user."' and TARJETA_RELOJ = '".$pass."'";
		   $persona = $conexLocalHost->query($sql); 
		   $obj=$persona->fetch_object();
	       if(!empty($obj->C_IDENTIDA))
	       {
	         $resp = $obj;
	       }  
	   }
	   $conexLocalHost->close();
	   return $resp;
    }	
  
  /*public function insertar_persona($arrDatos)
   {
       $arrConex= $this->conexionBD();
       $resp = false;
	   for($i=0;$i<count($arrConex);$i++)
	   {
	      $sql = "INSERT INTO persona (NOMBRE, CORREO, NO_TARJETA, AREA_NUM, AREA, CODIGO_DPTO, DEPARTAMENTO, C_IDENTIDA, SEXO, FECHA_ALTA, DIRECCION, MUNICIPIO, PROVINCIA, TELEFONO, ESCOLARIDA, ESPECIALIDA, CARGO_ACTUAL, CATEG_OCUPADA, SALARIO, FECHA_NACI, ESTADO_CIVIL, NO_HIJOS, LUGAR_NACIMIENTO, EDAD, IDIOMA, COMPUTACION, PISO) VALUES ('".$arrDatos['NOMBRE']."','".$arrDatos['CORREO']."','".$arrDatos['NO_TARJETA']."','".$arrDatos['AREA_NUM']."','".$arrDatos['AREA']."','".$arrDatos['CODIGO_DPTO']."','".$arrDatos['DEPARTAMENTO']."','".$arrDatos['C_IDENTIDA']."','".$arrDatos['SEXO']."','".$arrDatos['FECHA_ALTA']."','".$arrDatos['DIRECCION']."','".$arrDatos['MUNICIPIO']."','".$arrDatos['PROVINCIA']."','".$arrDatos['TELEFONO']."','".$arrDatos['ESCOLARIDA']."','".$arrDatos['ESPECIALIDA']."','".$arrDatos['CARGO_ACTUAL']."','".$arrDatos['CATEG_OCUPADA']."','".$arrDatos['SALARIO']."','".$arrDatos['FECHA_NACI']."','".$arrDatos['ESTADO_CIVIL']."','".$arrDatos['NO_HIJOS']."','".$arrDatos['LUGAR_NACIMIENTO']."','".$arrDatos['EDAD']."','".$arrDatos['IDIOMA']."','".$arrDatos['COMPUTACION']."','".$arrDatos['PISO']."')";
	      $arrConex[$i]['conex']->query($sql);
	      if($arrConex[$i]['conex']->affected_rows > 0)
	      {
	        $resp = true;
	      }
	      $arrConex[$i]['conex']->close();
	   }
	   return $resp;  
   }*/
   
   public function modificar_persona_userYpss($arrDatosModificar)
   {
       $conexLocalHost= $this->conexionBD();
       $resp = false;
	   if($conexLocalHost != false)
	   {
		   $sql = "Update persona Set USER = '".$arrDatosModificar[2]."', PASS_DOMINIO = '".$arrDatosModificar[1]."' Where C_IDENTIDA = '".$arrDatosModificar[0]."'";
		   $conexLocalHost->query($sql);
		   if($conexLocalHost->affected_rows > 0)
	       {
	         $resp = true;
	       } 
	   }
	   $conexLocalHost->close();
	   return $resp;
   }
  
   public function modificar_persona_Todo($arrDatos)
  {
       $conexLocalHost= $this->conexionBD();
       $resp = false;
	   if($conexLocalHost != false)
	   {
		   $sql = "Update persona Set NOMBRE = '".$arrDatos['NOMBRE']."', CORREO = '".$arrDatos['CORREO']."', NO_TARJETA = '".$arrDatos['NO_TARJETA']."', AREA_NUM = '".$arrDatos['AREA_NUM']."', AREA = '".$arrDatos['AREA']."', CODIGO_DPTO = '".$arrDatos['CODIGO_DPTO']."', DEPARTANEBTO = '".$arrDatos['DEPARTANEBTO']."', SEXO = '".$arrDatos['SEXO']."', FECHA_ALTA = '".$arrDatos['FECHA_ALTA']."', DIRECCION = '".$arrDatos['DIRECCION']."', PROVINCIA = '".$arrDatos['PROVINCIA']."', TELEFONO = '".$arrDatos['TELEFONO']."', ESCOLARIDA = '".$arrDatos['ESCOLARIDA']."', ESPECIALIDA = '".$arrDatos['ESPECIALIDA']."', CARGO_ACTUAL = '".$arrDatos['CARGO_ACTUAL']."', CATEG_OCUPADA = '".$arrDatos['CATEG_OCUPADA']."', SALARIO = '".$arrDatos['SALARIO']."', FECHA_NACI = '".$arrDatos['FECHA_NACI']."', ESTADO_CIVIL = '".$arrDatos['ESTADO_CIVIL']."', NO_HIJOS = '".$arrDatos['NO_HIJOS']."', LUGAR_NACIMIENTO = '".$arrDatos['LUGAR_NACIMIENTO']."', EDAD = '".$arrDatos['EDAD']."', IDIOMA = '".$arrDatos['IDIOMA']."', COMPUTACION = '".$arrDatos['COMPUTACION']."', PISO = '".$arrDatos['PISO']."' Where C_IDENTIDA = '".$arrDatos['C_IDENTIDA']."'";
		   $conexLocalHost->query($sql);
		   if($conexLocalHost->affected_rows > 0)
	       {
	         $resp = true;
	       }  
	   }
	   $conexLocalHost->close();
	   return $resp;
  }
  
   public function actualizar_personas_BD($arrSQL)
   {
     $conexLocalHost= $this->conexionBD();
     $resp = false;
	 if($conexLocalHost != false)
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
		   $sql = str_replace("'","�",$sql);
	       $sql = str_replace("�,�","','",$sql);
	       $sql = str_replace("(�","('",$sql);
	       $sql = str_replace("�)","')",$sql);
	    }
		//echo $sql;die;
		$conexLocalHost->query($sql);
		if($conexLocalHost->affected_rows > 0)
	    {
	       $resp = true;
	    }
	 }
	 $conexLocalHost->close();
	 return $resp;     
   }
   
    public function eliminar_todas_personas()
	{
	   $conexLocalHost= $this->conexionBD();
       $resp = false;
	   if($conexLocalHost != false)
	   {
		   $sql = "DELETE FROM `persona`";
		   $conexLocalHost->query($sql);
		   if($conexLocalHost->affected_rows > 0)
		    {
		      $resp = true;
		    } 
	   }
	   $conexLocalHost->close();
	   return $resp;
	}
	
	public function buscar_todas_personas()
	{
	   $conexLocalHost= $this->conexionBD();
       $resp = array();
	   if($conexLocalHost != false)
	   {
		   $sql = "SELECT * FROM `persona` order by NO_TARJETA";
		   $consulta = $conexLocalHost->query($sql); 
           while($persona = $consulta->fetch_assoc())
		   {
		     $resp[] = $persona;
		   }
	   }
	   $conexLocalHost->close();
	   return $resp;
	}
	
  public function buscar_personas_cumpleannos($mesdia)
  {
       $conexLocalHost= $this->conexionBD();
       $resp = array();
	   if($conexLocalHost != false)
	   {
		   $sql = "SELECT * FROM `persona` WHERE FECHA_NACI like '%$mesdia' order by FECHA_NACI";
		   $r = $conexLocalHost->query($sql); 
		   while($personaCumple = $r->fetch_object())
           {
             $resp[] = $personaCumple;
           }   
	   }
	   $conexLocalHost->close();
	   return $resp;
  }
  
  public function todasPersonasSinUsuario()
  {
       $conexLocalHost= $this->conexionBD();
       $resp = array();
	   if($conexLocalHost != false)
	   {
		   $sql = "SELECT * FROM `persona` WHERE persona.USER like '%-%' order by NO_TARJETA";
		   $consulta = $conexLocalHost->query($sql);
           $conexLocalHost->close();
		   while ($persona = $consulta->fetch_assoc())
		   {
               $resp[] = $persona;
		   }
	   }
	   return $resp;
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
?>
