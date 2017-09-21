<?php
class Model_idioma extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function m_cargar_idioma_cbo(){
		$this->db->select('id.ididioma, id.nombre_id, id.descripcion_id, id.bandera, id.estado_id');
		$this->db->from('idioma id');
		$this->db->where('id.estado_id', 1);
		$this->db->order_by('id.descripcion_id');
		return $this->db->get()->result_array();
	}
}