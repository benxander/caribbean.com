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
		$arrListado = array();
		// var_dump($lista); exit();
		// foreach ($lista as $row) {
		// 	array_push($arrListado,
		// 		array(
		// 			'idweb' 		=> $row['idweb'],
		// 			'titulo_we' 	=> $row['titulo_we'],
		// 			'descripcion_we'=> $row['descripcion_we'],
		// 			'keywords' 		=> $row['keywords'],
		// 			'autor_we' 		=> $row['autor_we'],
		// 			'logo' 			=> $row['logo'],
		// 			'footer_logo' 	=> $row['footer_logo'],
		// 			'favicon' 		=> $row['favicon'],
		// 			'apple_icon' 	=> $row['apple_icon'],
		// 			'marca_agua' 	=> $row['marca_agua'],
		// 			'correo' 		=> $row['correo'],
		// 			'telefono' 		=> $row['telefono'],
		// 			'whatsapp' 		=> $row['whatsapp'],
		// 			'skype' 		=> $row['skype'],
		// 			'direccion' 	=> $row['direccion'],

		// 		)
		// 	);
		// }

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
			$ruta = '/';
			subir_imagen_Base64($allInputs['newFavicon']['dataURL'], $ruta , $nombre);
		}
		// preparacion y subida de apple icon
    	if(!empty($allInputs['newAppleIcon']) && $allInputs['cAppleIcon']){
			$nombre = 'apple-touch-180x180.png';
			$ruta = '/';
			subir_imagen_Base64($allInputs['newAppleIcon']['dataURL'], $ruta , $nombre);
		}
		// preparacion y subida de watermark
    	if(!empty($allInputs['newWaterMark']) && $allInputs['cWaterMark']){
			$nombre = 'watermark.png';
			$ruta = 'assets/images/';
			subir_imagen_Base64($allInputs['newWaterMark']['dataURL'], $ruta , $nombre);
		}

    	// var_dump($data); exit();
		if( $this->model_config->m_editar($data,$allInputs['idweb']) ){
			$arrData['message'] = 'Se editaron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

}
