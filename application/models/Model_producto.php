<?php
class Model_producto extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function m_cargar_productos($paramPaginate=FALSE){
		$this->db->select("pm.idproductomaster, pm.descripcion_pm, pm.imagen, pm.estado_pm");
		$this->db->select('pm.si_genero, pm.si_color');
		$this->db->from('producto_master pm');
		$this->db->where_in('estado_pm',array(1,2));
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
	public function m_count_productos($paramPaginate=FALSE){
		$this->db->select('COUNT(*) AS contador');
		$this->db->from('producto_master pm');
		$this->db->where('estado_pm',1);
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
	public function m_registrar_producto($data){
		$this->db->insert('producto_master', $data);
   		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	public function m_editar_producto($data,$id){
		$this->db->where('idproductomaster',$id);
		return $this->db->update('producto_master', $data);
	}
	public function m_habilitar($id){
		$data = array(
			'estado_pm' => 1
		);
		$this->db->where('idproductomaster',$id);
		if($this->db->update('producto_master', $data)){
			return true;
		}else{
			return false;
		}
	}
	public function m_deshabilitar($id){
		$data = array(
			'estado_pm' => 2
		);
		$this->db->where('idproductomaster',$id);
		if($this->db->update('producto_master', $data)){
			return true;
		}else{
			return false;
		}
	}
	public function m_anular($datos){
		$data = array(
			'estado_pm' => 0
		);
		$this->db->where('idproductomaster',$datos['idproductomaster']);
		return $this->db->update('producto_master', $data);
	}
}