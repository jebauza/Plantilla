<?php session_start();?>
<?php
$entre = false;


if(isset($_POST['publicarFelicitacion']))
{
  $entre = true;
  $ci_cumple = $_POST['ci_cumpleannero'];
  $user_comenta= $_POST['user_comenta'];
  $nombre_comenta= $_POST['nombre_comenta'];
  $comentario = $_POST['comentarioCumple'];
  $fechaHoy = date("Y")."-".date("n")."-".date("j")." ".date("H").":".date("i").":".date("s");
  include '../../Class/modelo_cumpleFelicitaciones.php';
  $ClassCumpleFelicitaciones = new CumpleFelicitaciones();
  if($ClassCumpleFelicitaciones->insertar_felicitaciones($ci_cumple,$user_comenta,$comentario,$fechaHoy,$nombre_comenta))
  {  
	if(isset($_SESSION['directorioEmproy2']['cumple']['cumplesHoy'][$id]['correoEmp']))
	{
	  $correo = array();
	  $correo['corr_destinatario'] = $_SESSION['directorioEmproy2']['cumple']['cumplesHoy'][$id]['correoEmp'];
	  $correo['asunto'] = "Su compañero/a ".$nombre_comenta." ha escrito sobre usted";
	  $correo['cuerpo'] = "El trabajador ".$nombre_comenta." le ha dejado una felicitación a la ".date("g:i a")." de hoy. Puede verla en este link: <a>http://plantilla.emproy2.com.cu/Cumple/cumples.php?var=cumplesFelicitaciones&felicitaciones=".$ci_cumple."</a> Saludos y muchas felicidades de parte de la Emproy2.       Fecha: ".date("Y")."/".date("n")."/".date("j");
	  enviarEmail($correo);  
	}
	header ("location: cumples.php?var=cumplesFelicitaciones&ok=cumplesFelicitaciones&felicitaciones=".$ci_cumple);
	
  }
  else
  {
    header ("location: cumples.php?var=cumplesFelicitaciones&error=cumplesFelicitaciones&felicitaciones=".$ci_cumple);
  }
 
}

if($entre == false)
{
  header ("location: cumples.php?var=cumples");
}

function enviarEmail($correo)
{
    require("../../Class/PHPMailer-master/class.phpmailer.php");
    require("../../Class/PHPMailer-master/class.smtp.php");
	//Especificamos los datos y configuración del servidor
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "172.26.0.10";
    $mail->Port = 25;
 
    //Nos autenticamos con nuestras credenciales en el servidor de correo Gmail
    $mail->Username = "intranet";
    $mail->Password = "Clave830.";
 
    //Agregamos la información que el correo requiere
    $mail->From = "intranet@emproy2.co.cu";
    $mail->FromName = "Emproy2";
    $mail->Subject = $correo['asunto'];
    $mail->AltBody = "Loco que pinche";
    $mail->MsgHTML($correo['cuerpo']);
    //$mail->AddAttachment("adjunto.txt");
    $mail->AddAddress("bauza@emproy2.co.cu","administradorWeb");
	$mail->AddAddress($correo['corr_destinatario']);
    $mail->IsHTML(true);
 
   //Enviamos el correo electrónico
   $mail->Send();
}


?>

