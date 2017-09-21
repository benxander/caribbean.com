<?php
class Model_cliente extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function m_cargar_cliente($paramPaginate=FALSE){
		$this->db->select('c.idcliente, c.idusuario, c.nombres, c.apellidos, c.email, c.whatsapp, c.estado_cl');
		$this->db->from('cliente c');
		$this->db->where('c.estado_cl', 1);
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

	public function m_count_cliente($paramPaginate=FALSE){
		$this->db->select('COUNT(*) AS contador');
		$this->db->from('cliente c');
		$this->db->where('c.estado_cl', 1);
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

	public function m_cargar_cliente_por_idusuario($idusuario){
		$this->db->select('c.idcliente, c.idusuario, c.nombres, c.apellidos, c.email, c.whatsapp, c.estado_cl');
		$this->db->select('u.ididioma, u.solicita_bonificacion, u.estado_us, u.username, u.nombre_foto, id.nombre_id as idioma');
		$this->db->from('cliente c');
		$this->db->join('usuario u','c.idusuario = u.idusuario');
		$this->db->join('idioma id','u.ididioma = id.ididioma');
		$this->db->where('c.estado_cl', 1);
		$this->db->where('c.idusuario', $idusuario);
		$this->db->limit(1);

		return $this->db->get()->row_array();
	}

	// MANTENIMIENTO
	public function m_registrar_cliente($data){
		$datos = array(			
			'nombres' => strtoupper($data['nombres']),
			'apellidos' => strtoupper($data['apellidos']),
			'email' => $data['email'],
			'whatsapp' => empty($data['whatsapp']) ? NULL : $data['whatsapp'],
			'estado_cl' => 1,
			'createdat' => date('Y-m-d H:i:s'),
			'updatedat' => date('Y-m-d H:i:s'),
		 );
		return $this->db->insert('cliente', $datos);
	}

	public function m_editar_cliente($data){
		$datos = array(			
			'nombres' => strtoupper($data['nombres']),
			'apellidos' => strtoupper($data['apellidos']),
			'email' => $data['email'],
			'whatsapp' => empty($data['whatsapp']) ? NULL : $data['whatsapp'],
			'updatedat' => date('Y-m-d H:i:s'),
		 );
		$this->db->where('idcliente',$data['idcliente']);

		return $this->db->update('cliente', $datos);
	}

	public function m_anular_cliente($data){
		$datos = array(
			'estado_cl' => 0,
			'updatedat' => date('Y-m-d H:i:s')
		);
		$this->db->where('idcliente',$data['idcliente']);

		return $this->db->update('cliente', $datos);
	}

	public function m_actualizar_cliente_usuario($data){
		$datos = array(			
			'idusuario' => $data['idusuario'],
			'updatedat' => date('Y-m-d H:i:s'),
		 );
		$this->db->where('idcliente',$data['idcliente']);

		return $this->db->update('cliente', $datos);	
	}
}