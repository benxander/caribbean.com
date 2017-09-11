<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_usuario extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();

	}

	public function m_cargar_grupo_cbo(){
		$this->db->select("idgrupo, nombre_gr");
		$this->db->from('grupo');
		$this->db->where("estado_gr",1);
		
		return $this->db->get()->result_array();
	}

	public function m_cargar_idioma_cbo(){
		$this->db->select("ididioma, nombre_id");
		$this->db->from('idioma');
		$this->db->where("estado_id",1);

		return $this->db->get()->result_array();
	}

	public function m_registrar_usuario($data){
		return $this->db->insert('users', $data);
	}

}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */