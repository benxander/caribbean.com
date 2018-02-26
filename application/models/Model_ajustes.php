<?php
class Model_ajustes extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function m_cargar_ajustes(){
		$this->db->select("idajuste, dias");
		$this->db->from('ajuste');
		// $this->db->where("tb.estado_tb",1);
		// $this->db->where("UPPER(a.nombre) LIKE '%". strtoupper($datos['search']) . "%'");
		// $this->db->limit(10);
		return $this->db->get()->result_array();
	}
	public function m_editar_ajustes($data,$id)	{
		$this->db->where('idajuste',$id);
		return $this->db->update('ajuste', $data);
	}

	public function m_cargar_todos_ajustes(){
		$this->db->select("idajuste, dias");
		$this->db->from('ajuste');
		$this->db->order_by('dias ASC');
		return $this->db->get()->result_array();
	}
}