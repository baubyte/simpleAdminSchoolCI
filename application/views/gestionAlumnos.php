      <!--main content start-->
      <section id="main-content">
      	<section class="wrapper">
      		<table id="alumnos" class="display" style="width:100%">
      			<thead>
      				<tr>
      					<th>Nombres</th>
      					<th>Apellidos</th>
      					<th>Usuario</th>
      					<th>Curso</th>
      					<th>Editar</th>
      				</tr>
      			</thead>
      			<tbody>
      				<?php
						foreach ($alumnos as $alumno) {
						?>
      					<tr id="rowalumno-<?php echo $alumno->id?>">
      						<td><?php echo $alumno->nombres ?></td>
      						<td><?php echo $alumno->apellidos ?></td>
      						<td><?php echo $alumno->username ?></td>
      						<td><?php echo $alumno->curso ?></td>
      						<td><i class="eliminar fa fa-trash-o" style="cursor:pointer" id="alumno-<?php echo $alumno->id ?>"></i> </td>
      					</tr>
      				<?php
						}
						?>
      			</tbody>
      		</table>
      	</section>
      </section>

