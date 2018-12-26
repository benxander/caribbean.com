<?php
class Model_excursion extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function m_cargar_excursion_cbo($paramPaginate=FALSE){
		$this->db->select('
			exc.idexcursion,
			exc.descripcion,
			exc.precio_all,
			exc.precio_pack,
			exc.precio_primera,
			exc.precio_adicional,
			estado_exc
		');
		$this->db->from('excursion exc');
		$this->db->where_in('exc.estado_exc', array(1));
		$this->db->order_by('descripcion','ASC');
		return $this->db->get()->result_array();
	}
	public function m_cargar_excursiones($paramPaginate=FALSE){
		$this->db->select('
			exc.idexcursion,
			exc.descripcion,
			exc.precio_all,
			exc.precio_pack,
			exc.precio_adicional,
			exc.precio_primera,
			estado_exc
		');
		$this->db->from('excursion exc');
		$this->db->where_in('exc.estado_exc', array(1,2));
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
		$this->db->from('excursion exc');
		$this->db->where_in('exc.estado_exc', array(1,2));
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
	/**
	 * Carga una excursion por código
	 * @param  [array] $datos [array proveniente del excel]
	 * @return [array]        [devuelve el paquete con el precio]
	 */
	public function m_cargar_excursion_por_id($datos)
	{
		$this->db->select('
			exc.idexcursion,
			exc.descripcion,
			exc.precio_all,
			exc.precio_pack,
			exc.precio_adicional,
			exc.precio_primera
		');
		$this->db->from('excursion exc');
		$this->db->where('idexcursion', $datos['idexcursion']);
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}

	public function m_cargar_excursion_cliente_sesion(){
		$this->db->select('
			exc.idexcursion,
			exc.descripcion,
			exc.precio_all,
			exc.precio_pack,
			exc.precio_adicional,
			exc.precio_primera,
			c.idexcursionvideo,
			c.paquete,
			c.deposito,
			c.verifica_email,
			c.solicita_bonificacion
		');
		$this->db->from('excursion exc');
		$this->db->join('cliente c', 'exc.idexcursion = c.idexcursion');
		$this->db->where('c.idcliente', $this->sessionCP['idcliente']);
		return $this->db->get()->result_array();
	}
	public function m_cargar_excursiones_cliente($datos){
		$this->db->select('idexcursion');
		$this->db->from('excursion_cliente');
		$this->db->where('idcliente', $datos['idcliente']);
		$this->db->where('estado_exc_ac', 1);
		return $this->db->get()->result_array();
	}

	public function m_registrar($data)
	{
		$this->db->insert('excursion', $data);
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
		$this->db->where('idexcursion',$id);
		return $this->db->update('excursion', $data);
	}
	public function m_editar_paquete($data,$id)
	{
		$this->db->where('idpaquete',$id);
		return $this->db->update('paquete', $data);
	}
	public function m_anular($datos){
		$data = array(
			'estado_exc' => 0,
			'fecha_anula' => date('Y-m-d H:i:s'),
			'iduser_anula' => $this->sessionCI['idusuario']
		);
		$this->db->where('idexcursion',$datos['idexcursion']);
		return $this->db->update('excursion', $data);
	}
	public function m_habilitar($id){
		$data = array(
			'estado_exc' => 1
		);
		$this->db->where('idexcursion',$id);
		if($this->db->update('excursion', $data)){
			return true;
		}else{
			return false;
		}
	}
	public function m_deshabilitar($id){
		$data = array(
			'estado_exc' => 2
		);
		$this->db->where('idexcursion',$id);
		if($this->db->update('excursion', $data)){
			return true;
		}else{
			return false;
		}
	}


}