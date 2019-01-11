<?php
class Model_acceso extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
 	// ACCESO AL SISTEMA
	public function m_logging_user($data){
		$this->db->select('COUNT(*) AS logged, us.idusuario, us.estado_us, us.username, us.idgrupo, gr.nombre_gr, gr.key_grupo, ididioma, us.nombre_foto',FALSE);
		$this->db->from('usuario us');
		$this->db->join('grupo gr', 'us.idgrupo = gr.idgrupo');
		// $this->db->join('cliente cli', 'us.idusuario = cli.idusuario','left');
		$this->db->where('us.username', $data['usuario']);
		// $this->db->where('us.password', $data['clave'] );
		$this->db->where('us.password', hash('md5',$data['clave']));
		$this->db->where('us.estado_us <>', '0');
		$this->db->group_by('us.idusuario, us.estado_us, us.username, us.idgrupo, gr.nombre_gr, gr.key_grupo, ididioma, us.nombre_foto');
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}
	/**
	 * Obtiene los datos del cliente asociado a su código de pulsera
	 * o al código de la pulsera de un amigo o familiar asociado.
	 *
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function m_logging_cliente($data){
		$this->db->select('
			cli.idcliente,
			cli.monedero,
			cli.procesado,
			cli.paquete,
			cli.codigo,
			cli.precio_paquete,
			cli.nombres,
			cli.email,
			cli.ididioma
		',FALSE);
		$this->db->from('cliente cli');
		$this->db->join('dependiente de', 'cli.idcliente = de.idcliente','left');
		$this->db->where('cli.estado_cl', 1);
		$this->db->where("(cli.codigo = '".$data['codigo'] . "' OR de.codigo = '".$data['codigo'] . "')" );
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}

	public function m_registrar_sesion($data)
	{
		return $this->db->insert('cliente_sesion', $data);
	}
}
?>