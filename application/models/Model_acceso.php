<?php
class Model_acceso extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
 	// ACCESO AL SISTEMA
	public function m_logging_user($data){
		$this->db->select('COUNT(*) AS logged, us.idusuario, us.estado_us, us.username, us.idgrupo, gr.nombre_gr, gr.key_grupo, ididioma',FALSE);
		$this->db->from('usuario us');
		$this->db->join('grupo gr', 'us.idgrupo = gr.idgrupo');
		$this->db->join('cliente cli', 'us.idusuario = cli.idusuario','left');
		$this->db->where('us.username', $data['usuario']);
		// $this->db->where('us.password', $data['clave'] );
		$this->db->where('us.password', hash('md5',$data['clave']));
		$this->db->where('us.estado_us <>', '0');
		$this->db->group_by('us.idusuario');
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}
}
?>