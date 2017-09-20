<?php
class Model_blog extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function m_cargar_noticias($paramPaginate=FALSE){
		$this->db->select('bl.idblog, bl.titulo, bl.descripcion, bl.autor,bl.fecha, bl.imagen');
		$this->db->from('blog bl');
		$this->db->where('bl.estado_bl', 1);
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
	public function m_count_noticias($paramPaginate=FALSE){
		$this->db->select('COUNT(*) AS contador');
		$this->db->from('blog bl');
		$this->db->where('bl.estado_bl', 1);
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
	public function m_registrar($data)
	{
		return $this->db->insert('blog', $data);
	}

	public function m_editar($data,$id)
	{
		$this->db->where('idblog',$id);
		return $this->db->update('blog', $data);
	}
	public function m_anular($datos){
		$data = array(
			'estado_bl' => 0
		);
		$this->db->where('idblog',$datos['idblog']);
		return $this->db->update('blog', $data);
	}



}