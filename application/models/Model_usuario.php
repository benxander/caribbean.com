<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_usuario extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();

	}
	public function m_registrar_usuario($data){
		return $this->db->insert('users', $data);
	}

}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */