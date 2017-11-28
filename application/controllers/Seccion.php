<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seccion extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->helper(array('imagen','otros'));
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
	public function listar_tipo_iconos_cbo(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_seccion->m_cargar_tipo_iconos_cbo();
		$arrListado = array();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'id' => $row['idtipoicono'],
					'descripcion' => $row['descripcion']
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
	public function listar_iconos_autocomplete(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_seccion->m_cargar_iconos_cbo($allInputs);
		$arrListado = array();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'id' => $row['idicono'],
					// 'descripcion' => $row['descripcion'],
					'descripcion' => '<i class="' . $row['icono'] . '"></i> ' . $row['descripcion'],
					'icono' => $row['icono']
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
	public function listar_iconos(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		// $allInputs['tipoIcono']['id'] = $allInputs['']
		$lista = $this->model_seccion->m_cargar_iconos_cbo($allInputs);
		$arrListado = array();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'id' => $row['idicono'],
					'descripcion' => $row['descripcion'],
					// 'descripcion' => '<i class="' . $row['icono'] . '"></i> ' . $row['descripcion'],
					'icono' => $row['icono']
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
					'acepta_ficha' 	=> $row['acepta_ficha'] == 'NO' ? FALSE: TRUE,
					'nombre_boton' 	=> $row['nombre_boton'],
					'enlace_boton' 	=> $row['enlace_boton'],
					'tipo_contenido' 		=> $row['tipo_contenido'],
					'imagen' 		=> $row['imagen'],
					'imagen_bg' 	=> $row['imagen_bg'],
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
	public function listar_secciones_web()
	{
		ini_set('xdebug.var_display_max_depth', 10);
	    ini_set('xdebug.var_display_max_children', 256);
	    ini_set('xdebug.var_display_max_data', 1024);
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_seccion->m_cargar_secciones_web();
		$arrSeccion = array();
		foreach ($lista as $row) {
			$arrSeccion[$row['idseccion']] = array(
				'idseccion' 	=> $row['idseccion'],
				'seccion' 		=> $row['seccion'],
				'contenedor' => array()
			);
		}
		foreach ($arrSeccion as $key => $rowSec) {
			$arrAux = array();
			foreach ($lista as $key2 => $row) {
				if($rowSec['idseccion'] == $row['idseccion']){
					$arrAux[$row['idseccioncontenido']] =
					// array_push($arrAux,
						array(
							'idseccioncontenido' 	=> $row['idseccioncontenido'],
							'titulo' 		=> $row['titulo'],
							'subtitulo' 	=> $row['subtitulo'],
							'contenido' 	=> $row['contenido'],
							'tiene_boton' 	=> $row['tiene_boton'] == 'NO' ? FALSE: TRUE,
							'acepta_imagen' => $row['acepta_imagen'] == 'NO' ? FALSE: TRUE,
							'acepta_background' => $row['acepta_background'] == 'NO' ? FALSE: TRUE,
							'nombre_boton' 	=> $row['nombre_boton'],
							'enlace_boton' 	=> $row['enlace_boton'],
							'imagen' 		=> $row['imagen'],
							'imagen_bg' 	=> $row['imagen_bg'],
							'fichas'		=> array()
						);
					// );

				}
			}
			$arrSeccion[$key]['contenedor'] = $arrAux;
		}

		foreach ($arrSeccion as $key => $rowSec) {
			foreach ($rowSec['contenedor'] as $key2 => $rowCon) {
				$arrAux = array();
				foreach ($lista as $key3 => $row) {
					if(($rowCon['idseccioncontenido'] == $row['idseccioncontenido']) && !empty($row['idficha']) ){
						array_push($arrAux,
							array(
								'idficha' => $row['idficha'],
								'titulo' => $row['titulo_fi'],
								'descripcion_corta' => $row['descripcion_corta'],
								'descripcion' => $row['descripcion_fi'],
								'clase' => $row['icono_fi'],
							)
						);
					}
				}
				$arrSeccion[$key]['contenedor'][$key2]['fichas'] = $arrAux;
			}
		}
		foreach ($arrSeccion as $key => $rowSec) {
			$arrSeccion[$key]['contenedor'] =array_values($rowSec['contenedor']);
		}
		// var_dump($arrSeccion); exit();
    	$arrData['datos'] = $arrSeccion;
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
			/*$extension = strrchr($allInputs['imagen'], ".");
			$nombre = substr($allInputs['imagen'], 0, -strlen($extension));
			$nombre .= '-'. date('YmdHis') . $extension;*/
			$nombre = 'lat-'.$allInputs['idseccion'] .'-' . date('YmdHis') . 'jpg';
			$ruta = 'uploads/banners/LATERAL/';
			subir_imagen_Base64($allInputs['newImagen']['dataURL'], $ruta , $nombre);
			$data['imagen'] = $nombre;
    	}
    	// preparacion y subida de logo footer
    	if(!empty($allInputs['newImagenBg']) && $allInputs['cImagen']){
    		/*$extension = strrchr($allInputs['imagen_bgimagen_bg'], ".");
			$nombre = substr($allInputs['imagen_bg'], 0, -strlen($extension));
			$nombre .= '-'. date('YmdHis') . $extension;*/
			$nombre = 'bg-'.$allInputs['idseccion'] .'-' . date('YmdHis') . 'jpg';
			$ruta = 'uploads/banners/FONDO/';
			subir_imagen_Base64($allInputs['newImagenBg']['dataURL'], $ruta , $nombre);
			$data['imagen_bg'] = $nombre;
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
	public function listar_fichas()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_seccion->m_cargar_fichas_por_seccion($allInputs);
		/*$arrListado = array();
		var_dump($lista); exit();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'idseccioncontenido' 	=> $row['idseccioncontenido'],
					'titulo' 		=> $row['titulo'],
					'contenido' 	=> $row['contenido'],

				)
			);
		}*/

    	$arrData['datos'] = $lista;
    	// $arrData['datos'] = $arrListado;
    	$arrData['message'] = '';
    	$arrData['flag'] = 1;
		if(empty($lista)){
			$arrData['flag'] = 0;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function registrar_ficha(){
		// $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al registrar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// validaciones
    	if(empty($allInputs['titulo_fi'])){
    		$arrData['message'] = 'Debe ingresar un título';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}

		// data
    	$data = array(
    		'idseccioncontenido' => $allInputs['idseccioncontenido'],
    		'titulo_fi' => trim(strtoupper_total($allInputs['titulo_fi'])),
    		'descripcion_fi' => $allInputs['descripcion_fi'],
    		'icono_fi' => 'halcyon-icon-photos',
    	);
		if( $this->model_seccion->m_registrar_ficha($data) ){

			$arrData['message'] = 'Se registraron los datos correctamente';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function editar_ficha(){
		// $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// validaciones
    	if(empty($allInputs['titulo_fi'])){
    		$arrData['message'] = 'Debe ingresar un título';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}

		$data = array(
    		'titulo_fi' => trim(strtoupper_total($allInputs['titulo_fi'])),
    		'descripcion_fi' => $allInputs['descripcion_fi'],
    	);

		if( $this->model_seccion->m_editar_ficha($data,$allInputs['idficha']) ){

			$arrData['message'] = 'Se editaron los datos correctamente';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function eliminar_ficha(){
		// $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al eliminar la ficha, inténtelo nuevamente';
    	$arrData['flag'] = 0;

		if( $this->model_seccion->m_eliminar_ficha($allInputs['idficha']) ){

			$arrData['message'] = 'Se eliminó la ficha correctamente';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
}