<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class modelo_cursos extends CI_Model
{
	
	function __construct() {
		parent::__construct();
	
		//$this->load->model('ov/model_perfil_red');
		$this->load->model('ov/model_perfil');
	}
	
	function listar(){
		$q = $this->db->query("SELECT 
										c.* ,
										o.nombre oferta,
										f.nombre facultad
									FROM 
										curso c,
										(SELECT * FROM categoria WHERE tipo = 1) o,
										(SELECT * FROM categoria WHERE tipo = 2) f
									WHERE 
										o.id = c.FK_oferta
										AND f.id = c.FK_facultad");
	    return  $q->result();
		
	}
	
	function listarSede($id){
		$q = $this->db->query("SELECT
                                            c.*,
                                            s.nombre sede,
                                            concat(p.nombre,' ',p.apellido) docente
                                        FROM
                                            curso c,
                                            sede s,
                                            user_profiles p
                                        WHERE
                                            p.user_id = c.FK_docente
                                            and s.id = c.FK_sede
											and c.FK_sede = ".$id);
		return  $q->result();
	
	}
	
	function crear($curso){
		$this->db->insert('curso',$curso);
		return $this->db->insert_id();
	}
	
	function eliminar($id){
		$this->db->query("delete from curso where id = ".$id);
                return true;
	}
	
	function cambiar_estado($id,$estado) {
		$this->db->query("update curso set estatus = '".$estado."' where id= ".$id);
                return true;
	}
	
	function consultar($id){
		$q = $this->db->query('select * from curso where id ='.$id);
		return $q->result();
	}
    /*function consulta_sede($id){
		$q = $this->db->query("SELECT 
										c.id,c.nombre,c.descripcion,c.inicio,c.fin,
										s.nombre sede,s.direccion,s.telefono,s.codigo_postal postal,
										t.`Name` ciudad,
										o.nombre oferta,
										f.nombre facultad,
										concat(u.nombre,' ',u.apellido) docente,
										c.entradas,c.precio,
										(case when (c.FK_costo = 2) 
												then concat('$ ',c.precio) 
												else (case when (c.FK_costo = 1) 
													then 'Gratuita' 
													else concat('Donación (minimo $ ',c.precio,')') end) end) costo,
										(case when (c.reserva = 1) 
												then 'SI' else 'NO' end) reservacion,
										(case when (c.observaciones) 
												then c.observaciones else 'Sin Observaciones' end) observaciones
									FROM
									 curso c,
										sede s,
										City t,
										(select * from categoria where tipo = 1) o,
										(select * from categoria where tipo = 2) f,
										user_profiles u
									WHERE 
										s.id = c.FK_sede
										and t.ID = s.ciudad
										and o.id = c.FK_oferta
										and f.id = c.FK_facultad
										and u.user_id = c.FK_docente
										and c.estatus = 'ACT'
										and c.FK_sede = ".$id);
		return $q->result();
	}    */
        function consultar_ACT(){
		$q = $this->db->query('select * from curso where estatus = "ACT"');
		return $q->result();
	}
		
        function get_sede_usuario($id){
                $q = $this->db->query('select * from cross_sede_usuario where FK_user ='.$id);
                $q = $q->result();
                return $q ? $q[0]->FK_sede : 0;
        }
        
	function actualizar ($curso, $id){
		$this->db->update('curso', $curso, array('id' => $id));
         return true;
	}
	
	function insertarUsuario(){
		
				$datos = array(
						'id_cedi' => $_POST['id_cedi'],
						'dni' => $_POST['dni'], 
						'username' => $_POST['username'],
						'nombres' => $_POST['nombre'],
						'apellidos' => $_POST['apellido'],
						'telefono' => $_POST['telefono'],
						'email' => $_POST['email'],
						'pais' => $_POST['id_pais'],
						'status' => 'ACT'						
				);
				
				$this->db->insert("users_almacen",$datos);
	
	}
	
	function actualizarUsuario(){
		
		$username = $this->model_perfil->get_username($_POST['id']);
		
		$dato_users = array(
				'email' => $_POST['email']
		);
		$this->db->update('users', $dato_users, array('id' => $_POST['id']));
		
		$dato_almacen = array(
				'id_cedi' => $_POST['id_cedi'],
				'dni' => $_POST['dni'],
				'nombres' => $_POST['nombre'],
				'apellidos' => $_POST['apellido'],
				'telefono' => $_POST['telefono'],
				'email' => $_POST['email'],
				'pais' => $_POST['id_pais']
		);
		$this->db->update('users_almacen', $dato_almacen, array('username' => $username));
		
		$dato_profile = array(
				'keyword' => $_POST['dni'],
				'nombre' => $_POST['nombre'],
				'apellido' => $_POST['apellido']
		);
		$this->db->update('user_profiles', $dato_profile, array('user_id' => $_POST['id']));
			
		return true;
	}
	
	function getUsuarios()
	{
		$q=$this->db->query('SELECT 
								    u.id,
								    u.username,
								    u.email,
								    up.nombre,
								    up.apellido,
								    C.nombre as cedi
								FROM
								    users u,
								    user_profiles up,
								    cat_tipo_usuario cu,
								    users_almacen UC,
								    cedi C
								WHERE
								    (u.id = up.user_id)
								        and (up.id_tipo_usuario = cu.id_tipo_usuario)
								        and (cu.id_tipo_usuario = 9)
								        and UC.username = u.username
								        and UC.id_cedi = C.id_cedi');
		return $q->result();
	}
	
	function getUsuarioId($id)
	{
		$q=$this->db->query('SELECT 
								    u.id as id,
								    u.username as username,
								    u.email as email,
								    up.nombre,
								    up.apellido,
								    C.id_cedi as cedi,
								    UC.dni,
								    UC.telefono,
								    UC.pais
								FROM
								    users u,
								    user_profiles up,
								    cat_tipo_usuario cu,
								    users_almacen UC,
								    cedi C
								WHERE
								    (u.id = up.user_id)
								        and (up.id_tipo_usuario = cu.id_tipo_usuario)
								        and (cu.id_tipo_usuario = 9)
								        and (u.id = '.$id.')
								        and UC.username = u.username
								        and UC.id_cedi = C.id_cedi
								group by u.id');
		return $q->result();
	}
	
	function consultar_Pais_Ciudad($city){
		$q = $this->db->query("Select * from City where ID = ".$city);
		$ciudades = $q->result();
		return $ciudades;
	}
	
	function consultar_ciudades($city){
		$q = $this->db->query("select * from City where id_estate =(Select id_estate from City where ID =  '".$city." ') ");
		$ciudades = $q->result();
		return $ciudades;
	}
	
	function consultar_ciudad_actual($city){
		$q = $this->db->query("select * from City where ID = ".$city );
		$ciudades = $q->result();
		return $ciudades;
	
	}
	
	function  consultar_departamento($city){
		$q = $this->db->query("select * from estate where id_pais=(Select CountryCode from City where ID =  '".$city." ')");
		$departamento = $q->result();
		return $departamento;
	}
	
	function consultar_departamento_activo($city){
		$q = $this->db->query("select * from estate where id=(Select id_estate from City where ID =  '".$city." ')");
		$departamento = $q->result();
		return $departamento;
	}
	
        function getJefes($sede){
            
            $q = $this->db->query("SELECT 
                                        o.jefe id, concat(p.nombre,' ',p.apellido) jefe    
                                    FROM
                                        organizacion o,
                                        user_profiles p
                                    WHERE
                                         p.user_id = o.usuario 
                                         and p.id_tipo_usuario not in (3,6)
                                         and o.sede = $sede
                                    GROUP BY 
                                             o.usuario");
            return $q->result(); 
            
        }
        
        function img($id, $data) {        	
        	
        	
        	$nombre = $data [0];
        	$extencion = $data [1];
        	$archivo = $nombre.".".$extencion;
        	$dato_img = array (
        			"url" => "/media/cursos/".$id."/" . $archivo,
        			"nombre_completo" => $archivo,
        			"nombre" => $nombre,
        			"extencion" => $extencion,
        			"estatus" => "ACT"
        	);
        	$this->db->insert ( "cat_img", $dato_img);
        	$id_img = $this->db->insert_id(); 
        	
        	$galeria = array(
        			'FK_curso' => $id,
        			'FK_img' => $id_img
        	);
        	$this->db->insert ( "galeria", $galeria);
        }
		  
        function consultarGaleria($id){
        	$query=	"SELECT 
						    i.*
						FROM
						    galeria g,
							cat_img i
						WHERE 
							i.id_img = g.FK_img
							and g.FK_curso = ".$id;
        	$q= $this->db->query($query);      	
        	return $q->result();
        }
        
		 function limpiarGaleria($id) {
			$query=	"SELECT 
						    group_concat(FK_img) galeria
						FROM
						    galeria
						WHERE
							FK_curso = ".$id;
        	$q= $this->db->query($query);      	
        	$q= $q->result();
        	
        	if(intval($q[0]->galeria)>0){
        		$galeria = $q[0]->galeria;
        		$this->db->query("delete from galeria where FK_curso = ".$id);
        		$this->db->query("delete from cat_img where id_img in (".$galeria.")");
        	}
		}
	
}
