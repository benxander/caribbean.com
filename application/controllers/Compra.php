<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compra extends CI_Controller {
	public function __construct(){
        parent::__construct();
        // Se le asigna a la informacion a la variable $sessionVP.
        $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
        $this->load->helper(array('fechas','imagen','otros'));
        $this->load->model(
        	array(
        		'model_archivo',
        		'model_mensaje',
        		'model_cliente',
        		'model_movimiento'
        	)
        );
    }

	public function verificar_archivos_seleccion(){

		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$cliente  = $this->model_cliente->m_cargar_cliente_por_sesion();
		if(empty($cliente)){
			$arrData['flag'] = 0;
			$arrData['message'] = 'Session closed';
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
			// $rowMovimiento = $this->model_movimiento->m_cargar_movimiento_por_id($allInputs);
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
			$this->model_movimiento->m_activar_movimiento($allInputs);
		}
		$arrData['flag'] = 0;
		$arrData['message'] = 'Error has occurred';
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
					$image['descargado'] = 1;
					if(!$this->model_archivo->m_editar_descarga_archivo($image)){
						$error = TRUE;
					}
				}
			}
		}
		/*comprobar si ha descargado todas las imagenes*/
		$allInputs['idcliente'] = $allInputs['imagenes'][0]['idcliente'];
		$rowProc = $this->model_cliente->m_listar_cliente_procesado($allInputs);
		if($rowProc['total_subido'] == $rowProc['comprados']){
			$allInputs['procesado'] = 4; // marcamos como completado
			$this->model_cliente->m_actualizar_procesado($allInputs);
		}
		unset($_SESSION['sess_cp_'.substr(base_url(),-14,9) ]['token']);
		if(!$error){
			$arrData['message'] = 'Successfully downloaded files.';
    		$arrData['flag'] = 1;
		}

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function enviar_correo_oferta()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$allInputs['idcliente'] = md5($allInputs['imagen']['idcliente']);
		$allInputs['idarchivo'] = md5($allInputs['imagen']['idarchivo']);
		// var_dump($allInputs); exit();
		$url = base_url() . 'verification?c=' . $allInputs['idcliente'] . '&f=' . $allInputs['idarchivo'];
		$rowMensaje = $this->model_mensaje->m_cargar_mensaje_por_id(6); // 6: EMAIL DE OFERTA
		$mensaje = $rowMensaje['contenido'];
		$mensaje .= '<br>';
		$mensaje .= '<a href="' . $url . '">CLICK HERE</a>' ;
		$mensaje .= '<br>';
		$from = CORREO;
		$to = $allInputs['email'];
		$cc = CORREO;
		$asunto = 'Free Photo Verification';

		if(envio_email($to, $cc, $asunto, $mensaje, $from)){
			if($this->model_cliente->m_actualizar_email($allInputs)){
				$arrData['message'] = 'An email was sent for verification.';
				$arrData['flag'] = 1;
			}

		}else{
			$arrData['message'] = 'Error sending mail';
			$arrData['flag'] = 0;
		}

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function verificar_email()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$rowCliente = $this->model_cliente->m_verificar_cliente($allInputs);
		// var_dump($rowCliente); exit();
		if( !empty($rowCliente) ){
			if($rowCliente['verifica_email'] == 1){
				$arrData['message'] = 'Sorry, your email has already been verified';
				$arrData['flag'] = 0;
				$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode($arrData));
				return;
			}
			$rowCliente['verifica_email'] = 1;
			$this->model_cliente->m_actualizar_verificacion($rowCliente);

			$url_origen = 'uploads/clientes/'.$rowCliente['codigo'].'/originales/'.$rowCliente['nombre_archivo'];
			$url_destino = 'uploads/clientes/'.$rowCliente['codigo'].'/descargadas/'.$rowCliente['nombre_archivo'];
			$url_origen_thumb = 'uploads/clientes/'.$rowCliente['codigo'].'/originales/thumbs/'.$rowCliente['nombre_archivo'];
			$url_destino_thumb = 'uploads/clientes/'.$rowCliente['codigo'].'/descargadas/thumbs/'.$rowCliente['nombre_archivo'];
			rename($url_origen, $url_destino);
			rename($url_origen_thumb, $url_destino_thumb);
			$rowCliente['descargado'] = 1;
			if($this->model_archivo->m_editar_descarga_archivo($rowCliente)){
				$arrData['message'] = 'Verification Successful. Thank you for confirm your mail';
				$arrData['flag'] = 1;
			}else{
				$arrData['message'] = 'Error updating download';
				$arrData['flag'] = 0;
			}

		}else{
			$arrData['message'] = 'Confirmation not work';
			$arrData['flag'] = 0;
		}

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

}