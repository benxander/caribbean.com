<?php
class Model_email extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function m_cargar_emails(){
		$this->db->select("idemail, titulo_em, estado_em");
		$this->db->from('email');
		// $this->db->where(" tb.estado_tb",1);
		// $this->db->where("UPPER(a.nombre) LIKE '%". strtoupper($datos['search']) . "%'");
		// $this->db->limit(10);
		return $this->db->get()->result_array();
	}
	public function m_editar_email($data,$id)	{
		$this->db->where('idemail',$id);
		return $this->db->update('email', $data);
	}
}