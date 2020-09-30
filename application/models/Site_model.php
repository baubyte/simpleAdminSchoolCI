<?php
class Site_model extends CI_Model
{

	public function loginUser($data)
	{
		/**Seleccionamos todos los Campos */
		$this->db->select("*");
		/**Seleccionemos la Tabla */
		$this->db->from("profesores");
		/**Filtramos */
		$this->db->where("username", $data['username']);
		/**Obtenemos el Resultado */
		$queryProfesor = $this->db->get();
		/**Probamos si es profesor */
		if ($queryProfesor->num_rows() > 0) {
			if (password_verify($data['password'], $queryProfesor->row()->password)) {
				/**Devolvemos el Resultado */
				return $queryProfesor->row();
			}
		}
		/**Probamos si es un Alumno */
		else {
			/**Seleccionamos todos los Campos */
			$this->db->select("*");
			/**Seleccionemos la Tabla */
			$this->db->from("alumnos");
			/**Filtramos */
			$this->db->where("username", $data['username']);
			/**Obtenemos el Resultado */
			$queryAlumno = $this->db->get();
			if ($queryAlumno->num_rows() > 0) {
				if (password_verify($data['password'], $queryAlumno->row()->password)) {
					/**Devolvemos el Resultado */
					return $queryAlumno->row();
				}
			}
			/**SI no es Profesor ni Alumno devolvemos NULL */
			return null;
		}
	}
	/**Insertar un Profesor */
	public function insertProfesor()
	{
		$dataProfesor = array(
			"nombres" => "BAUBYTE",
			"apellidos" => "BAUBYTE",
			"curso" => 3,
		);
		$this->db->insert("profesores", $dataProfesor);
	}
	/**Obtener los Profesores */
	public function getProfesores()
	{
		/**Seleccionamos todos los Campos */
		$this->db->select("*");
		/**Seleccionemos la Tabla */
		$this->db->from("profesores");
		/**Obtenemos los Valores */
		$query = $this->db->get();
		/**Comprobamos que haya resultados */
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	/**Para actualizar los Datos del Profesor */
	public function updateProfesor()
	{
		$dataProfesor = array(
			"nombres" => "Martin",
			"apellidos" => "Pared Baez",
			"curso" => 4,
			"password" => password_hash('123456', PASSWORD_DEFAULT),
		);
		$this->db->where("id", 1);
		$this->db->update("profesores", $dataProfesor);
	}
	/**Para obtener los alumnos */
	public function getAlumnos($curso)
	{
		/**Seleccionamos todos los Campos */
		$this->db->select("*");
		/**Seleccionemos la Tabla */
		$this->db->from("alumnos");
		$this->db->where("curso", $curso);
		$this->db->where("deleted", 0);
		/**Obtenemos los Valores */
		$query = $this->db->get();
		/**Comprobamos que haya resultados */
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	/**Eliminar Alumno */
	public function eliminarAlumnoById($id)
	{
		$dataDeleted = array(
			"deleted" => 1
		);
		$this->db->where("id", $id);
		$this->db->update("alumnos", $dataDeleted);
	}
	/**Guardar Tareas */
	public function uploadTarea($data, $archivo = null)
	{
		if ($archivo) {
			$dataTarea = array(
				'nombre' => $data["nombre"],
				'descripcion' => $data["descripcion"],
				'fecha_final' => $data["fecha"],
				'archivo' => $archivo,
				'curso' => $data["curso"],
			);
		} else {
			$dataTarea = array(
				'nombre' => $data["nombre"],
				'descripcion' => $data["descripcion"],
				'fecha_final' => $data["fecha"],
				'curso' => $data["curso"],
			);
		}
		$this->db->insert("tareas", $dataTarea);
		header('location:' . $_SERVER['HTTP_REFERER']);
	}
	/**Obtener las Tareas */
	public function getTareas($curso)
	{
		/**Seleccionamos todos los Campos */
		$this->db->select("*");
		/**Seleccionemos la Tabla */
		$this->db->from("tareas");
		$this->db->where("curso", $curso);
		$this->db->where("deleted", 0);
		$this->db->order_by("fecha_final", "ASC");
		/**Obtenemos los Valores */
		$query = $this->db->get();
		//print_r($this->db->last_query());
		/**Comprobamos que haya resultados */
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	/**Obtener Los Usuarios */
	public function getUsuarios($tipo, $curso)
	{
		/**Seleccionamos todos los Campos */
		$this->db->select("*");
		/**Comprobamos si es Profesor Seleccionamos la Tabla Alumnos */
		if ($tipo == "profesor") {
			$this->db->from("alumnos");
		}
		/**Comprobamos si es Alumno Seleccionamos la Tabla Profesores */
		if ($tipo == "alumno") {
			$this->db->from("profesor");
		}
		$this->db->where("curso", $curso);
		/**Obtenemos los Valores */
		$query = $this->db->get();
		//print_r($this->db->last_query());
		/**Comprobamos que haya resultados */
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	/**Guardar los Mensajes */
	public function insertMensaje($data, $idUser)
	{
		$dataMensaje = array(
			"texto" => $data['texto'],
			"id_from" => $idUser,
			"id_to" => $data['id_to']
		);
		/**Insertamos el Mensaje*/
		$this->db->insert("mensajes", $dataMensaje);
	}
	/**Generar Token */
	public function getToken($id, $tipo)
	{
		/**Seleccionamos todos los Campos */
		$this->db->select("*");
		$this->db->where("id", $id);
		/**Comprobamos si es Profesor Seleccionamos la Tabla Alumnos */
		if ($tipo == "profesor") {
			$this->db->from("alumnos");
		}
		/**Comprobamos si es Alumno Seleccionamos la Tabla Profesores */
		if ($tipo == "alumno") {
			$this->db->from("profesor");
		}
		/**Obtenemos los Valores */
		$query = $this->db->get();
		//print_r($this->db->last_query());
		/**Comprobamos que haya resultados */
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result[0]->token_mensaje;
		} else {
			return null;
		}
	}
	public function getMensajes($token)
	{
		/**Seleccionamos todos los Campos */
		$this->db->select("*");
		$this->db->where("id_to", $token);
		$this->db->from("mensajes");
		/**Obtenemos los Valores */
		$query = $this->db->get();
		/**Comprobamos que haya resultados */
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	/**Obtenemos los Nombres */
	public function getNombre($id)
	{
		/**Seleccionamos todos los Campos Tabla Alumnos */
		$this->db->select("*");
		$this->db->from("alumnos");
		$this->db->where("id", $id);
		/**Compilamos pero sin ejecutarla */
		$queryAlumnos = $this->db->get_compiled_select();
		/**Seleccionamos todos los Campos Tabla Profesores */
		$this->db->select("*");
		$this->db->from("profesor");
		$this->db->where("id", $id);
		/**Compilamos pero sin ejecutarla */
		$queryProfesores = $this->db->get_compiled_select();
		/**Hacemos una Union de las Dos Query  */
		$query = $this->db->query($queryAlumnos . "UNION" . $queryProfesores);
		/**Comprobamos que haya resultados */
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
}
