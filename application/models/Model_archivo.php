<?php
class Model_archivo extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function m_cargar_archivo($paramPaginate=FALSE){
		$this->db->select('a.idarchivo, a.idcliente, a.idusuario, a.nombre_archivo, a.size, a.idtipoproducto, a.fecha_subida, a.descargado, a.fecha_descarga, a.es_bonificacion, a.estado_arc');
		$this->db->from('archivo a');
		$this->db->where('a.estado_ar', 1);
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

	public function m_count_archivo($paramPaginate=FALSE){
		$this->db->select('COUNT(*) AS contador');
		$this->db->from('archivo a');
		$this->db->where('a.estado_ar', 1);
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

	public function m_cargar_imagenes($data){
		$this->db->select('a.idarchivo, a.idcliente, a.idusuario, a.nombre_archivo, a.size, a.idtipoproducto, 
		a.fecha_subida, a.descargado, a.fecha_descarga, a.es_bonificacion, a.estado_arc, u.codigo');
		$this->db->from('archivo a');
		$this->db->join('usuario u','u.idusuario = a.idusuario', 'left');
		$this->db->where('a.estado_arc', 1);
		$this->db->where('a.idusuario', $data['idusuario']);
		return $this->db->get()->result_array();
	}

	public function m_cargar_nombre_imagenes($data){
		$this->db->select('a.nombre_archivo');
		$this->db->from('archivo a');
		$this->db->join('usuario u','u.idusuario = a.idusuario', 'left');
		$this->db->where('a.estado_arc', 1);
		$this->db->where('a.idusuario', $data['idusuario']);
		return $this->db->get()->result_array();
	}

	// MANTENIMIENTO
	public function m_registrar_archivo($data){
		$datos = array(
			'idcliente' => $data['idcliente'],
			'idusuario' => $data['idusuario'],
			'nombre_archivo' => $data['nombre_archivo'],
			'size' => $data['size'],
			'idtipoproducto' => $data['idtipoproducto'],
			'estado_arc' => 1,
			'fecha_subida' => date('Y-m-d H:i:s')
		 );
		return $this->db->insert('archivo', $datos);
	}

	public function m_anular_archivo($data){
		$datos = array(
			'estado_arc' => 0
		);
		$this->db->where('idarchivo',$data['idarchivo']);

		return $this->db->update('archivo', $datos);
	}

	public function m_delete_archivo($data){
		$datos = array(
			'estado_arc' => 0
		);
		$this->db->where('idcliente',$data['idcliente']);

		return $this->db->update('archivo', $datos);
	}
}