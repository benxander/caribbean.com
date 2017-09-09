<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        // Se le asigna a la informacion a la variable $sessionVP.
        // $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
        $this->load->helper(array('fechas','imagen','otros'));
        $this->load->model(array('model_blog'));
    }

	public function listar_noticias()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$paramPaginate = $allInputs['paginate'];
		$lista = $this->model_blog->m_cargar_noticias($paramPaginate);
		$totalRows = $this->model_blog->m_count_noticias($paramPaginate);
		$arrListado = array();
		foreach ($lista as $row) {
			array_push($arrListado, array(
				'idblog' => $row['idblog'],
				'titulo' => $row['titulo'],
				'descripcion' => $row['descripcion'],
				'autor' => $row['autor'],
				'fecha' => $row['fecha'],
				'imagen' => $row['imagen'],
				)
			);
		}

    	$arrData['datos'] = $arrListado;
    	$arrData['paginate']['totalRows'] = $totalRows['contador'];
    	$arrData['message'] = '';
    	$arrData['flag'] = 1;
		if(empty($lista)){
			$arrData['flag'] = 0;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function cargar_noticias_web(){
		ini_set('xdebug.var_display_max_depth', 5);
	    ini_set('xdebug.var_display_max_children', 256);
	    ini_set('xdebug.var_display_max_data', 1024);
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);

		$lista = $this->model_blog->m_cargar_noticias();

		$arrListado = array();

		$ruta = 'uploads/blog/';
		$shortMonthArray = array("","Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Set","Oct","Nov","Dic");
		foreach ($lista as $row) {

			array_push($arrListado, array(
				'idblog' => $row['idblog'],
				'titulo' => $row['titulo'],
				'descripcion' => $row['descripcion'],
				'autor' => $row['autor'],
				'dia' => date('d', strtotime($row['fecha'])),
				'mes' => $shortMonthArray[(int)date('m',strtotime($row['fecha']))],
				'imagen' => $ruta .$row['imagen'],
				)
			);
		}



    	$arrData['datos'] = $arrListado;
    	$arrData['message'] = '';
    	$arrData['flag'] = 1;
		if(empty($lista)){
			$arrData['flag'] = 0;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	// MANTENIMIENTO
	public function registrar_noticia()	{
		// $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al registrar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// validaciones
    	if(empty($allInputs['imagen'])){
    		$arrData['message'] = 'Debe subir una imagen';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}
    	// preparacion y subida de imagen
		$extension = strrchr($allInputs['nombre_imagen'], ".");
		$nombre = substr($allInputs['nombre_imagen'], 0, -strlen($extension));
		$nombre .= '-'. date('YmdHis') . $extension;
		// $ruta = 'uploads/banners/' . $allInputs['tipoBanner']['descripcion'].'/';
		$ruta = 'uploads/blog/';
		// $allInputs['imagen_ba'] = $nombre;
		subir_imagen_Base64($allInputs['imagen'], $ruta , $nombre);
		// data
    	$data = array(

    		'titulo' => empty($allInputs['titulo'])? NULL : trim(strtoupper_total($allInputs['titulo'])),
    		'descripcion' => $allInputs['descripcion'],
    		'autor' => $allInputs['autor'],
    		'imagen' => $nombre,
    		'fecha' => date('Y-m-d H:i:s'),
    	);

    	if($this->model_blog->m_registrar($data)){
			$arrData['message'] = 'Se registraron los datos correctamente';
    		$arrData['flag'] = 1;
    	}

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function editar_noticia()	{
		// $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// data
    	$data = array(

    		'titulo' => empty($allInputs['titulo'])? NULL : trim(strtoupper_total($allInputs['titulo'])),
    		'descripcion' => $allInputs['descripcion'],
    		'autor' => $allInputs['autor'],

    		'fecha' => date('Y-m-d H:i:s'),
    	);

    	// VALIDACIONES
    	if( $allInputs['canvas']){
    		if( empty($allInputs['imagen']) ){
	    		$arrData['message'] = 'Debe subir una imagen';
	    		$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode($arrData));
				return;
	    	}

	    	// preparacion y subida de imagen
			$extension = strrchr($allInputs['nombre_imagen'], ".");
			$nombre = substr($allInputs['nombre_imagen'], 0, -strlen($extension));
			$nombre .= '-'. date('YmdHis') . $extension;
			// $ruta = 'uploads/banners/' . $allInputs['tipoBanner']['descripcion'].'/';
			$ruta = 'uploads/blog/';
			// $allInputs['imagen_ba'] = $nombre;
			subir_imagen_Base64($allInputs['imagen'], $ruta , $nombre);
			$data_imagen = array(
				'imagen' => $nombre
			);
			$data = array_merge($data,$data_imagen);
    	}

    	// var_dump($data); exit();
		if( $this->model_blog->m_editar($data,$allInputs['idblog']) ){
			$arrData['message'] = 'Se editaron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function anular_noticia()	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al anular los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// var_dump($allInputs); exit();
		if($this->model_blog->m_anular($allInputs)){
			$arrData['message'] = 'Se anularon los datos correctamente';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

}
