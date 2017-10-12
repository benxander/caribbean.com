<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Descuento extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model(array('model_descuento'));
    }

    public function listar_descuentos(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_descuento->m_cargar_descuentos();
		$arrListado = array();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'iddescuento' => $row['iddescuento'],
					'dias' => $row['dias'],
					'descuento' => $row['descuento']
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
	public function editar_descuento()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	$data = array(
    		'dias' => $allInputs['dias'],
    		'descuento' => $allInputs['descuento'],
    	);


    	// var_dump($data); exit();
		if( $this->model_descuento->m_editar_descuento($data,$allInputs['iddescuento']) ){
			$arrData['message'] = 'Se editaron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
    	// var_dump($allInputs); exit();
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
}