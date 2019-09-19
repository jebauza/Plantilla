<?php
class Session
{
  public function __construct()
        {
         //$this->conexion= new mysqli("localhost", "adminemproy2", "emproy2","emproy2_bd",3306);
        }
   public function conexionBD()
   {
     $conexApolo= new mysqli("172.26.5.21", "adminemproy2", "emproy2","emproy2_bd",3306);
	 $conexLocalHost= new mysqli("localhost", "adminemproy2", "emproy2","emproy2_bd",3306);
	 $arrayConex = array($conexApolo,$conexLocalHost);
	 return $arrayConex;
   }	
		
   public function insertar_usuario($user,$nombre,$correo,$pass)
   {
       $arrConex= $this->conexionBD();
       $resp = false;
	   for($i=0;$i<count($arrConex) && $arrConex[$i] != false;$i++)
	   {
	      $sql = "INSERT INTO persona (user, nombre, correo, pass) VALUES ('".$user."','".$nombre."','".$correo."','".$pass."')";
	      $arrConex[$i]->query($sql);
	      if($arrConex[$i]->affected_rows > 0)
	      {
	        $resp = true;
	      }
	      $arrConex[$i]->close();
	   }
	   return $resp;   
   }		
  		
	public function buscar_usuario_user($user)
    {
	   $arrConex= $this->conexionBD();
       $resp = false;
	   for($i=0;$i<count($arrConex) && $arrConex[$i] != false;$i++)
	   {
	      $sql = "SELECT * FROM `persona` WHERE user = '".$user."'";
	      $resp = $arrConex[$i]->query($sql);
	      $arrConex[$i]->close();
	      $obj=$resp->fetch_object();
	      if(!empty($obj->user))
	      {
	        $resp = $obj;
	      }
	   }
	   return $resp;  
    }	
		
		
		

}
?>
