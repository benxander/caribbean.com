<?php
class Model_email extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function m_cargar_tipo_email_cbo(){
		$this->db->select("idtipoemail, titulo_te");
		$this->db->from('tipo_email');
		$this->db->where("estado_te",1);

		return $this->db->get()->result_array();
	}
	public function m_cargar_emails($paramPaginate){
		$this->db->select("te.idtipoemail, te.titulo_te, te.estado_te");
		$this->db->select("em.idemail, em.asunto, em.contenido, em.ididioma, id.nombre_id AS idioma");
		$this->db->from('email em');
		$this->db->join('tipo_email te', 'em.idtipoemail = te.idtipoemail');
		$this->db->join('idioma id', 'em.ididioma = id.ididioma');
		$this->db->where("em.estado_em",1);
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
		$this->db->from('email em');
		$this->db->join('tipo_email te', 'em.idtipoemail = te.idtipoemail');
		$this->db->where("em.estado_em",1);

		$fData = $this->db->get()->row_array();
		return $fData;
	}
	public function m_cargar_email($datos){
		$this->db->select("em.idtipoemail, em.idemail, em.asunto, em.contenido, em.ididioma");
		$this->db->from('email em');
		$this->db->where("estado_em",1);
		$this->db->where('ididioma', $datos['ididioma']);
		$this->db->where('idtipoemail', $datos['idtipoemail']);

		return $this->db->get()->result_array();
	}
	public function m_editar_email($data,$id)	{
		$this->db->where('idemail',$id);
		return $this->db->update('email', $data);
	}
	public function m_registrar_email($data)	{
		return $this->db->insert('email', $data);
	}
}