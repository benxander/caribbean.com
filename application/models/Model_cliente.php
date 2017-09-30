<?php
class Model_cliente extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function m_cargar_cliente($paramPaginate=FALSE){
		$this->db->select('c.idcliente, c.idusuario, c.nombres, c.apellidos, c.email, c.whatsapp, c.estado_cl');
		$this->db->select('u.codigo, u.ididioma, c.fecha_final, COUNT(a.idarchivo) as archivo');
		$this->db->from('cliente c');
		$this->db->join('usuario u','u.idusuario = c.idusuario AND u.estado_us = 1', 'left');
		$this->db->join('archivo a','a.idcliente = c.idcliente AND a.estado_arc = 1', 'left');
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
		$this->db->group_by('c.idcliente,u.codigo');
		return $this->db->get()->result_array();
	}

	public function m_count_cliente($paramPaginate=FALSE){
		$this->db->select('COUNT(*) AS contador');
		$this->db->from('cliente c');
		$this->db->join('usuario u','u.idusuario = c.idusuario AND u.estado_us = 1', 'left');
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
	public function m_cargar_cliente_cbo($datos){
		$this->db->select('c.idcliente, c.idusuario, c.nombres, c.apellidos, c.email, c.whatsapp, c.estado_cl, u.codigo');
		$this->db->select('u.codigo, u.ididioma, u.fecha_final');
		$this->db->from('cliente c');
		$this->db->join('usuario u','u.idusuario = c.idusuario');
		$this->db->where('c.estado_cl', 1);
		$this->db->where('c.idcliente', $datos['idcliente']);

		return $this->db->get()->result_array();
	}

	// MANTENIMIENTO
	public function m_registrar_cliente($data){
		$datos = array(
			'nombres' 		 => strtoupper($data['nombres']),
			'apellidos' 	=> strtoupper($data['apellidos']),
			'email' 		=> $data['email'],
			'whatsapp' 		=> empty($data['whatsapp']) ? NULL : $data['whatsapp'],
			'estado_cl' 	=> 1,
			'idusuario' 	=> $data['idusuario'],
			'createdat' 	=> date('Y-m-d H:i:s'),
			'updatedat' 	=> date('Y-m-d H:i:s'),
			'fecha_final' 	=> date ('Y-m-d H:i:s', strtotime($data['fecha']))
		 );
		$this->db->insert('cliente', $datos);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function m_editar_cliente($data){

		$datos = array(
			'nombres' 		=> strtoupper($data['nombres']),
			'apellidos' 	=> strtoupper($data['apellidos']),
			'email' 		=> $data['email'],
			'whatsapp' 		=> empty($data['whatsapp']) ? NULL : $data['whatsapp'],
			'updatedat' 	=> date('Y-m-d H:i:s'),
			'fecha_final'	=> $data['fecha'],

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
			'idusuario' => (int)$data['idusuario'],
			'updatedat' => date('Y-m-d H:i:s'),
		 );
		$this->db->where('idcliente',$data['idcliente']);

		return $this->db->update('cliente', $datos);
	}

}