<?php
class Model_Config extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function m_cargar_configuracion(){
		$this->db->select('we.idweb, we.titulo_we, we.descripcion_we, we.keywords');
		$this->db->select('we.autor_we, we.logo, we.footer_logo, we.favicon');
		$this->db->select('we.apple_icon, we.marca_agua, we.correo, we.telefono');
		$this->db->select('we.whatsapp, we.skype, we.direccion,we.latitud_gm, we.longitud_gm');

		$this->db->from('web we');
		$this->db->where('we.estado_we', 1);
		$this->db->limit(1);

		return $this->db->get()->row_array();
	}
	public function m_cargar_redes_web(){
		$this->db->select('sw.idsocialweb, sw.idredsocial, sw.enlace');
		$this->db->select('rs.nombre_rs, rs.icono_rs, rs.clase');
		$this->db->from('social_web sw');
		$this->db->join('red_social rs', 'sw.idredsocial = rs.idredsocial');
		$this->db->where_in('estado_sw', array(1,2));
		return $this->db->get()->result_array();
	}
	public function m_registrar($data){
		return $this->db->insert('web', $data);
	}

	public function m_editar($data,$id){
		$this->db->where('idweb',$id);
		return $this->db->update('web', $data);
	}
	public function m_editar_red_social($data){
		$datos = array(
			'enlace' => $data['enlace']
		);
		$this->db->where('idsocialweb',$data['id']);
		return $this->db->update('social_web', $datos);
	}




}