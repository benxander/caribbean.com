<?php
class Model_email extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function m_cargar_tipo_email_cbo(){
		$this->db->select("idemail, titulo_em");
		$this->db->from('email');
		$this->db->where("estado_em",1);

		return $this->db->get()->result_array();
	}
	public function m_cargar_emails($paramPaginate){
		$this->db->select("em.idemail, em.titulo_em, em.estado_em");
		$this->db->select("cm.idcontenidoemail, cm.asunto, cm.contenido, cm.ididioma, id.nombre_id AS idioma");
		$this->db->from('contenido_email cm');
		$this->db->join('email em', 'cm.idemail = em.idemail');
		$this->db->join('idioma id', 'cm.ididioma = id.ididioma');
		$this->db->where("cm.estado_ce",1);
		if( $paramPaginate['sortName'] ){
			$this->db->order_by($paramPaginate['sortName'], $paramPaginate['sort']);
		}
		if( $paramPaginate['firstRow'] || $paramPaginate['pageSize'] ){
			$this->db->limit($paramPaginate['pageSize'],$paramPaginate['firstRow'] );
		}
		return $this->db->get()->result_array();
	}
	public function m_count_emails($paramPaginate=FALSE){
		$this->db->select('COUNT(*) AS contador');
		$this->db->from('contenido_email cm');
		$this->db->join('email em', 'cm.idemail = em.idemail');
		$this->db->where("cm.estado_ce",1);

		$fData = $this->db->get()->row_array();
		return $fData;
	}
	public function m_editar_email($data,$id)	{
		$this->db->where('idcontenidoemail',$id);
		return $this->db->update('contenido_email', $data);
	}
	public function m_registrar_contenido_email($data)	{
		return $this->db->insert('contenido_email', $data);
	}
}