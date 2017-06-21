<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class modelo_sede extends CI_Model
{
	
	function __construct() {
		parent::__construct();
	
		//$this->load->model('ov/model_perfil_red');
		$this->load->model('ov/model_perfil');
	}
	
	function listar(){
		$q = $this->db->query("SELECT p.id,p.nombre,p.descripcion,p.ciudad,p.direccion,p.telefono,p.estatus,c.Name
                               FROM sede p ,City c where p.ciudad = c.ID  ");
	    return  $q->result();
		
	}
	
	function crear($sede){
		$this->db->insert('sede',$sede);
		return $this->db->insert_id();
	}
	
	function eliminar($id){
		$this->db->query("delete from sede where id = ".$id);
                return true;
	}
	
	function cambiar_estado($id,$estado) {
		$this->db->query("update sede set estatus = '".$estado."' where id= ".$id);
                return true;
	}
	
	function consultar($id){
		$q = $this->db->query('select * from sede where id ='.$id);
		return $q->result();
	}
        
        function consultar_ACT(){
		$q = $this->db->query('select * from sede where estatus = "ACT"');
		return $q->result();
	}
		
        function get_sede_usuario($id){
                $q = $this->db->query('select * from cross_sede_usuario where FK_user ='.$id);
                $q = $q->result();
                return $q ? $q[0]->FK_sede : 0;
        }
        
	function actualizar ($sede, $id){
		$this->db->update('sede', $sede, array('id' => $id));
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
        
}
