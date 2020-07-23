      <!--main content start-->
      <section id="main-content">
      	<section class="wrapper">
      		<?php
				foreach ($tareas as $tarea) {
				?>
      			<div class="col-md-4 tarea">
      				<div class="row">
      					<strong><?php echo $tarea->nombre ?></strong>
      				</div>
      				<div class="row">
      					<?php echo $tarea->descripcion ?>
      				</div>
      				<div class="row">
      					<?php echo date('d-m-Y', strtotime($tarea->fecha_final)) ?>
      				</div>
      				<?php
						if ($tarea->archivo != '') {
						?>
      					<div class="row">
      						<a href="<?php echo base_url() . 'uploads/' . $tarea->archivo ?>" download> Descargar Archivo</a>
      					</div>
      				<?php
						}else {
							echo "Sin Archivo.";
						}
						?>
      			</div>
      		<?php
				}
				?>
      	</section>
      </section>
