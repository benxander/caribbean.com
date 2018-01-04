<?php
class Model_movimiento extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}


	public function m_registrar_pedido($data){
		$datos = array(
			'fecha_subida' => date('Y-m-d H:i:s')
		 );
		return $this->db->insert('movimiento', $datos);
	}


}