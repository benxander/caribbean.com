<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mensaje extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('otros_helper'));
		$this->load->model(array('model_mensaje'));
	}
	public function listar_mensajes(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		// $paramPaginate = $allInputs['paginate'];
		$lista = $this->model_mensaje->m_cargar_mensajes();
		$arrListado = array();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'idmensaje' => $row['idmensaje'],
					'seccion' => $row['seccion'],
					'contenido' => $row['contenido'],
					'contenido_f' => strip_tags($row['contenido']),
				)
			);
		}

    	$arrData['datos'] = $arrListado;
    	// $arrData['paginate']['totalRows'] = count($lista);
    	$arrData['message'] = '';
    	$arrData['flag'] = 1;
		if(empty($lista)){
			$arrData['flag'] = 0;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

	public function editar_mensaje(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	$data = array(
    		'contenido' => trim($allInputs['contenido']),
    	);
    	if( $this->model_mensaje->m_editar_mensaje($data,$allInputs['idmensaje']) ){
			$arrData['message'] = 'Se editaron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
    }
}

/* End of file Medida.php */
/* Location: ./application/controllers/Medida.php */