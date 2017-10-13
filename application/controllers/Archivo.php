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
		//var_dump($lista); exit();
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
					'idtipoproducto' => $row['idtipoproducto'],
					'producto' => $row['producto'],
					'codigo_usuario' => $row['codigo'],
					'selected' => FALSE,
					'src' => '../uploads/clientes/'.$row['codigo'].'/descargadas/'.$row['nombre_archivo'],
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

	public function listar_archivos_no_descargados(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_archivo->m_cargar_galeria_no_descargados($allInputs);
		$arrListado = array();
		//var_dump($lista); exit();
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
					'idtipoproducto' => $row['idtipoproducto'],
					'producto' => $row['producto'],
					'precio' => $row['precio'],
					'codigo_usuario' => $row['codigo'],
					'selected' => FALSE,
					'src' => '../uploads/clientes/'.$row['codigo'].'/thumbs/'.$row['nombre_archivo'],
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

	public function descargar_archivos_pagados(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['flag'] = 0;
		$arrData['message'] = 'Ha ocurrido error';
		$error = FALSE;
		foreach ($allInputs as $key => $image) {
			if($image['selected']){
				$urloriginal = 'uploads/clientes/'.$image['codigo_usuario'].'/originales/'.$image['nombre_archivo'];
				$urldestino = 'uploads/clientes/'.$image['codigo_usuario'].'/descargadas/'.$image['nombre_archivo'];

				if(!rename($urloriginal,$urldestino)){
					$error = TRUE;
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