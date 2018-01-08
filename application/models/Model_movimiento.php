<?php
class Model_movimiento extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function m_cargar_pedidos($paramPaginate=FALSE, $paramDatos=FALSE){
		$this->db->select('mo.idmovimiento, mo.idcliente, mo.fecha_movimiento, mo.idactividadcliente');
		$this->db->select('d.iddetalle, d.idproducto, pm.descripcion_pm, d.cantidad, d.total_detalle, d.genero');
		$this->db->select("CASE WHEN p.categoria = 1 THEN 'BASICO' ELSE 'PREMIUM' END AS categoria",FALSE);
		$this->db->select('co.idcolor, co.nombre AS color');
		$this->db->select('c.nombres,c.apellidos, c.email, c.hotel, c.habitacion, c.fecha_salida, u.codigo, u.ididioma');
		$this->db->from('movimiento mo');
		$this->db->join('cliente c', 'mo.idcliente = c.idcliente');
		$this->db->join('usuario u', 'c.idusuario = u.idusuario');
		$this->db->join('detalle d', 'mo.idmovimiento = d.idmovimiento');
		$this->db->join('producto p', 'd.idproducto = p.idproducto');
		$this->db->join('producto_master pm', 'p.idproductomaster = pm.idproductomaster');
		$this->db->join('color co', 'd.idcolor = co.idcolor');
		// $this->db->join('detalle_archivo da', 'd.iddetalle = da.iddetalle');

		$this->db->where('mo.estado', 1);
		$this->db->where('d.estado_det', 1);
		$this->db->where('d.tipo_detalle', 2);
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
	public function m_count_pedidos($paramPaginate=FALSE, $paramDatos=FALSE){
		$this->db->select('COUNT(*) AS contador');
		$this->db->from('movimiento mo');
		$this->db->join('cliente c', 'mo.idcliente = c.idcliente');
		$this->db->join('usuario u', 'c.idusuario = u.idusuario');
		$this->db->join('detalle d', 'mo.idmovimiento = d.idmovimiento');
		$this->db->join('producto p', 'd.idproducto = p.idproducto');
		$this->db->join('producto_master pm', 'p.idproductomaster = pm.idproductomaster');
		$this->db->join('color co', 'd.idcolor = co.idcolor');
		// $this->db->join('detalle_archivo da', 'd.iddetalle = da.iddetalle');

		$this->db->where('mo.estado', 1);
		$this->db->where('d.estado_det', 1);
		$this->db->where('d.tipo_detalle', 2);
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
	public function m_registrar_pedido($data){
		$this->db->insert('movimiento', $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	public function m_registrar_detalle($data){
		$this->db->insert('detalle', $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	public function m_registrar_detalle_archivo($data){
		return $this->db->insert('detalle_archivo', $data);
	}


}