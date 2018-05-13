<?php
class Model_mensaje extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

	public function m_cargar_mensajes($paramPaginate=FALSE){
		$this->db->select("
			me.idmensaje,
			me.seccion,
			me.titulo,
			me.contenido
		");
		$this->db->from('mensaje me');
		$this->db->order_by('idmensaje', 'ASC');
		return $this->db->get()->result_array();
	}
	public function m_cargar_mensaje_por_id($id){
		$this->db->select("
			me.idmensaje,
			me.seccion,
			me.titulo,
			me.contenido
		");
		$this->db->from('mensaje me');
		$this->db->where('me.idmensaje', $id);
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}

	public function m_editar_mensaje($data,$id){
		$this->db->where('idmensaje',$id);
		return $this->db->update('mensaje', $data);
	}
}