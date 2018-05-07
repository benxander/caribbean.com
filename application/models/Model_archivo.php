<?php
class Model_archivo extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function m_cargar_galeria_descargados($pDatos){
		$this->db->select('arc.idarchivo, arc.idcliente, arc.nombre_archivo, arc.size, arc.fecha_subida,
			arc.descargado, arc.fecha_descarga, arc.es_bonificacion, arc.tipo_archivo,
			cl.codigo, cl.fecha_salida, cl.idexcursion');
		$this->db->from('archivo arc');
		// $this->db->join('usuario us','us.idusuario = arc.idusuario');
		$this->db->join('cliente cl', 'arc.idcliente = cl.idcliente');
		$this->db->where('arc.estado_arc', 1);
		$this->db->where('arc.descargado', 1);
		$this->db->where('arc.idcliente', $pDatos['idcliente']);
		return $this->db->get()->result_array();
	}
	public function m_cargar_video_cliente($pDatos){
		$this->db->select('ev.nombre_video, ev.size, ev.fecha, ev.idexcursionvideo');
		$this->db->from('cliente cl');
		$this->db->join('excursion_video ev', 'cl.idexcursion = ev.idexcursion AND cl.fecha_excursion = ev.fecha', 'left');
		$this->db->where('cl.idcliente', $pDatos['idcliente']);
		$this->db->where('cl.procesado', 4);
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}

	public function m_cargar_galeria_no_descargados($pDatos){
		$this->db->select('arc.idarchivo, arc.idcliente, arc.nombre_archivo, arc.size,
			arc.fecha_subida, arc.descargado, arc.fecha_descarga, arc.es_bonificacion,
			arc.tipo_archivo, cl.codigo,cl.fecha_salida');
		$this->db->from('archivo arc');
		// $this->db->join('usuario us','us.idusuario = arc.idusuario');
		$this->db->join('cliente cl', 'arc.idcliente = cl.idcliente');
		$this->db->where('arc.estado_arc', 1);
		$this->db->where('arc.descargado', 2);
		$this->db->where('arc.idcliente', $pDatos['idcliente']);
		return $this->db->get()->result_array();
	}

	public function m_cargar_archivo($paramPaginate=FALSE){
		$this->db->select('a.idarchivo, a.idcliente, a.nombre_archivo, a.size, a.tipo_archivo, a.fecha_subida, a.descargado, a.fecha_descarga, a.es_bonificacion, a.estado_arc');
		$this->db->from('archivo a');
		$this->db->where('a.estado_arc', 1);
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
		$this->db->where('a.estado_arc', 1);
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
		$this->db->select('a.idarchivo, a.idcliente, a.nombre_archivo, a.size, a.tipo_archivo,
		a.fecha_subida, a.descargado, a.fecha_descarga, a.es_bonificacion, a.estado_arc, cl.codigo');
		$this->db->from('archivo a');
		$this->db->join('cliente cl', 'a.idcliente = cl.idcliente');
		// $this->db->join('usuario u','u.idusuario = a.idusuario', 'left');
		$this->db->where('a.estado_arc', 1);
		$this->db->where('a.idcliente', $data['idcliente']);
		return $this->db->get()->result_array();
	}

	public function m_cargar_nombre_imagenes($data){
		$this->db->select('a.nombre_archivo');
		$this->db->from('archivo a');
		$this->db->join('cliente cl', 'a.idcliente = cl.idcliente');
		// $this->db->join('usuario u','u.idusuario = a.idusuario', 'left');
		$this->db->where('a.estado_arc', 1);
		$this->db->where('a.idcliente', $data['idcliente']);
		return $this->db->get()->result_array();
	}

	// MANTENIMIENTO
	public function m_registrar_archivo($data){
		return $this->db->insert('archivo', $data);
	}
	public function m_registrar_video_excursion($data){
		$datos = array(
			'idexcursion' => $data['idexcursion'],
			'nombre_video' => $data['nombre_video'],
			'fecha' => $data['fecha'],
			'size' => $data['size'],
			'estado' => 1,
		 );
		return $this->db->insert('excursion_video', $datos);
	}

	public function m_editar_descarga_archivo($data){
		$datos = array(
			'descargado' => $data['descargado'],
			'fecha_descarga' => date('Y-m-d H:i:s')
		);
		$this->db->where('idarchivo',$data['idarchivo']);

		return $this->db->update('archivo', $datos);
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
	public function m_verificar_archivo_cliente($datos){
		$this->db->select('idarchivo');
		$this->db->from('archivo');
		$this->db->where('idcliente', $datos['idcliente']);
		$this->db->where('nombre_archivo', $datos['nombre_archivo']);
		$this->db->where('estado_arc', '1');
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}
	public function m_verificar_video_excursion($datos){
		$this->db->select('idexcursionvideo');
		$this->db->from('excursion_video');
		$this->db->where('idexcursion', $datos['idexcursion']);
		$this->db->where('nombre_video', $datos['nombre_video']);
		$this->db->where('estado', '1');
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}
}