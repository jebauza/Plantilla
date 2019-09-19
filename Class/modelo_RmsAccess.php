<?php
class RmsAccess
{
  public function __construct()
        {
		   
           //$this->conexion= new mysqli("localhost", "adminemproy2", "emproy2","emproy2_bd",3306);
        }
		
		public function ultimaMarcacion()
		{
		  $resp = "";
		  if($conn_access = @odbc_connect ( "RMS_MESES", "", ""))
		  {
		    $sql = "select * from data_card where card_no = '4444444444'";
			if($rs_access = @odbc_exec ($conn_access, $sql))
			{
			  $resp = odbc_fetch_object($rs_access);
			}
		  }
		  return $resp;
		}



//BUSCA LAS MARCACIONES DE 1 PERSONA POR SU TARJETA Y AñO_MES 						
	public function buscar_marcaciones_tarjRmsYmes($targeta,$anno_mes)
    {
       $resp = false;
	   if($conn_access = @odbc_connect ( "RMS_MESES", "", ""))
	   {
	     $sql = "select * from data_card where card_no = '".$targeta."' and d_card like '%".$anno_mes."%' order by d_card,t_card";
		 if($rs_access = @odbc_exec ($conn_access, $sql))
		 {
		   $resp = array();
		   while ($fila = odbc_fetch_object($rs_access))
	       {
		       $resp[] = array('net_no'=>$fila->net_no,'node_no'=>$fila->net_no,'d_card'=>$fila->d_card,'t_card'=>$fila->t_card,'card_no'=>$fila->card_no,'shift'=>$fila->shift,'error_code'=>$fila->error_code,'enter'=>$fila->enter,'io'=>$fila->io,'modified'=>$fila->modified,'dt_data'=>$fila->dt_data,'id_mins'=>$fila->id_mins,'w_card'=>$fila->w_card,'Reader_use'=>$fila->Reader_use,'Reader_no'=>$fila->Reader_no);
           } 
		 }
	     odbc_close($conn_access);
	   }
	   return $resp;
    }
	
	
	
	public function existe_marcacion($fecha,$hora,$targeta)
    {
       $resp = false;
	   if($conn_access = @odbc_connect ( "RMS_SEMANA", "", ""))
	   {
	     $sql= "SELECT * FROM data_card WHERE d_card = '".$fecha."' and t_card = '".$hora."' and card_no = '".$targeta."'";
		 if($rs_access = @odbc_exec ($conn_access, $sql))
		 { 
		   $fila = odbc_fetch_object($rs_access);
		   if(!empty($fila->card_no))
	       { 
	         $resp = $fila;
	       }
		 }
	     odbc_close($conn_access);
	   }
	   return $resp;
    }
	
	
	
	public function modificar_marcacion_RMS_MES($d_card,$t_card,$card_no)
	{
	   $resp = false;
	   if($conn_access = @odbc_connect ( "RMS_MESES", "", ""))
	   {
	      // Update persona Set USER = '".$arrDatosModificar[2]."' Where C_IDENTIDA = '".$arrDatosModificar[0]."'";
	      $sql = "Update data_card Set d_card = '".$d_card."', t_card = '".$t_card."' where card_no = '".$card_no."'";
		  if($rs_access = @odbc_exec ($conn_access, $sql))
		  {
		    $resp = true;
		  }
		  @odbc_close($conn_access);
	   }
	   return $resp;
	}
	

	
//--------------------------------------------------------------------------------------------------------------------------------	
//ACTUALIZA LA BD RMS_MESES CON LO QUE ESTA EN LA CARPETA "semana_anterior" Y "actualizacion_diaria" Y ASI BD RMS_MESES ESTA AL DIA CON LAS MARCACIONES
	public function copiarRMSdeSEMANAparaMES()
	{
	   $ultimaFechaMarcacion = false;
	   $arrUltimaFechaMarcacion = array();
	   $resp = false;
	   if($conex_RMS_MES = @odbc_connect ( "RMS_MESES", "", ""))
	   {
	     $sql = "SELECT * FROM data_card WHERE card_no = '4444444444'";
		 if($rs_access = @odbc_exec ($conex_RMS_MES, $sql))
		 {
		       $fila = @odbc_fetch_object($rs_access);
		       if(!empty($fila->card_no))
	           { 
	             $ultimaFechaMarcacion = $fila;
	           }
		 }
		 @odbc_close($conex_RMS_MES);
	   }
	   $arrUltimaFechaMarcacion['fecha_hora'] = false;
	   if($ultimaFechaMarcacion != false)
	   {
	     $arrUltimaFechaMarcacion['fecha_hora'] = $ultimaFechaMarcacion->d_card.$ultimaFechaMarcacion->t_card;
	   }
	   $arrUltimaFechaMarcacion['fecha_hora'] = $this->copiarMarcaciones("RMS_SEMANA_PASADA",$arrUltimaFechaMarcacion);
	   $arrUltimaFechaMarcacion['fecha_hora'] = $this->copiarMarcaciones("RMS_ACT_DIARIA",$arrUltimaFechaMarcacion);
	}
  
