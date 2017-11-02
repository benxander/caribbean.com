<?php
class Model_tipo_producto extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function m_cargar_tipo_producto_oferta(){
		$this->db->select("idtipoproducto, descripcion_tp, precio, es_oferta, icono, estado_tp");
		$this->db->from('tipo_producto');
		$this->db->where('es_oferta',1);
		$this->db->where('estado_tp',1);
		return $this->db->get()->result_array();
	}
}