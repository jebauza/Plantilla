<?php
session_start();

if(isset($_SESSION['login']['loguin_marcaciones']['USER']))
{
  $ci_jugador = $_SESSION['login']['loguin_marcaciones']['C_IDENTIDA'];
  if(isset($_GET['total']) && $_GET['total']>0)
  {
    include 'modelo_juego2048.php';
    $class_2048 = new juego2048();
    $recor = $class_2048->datosRecor();
    if($recor->recor < $_GET['total'])
    {
        $class_2048->cambiarRecor($_GET['total'],$ci_jugador);
    }
    header ("location: ../");
  }
}
else
{
   header ("location: http://plantilla.emproy2.com.cu/");
}
