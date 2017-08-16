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
	public function m_cargar_secciones($paramPaginate=FALSE){
		$this->db->select('idseccion, descripcion_se, se.contenido');
		$this->db->select('se.idseccion, se.descripcion_se AS seccion');
		$this->db->from('seccion se');
		$this->db->where("se.estado_se",1);
		if($paramPaginate){
			if( isset($paramPaginate['search'] ) && $paramPaginate['search'] ){
				foreach ($paramPaginate['searchColumn'] as $key => $value) {
					if(! empty($value)){
						$this->db->like($key ,strtoupper($value) ,FALSE);
					}
				}
			}

			if( $paramPaginate['sortName'] ){
				$this->db->order_by($paramPaginate['sortName'], $paramPaginate['sort']);
			}
			if( $paramPaginate['firstRow'] || $paramPaginate['pageSize'] ){
				$this->db->limit($paramPaginate['pageSize'],$paramPaginate['firstRow'] );
			}
			}
		return $this->db->get()->result_array();
	}
	public function m_count_secciones($paramPaginate=FALSE){
		$this->db->select('COUNT(*) AS contador');
		$this->db->from('seccion se');
		$this->db->where("se.estado_se",1);
		if( isset($paramPaginate['search'] ) && $paramPaginate['search'] ){
			foreach ($paramPaginate['searchColumn'] as $key => $value) {
				if(! empty($value)){
					$this->db->like($key ,strtoupper($value) ,FALSE);
				}
			}
		}
		$fData = $this->db->get()->row_array();
		return $fData;
	}
}