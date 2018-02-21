<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compra extends CI_Controller {
	public function __construct(){
        parent::__construct();
        // Se le asigna a la informacion a la variable $sessionVP.
        // $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
        $this->load->helper(array('fechas','imagen','otros'));
        $this->load->model(array('model_archivo','model_descuento','model_cliente','model_pedido','model_movimiento'));
    }

	public function verificar_archivos_seleccion(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);

		$cliente  = $this->model_cliente->m_cargar_cliente_por_idusuario($allInputs['usuario']['idusuario']);
		// $descuentos = $this->model_descuento->m_cargar_todos_descuentos();

		/*verifica si sigue en isla*/
		/*$hoy = strtotime(date('Y-m-d'));
		$fecha_salida = strtotime($cliente['fecha_salida']);
		$arrData['mostrar_productos'] = FALSE;*/
		// $arrData['lista_productos'] = [];
		/*if($hoy  <= $fecha_salida){
			$arrData['mostrar_productos'] = TRUE;
			// $lista_productos = $this->model_tipo_producto->m_cargar_tipo_producto_oferta();
			// foreach ($lista_productos as $iProd => $prod) {
			// 	$lista_productos[$iProd]['cantidad'] = (int) $prod['cantidad'];
			// }
			// $arrData['lista_productos'] = $lista_productos;
		}*/

		/*verifica bonificacion*/
		/*$archivos = $this->model_archivo->m_cargar_galeria_descargados($cliente);
		if(!empty($archivos) && count($archivos) > 1){
			$arrData['tiene_bonificacion'] = FALSE;
		}else{
			$arrData['tiene_bonificacion'] = TRUE;
		}
*/
		/*verifica descuento*/
		/*$arrData['tiene_descuento'] = FALSE;
		$arrData['descuento']['descuento'] = 0;
		foreach ($descuentos as $key => $desc) {
			$nuevafecha = strtotime ( '+'.$desc['dias'].' day' , strtotime ( $cliente['fecha_salida'] ) );
			if( $hoy >= $nuevafecha ){
				$arrData['descuento'] = $desc;
				$arrData['tiene_descuento'] = TRUE;
			}
		}*/

		//print_r($arrData);	exit();

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

	public function descargar_archivos_pagados(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		//print_r($allInputs); exit();
		if( !empty($allInputs['idmovimiento']) ){
			$lista = $this->model_movimiento->m_cargar_imagenes_por_idmovimiento($allInputs);
			$arrListado = array();
			foreach ($lista as $row) {
				array_push($arrListado,
					array(
						'codigo_usuario' => $row['codigo'],
						'idarchivo' => $row['idarchivo'],
						'nombre_archivo' => $row['nombre_archivo'],
						'selected' => TRUE,
					)
				);
			}
			$allInputs['imagenes'] = $arrListado;
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