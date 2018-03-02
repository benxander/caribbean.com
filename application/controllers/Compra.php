<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compra extends CI_Controller {
	public function __construct(){
        parent::__construct();
        // Se le asigna a la informacion a la variable $sessionVP.
        $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
        $this->load->helper(array('fechas','imagen','otros'));
        $this->load->model(array('model_archivo','model_descuento','model_cliente','model_pedido','model_movimiento'));
    }

	public function verificar_archivos_seleccion(){

		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$cliente  = $this->model_cliente->m_cargar_cliente_por_sesion();
		if(empty($cliente)){
			$arrData['flag'] = 0;
			$arrData['message'] = 'Se ha perdido la sesíón';
		}else{
			$arrData['flag'] = 1;
			$arrData['message'] = '';
		}

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

	public function descargar_archivos_pagados(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		//print_r($allInputs); exit();
		if( !empty($allInputs['idmovimiento']) ){// cuando viene de pasarela
			$lista = $this->model_movimiento->m_cargar_imagenes_por_idmovimiento($allInputs);
			$arrListado = array();
			foreach ($lista as $row) {
				array_push($arrListado,
					array(
						'codigo_usuario' => $row['codigo'],
						'idarchivo' => $row['idarchivo'],
						'idcliente' => $row['idcliente'],
						'nombre_archivo' => $row['nombre_archivo'],
						'selected' => TRUE,
					)
				);
			}
			$allInputs['imagenes'] = $arrListado;
			$allInputs['idcliente'] = $arrListado[0]['idcliente'];
			$allInputs['monedero'] = 0;
			$this->model_cliente->m_actualizar_monedero($allInputs);
		}
		$arrData['flag'] = 0;
		$arrData['message'] = 'Ha ocurrido error';
		$error = FALSE;
		foreach ($allInputs['imagenes'] as $key => $image) {
			if($image['selected']){
				if(!$error){
					$url_origen = 'uploads/clientes/'.$image['codigo_usuario'].'/originales/'.$image['nombre_archivo'];
					$url_destino = 'uploads/clientes/'.$image['codigo_usuario'].'/descargadas/'.$image['nombre_archivo'];
					$url_origen_thumb = 'uploads/clientes/'.$image['codigo_usuario'].'/originales/thumbs/'.$image['nombre_archivo'];
					$url_destino_thumb = 'uploads/clientes/'.$image['codigo_usuario'].'/descargadas/thumbs/'.$image['nombre_archivo'];

					if(!rename($url_origen,$url_destino)){
						$error = TRUE;
					}
					if(!rename($url_origen_thumb,$url_destino_thumb)){
						$error = TRUE;
					}
				}

				if(!$error){
					$image['valor'] = 1;
					if(!$this->model_archivo->m_editar_descarga_archivo($image)){
						$error = TRUE;
					}
				}
			}
		}
		unset($_SESSION['sess_cp_'.substr(base_url(),-14,9) ]['token']);
		if(!$error){
			$arrData['message'] = 'Archivos descargados exitosamente.';
    		$arrData['flag'] = 1;
		}

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

}