<?php
class Model_descuento extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function m_cargar_descuentos(){
		$this->db->select("iddescuento, dias, descuento");
		$this->db->from('descuento');
		// $this->db->where("tb.estado_tb",1);
		// $this->db->where("UPPER(a.nombre) LIKE '%". strtoupper($datos['search']) . "%'");
		// $this->db->limit(10);
		return $this->db->get()->result_array();
	}
	public function m_editar_descuento($data,$id)	{
		$this->db->where('iddescuento',$id);
		return $this->db->update('descuento', $data);
	}

	public function m_cargar_todos_descuentos(){
		$this->db->select("iddescuento, dias, descuento");
		$this->db->from('descuento');
		$this->db->order_by('dias ASC');
		return $this->db->get()->result_array();
	}
}