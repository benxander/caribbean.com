<?php
class Model_excursion extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function m_cargar_excursion_cbo($paramPaginate=FALSE){
		$this->db->select('act.idactividad, act.titulo_act, act.descripcion_act, act.cantidad_fotos, act.monto_total, act.precio_video, act.precio_por_adicional, estado');
		$this->db->from('actividad act');
		$this->db->where_in('act.estado', array(1));
		$this->db->order_by('descripcion_act','ASC');
		return $this->db->get()->result_array();
	}
	public function m_cargar_excursiones($paramPaginate=FALSE){
		$this->db->select('act.idactividad, act.titulo_act, act.descripcion_act, act.cantidad_fotos, act.monto_total, act.precio_video, act.precio_por_adicional, act.precio_primera, estado');
		$this->db->from('actividad act');
		$this->db->where_in('act.estado', array(1,2));
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
	public function m_count_excursiones($paramPaginate=FALSE){
		$this->db->select('COUNT(*) AS contador');
		$this->db->from('actividad act');
		$this->db->where_in('act.estado', array(1,2));
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
	public function m_cargar_paquetes($datos){
		$this->db->select('pq.idpaquete, pq.idactividad, pq.porc_cantidad, pq.porc_monto, pq.cantidad, pq.monto, pq.estado_pq, pq.es_base, pq.titulo_pq');
		$this->db->from('paquete pq');
		$this->db->where('idactividad', $datos['idactividad']);
		if($this->sessionCP['key_grupo'] != 'key_cliente'){
			$this->db->where('es_base', 2);
		}
		return $this->db->get()->result_array();
	}
	public function m_cargar_paquetes_por_actividad($datos){
		$this->db->select('pq.idpaquete, pq.idactividad, pq.porc_cantidad, pq.porc_monto, pq.cantidad, pq.monto, pq.estado_pq, pq.es_base, pq.titulo_pq');
		$this->db->from('paquete pq');
		$this->db->where('idactividad', $datos['idactividad']);
		return $this->db->get()->result_array();
	}
	public function m_cargar_paquetes_cliente($datos){
		$this->db->select('act.idactividad, act.titulo_act, act.descripcion_act, act.cantidad_fotos, act.monto_total, ac.idactividadcliente');
		$this->db->select('act.precio_por_adicional, act.precio_primera, act.precio_video');
		$this->db->from('actividad act');
		$this->db->join('actividad_cliente ac', 'act.idactividad = ac.idactividad');
		$this->db->join('cliente c', 'ac.idcliente = c.idcliente');
		$this->db->where('c.idcliente', $datos['idcliente']);
		$this->db->where('ac.estado_ac', 1);

		return $this->db->get()->result_array();
	}
	public function m_cargar_excursiones_cliente($datos){
		$this->db->select('idactividad');
		$this->db->from('actividad_cliente');
		$this->db->where('idcliente', $datos['idcliente']);
		$this->db->where('estado_ac', 1);
		return $this->db->get()->result_array();
	}

	public function m_registrar($data)
	{
		$this->db->insert('actividad', $data);
		$last_id = $this->db->insert_id();
		return $last_id;
	}
	public function m_registrar_paquete($data)
	{
		$this->db->insert('paquete', $data);
		$last_id = $this->db->insert_id();
		return $last_id;
	}

	public function m_editar($data,$id)
	{
		$this->db->where('idactividad',$id);
		return $this->db->update('actividad', $data);
	}
	public function m_editar_paquete($data,$id)
	{
		$this->db->where('idpaquete',$id);
		return $this->db->update('paquete', $data);
	}
	public function m_anular($datos){
		$data = array(
			'estado' => 0
		);
		$this->db->where('idactividad',$datos['idactividad']);
		return $this->db->update('actividad', $data);
	}
	public function m_habilitar($id){
		$data = array(
			'estado' => 1
		);
		$this->db->where('idactividad',$id);
		if($this->db->update('actividad', $data)){
			return true;
		}else{
			return false;
		}
	}
	public function m_deshabilitar($id){
		$data = array(
			'estado' => 2
		);
		$this->db->where('idactividad',$id);
		if($this->db->update('actividad', $data)){
			return true;
		}else{
			return false;
		}
	}


}