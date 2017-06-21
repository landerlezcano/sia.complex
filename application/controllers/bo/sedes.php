<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class sedes extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
		$this->load->model('bo/modelo_dashboard');
		$this->load->model('bo/modelo_sede');
		$this->load->model('bo/general');
		$this->load->model('bo/model_admin');
		$this->load->model('bo/modelo_sede'); 
		
	}
	
	function index() {
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
		redirect('/auth');
		}
		
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		
		if($this->general->isAValidUser($id,"comercial")||$this->general->isAValidUser($id,"logistica"))
		{
		}else{
			redirect('/auth/logout');
		}
		
		$style=$this->modelo_dashboard->get_style(1);
		
		$this->template->set("usuario",$usuario);
		$this->template->set("style",$style);
		$this->template->set("type",$usuario[0]->id_tipo_usuario);
		
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/sedes/index');
	}
	
	function alta() {
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
		redirect('/auth');
		}
		
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		
		if(!$this->general->isAValidUser($id,"logistica"))
		{
			redirect('/auth/logout');
		}
		
		$style=$this->modelo_dashboard->get_style(1);
		$pais            = $this->model_admin->get_pais();
		$this->template->set("pais",$pais);
		$this->template->set("usuario",$usuario);
		$this->template->set("style",$style);
		$this->template->set("type",$usuario[0]->id_tipo_usuario);
		
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/sedes/alta');
	}
	
	function crear() { 
		
		$sede = array(
				'nombre' => $_POST['nombre'],
				'descripcion' => $_POST['descripcion'],
				'ciudad' => $_POST['ciudad'],
				'direccion' => $_POST['direccion'],
				'telefono' => $_POST['telefono'],
				'estatus' => 'ACT',
				'codigo_postal' => $_POST['codigo_postal']
		);
		
		if($this->validar($sede)){			
			$this->modelo_sede->crear($sede);
			echo "La Sede ha sido creada satisfactoriamente"; 
		}else{
			echo "La Sede no pudo crearse. Por favor, verifique los datos e intente de nuevo"; 
		}
		//redirect('/bo/sedes/listar');
	}
	
	function validar($sede){
		$error = '';
		if($sede['nombre'] == ''){
			$error = "El nombre del almacen es obligatorio";
		}elseif ($sede['descripcion'] == ''){
			$error = "La descripción del almacen es obligatoria";
		}elseif ($sede['ciudad'] == ''){
			$error = "La ciudad del almacen es obligatoria";
		}elseif ($sede['telefono'] == ''){
			$error = "El telefono del almacen es obligatorio";
		}elseif ($sede['direccion'] == ''){
			$error = "La dirección del almacen es obligatoria";
		}
		elseif ($sede['codigo_postal'] == ''){
			$error = "El codigo postal  del almacen es obligatoria";
		}
		
		return ($error == '') ? true : false;
			//$this->session->set_flashdata('error', $error);
			//redirect('/bo/sedes/alta');
		
	}
	
	function validar_almacen_actualizar($almacen){
		$error = '';
		if($almacen['nombre'] == ''){
			$error = "El nombre del almacen es obligatorio";
		}elseif ($almacen['descripcion'] == ''){
			$error = "La descripción del almacen es obligatoria";
		}elseif ($almacen['ciudad'] == ''){
			$error = "La ciudad del almacen es obligatoria";
		}elseif ($almacen['telefono'] == ''){
			$error = "El telefono del almacen es obligatorio";
		}elseif ($almacen['direccion'] == ''){
			$error = "La dirección del almacen es obligatoria";
		}
		elseif ($almacen['codigo_postal'] == ''){
			$error = "EL codigo postal del almacen es obligatoria";
		}
	
		if($error == ''){
			return true;
		}else{
			echo $error;
			return false;
		}
	}
	
	function listar() {
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
		
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		
		if(!$this->general->isAValidUser($id,"logistica"))
		{
			redirect('/auth/logout');
		}
		
		$style=$this->modelo_dashboard->get_style(1);
		
		$sedes = $this->modelo_sede->listar();
		$this->template->set("usuario",$usuario);
		$this->template->set("style",$style);
		$this->template->set("sedes",$sedes);
		$this->template->set("type",$usuario[0]->id_tipo_usuario);
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/sedes/listar');
	}
	
	function eliminar(){
		if (!$this->tank_auth->is_logged_in()){																		// logged in
			redirect('/auth');
		}
		
		$id = $_POST['id'];
		
		$this->modelo_sede->eliminar($id);
		echo  'la Sede ha sido eliminada corectamente';
	}
	
	function cambiar_estado(){
		if (!$this->tank_auth->is_logged_in()){																		// logged in
			redirect('/auth');
		}
	
		$id = $_POST['id'];
		$estado = $_POST['estado'];
	
		$this->modelo_sede->cambiar_estado($id,$estado);
		
	}
	
	function editar(){
		if (!$this->tank_auth->is_logged_in()){																		// logged in
			redirect('/auth');
		}
		$pais            = $this->model_admin->get_pais();
		$sede = $this->modelo_sede->consultar ($_POST['id']);
		 
		$PaisCiudad = $this->modelo_sede->consultar_Pais_Ciudad($sede[0]->ciudad);
		$ciudades = $this->modelo_sede->consultar_ciudades($sede[0]->ciudad);
		$ciudad_actual = $this->modelo_sede->consultar_ciudad_actual($sede[0]->ciudad);
		$departamentos = $this->modelo_sede->consultar_departamento($sede[0]->ciudad);
		$departamento_activo = $this->modelo_sede->consultar_departamento_activo($sede[0]->ciudad);
		
		$this->template->set("pais",$pais);
		$this->template->set("sede",$sede);
		$this->template->set("ciudades",$ciudades);
		$this->template->set("departamentos",$departamentos);
		$this->template->set("ciudad_actual",$ciudad_actual);
		$this->template->set("departamento_activo",$departamento_activo);
		$this->template->set("PaisCiudad",$PaisCiudad);
		
		$this->template->build('website/bo/sedes/editar');
	}
	
	function actualizar(){
		
		
		$sede = array(
				'nombre' => $_POST['nombre'],
				'descripcion' => $_POST['descripcion'],
				'ciudad' => $_POST['ciudad'],
				'direccion' => $_POST['direccion'],
				'telefono' => $_POST['telefono'],
				'codigo_postal' => $_POST['codigo_postal']
		);
		 
		if($this->validar ($sede)){
			 	
			$this->modelo_sede->actualizar ($sede,$_POST['id']);
			
			echo "La Sede ha sido Actualizada satisfactoriamente"; 
		}else{
			echo "La Sede no pudo Actualizarse. Por favor, verifique los datos e intente de nuevo"; 
		}
	}
}
