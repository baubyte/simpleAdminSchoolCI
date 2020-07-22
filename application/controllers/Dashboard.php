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
		$data["alumnos"]=$this->Site_model->getAlumnos($_SESSION["curso"]);
		if ($_SESSION['tipo']=="profesor") {
			$this->loadViews("gestionAlumnos",$data);
		}else {
			redirect(base_url()."dashboard/login", "location");
		}

		
	}
	public function loadViews($view, $data = null)
	{
		/**Si tenemos una sesion creada */
		if (isset($_SESSION['username'])) {
			/**Sila vista es login nos vamos a dashboard */
			if ($view == "login") {
				redirect(base_url()."dashboard", "location");
			}
			/**Si es cualquier otra vista la cargamos */
			$this->load->view('includes/header');
			$this->load->view('includes/sidebar');
			$this->load->view($view,$data);
			$this->load->view('includes/footer');
		} else {
			/**Si la vista es login la cargamos */
			if ($view == "login") {
				$this->load->view($view);
			} 
			/**Si es caulquier otra vamos a login */
			else {
				redirect(base_url()."dashboard/login", "location");
			}
		}
	}
}
