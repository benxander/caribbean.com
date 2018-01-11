<?php
class Model_producto extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function m_cargar_productos($paramPaginate=FALSE){
		$this->db->select("pm.idproductomaster, pm.descripcion_pm, pm.imagen, pm.estado_pm");
		$this->db->select('pm.si_genero, pm.si_color, pm.tipo_seleccion, pm.idtipomedida');
		$this->db->select('pm.descripcion_basico, pm.descripcion_premium, pm.imagen_bas, pm.imagen_pre');
		$this->db->from('producto_master pm');
		$this->db->where_in('estado_pm',array(1,2));
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
	public function m_count_productos($paramPaginate=FALSE){
		$this->db->select('COUNT(*) AS contador');
		$this->db->from('producto_master pm');
		$this->db->where('estado_pm',1);
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
	public function m_cargar_producto_cbo(){
		$this->db->select("pm.idproductomaster, pm.descripcion_pm, pm.imagen, pm.estado_pm");
		$this->db->select('pm.si_genero, pm.si_color, pm.idtipomedida');
		$this->db->from('producto_master pm');
		$this->db->where('pm.estado_pm', 1);
		$this->db->order_by('idproductomaster', 'ASC');
		return $this->db->get()->result_array();
	}
	public function m_cargar_producto_pedido(){
		$this->db->select("pm.idproductomaster, pm.descripcion_pm, pm.estado_pm");
		$this->db->select('pm.si_genero, pm.si_color, pm.idtipomedida, tm.descripcion_tm');
		$this->db->select('pm.descripcion_basico, pm.descripcion_premium, tipo_seleccion');
		$this->db->select('pm.imagen, pm.imagen_bas, pm.imagen_pre');
		$this->db->select('co.idcolor, co.nombre, co.rgba, me.idmedida, me.denominacion, p.cantidad_fotos');
		$this->db->select('p.idproducto, p.categoria, p.precio_unitario, p.precio_2_5, p.precio_mas_5');
		$this->db->from('producto_master pm');
		$this->db->join('producto_master_color pmc', 'pm.idproductomaster = pmc.idproductomaster AND estado_pmc = 1','left');
		$this->db->join('color co', 'pmc.idcolor = co.idcolor AND estado_co = 1','left');
		$this->db->join('producto p', 'pm.idproductomaster = p.idproductomaster');
		$this->db->join('medida me', 'p.idmedida = me.idmedida');
		$this->db->join('tipo_medida tm', 'pm.idtipomedida = tm.idtipomedida');
		$this->db->where('estado_pm',1);
		$this->db->where('estado_p',1);
		$this->db->where('estado_me',1);
		// $this->db->where('tipo_seleccion', 1);
		$this->db->order_by('pm.idproductomaster','ASC');
		$this->db->order_by('p.categoria','ASC');
		$this->db->order_by('me.idmedida','ASC');
		return $this->db->get()->result_array();
	}
	public function m_cargar_colores_cbo(){
		$this->db->select('co.idcolor, co.nombre, co.rgba, co.estado_co');
		$this->db->from('color co');
		$this->db->where('estado_co', 1);
		$this->db->order_by('nombre', 'ASC');
		return $this->db->get()->result_array();
	}
	public function m_cargar_tipo_medida_cbo(){
		$this->db->select('tm.idtipomedida, tm.descripcion_tm');
		$this->db->from('tipo_medida tm');
		// $this->db->where('estado_co', 1);
		$this->db->order_by('idtipomedida', 'ASC');
		return $this->db->get()->result_array();
	}
	public function m_cargar_precios_por_producto($datos){
		$this->db->select('m.idmedida, m.denominacion as medida, m.idtipomedida');
		$this->db->select('p.idproducto, p.categoria,p.cantidad_fotos, p.precio_unitario, p.precio_2_5, p.precio_mas_5, p.estado_p');
		$this->db->from('medida m');
		// $this->db->join('producto_master pm', 'm.ç = pm.ç');
		$this->db->join('producto p', 'm.idmedida = p.idmedida AND idproductomaster = ' . $datos['idproductomaster'] . ' AND p.categoria = ' . $datos['categoria'],'left');
		$this->db->where('idtipomedida', $datos['idtipomedida']);
		$this->db->where('p.estado_p', 1);
		$this->db->order_by('idmedida','ASC');
		$this->db->order_by('idproducto','ASC');
		return $this->db->get()->result_array();
	}
	public function m_registrar_producto($data){
		$this->db->insert('producto_master', $data);
   		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	public function m_editar_producto($data,$id){
		$this->db->where('idproductomaster',$id);
		return $this->db->update('producto_master', $data);
	}
	public function m_habilitar($id){
		$data = array(
			'estado_pm' => 1
		);
		$this->db->where('idproductomaster',$id);
		if($this->db->update('producto_master', $data)){
			return true;
		}else{
			return false;
		}
	}
	public function m_deshabilitar($id){
		$data = array(
			'estado_pm' => 2
		);
		$this->db->where('idproductomaster',$id);
		if($this->db->update('producto_master', $data)){
			return true;
		}else{
			return false;
		}
	}
	public function m_anular($datos){
		$data = array(
			'estado_pm' => 0
		);
		$this->db->where('idproductomaster',$datos['idproductomaster']);
		return $this->db->update('producto_master', $data);
	}
	public function m_cargar_colores_producto($datos){
		$this->db->select('idproductomastercolor, idproductomaster, idcolor');
		$this->db->from('producto_master_color pmc');
		$this->db->where('estado_pmc', 1);
		$this->db->where('idproductomaster', $datos['idproductomaster']);
		return $this->db->get()->result_array();
	}
	public function m_registrar_producto_precio($datos){
		return $this->db->insert('producto', $datos);
	}
	public function m_editar_producto_precio($data,$id){
		$this->db->where('idproducto',$id);
		return $this->db->update('producto', $data);
	}
	public function m_registrar_colores_producto($datos){
		return $this->db->insert('producto_master_color', $datos);
	}
	public function m_eliminar_colores_producto($datos){
		$data = array(
			'estado_pmc' => 0
		);
		$this->db->where('idproductomaster',$datos['idproductomaster']);
		return $this->db->update('producto_master_color', $data);
	}
	public function m_anular_producto_precios($datos){
		$data = array(
			'estado_p' => 0
		);
		$this->db->where('idproducto',$datos['idproducto']);
		return $this->db->update('producto', $data);
	}
}