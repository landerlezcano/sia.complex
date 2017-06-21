<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class usuarios extends CI_Controller
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
		//$this->load->model('ov/model_perfil_red');
		$this->load->model('ov/model_perfil');
		$this->load->model('ov/modelo_afiliado');
		$this->load->model('model_tipo_red');
		$this->load->model('bo/model_tipo_usuario');
		$this->load->model('bo/modelo_dashboard');
		$this->load->model('model_cedi');
        $this->load->model('bo/modelo_sede');
		$this->load->model('bo/model_admin');
		$this->load->model('bo/modelo_almacen');
	}
	
	function index(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
		redirect('/auth');
		}
		
		$id=$this->tank_auth->get_user_id();
		
		if(!$this->general->isAValidUser($id,"administracion"))
		{
			redirect('/auth/logout');
		}

		$usuario=$this->general->get_username($id);
		
                
		$style=$this->modelo_dashboard->get_style(1);
		
		$this->template->set("usuario",$usuario);
		$this->template->set("style",$style);
		
		$tipo_usuario = $this->general->get_tipo_usuario_ACT();
		$this->template->set("roles",$tipo_usuario);
		
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		
		$rol = isset($_GET["rol"]) ? $_GET["rol"] : false;
		
		if($rol){			
			$rolName = $this->general->get_tipo_usuario_ID_Atributo($rol,"descripcion");
			$this->template->set("rol",$rolName);
			$this->template->build('website/bo/usuarios/subindex');
		}else{
			$this->template->build('website/bo/usuarios/index');
		}		
		
	}
	
	function siguiente(){
		/*Peticiones Necesarias*/
		$rol = isset($_GET["id"]) ? $_GET["id"] : false;
		$mail_usuario = isset($_GET["token"]) ? $_GET["token"] : false;
		/*Condiciones : Carga Fallida de Peticiones, $rol identico a 3 [Estudiante]*/
		$noAplica = (!$rol||!$mail_usuario||$rol==3) ? true : false;
		/*Parametros: E-mail $mail_usuario
                 *Resultado: Identificador de Usuario $user_id,Rol de Usuario $user_rol*/
		$use_mail = ($mail_usuario) 
                    ? $this->model_perfil->exist_mail($mail_usuario) : false;
                $user_id = $use_mail ? $use_mail[0]->id : 0;                
		$use_rol = $this->model_perfil->get_perfil($user_id);
		$user_rol = $use_rol ? $use_rol[0]->id_tipo_usuario : 0;
		/*Condiciones : $rol diferente a Rol de Usuario $user_rol, 
                 *              Carga Fallida de Identificador de Usuario $user_id*/
		$noExiste = ($rol!=$user_rol||!$user_id) ? true : false;		
		/*Parametros: Identificador de Usuario $user_id
                 *Resultado: Identificador de Sede $user_sede*/
                $user_sede= ($user_id) ?
                            $this->modelo_sede->get_sede_usuario($user_id) : 0;
                $existeSede = ($user_sede&&$user_sede>0) ? true : false;
                /*Caso Afirmativo: retorno sin acciones al CRUD de Usuarios*/
		if($noAplica || $noExiste ||$existeSede){
                        redirect('/bo/usuarios');
		}else{
                        redirect('/bo/usuarios/organizacion?id='.$user_id);
                }
	}
	
	function organizacion()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
		
		$id              = isset($_GET["id"]) ? $_GET["id"] : false;
		$usuario         = $this->model_perfil->datos_perfil($id);
		$telefonos       = $this->model_perfil->telefonos($id);
		$sexo            = $this->model_perfil->sexo();
		$pais            = $this->model_perfil->get_pais();
		$style           = $this->general->get_style(1);
		$dir             = $this->model_perfil->dir($id);
		$civil           = $this->model_perfil->edo_civil();
		$tipo_fiscal     = $this->model_perfil->tipo_fiscal();
		$estudios        = $this->model_perfil->get_estudios();
		$ocupacion       = $this->model_perfil->get_ocupacion();
		$tiempo_dedicado = $this->model_perfil->get_tiempo_dedicado();
		//$red 			 = $this->model_afiliado->RedAfiliado($id, $id_red);
		//$premium         = $red[0]->premium;
		//$afiliados       = $this->model_perfil->get_afiliados($id_red, $id);
	
		$image 			 = $this->model_perfil->get_images($id);
		//$red_forntales 	 = $this->model_tipo_red->ObtenerFrontalesRed($id_red );
	
		$img_perfil="/template/img/empresario.jpg";
		foreach ($image as $img)
		{
			$cadena=explode(".", $img->img);
			if($cadena[0]=="user")
			{
				//$img_perfil=$img->url;
			}
		}
		$this->template->set("id",$id);
		$this->template->set("style",$style);
		$this->template->set("afiliados",$afiliados);
		$this->template->set("sexo",$sexo);
		$this->template->set("civil",$civil);
		$this->template->set("pais",$pais);
		$this->template->set("tipo_fiscal",$tipo_fiscal);
		$this->template->set("estudios",$estudios);
		$this->template->set("ocupacion",$ocupacion);
		$this->template->set("tiempo_dedicado",$tiempo_dedicado);
		$this->template->set("img_perfil",$img_perfil);
		$this->template->set("red_frontales",$red_forntales);
		//$this->template->set("premium",$premium);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/usuarios/organizacion');
	}
	
	function alta(){
		
		if (!$this->tank_auth->is_logged_in()){																		// logged in
		redirect('/auth');
		}
		$id=$this->tank_auth->get_user_id();
		
		if(!$this->general->isAValidUser($id,"comercial"))
		{
			redirect('/auth/logout');
		}

		$usuario=$this->general->get_username($id);
		
		$id              =  2;
		$rol = isset($_GET["rol"]) ? $_GET["rol"] : false;
                
                if(!$rol){
                    redirect('/bo/usuarios');
                }
                
		$sexo            = $this->model_perfil->sexo();
		$pais            = $this->model_perfil->get_pais();
		$style           = $this->general->get_style(1);
		$civil           = $this->model_perfil->edo_civil();
		$tipo_fiscal     = $this->model_perfil->tipo_fiscal();
		$estudios        = $this->model_perfil->get_estudios();
		$ocupacion       = $this->model_perfil->get_ocupacion();
		$tiempo_dedicado = $this->model_perfil->get_tiempo_dedicado();
		$tipos 			 = $this->model_tipo_usuario->listarTodos();
		
		$image 			 = $this->model_perfil->get_images($id);			
		
		$img_perfil="/template/img/empresario.jpg";
		foreach ($image as $img)
		{
			$cadena=explode(".", $img->img);
			if($cadena[0]=="user")
			{
				$img_perfil=$img->url;
			}
		}			
		
                $sedes = $this->modelo_sede->consultar_ACT();
                $secciones = $this->general->get_secciones_perfil($rol);
                
                $this->template->set("sedes",$sedes);
                $this->template->set("secciones",$secciones);
		$this->template->set("sexo",$sexo);
		$this->template->set("civil",$civil);
		$this->template->set("pais",$pais);
		$this->template->set("tipo_fiscal",$tipo_fiscal);
		$this->template->set("estudios",$estudios);
		$this->template->set("ocupacion",$ocupacion);
		$this->template->set("tiempo_dedicado",$tiempo_dedicado); 
		$this->template->set("tipos",$tipos);
		
		$rolName = $this->general->get_tipo_usuario_ID_Atributo($rol,"descripcion");
		$this->template->set("rol",$rolName);
		
		$this->template->set_theme('desktop');
		$this->template->set("style",$style);
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/usuarios/formulario');
	}
	
        function jefes(){
            
            $sede = isset($_POST["sede"]) ? $_POST["sede"] : 1;
            
            $jefes = $this->modelo_sede->getJefes($sede);
            
            $options = "<option value='1'>David Hidalgo</option>";
            foreach ($jefes as $jefe){
                
                $options.="<option value='$jefe->id'>$jefe->jefe</option>";
                
            }
            
            echo $options;
        }	
	
	function altaTipoDeUsuarioAcceso(){
		
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
		redirect('/auth');
		}
		$id=$this->tank_auth->get_user_id();
		
		if(!$this->general->isAValidUser($id,"administracion"))
		{
			redirect('/auth/logout');
		}

		$usuario=$this->general->get_username($id);
		
		$style=$this->modelo_dashboard->get_style(1);
		
		$tiposUsuario=$this->model_tipo_usuario->getTipoUsuarios();
		
		
		$this->template->set("tiposUsuario",$tiposUsuario);
		$this->template->set("usuario",$usuario);
		$this->template->set("style",$style);
		
		if ($this->tank_auth->is_logged_in(FALSE)) {						// logged in, not activated
			redirect('/auth/send_again/');
		
		} elseif (!$this->config->item('allow_registration', 'tank_auth')) {	// registration is off
			$this->_show_message($this->lang->line('auth_message_registration_disabled'));
		
		} else {
			$use_username = $this->config->item('use_username', 'tank_auth');
			if ($use_username) {
				$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|min_length['.$this->config->item('username_min_length', 'tank_auth').']|max_length['.$this->config->item('username_max_length', 'tank_auth').']|alpha_dash');
			}
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');
			$email_activation = $this->config->item('email_activation', 'tank_auth');
		
			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->tank_auth->create_user(
						$use_username ? $this->form_validation->set_value('username') : '',
						$this->form_validation->set_value('email'),
						$this->form_validation->set_value('password'),
						$email_activation))) {
							
				$this->model_tipo_usuario->newUser($_POST['nombre'],$_POST['apellido'],$_POST['tipo']);
				redirect('/bo/usuarios/listarTipoDeUsuarioAcceso');
				/*
					$data['site_name'] = $this->config->item('website_name', 'tank_auth');
					$last_id=$this->general->get_last_id();
					$data['lst_id']=$last_id;
					if ($email_activation) {									// send "activate" email
						$data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;
						$id_nuevo_usr=$this->db->query("select id from users order by id desc limit 1");
						$data['id']=$id_nuevo_usr[0]->id;
						//$this->send_email_activate( $data['email'], $data);
		
						unset($data['password']); // Clear password (just for any case)
		
						//$this->_show_message($this->lang->line('auth_message_registration_completed_1'));
		
					} else {
		
						if ($this->config->item('email_account_details', 'tank_auth')) {	// send "welcome" email
		
							//$this->_send_email('welcome', $data['email'], $data);
						}
						unset($data['password']); // Clear password (just for any case)
		
						//$this->_show_message($this->lang->line('auth_message_registration_completed_2').' '.anchor('/auth/login/', 'Login'));
					}*/
				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$data['use_username'] = $use_username;
			$this->template->set("data",$data);
			$this->template->set_theme('desktop');
			$this->template->set_layout('website/main');
			$this->template->set_partial('header', 'website/bo/header');
			$this->template->set_partial('footer', 'website/bo/footer');
			$this->template->build('website/bo/comercial/altas/usuarios/alta',$data);
				
		}

	}
	
	function altaUsuarioAcceso(){
		
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
		redirect('/auth');
		}
		$id=$this->tank_auth->get_user_id();
		
		if(!$this->general->isAValidUser($id,"administracion"))
		{
			redirect('/auth/logout');
		}
		
		$usuario=$this->general->get_username($id);
		
		$style=$this->modelo_dashboard->get_style(1);
		
		$this->template->set("usuario",$usuario);
		$this->template->set("style",$style);
		
			$this->template->set_theme('desktop');
			$this->template->set_layout('website/main');
			$this->template->set_partial('header', 'website/bo/header');
			$this->template->set_partial('footer', 'website/bo/footer');
			$this->template->build('website/bo/comercial/altas/usuarios/altaUsuarioAcceso');
	}

	
	
	
	
	function listarTipoDeUsuarioAcceso(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
		$id=$this->tank_auth->get_user_id();
		
		if(!$this->general->isAValidUser($id,"administracion"))
		{
			redirect('/auth/logout');
		}

		$usuario=$this->general->get_username($id);
	
		$style=$this->modelo_dashboard->get_style(1);
		$users=$this->model_tipo_usuario->get_all_users();

		$this->template->set("usuario",$usuario);
		$this->template->set("style",$style);
		$this->template->set("users",$users);
		
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/comercial/altas/usuarios/listar');
	}
	
	
	
	function get_formulario(){
		if (!$this->tank_auth->is_logged_in()){																		// logged in
		redirect('/auth');
		}
		$id=$this->tank_auth->get_user_id();
		
		if(!$this->general->isAValidUser($id,"comercial"))
		{
			redirect('/auth/logout');
		}

		$usuario=$this->general->get_username($id);
		
		$id   = isset($_POST["id"]) ? $_POST["id"] : 1;
                $rol = isset($_POST["rol"]) ? $_POST["rol"] : 3;
                
                if(!$id||!$rol){
                    exit();
                }
                
                $usuario         = $this->model_perfil->datos_perfil($id);
		$telefonos       = $this->model_perfil->telefonos($id);
		$edad            = $this->model_perfil->edad($id);
                $dir             = $this->model_perfil->dir($id);
                $style           = $this->general->get_style($id);
                $coaplicante	 = $this->model_perfil->get_coaplicante($id);
		$cuenta			 = $this->model_perfil->val_cuenta_banco($id);
                $org             = $this->general->get_organizacion_id($id);
                $use_jefe        = ($org) ? $org[0]->jefe : $id;
                $jefe            = $this->model_perfil->datos_perfil($use_jefe) ;
                
		$sexo            = $this->model_perfil->sexo();
		$pais            = $this->model_perfil->get_pais();                 
		$civil           = $this->model_perfil->edo_civil();
		$tipo_fiscal     = $this->model_perfil->tipo_fiscal();
		$estudios        = $this->model_perfil->get_estudios();
		$ocupacion       = $this->model_perfil->get_ocupacion();
		$tiempo_dedicado = $this->model_perfil->get_tiempo_dedicado();
		$tipos 		 = $this->model_tipo_usuario->listarTodos();
		
		$image 			 = $this->model_perfil->get_images($id);			
		
		$img_perfil="/template/img/empresario.jpg";
		foreach ($image as $img)
		{
			$cadena=explode(".", $img->img);
			if($cadena[0]=="user")
			{
				$img_perfil=$img->url;
			}
		}			
		
                $sedes = $this->modelo_sede->consultar_ACT();
                $secciones = $this->general->get_secciones_perfil($rol);
                
                $this->template->set("id",$id);
                $this->template->set("rol",$rol);
                $this->template->set("dir",$dir);
                $this->template->set("jefe",$jefe);
                $this->template->set("ref",$coaplicante);
                $this->template->set("org",$org);
		$this->template->set("style",$style);
		$this->template->set("usuario",$usuario);
		$this->template->set("telefonos",$telefonos);
		$this->template->set("edad",$edad[0]->edad);
                $this->template->set("sedes",$sedes);
                $this->template->set("secciones",$secciones);
		$this->template->set("sexo",$sexo);
		$this->template->set("civil",$civil);
		$this->template->set("pais",$pais);
		$this->template->set("tipo_fiscal",$tipo_fiscal);
		$this->template->set("estudios",$estudios);
		$this->template->set("ocupacion",$ocupacion);
		$this->template->set("tiempo_dedicado",$tiempo_dedicado); 
		$this->template->set("tipos",$tipos);
		 
		$this->template->build('website/bo/usuarios/editar');
	}
	
	function eliminar()
	{
		$id = $_POST['id'];
                
                $this->model_perfil->eliminar($id);

                echo "Acción Exitoso <br> Se ha Eliminado el Usuario";
	}
	
	function actualizar()
	{
		$id = $_POST['id'];
		$_POST['mail']=$_POST['email']; 
		$use_mail=$this->model_perfil->use_mail_modificar_perfil($id);
		$pais = $this->model_perfil->get_pais_Afiliado($id);
		$pais = ($pais) ? $pais[0]->codigoPais : "MEX";

		if($use_mail){
			echo "El Email ya existe , ingrese otro no existente";
			exit();
		}
		
                if(strlen($_POST['password'])>0) {
                    $this->tank_auth->change_pass_easy($_POST['id'], $_POST['password']);        
                }
                
		$this->model_perfil->actualizar($id,$pais);
                
                $rol = isset($_POST["rol"]) ? $_POST["rol"] : 3; 
                
                if ($rol != 3 && $rol != 6) {
                    $this->general->update_organizacion_id($id);
                }

                echo "Felicitaciones <br> Se han actualizado los datos";
	}
	
	
	function kill_user()
	{
		$this->db->query("delete from users where id=".$_POST["id"]);
		$this->db->query("delete from user_profiles where user_id=".$_POST["id"]);
	}
	
	
	
	function nuevo()
	{
		
		$resultado = $this->modelo_afiliado->crearUsuario();
		#echo $resultado;
		//$resultado=$this->model_perfil->afiliar_nuevo($id);
		
		if(intval($resultado))
		{
			#$id_afiliado=$this->model_perfil->get_id(); //$id_afiliado[0]->id
                        if(!$_POST['img']){
                           //echo "hola";exit(); 
                            $this->foto($resultado, 0);
                           	// $this->model_perfil->img_user($id/*,$data["upload_data"]*/);
                        }

			echo "!FINE¡ El usuario <b>".$_POST['nombre']."&nbsp; ".$_POST['apellido']."</b> ha quedado Registrado";// con el id <b>".$resultado."</b>";
                        
		}
		else
		{
			echo "!UPS¡ lo sentimos parece que algo fallo";
		}
                
                
	}
	
	function listar()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
	
		$usuario=$this->general->get_username($id);
	
		$style         = $this->general->get_style(1);
	
		$rol = isset($_GET["rol"]) ? $_GET["rol"] : false;
                
                if(!$rol){
                    redirect('/bo/usuarios');
                }
                
		$usuarios     = $this->model_perfil->get_usuarios_rol($rol);
		$image=$this->model_perfil->get_images_users();
	 
	
		$this->template->set("style",$style); 
	
		$this->template->set("usuarios",$usuarios);
		$this->template->set("image",$image);
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/usuarios/listar');
	}
	
	
	function foto($id,$tipo)
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
		
               
		//Checamos si el directorio del usuario existe, si no, se crea
		if(!is_dir(getcwd()."/media/".$id))
		{
			mkdir(getcwd()."/media/".$id, 0777);
		}

		if($tipo==0)
		{
			$nombre="user";
			$contenido=scandir(getcwd()."/media/".$id);
			if(sizeof($contenido)>2)
			{
				for($i=2;$i<sizeof($contenido);$i++)
				{
					$cadena=explode(".", $contenido[$i]);

					if($cadena[0]=="user")
					{
						unlink(getcwd()."/media/".$id."/".$contenido[$i]);
						
					}
				}
			}
		}
		if($tipo==1)
		{
			$nombre="fondo";
			$contenido=scandir(getcwd()."/media/".$id);
			if(sizeof($contenido)>2)
			{
				for($i=2;$i<sizeof($contenido);$i++)
				{
					$cadena=explode(".", $contenido[$i]);

					if($cadena[0]=="fondo")
					{
						unlink(getcwd()."/media/".$id."/".$contenido[$i]);
						
					}
				}
			}
		}
                
		$ruta="/media/".$id."/";
		//definimos la ruta para subir la imagen
		$config['upload_path'] 		= getcwd().$ruta;
		$config['allowed_types'] 	= 'gif|jpg|png|jpeg';
		$config['file_name'] 		= $nombre;
		$config['max_width']  		= '4096';
		$config['max_height']   	= '3112';

		//Cargamos la libreria con las configuraciones de arriba
		$this->load->library('upload', $config);

		//Preguntamos si se pudo subir el archivo "foto" es el nombre del input del dropzone
		if (!$this->upload->do_upload("img"))
		{
			echo $this->upload->display_errors();
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			//$this->model_perfil->img_user($id/*,$data["upload_data"]*/);
		}
	}
	
}
