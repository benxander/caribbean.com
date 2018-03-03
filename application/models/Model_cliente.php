<?php
class Model_cliente extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function m_cargar_cliente($paramPaginate=FALSE, $paramDatos){
		/*subquery*/
		$this->db->select('c.idcliente, c.monedero, c.codigo, c.fecha_excursion');
		$this->db->select('COUNT(a.idarchivo) as total_subido, exc.idexcursion, exc.descripcion, estado_cl');
		$this->db->select("SUM(CASE WHEN a.descargado = 1 THEN 1 ELSE 0 END) comprados",FALSE);
		$this->db->select("( SELECT sum(mo.total) FROM movimiento mo WHERE mo.estado = 1 AND mo.idcliente = c.idcliente ) as monto", FALSE);
		$this->db->select('ev.idexcursionvideo');
		$this->db->from('cliente c');
		$this->db->join('excursion exc', 'c.idexcursion = exc.idexcursion');
		$this->db->join('excursion_video ev', 'c.idexcursion = ev.idexcursion AND ev.fecha = c.fecha_excursion','left');
		$this->db->join('archivo a','a.idcliente = c.idcliente AND a.estado_arc = 1', 'left');
		$this->db->where('c.estado_cl', 1);
		$this->db->group_by('c.idcliente');
		$subQuery1 = $this->db->get_compiled_select();

		/*principal*/
		$this->db->select('foo.idcliente, foo. codigo, foo.idexcursion, foo.fecha_excursion');
		$this->db->select('foo.descripcion, foo.monedero, foo.total_subido, foo.comprados');
		$this->db->select('foo.monto, foo.idexcursionvideo, foo.estado_cl');
		$this->db->select("CASE WHEN total_subido = 0 THEN 'NO PROCESADO' ELSE (
			CASE WHEN monedero = 0 AND comprados = 0 THEN 'NO PAGO' ELSE (
				CASE WHEN (monedero = 0 AND comprados > 0 AND comprados < total_subido) OR
									(monedero > 0 AND comprados >= 0 AND comprados < total_subido) THEN 'PENDIENTE' ELSE (
					CASE WHEN comprados = total_subido THEN 'COMPLETO' ELSE 'OTRO' END
				) END
			) END
		) END AS procesado", FALSE);
		$this->db->from('('.$subQuery1 .') as foo');


		if($paramDatos['filtroExcursiones']['id'] != 0){
			$this->db->where('foo.idexcursion', $paramDatos['filtroExcursiones']['id']);
		}
		if($paramDatos['filtroProcesados']['id'] != 0){
			$this->db->where("CASE WHEN total_subido = 0 THEN 'NO PROCESADO' ELSE (
			CASE WHEN monedero = 0 AND comprados = 0 THEN 'NO PAGO' ELSE (
				CASE WHEN (monedero = 0 AND comprados > 0 AND comprados < total_subido) OR
										(monedero > 0 AND comprados >= 0 AND comprados < total_subido) THEN 'PENDIENTE' ELSE (
						CASE WHEN comprados = total_subido THEN 'COMPLETO' ELSE 'OTRO' END
					) END
				) END
			) END = '", $paramDatos['filtroProcesados']['descripcion']."'",FALSE);
		}
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

