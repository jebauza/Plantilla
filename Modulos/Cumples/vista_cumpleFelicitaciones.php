<?php 
if(isset($_GET['felicitaciones']))
{
  
?>
<body>
<?php 
//------------------------------------------------------------------------------------------------------------------
     $datosPersona = "";
	 for($q=0;$q<count($_SESSION['directorioEmproy2']['directorioBD']['key']) && $datosPersona == "";$q++)
	 {
	   if($_GET['felicitaciones'] == $_SESSION['directorioEmproy2']['directorioBD']['key'][$q]['C_IDENTID'])
	   {
	      $datosPersona = $_SESSION['directorioEmproy2']['directorioBD']['key'][$q];
	   }
	 }
	 $logueado = false;
	 if(isset($_SESSION['login']['user']))
	 {
	   $logueado = true;
	 }
	 include '../../Class/modelo_cumpleFelicitaciones.php';
	 $ClassCumpleFelicitaciones = new CumpleFelicitaciones();
	 $arrCaracteresEspeciales = array(array("á","&#225"),array("é","&#233"),array("í","&#237"),array("ó","&#243"),array("ú","&#250"),array("ñ","&#241"));
     $nombre = $datosPersona['NOMBRES']." ".$datosPersona['APELLIDO_1']." ".$datosPersona['APELLIDO_2'];
	 $edad = $datosPersona['EDAD'];
	 $fechaHoy = date("Y")."-".date("n")."-".date("j");
	 $nombFoto = $datosPersona['nombFoto'];
     $urlImg = "../../BD/Imagenes/Trabajadores/".$nombFoto;
	 $arrComentarios = $ClassCumpleFelicitaciones->buscar_felicitaciones_ci_fecha($datosPersona['C_IDENTID']);
	 ?>
	 <div class="foto-felicitaciones">
	  <table width="720" >
        <tr>
	     <td width="200"></td>  
         <td><table width="230" bgcolor="#2FFFFF"><tr><td>
   
            <p class="cumplefelicidades">
            <font color="#FF0000"><strong>FELICIDADES</strong></font>
             </p>
   
            <table>
			     <tr>
				    <td><img src="<?php echo $urlImg;?>" width="220" height="220" border="0"></td>
                 </tr>
		    </table>
            <p class="cumple">
            <font color="#0000FF"><strong><?php echo $nombre;?>
			</br>
			<?php echo $edad;?></strong></font>
			</br>
             </p>
	   
          </td></tr></table></td>
		 
	     </tr> 
       </table>
      </div>
	  
	  </br></br>
	  <table width="720">
	              
				      <?php 
					  while($arrComentarios != false && $comentario = $arrComentarios->fetch_object())
					  {
					    for($i=0;$i<count($arrCaracteresEspeciales);$i++)
						{ 
						  $comentar = str_replace($arrCaracteresEspeciales[$i][0],$arrCaracteresEspeciales[$i][1],$comentario->comentario);
						  $fechaHora = explode(":",explode(" ",$comentario->fecha)[1]);
						  $fechaHora[] = "am";
						  if($fechaHora[0] > 12)
						  {
						    $fechaHora[3] = "pm";
							$fechaHora[0] = $fechaHora[0] - 12;
						  }
						  $fechaCom = $fechaHora[0].":".$fechaHora[1].$fechaHora[3]; 
						  $fec = explode("-",explode(" ",$comentario->fecha)[0]);
						  $fechaCom = $fechaCom." ".$fec[2]."/".$fec[1]."/".$fec[0];
						}
						
					  ?>
					  <tr>
				          <td>
						  <blockquote style="height: 30px">
                                    <p>
									<strong><?php echo $comentario->nombre_comenta." --> ".$fechaCom;?> </strong>
									</br>
									   <p><?php echo $comentar;?></p>
                                     </p>
                          </blockquote>
						  </td>
					  </tr>
					  <?php 
					  }
					  ?>	  
			</table>
			
			</br>
			</br>
 
 <form action="controladora_cumpleFelicitaciones.php" method="post" name="fm_insertar_felicitacion" id="insertarFelicitaciones" onSubmit="return felicitaciones()">        
	<table width="720">
	          <tr>
			      <?php 
				   if(!isset($_SESSION['login']['user']))
				   {
				   ?>
				     <td><font color="#FF0000" size="3" face="Courier New, Courier, monospace"><strong>PARA PODER FELICITAR A <em><?php echo $nombre;?></em> DEBE AUTENTICARSE</strong></font></td>
				   <?php
				   }
				   else
				   {
				   ?>
				     <td><font color="#00A4F2" size="3" face="Courier New, Courier, monospace"><strong>Escriba aqu&#237 su felicitaci&#243n </strong></font></td>
				   <?php
				   }
				  ?>
              </tr>	
	          <tr>
				  <td><textarea name="comentarioCumple" id="comentarioCumple" cols="94" rows="5" <?php if(!isset($_SESSION['login']['user'])){echo "disabled";}?> wrap="off"  ></textarea></td>
              </tr>                 
	</table>
	
		<table width="720">
	          <tr>
			      <td width="500"><input name="ci_cumpleannero" id="ci_cumpleannero" type="hidden" value="<?php echo $datosPersona['C_IDENTID'];?>"><input name="user_comenta" id="user_comenta" type="hidden" value="<?php echo $_SESSION['login']['user'];?>"><input name="nombre_comenta" id="nombre_comenta" type="hidden" value="<?php echo $_SESSION['login']['nombreApell'];?>"></td> 
			      <?php 
				   if(isset($_SESSION['login']['user']))
				   {
				   ?>
				     <td><input name="publicarFelicitacion" id="publicarFelicitacion" type="submit" value="Publicar"></td>
				   <?php
				   }
				  ?>
              </tr>	                
	</table>	
</form>
</br>
</body>
<?php 
}
else
{
  header ("location: cumples.php");
}
?>
