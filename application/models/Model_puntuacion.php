<?php
class Model_puntuacion extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

	public function m_registrar_puntuacion($datos){
		$data = array(
			'idcliente' => $datos['idcliente'],
			'puntos' => $datos['puntos'],
			'fecha_registro' => date('Y-m-d H:i:s'),
			'comentarios' => empty($datos['comentarios']) ? NULL : $datos['comentarios']
		);

		$this->db->insert('puntuacion', $data);
   		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
}
?>