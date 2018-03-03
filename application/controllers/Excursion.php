<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excursion extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        // Se le asigna a la informacion a la variable $sessionCP.
        $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
        $this->load->helper(array('fechas','imagen','otros'));
        $this->load->model(array('model_excursion'));
        $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
    }
    public function listar_excursion_cbo(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_excursion->m_cargar_excursion_cbo();
		$arrListado = array();
		//var_dump($lista); exit();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'id' => $row['idexcursion'],
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
			array_push($arrListado, array(
				'idexcursion' => $row['idexcursion'],
				'descripcion' => $row['descripcion'],
				'precio_pack' => (int)$row['precio_pack'],
				'precio_primera' => (int)$row['precio_primera'],
				'precio_adicional' => (int)$row['precio_adicional'],
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
				'idpaquete' => $row['idpaquete'],
				'titulo_pq' => $row['titulo_pq'],
				'idexcursion' => $row['idexcursion'],
				'porc_cantidad' => (int)$row['porc_cantidad'],
				'porc_monto' => (int)$row['porc_monto'],
				'cantidad' => (int)$row['cantidad'],
				'monto' => (int)$row['monto'],
				'es_nuevo' => FALSE,
				// 'estado_pq' => array(
				// 		'id'	 =>$row['idexcursion'],
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
	public function listar_excursion_paquetes_cliente(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_excursion->m_cargar_excursion_cliente($allInputs);
		$arrListado = array();
		foreach ($lista as $row) {
			array_push($arrListado, array(
				'idexcursion' => $row['idexcursion'],
				'descripcion' => $row['descripcion'],
				'idexcursionvideo' => $row['idexcursionvideo'],
				'precio_pack' => (int)$row['precio_pack'],
				'precio_primera' => (int)$row['precio_primera'],
				'precio_adicional' => (int)$row['precio_adicional'],
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
	public function listar_excursiones_cliente(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_excursion->m_cargar_excursiones_cliente($allInputs);
		$arrListado = array();
		foreach ($lista as $row) {
 			$arrListado[] = $row['idexcursion'];
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
    		$arrData['message'] = 'Título obligatorio';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}
    	if(empty($allInputs['precio_pack'])){
    		$arrData['message'] = 'Precio paquete obligatorio';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}

    	$data = array(
    		'descripcion' => strtoupper_total($allInputs['descripcion']),
    		'precio_pack' => $allInputs['precio_pack'],
    		'precio_primera' => empty($allInputs['precio_primera'])?NULL:$allInputs['precio_primera'],
    		'precio_adicional' => empty($allInputs['precio_adicional'])?NULL:$allInputs['precio_adicional'],
    		'createdat' => date('Y-m-d H:i:s'),
    		'updatedat' => date('Y-m-d H:i:s'),
    		'iduser_reg' => $this->sessionCP['idusuario']
    	);
    	// print_r($data); exit();
    	$idexcursion = $this->model_excursion->m_registrar($data);
    	if($idexcursion){
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

    		'descripcion' => strtoupper_total($allInputs['descripcion']),
    		'precio_pack' => $allInputs['precio_pack'],
    		'precio_primera' => empty($allInputs['precio_primera'])?NULL:$allInputs['precio_primera'],
    		'precio_adicional' => empty($allInputs['precio_adicional'])?NULL:$allInputs['precio_adicional'],
    		'updatedat' => date('Y-m-d H:i:s'),
    	);
    	/*$paquetes = $this->model_excursion->m_cargar_paquetes_por_actividad($allInputs);
    	foreach ($paquetes as $row) {
    		if( $row['cantidad'] != $allInputs['cantidad_fotos'] && $row['es_base'] == 1 ){
    			$edita_cantidad = TRUE;
    		}
    		if( $row['monto'] != $allInputs['precio_pack'] && $row['es_base'] == 1 ){
    			$edita_monto = TRUE;
    		}
    	}*/
    	$this->db->trans_start();
		if( $this->model_excursion->m_editar($data,$allInputs['idexcursion']) ){
			$arrData['message'] = 'Se editaron los datos correctamente ';
    		$arrData['flag'] = 1;
			/*if( $edita_cantidad || $edita_monto ){
				foreach ($paquetes as $row) {
			    	$data2 = array(
			    		'cantidad' => ceil($allInputs['cantidad_fotos']*$row['porc_cantidad']/100),
			    		'monto' => ceil($allInputs['precio_pack']*$row['porc_monto']/100),
			    	);
					if( !$this->model_excursion->m_editar_paquete($data2,$row['idpaquete']) ){
						$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    					$arrData['flag'] = 0;
					}

				}
			}*/
		}
		$this->db->trans_complete();
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
		    		'idexcursion' => $row['idexcursion'],
		    		'titulo_pq' => strtoupper_total($row['titulo_pq']),
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
	public function editar_paquete()	{
		// $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// data
    	$data = array(
    		'titulo_pq' => $allInputs['titulo_pq'],
    		'porc_cantidad' => $allInputs['porc_cantidad'],
    		'porc_monto' => $allInputs['porc_monto'],
    		'cantidad' => $allInputs['cantidad'],
    		'monto' => $allInputs['monto'],
    	);


    	// var_dump($data); exit();
		if( $this->model_excursion->m_editar_paquete($data,$allInputs['idpaquete']) ){
			$arrData['message'] = 'Se editaron los datos correctamente ';
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
			if( $this->model_excursion->m_deshabilitar($allInputs['idexcursion']) ){
				$arrData['message'] = 'Se deshabilitaron los datos correctamente';
				$arrData['flag'] = 1;
			}
    	}
    	if( $allInputs['estado']['valor'] == 2 ){
			if( $this->model_excursion->m_habilitar($allInputs['idexcursion']) ){
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
