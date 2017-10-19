<?php
class Model_email extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function m_cargar_emails(){
		$this->db->select("em.idemail, em.titulo_em, em.estado_em, cm.contenido");
		$this->db->from('email em');
		$this->db->join('contenido_email cm', 'em.idemail = cm.idemail','left');
		// $this->db->where(" tb.estado_tb",1);
		// $this->db->where("UPPER(a.nombre) LIKE '%". strtoupper($datos['search']) . "%'");
		// $this->db->limit(10);
		return $this->db->get()->result_array();
	}
	public function m_editar_email($data,$id)	{
		$this->db->where('idemail',$id);
		return $this->db->update('email', $data);
	}
	public function m_registrar_email($data)	{
		$insert = $this->db->insert('email', $data);
		if($insert){
    		return $this->db->insert_id();
    	}
    	return false;
	}
	public function m_registrar_contenido_email($data)	{
		return $this->db->insert('contenido_email', $data);
	}
}