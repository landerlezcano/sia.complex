<?php if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

class evento extends CI_Controller {
	function __construct() {
		parent::__construct ();
		
		$this->load->helper ( array (
				'form',
				'url' 
		) );
		$this->load->library ( 'form_validation' );
		$this->load->library ( 'security' );
		$this->load->library ( 'tank_auth' );
		$this->lang->load ( 'tank_auth' );
		$this->load->model ( 'bo/modelo_dashboard' );
		$this->load->model ( 'bo/general' );
		$this->load->model ( 'bo/modelo_comercial' );
		// $this->load->model('ov/model_perfil');
		$this->load->model ( 'ov/model_perfil' );
		$this->load->model ( 'model_cat_tipo_usuario' );
		$this->load->model ( 'model_cat_sexo' );
		$this->load->model ( 'model_cat_edo_civil' );
		$this->load->model ( 'model_cat_estudios' );
		$this->load->model ( 'model_cat_ocupacion' );
		$this->load->model ( 'model_cat_estatus_afiliado' );
		$this->load->model ( 'model_cat_tiempo_dedicado' );
		$this->load->model ( 'model_cat_usuario_fiscal' );
		$this->load->model ( 'model_users' );
		$this->load->model ( 'model_user_profiles' );
		$this->load->model ( 'model_coaplicante' );
		$this->load->model ( 'bo/model_admin' );
		$this->load->model ( 'bo/modelo_sede' );
		$this->load->model ( 'bo/modelo_cursos' );
		$this->load->model ( 'bo/modelo_evento' );
		$this->load->model ( 'bo/model_categorias' );
		$this->load->model ( 'bo/model_mercancia' );
		$this->load->model ( 'ov/modelo_compras' );
		$this->load->model ( 'ov/modelo_billetera' );
		$this->load->model ( 'bo/model_bonos' );
		$this->load->model ( 'model_tipo_red' );
		$this->load->model ( 'cemail' );
	}
	function index() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		
		#if (! $this->general->isAValidUser ( $id, "comercial" )) {
		#	redirect ( '/auth/logout' );
		#}
		
		$style = $this->modelo_dashboard->get_style ( 1 );
		
