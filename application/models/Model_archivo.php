<?php
class Model_archivo extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
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
}