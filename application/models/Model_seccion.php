<?php
class Model_seccion extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function m_cargar_seccion_cbo(){
		$this->db->select("idseccion, descripcion_se");
		$this->db->from('seccion se');
		$this->db->where("se.estado_se",1);
		// $this->db->where("UPPER(a.nombre) LIKE '%". strtoupper($datos['search']) . "%'");
		// $this->db->limit(10);
		return $this->db->get()->result_array();
	}
}