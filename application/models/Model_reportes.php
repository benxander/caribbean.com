<?php
class Model_reportes extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function m_cargar_reportes(){
		$this->db->select("
			rp.idreporte,
			rp.titulo,
			rp.abreviatura,
			rp.estado_rp
		");
		$this->db->from('reporte rp');
		$this->db->where("rp.estado_rp",1);
		return $this->db->get()->result_array();
	}

}