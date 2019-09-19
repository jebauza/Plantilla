<div class="art-bar art-nav">
<div class="art-nav-outer">
	<ul class="art-hmenu">
		<li>
			<a href="../../index.php" class="active">Inicio</a>
		</li>
		<li>
			<a href="../Cumples/index.php" class="active">Cumpleaños</a>
		</li>
		<li>
			<a href="http://plantilla.emproy2.com.cu/ProyUser/web/login/" class="active" target="_blank">Marcaciones</a>
		</li>
		<?php
		if(false)
		{
		?>
		<li>
			<a href="../MarcacionesRMS/index.php" class="active">Marcaciones</a>
		</li>
		<?php
		}
		?>
		<li>
			<a href="http://plantilla.emproy2.com.cu/ProyUser/web/app.php" class="active" target="_blank">ProyUser</a>
		</li>
		<li>
			<a href="http://172.26.0.10:3000/" class="active" target="_blank">Correo</a>
		</li>
		<li>
			<a href="../Juegos/2048/" class="active" target="_blank">Juego</a>
		</li>
		<?php
		if((isset($_SESSION['login']['user']) && $_SESSION['login']['user']=="bauza") || true)
		{
		?>
		<li>
			<a href="#" class="active">Administrador</a>
			<ul>
			     <li>
				     <a href="" class="active">Actualizar BD MySQL</a>
					 <ul>
					     <li><a href="../Actualizacion/controladora_actualizacion.php?actualizarBDMySQLconDBase=si" class="active">Servidor Apolo</a></li>
					 </ul>
				 </li>
				 <li>
				     <a href="" class="active">RMS</a>
					 <ul>
					     <li><a href="../Actualizacion/controladora_actualizacion.php?cargarMarcacionesRMS_Mes=si" class="active">Actualizar RMS</a></li>
					 </ul>
				 </li>
			</ul>
		</li>
		<?php
		}
		?>
	<?php
     $var = false; 
     if($var)
     {
     ?>	
		<li>
			<a href="#">Menú Item</a>
			<ul>
				<li>
                    <a href="#">Menú Subitem 1</a>
			<ul>
				<li>
                    <a href="#">Menú Subitem 1.1</a>

                </li>
				<li>
                    <a href="#">Menú Subitem 1.2</a>

                </li>
				<li>
                    <a href="#">Menú Subitem 1.3</a>

                </li>
			</ul>

                </li>
				<li>
                    <a href="#">Menú Subitem 2</a>

                </li>
				<li>
                    <a href="#">Menú Subitem 3</a>

                </li>
			</ul>
		</li>	
		<li>
			<a href="#">Acerca de</a>
		</li>
	 <?php
      } 
     ?>	
	</ul>
</div>
</div>