<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excursion extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        // Se le asigna a la informacion a la variable $sessionVP.
        // $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
        $this->load->helper(array('fechas','imagen','otros'));
        $this->load->model(array('model_excursion'));
    }
    public function listar_excursion_cbo(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_excursion->m_cargar_excursion_cbo();
		$arrListado = array();
		//var_dump($lista); exit();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'id' => $row['idactividad'],
					'descripcion' => $row['descripcion'],
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
	public function listar_excursiones(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$paramPaginate = $allInputs['paginate'];
		$lista = $this->model_excursion->m_cargar_excursiones($paramPaginate);
		$totalRows = $this->model_excursion->m_count_excursiones($paramPaginate);
		$arrListado = array();
		foreach ($lista as $row) {
			if( $row['estado'] == 1 ){
				$bool = true;
			}
			elseif( $row['estado'] == 2 ){
				$bool = false;
			}
			array_push($arrListado, array(
				'idactividad' => $row['idactividad'],
				'descripcion' => $row['descripcion'],
				'cantidad_fotos' => (int)$row['cantidad_fotos'],
				'monto_total' => (int)$row['monto_total'],
				'precio_video' => empty($row['precio_video'])? NULL : (int)$row['precio_video'],
				'fecha' => date('Y-m-d',strtotime($row['fecha_actividad'])),
				// 'fecha' => $row['fecha'],
				'fecha_f' => darFormatoDMY2($row['fecha_actividad']),
				'estado' => array(
						'id'	 =>$row['idactividad'],
						'valor'  =>$row['estado'],
						'bool'   =>$bool
					)
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
	public function listar_paquetes(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_excursion->m_cargar_paquetes($allInputs);
		$arrListado = array();
		foreach ($lista as $row) {
			// if( $row['estado_pq'] == 1 ){
			// 	$bool = true;
			// }
			// elseif( $row['estado_pq'] == 2 ){
			// 	$bool = false;
			// }
			array_push($arrListado, array(
				'idactividad' => $row['idactividad'],
				'porc_cantidad' => (int)$row['porc_cantidad'],
				'porc_monto' => (int)$row['porc_monto'],
				'cantidad' => (int)$row['cantidad'],
				'monto' => (int)$row['monto'],
				'es_nuevo' => FALSE,
				// 'estado_pq' => array(
				// 		'id'	 =>$row['idactividad'],
				// 		'valor'  =>$row['estado_pq'],
				// 		'bool'   =>$bool
				// 	)
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
	public function registrar_excursion()	{
		// $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al registrar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// validaciones
    	if(empty($allInputs['descripcion'])){
    		$arrData['message'] = 'Campo obligatorio';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}
    	$data = array(
    		'descripcion' => $allInputs['descripcion'],
    		'fecha_actividad' => date('Y-m-d',strtotime($allInputs['fecha'])),
    		'cantidad_fotos' => $allInputs['cantidad_fotos'],
    		'monto_total' => $allInputs['monto_total'],
    		'precio_video' => empty($allInputs['precio_video'])? NULL : $allInputs['precio_video'],
    		'createdat' => date('Y-m-d H:i:s'),
    		'updatedat' => date('Y-m-d H:i:s'),
    	);
    	// print_r($data); exit();
    	$idactividad = $this->model_excursion->m_registrar($data);
    	if($idactividad){
	    	$data2 = array(
	    		'idactividad' => $idactividad,
	    		'porc_cantidad' => 100,
	    		'porc_monto' => 100,
	    		'cantidad' => $allInputs['cantidad_fotos'],
	    		'monto' => $allInputs['monto_total'],
	    		'es_base' => 1
	    	);
    		$reg_paquete = $this->model_excursion->m_registrar_paquete($data2);
    	}
    	if($reg_paquete){

			$arrData['message'] = 'Se registraron los datos correctamente';
    		$arrData['flag'] = 1;
    	}

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function editar_excursion()	{
		// $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// data
    	$data = array(

    		'descripcion' => $allInputs['descripcion'],
    		'fecha_actividad' => date('Y-m-d',strtotime($allInputs['fecha'])),
    		'cantidad_fotos' => $allInputs['cantidad_fotos'],
    		'monto_total' => $allInputs['monto_total'],
    		'precio_video' => empty($allInputs['precio_video'])? NULL : $allInputs['precio_video'],
    		'updatedat' => date('Y-m-d H:i:s'),
    	);

    	// VALIDACIONES
    	/*if( $allInputs['canvas']){
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
    	}*/

    	// var_dump($data); exit();
		if( $this->model_excursion->m_editar($data,$allInputs['idactividad']) ){
			$arrData['message'] = 'Se editaron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function registrar_paquetes()	{
		// $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al registrar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// data
    	$hay_error = FALSE;
    	foreach ($allInputs as $row) {
    		if($row['es_nuevo']){
		    	$data = array(
		    		'idactividad' => $row['idactividad'],
		    		'porc_cantidad' => $row['porc_cantidad'],
		    		'porc_monto' => $row['porc_monto'],
		    		'cantidad' => $row['cantidad'],
		    		'monto' => $row['monto'],
		    		'es_base' => 2
		    	);
    			if( !$this->model_excursion->m_registrar_paquete($data) ){
					$hay_error = TRUE;
				}
    		}

    	}

    	// var_dump($data); exit();
		if( !$hay_error ){
			$arrData['message'] = 'Se registraron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function anular_excursion()	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al anular los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// var_dump($allInputs); exit();
		if($this->model_excursion->m_anular($allInputs)){
			$arrData['message'] = 'Se anularon los datos correctamente';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function habilitar_deshabilitar_excursion()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	$this->db->trans_start();
    	if( $allInputs['estado']['valor'] == 1 ){
			if( $this->model_excursion->m_deshabilitar($allInputs['idactividad']) ){
				$arrData['message'] = 'Se deshabilitaron los datos correctamente';
				$arrData['flag'] = 1;
			}
    	}
    	if( $allInputs['estado']['valor'] == 2 ){
			if( $this->model_excursion->m_habilitar($allInputs['idactividad']) ){
				$arrData['message'] = 'Se habilitaron los datos correctamente';
				$arrData['flag'] = 1;
			}
    	}
    	$this->db->trans_complete();
    	$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

}
