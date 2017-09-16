<?php
class Model_banner extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function m_cargar_banner($paramPaginate=FALSE){
		$this->db->select('ba.idbanner, ba.titulo_ba, ba.imagen_ba, ba.estado_ba, ba.acepta_texto');
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
	public function m_cargar_capas_banner($data){
		$this->db->select('cs.idcapaslider, cs.texto, cs.color, cs.fontsize, cs.data_x, cs.data_y');
		$this->db->select('cs.offset_horizontal, cs.offset_vertical, cs.data_width, cs.line_height');
		$this->db->from('capa_slider cs');
		$this->db->where('cs.idbanner', $data['idbanner']);

		return $this->db->get()->result_array();
	}
	public function m_cargar_banner_web(){
		$this->db->select('ba.idbanner, ba.titulo_ba, ba.imagen_ba, ba.estado_ba, ba.acepta_texto');
		$this->db->select('ba.data_offset_start,ba.data_offset_end');
		$this->db->select('cs.idcapaslider, cs.texto, cs.color, cs.fontsize, cs.data_x,cs.data_y');
		$this->db->select('cs.offset_horizontal, cs.offset_vertical, cs.data_width, cs.line_height');
		$this->db->select('tb.idtipobanner, tb.descripcion_tb AS tipo_banner, tb.ancho_defecto, tb.alto_defecto');
		$this->db->select('se.idseccion, se.descripcion_se AS seccion');
		$this->db->from('banner ba');
		$this->db->join('capa_slider cs','ba.idbanner = cs.idbanner','left');
		$this->db->join('tipo_banner tb','ba.idtipobanner = tb.idtipobanner');
		$this->db->join('seccion se','ba.idseccion = se.idseccion');
		$this->db->where('ba.estado_ba', 1);

		return $this->db->get()->result_array();
	}

	public function m_registrar($data){
		$this->db->insert('banner', $data);
   		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	public function m_registrar_capa_slider($data){
		return $this->db->insert('capa_slider', $data);
	}

	public function m_editar($data,$id){
		$this->db->where('idbanner',$id);
		return $this->db->update('banner', $data);
	}
	public function m_editar_capa_slider($data,$id){
		$this->db->where('idcapaslider',$id);
		return $this->db->update('capa_slider', $data);
	}
	public function m_anular($datos){
		$data = array(
			'estado_ba' => 0,
			'updatedAt' => date('Y-m-d H:i:s')
		);
		$this->db->where('idbanner',$datos['idbanner']);
		return $this->db->update('banner', $data);
	}



}