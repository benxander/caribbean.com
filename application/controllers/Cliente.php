<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {
	public function __construct(){
        parent::__construct();
        // Se le asigna a la informacion a la variable $sessionVP.
        // $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
        $this->load->helper(array('fechas','imagen','otros'));
        $this->load->model(array('model_cliente','model_usuario'));
    }

    public function listar_clientes(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$paramPaginate = $allInputs['paginate'];
		$lista = $this->model_cliente->m_cargar_cliente($paramPaginate);
		$totalRows = $this->model_cliente->m_count_cliente($paramPaginate);
		$arrListado = array();
		//var_dump($lista); exit();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'idcliente' => $row['idcliente'],
					'idusuario' => $row['idusuario'],
					'nombres' => $row['nombres'],
					'apellidos' => $row['apellidos'],
					'email' => $row['email'],
					'whatsapp' => $row['whatsapp'],
					'estado_cl' => $row['estado_cl']
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

	public function listar_cliente_por_idusuario(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$row = $this->model_cliente->m_cargar_cliente_por_idusuario($allInputs['idusuario']);
		//var_dump($lista); exit();
		$arrListado =	array(
				'idcliente' => $row['idcliente'],
				'idusuario' => $row['idusuario'],
				'username' => $row['username'],
				'nombres' => $row['nombres'],
				'apellidos' => $row['apellidos'],
				'cliente' => strtoupper_total($row['nombres'] . ' ' .$row['apellidos']),
				'email' => $row['email'],
				'whatsapp' => $row['whatsapp'],
				'estado_cl' => $row['estado_cl'],
				'ididioma' => $row['ididioma'],
				'idioma' => $row['idioma'],
				'solicita_bonificacion' => $row['solicita_bonificacion'],			
				'nombre_foto' => $row['nombre_foto'],			
			);		

    	$arrData['datos'] = $arrListado;
    	$arrData['flag'] = 1;
		if(empty($row['idcliente'])){
			$arrData['flag'] = 0;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

	// MANTENIMIENTO
	public function registrar_cliente(){
		$this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al registrar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;

		if($this->model_cliente->m_registrar_cliente($allInputs)){
			$arrData['message'] = 'Se registraron los datos correctamente';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

	public function editar_cliente(){
		$this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;

		if( $this->model_cliente->m_editar_cliente($allInputs) ){
			$arrData['message'] = 'Se editaron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

	public function anular_cliente(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al anular los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	

    	if(!empty($allInputs['idusuario'])){
    		if($this->model_usuario->m_consultar_usuario($allInputs)){
    			$arrData['message'] = 'Este cliente tiene un usuario asociado';
	    		$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode($arrData));
				return;	
    		}		
    	}

		if($this->model_cliente->m_anular_cliente($allInputs)){
			$arrData['message'] = 'Se anularon los datos correctamente';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

}