  //AYUDA A COPIAR PARA LA BD RMS_MESES 	
  private function copiarMarcaciones($bd,$arrUltimaFechaMarcacion)
  {
    $fechaHora = $arrUltimaFechaMarcacion['fecha_hora'];
    if($conex_RMS = @odbc_connect ( $bd, "", ""))
	   { 
	      if($fechaHora == false)
	      {
             $sql = "select * from data_card order by d_card,t_card";
             if($rs_access = odbc_exec ($conex_RMS, $sql))
			 {
			      $num = 0;
			      while($fila = odbc_fetch_object($rs_access))
	              { 
	                 $arrDatosMarcacion = array('net_no'=>$fila->net_no,'node_no'=>$fila->net_no,'d_card'=>$fila->d_card,'t_card'=>$fila->t_card,'card_no'=>$fila->card_no,'shift'=>$fila->shift,'error_code'=>$fila->error_code,'enter'=>$fila->enter,'io'=>$fila->io,'modified'=>$fila->modified,'dt_data'=>$fila->dt_data,'id_mins'=>$fila->id_mins,'w_card'=>$fila->w_card,'Reader_use'=>$fila->Reader_use,'Reader_no'=>$fila->Reader_no);
					 $this->insertar_marcacion_RMS_MES($arrDatosMarcacion);
					 //De mi targeta-----------------------------------------
					 if($fila->card_no != "0000064032")
					 {
					   $dia = $fila->d_card;
					   $hora = $fila->t_card;
					 }
					 else
					 {
					   $num--;
					 }
					 //------------------------------------------------------
					 $num++; 
                  }
				  if($num>0)
				  { 
				     $arr = array('net_no'=>"1",'node_no'=>"5",'d_card'=>$dia,'t_card'=>$hora,'card_no'=>"4444444444",'shift'=>"12",'error_code'=>"0",'enter'=>"1",'io'=>"0",'modified'=>"1",'dt_data'=>$arrDatosMarcacion['dt_data'],'id_mins'=>$arrDatosMarcacion['id_mins'],'w_card'=>"1",'Reader_use'=>"0",'Reader_no'=>"1");
				     $this->insertar_marcacion_RMS_MES($arr);
					 $fechaHora = $arrDatosMarcacion['d_card'].$arrDatosMarcacion['t_card'];
				  } 
			 }
	      }
		  else
		  {
		    $sql = "select * from data_card where d_card+t_card > '".$fechaHora."' order by d_card,t_card";
			if($rs_access = odbc_exec ($conex_RMS, $sql))
			{
			   $num = 0;
			   while($fila = odbc_fetch_object($rs_access))
	              { 
	                 $arrDatosMarcacion = array('net_no'=>$fila->net_no,'node_no'=>$fila->net_no,'d_card'=>$fila->d_card,'t_card'=>$fila->t_card,'card_no'=>$fila->card_no,'shift'=>$fila->shift,'error_code'=>$fila->error_code,'enter'=>$fila->enter,'io'=>$fila->io,'modified'=>$fila->modified,'dt_data'=>$fila->dt_data,'id_mins'=>$fila->id_mins,'w_card'=>$fila->w_card,'Reader_use'=>$fila->Reader_use,'Reader_no'=>$fila->Reader_no);
					 $this->insertar_marcacion_RMS_MES($arrDatosMarcacion);
					 //De mi targeta-----------------------------------------
					 if($fila->card_no != "0000064032")
					 {
					   $dia = $fila->d_card;
					   $hora = $fila->t_card;
					 }
					 else
					 {
					   $num--;
					 }
					 //------------------------------------------------------
					 $num++;
                  }
				  if($num>0)
				  { 
				     $arr = array('net_no'=>"1",'node_no'=>"5",'d_card'=>$dia,'t_card'=>$hora,'card_no'=>"4444444444",'shift'=>"12",'error_code'=>"0",'enter'=>"1",'io'=>"0",'modified'=>"1",'dt_data'=>$arrDatosMarcacion['dt_data'],'id_mins'=>$arrDatosMarcacion['id_mins'],'w_card'=>"1",'Reader_use'=>"0",'Reader_no'=>"1");
				     $this->modificar_marcacion_RMS_MES($arr['d_card'],$arr['t_card'],$arr['card_no']);
					 $fechaHora = $arrDatosMarcacion['d_card'].$arrDatosMarcacion['t_card'];
				  }   
			}
		  }
		  @odbc_close($conex_RMS);
	   }
	   return $fechaHora;
  }
  
  
  //INSERTA MARCACIONES EN LA BD RMS_MESES DADO UN ARREGLO QUE LE PASES	
	public function insertar_marcacion_RMS_MES($arrDatosMarcacion)
	{
	   $resp = false;
	   if($conn_access = @odbc_connect ( "RMS_MESES", "", ""))
	   {
	      $sql = "INSERT INTO data_card (net_no ,node_no, d_card, t_card, card_no, shift, error_code, enter, io, modified,id_mins, w_card, Reader_use, Reader_no) VALUES ('".$arrDatosMarcacion['net_no']."','".$arrDatosMarcacion['node_no']."','".$arrDatosMarcacion['d_card']."','".$arrDatosMarcacion['t_card']."','".$arrDatosMarcacion['card_no']."','".$arrDatosMarcacion['shift']."','".$arrDatosMarcacion['error_code']."','".$arrDatosMarcacion['enter']."','".$arrDatosMarcacion['io']."','".$arrDatosMarcacion['modified']."','".$arrDatosMarcacion['id_mins']."','".$arrDatosMarcacion['w_card']."','".$arrDatosMarcacion['Reader_use']."','".$arrDatosMarcacion['Reader_no']."')";
		  if($rs_access = @odbc_exec ($conn_access, $sql))
		  {
		    $resp = true;
		  }
		  @odbc_close($conn_access);
	   }
	   return $resp;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  
  
  
  
  
  
  
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
