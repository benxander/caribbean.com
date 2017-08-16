<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seccion extends CI_Controller {
	public function __construct(){
        parent::__construct();
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
					'idseccion' 		=> $row['idseccion'],
					'seccion' 			=> $row['descripcion_se'],
					'contenido' 		=> $row['contenido'],

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
}