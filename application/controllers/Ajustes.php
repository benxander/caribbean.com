<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajustes extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model(array('model_ajustes'));
    }

    public function listar_ajustes(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_ajustes->m_cargar_ajustes();
		$arrListado = array();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'idajuste' => $row['idajuste'],
					'dias' => $row['dias'],
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
	public function editar_ajuste()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	$data = array(
    		'dias' => $allInputs['dias'],
    	);


    	// var_dump($data); exit();
		if( $this->model_ajustes->m_editar_ajustes($data,$allInputs['idajuste']) ){
			$arrData['message'] = 'Se editaron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
    	// var_dump($allInputs); exit();
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
}