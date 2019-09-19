<?php
require("../../Class/modelo_RmsAccess.php");
//require("prueba.php");
$ClassRMS = new RmsAccess();
$marcacionesPersonal = array();
$ClassRMS->copiarRMSdeSEMANAparaMES();
?>