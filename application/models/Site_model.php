<?php
class Site_model extends CI_Model
{

	public function loginUser($data)
	{
		/**Selecionamos tdos los Campos */
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
			/**Selecionamos tdos los Campos */
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
		/**Selecionamos tdos los Campos */
		$this->db->select("*");
		/**Seleccionemos la Tabla */
		$this->db->from("profesores");
		/**Obtenemos los Valores */
		$query = $this->db->get();
		/**Camprobamos que haya resultados */
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	/**Para actulizar los Datos del Profesor */
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
		/**Selecionamos tdos los Campos */
		$this->db->select("*");
		/**Seleccionemos la Tabla */
		$this->db->from("alumnos");
		$this->db->where("curso",$curso);
		$this->db->where("deleted",0);
		/**Obtenemos los Valores */
		$query = $this->db->get();
		/**Camprobamos que haya resultados */
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
}
