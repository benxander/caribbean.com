<?php
class Model_archivo extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
// <<<<<<< HEAD
	public function m_cargar_galeria_descargados($pDatos){
		$this->db->select('arc.idarchivo, arc.idusuario, arc.idcliente, arc.nombre_archivo, arc.size, arc.fecha_subida,
							arc.descargado, arc.fecha_descarga, arc.es_bonificacion, arc.idtipoproducto');
		$this->db->from('archivo arc');
		$this->db->where('arc.estado_arc', 1);
		$this->db->where('arc.descargado', 1);
		$this->db->where('arc.idusuario', $pDatos['idusuario']);
		return $this->db->get()->result_array();
	}

	public function m_cargar_galeria_no_descargados($pDatos){
		$this->db->select('arc.idarchivo, arc.idusuario, arc.idcliente, arc.nombre_archivo, arc.size, arc.fecha_subida,
							arc.descargado, arc.fecha_descarga, arc.es_bonificacion, arc.idtipoproducto,
							us.codigo, tp.descripcion_tp as producto, tp.precio');
		$this->db->from('archivo arc');
		$this->db->join('tipo_producto tp','tp.idtipoproducto = arc.idtipoproducto');
		$this->db->join('usuario us','us.idusuario = arc.idusuario');
		$this->db->where('arc.estado_arc', 1);
		$this->db->where('arc.descargado', 2);
		$this->db->where('arc.idusuario', $pDatos['idusuario']);
		return $this->db->get()->result_array();
	}
// =======

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
			'estado_ar' => 0
		);
		$this->db->where('idarchivo',$data['idarchivo']);

		return $this->db->update('archivo', $datos);
// >>>>>>> b_cliente
	}

	public function m_delete_archivo($data){
		$datos = array(
			'estado_ar' => 0
		);
		$this->db->where('idcliente',$data['idcliente']);

		return $this->db->update('archivo', $datos);
	}
}