<?php
class Model_banner extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function m_cargar_banner($paramPaginate=FALSE){
		$this->db->select('ba.idbanner, ba.titulo_ba, ba.imagen_ba, ba.estado_ba, ba.acepta_texto');
		$this->db->select('ba.titulo_texto, ba.size_titulo, ba.color_titulo,ba.position_x,position_y');
		$this->db->select('ba.subtitulo_texto, ba.size_subtitulo, ba.color_subtitulo');
		$this->db->select('tb.idtipobanner, tb.descripcion_tb AS tipo_banner, tb.ancho_defecto, tb.alto_defecto');
		$this->db->select('se.idseccion, se.descripcion_se AS seccion');
		$this->db->from('banner ba');
		$this->db->join('tipo_banner tb','ba.idtipobanner = tb.idtipobanner');
		$this->db->join('seccion se','ba.idseccion = se.idseccion');
		$this->db->where('ba.estado_ba', 1);
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
	public function m_count_banner($paramPaginate=FALSE){
		$this->db->select('COUNT(*) AS contador');
		$this->db->from('banner ba');
		$this->db->join('tipo_banner tb','ba.idtipobanner = tb.idtipobanner');
		$this->db->join('seccion se','ba.idseccion = se.idseccion');
		$this->db->where('ba.estado_ba', 1);
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
		return $this->db->insert('banner', $data);
	}

	public function m_editar($data,$id)
	{
		$this->db->where('idbanner',$id);
		return $this->db->update('banner', $data);
	}
	public function m_anular($datos)
	{
		$data = array(
			'estado_ba' => 0,
			'updatedAt' => date('Y-m-d H:i:s')
		);
		$this->db->where('idbanner',$datos['idbanner']);
		return $this->db->update('banner', $data);
	}



}