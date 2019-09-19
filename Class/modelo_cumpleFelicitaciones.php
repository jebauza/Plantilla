<?php
class CumpleFelicitaciones
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
		
   public function insertar_felicitaciones($ci_cumple,$user_comenta,$comentario,$fecha,$nombre_comenta)
   {
       $conexLocalHost= $this->conexionBD();
       $resp = false;
	   if($conexLocalHost != false)
	   {
	      $sql = "INSERT INTO comentario_cumple (ci_cumple_anno,user_comenta, comentario, fecha, nombre_comenta) VALUES ('".$ci_cumple."','".$user_comenta."','".$comentario."','".$fecha."','".$nombre_comenta."')";
		  $conexLocalHost->query($sql);
		  if($conexLocalHost->affected_rows > 0)
	      {
	        $resp = true;
	      }
	   }
	   $conexLocalHost->close();
	   return $resp;
   }		
  		
	public function buscar_felicitaciones_ci_fecha($ci)
    {
	   $conexLocalHost= $this->conexionBD();
       $resp = false;
	   if($conexLocalHost != false)
	   {
	     $sql = "SELECT * FROM `comentario_cumple` WHERE ci_cumple_anno = '".$ci."'";
		 $resp = $conexLocalHost->query($sql);
	   }
	   $conexLocalHost->close();
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
