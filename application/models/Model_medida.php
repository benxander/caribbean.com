<?php
class Model_medida extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

	public function m_cargar_medidas($paramPaginate=FALSE){
		$this->db->select("me.idmedida, me.denominacion, me.estado_me, tm.idtipomedida, tm.descripcion_tm");
		$this->db->from('medida me');
		$this->db->join('tipo_medida tm', 'me.idtipomedida = tm.idtipomedida');
		$this->db->where_in('estado_me',array(1,2));
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
	public function m_count_medidas($paramPaginate=FALSE){
		$this->db->select('COUNT(*) AS contador');
		$this->db->from('medida me');
		$this->db->join('tipo_medida tm', 'me.idtipomedida = tm.idtipomedida');
		$this->db->where_in('estado_me',array(1,2));
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

	public function m_registrar_medida($data){
		$this->db->insert('medida', $data);
   		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	public function m_editar_medida($data,$id){
		$this->db->where('idmedida',$id);
		return $this->db->update('medida', $data);
	}
	public function m_habilitar($id){
		$data = array(
			'estado_me' => 1
		);
		$this->db->where('idmedida',$id);
		if($this->db->update('medida', $data)){
			return true;
		}else{
			return false;
		}
	}
	public function m_deshabilitar($id){
		$data = array(
			'estado_me' => 2
		);
		$this->db->where('idmedida',$id);
		if($this->db->update('medida', $data)){
			return true;
		}else{
			return false;
		}
	}
	public function m_anular($datos){
		$data = array(
			'estado_me' => 0
		);
		$this->db->where('idmedida',$datos['idmedida']);
		return $this->db->update('medida', $data);
	}

}