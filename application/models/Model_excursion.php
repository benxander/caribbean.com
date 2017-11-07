<?php
class Model_excursion extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function m_cargar_excursion_cbo($paramPaginate=FALSE){
		$this->db->select('ac.idactividad, ac.descripcion, ac.fecha_actividad, ac.cantidad_fotos, ac.monto_total, ac.precio_video, estado');
		$this->db->from('actividad ac');
		$this->db->where_in('ac.estado', array(1));
		$this->db->order_by('descripcion','ASC');
		return $this->db->get()->result_array();
	}
	public function m_cargar_excursiones($paramPaginate=FALSE){
		$this->db->select('ac.idactividad, ac.descripcion, ac.fecha_actividad, ac.cantidad_fotos, ac.monto_total, ac.precio_video, estado');
		$this->db->from('actividad ac');
		$this->db->where_in('ac.estado', array(1,2));
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
	public function m_count_excursiones($paramPaginate=FALSE){
		$this->db->select('COUNT(*) AS contador');
		$this->db->from('actividad ac');
		$this->db->where_in('ac.estado', array(1,2));
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
		$this->db->insert('actividad', $data);
		$last_id = $this->db->insert_id();
		return $last_id;
	}
	public function m_registrar_paquete($data)
	{
		$this->db->insert('paquete', $data);
		$last_id = $this->db->insert_id();
		return $last_id;
	}

	public function m_editar($data,$id)
	{
		$this->db->where('idactividad',$id);
		return $this->db->update('actividad', $data);
	}
	public function m_anular($datos){
		$data = array(
			'estado_bl' => 0
		);
		$this->db->where('idblog',$datos['idblog']);
		return $this->db->update('blog', $data);
	}
	public function m_habilitar($id){
		$data = array(
			'estado' => 1
		);
		$this->db->where('idactividad',$id);
		if($this->db->update('actividad', $data)){
			return true;
		}else{
			return false;
		}
	}
	public function m_deshabilitar($id){
		$data = array(
			'estado' => 2
		);
		$this->db->where('idactividad',$id);
		if($this->db->update('actividad', $data)){
			return true;
		}else{
			return false;
		}
	}


}