<?php
class Model_cliente extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function m_cargar_cliente($paramPaginate=FALSE, $paramDatos){
		$this->db->select('c.idcliente, c.idusuario, c.nombres, c.apellidos, c.email, c.whatsapp, c.estado_cl, c.monedero, c.telefono, c.createdat, ac.idactividadcliente');
		$this->db->select('u.codigo, u.ididioma, c.fecha_excursion, c.fecha_salida, COUNT(a.idarchivo) as archivo');
		$this->db->select('c.hotel, c.habitacion');
		$this->db->from('cliente c');
		$this->db->join('actividad_cliente ac', 'c.idcliente = ac.idcliente');
		$this->db->join('usuario u','u.idusuario = c.idusuario AND u.estado_us = 1', 'left');
		$this->db->join('archivo a','a.idactividadcliente = ac.idactividadcliente AND a.estado_arc = 1', 'left');
		$this->db->where('c.estado_cl', 1);
		$this->db->where('ac.estado_ac', 1);
		$this->db->where('ac.idactividad', $paramDatos['filtroExcursiones']['id']);
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
		$this->db->group_by('c.idcliente,u.codigo, c.idusuario, c.nombres, c.apellidos, c.email, c.whatsapp, c.estado_cl, c.monedero,c.telefono, c.createdat, ac.idactividadcliente');
		return $this->db->get()->result_array();
	}

	public function m_count_cliente($paramPaginate=FALSE, $paramDatos){
		$this->db->select('COUNT(*) AS contador');
		$this->db->from('cliente c');
		$this->db->join('usuario u','u.idusuario = c.idusuario AND u.estado_us = 1', 'left');
		$this->db->join('actividad_cliente ac', 'c.idcliente = ac.idcliente');
		$this->db->where('ac.estado_ac', 1);
		$this->db->where('ac.idactividad', $paramDatos['filtroExcursiones']['id']);
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
		$this->db->select('c.idcliente, c.idusuario, c.nombres, c.apellidos, c.email, c.whatsapp, c.estado_cl, c.monedero,c.telefono, c.fecha_salida, c.createdat as fecha_creacion');
		$this->db->select('u.ididioma, u.solicita_bonificacion, u.estado_us, u.username, u.nombre_foto, id.nombre_id as idioma');
		$this->db->select('c.hotel, c.habitacion');
		$this->db->from('cliente c');
		$this->db->join('usuario u','c.idusuario = u.idusuario');
		$this->db->join('idioma id','u.ididioma = id.ididioma');
		$this->db->where('c.estado_cl', 1);
		$this->db->where('c.idusuario', $idusuario);
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}
	public function m_cargar_cliente_por_email($datos){
		$this->db->select('c.idcliente, c.idusuario, c.nombres, c.apellidos, c.email, c.whatsapp, c.estado_cl, c.monedero,c.telefono, c.fecha_salida, c.createdat as fecha_creacion');
		$this->db->from('cliente c');
		$this->db->where('c.estado_cl', 1);
		$this->db->where('c.email', $datos['email']);
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}
	public function m_cargar_cliente_por_sesion(){
		$this->db->select('c.idcliente, c.idusuario, c.nombres, c.apellidos, c.email, c.whatsapp, c.estado_cl, c.monedero,c.telefono, c.fecha_salida, c.createdat as fecha_creacion');
		$this->db->from('cliente c');
		$this->db->where('c.estado_cl', 1);
		$this->db->where('c.idcliente', $this->sessionCP['idcliente']);
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}
	public function m_cargar_cliente_cbo($datos){
		$this->db->select('c.idcliente, c.idusuario, c.nombres, c.apellidos, c.email, c.whatsapp, c.estado_cl, u.codigo');
		$this->db->select('u.codigo, u.ididioma, c.fecha_salida, c.monedero');
		$this->db->from('cliente c');
		$this->db->join('usuario u','u.idusuario = c.idusuario');
		$this->db->where('c.estado_cl', 1);
		$this->db->where('c.idcliente', $datos['idcliente']);

		return $this->db->get()->result_array();
	}

	// MANTENIMIENTO
	public function m_registrar_cliente($data){
		$datos = array(
			'nombres' 	 => empty($data['nombres'])? NULL : strtoupper($data['nombres']),
			'apellidos'  => empty($data['apellidos'])? NULL : strtoupper($data['apellidos']),
			'email' 	 => $data['email'],
			'telefono' 	 => empty($data['telefono']) ? NULL : $data['telefono'],
			'whatsapp' 	 => empty($data['whatsapp']) ? NULL : $data['whatsapp'],
			'hotel' 	 => empty($data['hotel']) ? NULL : $data['hotel'],
			'habitacion' 	 => empty($data['habitacion']) ? NULL : $data['habitacion'],
			'monedero' 	 => empty($data['monedero']) ? NULL : (float)$data['monedero'],
			'estado_cl'  => 1,
			// 'idactividad'=> $data['idactividad'],
			'idusuario'  => $data['idusuario'],
			'createdat'  => date('Y-m-d H:i:s'),
			'updatedat'  => date('Y-m-d H:i:s'),
			'fecha_excursion'=> date ('Y-m-d', strtotime($data['fecha_excursion'])),
			'fecha_salida'=> date ('Y-m-d', strtotime($data['fecha_salida']))
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
			'telefono' 		=> empty($data['telefono']) ? NULL : $data['telefono'],
			'whatsapp' 		=> empty($data['whatsapp']) ? NULL : $data['whatsapp'],
			'hotel' 		=> empty($data['hotel']) ? NULL : $data['hotel'],
			'habitacion' 	 => empty($data['habitacion']) ? NULL : $data['habitacion'],
			'monedero' 		=> empty($data['monedero']) ? NULL : (float)$data['monedero'],
			'updatedat' 	=> date('Y-m-d H:i:s'),
			'fecha_excursion'=> date ('Y-m-d', strtotime($data['fecha_excursion'])),
			'fecha_salida'	=> date ('Y-m-d', strtotime($data['fecha_salida']))
			// 'idactividad'	=> $data['idactividad'],

		 );
		$this->db->where('idcliente',$data['idcliente']);

		return $this->db->update('cliente', $datos);
	}
	public function m_editar_perfil_cliente($data){

		$datos = array(
			'nombres' 		=> strtoupper($data['nombres']),
			'apellidos' 	=> strtoupper($data['apellidos']),
			'telefono' 		=> empty($data['telefono']) ? NULL : $data['telefono'],
			'whatsapp' 		=> empty($data['whatsapp']) ? NULL : $data['whatsapp'],
			'hotel' 		=> empty($data['hotel']) ? NULL : $data['hotel'],
			'habitacion' 	 => empty($data['habitacion']) ? NULL : $data['habitacion'],
			'updatedat' 	=> date('Y-m-d H:i:s'),

		 );
		$this->db->where('idcliente',$data['idcliente']);

		return $this->db->update('cliente', $datos);
	}
	public function m_editar_datos_adicionales($data){

		$datos = array(
			// 'nombres' 		=> strtoupper($data['nombres']),
			// 'apellidos' 	=> strtoupper($data['apellidos']),
			// 'telefono' 		=> empty($data['telefono']) ? NULL : $data['telefono'],
			// 'whatsapp' 		=> empty($data['whatsapp']) ? NULL : $data['whatsapp'],
			'hotel' 		=> $data['hotel'],
			'habitacion' 	=> $data['habitacion'],
			'updatedat' 	=> date('Y-m-d H:i:s'),

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
	public function m_anula_actividad_cliente($data){
		$datos = array(
			'estado_ac' => 0,
		);
		$this->db->where('idcliente',$data['idcliente']);

		return $this->db->update('actividad_cliente', $datos);
	}
	public function m_registrar_actividad_cliente($data){
		// $datos = array(
		// 	'idcliente' => $data['idcliente'],
		// 	'idactividad' => $data['idactividad'],
		// );
		return $this->db->insert('actividad_cliente', $data);
	}

	public function m_actualizar_cliente_usuario($data){

		$datos = array(
			'idusuario' => (int)$data['idusuario'],
			'updatedat' => date('Y-m-d H:i:s'),
		 );
		$this->db->where('idcliente',$data['idcliente']);

		return $this->db->update('cliente', $datos);
	}

	public function m_actualizar_monedero($datos){
		$data = array(
			'monedero' => (float)$datos['monedero']
		);
		$this->db->where('idcliente',$datos['idcliente']);
		return $this->db->update('cliente', $data);
	}

	public function m_monedero_cliente_cbo($datos){
		$this->db->select('c.monedero');
		$this->db->from('cliente c');
		$this->db->where('c.estado_cl', 1);
		$this->db->where('c.idcliente', $datos['idcliente']);
		$result = $this->db->get()->row_array();
		return $result['monedero'];
	}

}