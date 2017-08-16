<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seccion extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->helper(array('imagen'));
        $this->load->model(array('model_seccion'));
    }

    public function listar_seccion_cbo(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_seccion->m_cargar_seccion_cbo();
		$arrListado = array();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'id' => $row['idseccion'],
					'descripcion' => $row['descripcion_se']
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
	public function listar_secciones()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$paramPaginate = $allInputs['paginate'];
		$lista = $this->model_seccion->m_cargar_secciones($paramPaginate);
		$totalRows = $this->model_seccion->m_count_secciones($paramPaginate);
		$arrListado = array();
		// var_dump($lista); exit();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'idseccioncontenido' 	=> $row['idseccioncontenido'],
					'idseccion' 	=> $row['idseccion'],
					'seccion' 		=> $row['seccion'],
					'titulo' 		=> $row['titulo'],
					'subtitulo' 	=> $row['subtitulo'],
					'contenido' 	=> $row['contenido'],
					'tiene_boton' 	=> $row['tiene_boton'] == 'NO' ? FALSE: TRUE,
					'acepta_imagen' => $row['acepta_imagen'] == 'NO' ? FALSE: TRUE,
					'acepta_background' => $row['acepta_background'] == 'NO' ? FALSE: TRUE,
					'nombre_boton' 	=> $row['nombre_boton'],
					'enlace_boton' 	=> $row['enlace_boton'],
					'imagen' 		=> $row['imagen'],
					'imagen_bg' 		=> $row['imagen_bg'],


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
	public function editar_contenido()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	$data = array(
    		'titulo' => $allInputs['titulo'],
    		'subtitulo' => empty($allInputs['subtitulo'])? NULL:$allInputs['subtitulo'],
    		'contenido' 	=> empty($allInputs['contenido'])? NULL:$allInputs['contenido'],
    	);
    	// preparacion y subida de banner lateral
    	if(!empty($allInputs['newImagen']) && $allInputs['cImagen']){
			$nombre = $allInputs['imagen'];
			$ruta = 'uploads/banners/LATERAL/';
			subir_imagen_Base64($allInputs['newImagen']['dataURL'], $ruta , $nombre);
    	}
    	// preparacion y subida de logo footer
    	if(!empty($allInputs['newImagenBg']) && $allInputs['cImagen']){
			$nombre = $allInputs['imagen_bg'];
			$ruta = 'uploads/banners/FONDO/';
			subir_imagen_Base64($allInputs['newImagenBg']['dataURL'], $ruta , $nombre);
		}

    	// var_dump($data); exit();
		if( $this->model_seccion->m_editar_contenido($data,$allInputs['idseccioncontenido']) ){
			$arrData['message'] = 'Se editaron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
    	// var_dump($allInputs); exit();
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
}