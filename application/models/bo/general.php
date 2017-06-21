<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class general extends CI_Model
{
	
	function isAValidUser($id,$modulo){

		$q=$this->db->query('SELECT cu.id_tipo_usuario as tipoId
							FROM users u , user_profiles up ,cat_tipo_usuario cu
							where(u.id=up.user_id)
							and (up.id_tipo_usuario=cu.id_tipo_usuario)
							and(u.id='.$id.')');
		$tipo=$q->result();
	
		$idTipoUsuario=$tipo[0]->tipoId;
	
		$perfiles = array(
			
				// "OV" => $this->IsActivedPago($id),
				"comercial" => ($idTipoUsuario==4) ? true : false,
				"soporte" => ($idTipoUsuario==3) ? true : false,
				"logistica" => ($idTipoUsuario==5) ? true : false,
				"oficina" => ($idTipoUsuario==6) ? true : false,
				"administracion" => ($idTipoUsuario==7) ? true : false,
				"cedi" => ($idTipoUsuario==8) ? true : false,
				"almacen" => ($idTipoUsuario==9) ? true : false,
				
		);
		
		return ($idTipoUsuario==1) ? true :$perfiles[$modulo];
		
	}
        
    function get_tipo_usuario_ACT(){
            $query="SELECT "
                    . "* "
                    . "FROM "
                    . "cat_tipo_usuario "
                    . "WHERE "
                    . "estatus = 'ACT' "
                    . "order by "
                    . "`order`";
            $q=  $this->db->query($query);
            return $q->result();
    }
    
	function get_tipo_usuario_ID_Atributo($id,$atributo){
            $query="SELECT "
                    . "$atributo "
                    . "FROM "
                    . "cat_tipo_usuario "
                    . "WHERE "
                    . "estatus = 'ACT' "
                    . "and id_tipo_usuario = '$id' "
                    . "order by "
                    . "`order`";
            $q= $this->db->query($query);
            $q= $q->result();
            $retorno = $q ? $q[0]->$atributo : '-';
            $formato = str_replace( "<br/>.","",$retorno);
            return $formato;
    }
    
    function get_categorizacion_ACT(){
            $query="SELECT "
                    . "* "
                    . "FROM "
                    . "categorizacion "
                    . "WHERE "
                    . "estatus = 'ACT' "
                    . "order by "
                    . "`order`";
            $q=  $this->db->query($query);
            return $q->result();
    }
    
    function get_categorizacion_ID_Atributo($id,$atributo){
            $query="SELECT "
                    . "$atributo "
                    . "FROM "
                    . "categorizacion "
                    . "WHERE "
                    . "estatus = 'ACT' "
                    . "and id = '$id' "
                    . "order by "
                    . "`order`";
            $q= $this->db->query($query);
            $q= $q->result();
            $retorno = $q ? $q[0]->$atributo : '-';
            $formato = str_replace( "<br/>.","",$retorno);
            return $formato;
    }
    
	function get_username($id)
	{
		$q=$this->db->query('select * from user_profiles where user_id = '.$id);
		return $q->result();
	}
	function get_groups()
	{
		$q=$this->db->query('select * from cat_grupo');
		return $q->result();
	}
	function get_tipo_archivo($ext)
	{
		$q=$this->$this->db->query('select id from cat_tipo_archivo where descripcion= '.$ext);
		return $q->result();
	}
	function get_video()
	{
		$q=$this->db->query('select * from archivo where id_tipo = 2');
		return $q->result();
	}
	
	function get_style($id)
	{
		$q=$this->db->query('select * from estilo_usuario where id_usuario = '.$id);
		return $q->result();
	}
	function totalAfiliados()
	{
		$q=$this->db->query('SELECT count(*)as total FROM users u , user_profiles up
								where u.id=up.user_id 
								and up.id_tipo_usuario=2
								and u.id!=2;');
		return $q->result();
	}
        function get_secciones_perfil($rol){  
            
            if($rol == 3){
                $rol = 2;
            }else if($rol == 6){
                $rol = 12;
            }else{
                $rol = 1;
            }
            
            $query = 'SELECT '
                    . '* '
                    . 'FROM cross_formularios '
                    . 'WHERE formulario = '.$rol.' '
                    . 'ORDER by `order`';
             
            $q=$this->db->query($query);
            return $q->result();
        }
        
        function get_usuarios_rol($rol){ 
            $query = 'SELECT '
                    . '* '
                    . 'FROM user_profiles '
                    . 'WHERE id_tipo_usuario = '.$rol.' '
                    . 'and id_estatus = 1 '
                    . 'ORDER by user_id';
             
            $q=$this->db->query($query);
            return $q->result();
        }
        
        function get_organizacion_id($id){ 
            $query = 'SELECT '
                    . '* '
                    . 'FROM organizacion '
                    . 'WHERE usuario = '.$id;
             
            $q=$this->db->query($query);
            return $q->result();
        }
        
        function update_organizacion_id($id){
            
            $dato = array(
              'jefe' => $_POST ['jefe'],
              'sede' => $_POST ['sede'],
              'cargo' => $_POST ['cargo']
            );
            
            $this->db->update ( "organizacion", $dato, "usuario=". $id );
            return true;
        }
}
