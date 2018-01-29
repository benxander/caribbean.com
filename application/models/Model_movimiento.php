<?php
class Model_movimiento extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function m_cargar_pedidos($paramPaginate=FALSE, $paramDatos=FALSE){
		$desde = $this->db->escape(darFormatoYMD($paramDatos['desde']) . ' 00:00:00');
		$hasta = $this->db->escape(darFormatoYMD($paramDatos['hasta']) . ' 23:59:59');
		// var_dump($desde); var_dump($hasta); exit();
		$this->db->select('mo.idmovimiento, mo.idcliente, mo.fecha_movimiento, mo.idactividadcliente');
		$this->db->select('d.iddetalle, d.idproducto, pm.descripcion_pm, d.cantidad, d.total_detalle, d.genero');
		$this->db->select("CASE WHEN p.categoria = 1 THEN 'BASICO' ELSE 'PREMIUM' END AS categoria",FALSE);
		$this->db->select("CASE WHEN p.categoria = 1 THEN pm.imagen_bas ELSE imagen_pre END AS imagen_producto",FALSE);
		$this->db->select('co.idcolor, co.nombre AS color');
		$this->db->select('c.nombres,c.apellidos, c.email, c.hotel, c.habitacion, c.fecha_excursion, c.fecha_salida, u.codigo, u.ididioma');
		$this->db->select('act.titulo_act excursion, me.denominacion size');
		$this->db->from('movimiento mo');
		$this->db->join('cliente c', 'mo.idcliente = c.idcliente');
		$this->db->join('usuario u', 'c.idusuario = u.idusuario');
		$this->db->join('detalle d', 'mo.idmovimiento = d.idmovimiento');
		$this->db->join('producto p', 'd.idproducto = p.idproducto');
		$this->db->join('medida me', 'p.idmedida = me.idmedida');
		$this->db->join('producto_master pm', 'p.idproductomaster = pm.idproductomaster');
		$this->db->join('color co', 'd.idcolor = co.idcolor');
		$this->db->join('actividad_cliente ac', 'mo.idactividadcliente = ac.idactividadcliente');
		$this->db->join('actividad act', 'ac.idactividad = act.idactividad');
		// $this->db->join('detalle_archivo da', 'd.iddetalle = da.iddetalle');

		$this->db->where('mo.estado', 1);
		$this->db->where('d.estado_det', 1);
		$this->db->where('d.tipo_detalle', 2);
		$this->db->where('mo.fecha_movimiento BETWEEN '. $desde.' AND ' . $hasta);
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
	public function m_cargar_pedido($datos){
		$this->db->select('mo.idmovimiento, mo.idcliente, mo.fecha_movimiento, mo.idactividadcliente');
		$this->db->select('d.iddetalle, d.idproducto, pm.descripcion_pm, d.cantidad, d.total_detalle, d.genero');
		$this->db->select("CASE WHEN p.categoria = 1 THEN 'BASICO' ELSE 'PREMIUM' END AS categoria",FALSE);
		$this->db->select('co.idcolor, co.nombre AS color');
		$this->db->select('c.nombres,c.apellidos, c.email, c.hotel, c.habitacion, c.fecha_excursion, c.fecha_salida, u.codigo, u.ididioma');
		$this->db->select('act.titulo_act excursion, me.denominacion size');
		$this->db->from('movimiento mo');
		$this->db->join('cliente c', 'mo.idcliente = c.idcliente');
		$this->db->join('usuario u', 'c.idusuario = u.idusuario');
		$this->db->join('detalle d', 'mo.idmovimiento = d.idmovimiento');
		$this->db->join('producto p', 'd.idproducto = p.idproducto');
		$this->db->join('medida me', 'p.idmedida = me.idmedida');
		$this->db->join('producto_master pm', 'p.idproductomaster = pm.idproductomaster');
		$this->db->join('color co', 'd.idcolor = co.idcolor');
		$this->db->join('actividad_cliente ac', 'mo.idactividadcliente = ac.idactividadcliente');
		$this->db->join('actividad act', 'ac.idactividad = act.idactividad');
		// $this->db->join('detalle_archivo da', 'd.iddetalle = da.iddetalle');

		$this->db->where('mo.estado', 1);
		$this->db->where('d.estado_det', 1);
		$this->db->where('d.iddetalle', $datos['iddetalle']);
		return $this->db->get()->row_array();
	}
	public function m_cargar_imagenes_pedidos($datos){
		$this->db->select('arc.idarchivo, arc.nombre_archivo');
		$this->db->from('detalle_archivo da');
		$this->db->join('archivo arc', 'da.idarchivo = arc.idarchivo');
		$this->db->where('iddetalle', $datos['iddetalle']);
		$this->db->where('arc.estado_arc', 1);
		return $this->db->get()->result_array();
	}
	public function m_cargar_puntuacion(){
		$this->db->select('puntos, COUNT(*) puntaje',FALSE);
		$this->db->from('puntuacion');
		$this->db->group_by('puntos');
		$this->db->order_by('puntos','DESC');
		return $this->db->get()->result_array();
	}
	public function m_registrar_movimiento($data){
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