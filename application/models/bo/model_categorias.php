<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class model_categorias extends CI_Model
{
function __construct()
	{
		parent::__construct();
	}
	
	function listar_tipo($tipo){
		$categorias = $this->db->query('select * from categoria where tipo = '.$tipo);
		return $categorias->result();
	}
	
	function  crear(){
		$datos = array(
				'nombre' => $_POST['nombre'],
				'tipo'	  => $_POST['tipo'],
				'estatus'	  => $_POST['estado']
		);
                 
		$this->db->insert('categoria', $datos);
		return true;
	}
	
	function ConsultarCategoria($id){
		$categoria = $this->db->query('select * from cat_grupo_producto where id_grupo = '.$id.'');
		return $categoria->result();
	}
	
	function actualizar_categoria(){
		$datos = array(
				'descripcion' => $_POST['nombre'],
				'id_red'	  => $_POST['red'],
				'estatus'	  => $_POST['estado']
		);
		$this->db->where('id_grupo', $_POST['id']);
		$this->db->update('cat_grupo_producto', $datos);
		return true;
	}
	
	function eliminar_categoria(){
		$this->db->query("delete from cat_grupo_producto where id_grupo=".$_POST["id"]);
		return true;
	}
	
	function cambiar_estatus_categoria(){
		
		$this->db->query("update cat_grupo_producto set estatus = '".$_POST['estado']."' where id_grupo=".$_POST["id"]);
		return true;
	}
	
	function VerificarCategoria($id_categoria){
		$q = $this->db->query("select nombre from producto where id_grupo = ".$id_categoria);
		$pro = $q->result();
		if(isset($pro[0]->nombre)){
			return false;
		}
		
		$q = $this->db->query("select nombre from servicio where id_red = ".$id_categoria);
		$pro = $q->result();
		if(isset($pro[0]->nombre)){
			return false;
		}
		
		$q = $this->db->query("select nombre from combinado where id_red = ".$id_categoria);
		$pro = $q->result();
		if(isset($pro[0]->nombre)){
			return false;
		}
		
		$q = $this->db->query("select nombre from paquete_inscripcion where id_red = ".$id_categoria);
		$pro = $q->result();
		if(isset($pro[0]->nombre)){
			return false;
		}
		
		$q = $this->db->query("select nombre from membresia where id_red = ".$id_categoria);
		$pro = $q->result();
		if(isset($pro[0]->nombre)){
			return false;
		}
		
		return true;
	}
}
