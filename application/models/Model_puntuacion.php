<?php
class Model_puntuacion extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

	public function m_registrar_puntuacion($datos){
		$data = array(
			'idcliente' => $datos['idcliente'],
			'puntos' => $datos['puntos'],
			'fecha_registro' => date('Y-m-d H:i:s'),
			'comentarios' => empty($datos['comentarios']) ? NULL : $datos['comentarios']
		);

		$this->db->insert('puntuacion', $data);
   		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function m_cargar_detalle_puntuacion($paramPaginate, $paramDatos)
	{
		$this->db->select("
			pu.idpuntuacion,
			pu.fecha_registro,
			cl.codigo
		", FALSE);
		$this->db->from('puntuacion pu');
		$this->db->join('cliente cl', 'pu.idcliente = cl.idcliente');
		$this->db->where('pu.puntos', $paramDatos['puntos']);
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
	public function m_count_detalle_puntuacion($paramPaginate, $paramDatos)
	{
		$this->db->select("
			COUNT(*) AS contador
		", FALSE);
		$this->db->from('puntuacion pu');
		$this->db->join('cliente cl', 'pu.idcliente = cl.idcliente');
		$this->db->where('pu.puntos', $paramDatos['puntos']);
		if($paramPaginate){
			if( isset($paramPaginate['search'] ) && $paramPaginate['search'] ){
				foreach ($paramPaginate['searchColumn'] as $key => $value) {
					if(! empty($value)){
						$this->db->like($key ,strtoupper($value) ,FALSE);
					}
				}
			}
		}
		$fData = $this->db->get()->row_array();
		return $fData;
	}
}