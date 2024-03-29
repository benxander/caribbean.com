<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_usuario extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();

	}

	public function m_cargar_usuario($paramPaginate=FALSE){
		$this->db->select('u.idusuario, u.username, u.solicita_bonificacion, u.estado_us, u.password');
		$this->db->select('gr.idgrupo, gr.nombre_gr');
		// $this->db->select('id.ididioma, id.nombre_id');
		$this->db->join('grupo gr','gr.idgrupo = u.idgrupo');
		// $this->db->join('idioma id','id.ididioma = u.ididioma');
		$this->db->from('usuario u');
		$this->db->where('u.estado_us <>', 0);
		if($this->sessionCI['key_grupo'] != 'key_root'){
			$this->db->where_not_in('u.idgrupo', array(1,3));
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

	public function m_count_usuario($paramPaginate=FALSE){
		$this->db->select('COUNT(*) AS contador');
		$this->db->from('usuario u');
		$this->db->where('u.estado_us <>', 0);
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

	public function m_cargar_grupo_cbo(){
		$this->db->select("idgrupo, nombre_gr");
		$this->db->from('grupo');
		$this->db->where('key_grupo <>', 'key_root');
		$this->db->where('key_grupo <>', 'key_cliente');
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

		$datos = array(
			'idgrupo' => $data['idgrupo'],
			'username' =>$data['username'],
			'password' => hash('md5',$data['password']),
			// 'ididioma' => empty($data['ididioma'])? NULL : $data['ididioma'],
			// 'solicita_bonificacion' => 2,
			'estado_us' => 1,
			'createdat' => date('Y-m-d H:i:s'),
			'updatedat' => date('Y-m-d H:i:s'),
		);

		$this->db->insert('usuario', $datos);
   		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	/*public function m_registrar_usuario_cliente($data){

		$datos = array(
			'idgrupo' => 3,
			'username' => empty($data['email'])? NULL : $data['email'],
			'password' => hash('md5',$data['codigo']),
			'ididioma' => empty($data['ididioma'])? NULL : $data['ididioma'],
			'solicita_bonificacion' => 2,
			'estado_us' => 1,
			'createdat' => date('Y-m-d H:i:s'),
			'updatedat' => date('Y-m-d H:i:s'),
			// 'codigo' => $data['codigo']
		);

		$this->db->insert('usuario', $datos);
   		$insert_id = $this->db->insert_id();
		return $insert_id;
	}*/

	public function m_editar_usuario($data){
		$datos = array(
			'idgrupo' => $data['idgrupo'],
			'username' => $data['username'],
			'updatedat' => date('Y-m-d H:i:s'),
		);
		if(!empty($data['password'])){
			$datos['password'] = hash('md5',$data['password']);
		}
		$this->db->where('idusuario',$data['idusuario']);

		return $this->db->update('usuario', $datos);
	}

	public function m_editar_idioma_usuario($datos){
		$data = array(
			'ididioma' => $datos['ididioma'],
			'updatedat' => date('Y-m-d H:i:s'),
		);
		$this->db->where('idusuario',$datos['idusuario']);
		return $this->db->update('usuario', $data);
	}

	public function m_editar_clave_usuario($datos){
		$data = array(
			'password' => hash('md5',$data['password']),
			'updatedat' => date('Y-m-d H:i:s'),
		);
		$this->db->where('idusuario',$datos['idusuario']);
		return $this->db->update('usuario', $data);
	}

	public function m_editar_usuario_cliente($data){

		$datos = array(
			'username' => $data['email'],
			'password' => hash('md5',$data['codigo']),
			'ididioma' => $data['ididioma'],
			'codigo' => $data['codigo'],
			'updatedat' => date('Y-m-d H:i:s'),
		);
		$this->db->where('idusuario',$data['idusuario']);

		return $this->db->update('usuario', $datos);
	}
	public function m_anular_usuario($data){
		$datos = array(
			'estado_us' => 0,
			'updatedat' => date('Y-m-d H:i:s')
		);
		$this->db->where('idusuario',$data['idusuario']);

		return $this->db->update('usuario', $datos);
	}

	public function m_consultar_usuario($data){
		$this->db->select("idusuario");
		$this->db->from('usuario');
		$this->db->where("estado_us <>",0);
		$this->db->where("idusuario", $data['idusuario']);
		return $this->db->get()->result_array();
	}

	public function m_habilitar($id)
	{
		$data = array(
			'estado_us' => 1
		);
		$this->db->where('idusuario',$id);
		if($this->db->update('usuario', $data)){
			return true;
		}else{
			return false;
		}
	}
	public function m_deshabilitar($id)
	{
		$data = array(
			'estado_us' => 2
		);
		$this->db->where('idusuario',$id);
		if($this->db->update('usuario', $data)){
			return true;
		}else{
			return false;
		}
	}

	public function m_verificar_codigo_usuario($codigo){
		$this->db->select('*');
		$this->db->from('usuario');
		$this->db->where('codigo', $codigo);
		$this->db->where('estado_us', 1);
		$this->db->limit(1);
		if ( $this->db->get()->num_rows() > 0 ){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function m_editar_foto($datos){
		$data = array(
			'nombre_foto' => $datos['nombre_foto'],
			'updatedAt' => date('Y-m-d H:i:s')
		);
		$this->db->where('idusuario',$datos['idusuario']);
		return $this->db->update('usuario', $data);
	}
}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */