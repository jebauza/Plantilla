<?php session_start();
if(isset($_SESSION['directorioEmproy2']['directorioBusq']) && isset($_GET['var']))
{
  $url = str_replace("&","-",$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
  $url = str_replace("error","nada",$url);
  $url = str_replace("ok","nada",$url);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"[]>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
<head>
    <!--
    Created by Artisteer v3.1.0.45994
    Base template (without user's data) checked by http://validator.w3.org : "This page is valid XHTML 1.0 Transitional"
    -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Plantilla Emproy2</title>



    <link rel="stylesheet" href="../../style.css" type="text/css" media="screen" />
    <!--[if IE 6]><link rel="stylesheet" href="style.ie6.css" type="text/css" media="screen" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="style.ie7.css" type="text/css" media="screen" /><![endif]-->
    <link rel="shortcut icon" href="../../images/principal.jpg" type="image/x-icon" />
    <script type="text/javascript" src="../../jquery.js"></script>
    <script type="text/javascript" src="../../script.js"></script>

</head>
<body>
<div id="art-main">
    <div class="cleared reset-box"></div>
    <div class="art-box art-sheet">
        <div class="art-box-body art-sheet-body">
            <a href="../../index.php"><div class="art-header">
                <div class="art-headerobject"></div>
                        <div class="art-logo">
                                                 <h1 class="art-logo-name">Plantilla Emproy-2</h1>
                                                                         <h2 class="art-logo-text">Directorio</h2>
                                                </div>
                
            </div></a>
            <div class="cleared reset-box"></div>
<?php
  include 'elementos_iniciales.php';
?>


<?php //Menu de Busqueda--------------------------------------------------------------------------------------------------------------------------------------- ?>
<div class="cleared reset-box"></div>
<div class="art-layout-wrapper">
                <div class="art-content-layout">
                    <div class="art-content-layout-row">
                        <div class="art-layout-cell art-sidebar1">
<div class="art-box art-vmenublock">
    <div class="art-box-body art-vmenublock-body">
                <div class="art-bar art-vmenublockheader">
                    <h3 class="t">Menú Busqueda</h3>
                </div>
                <div class="art-box art-vmenublockcontent">
                    <div class="art-box-body art-vmenublockcontent-body">
					
					<form action="controladora_directorio.php" method="post" name="fm_buscar_persona" id="buscarPersona" >
					
<ul class="art-vmenu">
     <?php
       $nombre = ""; 
       if(!empty($_SESSION['directorioEmproy2']['directorioBD']['busqueda']['nombre']))
       {
          $nombre = $_SESSION['directorioEmproy2']['directorioBD']['busqueda']['nombre'];
       } 
     ?>
	<li><a>Nombre y Apellidos</a>
		<ul>
			<li style="margin-left:25px"><input name="nombre" type="text" size="25" maxlength="50"  value="<?php echo $nombre; ?>"/></li>
		</ul>
	</li>	
	<?php
    $municipio = ""; 
    if(!empty($_SESSION['directorioEmproy2']['directorioBD']['busqueda']['municipio']))
    {
       $municipio = $_SESSION['directorioEmproy2']['directorioBD']['busqueda']['municipio'];
    } 
    ?>
	<li><a>Municipio</a>
		<ul>
			<li style="margin-left:25px"><input name="municipio" type="text" size="20" maxlength="50" value="<?php echo $municipio; ?>"/></li>
		</ul>
	</li>
	<?php
    $cargo = ""; 
    if(!empty($_SESSION['directorioEmproy2']['directorioBD']['busqueda']['cargo']))
    {
       $cargo = $_SESSION['directorioEmproy2']['directorioBD']['busqueda']['cargo'];
    } 
    ?>
	<li><a>Cargo</a>
		<ul>
			<li style="margin-left:25px"><input name="cargo" type="text" size="25" maxlength="50" value="<?php echo $cargo; ?>"/></li>
		</ul>
	</li>
	<?php
    $area = ""; 
    if(!empty($_SESSION['directorioEmproy2']['directorioBD']['busqueda']['area']))
    {
       $area = $_SESSION['directorioEmproy2']['directorioBD']['busqueda']['area'];
    } 
    ?>
	<li><a>Area</a>
		<ul>
			<li style="margin-left:25px"><input name="area" type="text" size="25" maxlength="50" value="<?php echo $area; ?>"/></li>
		</ul>
	</li>
	<?php
    $cubiculo = ""; 
    if(!empty($_SESSION['directorioEmproy2']['directorioBD']['busqueda']['cubiculo']))
    {
       $cubiculo = $_SESSION['directorioEmproy2']['directorioBD']['busqueda']['cubiculo'];
    } 
    ?>
	<li><a>Cubiculo</a>
		<ul>
			<li style="margin-left:25px"><input name="cubiculo" type="text" size="10" maxlength="10" value="<?php echo $cubiculo; ?>"/></li>
		</ul>
	</li>
	<?php
    $telefono = ""; 
    if(!empty($_SESSION['directorioEmproy2']['directorioBD']['busqueda']['telefono']))
    {
       $telefono = $_SESSION['directorioEmproy2']['directorioBD']['busqueda']['telefono'];
    } 
    ?>
	<li><a>Telefono</a>
		<ul>
			<li style="margin-left:25px"><input name="telefono" type="text" size="10" maxlength="10" value="<?php echo $telefono; ?>"/></li>
		</ul>
	</li>
	<?php
    $piso = ""; 
	$pisos = array("",2,3,4,5,6,7,8);
    if(!empty($_SESSION['directorioEmproy2']['directorioBD']['busqueda']['piso']))
    {
       $piso = $_SESSION['directorioEmproy2']['directorioBD']['busqueda']['piso'];
    } 
    ?>
	<li><a>Piso</a>
		<ul>
			<li style="margin-left:25px"><select name="piso" id="idpiso">
			<option value="<?php echo $piso; ?>"><?php echo $piso; ?></option>
		<?php
		for($m=0;$m<count($pisos);$m++)
		{
		  if($pisos[$m] != $piso)
		  {
		?>
             <option value="<?php echo $pisos[$m]; ?>"><?php echo $pisos[$m]; ?></option>
		<?php
		  }
		}
		?>
			</select></li>
		</ul>
	</li>
	<?php
    //unset($_SESSION['directorioEmproy2']['directorioBD']['busqueda']);
    ?>			
</ul>

<table>
       <tr>
	       <td width="80"></td>
		   <td><input name="buscar_personas" type="submit"  id="buscarConsumoMateriales" value="Buscar"/></td>					
       </tr>
</table>

</form>
                                		<div class="cleared"></div>
                    </div>
                </div>
		<div class="cleared"></div>
    </div>
</div>




<div class="art-box art-vmenublock">
    <div class="art-box-body art-vmenublock-body">
	
	   <?php
	   if(!isset($_SESSION['login']['user']))
	   {
	   ?>			
	          <div class="art-bar art-vmenublockheader">
                    <h3 class="t">Autenticar</h3>
                </div>
                <div class="art-box art-vmenublockcontent">
                    <div class="art-box-body art-vmenublockcontent-body">	
					</br>
		<form action="../Auntenticar/controladora_session.php" method="post" name="fm_logear_persona" id="logearPersona" >		
                   <table width="200">
				          <tr>
						      <td width="30"></td>
						      <td><strong><font color="#FF0000" size="3" face="Arial, Helvetica, sans-serif">Usuario</font></strong></br><input name="usuario" id="usuario" type="text" size="20" maxlength="50" /></td>
						  </tr>
						  <tr>
						      <td width="30"></td>
						      <td><strong><font color="#FF0000" size="3" face="Arial, Helvetica, sans-serif">Contraseña</font></strong></br><input name="pass" id="pass" type="password" size="20" maxlength="50" /></td>
						  </tr>
						  
				   </table>
				   </br>
				  <table width="200">
				           <tr>  
						      <td width="75"><input name="url"  id="url" type="hidden" value="<?php echo $url;?>" /></td>
						      <td><input name="logueo_emproy2" type="submit" value="Entrar" id="logueoEmproy2"/></td>
						  </tr>
				  </table>
				</br>
			</form>
         <?php
	    }
		else
		{
		  $direcionFotoUsuario = "../../images/usuario.jpg";
		  if(isset($_SESSION['login']['FOTO_NOMBRE']))
		  {
		    $direcionFotoUsuario = "../../BD/Imagenes/Trabajadores/".$_SESSION['login']['FOTO_NOMBRE'];
		  }
	   ?>
	      <div class="art-bar art-vmenublockheader">
                    <h3 class="t">Bienvenido</h3>
                </div>
                <div class="art-box art-vmenublockcontent">
                    <div class="art-box-body art-usuarioautenticado-body">
					</br>
	       <table width="200">
				  <tr> 
				      <td width="60"></td>
				     <td><img src="<?php echo $direcionFotoUsuario; ?>" width="110" height="80" border="0"></td> 
			    </tr>
		   </table>
		   <cajadatos>
		         <strong><p id="nombreSession"><font color="#0000FF"> <?php echo $_SESSION['login']['nombreApell'];?></font></br></br>
				 <span class="art-button-wrapper">
                         <span class="art-button-l"></span>
                         <span class="art-button-r"></span>
						 <a class="art-button" href="../Auntenticar/controladora_session.php?cerrar=1&url=<?php echo $url;?>">Salir</a>
                 </span>
				 </p></strong>
		   </cajadatos>
	    <?php
		}
	   ?>
                    </div>
                </div>
		<div class="cleared"></div>
    </div>
</div>





<div class="art-box art-block">
    <div class="art-box-body art-block-body">
                <div class="art-bar art-blockheader">
                    <h3 class="t">Sitios de interes</h3>
                </div>
                <div class="art-box art-blockcontent">
                    <div class="art-box-body art-blockcontent-body">
                <ul>
  <li class="active">
    <a href="http://www.granma.cu/" target="_blank">
      <span>Granma</span>
    </a>
  </li>
  <li class="parent">
    <a href="http://www.cubadebate.cu/" target="_blank">
      <span>Cubadebate</span>
    </a>
  </li>
  <li>
    <a href="http://www.juventudrebelde.cu/" target="_blank">
      <span>Juventud Rebelde</span>
    </a>
  </li>
  <li>
    <a href="http://www.aduana.co.cu/" target="_blank">
      <span>Aduana</span>
    </a>
  </li>
  <li>
    <a href="http://www.etecsa.cu/" target="_blank">
      <span>Etecsa</span>
    </a>
  </li>
  <li>
    <a href="http://intranet.emproy2.com.cu/" target="_blank">
      <span>Intranet Emproy-2</span>
    </a>
  </li>
  <li>
    <a href="http://www.tvcubana.icrt.cu/" target="_blank">
      <span>TV Cubana</span>
    </a>
  </li>
  <li>
    <a href="https://www.google.com.cu/?gws_rd=ssl" target="_blank">
      <span>Google</span>
    </a>
  </li>

</ul>                
                                		<div class="cleared"></div>
                    </div>
                </div>
		<div class="cleared"></div>
    </div>
</div>
                          <div class="cleared"></div>
                        </div>
						
						
	<div class="art-layout-cell art-content">	
	<div class="art-box-body art-post-body">				
<?php 
//------------------------------------------------------------------------------------------------------------------

if($_SESSION['directorioEmproy2']['errorSist']==false)
{
    
    $sacarPage = true;
    if(isset($_GET['var']))
    {
       if($_GET['var']=='page')
       {
	       $sacarPage = false;
	       $_SESSION['directorioEmproy2']['directorioBusq'] = $_SESSION['directorioEmproy2']['directorioBD']['key'];
	       include('vista_directorio.php');
       }
	   if($_GET['var']=='pageBusq')
	   {
	     $sacarPage = false;
	     include('vista_directorio.php');
	   } 
    }
	
	
	
	if($sacarPage == true)
	{
	  $_SESSION['directorioEmproy2']['directorioBusq'] = $_SESSION['directorioEmproy2']['directorioBD']['key'];
	  include('vista_directorio.php');
	}    
}
		
?>							
    </div>

<?php 
//------------------------------------------------------------------------------------------------------------------
$diaSeman = array("lunes","marte","miércoles","jueves","viernes","sabado","domingo");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$fecha = $diaSeman[date("N")-1].", ".date("d")." ".$meses[date("n")-1]." ".date("Y");
if($_SESSION['directorioEmproy2']['errorSist']==false)
{
?>						
						

<div class="art-box-body art-post-body">
<div class="art-post-inner art-article">
                                <div class="art-postmetadataheader">
                                        <h2 class="art-postheader">Arquitectura de hoy. Patrimonio de Mañana</h2>
                                                                                <div class="art-postheadericons art-metadata-icons">
                        <span class="art-postdateicon"><?php echo $fecha; ?></span>
                    </div>
                                    </div>
									
									
                                <div class="art-postcontent">


                </div>
                <div class="cleared"></div>
                </div>
<?php
}
else
{
  //dibujar error;
  ?>
  <div class="art-box-body art-post-body">
  <table bgcolor="#FF0000" width="700"><tr><td width="100"><img src="../../images/error.png" width="100" height="100" border="0"></td>
			        <td width="10"></td>
                    <td><table>
                           <tr>
                               <td><strong><font color="#FFFFFF" size="+2" face="Georgia, Times New Roman, Times, serif">Error del Sistema: Póngase en contacto con el administrador de la Página</font></strong></td>	
				 		   </tr>		    
					</table></td>					
			</td></tr></table>
   </div>			
  
  <?php
}
?>

		<div class="cleared"></div>
    </div>
	




                          <div class="cleared"></div>
            
						
	<?php 
//------------------------------------------------------------------------------------------------------------------
?>	
</div>

				
						
        </div>
    </div>
</div>
			
			
			
			
			
            <div class="cleared"></div>
            <div class="art-footer">
                <div class="art-footer-body">
                    <a href="#" title="Empresa de Proyectos-2" ><img src="../../images/emproy2.gif" width="50" height="50" style="float:left; " /></a>
                            <div class="art-footer-text">
                                <p><font color="#0080C0" face="Pristina" size="5">Empresa de Proyectos</font></p>

<p><font color="#0080C0" face="Pristina" size="5">Emproy-2</font></p>
                                                            </div>
                    <div class="cleared"></div>
                </div>
            </div>
    		<div class="cleared"></div>
        </div>
    </div>
    <div class="cleared"></div>
    <p class="art-page-footer"><font color="#FFFFFF">Aut: Ing. Jorge Ernesto Bauzá Becerra</br>Esp. Luis Ernesto Valdez Baez</font></p>
    <div class="cleared"></div>
</div>


</body>
</html>

<?php
  if($_SESSION['directorioEmproy2']['errorSist']==true)
  { 
         ?>
	     <script type="text/javascript" >
		 alert("Error: Los Bundle de php_dbase.dll han entrado en conflicto con los puertos de red")
		 </script>
		 <?php
  }
  if(isset($_GET['error']))
  {
    if($_GET['error'] == "usermal")
	{
	    ?>
	     <script type="text/javascript" >
		 alert("Error: Usuario o contraseña incorecta, puede tambien haber problema con el servidor")
		 </script>
		 <?php
	}
	if($_GET['error'] == "cumplesFelicitaciones")
	{
	    ?>
	     <script type="text/javascript" >
		 alert("Error: Su felicitacion no se pudo agregar a la Base Datos")
		 </script>
		 <?php
	}
  }
  if(isset($_GET['ok']))
  {
         if($_GET['ok'] == "cumplesFelicitaciones")
	     {
	        ?>
	         <script type="text/javascript" >
		     alert("OK: Felicitacion guardada con exito")
		     </script>
		     <?php
	     }
  }
  

}
else
{
    header ("location: ../../index.php");
}
?>