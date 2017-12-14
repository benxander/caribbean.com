<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Archivo extends CI_Controller {
	public function __construct(){
        parent::__construct();
        // Se le asigna a la informacion a la variable $sessionVP.
        // $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
        $this->load->helper(array('fechas','imagen','otros'));
        $this->load->model(array('model_archivo'));
    }

    public function listar_galeria_descargados(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_archivo->m_cargar_galeria_descargados($allInputs);
		$arrListado = array();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'idarchivo' => $row['idarchivo'],
					'idusuario' => $row['idusuario'],
					'idcliente' => $row['idcliente'],
					'nombre_archivo' => $row['nombre_archivo'],
					'size' => $row['size'],
					'fecha_subida' => $row['fecha_subida'],
					'descargado' => $row['descargado'],
					'fecha_descarga' => $row['fecha_descarga'],
					'es_bonificacion' => $row['es_bonificacion'],
					'tipo_archivo' => $row['tipo_archivo'],
					// 'producto' => $row['producto'],
					'codigo_usuario' => $row['codigo'],
					'selected' => FALSE,
					'src' => '../uploads/clientes/'.$row['codigo'].'/descargadas/'.$row['nombre_archivo'],
					'src_thumb' => '../uploads/clientes/'.$row['codigo'].'/descargadas/thumbs/'.$row['nombre_archivo'],
					'src_share' => dirname($_SERVER['HTTP_REFERER']).'/uploads/clientes/'.$row['codigo'].'/descargadas/'.$row['nombre_archivo'],
					//'src_share' => "http://www.unaisangamer.com/uploads/clientes/23121970/descargadas/2oBv2IaekK.jpg",
					'title' => '',
					'fecha_salida' => $row['fecha_salida']
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

	public function listar_archivos_no_descargados(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_archivo->m_cargar_galeria_no_descargados($allInputs);
		$arrListado = array();
		//var_dump($lista); exit();
		foreach ($lista as $row) {
			// if($row['descargado'] == 1){
			// 	$src = '../uploads/clientes/'.$row['codigo'].'/descargadas/'.$row['nombre_archivo'];
			// }else{
			// 	$src = '../uploads/clientes/'.$row['codigo'].'/descargadas/thumbs/'.$row['nombre_archivo'];
			// }
			$src = '../uploads/clientes/'.$row['codigo'].'/thumbs/'.$row['nombre_archivo'];
			array_push($arrListado,
				array(
					'idarchivo' => $row['idarchivo'],
					'idusuario' => $row['idusuario'],
					'idcliente' => $row['idcliente'],
					'nombre_archivo' => $row['nombre_archivo'],
					'size' => $row['size'],
					'fecha_subida' => $row['fecha_subida'],
					'descargado' => $row['descargado'],
					'fecha_descarga' => $row['fecha_descarga'],
					'es_bonificacion' => $row['es_bonificacion'],
					'tipo_archivo' => $row['tipo_archivo'],
					// 'producto' => $row['producto'],
					// 'precio_float' => (float)$row['precio'],
					// 'precio' => $row['precio'],
					'codigo_usuario' => $row['codigo'],
					'selected' => FALSE,
					'src' => $src,
					'title' => '',
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
}