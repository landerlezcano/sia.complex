<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class categorias extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
		$this->load->model('bo/general');
		$this->load->model('bo/model_grupo_producto');
                $this->load->model('bo/model_categorias');
		$this->load->model('model_tipo_red');
	}
	
	function index(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
		redirect('/auth');
		}

		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}
		
		$id              = $this->tank_auth->get_user_id();
		$style           = $this->general->get_style($id);		
                
                $cat = $this->general->get_categorizacion_ACT();
		$this->template->set("cat",$cat);
		
		$this->template->set("style",$style);
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
                
                $cat = isset($_GET["id"]) ? $_GET["id"] : false;
		
		if($cat){			
			$catName = $this->general->get_categorizacion_ID_Atributo($cat,"descripcion");
			$this->template->set("cat",$catName);
			$this->template->build('website/bo/categorias/subindex');
		}else{
			$this->template->build('website/bo/categorias/index');
		}	
                
		
	}
        
	function listar(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
		redirect('/auth');
		}
		
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}
		
		$id              = $this->tank_auth->get_user_id();
		$style           = $this->general->get_style($id); 
		
                $cat = isset($_GET["id"]) ? $_GET["id"] : false;
                if(!$cat){
                    redirect('/bo/categorias');
                }
                
                $categorias = $this->model_categorias->listar_tipo($cat);                
		$this->template->set("categorias",$categorias);
                
		$this->template->set("style",$style);
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/categorias/listar');
	}
        
	function alta(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
		redirect('/auth');
		}
		
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}
		
                $cat = isset($_GET["id"]) ? $_GET["id"] : false;
                if(!$cat){
                    redirect('/bo/categorias');
                }
                
		$id              = $this->tank_auth->get_user_id();
		$style           = $this->general->get_style($id); 
		
		$this->template->set("style",$style); 
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/categorias/alta');
	}
	
	function crear(){ 
		if ($_POST['nombre']==""){
			echo "FAIL! Debe agregar un nombre a la categoria.";
		}
		
		echo $this->model_categorias->crear()
		? "La categoria ha sido agregada satisfactoriamente."
                : "La categoria no ha podido agregarse, Por favor verifique los datos.";
		
	}
	
	function editar(){
		$id              = $this->tank_auth->get_user_id();
		$style           = $this->general->get_style($id);
		$redes 	 		 = $this->model_tipo_red->listarTodos();
		$categoria	 	 = $this->model_grupo_producto->ConsultarCategoria($_POST['id']);
		
		$this->template->set("redes",$redes);
		$this->template->set("categoria",$categoria);
		$this->template->build('website/bo/categorias/editar');
	}
	
	function actualizar_categoria(){
		if ($_POST['nombre']==""){
			$error = "Debe agregar un nombre a la categoria.";
			$this->session->set_flashdata('error', $error);
			redirect('/bo/categorias/index');
		}
		
		$correcto = $this->model_grupo_producto->actualizar_categoria();
		$success = "La categoria ha sido actualizada satisfactoriamente.";
		$this->session->set_flashdata('success', $success);
		redirect("/bo/categorias/index");
		if($correcto){
			echo "Categoria Actualizada";
		}
		else{
			echo "No se logro actualizar la categoria";
		}
		
	}
	
	function eliminar_categoria(){
		
		if($this->model_grupo_producto->VerificarCategoria($_POST['id'])){
			$correcto = $this->model_grupo_producto->eliminar_categoria();
			if($correcto){
				echo "Se ha eliminada la categoria.";
			}
			else{
				echo "No se logro eliminada la categoria";
			}
		}else{
			echo "Ha ocurrido un error eliminado la categoria, debido a que tiene mercancias creadas.<br>
					Lo mas recomendable es que desative la categoria o elimine las mercancias.";
		}
	}
	
	function cambiar_estado_categoria(){
		$correcto = $this->model_grupo_producto->cambiar_estatus_categoria();
		echo "";
	}
}
