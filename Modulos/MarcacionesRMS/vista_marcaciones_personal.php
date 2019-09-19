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
<table width="670"><tr><td>

<?php 

//------------------------------------------------------------------------------------------------------------------
require("../../Class/modelo_RmsAccess.php");
$ClassRMS = new RmsAccess();
$marcacionesPersonal = array();
//$ClassRMS->copiarRMSdeSEMANAparaMES();
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre" );
$arrDiasFeriados = array('0101'=>true,'0102'=>true,'0501'=>true,'0725'=>true,'0726'=>true,'0727'=>true,'1010'=>true,'1225'=>true,'1231'=>true);
$j =  mktime(0, 0, 0, date("m")  , 1, date("Y"));
/*echo date("l", $j);die;
echo  mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));
echo  mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1);*/

if(isset($_SESSION['login']['loguin_marcaciones']['TARJETA_RELOJ']))
{
  $marcacionesPersonal = $ClassRMS->buscar_marcaciones_tarjRmsYmes($_SESSION['login']['loguin_marcaciones']['TARJETA_RELOJ'],$annoMes);
  //$marcacionesPersonal[] = array('d_card'=>20141110,'t_card'=>"164523");
  //$marcacionesPersonal[] = array('d_card'=>20141102,'t_card'=>"170023");
}
if(isset($_SESSION['login']['loguin_marcaciones']['USER']) && count($marcacionesPersonal)>0)
{
   $arrMarcPorFecha = array();
   for($i=0;$i<count($marcacionesPersonal);$i++)
   {
        $pintarAlerta = "no";
		$diaMarcacion =  mktime(0, 0, 0, substr($marcacionesPersonal[$i]['d_card'],4,2)  , substr($marcacionesPersonal[$i]['d_card'],6,2), substr($marcacionesPersonal[$i]['d_card'],0,4));
		$horarioUsuario = array('entrada'=>73059,'salida'=>170000);
		if(!empty($_SESSION['login']['loguin_marcaciones']['HORA_ENTRAD_SALID']))
		{
			$horaEnSa = explode("-",$_SESSION['login']['loguin_marcaciones']['HORA_ENTRAD_SALID']);
			$horarioUsuario['entrada'] = substr($horaEnSa[0],0,1).substr($horaEnSa[0],2,2)."59";
			$horarioUsuario['salida'] = substr($horaEnSa[1],0,1).substr($horaEnSa[1],2,2)."00" + 120000;
		}
		
		if($marcacionesPersonal[$i]['t_card'] > $horarioUsuario['entrada'] && (($marcacionesPersonal[$i]['t_card'] < $horarioUsuario['salida'] && date("N",$diaMarcacion)<5) || ($marcacionesPersonal[$i]['t_card'] < $horarioUsuario['salida']-10000 && date("N",$diaMarcacion)==5)))
		{
		    $pintarAlerta = "si";
		}
		if($marcacionesPersonal[$i]['t_card'] >= 120000)
		{
		  $h = substr($marcacionesPersonal[$i]['t_card'],0,4)." pm";
		  if(substr($marcacionesPersonal[$i]['t_card'],0,4)>=1300)
		  {
		    $h = (substr($h,0,4)-1200)." pm";
			$hora = substr_replace($h, ':', -5, 0);
		  }
		  $hora = substr_replace($h, ':', -5, 0);
		}
		else
		{
		  $h = (substr($marcacionesPersonal[$i]['t_card'],0,4)-0)." am";
		  $hora = substr_replace($h, ':', -5, 0);
		}
		$marcacionManual = "";
		if($marcacionesPersonal[$i]['enter'] == 0)
		{
		  $marcacionManual = "->Inc";
		}
     if(isset($arrMarcPorFecha[$marcacionesPersonal[$i]['d_card']]))
	 {
	    $arrMarcPorFecha[$marcacionesPersonal[$i]['d_card']][] = array('hora'=>$hora.$marcacionManual, 'pintarAlerta'=>$pintarAlerta, 't_card'=>$marcacionesPersonal[$i]['t_card']);
	 }
	 else
	 {
	   $arrMarcPorFecha[$marcacionesPersonal[$i]['d_card']] = array();
	   $arrMarcPorFecha[$marcacionesPersonal[$i]['d_card']][] = array('hora'=>$hora.$marcacionManual, 'pintarAlerta'=>$pintarAlerta,'t_card'=>$marcacionesPersonal[$i]['t_card']);
	 }
   }
   $dia = 1;
   $cantDiasMes = date("t",mktime(0, 0, 0, substr($annoMes,4,2), $dia, substr($annoMes,0,4)));
   $diasSemana = array("Lunes","Martes","Mi&#233rcoles","Jueves","Viernes","Sabado","Domingo");
   $numDiasdibujado = 0;
   ?>
      <hi><font color="#0080C0" size="8" face="Baskerville Old Face"><?php echo $meses[substr($annoMes,4,2)-1]." del ".substr($annoMes,0,4);?></font></hi>
	  </br>
	  </br>
   <?php
   $cantDiasMarcados = 0;
   $cantDiasLaborablesMes = 0;
   for($j=1;$j<=6 && $numDiasdibujado<$cantDiasMes;$j++)
   {
     if(true)
	 {
	   $diaInicialSemana = $dia;
       $diaFinalSemana = (7 - date("N",mktime(0, 0, 0, substr($annoMes,4,2), $dia, substr($annoMes,0,4))))+$diaInicialSemana;
	   $colorSemanaPresente = "#CCCCCC";
	   
	   //echo date("Y").date("m");die;
	   if(date("d")>=$diaInicialSemana && date("d")<=$diaFinalSemana && date("Y").date("m")==$annoMes)
	   {
	     $colorSemanaPresente = "#B9FFFF";
	   }
	 ?>
	    <fieldset style="background-color:<?php echo $colorSemanaPresente; ?>"><legend><font color="#0000FF" size="4"><strong>Semana <?php echo $j." (".$diaInicialSemana." al ".$diaFinalSemana.")";?></strong></font></legend>
           <table width="665">
                 <tr VALIGN=top>
				    <?php
				     for($q=0;$q<count($diasSemana);$q++)
					 {
					   if($q+1==date("N",mktime(0, 0, 0, substr($annoMes,4,2), $dia, substr($annoMes,0,4))))
					   {
					    ?>
					     <td width="95" ><?php echo '<font face="Times New Roman, Times, serif" color="#666666" size="3"><strong>'.$diasSemana[$q]."-".date("j",mktime(0, 0, 0, substr($annoMes,4,2), $dia, substr($annoMes,0,4))).'</strong></font>'; 
						 $diaMktime = mktime(0, 0, 0, substr($annoMes,4,2), $dia, substr($annoMes,0,4));
						 $fecha = date("Ymd",$diaMktime);
						 if(date("N",$diaMktime)<6 && $dia<=$cantDiasMes && !isset($arrDiasFeriados[date("md",$diaMktime)]))
						 {
						     $cantDiasLaborablesMes++;
						 }
						 if(isset($arrMarcPorFecha[$fecha]))
						 {
						   if(date("N",$diaMktime)<6)
						   {
						     $cantDiasMarcados++;
						   }
						   $repetioIni = 0;
                           $repetioFin = 0;
						   for($r=0;$r<count($arrMarcPorFecha[$fecha]);$r++)
						   {
							 if($arrMarcPorFecha[$fecha][$r]['pintarAlerta'] == "si")
							 {
							    echo '<em><font face="Times New Roman, Times, serif" color="#BF0000" size="2"><strong></br>'.$arrMarcPorFecha[$fecha][$r]['hora'].' &#33</strong></font></em>';
							 }
							 else
							 {
							    $pinte = false;
							    if($arrMarcPorFecha[$fecha][$r]['t_card']<73100)
								{
								  $repetioIni++;
								  if($repetioIni>1)
								  {
								    $pinte =true;
									echo '<em><font face="Times New Roman, Times, serif" color="#50A0A0" size="2"><strong></br>'.$arrMarcPorFecha[$fecha][$r]['hora'].' &#174</strong></font></em>';
								  }
								}
								if($arrMarcPorFecha[$fecha][$r]['t_card']>165959 && $pinte==false)
								{
								  $repetioFin++;
								  if($repetioFin>1)
								  {
								    $pinte =true;
									echo '<em><font face="Times New Roman, Times, serif" color="#50A0A0" size="2"><strong></br>'.$arrMarcPorFecha[$fecha][$r]['hora'].' &#174</strong></font></em>';
								  }
								}
								if($pinte == false)
								{
								   echo '<em><font face="Times New Roman, Times, serif" size="2" color="#000000"><strong></br>'.$arrMarcPorFecha[$fecha][$r]['hora']."</strong></font></em>";
								}
							 }
						   }
						 }
						 else
						 {
						   if($numDiasdibujado<$cantDiasMes)
						   {
						     echo '<em><font face="Times New Roman, Times, serif" color="#50A0A0" size="2"><strong></br>&#60-SM-&#62</strong></font></em>';
						   }  
						 }
						 ?>
						 </td>
						 <?php
						 $dia++;
						 $numDiasdibujado++;
					   }
					   else
					   {
					   ?>
					      <td width="95"><font face="Times New Roman, Times, serif" color="#666666" size="3"><strong><?php echo $diasSemana[$q] ?></strong></font></td>
					    <?php  
					   }
					 }
					 ?>
                 </tr>
             </table>
          </fieldset>
		  </br>
	 <?php 
	 } 
   }
   ?>
   </br>
   <table width="550" style="margin-left: 70px">
             <tr ALIGN=center>
                <td><table><tr>
			       <td width="300"><strong><font color="#000000" size="4" face="lucida Bright">Trabajados => <?php echo '<font color="#1C9AC4">'.$cantDiasMarcados."</font>/".$cantDiasLaborablesMes;?> dias</font></strong></td>
		           <td><strong><font color="#000000" size="4" face="lucida Bright">Vi&#225;tico => <?php echo '<font color="#1C9AC4">'.$cantDiasMarcados*0.6."</font>/".$cantDiasLaborablesMes*0.6;?> cuc</font></strong></td>
	            </tr></table></td>
			 </tr>	
		 <tr ALIGN=center>
			 <th><font color="#FF0000">Nota: <em>Esta informaci&#243;n es solamente un c&#225;lculo que se le hace a sus marcaciones, no es definitivo. Esto no procede asi para los agente de seguridad y protecci&#243;n.</em></font></th>
	     </tr>
   </table>	
   
   <script type="text/javascript" >
		 //alert("Información: Estimado usuario de la emproy2, las marcaciones desde el 24/12/2014 por la tarde hasta el 5/1/2015 por la mañana, no aparecerán en la Intranet de la empresa por problemas tecnicos, no preocuparse pues ya esas marcaciones están registradas en Recursos Humanos solo que el visual en la intranet no está disponible. Pedimos disculpa por las molestias que esto pueda causarle")
   </script>	 
   <?php  
}
else
{
  if(isset($_SESSION['login']['loguin_marcaciones']['USER']))
  {
    ?>
     <hi><font color="#008080" size="6" face="Baskerville Old Face">No posee marcaciones en el mes de <?php echo $meses[substr($annoMes,4,2)-1]." del ".substr($annoMes,0,4);?></font></hi>
    <?php
  }
  else
  {
  ?>
     <hi><font color="#FF0000" size="8" face="Baskerville Old Face">Debe autenticarse para poder ver sus marcaciones</font></hi>
  <?php
  }
}

?>                                

</td></tr></table>


</br>
</body>
</html>
