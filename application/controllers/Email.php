<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model(array('model_email'));
    }
    public function listar_tipo_email_cbo(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_email->m_cargar_tipo_email_cbo();
		$arrListado = array();
		//var_dump($lista); exit();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'id' => $row['idtipoemail'],
					'descripcion' => $row['titulo_te'],

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
    public function listar_emails(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$paramPaginate = $allInputs['paginate'];
		$lista = $this->model_email->m_cargar_emails($paramPaginate);
		$totalRows = $this->model_email->m_count_emails($paramPaginate);
		$arrListado = array();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'idcontenidoemail' => $row['idemail'],
					'idemail' => $row['idtipoemail'],
					'titulo' => $row['titulo_te'],
					'asunto' => $row['asunto'],
					'contenido' => strip_tags($row['contenido']),
					'ididioma' => $row['ididioma'],
					'idioma' => $row['idioma'],

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
	public function registrar_email(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	$data = array(
    		'idtipoemail' => $allInputs['tipoEmail']['id'],
    		'ididioma' => $allInputs['idioma']['id'],
    		'asunto' => $allInputs['asunto'],
    		'contenido' => $allInputs['contenido'],
    	);
		if( $this->model_email->m_registrar_email($data) ){
			$arrData['message'] = 'Se registraron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function editar_email(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	$data = array(
    		'idtipoemail' => $allInputs['tipoEmail']['id'],
    		'ididioma' => $allInputs['idioma']['id'],
    		'asunto' => $allInputs['asunto'],
    		'contenido' => $allInputs['contenido'],
    	);


    	// var_dump($data); exit();
		if( $this->model_email->m_editar_email($data,$allInputs['idcontenidoemail']) ){
			$arrData['message'] = 'Se editaron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
    	// var_dump($allInputs); exit();
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
}