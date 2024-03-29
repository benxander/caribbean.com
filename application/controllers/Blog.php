<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        // Se le asigna a la informacion a la variable $sessionVP.
        // $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
        $this->load->helper(array('fechas','imagen','otros'));
        $this->load->model(array('model_blog'));
    }
	public function listar_noticias(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$paramPaginate = $allInputs['paginate'];
		$lista = $this->model_blog->m_cargar_noticias($paramPaginate);
		$totalRows = $this->model_blog->m_count_noticias($paramPaginate);
		$arrListado = array();
		foreach ($lista as $row) {
			array_push($arrListado, array(
				'idblog' => $row['idblog'],
				'titulo' => $row['titulo'],
				'descripcion' => $row['descripcion'],
				'descripcion_f' => strip_tags($row['descripcion']),
				'autor' => $row['autor'],
				'codigo_youtube' => $row['codigo_youtube'],
				'codigo_vimeo' => $row['codigo_vimeo'],
				'fecha' => date('Y-m-d',strtotime($row['fecha'])),
				// 'fecha' => $row['fecha'],
				'fecha_f' => darFormatoDMY2($row['fecha']),
				'imagen' => $row['imagen'],
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
	public function cargar_noticias_web(){
		ini_set('xdebug.var_display_max_depth', 5);
	    ini_set('xdebug.var_display_max_children', 256);
	    ini_set('xdebug.var_display_max_data', 1024);
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);

		$lista = $this->model_blog->m_cargar_noticias();

		$arrListado = array();

		$ruta = 'uploads/blog/';
		$shortMonthArray = array("","Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Set","Oct","Nov","Dic");
		foreach ($lista as $row) {

			array_push($arrListado, array(
				'idblog' => $row['idblog'],
				'titulo' => $row['titulo'],
				'descripcion' => $row['descripcion'],
				'autor' => $row['autor'],
				'dia' => date('d', strtotime($row['fecha'])),
				'mes' => $shortMonthArray[(int)date('m',strtotime($row['fecha']))],
				'imagen' => $ruta .$row['imagen'],
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
	public function cargar_noticias_seccion(){
		ini_set('xdebug.var_display_max_depth', 5);
	    ini_set('xdebug.var_display_max_children', 256);
	    ini_set('xdebug.var_display_max_data', 1024);
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$paramPaginate = array(
			'sortName' => $allInputs['sortName'],
			'sort' => $allInputs['sort'],
			'pageSize' => $allInputs['limit'],
			'firstRow' => 0,
		);
		$lista = $this->model_blog->m_cargar_noticias($paramPaginate);

		$arrListado = array();

		$ruta = 'uploads/blog/';
		$shortMonthArray = array("","Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Set","Oct","Nov","Dic");
		foreach ($lista as $row) {

			array_push($arrListado, array(
				'idblog' => $row['idblog'],
				'titulo' => $row['titulo'],
				'descripcion' => $row['descripcion'],
				'autor' => $row['autor'],
				'fecha' => formatoFechaReporte3($row['fecha']),
				'dia' => date('d', strtotime($row['fecha'])),
				'mes' => $shortMonthArray[(int)date('m',strtotime($row['fecha']))],
				'imagen' => $ruta .$row['imagen'],
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
	public function cargar_post_blog(){
		ini_set('xdebug.var_display_max_depth', 5);
	    ini_set('xdebug.var_display_max_children', 256);
	    ini_set('xdebug.var_display_max_data', 1024);
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);

		$lista = $this->model_blog->m_cargar_post_blog($allInputs);
		$listaNoticias = $this->model_blog->m_cargar_noticias();

		$previo = NULL;
		$next = NULL;
		$cantidad = count($listaNoticias);
		// var_dump($listaNoticias);
		for ($i=0; $i < $cantidad; $i++) {
			if($listaNoticias[$i]['idblog'] == $allInputs['id']){
				if($i > 0 && $i < ($cantidad-1)){
					$previo = $listaNoticias[$i-1]['idblog'];
					$next = $listaNoticias[$i+1]['idblog'];
				}elseif($i > 0 && $i == ($cantidad-1)){
					$previo = $listaNoticias[$i-1]['idblog'];
				}elseif($i == 0 && $i < ($cantidad-1)){
					$next = $listaNoticias[$i+1]['idblog'];
				}
				break;
			}
		}

		$arrListado = array();
		$ruta = 'uploads/blog/';
		$shortMonthArray = array("","Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Set","Oct","Nov","Dic");
		$arrListado = array(
			'idblog' => $lista[0]['idblog'],
			'titulo' => $lista[0]['titulo'],
			'descripcion' => $lista[0]['descripcion'],
			'autor' => $lista[0]['autor'],
			'dia' => date('d', strtotime($lista[0]['fecha'])),
			'mes' => $shortMonthArray[(int)date('m',strtotime($lista[0]['fecha']))],
			'imagen' => $ruta .$lista[0]['imagen'],
			'codigo_youtube' => empty($lista[0]['codigo_youtube']) ? NULL : $lista[0]['codigo_youtube'],
			'codigo_vimeo' => empty($lista[0]['codigo_vimeo']) ? NULL : $lista[0]['codigo_vimeo'],
			'website' => empty($lista[0]['website']) ? NULL : $lista[0]['website'],
			'texto_link' => empty($lista[0]['texto_link']) ? 'Visita el sitio Web' : $lista[0]['texto_link'],
			'posts' => array(),
			'previo' => $previo,
			'next' => $next,
		);

		foreach ($lista as $row) {
			if(!empty($row['idblogpost'])){
				array_push($arrListado['posts'], array(
						'idblogpost' => $row['idblogpost'],
						'autor_post' => $row['autor_post'],
						'comentario' => $row['comentario'],
						'fecha_post' => formatoFechaReporte3($row['fecha_post']),
					)
				);
			}
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
	public function cargar_imagenes_blog(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_blog->m_cargar_imagenes_blog($allInputs);
		$arrListado = array();
		// var_dump($lista); exit();
		$i = 0;
		foreach ($lista as $row) {
			$src_image = '../uploads/blog/'.$row['idblog'].'/'.$row['imagen'];
			$src_image_web = 'uploads/blog/'.$row['idblog'].'/'.$row['imagen'];
			array_push($arrListado,
				array(
					'id' => $i++, // se usa para el carousel
					'idblogimagen' => $row['idblogimagen'],
					'idblog' => $row['idblog'],
					'imagen' => $row['imagen'],
					'src_image_web' => $src_image_web,
					'src_image' => $src_image,
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
	public function cargar_imagenes_blog_web(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_blog->m_cargar_imagenes_blog($allInputs);
		$arrListado = array();
		// var_dump($lista); exit();
		$i = 0;
		foreach ($lista as $row) {
			$src_image_web = 'uploads/blog/'.$row['idblog'].'/'.$row['imagen'];
			$src_thumb_web = 'uploads/blog/'.$row['idblog'].'/thumbs/'.$row['imagen'];
			array_push($arrListado,
				array(
					'thumb' => $src_thumb_web,
					'img'=>$src_image_web,
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
	// MANTENIMIENTO
	public function registrar_noticia()	{
		// $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al registrar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// validaciones
    	if(empty($allInputs['imagen'])){
    		$arrData['message'] = 'Debe subir una imagen';
    		$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($arrData));
			return;
    	}
    	// preparacion y subida de imagen
		$extension = strrchr($allInputs['nombre_imagen'], ".");
		$nombre = substr($allInputs['nombre_imagen'], 0, -strlen($extension));
		$nombre .= '-'. date('YmdHis') . $extension;
		// $ruta = 'uploads/banners/' . $allInputs['tipoBanner']['descripcion'].'/';
		$ruta = 'uploads/blog/';
		// $allInputs['imagen_ba'] = $nombre;
		subir_imagen_Base64($allInputs['imagen'], $ruta , $nombre);
		// data
    	$data = array(

    		'titulo' => trim(strtoupper_total($allInputs['titulo'])),
    		'descripcion' =>$allInputs['descripcion'],
    		'autor' => $allInputs['autor'],
    		'codigo_youtube' => empty($allInputs['codigo_youtube'])? NULL : $allInputs['codigo_youtube'],
    		'codigo_vimeo' => empty($allInputs['codigo_vimeo'])? NULL : $allInputs['codigo_vimeo'],
    		'website' => empty($allInputs['website'])? NULL : $allInputs['website'],
    		'texto_link' => empty($allInputs['texto_link'])? NULL : $allInputs['texto_link'],
    		'imagen' => $nombre,
    		'fecha' => date('Y-m-d',strtotime($allInputs['fecha']))
    	);
    	// print_r($data); exit();
    	if($this->model_blog->m_registrar($data)){
			$arrData['message'] = 'Se registraron los datos correctamente';
    		$arrData['flag'] = 1;
    	}

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function editar_noticia()	{
		// $this->sessionCP = @$this->session->userdata('sess_cp_'.substr(base_url(),-14,9));
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// data
    	$data = array(

    		'titulo' => trim(strtoupper_total($allInputs['titulo'])),
    		'descripcion' => $allInputs['descripcion'],
    		'codigo_youtube' => empty($allInputs['codigo_youtube'])? NULL : $allInputs['codigo_youtube'],
    		'codigo_vimeo' => empty($allInputs['codigo_vimeo'])? NULL : $allInputs['codigo_vimeo'],
    		'website' => empty($allInputs['website'])? NULL : $allInputs['website'],
    		'texto_link' => empty($allInputs['texto_link'])? NULL : $allInputs['texto_link'],
    		'autor' => $allInputs['autor'],
    		'fecha' => date('Y-m-d',strtotime($allInputs['fecha']))
    		// 'fecha' => date('Y-m-d H:i:s'),
    	);

    	// VALIDACIONES
    	if( $allInputs['canvas']){
    		if( empty($allInputs['imagen']) ){
	    		$arrData['message'] = 'Debe subir una imagen';
	    		$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode($arrData));
				return;
	    	}

	    	// preparacion y subida de imagen
			$extension = strrchr($allInputs['nombre_imagen'], ".");
			$nombre = substr($allInputs['nombre_imagen'], 0, -strlen($extension));
			$nombre .= '-'. date('YmdHis') . $extension;
			// $ruta = 'uploads/banners/' . $allInputs['tipoBanner']['descripcion'].'/';
			$ruta = 'uploads/blog/';
			// $allInputs['imagen_ba'] = $nombre;
			subir_imagen_Base64($allInputs['imagen'], $ruta , $nombre);
			$data_imagen = array(
				'imagen' => $nombre
			);
			$data = array_merge($data,$data_imagen);
    	}

    	// var_dump($data); exit();
		if( $this->model_blog->m_editar($data,$allInputs['idblog']) ){
			$arrData['message'] = 'Se editaron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function anular_noticia()	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al anular los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// var_dump($allInputs); exit();
		if($this->model_blog->m_anular($allInputs)){
			$arrData['message'] = 'Se anularon los datos correctamente';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	// GALERIA
	public function upload_galeria(){
		$arrData['message'] = 'Error al subir imagen';
    	$arrData['flag'] = 0;
    	// var_dump($_REQUEST); exit();
		if(!empty( $_FILES )  && isset($_FILES['file'])){

			if(!empty( $_REQUEST )){
				$idblog = $_REQUEST['idblog'];

			    $errors= array();
			    $file_name = $_FILES['file']['name'];
			    $file_size =$_FILES['file']['size'];
			    $file_tmp =$_FILES['file']['tmp_name'];
			    $file_type=$_FILES['file']['type'];
			    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			    $extensions_image = array("jpeg","jpg");
				// CREAR CARPETA
		    	$carpeta = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'blog' . DIRECTORY_SEPARATOR . $idblog;
		    	createCarpetaBlog($carpeta);
				$random = generateRandomString();
				$file_name = $random .'.'. $file_ext;


				// IMAGENES
			    if(in_array($file_ext,$extensions_image)){

			    	if($file_size < 10485760){
						redimenciona(100, $file_tmp, $carpeta. DIRECTORY_SEPARATOR .'thumbs', $file_name);
			    		redimenciona(800, $file_tmp, $carpeta, $file_name);

						$allInputs = array(
							'idblog' 	=> $idblog,
							'imagen'=> $file_name,
						);
				        if($this->model_blog->m_registrar_imagen($allInputs)){
							$arrData['message'] = 'Se subieron las imagenes correctamente. ';
				    		$arrData['flag'] = 1;
						}
			    	}else{
			    		$arrData['message'] = 'El tamaño es mayor a 10Mb';
			    		$this->output
						    ->set_content_type('application/json')
						    ->set_output(json_encode($arrData));
						return;
			    	}
			    }else{
			    	$arrData['message'] = 'No es el formato correcto';
		    		$this->output
					    ->set_content_type('application/json')
					    ->set_output(json_encode($arrData));
					return;
			    }
			}
		}


		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function eliminar_imagen_blog(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al eliminar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;

		if($this->model_blog->m_eliminar_imagen_blog($allInputs)){
			$carpeta = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'blog' . DIRECTORY_SEPARATOR . $allInputs['idblog'];
			unlink($carpeta.DIRECTORY_SEPARATOR.explode(".", $allInputs['imagen'])[0].'.jpg');

			$arrData['message'] = 'Se eliminaron los datos correctamente';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function eliminar_imagenes_blog(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al eliminar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	$carpeta = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'blog' . DIRECTORY_SEPARATOR;

    	foreach ($allInputs as $key => $value) {
    		if($value['selected']){
    			if($this->model_blog->m_eliminar_imagen_blog($value)){
    				unlink($carpeta.$value['idblog'].DIRECTORY_SEPARATOR.$value['imagen']);

					$arrData['message'] = 'Se eliminaron los datos correctamente';
		    		$arrData['flag'] = 1;
				}
    		}
    	}

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

}
