<?php
class Model_blog extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function m_cargar_noticias($paramPaginate=FALSE){
		$this->db->select('bl.idblog, bl.titulo, bl.descripcion, bl.autor,bl.fecha, bl.imagen, bl.codigo_youtube, bl.codigo_vimeo');
		$this->db->from('blog bl');
		$this->db->where('bl.estado_bl', 1);
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
	public function m_count_noticias($paramPaginate=FALSE){
		$this->db->select('COUNT(*) AS contador');
		$this->db->from('blog bl');
		$this->db->where('bl.estado_bl', 1);
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
	public function m_cargar_post_blog($datos){
		$this->db->select('bl.idblog, bl.titulo, bl.descripcion, bl.autor,bl.fecha, bl.imagen, bl.codigo_youtube, bl.codigo_vimeo, bl.website, bl.texto_link');
		$this->db->select('bp.idblogpost,bp.autor_post, bp.comentario, bp.fecha_post, bp.idblogpost_origen');
		$this->db->from('blog bl');
		$this->db->join('blog_post bp','bl.idblog = bp.idblog AND bp.estado_bp = 1','left');
		$this->db->where('bl.estado_bl', 1);
		$this->db->where('bl.idblog', $datos['id']);

		return $this->db->get()->result_array();
	}
	public function m_cargar_imagenes_blog($datos)
	{
		$this->db->select('idblogimagen, idblog, imagen, orden');
		$this->db->from('blog_imagen');
		$this->db->where('idblog', $datos['idblog']);
		$this->db->where('estado', 1);
		$this->db->order_by('orden', 'ASC');
		return $this->db->get()->result_array();
	}
	public function m_registrar($data){
		return $this->db->insert('blog', $data);
	}

	public function m_editar($data,$id){
		$this->db->where('idblog',$id);
		return $this->db->update('blog', $data);
	}
	public function m_anular($datos){
		$data = array(
			'estado_bl' => 0
		);
		$this->db->where('idblog',$datos['idblog']);
		return $this->db->update('blog', $data);
	}
	public function m_registrar_imagen($data){
		return $this->db->insert('blog_imagen', $data);
	}
	public function m_eliminar_imagen_blog($data){
		$datos = array(
			'estado' => 0
		);
		$this->db->where('idblogimagen',$data['idblogimagen']);

		return $this->db->update('blog_imagen', $datos);
	}



}