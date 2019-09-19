<?php session_start();?>
<?php
$entre = false;


if(isset($_POST['buscar_marcaciones']))
{
   $entre = treu;
   $annoMes = $_POST['anno'].$_POST['mes'];
   header ("location: marcaciones.php?var=marcaciones&AM=".$annoMes);
}

if($entre == false)
{
  
  header ("location: marcaciones.php?var=marcaciones");
}


?>

