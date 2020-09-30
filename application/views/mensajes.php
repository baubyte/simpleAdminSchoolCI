      <!--main content start-->
      <section id="main-content">
      	<section class="wrapper">
      		<br>
      		<div class="row">
      				<button id="btnmensaje" class="btn btn-success" data-toggle="modal" data-target="#myModal"> Enviar Mensaje</button>
      		</div>
      		<div class="row">
      			<table id="mensajes" class="display" style="width:100%">
      				<thead>
      					<tr>
      						<th>Nombres</th>
      						<th>Apellidos</th>
      						<th>Fecha</th>
      						<th>Leer</th>
      					</tr>
      				</thead>
      				<tbody>
      					<?php
							foreach ($mensajes as $mensaje) {
								$nombresApellidos=$this->Site_model->getNombre($mensaje->id_from);
							?>
      						<tr id="rowmensaje-<?php echo $mensaje->id ?>">
      							<td><?php echo $nombres ?></td>
      							<td><?php echo $apellidos ?></td>
      							<td><?php echo $mensaje->created_at ?></td>
      							<td><i class="eliminar fa fa-trash-o" style="cursor:pointer" id="mensaje-<?php echo $mensaje->id ?>"></i> </td>
      						</tr>
      					<?php
							}
							?>
      				</tbody>
      			</table>
      		</div>
      		</div>
      		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      			<div class="modal-dialog">
      				<div class="modal-content">
      					<div class="modal-header">
      						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      						<h4 class="modal-title" id="myModalLabel">Enviar Mensaje</h4>
      					</div>
      					<div class="modal-body">
      						<form action="" method="post">
      							<div class="form-group">
      								<label for="persona">Destinatario: </label>
      								<select name="id_to" id="id_to" class="form-control">
      									<option value="0" class="form-control" disabled selected>Seleccione un Usuario</option>
      									<?php foreach ($usuarios as $usuario) : ?>
      										<option value="<?php echo $usuario->token_mensaje ?>"><?php echo $usuario->nombres ?></option>
      									<?php endforeach ?>
      								</select>
      							</div>
      							<label for="texto">Mensaje: </label>
      							<div class="form-group">
      								<textarea name="texto" id="" cols="30" rows="10" class="form-control"></textarea>
      							</div>
      							<button type="submit" class="btn btn-theme">Enviar</button>
      						</form>
      					</div>
      					<div class="modal-footer">
      						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      					</div>
      				</div>
      			</div>
      		</div>
      	</section>
      </section>
