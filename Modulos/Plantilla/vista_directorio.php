</head>
<body>
<?php 
//------------------------------------------------------------------------------------------------------------------
$color = "#CCCCCC";
$contUser = 0;
$i = 0;
if(isset($_GET['ant']) && $_GET['ant']>21)
{
  $i = $_GET['ant']-20;
}
if(isset($_GET['sig']))
{
  $i = $_GET['sig'];
}
while($contUser<10 && isset($_SESSION['directorioEmproy2']['directorioBusq'][$i]))
{
  $nombre = $_SESSION['directorioEmproy2']['directorioBusq'][$i]['NOMBRES']." ".$_SESSION['directorioEmproy2']['directorioBusq'][$i]['APELLIDO_1']." ".$_SESSION['directorioEmproy2']['directorioBusq'][$i]['APELLIDO_2'];
  $municipio = $_SESSION['directorioEmproy2']['directorioBusq'][$i]['MUNICIPIO'];
  $cargo = $_SESSION['directorioEmproy2']['directorioBusq'][$i]['CARGO_ACTU'];
  $area = $_SESSION['directorioEmproy2']['directorioBusq'][$i]['AREAD'];
  $piso = $_SESSION['directorioEmproy2']['directorioBusq'][$i]['PISO'];
  $cubiculo = $_SESSION['directorioEmproy2']['directorioBusq'][$i]['CUBICULO'];
  $telefono = $_SESSION['directorioEmproy2']['directorioBusq'][$i]['TELEF_OFICINA'];
  $ci = $_SESSION['directorioEmproy2']['directorioBusq'][$i]['C_IDENTID'];
  $idPlaza = $_SESSION['directorioEmproy2']['directorioBusq'][$i]['NO_TARJETA'];
  $nombFoto = $_SESSION['directorioEmproy2']['directorioBusq'][$i]['nombFoto'];
  $urlImg = "../../BD/Imagenes/Trabajadores/".$nombFoto;
  $correo = $_SESSION['directorioEmproy2']['directorioBusq'][$i]['correoEmp'];;
?>


                                
			<p class="letra-minus"><table bgcolor="<?php echo $color; ?>" width="700"><tr><td width="100"><img src="<?php echo $urlImg; ?>" width="100" height="100" border="0"></td>
			        <td width="10"></td>
                    <td width="420"><table>
                           <tr>
                               <td><strong>Nombre: </strong><?php echo $nombre; ?></td>	
				 		   </tr>
						   <tr>
                               <td><strong>Cargo: </strong> <?php echo $cargo; ?></td>	
				 		   </tr>
						    <tr>
                               <td><strong>Area: </strong> <?php echo $area; ?></td>	
				 		   </tr>
						   <tr>
                               <td><strong>Correo: </strong> <?php echo $correo; ?></td>	
				 		   </tr>
						   
						   <?php
						   if(false)
						   {
						   ?>
						   <tr>
                               <td><strong>CI: </strong> <?php echo $ci; ?></td>	
				 		   </tr>
						   <?php
						   }
						   ?>
						    
					</table></td>
					<td width="10"></td>
                    <td><table width="180">
						   <tr>
							   <td><strong>Municipio: </strong><?php echo $municipio; ?></td>
				 		   </tr>
						   <tr>
							   <td><strong>Solapin: </strong><?php echo $idPlaza; ?></td>
				 		   </tr>
						   <tr>
                               <td><strong>Piso: </strong><?php echo $piso; ?></td>	
				 		   </tr>
						   <tr>
							   <td><strong>Cubiculo: </strong><?php echo $cubiculo; ?> </td>
				 		   </tr>
						    <tr>
                               <td><strong>Telefono: </strong><?php echo $telefono; ?> </td>	
				 		   </tr>
					</table></td>					
			</td></tr></table></p>
			
			</br>
<?php	
  if($color == "#CCCCCC")
  {
    $color = "#62FFFF";
  }
  else
  {
    $color = "#CCCCCC";
  }
  $i++;
  $contUser++;
}
		
?>
<table>
      <tr>
	     <td width="320"></td>
		 <?php
		 if($i>10)
		 {
		 ?>
		 <td><a href="page.php?var=pageBusq&ant=<?php echo $i; ?>"><img src="../../images/anterior.jpg" width="30" height="20" border="0" title="Ir anterior"></a></td>
		  <?php
		 }
		 ?>
		 <td width="20"></td>
		 <?php
		 if(isset($_SESSION['directorioEmproy2']['directorioBusq'][$i]))
		 {
		 ?>
		 <td><a href="page.php?var=pageBusq&sig=<?php echo $i; ?>"><img src="../../images/siguiente.jpg" width="30" height="20" border="0" title="Ir siguiente"></a></td>
		 <?php
		 }
		 ?>
	  </tr>                     
</table>

</br>
</body>
</html>
