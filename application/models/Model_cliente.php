<?php
class Model_cliente extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function m_cargar_cliente($paramPaginate=FALSE, $paramDatos){
		/*subquery*/
		$this->db->select("
			c.idcliente,
			c.monedero,
			c.deposito,
			c.codigo,
			c.fecha_excursion,
			c.paquete,
			c.procesado,
			c.precio_paquete,
			c.email,
			c.estado_cl,
			exc.idexcursion,
			exc.descripcion,
			COUNT(a.idarchivo) as total_subido,
			(SELECT nombre_archivo FROM archivo arc WHERE arc.idcliente = c.idcliente AND arc.tipo_archivo = 2 AND arc.estado_arc = 1 LIMIT 1) AS nombre_video,
			SUM(CASE WHEN a.descargado = 1 THEN 1 ELSE 0 END) AS comprados,
			( SELECT sum(mo.total) FROM movimiento mo WHERE mo.estado = 1 AND mo.idcliente = c.idcliente ) AS monto,
			( SELECT MAX(DATE(mo.fecha_movimiento)) FROM movimiento mo WHERE mo.estado = 1 AND mo.idcliente = c.idcliente ) AS fecha_movimiento,
			( SELECT sum(mo.total) FROM movimiento mo WHERE mo.estado = 1 AND mo.idcliente = c.idcliente ) - c.deposito AS online

		",FALSE);


		$this->db->from('cliente c');
		$this->db->join('excursion exc', 'c.idexcursion = exc.idexcursion');
		// $this->db->join('excursion_video ev', 'c.idexcursion = ev.idexcursion AND ev.fecha = c.fecha_excursion','left');
		$this->db->join('archivo a','a.idcliente = c.idcliente AND a.estado_arc = 1 AND a.tipo_archivo = 1', 'left');
		$this->db->where('c.estado_cl', 1);
		$this->db->group_by('c.idcliente');
		$subQuery1 = $this->db->get_compiled_select();

		/*principal*/
		$this->db->select('
			foo.idcliente,
			foo. codigo,
			foo.idexcursion,
			foo.fecha_excursion,
			foo.paquete,
			foo.precio_paquete,
			foo.email,
			foo.descripcion,
			foo.monedero,
			foo.deposito,
			foo.procesado,
			foo.total_subido,
			foo.comprados,
			foo.monto,
			foo.fecha_movimiento,
			foo.online,
			foo.estado_cl,
			foo.nombre_video
		');
		$this->db->select("CASE WHEN total_subido = 0 THEN 'NO PROCESADO' ELSE (
			CASE WHEN deposito = 0 AND comprados = 0 THEN 'NO PAGO' ELSE (
				CASE WHEN (monedero = 0 AND comprados > 0 AND comprados < total_subido) OR
									(monedero > 0 AND comprados >= 0 AND comprados < total_subido) THEN 'PENDIENTE' ELSE (
					CASE WHEN (comprados = total_subido) OR procesado = 4 THEN 'COMPLETO' ELSE 'OTRO' END
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
			if(!empty($paramDatos['origen']) && $paramDatos['origen'] == 'reporte' ){

			}else{
				if( $paramPaginate['firstRow'] || $paramPaginate['pageSize'] ){
					$this->db->limit($paramPaginate['pageSize'],$paramPaginate['firstRow'] );
				}
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
		$this->db->select("( SELECT MAX(DATE(mo.fecha_movimiento)) FROM movimiento mo WHERE mo.estado = 1 AND mo.idcliente = c.idcliente ) as fecha_movimiento", FALSE);
		$this->db->from('cliente c');
		$this->db->join('excursion exc', 'c.idexcursion = exc.idexcursion');
		$this->db->join('archivo a','a.idcliente = c.idcliente AND a.estado_arc = 1 AND a.tipo_archivo = 1', 'left');
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
	public function m_listar_cliente_procesado($datos){
		$this->db->select('
			SUM(CASE WHEN a.descargado = 1 THEN 1 ELSE 0 END) AS comprados,
			COUNT(a.idarchivo) AS total_subido
		', FALSE);
		$this->db->from('cliente c');
		$this->db->join('archivo a','a.idcliente = c.idcliente AND a.estado_arc = 1 AND a.tipo_archivo = 1', 'left');// solo imagenes
		$this->db->where('c.idcliente', $datos['idcliente']);
		return $this->db->get()->row_array();
	}
	public function m_cargar_cliente_por_codigo($codigo){
		$this->db->select('
			c.idcliente,
			c.codigo,
			c.estado_cl,
			c.monedero,
			c.idexcursion,
			c.paquete,
			c.precio_paquete,
			c.deposito,
			c.procesado,
			c.createdat as fecha_creacion
		');
		$this->db->from('cliente c');
		$this->db->join('dependiente d', 'c.idcliente = d.idcliente','left');
		$this->db->where('c.estado_cl', 1);
		$this->db->where("(c.codigo = '". $codigo . "' OR d.codigo = '". $codigo . "')", NULL, FALSE );
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}
	public function m_cargar_clientes_email($datos){
		$desde = $this->db->escape(darFormatoYMD($datos['fDesde']));
		$hasta = $this->db->escape(darFormatoYMD($datos['fHasta']));
		$this->db->select('
			c.idcliente,
			c.codigo,
			c.estado_cl,
			c.monedero,
			c.idexcursion,
			c.paquete,
			c.email,
			c.precio_paquete,
			c.deposito,
			c.procesado,
			c.fecha_excursion,
			ex.descripcion AS excursion
		');
		$this->db->from('cliente c');
		$this->db->join('excursion ex', 'c.idexcursion = ex.idexcursion');
		$this->db->where('c.estado_cl <>', 0);
		$this->db->where('c.email IS NOT NULL');
		$this->db->where('c.fecha_excursion BETWEEN '. $desde.' AND ' . $hasta);
		$this->db->order_by('c.fecha_excursion', 'ASC');
		return $this->db->get()->result_array();
	}
	public function m_cargar_codigos_cliente($datos){
		$this->db->select('dep.iddependiente, dep.codigo, dep.idcliente');
		$this->db->from('dependiente dep');
		$this->db->where('dep.idcliente', $datos['idcliente']);
		return $this->db->get()->result_array();
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
		$this->db->select('
			c.idcliente,
			c.estado_cl,
			c.monedero,
			c.createdat as fecha_creacion,
			c.codigo,
			c.procesado,
			c.verifica_email
		');
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
			'deposito' 	 => empty($data['monedero']) ? '0' : (float)$data['monedero'],
			'iduser_reg'  => $this->sessionCI['idusuario'],
			'createdat'  => date('Y-m-d H:i:s'),
			'updatedat'  => date('Y-m-d H:i:s'),
			'idexcursion'	=> $data['excursion']['id'],
			'paquete'	 	=> $data['paquete'],
			'precio_paquete' => $data['precio_paquete'],
			'precio_adicional' 	 => empty($data['precio_adicional']) ? NULL : (float)$data['precio_adicional'],
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
			'deposito' 		=> empty($data['monedero']) ? '0' : (float)$data['monedero'],
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
	public function m_actualizar_procesado($datos){
		$data = array(
			'procesado' => $datos['procesado'],
			'monedero' 	=> 0
		);
		$this->db->where('idcliente',$datos['idcliente']);
		return $this->db->update('cliente', $data);
	}
/*	public function m_actualizar_monedero_procesado($datos){
		$data = array(
			'monedero' => (float)$datos['monedero'],
			'procesado' => ($datos['tipo_pack'] == 1)? 4 : 3
		);
		$this->db->where('idcliente',$datos['idcliente']);
		return $this->db->update('cliente', $data);
	}*/

	public function m_monedero_cliente_cbo($datos){
		$this->db->select('c.monedero');
		$this->db->from('cliente c');
		$this->db->where('c.estado_cl', 1);
		$this->db->where('c.idcliente', $datos['idcliente']);
		$result = $this->db->get()->row_array();
		return $result['monedero'];
	}
	/* CODIGOS DEPENDIENTES */
	public function m_registrar_codigo_dep($data){
		$datos = array(
			'idcliente'	 => $data['idcliente'],
			'codigo'	 => $data['codigo'],
		 );
		$this->db->insert('dependiente', $datos);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	public function m_editar_codigo_dependiente($data){
		$datos = array(
			'codigo' => $data['codigo'],
		);
		$this->db->where('iddependiente',$data['iddependiente']);
		return $this->db->update('dependiente', $datos);
	}
	public function m_eliminar_codigo_dependiente($data){
		$this->db->where('iddependiente',$data['iddependiente']);
		return $this->db->delete('dependiente');
	}
	public function m_actualizar_email($datos){
		$data = array(
			'email' => $datos['email'],
			'solicita_bonificacion' => 1
		);
		$this->db->where('idcliente',$datos['imagen']['idcliente']);
		return $this->db->update('cliente', $data);
	}
	public function m_actualizar_verificacion($datos){
		$data = array(
			'verifica_email' => $datos['verifica_email'],
		);
		$this->db->where('idcliente',$datos['idcliente']);
		return $this->db->update('cliente', $data);
	}
	public function m_verificar_cliente($datos)
	{
		$this->db->select('
			c.idcliente,
			c.codigo,
			c.verifica_email,
			arc.idarchivo,
			arc.nombre_archivo,
			arc.descargado,
			arc.es_bonificacion
		');
		$this->db->from('cliente c');
		$this->db->join('archivo arc', 'c.idcliente = arc.idcliente');
		$this->db->where('c.estado_cl', 1);
		$this->db->where('MD5(c.idcliente)', $datos['idcliente_enc']);
		$this->db->where('MD5(arc.idarchivo)', $datos['idarchivo_enc']);
		$this->db->where('solicita_bonificacion', 1);
		// $this->db->where('verifica_email', 2);
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}
	/**
	 * Lista los clientes cuya fecha de excursion fue hace $dias dias y
	 * que ya no deberian estar en el sistema.
	 *
	 * @param  string $dias
	 * @return array
	 */
	public function m_clientes_para_eliminar($dias)
	{
		$this->db->select('
			c.idcliente,
			c.codigo,
			c.fecha_excursion
		');
		$this->db->from('cliente c');
		$this->db->where('DATEDIFF(CURDATE(), c.fecha_excursion) > '. $dias);
		$this->db->where('estado_cl', '1');
		return $this->db->get()->result_array();
	}
	/**
	 * Lista de clientes con la cantidad de sesiones realizadas y la ultima fecha de acceso
	 *
	 * @return [type] [description]
	 */
	public function m_listar_sesiones_cliente($paramPaginate,$paramDatos)
	{
		$this->db->select("
			cli.idcliente,
			cli.codigo,
			cli.email,
			cli.fecha_excursion,
			cli.idexcursion,
			ex.descripcion AS excursion,
			MAX(cs.fecha_hora) AS fecha,
			count(*) cantidad
		",FALSE);
		$this->db->from('cliente cli');
		$this->db->join('cliente_sesion cs', 'cli.idcliente = cs.idcliente');
		$this->db->join('excursion ex', 'cli.idexcursion = ex.idexcursion');
		if( $paramDatos['filtroExcursiones']['id'] != 0 ){
			$this->db->where('cli.idexcursion', $paramDatos['filtroExcursiones']['id']);
		}

		if( isset($paramPaginate['search'] ) && $paramPaginate['search'] ){
			foreach ($paramPaginate['searchColumn'] as $key => $value) {
				if(! empty($value)){
					$this->db->like($key ,strtoupper($value) ,FALSE);
				}
			}
		}
		$this->db->group_by('cli.idcliente');
		$this->db->group_by('ex.idexcursion');

		if( $paramPaginate['sortName'] ){
			$this->db->order_by($paramPaginate['sortName'], $paramPaginate['sort']);
		}

		if( $paramPaginate['firstRow'] || $paramPaginate['pageSize'] ){
			$this->db->limit($paramPaginate['pageSize'],$paramPaginate['firstRow'] );
		}



		return $this->db->get()->result_array();
	}
	public function m_count_sesiones_cliente($paramPaginate,$paramDatos)
	{
		$this->db->select("
			cli.idcliente,
			cli.codigo,
			cli.email,
			cli.fecha_excursion,
			cli.idexcursion,
			ex.descripcion AS excursion,
			MAX(cs.fecha_hora) AS fecha,
			count(*) cantidad
		",FALSE);
		$this->db->from('cliente cli');
		$this->db->join('cliente_sesion cs', 'cli.idcliente = cs.idcliente');
		$this->db->join('excursion ex', 'cli.idexcursion = ex.idexcursion');
		if( $paramDatos['filtroExcursiones']['id'] != 0 ){
			$this->db->where('cli.idexcursion', $paramDatos['filtroExcursiones']['id']);
		}

		if( isset($paramPaginate['search'] ) && $paramPaginate['search'] ){
			foreach ($paramPaginate['searchColumn'] as $key => $value) {
				if(! empty($value)){
					$this->db->like($key ,strtoupper($value) ,FALSE);
				}
			}
		}
		$this->db->group_by('cli.idcliente');
		$this->db->group_by('ex.idexcursion');
		$subQuery = $this->db->get_compiled_select();

		$this->db->select('COUNT(*) AS contador');
		$this->db->from('('.$subQuery .') as foo');


		$this->db->limit(1);
		$fData = $this->db->get()->row_array();
		return $fData;
	}

	public function m_listar_detalle_sesiones($paramPaginate, $paramDatos)
	{
		$this->db->select("
			idclientesesion,
			idcliente,
			DATE_FORMAT(fecha_hora,'%d-%m-%Y') AS fecha,
			DATE_FORMAT(fecha_hora,'%H:%i:%s') AS hora,
			ip
		",FALSE);
		$this->db->from('cliente_sesion');
		$this->db->where('idcliente', $paramDatos['idcliente']);
		if( $paramPaginate['sortName'] ){
			$this->db->order_by($paramPaginate['sortName'], $paramPaginate['sort']);
		}
		return $this->db->get()->result_array();
	}

	public function m_listar_detalle_descarga($paramPaginate, $paramDatos)
	{
		$this->db->select("
			idarchivo,
			nombre_archivo,
			DATE_FORMAT(fecha_descarga,'%d-%m-%Y') AS fecha_descarga,
			DATE_FORMAT(fecha_descarga,'%H:%i:%s') AS hora_descarga,
			es_bonificacion,
			size
		",FALSE);
		$this->db->from('archivo');
		$this->db->where('idcliente', $paramDatos['idcliente']);
		$this->db->where('estado_arc', 1);
		$this->db->where('descargado', 1);
		if( $paramPaginate['sortName'] ){
			$this->db->order_by($paramPaginate['sortName'], $paramPaginate['sort']);
		}
		return $this->db->get()->result_array();
	}
}