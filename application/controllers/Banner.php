<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends CI_Controller {
	public function __construct(){
        parent::__construct();
        // Se le asigna a la informacion a la variable $sessionVP.
        // $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
        $this->load->helper(array('fechas','imagen','otros'));
        $this->load->model(array('model_banner'));
    }

	public function listar_banners(){
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
					'titulo' 		=> $row['titulo_ba'],
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
	public function cargar_banners_web(){
		ini_set('xdebug.var_display_max_depth', 5);
	    ini_set('xdebug.var_display_max_children', 256);
	    ini_set('xdebug.var_display_max_data', 1024);
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);

		$lista = $this->model_banner->m_cargar_banner_web();

		$arrListado = array();

		$ruta = 'uploads/banners/';
		foreach ($lista as $row) {

			$arrListado[$row['idbanner']] = array(
				'idbanner' 		=> $row['idbanner'],
				'imagen' 		=> $ruta . $row['tipo_banner'].'/'.$row['imagen_ba'],
				'tipo_banner' 	=> $row['tipo_banner'],
				'seccion'		=> $row['seccion'],
				'ancho_defecto' => $row['ancho_defecto'],
				'alto_defecto' 	=> $row['alto_defecto'],
				'data_offset_start'	=> $row['data_offset_start'],
				'data_offset_end' 	=> $row['data_offset_end'],
				'titulo' 		=> $row['titulo_ba'],
				'acepta_texto'	=> $row['acepta_texto'] == 'SI'? '1': '0',
				'capas'			=> array()

			);
		}
		foreach ($arrListado as $key => $value) {
			$arrAux = array();
			foreach ($lista as $row) {
				if($key == $row['idbanner']){
					array_push($arrAux,
						array(
							'idcapaslider' 	=> $row['idcapaslider'],
							'texto' 		=> $row['texto'],
							'color' 		=> $row['color'],
							'fontsize'		=> floatval($row['fontsize']),
							'fontsize2'		=> floatval($row['fontsize'])*0.8,
							'fontsize3'		=> $row['fontsize']>= 100 ? floatval($row['fontsize'])*0.5 : floatval($row['fontsize'])*0.6,
							'fontsize4'		=> $row['fontsize']>= 100 ? floatval($row['fontsize'])*0.4 : floatval($row['fontsize'])*0.5,
							'data_x' 		=> $row['data_x'],
							'data_x4' 		=> 'left',
							'data_y' 		=> $row['data_y'],
							'offset_horizontal'	=> floatval($row['offset_horizontal']),
							// 'offset_horizontal4'	=> 20,
							'offset_vertical'	=> floatval($row['offset_vertical']),
							'offset_vertical2'	=> floatval($row['offset_vertical'])*0.9,
							'offset_vertical3'	=> floatval($row['offset_vertical'])*0.8,
							'offset_vertical4'	=> floatval($row['offset_vertical'])*0.7,
							'data_width'	=> floatval($row['data_width']),
							'data_width2'	=> floatval($row['data_width'])*0.8,
							'data_width3'	=> $row['data_width'] >= 850 ? floatval($row['data_width'])*0.5 : floatval($row['data_width'])*0.7,
							'data_width4'	=> 250,
							'line_height'	=> floatval($row['line_height']),
							'line_height2'	=> floatval($row['line_height']),
							'line_height3'	=> floatval($row['line_height'])*0.8,
							'line_height4'	=> floatval($row['line_height'])*0.6,
						)
					);
				}
			}
			$arrListado[$key]['capas'] = $arrAux;
		}

		$arrListado = array_values($arrListado);
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
	public function cargar_capas_banner(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_banner->m_cargar_capas_banner($allInputs);
		$arrListado = array();

		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'idcapaslider' 	=> $row['idcapaslider'],
					'texto' 		=> $row['texto'],
					'color' 		=> $row['color'],
					'fontsize'		=> floatval($row['fontsize']),
					'data_x' 		=> $row['data_x'],
					'data_y' 		=> $row['data_y'],
					'offset_horizontal' 		=> floatval($row['offset_horizontal']),
					'offset_vertical'	=> floatval($row['offset_vertical']),
					'data_width'	=> floatval($row['data_width']),
					'line_height'	=> floatval($row['line_height']),
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
    		'titulo_ba' => empty($allInputs['titulo'])? NULL : trim(strtoupper_total($allInputs['titulo'])),
    		'imagen_ba' => $nombre,
    		'idusuario' => $this->sessionCP['idusuario'],
    		'size' => $allInputs['size'],
    		'tipo_imagen' => $allInputs['tipo_imagen'],
    		'createdAt' => date('Y-m-d H:i:s'),
			'updatedAt' => date('Y-m-d H:i:s')
    	);
    	if($allInputs['acepta_texto'] == 1 ){
    		$data['acepta_texto'] = 'SI';
    	}else{
    		$data['acepta_texto'] = 'NO';
    	}

    	$idbanner = $this->model_banner->m_registrar($data);
    	// var_dump($idbanner); exit();
		if($idbanner){
			if($allInputs['acepta_texto'] == 1 ){
	    		foreach ($allInputs['capas'] as $row) {
	    			$data_c['idbanner'] = $idbanner;
		    		$data_c['texto'] = empty($row['texto'])? NULL : trim($row['texto']);
		    		$data_c['fontsize'] = empty($row['fontsize'])? 70 : $row['fontsize'];
		    		$data_c['color'] = empty($row['color'])? 'rgba(255,255,255,1)' : $row['color'];

		    		$data_c['data_x'] = $row['data_x'];
		    		$data_c['data_y'] = $row['data_y'];
		    		$data_c['offset_vertical'] = $row['offset_vertical'];
		    		$data_c['offset_horizontal'] = $row['offset_horizontal'];
		    		$data_c['line_height'] = $row['line_height'];
		    		$data_c['data_width'] = $row['data_width'];
	    			$this->model_banner->m_registrar_capa_slider($data_c);
	    		}
	    	}
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
    		$data['acepta_texto'] = 'SI';
    		foreach ($allInputs['capas'] as $row) {
	    		$data_c['texto'] = trim($row['texto']);
	    		$data_c['fontsize'] = empty($row['fontsize'])? 70 : $row['fontsize'];
	    		$data_c['color'] = empty($row['color'])? 'rgba(255,255,255,1)' : $row['color'];

	    		$data_c['data_x'] = $row['data_x'];
	    		$data_c['data_y'] = $row['data_y'];
	    		$data_c['offset_vertical'] = $row['offset_vertical'];
	    		$data_c['offset_horizontal'] = $row['offset_horizontal'];
	    		$data_c['line_height'] = $row['line_height'];
	    		$data_c['data_width'] = $row['data_width'];
    			$this->model_banner->m_editar_capa_slider($data_c,$row['idcapaslider']);
    		}
    	}else{
    		$data['acepta_texto'] = 'NO';
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
