<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
<body>
<?php 
//------------------------------------------------------------------------------------------------------------------
if(count($_SESSION['directorioEmproy2']['cumple']['busquedadPersona'])>0)
{
  $arrBusq = $_SESSION['directorioEmproy2']['cumple']['busquedadPersona'];
  $val = 0;
  $color = array("","","");
  $i = 0;
  if(isset($_GET['ant']) && $_GET['ant']>19)
  {
     $i = $_GET['ant']-18;
  }
  if(isset($_GET['sig']))
  {
     $i = $_GET['sig'];
  }
  $contUser = 0;
  while($contUser<9 && isset($arrBusq[$i]))
  {
     $nombre = $_SESSION['directorioEmproy2']['cumple']['busquedadPersona'][$i]['NOMBRES']." ".$_SESSION['directorioEmproy2']['cumple']['busquedadPersona'][$i]['APELLIDO_1']." ".$_SESSION['directorioEmproy2']['cumple']['busquedadPersona'][$i]['APELLIDO_2'];
	 $edad = $arrBusq[$i]['EDAD'];
	 $fechaNacimiento = substr($arrBusq[$i]['FECHA_NACI'], 6, 2)."/".substr($arrBusq[$i]['FECHA_NACI'], 4, 2)."/".substr($arrBusq[$i]['FECHA_NACI'], 0, 4);
	 $urlImg = "../../BD/Imagenes/Trabajadores/".explode(" ",$nombre)[0]."-".$_SESSION['directorioEmproy2']['cumple']['busquedadPersona'][$i]['C_IDENTID'];
	 if(substr($_SESSION['directorioEmproy2']['cumple']['busquedadPersona'][$i]['C_IDENTID'], 9, -1)%2==0)
	 {
		$color[0]="#BBBBFF";
	 }
	 else
	 {
	     $color[0]="#FFA4FF";
	 }
	 if($val == 0)
	 {
	 ?>
	  </br>
	  <table width="720">
        <tr>
	 <?php
	 } 
	   if($val != 0)
	   {
	   ?>
	     <td width="10"></td>
	   <?php
       }
       ?>   
         <td><table width="230" bgcolor="<?php echo $color[0];?>"><tr><td>
   
            <p class="busqFechaNacimiento" >
            <font color="#666666"><strong><?php echo $fechaNacimiento;?></strong></font>
             </p>
   
            <table>
			     <tr>
				    <td><img src="<?php echo $urlImg;?>.jpg" width="220" height="220" border="0"></td>
                 </tr>
		    </table>
            <p class="cumple">
            <font color="#0000FF"><strong><?php echo $nombre;?>
			</br>
			<?php echo $edad;?></strong>
			</br>
			<a href="cumples.php?var=cumplesFelicitaciones&felicitaciones=<?php echo $_SESSION['directorioEmproy2']['cumple']['busquedadPersona'][$i]['C_IDENTID'];?>"><font color="#800000" size="4" face="Times New Roman, Times, serif"><strong>Ver Felicitaciones</strong></font></a>
			</br>
             </p>
	   
          </td></tr></table></td>
	  
	  <?php
	   $val++;
	   if($val == 3 || $i == count($arrBusq)-1 )
	   {
	     $val = 0;
	   ?>
	     </tr> 
       </table>
	   <?php
	   }
	  $i++;
	  $contUser++;   
   }    
   ?>
   </br>
	<table>
      <tr>
	     <td width="320"></td>
		 <?php
		 if($i>10)
		 {
		 ?>
		 <td><a href="cumples.php?var=cumplesBusq&ant=<?php echo $i; ?>"><img src="../../images/anterior.jpg" width="30" height="20" border="0" title="Ir anterior"></a></td>
		  <?php
		 }
		 ?>
		 <td width="20"></td>
		 <?php
		 if(isset($arrBusq[$i]))
		 {
		 ?>
		 <td><a href="cumples.php?var=cumplesBusq&sig=<?php echo $i; ?>"><img src="../../images/siguiente.jpg" width="30" height="20" border="0" title="Ir siguiente"></a></td>
		 <?php
		 }
		 ?>
	  </tr>                     
  </table>
	   
  
<?php 
}
?>
                                
			


</br>
</body>
</html>
