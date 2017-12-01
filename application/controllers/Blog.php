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
	public function listar_noticias()
	{
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
				'link_youtube' => $row['link_youtube'],
				'link_vimeo' => $row['link_vimeo'],
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
		$arrListado = array();
		$ruta = 'uploads/blog/';
		$shortMonthArray = array("","Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Set","Oct","Nov","Dic");
		// if(!empty($lista[0]['link_youtube'])){
		// 	$enlace = 'https://www.youtube.com/embed/' . explode('=', $lista[0]['link_youtube'])[1];
		// }else{
		// 	$enlace = NULL;
		// }
		$arrListado = array(
			'idblog' => $lista[0]['idblog'],
			'titulo' => $lista[0]['titulo'],
			'descripcion' => $lista[0]['descripcion'],
			'autor' => $lista[0]['autor'],
			'dia' => date('d', strtotime($lista[0]['fecha'])),
			'mes' => $shortMonthArray[(int)date('m',strtotime($lista[0]['fecha']))],
			'imagen' => $ruta .$lista[0]['imagen'],
			'enlace' => empty($lista[0]['link_youtube']) ? NULL : $lista[0]['link_youtube'],
			'link_vimeo' => empty($lista[0]['link_vimeo']) ? NULL : $lista[0]['link_vimeo'],
			'codigo_vimeo' => '245013786',
			// 'enlace' => $enlace,
			'posts' => array()
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

    		'titulo' => empty($allInputs['titulo'])? NULL : trim(strtoupper_total($allInputs['titulo'])),
    		'descripcion' => $allInputs['descripcion'],
    		'autor' => $allInputs['autor'],
    		'link_youtube' => $allInputs['link_youtube'],
    		'link_vimeo' => $allInputs['link_vimeo'],
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

    		'titulo' => empty($allInputs['titulo'])? NULL : trim(strtoupper_total($allInputs['titulo'])),
    		'descripcion' => $allInputs['descripcion'],
    		'link_youtube' => $allInputs['link_youtube'],
    		'link_vimeo' => $allInputs['link_vimeo'],
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
						move_uploaded_file($file_tmp, $carpeta . DIRECTORY_SEPARATOR . $file_name);
				        // redimencionMarcaAgua2(500, $carpeta, $file_name);

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

}
