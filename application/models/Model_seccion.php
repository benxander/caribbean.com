<?php
class Model_seccion extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function m_cargar_seccion_cbo(){
		$this->db->select("idseccion, descripcion_se");
		$this->db->from('seccion se');
		$this->db->where("se.estado_se",1);
		// $this->db->where("UPPER(a.nombre) LIKE '%". strtoupper($datos['search']) . "%'");
		// $this->db->limit(10);
		return $this->db->get()->result_array();
	}
	public function m_cargar_tipo_iconos_cbo(){
		$this->db->select("idtipoicono, descripcion");
		$this->db->from('tipo_icono');
		return $this->db->get()->result_array();
	}
	public function m_cargar_iconos_cbo($datos){
		$this->db->select("idicono, descripcion, icono");
		$this->db->from('icono ico');
		$this->db->where("ico.idtipoicono",$datos['tipoIcono']['id']);
		if(!empty($datos['search'])){
			$this->db->where("UPPER(ico.icono) LIKE '%". strtoupper($datos['search']) . "%'");
			$this->db->limit(10);
		}
		$this->db->order_by('descripcion','ASC');
		return $this->db->get()->result_array();
	}
	public function m_cargar_secciones($paramPaginate=FALSE){
		$this->db->select('se.idseccion, se.descripcion_se AS seccion, sc.titulo, sc.subtitulo');
		$this->db->select('sc.idseccioncontenido, sc.contenido, sc.tiene_boton, sc.nombre_boton, sc.enlace_boton, tipo_contenido');
		$this->db->select('sc.acepta_imagen, sc.imagen, sc.acepta_background, sc.imagen_bg, acepta_ficha, sc.ficha_galeria');
		$this->db->from('seccion se');
		$this->db->join('seccion_contenido sc','se.idseccion = sc.idseccion');
		$this->db->where("se.estado_se",1);
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
	public function m_cargar_Seccion($datos){
		$this->db->select('idseccion, titulo, contenido');
		$this->db->from('seccion_contenido');
		$this->db->where('idseccion', $datos['idseccion']);
		$fData = $this->db->get()->row_array();
		return $fData;
	}
	public function m_count_secciones($paramPaginate=FALSE){
		$this->db->select('COUNT(*) AS contador');
		$this->db->from('seccion se');
		$this->db->join('seccion_contenido sc','se.idseccion = sc.idseccion');
		$this->db->where("se.estado_se",1);
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
	public function m_cargar_secciones_web(){
		$this->db->select('se.idseccion, se.descripcion_se AS seccion, sc.titulo, sc.subtitulo');
		$this->db->select('sc.idseccioncontenido, sc.contenido, sc.tiene_boton, sc.nombre_boton, sc.enlace_boton, sc.ficha_galeria');
		$this->db->select('sc.acepta_imagen, sc.imagen, sc.acepta_background, sc.imagen_bg, sc.acepta_ficha');
		$this->db->select('idficha, titulo_fi, descripcion_corta, descripcion_fi, icono_fi, codigo_youtube, codigo_vimeo, website, fi.texto_link');

		$this->db->from('seccion se');
		$this->db->join('seccion_contenido sc','se.idseccion = sc.idseccion');
		$this->db->join('ficha fi','sc.idseccioncontenido = fi.idseccioncontenido AND fi.estado_fi = 1','left');

		$this->db->where("se.estado_se",1);

		return $this->db->get()->result_array();
	}
	public function m_editar_contenido($data,$id)	{
		$this->db->where('idseccioncontenido',$id);
		return $this->db->update('seccion_contenido', $data);
	}
	public function m_cargar_fichas_por_seccion($datos)	{
		$this->db->select('fi.idficha, fi.idseccioncontenido, fi.titulo_fi, fi.descripcion_corta, fi.descripcion_fi, fi.icono_fi, fi.codigo_vimeo, fi.codigo_youtube, sc.ficha_galeria, fi.website, fi.texto_link');
		$this->db->from('ficha fi');
		$this->db->join('seccion_contenido sc', 'fi.idseccioncontenido = sc.idseccioncontenido');
		$this->db->where("fi.estado_fi",1);
		$this->db->where("fi.idseccioncontenido",$datos['idseccioncontenido']);
		return $this->db->get()->result_array();
	}
	public function m_registrar_ficha($data){
		return $this->db->insert('ficha', $data);
	}
	public function m_editar_ficha($data,$id){
		$this->db->where('idficha',$id);
		return $this->db->update('ficha', $data);
	}
	public function m_eliminar_ficha($id){
		$datos = array(
			'estado_fi' => 0,
		);
		$this->db->where('idficha',$id);
		return $this->db->update('ficha', $datos);
	}
	public function m_registrar_imagen_ficha($data){
		return $this->db->insert('ficha_imagen', $data);
	}
	public function m_cargar_imagenes_ficha($datos)
	{
		$this->db->select('idfichaimagen, idficha, imagen,estado');
		$this->db->from('ficha_imagen');
		$this->db->where('idficha', $datos['idficha']);
		$this->db->where('estado', 1);
		$this->db->order_by('idfichaimagen', 'ASC');
		return $this->db->get()->result_array();
	}
	public function m_eliminar_imagen_ficha($data){
		$datos = array(
			'estado' => 0
		);
		$this->db->where('idfichaimagen',$data['idfichaimagen']);

		return $this->db->update('ficha_imagen', $datos);
	}
}