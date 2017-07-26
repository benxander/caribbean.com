<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();

	}
	public function m_registrar_usuario($data){
		return $this->db->insert('users', $data);
	}
	public function m_verificar_usuario_social_existe($social_id)
	{
		$this->db->where('user_social_id', (int) $social_id);
		$this->db->from('users');
		return $this->db->count_all_results();
	}
}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */