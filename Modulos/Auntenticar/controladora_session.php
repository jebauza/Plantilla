<?php session_start();?>
<?php

$entre = false;
//PREGUNTO POR EL BOTON DE LOGUEARSE Y AGO EL PROCEDIMINTO DE VALIDAR AL USUARIO
if(isset($_POST['logueo_emproy2'])) 
{
    include '../../Class/modelo_persona.php';
    $entre = true;
	$usuario = $_POST['usuario'];
	$pass=$_POST['pass'];
	if(empty($pass))
	{
	  $pass = " ";
	}
	$url = $_POST['url'];
	$ClassPersona = new Persona();
	$url = str_replace("-","&",$url);

	
	//ESTO ES PARA VALIDAR QUE ES UN USUARIO VALIDO, CONSULTA EL SERVIDOR DE DOMINIO----------------------
	
	if(usuarioYpassEsValidoDominio($usuario,$pass,$ClassPersona))
	{
	  header ("location: http://".$url);
	}
	else
	{
	  if( usuarioYpassEsValidoCorreo($usuario,$pass,$ClassPersona))
	  {
	    //print_r($_SESSION['login']);die;
	    header ("location: http://".$url);
	  }
	  else
	  {  
	     $personaBD = $ClassPersona->buscar_persona_SinMaquina($usuario,$pass);
	     if($personaBD!=false)
	     {
	          $_SESSION['login']['loguin_marcaciones']['USER'] = $usuario;
		      $_SESSION['login']['loguin_marcaciones']['TARJETA_RELOJ'] = $personaBD->TARJETA_RELOJ; 
		      $_SESSION['login']['loguin_marcaciones']['EDAD'] = $personaBD->EDAD;
		      $_SESSION['login']['loguin_marcaciones']['C_IDENTIDA'] = $personaBD->C_IDENTIDA;
		      $_SESSION['login']['loguin_marcaciones']['NOMBRE'] = $personaBD->NOMBRE;
		      $_SESSION['login']['loguin_marcaciones']['FOTO_NOMBRE'] = $personaBD->FOTO_NOMBRE;
			  $_SESSION['login']['loguin_marcaciones']['HORA_ENTRAD_SALID'] = $personaBD->HORA_ENTRAD_SALID;
		      header ("location: http://".$url);
	     }
	     else
	     {
	         header ("location: http://".$url."&error=usermal");
	     }
	  }
	}	
}


//PREGUNTO POR EL BOTON SALIR Y SIERRO LA SECCION DEL USUARIO	   
if (isset($_GET['cerrar']) && isset($_GET['url'])) 
{
	$url = str_replace("-","&",$_GET['url']);
    $entre = true;
       if($_GET['cerrar']==1)
	   {
	     unset($_SESSION['login']);	
	   }
	header ("location: http://".$url);	
}

if($entre == false)
{
  header ("location: ../");
}

//METODO QUE TRATA DE RELACIONAR UN NOMBRE DEL DOMINIO CON UNA PERSONA DE BD DBase------------------------
function buscar_user_logueo_Dbase($nombDom,$ClassPersona)
{
  $arrNombreDominio = explode(" ",$nombDom);  
  $val = 0;
  //echo count($arrNombreDominio);die;
    $resp = array(0,"");
    $arrPersonasSinUser = $ClassPersona->todasPersonasSinUsuario();
    //print_r($arrPersonasSinUser);die;
  
  for($i=0;$i<count($arrPersonasSinUser);$i++)
  {
    $nombre = $arrPersonasSinUser[$i]['NOMBRE'];
	$arrNombre = explode(" ",$nombre);
	//echo count($arrNombre);die;
	$val = 0;
	  for($g=0;$g<count($arrNombreDominio) && $g<count($arrNombre);$g++)
	  {
	     if(substr(trim(strtolower($arrNombreDominio[$g])),1,3) == substr(trim(strtolower($arrNombre[$g])),1,3))
		 {
		   $val++;
		 }
	  }
	  if($resp[0]<$val)
	  {
	    $resp[0] = $val;
		$resp[1] = $arrPersonasSinUser[$i];
	  }
  }
   return $resp;
}

