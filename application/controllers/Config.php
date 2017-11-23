<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        // Se le asigna a la informacion a la variable $sessionVP.
        // $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
        $this->load->helper(array('fechas','imagen','otros'));
        $this->load->model(array('model_config'));
    }

	public function listar_configuracion()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_config->m_cargar_configuracion();
		$lista['email_cifrado'] = safe_mailto($lista['correo']);
		// $arrListado = array();
		$lista['lat'] = floatval($lista['latitud_gm']);
		$lista['lng'] = floatval($lista['longitud_gm']);
    	$arrData['datos'] = $lista;
    	$arrData['message'] = '';
    	$arrData['flag'] = 1;
		if(empty($lista)){
			$arrData['flag'] = 0;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function listar_redes_web()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_config->m_cargar_redes_web();
		$arrListado = array();
		foreach ($lista as $row) {
			array_push($arrListado, array(
					'id' => $row['idsocialweb'],
					'descripcion' => $row['nombre_rs'],
					'enlace' => $row['enlace'],
					'icono_rs' => $row['icono_rs'],
					'clase' => $row['clase'],
				)
			);
		}
    	$arrData['message'] = '';
    	$arrData['flag'] = 1;
		if(empty($lista)){
			$arrData['flag'] = 0;
		}
    	$arrData['datos'] = $arrListado;
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

	// MANTENIMIENTO
	public function editar_configuracion()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// var_dump($allInputs); exit();
    	$data = array(
    		'titulo_we' => $allInputs['titulo_we'],
    		'descripcion_we' => empty($allInputs['descripcion_we'])? NULL:$allInputs['descripcion_we'],
    		'keywords' 	=> empty($allInputs['keywords'])? NULL:$allInputs['keywords'],
    		'autor_we' 	=> empty($allInputs['autor'])? NULL:$allInputs['autor'],
    		'telefono' 	=> empty($allInputs['telefono'])? NULL:$allInputs['telefono'],
    		'whatsapp' 	=> empty($allInputs['whatsapp'])? NULL:$allInputs['whatsapp'],
    		'skype' 	=> empty($allInputs['skype'])? NULL:$allInputs['skype'],
    		'correo'	=> empty($allInputs['correo'])? NULL:$allInputs['correo'],
    		'direccion' => empty($allInputs['direccion'])? NULL:$allInputs['direccion'],

			'updatedat' => date('Y-m-d H:i:s')
    	);
    	// preparacion y subida de logo
    	if(!empty($allInputs['newLogo']) && $allInputs['cLogo']){
			$nombre = 'logo-dark.png';
			$ruta = 'assets/images/';
			subir_imagen_Base64($allInputs['newLogo']['dataURL'], $ruta , $nombre);
    	}
    	// preparacion y subida de logo footer
    	if(!empty($allInputs['newLogoFooter']) && $allInputs['cLogoFooter']){
			$nombre = 'footer-logo.png';
			$ruta = 'assets/images/';
			subir_imagen_Base64($allInputs['newLogoFooter']['dataURL'], $ruta , $nombre);
		}
		// preparacion y subida de favicon
    	if(!empty($allInputs['newFavicon']) && $allInputs['cFavicon']){
			$nombre = 'favicon.png';
			$ruta = 'assets/images/';
			subir_imagen_Base64($allInputs['newFavicon']['dataURL'], $ruta , $nombre);
		}
		// preparacion y subida de apple icon
    	if(!empty($allInputs['newAppleIcon']) && $allInputs['cAppleIcon']){
			$nombre = 'apple-touch-180x180.png';
			$ruta = 'assets/images/';
			subir_imagen_Base64($allInputs['newAppleIcon']['dataURL'], $ruta , $nombre);
		}
		// preparacion y subida de watermark
    	if(!empty($allInputs['newWaterMark']) && $allInputs['cWaterMark']){
			$nombre = 'watermark.png';
			$ruta = 'assets/images/';
			subir_imagen_Base64($allInputs['newWaterMark']['dataURL'], $ruta , $nombre);
		}
		// foreach ($allInputs['redes'] as $row) {
		// 	$r = $this->model_config->m_editar_red_social($row);
  //   		var_dump($r);
		// } exit();
		if( $this->model_config->m_editar($data,$allInputs['idweb']) ){
			foreach ($allInputs['redes'] as $row) {
				if ($this->model_config->m_editar_red_social($row)) {
					$arrData['message'] = 'Se editaron los datos correctamente ';
		    		$arrData['flag'] = 1;

				}
			}
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

}
