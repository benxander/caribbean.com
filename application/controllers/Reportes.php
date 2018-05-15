<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model(
        	array(
        		'model_reportes',
        		'model_cliente',
        	)
        );
        $this->load->helper(
        	array(
        		'fechas_helper'
        	)
        );
        $this->load->library('excel');
    }

    public function listar_reportes(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_reportes->m_cargar_reportes();
		$arrListado = array();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'id' => $row['abreviatura'],
					'idreporte' => $row['idreporte'],
					'titulo' => $row['titulo'],
					'abreviatura' => $row['abreviatura'],
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
	/**
	 * Reporte Clientes por Email
	 * @author Ruben Guevara <rguevara@hotmail.es>
	 * [clientes_email_excel description]
	 * @return [type] [description]
	 */
	public function clientes_email_excel()
	{
		ini_set('max_execution_time', 300);
	    ini_set('memory_limit','160M');
	    $allInputs = json_decode(trim($this->input->raw_input_stream),true);
	    $arrData['flag'] = 0;
	    // TRATAMIENTO DE DATOS
	    $lista = $this->model_cliente->m_cargar_clientes_email($allInputs);
	    // var_dump($lista); exit();
	    $arrListadoProd = array();
        $i = 1;
        foreach ($lista as $row) {
        	array_push($arrListadoProd,
        		array(
        			$i++,
        			$row['codigo'],
        			$row['excursion'],
        			darFormatoDMY($row['fecha_excursion']),
        			$row['email']

        		)
        	);
        }
	    // SETEO DE VARIABLES
	    	$excel = new PHPExcel();
			//Usamos el worsheet por defecto
	    	// $excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();
			$sheet->setTitle('Emails');
			$sheet->setShowGridlines(false);
	    	$dataColumnsTP = array(
	    		array('col' => '#',			'ancho' => 7),
	    		array('col' => 'CODIGO',	'ancho' => 15),
	    		array('col' => 'EXCURSION',	'ancho' => 30),
	    		array('col' => 'FECHA',		'ancho' => 15),
	    		array('col' => 'EMAIL',		'ancho' => 40)
	    	);
	    	$cantColumns = count($dataColumnsTP);
	    	$arrColumns = array();
	    	$a = 'B'; // INICIO DE COLUMNA
	    	for ($x=0; $x < $cantColumns; $x++) {
	    	  $arrColumns[] = $a++;
	    	}
	    	$endColum = end($arrColumns);
	      	$sheet->getColumnDimension('A')->setWidth(2); // por defecto lo ponemos en 2 luego si se usa la columna se cambia

		// ESTILOS
	      	$styleArrayTitle = array(
		        'font'=>  array(
		          'bold'  => false,
		          'size'  => 18,
		          'name'  => 'arial',
		          'color' => array('rgb' => '00000000')
		        ),
		        'alignment' => array(
		          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
		        ),
	      	);
	      	$styleArraySubTitle = array(
		        'font'=>  array(
		          'bold'  => false,
		          'size'  => 12,
		          'name'  => 'arial',
		          'color' => array('rgb' => '000000')
		        ),
		        'alignment' => array(
		          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
		        ),
		    );
	      	$styleArrayHeader = array(
		        'borders' => array(
		          	'allborders' => array(
		            'style' => PHPExcel_Style_Border::BORDER_THIN,
		            'color' => array('rgb' => 'FFFFFF')
		          )
		        ),
		        'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
		        ),
		        'font'=>  array(
		            'bold'  => true,
		            'size'  => 11,
		            'name'  => 'calibri',
		            'color' => array('rgb' => 'FFFFFF')
		        ),
		        'fill' => array(
		            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		            'startcolor' => array( 'rgb' => '328DB7', ),
		        ),
		    );
		    $styleArrayBorder = array(
		        'borders' => array(
		          'allborders' => array(
		            'style' => PHPExcel_Style_Border::BORDER_THIN,
		            'color' => array('rgb' => '000000')
		          )
		        )
		    );
	    // TITULO
			$sheet->setCellValue($arrColumns[0].'1', $allInputs['titulo']);
			$sheet->getStyle($arrColumns[0].'1')->applyFromArray($styleArrayTitle);
			$sheet->mergeCells($arrColumns[0].'1:'. $endColum .'1');

			$sheet->getCell($arrColumns[0].'2')->setValue( 'FECHA: '.$allInputs['fDesde'].' AL '.$allInputs['fHasta'] );
      		$sheet->getStyle($arrColumns[0].'2')->applyFromArray($styleArraySubTitle);
      		$sheet->mergeCells($arrColumns[0].'2:'. $endColum .'2');
      		$currentCellEncabezado = 4; // donde inicia el encabezado del listado

      	// CABECERA
      		$sheet->getStyle($arrColumns[0].$currentCellEncabezado.':'.$endColum.$currentCellEncabezado)->getAlignment()->setWrapText(true);
      		$sheet->getStyle($arrColumns[0].$currentCellEncabezado.':'.$endColum.$currentCellEncabezado)->applyFromArray($styleArrayHeader);
      		$sheet->getRowDimension($currentCellEncabezado)->setRowHeight(38);
      		$sheet->setAutoFilter($arrColumns[0].$currentCellEncabezado.':'.$endColum.$currentCellEncabezado);
      		$i = 0; // se utiliza este contador por si se usan diferentes $dataColumnsTP continuar con la columna siguiente
      		foreach ($dataColumnsTP as $key => $value) {
		        $sheet->getColumnDimension($arrColumns[$i])->setWidth($value['ancho']);
		        $sheet->getCell($arrColumns[$i].$currentCellEncabezado)->setValue($value['col']);
		        $i++;
		    }
      		// $sheet->fromArray($dataColumnsTP, null, $arrColumns[0].$currentCellEncabezado);
      	// LISTADO
      		$finLista = $currentCellEncabezado + count($arrListadoProd);
      		$sheet->fromArray($arrListadoProd, null, $arrColumns[0].($currentCellEncabezado+1));

      		$sheet->getStyle($arrColumns[0].($currentCellEncabezado+1) .':'.$arrColumns[1].($finLista))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      		$sheet->getStyle($arrColumns[3].($currentCellEncabezado+1) .':'.$arrColumns[3].($finLista))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      		$sheet->getStyle($arrColumns[0].($currentCellEncabezado+1) .':'.$endColum.$finLista)->applyFromArray($styleArrayBorder);

		//exportamos nuestro documento
	    $writer = new PHPExcel_Writer_Excel2007($excel);

	    $time = date('His');
		$writer->save('admin/assets/images/dinamic/excelTemporales/clientes_'.$time.'.xlsx');
		if(file_exists('./admin/assets/images/dinamic/excelTemporales/clientes_'.$time.'.xlsx')){
			$arrData['flag'] = 1;
		}
	    $arrData['urlTempEXCEL'] = 'assets/images/dinamic/excelTemporales/clientes_'.$time.'.xlsx';

	    $this->output
	        ->set_content_type('application/json')
	        ->set_output(json_encode($arrData));
	}
}