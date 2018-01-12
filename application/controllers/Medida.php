<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Medida extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('otros_helper'));
		$this->load->model(array('model_medida'));
	}
	public function listar_medidas(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$paramPaginate = $allInputs['paginate'];
		$lista = $this->model_medida->m_cargar_medidas($paramPaginate);
		$totalRows = $this->model_medida->m_count_medidas($paramPaginate);
		$arrListado = array();
		foreach ($lista as $row) {
			if( $row['estado_me'] == 1 ){
				$bool = true;
			}
			elseif( $row['estado_me'] == 2 ){
				$bool = false;
			}
			array_push($arrListado,
				array(
					'idtipomedida' => $row['idtipomedida'],
					'descripcion_tm' => $row['descripcion_tm'],
					'denominacion' => $row['denominacion'],
					'idmedida' 		=> $row['idmedida'],
					'estado' => array(
						'id'	 =>$row['idmedida'],
						'valor'  =>$row['estado_me'],
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
	public function registrar_medida(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;

    	$data = array(
    		'descripcion_tm' => strtoupper_total(trim($allInputs['descripcion_pm'])),
    		'idtipomedida' => $allInputs['tipo_medida']['id'],


    	);

    	if( $this->model_medida->m_registrar_medida($data) ){
			$arrData['message'] = 'Se registraron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

}

/* End of file Medida.php */
/* Location: ./application/controllers/Medida.php */