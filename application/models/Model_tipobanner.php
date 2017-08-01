<?php
class Model_tipobanner extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function m_cargar_tipo_banner_cbo(){
		$this->db->select("idtipobanner, descripcion_tb, ancho_defecto, alto_defecto");
		$this->db->from('tipo_banner tb');
		// $this->db->where("tb.estado_tb",1);
		// $this->db->where("UPPER(a.nombre) LIKE '%". strtoupper($datos['search']) . "%'");
		// $this->db->limit(10);
		return $this->db->get()->result_array();
	}
}