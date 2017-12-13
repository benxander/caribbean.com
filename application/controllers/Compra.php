<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compra extends CI_Controller {
	public function __construct(){
        parent::__construct();
        // Se le asigna a la informacion a la variable $sessionVP.
        // $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
        $this->load->helper(array('fechas','imagen','otros'));
        $this->load->model(array('model_archivo','model_descuento','model_cliente','model_tipo_producto','model_pedido'));
    }

	public function verificar_archivos_seleccion(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);

		$cliente  = $this->model_cliente->m_cargar_cliente_por_idusuario($allInputs['usuario']['idusuario']);
		$descuentos = $this->model_descuento->m_cargar_todos_descuentos();

		/*verifica si sigue en isla*/
		$hoy = strtotime(date('Y-m-d'));
		$fecha_salida = strtotime($cliente['fecha_salida']);
		$arrData['mostrar_productos'] = FALSE;
		$arrData['lista_productos'] = [];
		if($hoy  <= $fecha_salida){
			$arrData['mostrar_productos'] = TRUE;
			$lista_productos = $this->model_tipo_producto->m_cargar_tipo_producto_oferta();
			foreach ($lista_productos as $iProd => $prod) {
				$lista_productos[$iProd]['cantidad'] = (int) $prod['cantidad'];
			}
			$arrData['lista_productos'] = $lista_productos;
		}

		/*verifica bonificacion*/
		$archivos = $this->model_archivo->m_cargar_galeria_descargados($cliente);
		if(!empty($archivos) && count($archivos) > 1){
			$arrData['tiene_bonificacion'] = FALSE;
		}else{
			$arrData['tiene_bonificacion'] = TRUE;
		}

		/*verifica descuento*/
		$arrData['tiene_descuento'] = FALSE;
		$arrData['descuento']['descuento'] = 0;
		foreach ($descuentos as $key => $desc) {
			$nuevafecha = strtotime ( '+'.$desc['dias'].' day' , strtotime ( $cliente['fecha_creacion'] ) );
			if( $hoy >= $nuevafecha ){
				$arrData['descuento'] = $desc;
				$arrData['tiene_descuento'] = TRUE;
			}
		}

		//print_r($arrData);	exit();

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

	public function descargar_archivos_pagados(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		//print_r($allInputs); exit();
		$arrData['flag'] = 0;
		$arrData['message'] = 'Ha ocurrido error';
		$error = FALSE;
		foreach ($allInputs as $key => $image) {
			if($image['selected']){

				// foreach ($image['lista_productos'] as $iProd => $prod) {
				// 	if((int)$prod['cantidad'] > 0){
				// 		/*registro en pedido*/
				// 		$pDatos =  array(
				// 			'idarchivo' 		=> $image['idarchivo'],
				// 			'idcliente' 		=> $image['idcliente'],
				// 			'tipo_archivo' 		=> $prod['tipo_archivo'],
				// 			'precio_unitario' 	=> $prod['precio'],
				// 			'cantidad' 			=> $prod['cantidad'],
				// 		);
				// 		if(!$this->model_pedido->m_registrar_pedido($pDatos)){
				// 			$error = TRUE;
				// 		}
				// 	}
				// }

				if(!$error){
					$urloriginal = 'uploads/clientes/'.$image['codigo_usuario'].'/originales/'.$image['nombre_archivo'];
					$urldestino = 'uploads/clientes/'.$image['codigo_usuario'].'/descargadas/'.$image['nombre_archivo'];

					if(!rename($urloriginal,$urldestino)){
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

		if(!$error){
			$arrData['message'] = 'Archivos descargados exitosamente.';
    		$arrData['flag'] = 1;
		}

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

}