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
		$rowVideo = $this->model_archivo->m_cargar_video_cliente($allInputs);
		$rowVideo['ruta'] = empty($rowVideo['nombre_video'])? NULL : '../uploads/clientes/videos/'.$rowVideo['nombre_video'];
		$arrListado = array();
		foreach ($lista as $row) {
			if( strtotime($row['fecha_salida'])<strtotime(date('Y-m-d')) ){
				$salida = TRUE;
			}else{
				$salida = FALSE;
			}
			array_push($arrListado,
				array(
					'idarchivo' => $row['idarchivo'],
					'idcliente' => $row['idcliente'],
					'idexcursion' => $row['idexcursion'],
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
					'title' => '',
					'fecha_salida' => $row['fecha_salida'],
					'es_salida' => $salida,
				)
			);
		}
		if(!empty($rowVideo['nombre_video'])){
			array_push($arrListado,
				array(
					'nombre_archivo' => $rowVideo['nombre_video'],
					'tipo_archivo' => 2,
					'selected' => FALSE,
					'src_thumb' => '../uploads/clientes/videos/'.$rowVideo['nombre_video'],
					'src_share' => dirname($_SERVER['HTTP_REFERER']).'/uploads/clientes/videos/'.$rowVideo['nombre_video'],
				)
			);
		}
    	$arrData['datos'] = $arrListado;
    	// $arrData['video'] = $rowVideo;
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
		foreach ($lista as $row) {
			/*if( strtotime($row['fecha_salida'])<strtotime(date('Y-m-d')) ){
				$salida = TRUE;
			}else{
				$salida = FALSE;
			}*/
			$src = '../uploads/clientes/'.$row['codigo'].'/thumbs/'.$row['nombre_archivo'];
			array_push($arrListado,
				array(
					'idarchivo' => $row['idarchivo'],
					'idusuario' => NULL,
					'idcliente' => $row['idcliente'],
					'nombre_archivo' => $row['nombre_archivo'],
					'size' => $row['size'],
					'fecha_subida' => $row['fecha_subida'],
					'descargado' => $row['descargado'],
					'fecha_descarga' => $row['fecha_descarga'],
					'es_bonificacion' => $row['es_bonificacion'],
					'tipo_archivo' => $row['tipo_archivo'],
					'codigo_usuario' => $row['codigo'],
					'selected' => FALSE,
					'src' => $src,
					'title' => '',
					'fecha_salida' => $row['fecha_salida'],
					'es_salida' => FALSE,
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