		$this->template->set ( "usuario", $usuario );
		$this->template->set ( "style", $style );
		
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/sede/header' );
		$this->template->set_partial ( 'footer', 'website/sede/footer' );
		$this->template->build ( 'website/sede/evento/index' );
	}
	function billetera_afiliado() {
		$style = $this->modelo_dashboard->get_style ( 1 );
		$usuario = $this->tank_auth->get_user_id ();
		$id = $_POST ['id'];
		
		$this->template->set ( "usuario", $usuario );
		// $usuario=$this->general->get_username($id);
		// $style=$this->general->get_style($id);
		
		$redes = $this->model_tipo_red->listarTodos ();
		$redesUsuario = $this->model_tipo_red->RedesUsuario ( $id );
		
		$ganancias = array ();
		$comision_directos = array ();
		$bonos = array ();
		
		foreach ( $redesUsuario as $red ) {
			// $array_bono = $this->model_bonos->ver_total_bonos_id($id,$red->id,'');
			// $array_ganancias = $this->modelo_billetera->get_comisiones($id,$red->id);
			// $array_comision = $this->modelo_billetera->getComisionDirectos($id, $red->id);
			
			array_push ( $bonos, $this->model_bonos->ver_total_bonos_id_red ( $id, $red->id ) );
			array_push ( $ganancias, $this->modelo_billetera->get_comisiones ( $id, $red->id ) );
			array_push ( $comision_directos, $this->modelo_billetera->getComisionDirectos ( $id, $red->id ) );
		}
		
		$comision_todo = array (
				'directos' => $comision_directos,
				'ganancias' => $ganancias,
				'bonos' => $bonos,
				'redes' => $redesUsuario 
		);
		
		$comisiones = $this->modelo_billetera->get_total_comisiones_afiliado ( $id );
		$cobro = $this->modelo_billetera->get_cobros_total ( $id );
		$cobroPendientes = $this->modelo_billetera->get_cobros_pendientes_total_afiliado ( $id );
		$retenciones = $this->modelo_billetera->ValorRetencionesTotales ( $id );
		$total_bonos = $this->model_bonos->ver_total_bonos_id ( $id );
		
		$transaction = $this->modelo_billetera->get_total_transacciones_id ( $id );
		
		$this->template->set ( "style", $style );
		$this->template->set ( "usuario", $usuario );
		$this->template->set ( "id", $id );
		$this->template->set ( "redes", $redesUsuario );
		$this->template->set ( "bonos", $bonos );
		$this->template->set ( "total_bonos", $total_bonos );
		$this->template->set ( "comisiones", $comisiones );
		$this->template->set ( "comision_todo", $comision_todo );
		$this->template->set ( "ganancias", $ganancias );
		$this->template->set ( "transaction", $transaction );
		$this->template->set ( "comisiones_directos", $comision_directos );
		$this->template->set ( "cobro", $cobro );
		$this->template->set ( "cobroPendientes", $cobroPendientes );
		$this->template->set ( "retenciones", $retenciones );
		
		$this->template->set_theme ( 'desktop' );
		// $this->template->set_layout('website/main');
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/comercial/billetera' );
	}
	function add_sub_billetera_afiliado() {
		$id = $_POST ['id'];
		$monto = $_POST ['cobro'];
		$descripcion = $_POST ['descripcion'];
		$tipo = $_POST ['tipo'];
		
		$transact = $this->modelo_billetera->add_sub_billetera ( $tipo, $id, $monto, $descripcion );
		
		$data = array (
				'email' => $this->model_perfil->get_email ( $id ),
				'username' => $this->model_perfil->get_username ( $id ),
				'id_transaccion' => $transact,
				'tipo_t' => ($tipo == "ADD") ? "Agregado" : "Descontado",
				'descripcion_t' => $descripcion,
				'monto_t' => $monto 
		);
		
		$email = $this->cemail->send_email ( 10, $data ['email'], $data );
		
		echo $transact ? "Transacción Exitosa" : "Falló la Transacción";
		// echo $email ? "Email Enviado" : "Falló envio de Email";
	}
	function transacciones_billetera() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		
		if (! $this->general->isAValidUser ( $id, "comercial" )) {
			redirect ( '/auth/logout' );
		}
		
		$style = $this->modelo_dashboard->get_style ( $id );
		
		$this->template->set ( "usuario", $usuario );
		$this->template->set ( "style", $style );
		
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/comercial/transacciones' );
	}
	function listar_transacciones() {
		$fecha_inicio = $_POST ['startdate'];
		$fecha_fin = $_POST ['finishdate'];
		
		if ($fecha_inicio && $fecha_fin) {
			$transactions = $this->modelo_billetera->get_transacciones_fecha ( $fecha_inicio, $fecha_fin );
			
			echo "<table id='datatable_fixed_column1' class='table table-striped table-bordered table-hover' width='100%'>
				<thead id='tablacabeza'>
					<th data-class='expand'>ID Transacción</th>
					<th data-hide='phone,tablet'>Username</th>
					<th data-hide='phone,tablet'>Nombre Completo </th>
					<th data-hide='phone,tablet'>Tipo de Transacción</th>
					<th data-hide='phone,tablet'>Motivo</th>
					<th data-hide='phone,tablet'>Valor</th>
					<th data-hide='phone,tablet'>Accion</th>
				</thead>
				<tbody>";
			
			foreach ( $transactions as $transaction ) {
				$color = ($transaction->tipo == "plus") ? "green" : "red";
				echo "<tr>
			<td class='sorting_1'>" . $transaction->id . "</td>
			<td>" . $transaction->username . "</td>
			<td>" . $transaction->nombres . "</td>
			<td style='color: " . $color . ";'><i class='fa fa-" . $transaction->tipo . "-circle fa-3x'></i></td>
			<td>" . $transaction->descripcion . "</td>
			<td> $	" . number_format ( $transaction->monto, 2 ) . "</td>
			<td>
				
				<a title='Eliminar' style='cursor: pointer;' class='txt-color-red' onclick='eliminar(" . $transaction->id . ");'>
				<i class='fa fa-trash-o fa-3x'></i>
				</a>
			</td>
			</tr>";
			}
		}
		echo "</tbody>
		</table><tr class='odd' role='row'>";
	}
	function kill_transaccion() {
		// echo "dentro de kill controller ";
		$q = $this->modelo_billetera->kill_transaccion ( $_POST ['id'] );
		if ($q) {
			echo "La transacción ha sido eliminado con exito";
		} else {
			echo "La transacción no pudo ser eliminado";
		}
	}
	function red_genealogica() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		
		if ($usuario [0]->id_tipo_usuario != 1) {
			redirect ( '/auth/logout' );
		}
		
		$style = $this->modelo_dashboard->get_style ( $id );
		
		$id_red = $this->modelo_comercial->get_red ( $id );
		$id_red = $id_red [0]->id_red;
		$afiliados = $this->modelo_comercial->get_afiliados ( $id_red );
		
		$this->template->set ( "afiliados", $afiliados );
		$this->template->set ( "usuario", $usuario );
		$this->template->set ( "style", $style );
		
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/comercial/red/genealogico' );
	}
	function red_tabla() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		
		if (! $this->general->isAValidUser ( $id, "comercial" )) {
			redirect ( '/auth/logout' );
		}
		
		$usuario = $this->general->get_username ( $id );
		
		$style = $this->general->get_style ( 1 );
		
		$afiliados = $this->model_perfil->get_tabla ();
		$image = $this->model_perfil->get_images_users ();
		
		$id_red = 0;
		
		$this->template->set ( "style", $style );
		
		$this->template->set ( "id_red", $id_red );
		
		$this->template->set ( "afiliados", $afiliados );
		$this->template->set ( "image", $image );
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/comercial/red/tabla_' );
	}
	function actualizar_tabla() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		
		if (! $this->general->isAValidUser ( $id, "comercial" )) {
			redirect ( '/auth/logout' );
		}
		
		$usuario = $this->general->get_username ( $id );
		
		$style = $this->general->get_style ( 1 );
		$id_red = 0;
		// $id_red = $_POST['id_red'];
		
		if (isset ( $_POST ['nombre_buscado'] )) {
			$longitud_nombre = strlen ( $_POST ['nombre_buscado'] );
			$id_red = 0;
			// $id_red = $_POST['id_red'];
			if ($longitud_nombre >= 0 && $longitud_nombre < 2) {
				$error = "La casilla nombre debe contener al menos 2 letras.";
				$this->session->set_flashdata ( 'error', $error );
				redirect ( '/bo/comercial/red_tabla?id_red=' . $id_red . '' );
			} 

			else {
				$afiliados = $this->model_perfil->get_tabla_por_nombre_buscado ( $_POST ['nombre_buscado'], $id_red );
				$image = $this->model_perfil->get_images_users ();
			}
		}
		
		if (isset ( $_POST ['apellido_buscado'] )) {
			$longitud_apellido = strlen ( $_POST ['apellido_buscado'] );
			$id_red = 0;
			// $id_red = $_POST['id_red'];
			if ($longitud_apellido >= 0 && $longitud_apellido < 2) {
				$error = "La casilla apellido debe contener al menos 2 letras.";
				$this->session->set_flashdata ( 'error', $error );
				redirect ( '/bo/comercial/red_tabla?id_red=' . $id_red . '' );
			} 

			else {
				$afiliados = $this->model_perfil->get_tabla_por_apellido_buscado ( $_POST ['apellido_buscado'], $id_red );
				$image = $this->model_perfil->get_images_users ();
			}
		}
		
		if (isset ( $_POST ['username_buscado'] )) {
			$longitud_username = strlen ( $_POST ['username_buscado'] );
			$id_red = 0;
			// $id_red = $_POST['id_red'];
			if ($longitud_username >= 0 && $longitud_username < 2) {
				$error = "La casilla username debe contener al menos 2 letras.";
				$this->session->set_flashdata ( 'error', $error );
				redirect ( '/bo/comercial/red_tabla?id_red=' . $id_red . '' );
			} 

			else {
				$afiliados = $this->model_perfil->get_tabla_por_username_buscado ( $_POST ['username_buscado'], $id_red );
				$image = $this->model_perfil->get_images_users ();
			}
		}
		
		if (isset ( $_POST ['email_buscado'] )) {
			$longitud_email = strlen ( $_POST ['email_buscado'] );
			$id_red = 0;
			// $id_red = $_POST['id_red'];
			if ($longitud_email >= 0 && $longitud_email < 6) {
				$error = "La casilla email debe contener al menos 6 letras.";
				$this->session->set_flashdata ( 'error', $error );
				redirect ( '/bo/comercial/red_tabla?id_red=' . $id_red . '' );
			} 

			else {
				$afiliados = $this->model_perfil->get_tabla_por_email_buscado ( $_POST ['email_buscado'], $id_red );
				$image = $this->model_perfil->get_images_users ();
			}
		}
		
		if (isset ( $_POST ['id_buscado'] )) {
			$id_red = 0;
			$longitud_id = strlen ( $_POST ['id_buscado'] );
			if ($longitud_id == 0) {
				$error = "La casilla id no puede estar vacia.";
				$this->session->set_flashdata ( 'error', $error );
				redirect ( '/bo/comercial/red_tabla?id_red=' . $id_red . '' );
			} 			// $id_red = $_POST['id_red'];
			else {
				$afiliados = $this->model_perfil->get_tabla_por_id_buscado ( $_POST ['id_buscado'], $id_red );
				$image = $this->model_perfil->get_images_users ();
			}
		}
		
		if ($afiliados [0] == NULL) {
			$error = "El afiliado que estas buscando no existe.";
			$this->session->set_flashdata ( 'error', $error );
			redirect ( '/bo/comercial/red_tabla?id_red=' . $id_red . '' );
		}
		
		/*
		 * var_dump($afiliados[0]!=NULL);
		 * exit();
		 */
		
		$this->template->set ( "style", $style );
		
		$this->template->set ( "id_red", $id_red );
		
		$this->template->set ( "afiliados", $afiliados );
		$this->template->set ( "image", $image );
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/comercial/red/tabla_' );
	}
	function alta() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		
		#if (! $this->general->isAValidUser ( $id, "comercial" )) {
		#	redirect ( '/auth/logout' );
		#}
		
		$usuario = $this->general->get_username ( $id );
		$org = $this->general->get_organizacion_id($id);
		$sedes = $this->modelo_sede->consultar ($org[0]->sede);
		//$oferta = $this->model_categorias->listar_tipo ( 1 );
		//$facultad = $this->model_categorias->listar_tipo ( 2 );
		//$docentes = $this->general->get_usuarios_rol ( 6 );
		$cursos = $this->modelo_cursos->consultar_ACT ();
		
		$style = $this->modelo_dashboard->get_style ( 1 );
		
		$this->template->set ( "cursos", $cursos );
		$this->template->set ( "sedes", $sedes );
		//$this->template->set ( "oferta", $oferta );
		//$this->template->set ( "facultad", $facultad );
		//$this->template->set ( "docente", $docentes );
		$this->template->set ( "usuario", $usuario );
		$this->template->set ( "style", $style );
		
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/sede/header' );
		$this->template->set_partial ( 'footer', 'website/sede/footer' );
		$this->template->build ( 'website/sede/evento/alta' );
	}
	function editar() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id_user = $this->tank_auth->get_user_id ();
		
		#if (! $this->general->isAValidUser ( $id, "comercial" )) {
		#	redirect ( '/auth/logout' );
		#}
		
		$id = $_POST ['id'] ? $_POST ['id'] : 1;
		
		$curso = $this->modelo_evento->consultar ( $id );
		$galeria = $this->modelo_evento->consultarGaleria ( $id );
		
		$jsArray = array ();
		foreach ( $galeria as $imagen ) {
			array_push ( $jsArray, $imagen->nombre_completo );
		}
		
		$usuario = $this->general->get_username ( $id_user );
		$org = $this->general->get_organizacion_id($id_user);
		$sedes = $this->modelo_sede->consultar ($org[0]->sede);
		// $oferta = $this->model_categorias->listar_tipo(1);
		// $facultad = $this->model_categorias->listar_tipo(2);
		//$docentes = $this->general->get_usuarios_rol ( 6 );
		$cursos = $this->modelo_cursos->consultar_ACT ();
		
		$style = $this->modelo_dashboard->get_style ( 1 );
		
		$this->template->set ( "cursos", $cursos );
		$this->template->set ( "galeriaJS", $jsArray );
		$this->template->set ( "galeria", $galeria );
		$this->template->set ( "curso", $curso );
		$this->template->set ( "sedes", $sedes );
		// $this->template->set("oferta",$oferta);
		// $this->template->set("facultad",$facultad);
		//$this->template->set ( "docente", $docentes );
		$this->template->set ( "usuario", $usuario );
		$this->template->set ( "style", $style );
		
		$this->template->build ( 'website/sede/evento/editar' );
	}
	function listar() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		
		#if (! $this->general->isAValidUser ( $id, "logistica" )) {
		#	redirect ( '/auth/logout' );
		#}
		
		$style = $this->modelo_dashboard->get_style ( 1 );
		
		$org = $this->general->get_organizacion_id($id);
		$cursos = $this->modelo_evento->listarSede($org[0]->sede);
		$sedes = $this->modelo_sede->consultar($org[0]->sede);
		
		foreach ($cursos as $curso){
		 	$this->galeria_load($curso->id);
		}
		
		foreach ($sedes as $sede){
			 $this->actualizarWeb($sede);
		}
		
		$this->template->set ( "usuario", $usuario );
		$this->template->set ( "style", $style );
		$this->template->set ( "cursos", $cursos );
		$this->template->set ( "type", $usuario [0]->id_tipo_usuario );
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/sede/header' );
		$this->template->set_partial ( 'footer', 'website/sede/footer' );
		$this->template->build ( 'website/sede/evento/listar' );
	}
	function crear() {
		$curso = array (
				'nombre' => $_POST ['nombre'],
				'descripcion' => $_POST ['descripcion'],
				'inicio' => $_POST ['inicio'],
				'fin' => $_POST ['fin'],
				'FK_sede' => $_POST ['sede'],
				'FK_curso' => $_POST ['curso'],
				// 'FK_oferta' => $_POST['oferta'],
				// 'FK_facultad' => $_POST['facultad'],
				// 'FK_docente' => $_POST['docente'],
				'FK_costo' => $_POST ['costo'],
				'entradas' => $_POST ['entradas'],
				'precio' => floatval ( $_POST ['precio'] ),
				'reserva' => floatval ( $_POST ['reserva'] ),
				'observaciones' => $_POST ['observaciones'],
				'hora0' => $_POST ['hora0'].":".$_POST ['min0'].":00",
				'hora1' => $_POST ['hora1'].":".$_POST ['min1'].":00",
				'estatus' => 'ACT' 
		)
		;
		
		$id = $this->modelo_evento->crear ( $curso );
		echo ($id) ? "El Evento ha sido creado satisfactoriamente" : "El Evento no pudo crearse. Por favor, verifique los datos e intente de nuevo";
		
		for($i = 1; $i <= $_POST ['imgCount']; $i ++) {
			$imgName = "img" . $i;
			$this->galeria_subir ( $id, $imgName );
		}
		// redirect('/bo/sedes/listar');
	}
	function eliminar() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $_POST ['id'];
		
		$this->modelo_evento->eliminar ( $id );
		echo 'El Evento ha sido eliminado corectamente';
	}
	
	function cambiar_estado(){
		if (!$this->tank_auth->is_logged_in()){																		// logged in
			redirect('/auth');
		}
	
		$id = $_POST['id'];
		$estado = $_POST['estado'];
	
		$this->modelo_evento->cambiar_estado($id,$estado);
	
	}
	
	function eliminarImagen() {
		$id = $_POST ['id'];
		$img = $_POST ['img'];
		
		$link = getcwd () . "/media/cursos/" . $id . "/" . $img;
		unlink ( $link );
		
		echo "OK";
	}
	function actualizar() {
		$id = $_POST ['id'];
		
		$curso = array (
				'nombre' => $_POST ['nombre'],
				'descripcion' => $_POST ['descripcion'],
				'inicio' => $_POST ['inicio'],
				'fin' => $_POST ['fin'],
				'FK_sede' => $_POST ['sede'],
				'FK_curso' => $_POST ['curso'],
				// 'FK_oferta' => $_POST['oferta'],
				// 'FK_facultad' => $_POST['facultad'],
				// 'FK_docente' => $_POST['docente'],
				'FK_costo' => $_POST ['costo'],
				'entradas' => $_POST ['entradas'],
				'precio' => floatval ( $_POST ['precio'] ),
				'reserva' => intval ( $_POST ['reserva'] ),
				'hora0' => $_POST ['hora0'].":".$_POST ['min0'].":00",
				'hora1' => $_POST ['hora1'].":".$_POST ['min1'].":00",
				'observaciones' => $_POST ['observaciones'],
				#'estatus' => 'ACT' 
		)
		;
		
		$retorno = $this->modelo_evento->actualizar ( $curso, $id );
		echo ($retorno) ? "El Evento ha sido Actualizado satisfactoriamente" : "El Evento no pudo crearse. Por favor, verifique los datos e intente de nuevo";
		
		for($i = 1; $i <= $_POST ['imgCount']; $i ++) {
			$imgName = "img" . $i;
			if ($_FILES [$imgName] ["name"]) {
				// echo $i;
				$this->galeria_subir ( $id, $imgName );
			}
		}
		// redirect('/bo/sedes/listar');
	}
	function galeria_load($id) {
		$this->modelo_cursos->limpiarGaleria ( $id );
		
		$contenido = scandir ( getcwd () . "/media/cursos/" . $id );
		if (sizeof ( $contenido ) > 2) {
			for($i = 2; $i < sizeof ( $contenido ); $i ++) {
				$cadena = explode ( ".", $contenido [$i] );
				
				$this->modelo_cursos->img ( $id, $cadena );
			}
		}
		
		// return $this->modelo_cursos->consultarGaleria ( $id );
	}
	function actualizarWeb($sede) {
		$host = $sede->dbhost;
		$user = $sede->dbuser;
		$pass = $sede->dbkey;
		$db = $sede->dbuser;
		
		// echo $host."<hr/>".$user."<hr/>".$pass."<hr/>".$db."<hr/>";
		
		if (! $host || ! $user || ! $pass || ! $db) {
			return false;
		}
		
		$datos = $this->modelo_evento->consulta_sede ( $sede->id );
		
		$data = $this->setWebCursos ( $datos );
		
		$this->executeWeb ( $host, $user, $pass, $db, $data );
	}
	private function setWebCursos($datos) {
		/*$content = '[gallery columns="4" filter="yes"]';
		// $css = ' <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">';
		$js = '	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  				<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
				<script>';*/
		$i = 0;
		$hoy = '';
		$proximo = '';
		
		$page = "http://" . $_SERVER ['HTTP_HOST'] . "/";
		
		foreach ( $datos as $dato ) {
			$ruta = "/media/cursos/" . $dato->id . "/";
			$image = $this->modelo_evento->consultarGaleria ( $dato->id );
			$image = $image ? $page . $ruta . $image [0]->nombre_completo : $page . "logo.jpg";
			$content .= '[gallery_item tag="' . $dato->oferta . '" src="' . $image . '" /]';
			// echo $image;
			$tabla = $this->setDataCurso ( $dato, $i, $image );
			($dato->tiempo=='hoy') ?  $hoy.= $tabla : $proximo.=$tabla;
			/*$js .= '$("#modal-' . $i . '").ready(
					function(){
						' . $tabla . '	
					});';*/
			$i ++;
		}
		
		/*$content .= '[/gallery]';
		$js .= '</script>';*/
		
		$content = '[row]
						[col class="span12"]
							[tab id="tab1" class="tabbale" button="nav-tabs"]
								[tab_item title="Hoy"]
										[accordion id="sc-accordion"] 
											'.$hoy.'
										[/accordion]
								[/tab_item]
								[tab_item title="Proximamente"]
										[accordion id="sc-accordion2"] 
											'.$proximo.'
										[/accordion]
								[/tab_item]
							[/tab]
						[/col]
					[/row]';
		$js = '';
		return $content . $js;
	}
	private function setDataCurso($dato, $i, $image) {
		setlocale(LC_TIME,"es_ES.UTF-8");
		$inicio = utf8_decode(strftime("%A, %d de %B de %Y", strtotime($dato->inicio)));
		$fin = utf8_decode(strftime("%A, %d de %B de %Y", strtotime($dato->fin)));
		$hora0 = date("g:i a",strtotime(substr($dato->hora0, 0,8)));
		$hora1 = date("g:i a",strtotime(substr($dato->hora1, 0,8)));
		$tabla = '
													[accordion_item title="'.utf8_decode($dato->nombre).'"]
														<div clas="row">
															<div class="span2">
																<img src="'.$image.'" alt="logo" title="logo" width="100%"/>
															</div>
															<div class="span7">
																<h1>'.utf8_decode($dato->nombre).'</h1><em>'.utf8_decode($dato->curso).'</em>
																<h2>Inicio:  '.ucfirst($inicio).'<br/>Finalizaci&oacute;n: '.ucfirst($fin).' </h2>
																<h2>Horario:  Desde las '.$hora0.' hasta las '.$hora1.' </h2>
																<hr/>
																<div class="span12">
																	<blockquote><h4><strong>Descripci&oacute;n del Evento:</strong>  <br/><br/>'.utf8_decode($dato->descripcion).'</h4></blockquote>
																</div>
																<hr class="span12"/>
																<div class="span12">																
																	<blockquote><h2>Tema : '.utf8_decode($dato->facultad).'<br/>Tipo : '.$dato->oferta.'</h2></blockquote>
																</div>															
																				
															</div>
															<div class="span2 pull-right">
																<a href="#" class="btn btn-primary">Comprar</a>	
															</div>
														</div>
													[/accordion_item] 
												';
		
		// $tabla = "<div class=\'span10\'><ul class=\'plan\'><li class=\'plan-name\'>Nombre del Curso :</li><li class=\'plan-details\'><ul><li>".$dato->nombre."</li></ul></li></ul></div></div></div>";
		
		return $tabla;
	}
	private function executeWeb($host, $user, $pass, $db, $data) {
		$phpEXE = "sh";
		$phpFILE = getcwd () . "/curso.sh";
		$params = " '" . $host . "' '" . $user . "' '" . $pass . "' '" . $db . "' '" . $data . "'";
		$comando = $phpEXE . " " . $phpFILE . $params;
		$salida = shell_exec ( $comando );
		
		return "<hr/>$salida<hr/>";
		
		// exit();
	}
	private function executeWebPHP($host, $user, $pass, $db, $data) {
		$phpEXE = "php5";
		$phpFILE = getcwd () . "/curso.php";
		$params = " '" . $host . "' '" . $user . "' '" . $pass . "' '" . $db . "' '" . $data . "'";
		$comando = $phpEXE . " " . $phpFILE . $params;
		$salida = shell_exec ( $comando );
		
		return "<hr/>$salida<hr/>";
		
		// exit();
	}
	function galeria_subir($id, $fileID) {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		// Checamos si el directorio existe, si no, se crea
		if (! is_dir ( getcwd () . "/media/cursos/" . $id )) {
			mkdir ( getcwd () . "/media/cursos/" . $id, 0777 );
		}
		
		$nombre = $id . "_" . $fileID;
		// echo $nombre;
		
		$ruta = "/media/cursos/" . $id . "/";
		// definimos la ruta para subir la imagen
		$config ['upload_path'] = getcwd () . $ruta;
		$config ['allowed_types'] = 'gif|jpg|png|jpeg';
		// $config['file_name'] = $nombre;
		$config ['max_width'] = '4096';
		$config ['max_height'] = '3112';
		
		// Cargamos la libreria con las configuraciones de arriba
		$this->load->library ( 'upload', $config );
		
		// Preguntamos si se pudo subir el archivo "foto" es el nombre del input del dropzone
		if (! $this->upload->do_upload ( $fileID )) {
			echo $this->upload->display_errors ();
		} else {
			$data = array (
					'upload_data' => $this->upload->data () 
			);
		}
	}
	function tipos_de_red_genealogico() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		
		if (! $this->general->isAValidUser ( $id, "comercial" )) {
			redirect ( '/auth/logout' );
		}
		
		$usuario = $this->general->get_username ( $id );
		
		$style = $this->general->get_style ( 1 );
		
		$redes = $this->model_tipo_red->listarActivos ();
		
		$id_afiliado = $_GET ['id_afiliado'];
		
		$this->template->set ( "id", $id );
		$this->template->set ( "style", $style );
		$this->template->set ( "redes", $redes );
		$this->template->set ( "id_afiliado", $id_afiliado );
		
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/comercial/red/redes_ver_genealogico' );
	}
	function tipos_de_red_grafico_1() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		
		if (! $this->general->isAValidUser ( $id, "comercial" )) {
			redirect ( '/auth/logout' );
		}
		
		$usuario = $this->general->get_username ( $id );
		
		$style = $this->general->get_style ( 1 );
		
		$redes = $this->model_tipo_red->listarActivos ();
		
		$id_afiliado = $_GET ['id_afiliado'];
		
		$this->template->set ( "id", $id );
		$this->template->set ( "style", $style );
		$this->template->set ( "redes", $redes );
		$this->template->set ( "id_afiliado", $id_afiliado );
		
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/comercial/red/redes_ver_grafico_1' );
	}
	function tipos_de_red_grafico_2() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		
		if (! $this->general->isAValidUser ( $id, "comercial" )) {
			redirect ( '/auth/logout' );
		}
		
		$usuario = $this->general->get_username ( $id );
		
		$style = $this->general->get_style ( 1 );
		
		$redes = $this->model_tipo_red->listarActivos ();
		
		$id_afiliado = $_GET ['id_afiliado'];
		
		$this->template->set ( "id", $id );
		$this->template->set ( "style", $style );
		$this->template->set ( "redes", $redes );
		$this->template->set ( "id_afiliado", $id_afiliado );
		
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/comercial/red/redes_ver_grafico_2' );
	}
	function red() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		
		if (! $this->general->isAValidUser ( $id, "comercial" )) {
			redirect ( '/auth/logout' );
		}
		
		$usuario = $this->general->get_username ( $id );
		
		$style = $this->modelo_dashboard->get_style ( 1 );
		
		$this->template->set ( "usuario", $usuario );
		$this->template->set ( "style", $style );
		
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/comercial/red/index' );
	}
	function mi_red() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$frontales = $this->model_tipo_red->ObtenerFrontales ();
		$frontales = $frontales [0]->frontal;
		$id = $this->tank_auth->get_user_id ();
		$style = $this->general->get_style ( $id );
		$id_red = $_GET ['id_red'];
		$afiliados = $this->model_perfil->get_afiliados_ ( $id_red, $id );
		$afiliadostree = $this->model_perfil->get_afiliados ( $id_red, $id );
		
		$image = $this->model_perfil->get_images ( $id );
		$user = "/template/img/empresario.jpg";
		foreach ( $image as $img ) {
			$cadena = explode ( ".", $img->img );
			if ($cadena [0] == "user") {
				$user = $img->url;
			}
		}
		
		$this->template->set ( "user", $user );
		$this->template->set ( "style", $style );
		$this->template->set ( "id", $id );
		$this->template->set ( "frontales", $frontales );
		$this->template->set ( "afiliados", $afiliados );
		$this->template->set ( "afiliadostree", $afiliadostree );
		$this->template->set ( "img_perfil", $user );
		
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/comercial/red/tabla' );
	}
	function reportes() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		
		if ($usuario [0]->id_tipo_usuario != 1) {
			redirect ( '/auth/logout' );
		}
		
		$style = $this->modelo_dashboard->get_style ( $id );
		
		$this->template->set ( "usuario", $usuario );
		$this->template->set ( "style", $style );
		
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/comercial/reportes/index' );
	}
	function oficina_virtual() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		
		if ($usuario [0]->id_tipo_usuario != 1) {
			redirect ( '/auth/logout' );
		}
		
		$style = $this->modelo_dashboard->get_style ( $id );
		
		$this->template->set ( "usuario", $usuario );
		$this->template->set ( "style", $style );
		
		$archivos = $this->modelo_comercial->get_files ();
		$info = $this->modelo_comercial->get_info ();
		$presentaciones = $this->modelo_comercial->get_presentaciones ();
		$ebooks = $this->modelo_comercial->get_ebooks ();
		$videos = $this->modelo_comercial->get_video ();
		$eventos = $this->modelo_comercial->get_evento ();
		$noticias = $this->modelo_comercial->get_new ();
		$cupones = $this->modelo_comercial->get_cupon ();
		
		$data = array ();
		$data ['cupones'] = $cupones;
		$data ["noticias"] = $noticias;
		$data ["eventos"] = $eventos;
		$data ['videos'] = $videos;
		$grupos = $this->modelo_comercial->get_groups ();
		$data ['grupos'] = $grupos;
		$comentarios = $this->modelo_comercial->get_comments ();
		$data ['comentarios'] = $comentarios;
		$data ['ebooks'] = $ebooks;
		$data ["files"] = $archivos;
		$data ['infos'] = $info;
		$data ["presentaciones"] = $presentaciones;
		$encuestas = $this->modelo_comercial->get_encuestas ();
		$data ['encuestas'] = $encuestas;
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/comercial/oficina_virtual', $data );
	}
	function ver_noticia() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		
		if ($usuario [0]->id_tipo_usuario != 1) {
			redirect ( '/auth/logout' );
		}
		
		$style = $this->modelo_dashboard->get_style ( $id );
		
		$this->template->set ( "usuario", $usuario );
		$this->template->set ( "style", $style );
		$data = array ();
		if (isset ( $_GET ["idnw"] )) {
			$data ["noticia"] = $this->modelo_comercial->noticia_espec ( $_GET ["idnw"] );
			$index = 1;
			$parrafos = array ();
			$i = 0;
			$texto = nl2br ( $data ["noticia"] [0]->contenido );
			while ( $index > 0 ) {
				
				$index = strpos ( $texto, "<br />" );
				$parrafos [$i] = substr ( $texto, 0, $index );
				$texto = substr ( $texto, $index + 6 );
				$i ++;
			}
			$data ["parrafos"] = $parrafos;
		}
		
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/comercial/ver_noticia', $data );
	}
	function crear_encuesta() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		
		if ($usuario [0]->id_tipo_usuario != 1) {
			redirect ( '/auth/logout' );
		}
		
		$style = $this->modelo_dashboard->get_style ( $id );
		
		$this->template->set ( "usuario", $usuario );
		$this->template->set ( "style", $style );
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/comercial/crear_encuesta' );
	}
	/*
	 * function red()
	 * {
	 * if (!$this->tank_auth->is_logged_in())
	 * { // logged in
	 * redirect('/auth');
	 * }
	 * $id = $this->tank_auth->get_user_id();
	 * $style = $this->modelo_dashboard->get_style($id);
	 * $red = $this->modelo_comercial->get_red($id);
	 * $id_red = $red[0]->id_red;
	 * $afiliados = $this->modelo_comercial->get_afiliados_($id_red);
	 * $users = $this->modelo_comercial->get_dato_usuario();
	 * $perfiles = $this->modelo_comercial->get_perfiles();
	 * $permisos = $this->modelo_comercial->get_permisos();
	 * $grupos = $this->modelo_comercial->get_cat_grupo_perfil();
	 * $preregistro = $this->modelo_comercial->get_preregistro();
	 *
	 *
	 * $image=$this->modelo_comercial->get_images($id);
	 * $user="/template/img/empresario.jpg";
	 * foreach ($image as $img) {
	 * $cadena=explode(".", $img->img);
	 * if($cadena[0]=="user")
	 * {
	 * $user=$img->url;
	 * }
	 * }
	 *
	 * $this->template->set("user",$user);
	 * $this->template->set("style",$style);
	 * $this->template->set("id",$id);
	 * $this->template->set("afiliados",$afiliados);
	 * $this->template->set("users",$users);
	 * $this->template->set("img_perfil",$user);
	 * $this->template->set("perfiles",$perfiles);
	 * $this->template->set("permisos",$permisos);
	 * $this->template->set("grupos",$grupos);
	 * $this->template->set("preregistro",$preregistro);
	 *
	 * $this->template->set_theme('desktop');
	 * $this->template->set_layout('website/main');
	 * $this->template->set_partial('header', 'website/bo/header');
	 * $this->template->set_partial('footer', 'website/bo/footer');
	 * $this->template->build('website/bo/comercial/red');
	 * }
	 */
	/*
	 * function get_detalle_usuario()
	 * {
	 * $detalle=$this->modelo_comercial->get_detalle_usuario();
	 * $img= ($detalle[0]->url) ? $detalle[0]->url : '/template/img/empresario.jpg';
	 * echo '<div class="row"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
	 * echo '<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><img src="'.$img.'" alt="<?=$user->username?>" style="max-height: 100%; max-width: 100%;"></div>
	 * <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><div class="row" style="border-bottom: 1px solid #CCC; padding: 3px"><div class="col-xs-6">Id: </div><strong>'.$detalle[0]->id.'</strong></div>';
	 * echo '<div class="row" style="border-bottom: 1px solid #CCC; padding: 3px"><div class="col-xs-6">Usuario:</div><strong>'.$detalle[0]->username.'</strong></div>';
	 * echo '<div class="row" style="border-bottom: 1px solid #CCC; padding: 3px"><div class="col-xs-6">Correo:</div><strong>'.$detalle[0]->email.'</strong></div>';
	 * echo '<div class="row" style="border-bottom: 1px solid #CCC; padding: 3px"><div class="col-xs-6">Estado:</div><strong>'.$detalle[0]->estatus_afiliado.'</strong></div>';
	 * echo '<div class="row" style="border-bottom: 1px solid #CCC; padding: 3px"><div class="col-xs-6">Estado civil:</div><strong>'.$detalle[0]->estado_civil.'</strong></div>';
	 * echo '<div class="row" style="border-bottom: 1px solid #CCC; padding: 3px"><div class="col-xs-6">Tipo:</div><strong>'.$detalle[0]->tipo_usuario.'</strong></div>';
	 * echo '<div class="row" style="border-bottom: 1px solid #CCC; padding: 3px"><div class="col-xs-6">Estudios:</div><strong>'.$detalle[0]->estudio.'</strong></div>';
	 * echo '<div class="row" style="border-bottom: 1px solid #CCC; padding: 3px"><div class="col-xs-6">Ocupacion:</div><strong>'.$detalle[0]->ocupacion.'</strong></div>';
	 * echo '<div class="row" style="border-bottom: 1px solid #CCC; padding: 3px"><div class="col-xs-6">Tiempo dedicado:</div><strong>'.$detalle[0]->tiempo_dedicado.'</strong></div>';
	 * echo '<div class="row" style="border-bottom: 1px solid #CCC; padding: 3px"><div class="col-xs-6">Co-aplicante:</div><strong>'.$detalle[0]->nombre_co.' '.$detalle[0]->apellido_co.'</strong></div>';
	 * echo '<div class="row" style="border-bottom: 1px solid #CCC; padding: 3px"><div class="col-xs-6">Nombre:</div><strong>'.$detalle[0]->nombre.'</strong></div>';
	 * echo '<div class="row" style="border-bottom: 1px solid #CCC; padding: 3px"><div class="col-xs-6">Apellido:</div><strong>'.$detalle[0]->apellido.'</strong></div>';
	 * echo '<div class="row" style="border-bottom: 1px solid #CCC; padding: 3px"><div class="col-xs-6">Nacimiento:</div><strong>'.$detalle[0]->fecha_nacimiento.'</strong></div>';
	 * echo '<div class="row" style="border-bottom: 1px solid #CCC; padding: 3px"><div class="col-xs-6">Edad:</div><strong>'.$detalle[0]->edad.'</strong></div>';
	 * echo '<div class="row" style="border-bottom: 1px solid #CCC; padding: 3px"><div class="col-xs-6">Última sesión:</div><strong>'.$detalle[0]->ultima_sesion.'</strong></div>';
	 * echo '</div></div>';
	 * }
	 */
	function get_detalle_usuario() {
		$detalle = $this->modelo_comercial->get_detalle_usuario ( $_POST ['id'] );
		$pais = $this->model_admin->get_pais ();
		
		$this->template->set ( "detalle", $detalle );
		$this->template->set ( "pais", $pais );
		
		$this->template->set_theme ( 'desktop' );
		$this->template->build ( 'website/bo/comercial/red/detalleUsuario' );
	}
	function get_formulario_usuario() {
		$id_afiliado = $_POST ['id'];
		$tiposDeUsuario = $this->model_cat_tipo_usuario->listarTodos ();
		$tiposDeSexo = $this->model_cat_sexo->listarTodos ();
		$tiposDeEstadoCivil = $this->model_cat_edo_civil->listarTodos ();
		$tiposDeEstudio = $this->model_cat_estudios->listarTodos ();
		$tiposDeOcupacion = $this->model_cat_ocupacion->listarTodos ();
		$tiposDeTiempoDedicacion = $this->model_cat_tiempo_dedicado->listarTodos ();
		$tiposDeEstadosAfiliado = $this->model_cat_estatus_afiliado->listarTodos ();
		$tiposDeEstadoFiscal = $this->model_cat_usuario_fiscal->listarTodos ();
		
		$this->template->set ( "id_afiliado", $id_afiliado );
		$this->template->set ( "tiposDeUsuario", $tiposDeUsuario );
		$this->template->set ( "tiposDeSexo", $tiposDeSexo );
		$this->template->set ( "tiposDeEstadoCivil", $tiposDeEstadoCivil );
		$this->template->set ( "tiposDeEstudio", $tiposDeEstudio );
		$this->template->set ( "tiposDeOcupacion", $tiposDeOcupacion );
		$this->template->set ( "tiposDeTiempoDedicacion", $tiposDeTiempoDedicacion );
		$this->template->set ( "tiposDeEstadosAfiliado", $tiposDeEstadosAfiliado );
		$this->template->set ( "tiposDeEstadoFiscal", $tiposDeEstadoFiscal );
		$this->template->set_theme ( 'desktop' );
		$this->template->build ( 'website/bo/comercial/red/formularioUsuario' );
	}
	function actualizar_afiliado() {
		// $emails = $this->model_perfil->use_mail_modificar();
		$this->model_users->actualizar ( $_POST ['id'], $_POST ['username'], $_POST ['mail'] );
		$this->model_user_profiles->actualizar_nombres ( $_POST ['id'], $_POST ['nombre'], $_POST ['apellido'] );
		$this->model_user_profiles->actualizar_pais ( $_POST ['id'], $_POST ['pais'] );
		(strlen ( $_POST ['password'] ) > 0) ? $this->tank_auth->change_pass_easy ( $_POST ['id'], $_POST ['password'] ) : '';
		
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		
		echo "El afiliado ha sido actualizado satisfactoriamente.";
		// $success = "El afiliado ha sido actualizado satisfactoriamente.";
		// $this->session->set_flashdata('success', $success);
		// redirect('/bo/comercial/red_tabla');
	}
	
	/*
	 * function sustituir_afiliado()
	 * {
	 * $emails = $this->model_perfil->use_mail();
	 * $usernames = $this->model_perfil->use_username();
	 *
	 * var_dump($emails);exit();
	 *
	 * if ($emails){
	 * $error = "Lo sentimos, el email que estas ingresando ya existe.";
	 * $this->session->set_flashdata('error', $error);
	 * redirect('/bo/comercial/red_tabla');
	 * }
	 *
	 * if ($usernames){
	 * $error = "Lo sentimos, el username que estas ingresando ya existe.";
	 * $this->session->set_flashdata('error', $error);
	 * redirect('/bo/comercial/red_tabla');
	 * }
	 * if(!isset($_POST['nacimiento'])){
	 * $error = "Olvidaste escribir la fecha de nacimiento.";
	 * $this->session->set_flashdata('error', $error);
	 * redirect('/bo/comercial/red_tabla');
	 * }
	 * else{
	 * $this->model_users->actualizar($_POST['id'], $_POST['username'], $_POST['email']);
	 *
	 * $this->model_user_profiles->actualizar($_POST['id'], $_POST['sexo'], $_POST['estadoCivil'], $_POST['tipoUsuario'], $_POST['estudio'], $_POST['ocupacion'], $_POST['tiempoDedicado'],
	 * $_POST['estadoAfiliado'], $_POST['nombre'], $_POST['apellido'], $_POST['nacimiento']);
	 * $this->model_coaplicante->actualizar($_POST['id'], $_POST['nombreCo'], $_POST['apellidoCo']);
	 *
	 * $this->template->set_theme('desktop');
	 * $this->template->set_layout('website/main');
	 * $this->template->set_partial('header', 'website/bo/header');
	 * $this->template->set_partial('footer', 'website/bo/footer');
	 * redirect('/bo/comercial/red_tabla');
	 * }
	 * }
	 * /*function sustituir_afiliado()
	 * {
	 * $this->model_users->actualizar($_POST['id'], $_POST['username'], $_POST['email']);
	 *
	 * $this->model_user_profiles->actualizar($_POST['id'], $_POST['sexo'], $_POST['estadoCivil'], $_POST['tipoUsuario'], $_POST['estudio'], $_POST['ocupacion'], $_POST['tiempoDedicado'],
	 * $_POST['estadoAfiliado'], $_POST['nombre'], $_POST['apellido'], $_POST['nacimiento']);
	 * $this->model_coaplicante->actualizar($_POST['id'], $_POST['nombreCo'], $_POST['apellidoCo']);
	 *
	 * $this->template->set_theme('desktop');
	 * $this->template->set_layout('website/main');
	 * $this->template->set_partial('header', 'website/bo/header');
	 * $this->template->set_partial('footer', 'website/bo/footer');
	 * redirect('/bo/comercial/red_tabla');
	 * }
	 */
	function cambiar_estado_afiliado() {
		$this->model_user_profiles->cambiar_estado ( $_POST ['id'], $_POST ['estatus'] );
		/*
		 * if ($_POST['estatus']==1) echo "Se ha desbloqueado el perfil con exito";
		 * else echo "Se ha bloqueado el perfil con exito";
		 * $error = "El afiliado ha cambiado de estado.";
		 * $this->session->set_flashdata('error', $error);
		 * //redirect('/bo/comercial/red_tabla?id_red='.$id_red.'');
		 * //$this->red_tabla();
		 */
	}
	function detalle_red() {
		$misdatos = $this->modelo_comercial->datos_perfil ( $_POST ['id'] );
		$sponsor = $this->modelo_comercial->get_sponsor ();
		$id_user = $this->modelo_comercial->get_id_by_red ( $sponsor [0]->id_red );
		$afiliados = $this->modelo_comercial->get_afiliados ( $sponsor [0]->id_red );
		$detalle_sponsor = $this->modelo_comercial->datos_perfil ( $id_user );
		
		echo '
		<div class="smart-form row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<fieldset>
					<legend>Datos del sponsor</legend>
					<div>Id: ' . $id_user . '</div>
					<div>Nombre: ' . $detalle_sponsor [0]->nombre . " " . $detalle_sponsor [0]->apellido . '</div>
					<div>Correo: ' . $detalle_sponsor [0]->email . '</div>
				</fieldset>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<fieldset>
					<legend>Datos de los afiliados</legend>';
		$ids = array ();
		foreach ( $afiliados as $key ) {
			$ids [$key->id_afiliado] = $key->lado;
			echo '<div>Id: ' . $key->id_afiliado . '</div>';
			echo '<div>Nombre: ' . $key->afiliado . " " . $key->afiliado_p . '</div>';
			echo '<div>Posicion: ';
			echo ($key->lado == 0) ? 'Izquierda' : 'Derecha';
			echo '</div><hr />';
		}
		echo '</fieldset>
			</div>';
		
		echo '
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<fieldset id="edita_posicion">
				<legend>Editar</legend>
				<div>Id: ' . $_POST ['id'] . '</div>
				<div>Nombre: ' . $misdatos [0]->nombre . " " . $misdatos [0]->apellido . '</div>
				<div>Correo: ' . $misdatos [0]->email . '</div>
				<div>Posicion actual: ';
		echo ($sponsor [0]->lado == 0) ? 'Izquierda' : 'Derecha';
		echo '<input name="mi_id" type="hidden" value="' . $_POST ['id'] . '">';
		foreach ( $ids as $key )
			echo '<input name="posiciones[]" type="hidden" value="' . $key . '">';
		foreach ( array_keys ( $ids ) as $key )
			echo '<input name="ids[]" type="hidden" value="' . $key . '">';
		echo '</div>
				<br /><hr />
				<section class="col col-6">Selecciona la posicion para el usuario
					<label class="select">
						<select name="posicion">
							<option value="0">Izquierda</option>
							<option value="1">Derecha</option>
						</select>
					</label>
				</section>
			</fieldset></div>
		</div>';
	}
	function cambia_posicion() {
		$this->modelo_comercial->cambia_posicion ();
		if (sizeof ( $_POST ['ids'] ) > 1)
			echo "Se han cambiado de posicion dos afiliados";
		else
			echo "Se ha cambiado de posicion al afiliado";
	}
	function perfil_permiso() {
		$perfiles = $this->modelo_comercial->get_perfiles ();
		$perfil = $this->modelo_comercial->get_perfil_usuario ();
		$grupo = $this->modelo_comercial->get_grupo_perfil ( $perfil [0]->id_perfil );
		
		echo '<div class="row"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
		echo '
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="row" style="border-bottom: 1px solid #CCC; padding: 3px">
					<div class="col-xs-4">Grupo del perfil: </div><strong>' . $grupo [0]->grupo . '</strong>
				</div>
				<div class="row" style="border-bottom: 1px solid #CCC; padding: 3px">
					<div class="col-xs-4">Perfil actual: </div><strong>' . $perfil [0]->perfil . '</strong>
				</div>
				<div class="row" style="border-bottom: 1px solid #CCC; padding: 3px">
					<div class="col-xs-4">Detalles del perfil: </div><strong><span class="txt-color-blue" style="cursor: pointer;" onclick="get_permisos(' . $perfil [0]->id_perfil . ')">Mostrar permisos</span></strong>
				</div>
				<div class="row" style="border-bottom: 1px solid #CCC; padding: 3px">
					<div class="col-xs-4">Acciones de perfiles: </div><strong><span class="txt-color-blue" style="cursor: pointer;" onclick="new_perfil()">Crear perfil</span></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<strong><span class="txt-color-red" style="cursor: pointer;" onclick="del_perfil()">Borrar perfil</span></strong>
				</div>
			</div>';
		echo '<div class="row"><br /><br /><br /></div>';
		echo '<div class="row"><br /><br /><br /></div>';
		
		echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><div class="row"><div class="col-xs-6">Cambiar el perfil: </div>';
		echo '<form id="perfil_123" action="/bo/comercial/actualiza_perfil" action="POST"><select name="perfil">';
		foreach ( $perfiles as $key ) {
			
			echo ($perfil [0]->id_perfil == $key->id_perfil) ? '<option selected value="' . $key->id_perfil . '">' . $key->descripcion . '</option>' : '<option value="' . $key->id_perfil . '">' . $key->descripcion . '</option>';
		}
		echo '</select>
				<input name="id" type="hidden" value="' . $_POST ['id'] . '"></form>
			</div></div>
		</div>';
	}
	function get_permisos() {
		$permisos = $this->modelo_comercial->get_permiso_perfil ( $_POST ['id'] );
		foreach ( $permisos as $key ) {
			echo '<div class="row" style="border-bottom: 1px solid #CCC; padding: 3px">';
			echo '<div class="col-xs-6">Permiso: </div><strong>' . $key->permiso . '</strong></div>';
		}
	}
	function actualiza_perfil() {
		$this->modelo_comercial->actualiza_perfil ();
		echo "Se ha cambiado el perfil con exito";
	}
	function new_perfil() {
		$this->modelo_comercial->new_perfil ();
		echo "Se ha agregado el perfil con exito";
	}
	function del_perfil() {
		$this->modelo_comercial->del_perfil ();
		echo "Se ha eliminado el perfil con exito";
	}
	function subred() {
		$id_red = $this->modelo_comercial->get_red ( $_POST ['id'] );
		$id_red = $id_red [0]->id_red;
		$afiliados = $this->modelo_comercial->get_afiliados ( $id_red );
		if ($afiliados) {
			$usuario = array ();
			foreach ( $afiliados as $id_afiliado ) {
				$usuario [] = $this->modelo_comercial->datos_perfil ( $id_afiliado->id_afiliado );
			}
			echo "<ul role='group'>";
			foreach ( $usuario as $afiliado ) {
				echo "
				<li class='parent_li' style='display: list-item;' role='treeitem' id='" . $afiliado [0]->user_id . "'>
	            	<span class='quitar'  onclick='subred(" . $afiliado [0]->user_id . ")'><i class='fa fa-lg fa-plus-circle'></i> " . $afiliado [0]->nombre . " " . $afiliado [0]->apellido . "</span>
	            </li>";
			}
			echo "</ul>";
		} else {
			echo "<ul  role='group'>
				<li  class='parent_li' style='display: list-item;' role='treeitem'>
					No tiene afiliados
	            </li>";
			echo "</ul>";
		}
	}
	function subtree() {
		$id_red = $this->modelo_comercial->get_red ( $_POST ['id'] );
		$id_red = $id_red [0]->id_red;
		$afiliados = $this->modelo_comercial->get_afiliados ( $id_red );
		
		if ($afiliados) {
			$usuario = array ();
			foreach ( $afiliados as $id_afiliado ) {
				$usuario [] = $this->modelo_comercial->datos_perfil ( $id_afiliado->id_afiliado );
			}
			echo "<ul>";
			foreach ( $usuario as $afiliado ) {
				$image = $this->modelo_comercial->get_images ( $afiliado [0]->user_id );
				$img_perfil = '/template/img/empresario.jpg';
				foreach ( $image as $img ) {
					$cadena = explode ( ".", $img->img );
					if ($cadena [0] == "user") {
						$img_perfil = $img->url;
					}
				}
				echo "
				<li id='t" . $afiliado [0]->user_id . "'>
	            	<a class='quitar' onclick='subtree(" . $afiliado [0]->user_id . ")' style='background: url(" . $img_perfil . "); background-size: cover; background-position: center;' href='#'><div class='nombre'>" . $afiliado [0]->nombre . " " . $afiliado [0]->apellido . "</div></a>
	            	<div onclick='detalles(" . $afiliado [0]->user_id . ")' class='todo'>Detalles</div>
	            </li>";
			}
			echo "</ul>";
		} else {
			$nombre = $this->modelo_comercial->get_name ( $_POST ['id'] );
			$nombre = '"' . $nombre [0]->nombre . " " . $nombre [0]->apellido . '"';
			echo "<ul>
				<li>
					<a href='#'>No tiene afiliados</a>
	            </li>";
			echo "</ul>";
		}
	}
	function afiliar_nuevo() {
		$id = $this->tank_auth->get_user_id ();
		$this->modelo_comercial->afiliar_nuevo ( $id );
	}
	function afiliar_nuevo_r($id) {
		sleep ( 1 );
		// print_r($_POST);
		$this->modelo_comercial->afiliar_nuevo ( $id );
		if ($_POST ['sponsor']) {
			$id_ = $this->tank_auth->get_user_id ();
			$this->modelo_comercial->actualiza_directo ( $id_, $id );
		}
	}
	function detalle_usuario() {
		$image = $this->modelo_comercial->get_images ( $_POST ['id'] );
		
		$img_perfil = "/template/img/empresario.jpg";
		foreach ( $image as $img ) {
			$cadena = explode ( ".", $img->img );
			if ($cadena [0] == "user") {
				$img_perfil = $img->url;
			}
		}
		
		$usuario = $this->modelo_comercial->datos_perfil ( $_POST ['id'] );
		$edad = $this->modelo_comercial->edad ( $_POST ['id'] );
		echo '<div class="row"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
		echo '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><img alt="' . $usuario [0]->nombre . '" src="' . $img_perfil . '" style="max-width: 100%; max-height: 100%"></div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><div class="row">Id: ' . $_POST ["id"] . '</div>';
		echo '<div class="row">Nombre: ' . $usuario [0]->nombre . '</div>';
		echo '<div class="row">Apellido: ' . $usuario [0]->apellido . '</div>';
		echo '<div class="row">Nacimiento: ' . $usuario [0]->nacimiento . '</div>';
		echo '<div class="row">Edad: ' . $edad [0]->edad . '</div></div>';
		echo '</div></div>';
	}
	function nuevo_grupo() {
		$this->db->query ( 'insert into cat_grupo (descripcion) values ("' . $_GET ["grupo"] . '")' );
	}
	function sube_video() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		
		if ($usuario [0]->id_tipo_usuario != 1) {
			redirect ( '/auth/logout' );
		}
		
		// Checamos si el directorio del usuario existe, si no, se crea
		if (! is_dir ( getcwd () . "/media/" . $id )) {
			mkdir ( getcwd () . "/media/" . $id, 0777 );
		}
		
		$ruta = "/media/" . $id . "/";
		// definimos la ruta para subir la imagen
		$config ['upload_path'] = getcwd () . $ruta;
		$config ['allowed_types'] = 'mp4|jpg|png';
		
		// Cargamos la libreria con las configuraciones de arriba
		$this->load->library ( 'upload', $config );
		
		// Preguntamos si se pudo subir el archivo "foto" es el nombre del input del dropzone
		if (! $this->upload->do_multi_upload ( 'userfile' )) {
			// echo 'Holis';
			// echo $ruta;
			$error = array (
					'error' => $this->upload->display_errors () 
			);
		} else {
			$data = array (
					'upload_data' => $this->upload->get_multi_upload_data () 
			);
			foreach ( $data ["upload_data"] as $key ) {
				$filename = strrev ( $key ["file_name"] );
				$explode = explode ( ".", $filename );
				$nombre = strrev ( $explode [1] );
				$extencion = strrev ( $explode [0] );
				$ext = strtolower ( $extencion );
				if ($ext == "mp4") {
					$this->db->query ( 'insert into archivo (id_usuario,id_grupo,id_tipo,descripcion,ruta,status,nombre_publico) 
					values (' . $id . ',' . $_POST ['grupo_frm'] . ',2,"' . $_POST ['desc_frm'] . '","' . $ruta . $key ["file_name"] . '","ACT","' . $_POST ["nombre_publico"] . '")' );
					$video = $this->db->insert_id ();
				} else {
					$this->db->query ( 'insert into cat_img (url,nombre_completo,nombre,extencion,estatus) 
					values ("' . $ruta . $key ["file_name"] . '","' . $key ["file_name"] . '","' . $nombre . '","' . $extencion . '","ACT")' );
					$imgn = $this->db->insert_id ();
				}
			}
			$this->db->query ( 'insert into cross_img_archivo	values (' . $video . ',' . $imgn . ')' );
		}
		
		redirect ( '/bo/comercial/oficina_virtual' );
	}
	function sube_video_youtube() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		
		if ($usuario [0]->id_tipo_usuario != 1) {
			redirect ( '/auth/logout' );
		}
		
		// Checamos si el directorio del usuario existe, si no, se crea
		if (! is_dir ( getcwd () . "/media/" . $id )) {
			mkdir ( getcwd () . "/media/" . $id, 0777 );
		}
		
		$ruta = "/media/" . $id . "/";
		// definimos la ruta para subir la imagen
		$config ['upload_path'] = getcwd () . $ruta;
		$config ['allowed_types'] = 'jpg|png|gif';
		
		// Cargamos la libreria con las configuraciones de arriba
		$this->load->library ( 'upload', $config );
		// echo 'heey 2';
		// Preguntamos si se pudo subir el archivo "foto" es el nombre del input del dropzone
		if (! $this->upload->do_upload ()) {
			// echo 'Holis valio vergui';
			// echo $ruta;
			$error = array (
					'error' => $this->upload->display_errors () 
			);
			print_r ( $error );
		} else {
			$data = array (
					'upload_data' => $this->upload->data () 
			);
			$filename = strrev ( $data ["upload_data"] ["file_name"] );
			$explode = explode ( ".", $filename );
			$nombre = strrev ( $explode [1] );
			$extencion = strrev ( $explode [0] );
			$ext = strtolower ( $extencion );
			if ($ext == 'jpg' || $ext == "png") {
				// echo 'insert into noticia (id_usuario,nombre,contenido,imagen) values ('.$id.',"'.$_POST['nombre_frm'].'","'.$_POST['desc_frm'].'","'.$ruta.$_POST['file_nme'].'")';
				$this->db->query ( 'insert into cat_img (url,nombre_completo,nombre,extencion,estatus) 
				values ("' . $ruta . $data ["upload_data"] ["file_name"] . '","' . $data ["upload_data"] ["file_name"] . '","' . $nombre . '","' . $extencion . '","ACT")' );
				$imgn = $this->db->insert_id ();
				
				$this->db->query ( 'insert into archivo (id_usuario,id_grupo,id_tipo,descripcion,ruta,status,nombre_publico) 
				values (' . $id . ',' . $_POST ['grupo_frm'] . ',8,"' . $_POST ['desc_frm'] . '","' . $_POST ["url"] . '","ACT","' . $_POST ["nombre_publico"] . '")' );
				$video = $this->db->insert_id ();
				$this->db->query ( 'insert into cross_img_archivo	values (' . $video . ',' . $imgn . ')' );
			}
		}
		redirect ( '/bo/comercial/oficina_virtual' );
	}
	function sube_presentacion() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		
		if ($usuario [0]->id_tipo_usuario != 1) {
			redirect ( '/auth/logout' );
		}
		
		// Checamos si el directorio del usuario existe, si no, se crea
		if (! is_dir ( getcwd () . "/media/" . $id )) {
			mkdir ( getcwd () . "/media/" . $id, 0777 );
		}
		
		$ruta = "/media/" . $id . "/";
		// definimos la ruta para subir la imagen
		$config ['upload_path'] = getcwd () . $ruta;
		$config ['allowed_types'] = 'ppt|pptx';
		
		// Cargamos la libreria con las configuraciones de arriba
		$this->load->library ( 'upload', $config );
		
		// Preguntamos si se pudo subir el archivo "foto" es el nombre del input del dropzone
		if (! $this->upload->do_upload ()) {
			// echo 'Holis';
			// echo $ruta;
			
			$error = array (
					'error' => $this->upload->display_errors () 
			);
		} else {
			$data = array (
					'upload_data' => $this->upload->data () 
			);
			$nombre = $data ['upload_data'] ['file_name'];
			$filename = strrev ( $nombre );
			$explode = explode ( ".", $filename );
			$nombre = strrev ( $explode [1] );
			$extencion = strrev ( $explode [0] );
			$ext = strtolower ( $extencion );
			
			if ($ext == "pptx") {
				$this->db->query ( 'insert into archivo (id_usuario,id_grupo,id_tipo,descripcion,ruta,status,nombre_publico) 
				values (' . $id . ',' . $_POST ['grupo_frm'] . ',4,"' . $_POST ['desc_frm'] . '","' . $ruta . $data ['upload_data'] ['file_name'] . '","ACT","' . $_POST ["nombre_publico"] . '")' );
			} elseif ($ext == "ppt") {
				$this->db->query ( 'insert into archivo (id_usuario,id_grupo,id_tipo,descripcion,ruta,status) 
				values (' . $id . ',' . $_POST ['grupo_frm'] . ',3,"' . $_POST ['desc_frm'] . '","' . $ruta . $data ['upload_data'] ['file_name'] . '","ACT")' );
			}
			// echo 'ptm';
		}
		redirect ( '/bo/comercial/oficina_virtual' );
	}
	function sube_ebook() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		
		if ($usuario [0]->id_tipo_usuario != 1) {
			redirect ( '/auth/logout' );
		}
		
		// Checamos si el directorio del usuario existe, si no, se crea
		if (! is_dir ( getcwd () . "/media/" . $id )) {
			mkdir ( getcwd () . "/media/" . $id, 0777 );
		}
		
		$ruta = "/media/" . $id . "/";
		// definimos la ruta para subir la imagen
		$config ['upload_path'] = getcwd () . $ruta;
		$config ['allowed_types'] = 'pdf|jpg|png';
		
		// Cargamos la libreria con las configuraciones de arriba
		$this->load->library ( 'upload', $config );
		
		// Preguntamos si se pudo subir el archivo "foto" es el nombre del input del dropzone
		if (! $this->upload->do_multi_upload ( 'userfile' )) {
			// echo 'Holis';
			// echo $ruta;
			$error = array (
					'error' => $this->upload->display_errors () 
			);
			print_r ( $error );
		} else {
			$data = array (
					'upload_data' => $this->upload->get_multi_upload_data () 
			);
			foreach ( $data ["upload_data"] as $key ) {
				$filename = strrev ( $key ["file_name"] );
				$explode = explode ( ".", $filename );
				$nombre = strrev ( $explode [1] );
				$extencion = strrev ( $explode [0] );
				$ext = strtolower ( $extencion );
				if ($ext == "pdf") {
					$this->db->query ( 'insert into archivo (id_usuario,id_grupo,id_tipo,descripcion,ruta,status,nombre_publico) 
					values (' . $id . ',' . $_POST ['grupo_frm'] . ',1,"' . $_POST ['desc_frm'] . '","' . $ruta . $key ["file_name"] . '","ACT","' . $_POST ["nombre_publico"] . '")' );
					$ebook = $this->db->insert_id ();
				} else {
					$this->db->query ( 'insert into cat_img (url,nombre_completo,nombre,extencion,estatus) 
					values ("' . $ruta . $key ["file_name"] . '","' . $key ["file_name"] . '","' . $nombre . '","' . $extencion . '","ACT")' );
					$imgn = $this->db->insert_id ();
				}
			}
			$this->db->query ( 'insert into cross_img_archivo	values (' . $ebook . ',' . $imgn . ')' );
		}
		redirect ( '/bo/comercial/oficina_virtual' );
	}
	function sube_noticia() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		
		if ($usuario [0]->id_tipo_usuario != 1) {
			redirect ( '/auth/logout' );
		}
		
		// Checamos si el directorio del usuario existe, si no, se crea
		if (! is_dir ( getcwd () . "/media/" . $id )) {
			mkdir ( getcwd () . "/media/" . $id, 0777 );
		}
		
		$ruta = "/media/" . $id . "/";
		// definimos la ruta para subir la imagen
		$config ['upload_path'] = getcwd () . $ruta;
		$config ['allowed_types'] = 'jpg|png|gif';
		
		// Cargamos la libreria con las configuraciones de arriba
		$this->load->library ( 'upload', $config );
		// echo 'heey 2';
		// Preguntamos si se pudo subir el archivo "foto" es el nombre del input del dropzone
		if (! $this->upload->do_upload ()) {
			// echo 'Holis valio vergui';
			// echo $ruta;
			$error = array (
					'error' => $this->upload->display_errors () 
			);
		} else {
			$data = array (
					'upload_data' => $this->upload->data () 
			);
			$nombre = $data ['upload_data'] ['file_name'];
			$filename = strrev ( $nombre );
			$explode = explode ( ".", $filename );
			$nombre = strrev ( $explode [1] );
			$extencion = strrev ( $explode [0] );
			$ext = strtolower ( $extencion );
			// echo 'se supone que se debo de subir';
			if ($ext == "jpg" || $ext = "png" || $ext = "gif") {
				// echo 'insert into noticia (id_usuario,nombre,contenido,imagen) values ('.$id.',"'.$_POST['nombre_frm'].'","'.$_POST['desc_frm'].'","'.$ruta.$_POST['file_nme'].'")';
				$this->db->query ( 'insert into noticia (id_usuario,nombre,contenido,imagen) 
				values (' . $id . ',"' . $_POST ['nombre_frm'] . '","' . $_POST ['desc_frm'] . '","' . $ruta . $nombre . '")' );
			}
			// echo 'ptm';
		}
		redirect ( '/bo/comercial/oficina_virtual' );
	}
	function sube_info() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		
		if ($usuario [0]->id_tipo_usuario != 1) {
			redirect ( '/auth/logout' );
		}
		
		// Checamos si el directorio del usuario existe, si no, se crea
		if (! is_dir ( getcwd () . "/media/" . $id )) {
			mkdir ( getcwd () . "/media/" . $id, 0777 );
		}
		
		$ruta = "/media/" . $id . "/";
		// definimos la ruta para subir la imagen
		$config ['upload_path'] = getcwd () . $ruta;
		$config ['allowed_types'] = 'jpg|png|gif';
		
		// Cargamos la libreria con las configuraciones de arriba
		$this->load->library ( 'upload', $config );
		// echo 'heey 2';
		// Preguntamos si se pudo subir el archivo "foto" es el nombre del input del dropzone
		if (! $this->upload->do_upload ()) {
			// echo 'Holis valio vergui';
			// echo $ruta;
			$error = array (
					'error' => $this->upload->display_errors () 
			);
		} else {
			$data = array (
					'upload_data' => $this->upload->data () 
			);
			$nombre = $data ['upload_data'] ['file_name'];
			$nombre = $data ['upload_data'] ['file_name'];
			$filename = strrev ( $nombre );
			$explode = explode ( ".", $filename );
			$nombre = strrev ( $explode [1] );
			$extencion = strrev ( $explode [0] );
			$ext = strtolower ( $extencion );
			// echo 'se supone que se debo de subir';
			if ($ext == "jpg" || $ext = "png" || $ext = "gif") {
				// echo 'insert into noticia (id_usuario,nombre,contenido,imagen) values ('.$id.',"'.$_POST['nombre_frm'].'","'.$_POST['desc_frm'].'","'.$ruta.$_POST['file_nme'].'")';
				$this->db->query ( 'insert into informacion (id_usuario,nombre,descripcion,img) 
				values (' . $id . ',"' . $_POST ['nombre_frm'] . '","' . $_POST ['desc_frm'] . '","' . $ruta . $nombre . '")' );
			}
			// echo 'ptm';
		}
		redirect ( '/bo/comercial/oficina_virtual' );
	}
	function nuevo_evento() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		
		if ($usuario [0]->id_tipo_usuario != 1) {
			redirect ( '/auth/logout' );
		}
		
		$data = $_GET ["info"];
		$data = json_decode ( $data, true );
		$tipo = $data ['tipo'];
		$color = $data ['color'];
		$nombre = $data ['nombre'];
		$desc = $data ['descripcion'];
		$dia_ini = $data ['dia_ini'];
		$hora_ini = $data ['hora_ini'];
		$minuto_ini = $data ['minuto_ini'];
		$dia_fin = $data ['dia_fin'];
		$hora_fin = $data ['hora_fin'];
		$minuto_fin = $data ['minuto_fin'];
		$ano_ini = substr ( $dia_ini, 6 );
		$mes_ini = substr ( $dia_ini, 3, 2 );
		$dia_ini = substr ( $dia_ini, 0, 2 );
		$ano_fin = substr ( $dia_fin, 6 );
		$mes_fin = substr ( $dia_fin, 3, 2 );
		$dia_fin = substr ( $dia_fin, 0, 2 );
		$inicio = $ano_ini . '-' . $mes_ini . '-' . $dia_ini . ' ' . $hora_ini . ':' . $minuto_ini . ':00';
		$fin = $ano_fin . '-' . $mes_fin . '-' . $dia_fin . ' ' . $hora_fin . ':' . $minuto_fin . ':00';
		$id = $this->tank_auth->get_user_id ();
		$this->db->query ( 'insert into evento (id_tipo,id_color,id_usuario,nombre,descripcion,inicio,fin,lugar,costo,direccion,latitud,longitud,observaciones) 
						values(' . $tipo . ',' . $color . ',' . $id . ',"' . $nombre . '","' . $desc . '","' . $inicio . '","' . $fin . '","' . $data ["lugar"] . '",' . $data ["costo"] . '
						,"' . $data ["direccion"] . '","0.00000","0.00000","' . $data ["observacion"] . '")' );
		$id_evento = $this->db->insert_id ();
		$descripcion = $desc . '&nbspc;<a class="ver-mas-calendario" href="#" onclick="ver_evento(' . $id_evento . ')">Ver más</a>';
		$this->db->query ( "update evento set descripcion='" . $descripcion . "' where id=" . $id_evento );
	}
	function nuevo_video() {
		$id = $this->tank_auth->get_user_id ();
		$grupo = $_GET ['grupo'];
		$ruta = "/media/" . $id . "/" . $_GET ['video'];
		$archivo = $this->general->get_tipo_archivo ( 'mp4' );
		$this->db->query ( 'insert into archivo (id_usuario,id_grupo,id_tipo,descripcion,ruta) values (' . $id . ',' . $grupo . ',' . $archivo . ',"algo","' . $ruta . '")' );
	}
	function insert_coment() {
		$id_user = $this->tank_auth->get_user_id ();
		$data = $_GET ["info"];
		$data = json_decode ( $data, true );
		$id = $data ['video'];
		$coment = $data ['comentario'];
		$this->db->query ( 'insert into comentario (comentario,id_video,autor) values ("' . $coment . '"," ' . $id . '","' . $id_user . '")' );
	}
	function sube_archivo() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		
		if ($usuario [0]->id_tipo_usuario != 1) {
			redirect ( '/auth/logout' );
		}
		
		// Checamos si el directorio del usuario existe, si no, se crea
		if (! is_dir ( getcwd () . "/media/" . $id )) {
			mkdir ( getcwd () . "/media/" . $id, 0777 );
		}
		
		$ruta = "/media/" . $id . "/";
		// definimos la ruta para subir la imagen
		$config ['upload_path'] = getcwd () . $ruta;
		$config ['allowed_types'] = 'ppt|pptx|pdf|jpg|png|mp4';
		
		// Cargamos la libreria con las configuraciones de arriba
		$this->load->library ( 'upload', $config );
		
		// Preguntamos si se pudo subir el archivo "foto" es el nombre del input del dropzone
		if (! $this->upload->do_upload ()) {
			// echo 'Holis';
			// echo $ruta;
			$error = array (
					'error' => $this->upload->display_errors () 
			);
		} else {
			$data = array (
					'upload_data' => $this->upload->data () 
			);
			if (stristr ( $_POST ['file_nme'], 'pptx' )) {
				$this->db->query ( 'insert into archivo (id_usuario,id_grupo,id_tipo,descripcion,ruta,status,nombre_publico) 
				values (' . $id . ',' . $_POST ['grupo_frm'] . ',4,"' . $_POST ['desc_frm'] . '","' . $ruta . $data ['upload_data'] ['file_name'] . '","ACT","' . $_POST ["nombre_publico"] . '")' );
			}
			if (stristr ( $_POST ['file_nme'], 'ppt' )) {
				$this->db->query ( 'insert into archivo (id_usuario,id_grupo,id_tipo,descripcion,ruta,status,nombre_publico) 
				values (' . $id . ',' . $_POST ['grupo_frm'] . ',3,"' . $_POST ['desc_frm'] . '","' . $ruta . $data ['upload_data'] ['file_name'] . '","ACT","' . $_POST ["nombre_publico"] . '")' );
			}
			if (stristr ( $_POST ['file_nme'], 'pdf' )) {
				$this->db->query ( 'insert into archivo (id_usuario,id_grupo,id_tipo,descripcion,ruta,status,nombre_publico) 
				values (' . $id . ',' . $_POST ['grupo_frm'] . ',1,"' . $_POST ['desc_frm'] . '","' . $ruta . $data ['upload_data'] ['file_name'] . '","ACT","' . $_POST ["nombre_publico"] . '")' );
			}
			if (stristr ( $_POST ['file_nme'], 'jpg' )) {
				$this->db->query ( 'insert into archivo (id_usuario,id_grupo,id_tipo,descripcion,ruta,status,nombre_publico) 
				values (' . $id . ',' . $_POST ['grupo_frm'] . ',5,"' . $_POST ['desc_frm'] . '","' . $ruta . $data ['upload_data'] ['file_name'] . '","ACT","' . $_POST ["nombre_publico"] . '")' );
			}
			if (stristr ( $_POST ['file_nme'], 'png' )) {
				$this->db->query ( 'insert into archivo (id_usuario,id_grupo,id_tipo,descripcion,ruta,status,nombre_publico) 
				values (' . $id . ',' . $_POST ['grupo_frm'] . ',6,"' . $_POST ['desc_frm'] . '","' . $ruta . $data ['upload_data'] ['file_name'] . '","ACT","' . $_POST ["nombre_publico"] . '")' );
			}
			if (stristr ( $_POST ['file_nme'], 'mp4' )) {
				$this->db->query ( 'insert into archivo (id_usuario,id_grupo,id_tipo,descripcion,ruta,status,nombre_publico) 
				values (' . $id . ',' . $_POST ['grupo_frm'] . ',2,"' . $_POST ['desc_frm'] . '","' . $ruta . $data ['upload_data'] ['file_name'] . '","ACT","' . $_POST ["nombre_publico"] . '")' );
			}
			// echo 'ptm';
			$this->db->query ( 'insert into archivo (id_usuario,id_grupo,id_tipo,descripcion,ruta,status,nombre_publico) 
			values (' . $id . ',' . $_POST ['grupo_frm'] . ',9,"' . $_POST ['desc_frm'] . '","' . $ruta . $data ['upload_data'] ['file_name'] . '","ACT","' . $_POST ["nombre_publico"] . '")' );
		}
		redirect ( '/bo/comercial/oficina_virtual' );
	}
	function nuevo_archivo() {
		$tipo = $_GET ['tipo'];
		$this->db->query ( 'insert into archivo (id_usuario,id_grupo,id_tipo,descripcion,ruta) values ()' );
	}
	function borrar_archivo() {
		$data = $_GET ["info"];
		$data = json_decode ( $data, true );
		$this->db->query ( 'delete from archivo where id_archivo=' . $data ['id'] );
		if (unlink ( $data ['file'] ))
			echo "File Deleted.";
	}
	function borrar_noticia() {
		$this->db->query ( 'delete from noticia where id=' . $_GET ['id'] );
	}
	function borrar_info() {
		$this->db->query ( 'delete from informacion where id=' . $_GET ['id'] );
	}
	function borrar_cupon() {
		$this->db->query ( 'delete from cupon where id_cupon=' . $_GET ['id'] );
	}
	function borrar_encuesta() {
		$q = $this->db->query ( 'SELECT id_pregunta FROM encuesta_pregunta WHERE id_encuesta=' . $_GET ['id'] );
		$preg = $q->result ();
		for($i = 0; $i < sizeof ( $preg ); $i ++) {
			$this->db->query ( 'delete from encuesta_respuesta where id_pregunta=' . $preg [$i]->id_pregunta );
		}
		$this->db->query ( 'delete from encuesta where id_encuesta=' . $_GET ['id'] );
		$this->db->query ( 'delete from encuesta_pregunta where id_encuesta=' . $_GET ['id'] );
		$n = $this->db->query ( 'SELECT id_encuesta_contestada FROM encuesta_contestada WHERE id_encuesta=' . $_GET ['id'] );
		$cont = $n->result ();
		for($j = 0; $j < sizeof ( $cont ); $j ++) {
			$this->db->query ( 'delete from encuesta_resultado where id_encuesta_contestada=' . $cont [$j]->id_encuesta_contestada );
		}
		$this->db->query ( 'delete from encuesta_contestada where id_encuesta=' . $_GET ['id'] );
	}
	function borrar_evento() {
		$this->db->query ( 'delete from evento where id=' . $_GET ['id'] );
	}
	function nuevo_cupon() {
		$data = $_GET ["info"];
		$data = json_decode ( $data, true );
		$this->db->query ( 'insert into cupon (codigo,descripcion,estado) values ("' . $data ['cod'] . '","' . $data ['desc'] . '","' . $data ['act'] . '")' );
	}
	function estado_cupon() {
		$data = $_GET ["info"];
		$data = json_decode ( $data, true );
		$this->db->query ( 'update cupon set estado="' . $data ['tipo'] . '" where id_cupon=' . $data ['id'] );
	}
	function estado_archivo() {
		$data = $_GET ["info"];
		$data = json_decode ( $data, true );
		$this->db->query ( 'update archivo set status="' . $data ['tipo'] . '" where id_archivo=' . $data ['id'] );
	}
	function estado_encuesta() {
		$data = $_GET ["info"];
		$data = json_decode ( $data, true );
		$this->db->query ( 'update encuesta set estatus="' . $data ['tipo'] . '" where id_encuesta=' . $data ['id'] );
	}
	function editar_archivo() {
		$data = $_GET ["info"];
		$data = json_decode ( $data, true );
		if ($data ['tipo'] == 1) {
			$this->db->query ( 'update archivo set id_grupo=' . $data ['grupo'] . ', descripcion="' . $data ['desc'] . '" where id_archivo=' . $data ['id'] );
		}
		if ($data ['tipo'] == 2) {
			$this->db->query ( 'update informacion set nombre="' . $data ['grupo'] . '", descripcion="' . $data ['desc'] . '" where id=' . $data ['id'] );
		}
		if ($data ['tipo'] == 3) {
			$this->db->query ( 'update noticia set nombre="' . $data ['grupo'] . '", contenido="' . $data ['desc'] . '" where id=' . $data ['id'] );
		}
		if ($data ['tipo'] == 4) {
			$this->db->query ( 'update cupon set codigo="' . $data ['grupo'] . '", descripcion="' . $data ['desc'] . '" where id_cupon=' . $data ['id'] );
		}
	}
	function buscar_usr() {
		$users = $this->modelo_comercial->get_users ( $_GET ['nombre'] );
		if (empty ( $users )) {
			echo '<div class="row">
					<div class="col-lg-1 col-sm-1 col-md-1 col-xs-1">
					</div>
					<div class="col-lg-10 col-sm-10 col-md-10 col-xs-10">
						<div style="text-align:middle;">
							NO HAY USUARIOS CON ESTE NOMBRE
						</div>
					</div>
					<div class="col-lg-1 col-sm-1 col-md-1 col-xs-1">
					</div>
				</div>
				';
		} else {
			echo '
			<div class="row">
				<div class="col-lg-1 col-sm-1 col-md-1 col-xs-1">
				</div>
				<div class="col-lg-10 col-sm-10 col-md-10 col-xs-10">
					<div class="table-responsive">	
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th></th>
									<th>Usuario</th>
									<th>Nombre</th>
									<th>Apellido</th>
								</tr>
							</thead>
							<tbody>';
			
			for($i = 0; $i < sizeof ( $users ); $i ++) {
				echo '
										<tr>
											<td>
												<label class="radio">
													<input type="radio" name="radio" id="user_selected" value="' . $users [$i]->id . '">
												<i></i></label>
											</td>
											<td>' . $users [$i]->username . '</td>
											<td>' . $users [$i]->nombre . '</td>
											<td>' . $users [$i]->apellido . '</td>
										</tr>';
			}
			echo '</tbody>
						</table>

					</div>
				</div>
				<div class="col-lg-1 col-sm-1 col-md-1 col-xs-1">
				</div>
			</div>';
		}
	}
	function insert_cupon_usr() {
		$data = $_GET ["info"];
		$data = json_decode ( $data, true );
		$this->db->query ( 'insert into cross_usuario_cupon values(' . $data ["usuario"] . ',' . $data ["cupon"] . ')' );
	}
	function ver_eventos() {
		$eventos = $this->modelo_comercial->get_evento ();
		echo '
		<div class="row">
									
			<!-- NEW WIDGET START -->
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="col-lg-1 col-sm-1 col-md-1 col-xs-1">
				</div>
				<div class="col-lg-10 col-sm-10 col-md-10 col-xs-10">
					<div class="jarviswidget jarviswidget-color-blueDark" data-widget-editbutton="false">
						
						
		
						<!-- widget div-->
						<div>
		
							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->
		
							</div>
							<!-- end widget edit box -->
		
							<!-- widget content -->
							<div class="widget-body no-padding">
		
								<table id="datatable_fixed_column5" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th data-hide="phone">ID</th>
											<th data-class="expand">Nombre</th>
											<th>Descripcion</th>
											<th data-hide="phone">Fecha inicio</th>
											<th>Fecha fin</th>
											<th>Mas...</th>
										</tr>
									</thead>
									<tbody>';
		for($i = 0; $i < sizeof ( $eventos ); $i ++) {
			echo '
										<tr>
											<td>' . ($i + 1) . '</td>
											<td>' . $eventos [$i]->nombre . '</td>
											<td>' . $eventos [$i]->descripcion . '</td>
											<td>' . $eventos [$i]->inicio . '</td>
											<td>' . $eventos [$i]->fin . '</td>
											<td class="text-center">									
												<a class="txt-color-red" style="cursor: pointer;" onclick="delete_evento(' . $eventos [$i]->id . ')" title="Eliminar""><i class="fa fa-trash-o"></i></a>
												<a class="txt-color-green"  style="cursor: pointer;" onclick="editar_evento(' . $eventos [$i]->id . ')"  title="Editar"><i class="fa fa-edit"></i></a>
											</td>';
		}
		
		echo '</tbody>
								</table>
		
							</div>
							<!-- end widget content -->
		
						</div>
						<!-- end widget div -->
					</div>
				</div>
				<div class="col-lg-1 col-sm-1 col-md-1 col-xs-1">
				</div>
				
				<!-- end widget -->
	
			</article>
		</div>';
	}
	function update_evento() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		
		if ($usuario [0]->id_tipo_usuario != 1) {
			redirect ( '/auth/logout' );
		}
		
		$data = $_GET ["info"];
		$data = json_decode ( $data, true );
		$tipo = $data ['tipo'];
		$color = $data ['color'];
		$nombre = $data ['nombre'];
		$desc = $data ['descripcion'];
		$dia_ini = $data ['dia_ini'];
		$hora_ini = $data ['hora_ini'];
		$minuto_ini = $data ['minuto_ini'];
		$dia_fin = $data ['dia_fin'];
		$hora_fin = $data ['hora_fin'];
		$minuto_fin = $data ['minuto_fin'];
		$ano_ini = substr ( $dia_ini, 6 );
		$mes_ini = substr ( $dia_ini, 3, 2 );
		$dia_ini = substr ( $dia_ini, 0, 2 );
		$ano_fin = substr ( $dia_fin, 6 );
		$mes_fin = substr ( $dia_fin, 3, 2 );
		$dia_fin = substr ( $dia_fin, 0, 2 );
		$inicio = $ano_ini . '-' . $mes_ini . '-' . $dia_ini . ' ' . $hora_ini . ':' . $minuto_ini . ':00';
		$fin = $ano_fin . '-' . $mes_fin . '-' . $dia_fin . ' ' . $hora_fin . ':' . $minuto_fin . ':00';
		
		$id = $this->tank_auth->get_user_id ();
		$this->db->query ( 'update evento set id_tipo=' . $tipo . ' ,id_color=' . $color . ' ,id_usuario=' . $id . ' ,nombre="' . $nombre . '" ,descripcion="' . $desc . '" ,
		inicio="' . $inicio . '",fin="' . $fin . '" where id=' . $data ['id'] );
	}
	function insertar_encuesta() {
		$id_usuario = $this->tank_auth->get_user_id ();
		$data = $_POST ["info"];
		$data = json_decode ( $data, true );
		// print_r($data);
		$keys = array_keys ( $data );
		// print_r($keys);
		$this->db->query ( 'insert into encuesta (nombre,descripcion,id_usuario,estatus) values ("' . $data ['nombre'] . '","' . $data ['desc'] . '",' . $id_usuario . ',"DES")' );
		$enc_id = $this->db->insert_id ();
		for($i = 0; $i < $data ['qty']; $i ++) {
			$this->db->query ( 'insert into encuesta_pregunta (id_encuesta,pregunta) values (' . $enc_id . ',"' . $data [$keys [$i]] ["pregunta"] . '")' );
			$preg_id = $this->db->insert_id ();
			// print_r($data[$keys[$i]]);
			// echo $data[$keys[$i]]["pregunta"];
			$resp_keys = array_keys ( $data [$keys [$i]] ["respuestas"] );
			for($j = 0; $j < sizeof ( $resp_keys ); $j ++) {
				// echo $data[$keys[$i]]["respuestas"][$resp_keys[$j]];
				// print_r($resp_keys);
				if ($data [$keys [$i]] ["respuestas"] [$resp_keys [$j]] != "") {
					$this->db->query ( 'insert into encuesta_respuesta (id_pregunta,respuesta) values (' . $preg_id . ',"' . $data [$keys [$i]] ["respuestas"] [$resp_keys [$j]] . '")' );
				}
			}
		}
	}
	function add_grupo() {
		$this->db->query ( "insert into cat_grupo (descripcion) values ('" . $_POST ['grupo'] . "')" );
	}
	function actionProveedor() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		
		$Comercial = $this->general->isAValidUser ( $id, "comercial" );
		$CEDI = $this->general->isAValidUser ( $id, "cedi" );
		$almacen = $this->general->isAValidUser ( $id, "almacen" );
		$Logistico = $this->general->isAValidUser ( $id, "logistica" );
		
		if (! $CEDI && ! $almacen && ! $Logistico && ! $Comercial) {
			redirect ( '/auth/logout' );
		}
		
		$usuario = $this->general->get_username ( $id );
		$type = $usuario [0]->id_tipo_usuario;
		$this->template->set ( "type", $type );
		$style = $this->modelo_dashboard->get_style ( 1 );
		
		$this->template->set ( "usuario", $usuario );
		$this->template->set ( "style", $style );
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		if ($type == 8 || $type == 9) {
			$data = array (
					"user" => $usuario [0]->nombre . "<br/>" . $usuario [0]->apellido 
			);
			$header = $type == 8 ? 'CEDI' : 'Almacen';
			$this->template->set_partial ( 'header', 'website/' . $header . '/header2', $data );
		} else {
			$this->template->set_partial ( 'header', 'website/bo/header' );
		}
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/comercial/altas/proveedor' );
	}
	function nuevo_proveedor() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		
		$Comercial = $this->general->isAValidUser ( $id, "comercial" );
		$CEDI = $this->general->isAValidUser ( $id, "cedi" );
		$almacen = $this->general->isAValidUser ( $id, "almacen" );
		$Logistico = $this->general->isAValidUser ( $id, "logistica" );
		
		if (! $CEDI && ! $almacen && ! $Logistico && ! $Comercial) {
			redirect ( '/auth/logout' );
		}
		
		$usuario = $this->general->get_username ( $id );
		$type = $usuario [0]->id_tipo_usuario;
		$this->template->set ( "type", $type );
		$style = $this->modelo_dashboard->get_style ( 1 );
		
		$this->template->set ( "usuario", $usuario );
		$this->template->set ( "style", $style );
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		$bancos = $this->model_mercancia->Bancos ();
		
		$sexo = $this->model_admin->sexo ();
		$civil = $this->model_admin->edo_civil ();
		$tipo = $this->model_admin->get_user_type ();
		$tipo_fiscal = $this->model_admin->tipo_fiscal ();
		$pais = $this->model_admin->get_pais_activo ();
		$productos = $this->model_admin->get_mercancia ();
		$estudios = $this->model_admin->get_estudios ();
		$ocupacion = $this->model_admin->get_ocupacion ();
		$tiempo_dedicado = $this->model_admin->get_tiempo_dedicado ();
		$proveedores = $this->model_admin->get_proveedor ();
		$grupo = $this->model_admin->get_grupo ();
		$impuesto = $this->model_admin->get_impuesto ();
		$tipo_mercancia = $this->model_admin->get_tipo_mercancia ();
		$tipo_proveedor = $this->model_admin->get_tipo_proveedor ();
		$empresa = $this->model_admin->get_empresa ();
		$regimen = $this->model_admin->get_regimen ();
		$zona = $this->model_admin->get_zona ();
		$tipo_paquete = $this->model_admin->get_tipo_paquete ();
		
		$this->template->set ( "usuario", $usuario );
		$this->template->set ( "style", $style );
		$this->template->set ( "sexo", $sexo );
		$this->template->set ( "civil", $civil );
		$this->template->set ( "tipo", $tipo );
		$this->template->set ( "pais", $pais );
		$this->template->set ( "estudios", $estudios );
		$this->template->set ( "ocupacion", $ocupacion );
		$this->template->set ( "tiempo_dedicado", $tiempo_dedicado );
		$this->template->set ( "tipo_fiscal", $tipo_fiscal );
		$this->template->set ( "proveedores", $proveedores );
		$this->template->set ( "grupo", $grupo );
		$this->template->set ( "impuesto", $impuesto );
		$this->template->set ( "tipo_mercancia", $tipo_mercancia );
		$this->template->set ( "tipo_proveedor", $tipo_proveedor );
		$this->template->set ( "empresa", $empresa );
		$this->template->set ( "regimen", $regimen );
		$this->template->set ( "zona", $zona );
		$this->template->set ( "tipo_paquete", $tipo_paquete );
		$this->template->set ( "bancos", $bancos );
		
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		if ($type == 8 || $type == 9) {
			$data = array (
					"user" => $usuario [0]->nombre . "<br/>" . $usuario [0]->apellido 
			);
			$header = $type == 8 ? 'CEDI' : 'Almacen';
			$this->template->set_partial ( 'header', 'website/' . $header . '/header2', $data );
		} else {
			$this->template->set_partial ( 'header', 'website/bo/header' );
		}
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/comercial/altas/newproveedor' );
	}
	function listarProveedor() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		
		$Comercial = $this->general->isAValidUser ( $id, "comercial" );
		$CEDI = $this->general->isAValidUser ( $id, "cedi" );
		$almacen = $this->general->isAValidUser ( $id, "almacen" );
		$Logistico = $this->general->isAValidUser ( $id, "logistica" );
		
		if (! $CEDI && ! $almacen && ! $Logistico && ! $Comercial) {
			redirect ( '/auth/logout' );
		}
		
		$usuario = $this->general->get_username ( $id );
		$type = $usuario [0]->id_tipo_usuario;
		$this->template->set ( "type", $type );
		$style = $this->modelo_dashboard->get_style ( 1 );
		
		$proveedor = $this->model_admin->get_all_proveedor ();
		$this->template->set ( "proveedor", $proveedor );
		
		$this->template->set ( "usuario", $usuario );
		$this->template->set ( "style", $style );
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		if ($type == 8 || $type == 9) {
			$data = array (
					"user" => $usuario [0]->nombre . "<br/>" . $usuario [0]->apellido 
			);
			$header = $type == 8 ? 'CEDI' : 'Almacen';
			$this->template->set_partial ( 'header', 'website/' . $header . '/header2', $data );
		} else {
			$this->template->set_partial ( 'header', 'website/bo/header' );
		}
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/comercial/altas/listarProveedor' );
	}
	function kill_proveedor() {
		$tieneProductos = $this->model_admin->kill_proveedor ( $_POST ['id'] );
		if ($tieneProductos) {
			echo "El proveedor posee productos no puede ser eliminado";
		} else {
			$this->db->query ( "delete from proveedor_datos where id_proveedor=" . $_POST ["id"] );
			$this->db->query ( "delete from proveedor where id_proveedor=" . $_POST ["id"] );
			echo "Proveedor eliminado con exito";
		}
	}
	function eliminar_afiliado() {
		$q = $this->model_tipo_red->cantidadRedesUsuario ( $_POST ['id'] );
		
		$this->template->set ( "redes", $q );
		$this->template->set ( "id", $_POST ['id'] );
		$this->template->build ( 'website/bo/comercial/red/eliminar_usuario' );
		// echo "dentro de kill controller ";
	}
	function kill_afiliado() {
		// echo "dentro de kill controller ";
		$q = $this->model_admin->kill_afiliado ( $_POST ['id'], $_POST ['red'] );
		if ($q) {
			echo "El Afiliado ha sido eliminado con exito";
			$this->trash_afiliado ( $_POST ['id'], $_POST ['red'] );
		} else {
			echo "El Afiliado no pudo ser eliminado";
		}
	}
	function trash_afiliado($id, $red) {
		$q = count ( $this->model_tipo_red->cantidadRedesUsuario ( $id ) );
		if ($q == 1 || $red == 0) {
			$this->model_perfil->kill_afiliado ( $id );
		} else {
			$this->model_perfil->kill_afiliadonred ( $id, $red );
		}
	}
	function cambiar_estado_proveedor() {
		$this->db->query ( "update proveedor set estatus = '" . $_POST ['estado'] . "' where id_proveedor=" . $_POST ["id"] );
	}
	function editarProveedor() {
		$id = $this->tank_auth->get_user_id ();
		$style = $this->general->get_style ( 1 );
		
		$datosProveedor = $this->model_admin->get_datosProveedor ();
		$zona = $this->model_admin->get_zona ();
		$regimen = $this->model_admin->get_regimen ();
		$impuesto = $this->model_admin->get_impuesto ();
		$pais = $this->model_admin->get_pais_activo ();
		$empresa = $this->model_admin->get_empresa ();
		$tipo_proveedor = $this->model_admin->get_tipo_proveedor ();
		$cuentaBanco = $this->model_admin->get_cuentaBanco ();
		$bancoProveedor = $this->model_admin->get_BancoProveedor ( $cuentaBanco [0]->banco );
		$bancos = $this->model_mercancia->Bancos ();
		
		$this->template->set ( "tipo_proveedor", $tipo_proveedor );
		$this->template->set ( "empresa", $empresa );
		$this->template->set ( "pais", $pais );
		$this->template->set ( "bancoProveedor", $bancoProveedor );
		$this->template->set ( "bancos", $bancos );
		$this->template->set ( "cuentaBanco", $cuentaBanco );
		$this->template->set ( "impuesto", $impuesto );
		
		$this->template->set ( "regimen", $regimen );
		$this->template->set ( "zona", $zona );
		$this->template->set ( "datosProveedor", $datosProveedor );
		
		$this->template->build ( 'website/bo/comercial/altas/editarProveedor' );
	}
	function nueva_mercancia() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		
		if (! $this->general->isAValidUser ( $id, "comercial" )) {
			redirect ( '/auth/logout' );
		}
		
		$usuario = $this->general->get_username ( $id );
		
		$style = $this->modelo_dashboard->get_style ( 1 );
		
		$this->template->set ( "usuario", $usuario );
		$this->template->set ( "style", $style );
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		
		$style = $this->modelo_dashboard->get_style ( $id );
		$productos = $this->model_admin->get_mercancia ();
		$proveedores = $this->model_admin->get_proveedor ();
		$promo = $this->model_admin->get_promo ();
		$grupo = $this->model_admin->get_grupo ();
		$servicio = $this->model_admin->get_servicio ();
		$producto = $this->model_admin->get_producto ();
		$combinado = $this->model_admin->get_combinado ();
		$impuesto = $this->model_admin->get_impuesto ();
		$tipo_mercancia = $this->model_admin->get_tipo_mercancia ();
		$tipo_proveedor = $this->model_admin->get_tipo_proveedor ();
		$empresa = $this->model_admin->get_empresa ();
		$regimen = $this->model_admin->get_regimen ();
		$zona = $this->model_admin->get_zona ();
		$inscripcion = $this->model_admin->get_paquete ();
		$tipo_paquete = $this->model_admin->get_tipo_paquete ();
		$pais = $this->model_admin->get_pais ();
		
		$this->template->set ( "pais", $pais );
		$this->template->set ( "productos", $productos );
		$this->template->set ( "usuario", $usuario );
		$this->template->set ( "style", $style );
		$this->template->set ( "proveedores", $proveedores );
		$this->template->set ( "promo", $promo );
		$this->template->set ( "grupo", $grupo );
		$this->template->set ( "servicio", $servicio );
		$this->template->set ( "producto", $producto );
		$this->template->set ( "combinado", $combinado );
		$this->template->set ( "impuesto", $impuesto );
		$this->template->set ( "tipo_mercancia", $tipo_mercancia );
		$this->template->set ( "tipo_proveedor", $tipo_proveedor );
		$this->template->set ( "empresa", $empresa );
		$this->template->set ( "regimen", $regimen );
		$this->template->set ( "zona", $zona );
		$this->template->set ( "inscripcion", $inscripcion );
		$this->template->set ( "tipo_paquete", $tipo_paquete );
		
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/comercial/altas/mercancia' );
	}
	function actualizar_proveedor() {
		$id = $this->tank_auth->get_user_id ();
		$this->model_mercancia->actualizarProveedor ();
	}
	function mercancia() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		
		$Comercial = $this->general->isAValidUser ( $id, "comercial" );
		$Logistica = ''; // $this->general->isAValidUser($id,"logistica");
		
		if (! $Comercial && ! $Logistica) {
			redirect ( '/auth/logout' );
		}
		
		$style = $this->general->get_style ( 1 );
		
		$this->template->set ( "id", $id );
		$this->template->set ( "style", $style );
		$this->template->set ( "type", $usuario [0]->id_tipo_usuario );
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/comercial/carrito/index' );
	}
	function carrito_de_compras() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		if ($this->general->isAValidUser ( $id, "comercial" ) || $this->general->isAValidUser ( $id, "logistica" )) {
		} else {
			redirect ( '/auth/logout' );
		}
		
		$style = $this->general->get_style ( 1 );
		
		$this->template->set ( "id", $id );
		$this->template->set ( "style", $style );
		$this->template->set ( "type", $usuario [0]->id_tipo_usuario );
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/comercial/carrito/index' );
	}
	function categorias() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		
		if ($usuario [0]->id_tipo_usuario != 1) {
			redirect ( '/auth/logout' );
		}
		
		$style = $this->modelo_dashboard->get_style ( $id );
		
		$this->template->set ( "style", $style );
		
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/comercial/categorias' );
	}
	function listarMercancia() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		
		$Comercial = $this->general->isAValidUser ( $id, "comercial" );
		$Logistica = ''; // $this->general->isAValidUser($id,"logistica");
		
		if (! $Comercial && ! $Logistica) {
			redirect ( '/auth/logout' );
		}
		
		$usuario = $this->general->get_username ( $id );
		$this->template->set ( "type", $usuario [0]->id_tipo_usuario );
		$style = $this->modelo_dashboard->get_style ( 1 );
		
		$this->template->set ( "usuario", $usuario );
		$this->template->set ( "style", $style );
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		
		$grupos1 = $this->model_mercancia->todogrupos ();
		$proveedores = $this->model_admin->get_proveedor ();
		$grupo = $this->model_admin->get_grupo ();
		$impuesto = $this->model_admin->get_impuesto ();
		$tipo_mercancia = $this->model_admin->get_tipo_mercancia ();
		$tipo_proveedor = $this->model_admin->get_tipo_proveedor ();
		$empresa = $this->model_admin->get_empresa ();
		$regimen = $this->model_admin->get_regimen ();
		$zona = $this->model_admin->get_zona ();
		$tipo_paquete = $this->model_admin->get_tipo_paquete ();
		$pais = $this->model_admin->get_pais ();
		
		$productos = $this->model_admin->get_productos ();
		$servicios = $this->model_admin->get_servicios (); // var_dump($servicios);exit();
		                                                    // $promo = $this->model_admin->get_promo();
		$combinados = $this->model_admin->get_combinados ();
		$paquete = $this->model_admin->get_paquetes ();
		$membresias = $this->model_admin->get_membresias ();
		$imp_merc = $this->model_admin->impuestos_por_mercancia ();
		
		$this->template->set ( "imp_merc", $imp_merc );
		$this->template->set ( "pais", $pais );
		$this->template->set ( "productos", $productos );
		$this->template->set ( "usuario", $usuario );
		$this->template->set ( "style", $style );
		$this->template->set ( "proveedores", $proveedores );
		// $this->template->set("promo",$promo);
		$this->template->set ( "grupo", $grupo );
		$this->template->set ( "servicios", $servicios );
		// $this->template->set("producto",$producto);
		$this->template->set ( "combinados", $combinados );
		$this->template->set ( "impuesto", $impuesto );
		$this->template->set ( "tipo_mercancia", $tipo_mercancia );
		$this->template->set ( "tipo_proveedor", $tipo_proveedor );
		$this->template->set ( "empresa", $empresa );
		$this->template->set ( "regimen", $regimen );
		$this->template->set ( "zona", $zona );
		$this->template->set ( "tipo_paquete", $tipo_paquete );
		$this->template->set ( "paquetes", $paquete );
		$this->template->set ( "membresias", $membresias );
		$this->template->set ( "grupos1", $grupos1 );
		
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/comercial/altas/carrito' );
	}
	function new_proveedor() {
		$id = $this->tank_auth->get_user_id ();
		$this->model_mercancia->new_proveedor ( $id );
	}
}