function usuarioYpassEsValidoCorreo($user,$pass,$ClassPersona)
{
    $resp = false;
    require("../../Class/PHPMailer-master/class.phpmailer.php");
    require("../../Class/PHPMailer-master/class.smtp.php");
	//Especificamos los datos y configuraci�n del servidor
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "172.26.0.10";
    $mail->Port = 25;
 
    //Nos autenticamos con nuestras credenciales en el servidor de correo Gmail
    $mail->Username = $user;
    $mail->Password = $pass;
 
    //Agregamos la informaci�n que el correo requiere
    $mail->From = $user."@emproy2.co.cu";
    $mail->FromName = "Emproy2";
    $mail->Subject = "autenticar RMS";
    $mail->AltBody = "Loco que pinche";
    $mail->MsgHTML("Loguin RMS");
    //$mail->AddAttachment("adjunto.txt");
    $mail->AddAddress("intranet@emproy2.co.cu","administradorWeb");
    $mail->IsHTML(true);
 
   //Enviamos el correo electr�nico
    if($mail->Send())
	{
	  $resp = true;
	  $personaBD = $ClassPersona->buscar_persona_userCorreo($user);
	    if($personaBD!=false)
	    { 
		   $resp = true;
		   $_SESSION['login']['user'] = $personaBD->USER;
		   $_SESSION['login']['TARJETA_RELOJ'] = $personaBD->TARJETA_RELOJ; 
		   $_SESSION['login']['EDAD'] = $personaBD->EDAD;
		   $_SESSION['login']['C_IDENTIDA'] = $personaBD->C_IDENTIDA;
		   $_SESSION['login']['nombreApell'] = $personaBD->NOMBRE;
		   $_SESSION['login']['FOTO_NOMBRE'] = $personaBD->FOTO_NOMBRE;
		   
		   
		   $_SESSION['login']['loguin_marcaciones']['USER'] = $personaBD->USER;
		   $_SESSION['login']['loguin_marcaciones']['TARJETA_RELOJ'] = $personaBD->TARJETA_RELOJ; 
		   $_SESSION['login']['loguin_marcaciones']['EDAD'] = $personaBD->EDAD;
		   $_SESSION['login']['loguin_marcaciones']['C_IDENTIDA'] = $personaBD->C_IDENTIDA;
		   $_SESSION['login']['loguin_marcaciones']['NOMBRE'] = $personaBD->NOMBRE;
		   $_SESSION['login']['loguin_marcaciones']['FOTO_NOMBRE'] = $personaBD->FOTO_NOMBRE;
		   $_SESSION['login']['loguin_marcaciones']['HORA_ENTRAD_SALID'] = $personaBD->HORA_ENTRAD_SALID;
		   //print_r($_SESSION['login']);die;
	    } 
	}
	return $resp;	
}

