<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function index()
	{
		$this->loadViews("home");
	}
	public function login()
	{
		if (isset($_POST["username"]) && isset($_POST["password"])) {
			$login = $this->Site_model->loginUser($_POST);

			/**Comprobamos que no sea null */
			if ($login) {
				/**Armamos un array con los datos */
				$dataUser = array(
					'id' => $login->id,
					'nombres' => $login->nombres,
					'apellidos' => $login->apellidos,
					'username' => $login->username,
					'curso' => $login->curso,
				);
				/**Guardamos el Tipo de Usuario */
				if (isset($login->is_profesor)) {
					$dataUser['tipo'] = "profesor";
				} elseif (isset($login->is_alumno)) {
					$dataUser['tipo'] = "alumno";
				}
				/**Creamos las Sesion */
				$this->session->set_userData($dataUser);
			}
		}
		$this->loadViews("login");
	}
	/**Gestion de Alumnos */
	public function gestionAlumnos()
	{
		$data["alumnos"] = $this->Site_model->getAlumnos($_SESSION["curso"]);
		if ($_SESSION['tipo'] == "profesor") {
			$this->loadViews("gestionAlumnos", $data);
		} else {
			redirect(base_url() . "dashboard/login", "location");
		}
	}
	/**Eliminar Alumno */
	public function eliminarAlumno()
	{
		if ($_POST["idAlumno"]) {
			$this->Site_model->eliminarAlumnoById($_POST["idAlumno"]);
		}
	}
	/**Para Crear las Tareas */
	public function crearTareas()
	{
		/**Comprobamos que se Ejecuto el POST */
		if ($_POST) {
			/**Comprobamos si Tiene un Archivo */
			if ($_FILES['archivo']) {
				$config['upload_path']          = './uploads/';
				$config['allowed_types']        = 'gif|jpg|png|pdf';
				//$config['max_size']             = 100;
				//$config['max_width']            = 1024;
				//$config['max_height']           = 768;
				$config['file_name']        = uniqid() . $_FILES['archivo']['name'];
				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('archivo')) {
					echo "error";
				} else {
					$this->Site_model->uploadTarea($_POST, $config['file_name']);
				}
			} else {
				$this->Site_model->uploadTarea($_POST);
			}
		}
		$this->loadViews("crearTareas");
	}
	/**Tareas de los Alumnos */
	public function misTareas()
	{
		if ($_SESSION['id']) {
			$data['tareas'] = $this->Site_model->getTareas($_SESSION['curso']);
			$this->loadViews("misTareas", $data);
		} else {
			redirect(base_url() . "dashboard", "location");
		}
	}
	/**Mensajes Enviados */
	public function mensajes()
	{
		
		if ($_SESSION['id']) {
			/**Comprobamos que se Ejecuto el POST */
			if ($_POST) {
				/**Insertar Mensajes */
				$this->Site_model->insertMensaje($_POST,$_SESSION['id']);
			}
			/**Obtener todos los Usuarios */
			$data['usuarios'] = $this->Site_model->getUsuarios($_SESSION['tipo'],$_SESSION['curso']);
			/**Obtenemos el Token */
			$token =$this->Site_model->getToken($_SESSION['id'],$_SESSION['tipo']);
			/**Obtenemos Los Mensajes */
			$data['mensajes']= $this->Site_model->getMensajes($token);
			$this->loadViews("mensajes",$data);
		} else {
			redirect(base_url() . "dashboard", "location");
		}
	}
	public function loadViews($view, $data = null)
	{
		/**Si tenemos una sesion creada */
		if (isset($_SESSION['username'])) {
			/**Sila vista es login nos vamos a dashboard */
			if ($view == "login") {
				redirect(base_url() . "dashboard", "location");
			}
			/**Si es cualquier otra vista la cargamos */
			$this->load->view('includes/header');
			$this->load->view('includes/sidebar');
			$this->load->view($view, $data);
			$this->load->view('includes/footer');
		} else {
			/**Si la vista es login la cargamos */
			if ($view == "login") {
				$this->load->view($view);
			}
			/**Si es caulquier otra vamos a login */
			else {
				redirect(base_url() . "dashboard/login", "location");
			}
		}
	}
}
