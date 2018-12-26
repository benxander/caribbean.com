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
		$bool_video = FALSE;
		$video = NULL;
		if( file_exists('./uploads/temporal/videos_demo/' . $lista[0]['idexcursion'] . '-demo.mp4') ){
			$bool_video = TRUE;
			$video = '../uploads/temporal/videos_demo/' . $lista[0]['idexcursion'] . '-demo.mp4';
		}
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
    	$arrData['datos_solo_fotos'] = $arrListado;
		if( $bool_video ){
			array_push($arrListado,
				array(
					'nombre_archivo' => $video,
					'tipo_archivo' => 2,
					'selected' => FALSE,
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

	public function comprimir_seleccionados()
	{
		ini_set("memory_limit","2G");
		$arrData['flag'] = 0;
		$arrData['datos'] = NULL;
		$arrData['message'] = 'Ocurrió un error';

		$allInputs = json_decode(trim($this->input->raw_input_stream),true);

		// var_dump($allInputs); exit();
		$cod_usuario = $allInputs[0]['codigo_usuario'];
		$zip = new ZipArchive();
		$filename = './uploads/clientes/'. $cod_usuario .'/'. $cod_usuario .'.zip';

		if( $zip->open($filename,ZipArchive::CREATE) === TRUE ){
			foreach ($allInputs as $row) {
				if( $row['selected'] ){
					$ruta = './uploads/clientes/'. $cod_usuario .'/descargadas/'. $row['nombre_archivo'] ;
					$zip->addFile($ruta,$row['nombre_archivo']);
				}
			}
			$zip->close();
		}else{
			$arrData['message'] = 'Ocurrió un error';

		}
		if( file_exists($filename) ){
			$arrData['message'] = 'Zip creado';
			$arrData['flag'] = 1;
			$arrData['datos'] = array(
				'zip' => '../uploads/clientes/'. $cod_usuario .'/'. $cod_usuario .'.zip',
				'nombre' => $cod_usuario .'.zip'
			);
			/*header('Content-Type: application/zip');
			header('Content-disposition: attachment; filename='.$filename);
			header('Content-Length: ' . filesize($filename));
			readfile($filename);
			return;*/
		}else{
			$arrData['message'] = 'No existe el zip';

		}


		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
}