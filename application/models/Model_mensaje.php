<?php
class Model_mensaje extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

	public function m_cargar_mensajes($paramPaginate=FALSE){
		$this->db->select("me.idmensaje, me.seccion, me.contenido");
		$this->db->from('mensaje me');
		return $this->db->get()->result_array();
	}

	public function m_editar_mensaje($data,$id){
		$this->db->where('idmensaje',$id);
		return $this->db->update('mensaje', $data);
	}
}