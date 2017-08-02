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
					'titulo_ba' 	=> $row['titulo_ba'],
					'imagen_ba' 	=> $row['imagen_ba'],
					'tipo_banner' 	=> $row['tipo_banner'],
					'seccion'		=> $row['seccion'],
					'ancho_defecto' => $row['ancho_defecto'],
					'alto_defecto' 	=> $row['alto_defecto'],
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
		$ruta = 'uploads/banners/' . $allInputs['tipoBanner']['descripcion'].'/';
		$allInputs['imagen_ba'] = $nombre;
		subir_imagen_Base64($allInputs['imagen'], $ruta , $nombre);
		// data
    	$data = array(
    		'idtipobanner' => $allInputs['tipoBanner']['id'],
    		'idseccion' => $allInputs['seccion']['id'],
    		'titulo_ba' => empty($allInputs['titulo'])? NULL : trim(strtoupper_total($allInputs['titulo'])),
    		'imagen_ba' => $nombre,
    		'idusuario' => $this->sessionCP['idusuario'],
    		'size' => $allInputs['size'],
    		'tipo_imagen' => $allInputs['tipo_imagen'],
    		'createdAt' => date('Y-m-d H:i:s'),
			'updatedAt' => date('Y-m-d H:i:s')
    	);
		if($this->model_banner->m_registrar($data)){
			$arrData['message'] = 'Se registraron los datos correctamente';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function editar_alimento()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// var_dump($allInputs); exit();
		if($this->model_banner->m_editar($allInputs)){
			$arrData['message'] = 'Se editaron los datos correctamente ' . date('H:n:s');
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function anular_alimento()
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