function usuarioYpassEsValidoDominio($user,$pass,$ClassPersona)
{
    
    require_once '../../Class/LDAConexionPHP.php';
	$ClassLDA = new LdapConexion();
    $resp = false;
	
	
	if(($ClassLDA->crearConex("172.26.0.1",389) || $ClassLDA->crearConex("172.26.0.2",389)) && $ClassLDA->auntenticarUsuario($user,$pass))
	{
	    $resp = true;
	    $datosUsuario = $ClassLDA->datosDeUsuario($user);
	    $_SESSION['login']['user'] = $user;
	    $_SESSION['login']['TARJETA_RELOJ'] = ""; 
	    $_SESSION['login']['EDAD'] = "";
	    $_SESSION['login']['C_IDENTIDA'] = "";
        if($datosUsuario != false)
        {
           //print_r($datosUsuario);die;
		   $_SESSION['login']['nombreApell'] = $datosUsuario['nombreApell'];
	       $_SESSION['login']['nombre'] = $datosUsuario['nombre'];
	       $_SESSION['login']['informacion'] = $datosUsuario['infoemacion'];   
        }
        else
        {
            $_SESSION['login']['nombreApell'] = $user;
	        $_SESSION['login']['nombre'] = $user;
	        $_SESSION['login']['informacion'] = "";
        }
	   //ENTRAR AL USUARIO A LA BD MySQL-------------------------------------------------------------------
	    $personaBD = $ClassPersona->buscar_persona_Usuario($user);
	    if($personaBD!=false)
	    { 
	       $arrDatosModificar = array($personaBD->C_IDENTIDA,hash('md5', $pass),$user);
           $ClassPersona->modificar_persona_userYpss($arrDatosModificar);
		   $_SESSION['login']['TARJETA_RELOJ'] = $personaBD->TARJETA_RELOJ; 
		   $_SESSION['login']['EDAD'] = $personaBD->EDAD;
		   $_SESSION['login']['C_IDENTIDA'] = $personaBD->C_IDENTIDA;
		   $_SESSION['login']['nombreApell'] = $personaBD->NOMBRE;
		   $_SESSION['login']['FOTO_NOMBRE'] = $personaBD->FOTO_NOMBRE;
		   
		   
		   $_SESSION['login']['loguin_marcaciones']['USER'] = $user;
		   $_SESSION['login']['loguin_marcaciones']['TARJETA_RELOJ'] = $personaBD->TARJETA_RELOJ; 
		   $_SESSION['login']['loguin_marcaciones']['EDAD'] = $personaBD->EDAD;
		   $_SESSION['login']['loguin_marcaciones']['C_IDENTIDA'] = $personaBD->C_IDENTIDA;
		   $_SESSION['login']['loguin_marcaciones']['NOMBRE'] = $personaBD->NOMBRE;
		   $_SESSION['login']['loguin_marcaciones']['FOTO_NOMBRE'] = $personaBD->FOTO_NOMBRE;
		   $_SESSION['login']['loguin_marcaciones']['HORA_ENTRAD_SALID'] = $personaBD->HORA_ENTRAD_SALID;
	    }
	    else
	    {
	      $busq = buscar_user_logueo_Dbase($_SESSION['login']['nombreApell'],$ClassPersona);
	      if($busq[0]!=0)
		  {
		    $arrDatosModificar = array(trim($busq[1]['C_IDENTIDA']),$pass,$_SESSION['login']['user']);
		    $ClassPersona->modificar_persona_userYpss($arrDatosModificar); 
			$personaBD = $ClassPersona->buscar_persona_ci(trim($busq[1]['C_IDENTIDA']));
			$_SESSION['login']['TARJETA_RELOJ'] = $personaBD->TARJETA_RELOJ; 
		    $_SESSION['login']['EDAD'] = $personaBD->EDAD;
		    $_SESSION['login']['C_IDENTIDA'] = $personaBD->C_IDENTIDA;
			$_SESSION['login']['FOTO_NOMBRE'] = $personaBD->FOTO_NOMBRE;
			$_SESSION['login']['nombreApell'] = $personaBD->NOMBRE;
			
			$_SESSION['login']['loguin_marcaciones']['USER'] = $user;
		    $_SESSION['login']['loguin_marcaciones']['TARJETA_RELOJ'] = $personaBD->TARJETA_RELOJ; 
		    $_SESSION['login']['loguin_marcaciones']['EDAD'] = $personaBD->EDAD;
		    $_SESSION['login']['loguin_marcaciones']['C_IDENTIDA'] = $personaBD->C_IDENTIDA;
		    $_SESSION['login']['loguin_marcaciones']['NOMBRE'] = $personaBD->NOMBRE;
			$_SESSION['login']['loguin_marcaciones']['FOTO_NOMBRE'] = $personaBD->FOTO_NOMBRE;
			$_SESSION['login']['loguin_marcaciones']['HORA_ENTRAD_SALID'] = $personaBD->HORA_ENTRAD_SALID;
		 }
	    }
	   //----------------------------------------------------------------
	}
	return $resp;
}

?>