	public function m_count_cliente($paramPaginate=FALSE, $paramDatos){
		/*subquery*/
		$this->db->select('c.idcliente, c.monedero, c.codigo, c.fecha_excursion');
		$this->db->select('COUNT(a.idarchivo) as total_subido, exc.idexcursion, exc.descripcion, estado_cl');
		$this->db->select("SUM(CASE WHEN a.descargado = 1 THEN 1 ELSE 0 END) comprados",FALSE);
		$this->db->select("( SELECT sum(mo.total) FROM movimiento mo WHERE mo.estado = 1 AND mo.idcliente = c.idcliente ) as monto", FALSE);
		$this->db->from('cliente c');
		$this->db->join('excursion exc', 'c.idexcursion = exc.idexcursion');
		$this->db->join('archivo a','a.idcliente = c.idcliente AND a.estado_arc = 1', 'left');
		$this->db->where('c.estado_cl', 1);
		$this->db->group_by('c.idcliente');
		$subQuery1 = $this->db->get_compiled_select();

		$this->db->select('COUNT(*) AS contador');
		$this->db->from('('.$subQuery1 .') as foo');

		if($paramDatos['filtroExcursiones']['id'] != 0){
			$this->db->where('foo.idexcursion', $paramDatos['filtroExcursiones']['id']);
		}
		if($paramDatos['filtroProcesados']['id'] != 0){
			$this->db->where("CASE WHEN total_subido = 0 THEN 'NO PROCESADO' ELSE (
			CASE WHEN monedero = 0 AND comprados = 0 THEN 'NO PAGO' ELSE (
				CASE WHEN (monedero = 0 AND comprados > 0 AND comprados < total_subido) OR
										(monedero > 0 AND comprados >= 0 AND comprados < total_subido) THEN 'PENDIENTE' ELSE (
						CASE WHEN comprados = total_subido THEN 'COMPLETO' ELSE 'OTRO' END
					) END
				) END
			) END = '", $paramDatos['filtroProcesados']['descripcion']."'",FALSE);
		}
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
		$this->db->select('c.idcliente, c.nombres, c.apellidos, c.email, c.whatsapp, c.estado_cl, c.monedero,c.telefono, c.fecha_salida, c.createdat as fecha_creacion');
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
	public function m_cargar_cliente_por_codigo($codigo){
		$this->db->select('c.idcliente, c.estado_cl, c.monedero, c.idexcursion, c.createdat as fecha_creacion');
		$this->db->from('cliente c');
		$this->db->where('c.estado_cl', 1);
		$this->db->where('c.codigo', $codigo);
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}
	public function m_cargar_cliente_por_email($datos){
		$this->db->select('c.idcliente, c.nombres, c.apellidos, c.email, c.whatsapp, c.estado_cl, c.monedero,c.telefono, c.fecha_salida, c.createdat as fecha_creacion');
		$this->db->from('cliente c');
		$this->db->where('c.estado_cl', 1);
		$this->db->where('c.email', $datos['email']);
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}
	public function m_cargar_cliente_por_sesion(){
		$this->db->select('c.idcliente, c.estado_cl, c.monedero, c.createdat as fecha_creacion, c.codigo');
		$this->db->from('cliente c');
		// $this->db->join('usuario u','u.idusuario = c.idusuario');
		$this->db->where('c.estado_cl', 1);
		$this->db->where('c.idcliente', $this->sessionCP['idcliente']);
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}
	public function m_cargar_cliente_cbo($datos){
		$this->db->select('c.idcliente, c.nombres, c.apellidos, c.email, c.whatsapp, c.estado_cl, u.codigo');
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
			'codigo'	 => $data['codigo'],
			'monedero' 	 => empty($data['monedero']) ? '0' : (float)$data['monedero'],
			'iduser_reg'  => $this->sessionCP['idusuario'],
			'createdat'  => date('Y-m-d H:i:s'),
			'updatedat'  => date('Y-m-d H:i:s'),
			'idexcursion'	 => $data['excursion']['id'],
			'fecha_excursion'=> empty($data['fecha_excursion'])? date('Y-m-d') : date ('Y-m-d', strtotime($data['fecha_excursion'])),
			'estado_cl'  => 1,

			// 'fecha_salida'=> date ('Y-m-d', strtotime($data['fecha_salida']))
		 );
		$this->db->insert('cliente', $datos);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function m_editar_cliente($data){

		$datos = array(
			'monedero' 		=> empty($data['monedero']) ? '0' : (float)$data['monedero'],
			'updatedat' 	=> date('Y-m-d H:i:s'),
			'fecha_excursion'=> date ('Y-m-d', strtotime($data['fecha_excursion'])),
			// 'idexcursion'	=> $data['idexcursion'],

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
		// 	'idexcursion' => $data['idexcursion'],
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