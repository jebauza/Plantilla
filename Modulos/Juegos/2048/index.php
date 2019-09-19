<?php
session_start();
if(isset($_SESSION['login']['loguin_marcaciones']['USER']))
{
include 'controladora-modelo/modelo_juego2048.php';
$class_2048 = new juego2048();
$obj_recor = $class_2048->datosRecor();
$recor = 0;
if($obj_recor != false)
{
  $recor = $obj_recor->recor;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>2048</title>

  <link href="style/main.css" rel="stylesheet" type="text/css">
  <link rel="shortcut icon" href="favicon.ico">
  <link rel="apple-touch-icon" href="meta/apple-touch-icon.png">
  <link rel="apple-touch-startup-image" href="meta/apple-touch-startup-image-640x1096.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)"> <!-- iPhone 5+ -->
  <link rel="apple-touch-startup-image" href="meta/apple-touch-startup-image-640x920.png"  media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 2)"> <!-- iPhone, retina -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">

  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <meta name="viewport" content="width=device-width, target-densitydpi=160dpi, initial-scale=1.0, maximum-scale=1, user-scalable=no, minimal-ui">
</head>
<body>
  <div class="container">
    <div class="heading">
      <h1 class="title">2048</h1>
      <div class="scores-container">
          <table>
              <tr>
                  <td><img src="../../../BD/Imagenes/Trabajadores/<?php echo $obj_recor->FOTO_NOMBRE; ?>" width="100" height="100" border="3 px" style="border-color: #bb0908"></td>
              </tr>
              <tr>
                  <td ><div class="score-container">0</div> <div class="best-container">0</div> <div class="recorEmproy2"><?php echo $recor; ?></div></td>
              </tr>
          </table>
          </br>
      </div>
    </div>

    <div class="above-game">
      <p class="game-intro">Unir los números y llegar a <strong>2048 fichas!</strong></p>
      <a class="restart-button">Nuevo Juego</a>
    </div>

    <div class="game-container">
      <div class="game-message">
        <p></p>
        <div class="lower">
	        <a class="keep-playing-button">sigue adelante</a>
          <a class="retry-button" id="total" href="controladora-modelo/controladora.php?total=0">Guardar recor</a>
        </div>
      </div>

      <div class="grid-container">
        <div class="grid-row">
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
        </div>
        <div class="grid-row">
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
        </div>
        <div class="grid-row">
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
        </div>
        <div class="grid-row">
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
        </div>
      </div>

      <div class="tile-container">

      </div>
    </div>

    <p class="game-explanation">
      <strong class="important">¿Cómo se juega:</strong> Utilice su <strong>teclas de flecha</strong> para mover los azulejos. Trate de unir dos fichas con el mismo número para que se <strong>
funda en uno!</strong>
    </p>
    <hr>
    <p>
    <strong class="important">Nota:</strong> Este sitio es la versión oficial de 2048. Se puede jugar en su teléfono a través de <a href="http://git.io/2048">http://git.io/2048.</a> Todas las demás aplicaciones o sitios son derivados o falsificaciones, y deben usarse con precaución.
    </p>
    <hr>
    <p>
    Creado por Gabriele Cirulli. Basado en 1024 por Veewo Studio y conceptualmente similar a Threes por Asher Vollmer.
    </p>
  </div>

  <script src="js/bind_polyfill.js"></script>
  <script src="js/classlist_polyfill.js"></script>
  <script src="js/animframe_polyfill.js"></script>
  <script src="js/keyboard_input_manager.js"></script>
  <script src="js/html_actuator.js"></script>
  <script src="js/grid.js"></script>
  <script src="js/tile.js"></script>
  <script src="js/local_storage_manager.js"></script>
  <script src="js/game_manager.js"></script>
  <script src="js/application.js"></script>
</body>
</html>
<?php
}
else
{
  ?> 
  <script>
     alert("Debe autenticarte para poder jugar 2048")
	 window.location="http://plantilla.emproy2.com.cu/";
  </script>
  <?php
}
?>