<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
<head>
    <!--
    Created by Artisteer v3.1.0.45994
    Base template (without user's data) checked by http://validator.w3.org : "This page is valid XHTML 1.0 Transitional"
    -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!--[if IE 6]><link rel="stylesheet" href="style.ie6.css" type="text/css" media="screen" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="style.ie7.css" type="text/css" media="screen" /><![endif]-->

</head>
<body>
<?php 
//------------------------------------------------------------------------------------------------------------------
include('../../class/modelo_persona.php');
$clasPersona = new Persona();
//print_r($clasPersona->buscar_personas_cumpleannos("06-25"));die;
//echo date("m-d");die;
$arrCumples = $clasPersona->buscar_personas_cumpleannos(date("m-d"));
if(count($arrCumples)!=0)
{
  $arrTextFelic = array('"En nombre de la Emproy2, te deseamos el mejor de los cumplea&#241os y muchas buenas energ&#237as para que mantengas la vitalidad y la felicidad mucho tiempo m&#225s."','"Todo el equipo de trabajo de la Emproy2 te deseamos un cumplea&#241os muy feliz y te agradecemos por tu compromiso con el bienestar de todos. Que pases un buen d&#237a."','"Querido compa&#241ero, todos los trabajadores de la Emproy2 te deseamos un cumplea&#241os inolvidable al lado de los que m&#225s te quieren. Abrazos de todos y un bastante energ&#237as positivas para que sigas positivo en la vida. Feliz cumplea&#241os."','"Recibe un caluroso saludo cumplea&#241ero de todo el personasl de la Emproy2. Sigue siendo tan buena persona y comparte tu felicidad con todos, como siempre.. Feliz cumplea&#241os."','"Feliz cumplea&#241os querido compa&#241ero, es realmente una gran dicha poder laborar junto a ti porque siempre est&#225s dispuesto a colaborar y ayudarme en todo."','"Tu compromiso y dedicaci&#243n cada d&#237a en el trabajo es algo que realmente nos motiva a todos, que pases un feliz onom&#225stico."');
  $val = 0;
  $color = array("","","");
  for($i=0;$i<count($arrCumples);$i++)
  {
     $nombre = $arrCumples[$i]->NOMBRE;
	 $edad = date("Y")-substr($arrCumples[$i]->FECHA_NACI, 0, 4);
	 $nombFoto = $arrCumples[$i]->FOTO_NOMBRE;
     $urlImg = "../../BD/Imagenes/Trabajadores/".$nombFoto;
	 $num_lista = $i;
	 if(substr($arrCumples[$i]->C_IDENTIDA, 9, -1)%2==0)
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
			</br></br>
			<font color="#333333"><?php echo $arrTextFelic[mt_rand(0, count($arrTextFelic)-1)]; ?></font>
			</br></br>
			<?php
			if(true)
			{
			?>
			<a href="cumples.php?var=cumplesFelicitaciones&felicitaciones=<?php echo $arrCumples[$i]->C_IDENTIDA;?>"><font color="#800000" size="4" face="Times New Roman, Times, serif"><strong>Ver Felicitaciones</strong></font></a>
			<?php
			}
			?>
             </p>
	   
          </td></tr></table></td>
	  
	  <?php
	   $val++;
	   if($val == 3 || $i == count($arrCumples)-1 )
	   {
	     $val = 0;
	   ?>
	     </tr> 
       </table>
	   <?php
	   }
	   
   }    
   ?>
	   
  
<?php 
}
else
{
?>
  <div class="art-box-body art-post-body">
                    <table bgcolor="#CCCCCC" width="530">
                           <tr>
                               <td><strong><font color="#04ADFF" size="+2" face="Georgia, Times New Roman, Times, serif">No hay ningun trabajador que cumpla hoy</font></strong></td>	
				 		   </tr>		    
					</table>
   </div>			
  
  <?php
}
?>
                                
			


</br>
</body>
</html>
