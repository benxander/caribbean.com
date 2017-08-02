<?php
class Model_banner extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function m_cargar_banner($paramPaginate=FALSE){
		$this->db->select('ba.idbanner, ba.titulo_ba, ba.imagen_ba, ba.estado_ba');
		$this->db->select('tb.idtipobanner, tb.descripcion_tb AS tipo_banner, tb.ancho_defecto, tb.alto_defecto');
		$this->db->select('se.idseccion, se.descripcion_se AS seccion');
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

		if( $paramPaginate['sortName'] ){
			$this->db->order_by($paramPaginate['sortName'], $paramPaginate['sort']);
		}
		if( $paramPaginate['firstRow'] || $paramPaginate['pageSize'] ){
			$this->db->limit($paramPaginate['pageSize'],$paramPaginate['firstRow'] );
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

	public function m_editar($datos)
	{
		$data = array(
			'idgrupo1' => $datos['idgrupo1']['id'],
			'idgrupo2' => $datos['idgrupo2']['id'],
			'nombre' => strtoupper($datos['nombre']),
			'calorias' => empty($datos['calorias']) ? NULL : $datos['calorias'],
			'proteinas' => empty($datos['proteinas']) ? NULL : $datos['proteinas'],
			'grasas' => empty($datos['grasas']) ? NULL : $datos['grasas'],
			'carbohidratos' => empty($datos['carbohidratos']) ? NULL : $datos['carbohidratos'],
			'medida_casera' => empty($datos['medida_casera']) ? NULL : $datos['medida_casera'],
			'gramo' => empty($datos['gramo']) ? NULL : $datos['gramo'],
			'fibra' => empty($datos['fibra']) ? NULL : $datos['fibra'],
			'ceniza' => empty($datos['ceniza']) ? NULL : $datos['ceniza'],
			'calcio' => empty($datos['calcio']) ? NULL : $datos['calcio'],
			'fosforo' => empty($datos['fosforo']) ? NULL : $datos['fosforo'],
			'zinc' => empty($datos['zinc']) ? NULL : $datos['zinc'],
			'hierro' => empty($datos['hierro']) ? NULL : $datos['hierro'],
			'updatedAt' => date('Y-m-d H:i:s')
		);
		$this->db->where('idbanner',$datos['idbanner']);
		return $this->db->update('banner', $data);
	}
	public function m_anular($datos)
	{
		$data = array(
			'estado_ali' => 0,
			'updatedAt' => date('Y-m-d H:i:s')
		);
		$this->db->where('idbanner',$datos['idbanner']);
		return $this->db->update('banner', $data);
	}



}