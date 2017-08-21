<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        // Se le asigna a la informacion a la variable $sessionVP.
        // $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
        $this->load->helper(array('fechas','imagen','otros'));
        $this->load->model(array('model_banner'));
    }

	public function listar_banners()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$paramPaginate = $allInputs['paginate'];
		$lista = $this->model_banner->m_cargar_banner($paramPaginate);
		$totalRows = $this->model_banner->m_count_banner($paramPaginate);
		$arrListado = array();
		// var_dump($lista); exit();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'idbanner' 		=> $row['idbanner'],
					'imagen' 		=> $row['imagen_ba'],
					'tipo_banner' 	=> $row['tipo_banner'],
					'seccion'		=> $row['seccion'],
					'ancho_defecto' => $row['ancho_defecto'],
					'alto_defecto' 	=> $row['alto_defecto'],
					'titulo' 		=> $row['titulo_texto'],
					'size_titulo' 	=> floatval($row['size_titulo']),
					'color_titulo' 	=> $row['color_titulo'],
					'subtitulo' 	=> $row['subtitulo_texto'],
					'size_subtitulo'=> floatval($row['size_subtitulo']),
					'color_subtitulo'=> $row['color_subtitulo'],
					'acepta_texto'	=> $row['acepta_texto'] == 'SI'? '1': '0',
					'estado_ba' 	=> $row['estado_ba'],
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
	public function cargar_banners_web()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);

		$lista = $this->model_banner->m_cargar_banner();

		$arrListado = array();
		$arrSlider = array();
		$arrFondo = array();
		$arrLateral = array();
		$ruta = 'uploads/banners/';
		foreach ($lista as $row) {
			$arrAux = array(
				'idbanner' 		=> $row['idbanner'],
				'imagen' 		=> $ruta . $row['tipo_banner'].'/'.$row['imagen_ba'],
				'tipo_banner' 	=> $row['tipo_banner'],
				'seccion'		=> $row['seccion'],
				'ancho_defecto' => $row['ancho_defecto'],
				'alto_defecto' 	=> $row['alto_defecto'],
				'titulo' 		=> $row['titulo_texto'],
				'size_titulo' 	=> floatval($row['size_titulo']),
				'color_titulo' 	=> $row['color_titulo'],
				'subtitulo' 	=> $row['subtitulo_texto'],
				'size_subtitulo'=> floatval($row['size_subtitulo']),
				'color_subtitulo'=> $row['color_subtitulo'],
				'acepta_texto'	=> $row['acepta_texto'] == 'SI'? '1': '0',
				'estado_ba' 	=> $row['estado_ba'],
			);
			// $arrListado[$row['tipo_banner']][] = $arrAux;
			array_push($arrListado, $arrAux);
		}

		// var_dump($arrListado); exit();

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
	public function registrar_banner()
	{
		$this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
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
		$ruta = 'uploads/banners/SLIDER/';
		$allInputs['imagen_ba'] = $nombre;
		subir_imagen_Base64($allInputs['imagen'], $ruta , $nombre);
		// data
    	$data = array(
    		'idtipobanner' => 1,
    		'idseccion' => 1,
    		// 'idtipobanner' => $allInputs['tipoBanner']['id'],
    		// 'idseccion' => $allInputs['seccion']['id'],
    		'imagen_ba' => $nombre,
    		'idusuario' => $this->sessionCP['idusuario'],
    		'size' => $allInputs['size'],
    		'tipo_imagen' => $allInputs['tipo_imagen'],
    		'createdAt' => date('Y-m-d H:i:s'),
			'updatedAt' => date('Y-m-d H:i:s')
    	);
    	if($allInputs['acepta_texto'] == 1 ){
    		$data['titulo_texto'] = trim($allInputs['titulo']);
    		$data['size_titulo'] = empty($allInputs['size_titulo'])? 70 : $allInputs['size_titulo'];
    		$data['color_titulo'] = empty($allInputs['color_titulo'])? 'rgba(255,255,255,1)' : $allInputs['color_titulo'];
    		$data['subtitulo_texto'] = trim($allInputs['subtitulo']);
    		$data['size_subtitulo'] = empty($allInputs['size_subtitulo'])? 12 : $allInputs['size_subtitulo'];
    		$data['color_subtitulo'] = empty($allInputs['color_subtitulo'])? 'rgba(255,255,255,1)' : $allInputs['color_subtitulo'];
    		$data['acepta_texto'] = 'SI';
    	}else{
    		$data['acepta_texto'] = 'NO';
    	}
    	// var_dump($data); exit();
		if($this->model_banner->m_registrar($data)){
			$arrData['message'] = 'Se registraron los datos correctamente';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function editar_banner()
	{
		$this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// data
    	$data = array(
    		// 'idtipobanner' => $allInputs['tipoBanner']['id'],
    		// 'idseccion' => $allInputs['seccion']['id'],
    		'titulo_ba' => empty($allInputs['titulo'])? NULL : trim(strtoupper_total($allInputs['titulo'])),
    		'idusuario' => $this->sessionCP['idusuario'],
			'updatedAt' => date('Y-m-d H:i:s')
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
			$ruta = 'uploads/banners/SLIDER/';
			$allInputs['imagen_ba'] = $nombre;
			subir_imagen_Base64($allInputs['imagen'], $ruta , $nombre);
			$data_imagen = array(
				'imagen_ba' => $nombre,
	    		'size' => $allInputs['size'],
	    		'tipo_imagen' => $allInputs['tipo_imagen'],
			);
			$data = array_merge($data,$data_imagen);
    	}
    	if($allInputs['acepta_texto'] == 1 ){
    		$data['titulo_texto'] = trim($allInputs['titulo']);
    		$data['size_titulo'] = empty($allInputs['size_titulo'])? 70 : $allInputs['size_titulo'];
    		$data['color_titulo'] = empty($allInputs['color_titulo'])? 'rgba(255,255,255,1)' : $allInputs['color_titulo'];
    		$data['subtitulo_texto'] = trim($allInputs['subtitulo']);
    		$data['size_subtitulo'] = empty($allInputs['size_subtitulo'])? 12 : $allInputs['size_subtitulo'];
    		$data['color_subtitulo'] = empty($allInputs['color_subtitulo'])? 'rgba(255,255,255,1)' : $allInputs['color_subtitulo'];
    	}
    	// var_dump($data); exit();
		if( $this->model_banner->m_editar($data,$allInputs['idbanner']) ){
			$arrData['message'] = 'Se editaron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function anular_banner()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al anular los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// var_dump($allInputs); exit();
		if($this->model_banner->m_anular($allInputs)){
			$arrData['message'] = 'Se anularon los datos correctamente';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
}
