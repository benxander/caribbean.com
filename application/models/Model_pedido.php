<?php
class Model_pedido extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function m_registrar_pedido($data){
		$datos = array(
			'idarchivo' 	 => $data['idarchivo'],
			'idcliente' 	 => $data['idcliente'],
			'idtipoproducto' => $data['idtipoproducto'],
			'cantidad' 		 => $data['cantidad'],
			'precio_unitario'=> $data['precio_unitario'],
			'fecha_pedido' => date('Y-m-d H:i:s')
		 );
		return $this->db->insert('pedido', $datos);
	}
}