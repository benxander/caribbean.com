<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipobanner extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model(array('model_tipobanner'));
    }

    public function listar_tipo_banner_cbo(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_tipobanner->m_cargar_tipo_banner_cbo();
		$arrListado = array();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'id' => $row['idtipobanner'],
					'descripcion' => $row['descripcion_tb']
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
}