<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model(array('model_email'));
    }

    public function listar_emails(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_email->m_cargar_emails();
		$arrListado = array();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'idcontenidoemail' => $row['idcontenidoemail'],
					'titulo' => $row['titulo'],
					'contenido' => $row['contenido']
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
    		'titulo' => $allInputs['titulo'],
    		'contenido' => $allInputs['contenido'],
    	);


    	// var_dump($data); exit();
		if( $this->model_email->m_editar_descuento($data,$allInputs['iddescuento']) ){
			$arrData['message'] = 'Se editaron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
    	// var_dump($allInputs); exit();
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
}