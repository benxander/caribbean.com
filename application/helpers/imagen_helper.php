<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function convertImageToBase64($urlImage)
{
    $type = pathinfo($urlImage, PATHINFO_EXTENSION);
    $data = file_get_contents($urlImage);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return $base64;
}
function subir_imagen_Base64($Base64Img, $ruta, $nombre_foto_con_extension)
{
    list(, $Base64Img) = explode(';', $Base64Img);
    list(, $Base64Img) = explode(',', $Base64Img);
    //Decodificamos $Base64Img codificada en base64.
    $Base64Img = base64_decode($Base64Img);
    $file = $ruta . $nombre_foto_con_extension;
    file_put_contents($file, $Base64Img);
}
function convertBase64ToImage($base64_string, $output_file)
{
    // open the output file for writing
    $ifp = fopen( $output_file, 'wb' );

    // split the string on commas
    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>
    $data = explode( ',', $base64_string );

    // we could add validation here with ensuring count( $data ) > 1
    fwrite( $ifp, base64_decode( $data[ 1 ] ) );

    // clean up the file resource
    fclose( $ifp );

    return $output_file;
}

function subir_fichero($directorio_destino, $nombre_fichero, $nombreArchivo = FALSE)
{
    //if($nombre_fichero){
        $tmp_name = @$_FILES[$nombre_fichero]['tmp_name']; //print_r($tmp_name);
        //var_dump($_FILES['archivo']['error']); exit();
        //var_dump($_FILES[$nombre_fichero]); exit();
        //si hemos enviado un directorio que existe realmente y hemos subido el archivo
        // $path = $_FILES['image']['name'];
        $extension = pathinfo($_FILES[$nombre_fichero]['name'], PATHINFO_EXTENSION);
        if (is_dir($directorio_destino) && is_uploaded_file($tmp_name))
        {
            $img_file = $_FILES[$nombre_fichero]['name'];
            if( !empty($nombreArchivo) ){
                $img_file = $nombreArchivo/*.'.'.$extension*/;
            }
            $img_type = $_FILES[$nombre_fichero]['type'];
            //echo 1;
            // Si se trata de una imagen
            //if (((strpos($img_type, "gif") || strpos($img_type, "jpeg") || strpos($img_type, "jpg")) || strpos($img_type, "png")))
            //{
                //¿Tenemos permisos para subir la imágen?
                //echo 2;
                if (move_uploaded_file($tmp_name, $directorio_destino . '/' . $img_file))
                {
                    return true;
                }
            //}
        }
    //}
    //Si llegamos hasta aquí es que algo ha fallado
    return false;
}
function subir_fichero_solo_PDF($directorio_destino, $nombre_fichero, $fechaUnique)
{

    //if($nombre_fichero){
        $tmp_name = @$_FILES[$nombre_fichero]['tmp_name'];
        //var_dump($tmp_name);
        //si hemos enviado un directorio que existe realmente y hemos subido el archivo
        if (is_dir($directorio_destino) && is_uploaded_file($tmp_name))
        {
            $img_file = $_FILES[$nombre_fichero]['name'];
            $img_type = $_FILES[$nombre_fichero]['type'];
            //echo 1;
            // Si se trata de una imagen
            if ( strpos($img_type, "pdf") )
            {
                //¿Tenemos permisos para subir la imágen?
                //echo 2;
                if (move_uploaded_file($tmp_name, $directorio_destino . '/' . $img_file.$fechaUnique))
                {
                    return true;
                }
            }
        }
    //}
    //Si llegamos hasta aquí es que algo ha fallado
    return false;
}
function crearVistasPrevias150($img,$dir, $width = '150', $height = '150')
    {
                //unset al arreglo config por si existe en memoria
        unset($config);
        $config['image_library']  = 'GD2';
        $config['source_image']   = './'.$dir.'/'.$img;
                //se debe de crear la carpeta thumb dentro de nuestro directorio $dir
        $config['new_image']      = './'.$dir.'/thumbs_150/'.$img;
        $config['create_thumb']   = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width']          = $width;
        $config['height']         = $height;

                //verificamos que no este bacio nuestro archivo a subir
        if(!empty($config['source_image']))
        {
                        //cargamos desde CI  a nuestra libreria image_lib
            $ci =& get_instance();
            $ci->load->library('image_lib', $config);
                        // iniciamos image_lib con el contenido de $config
            $ci->image_lib->initialize($config);

                        //le hacemos resize a nuestra imagen
            if (!$ci->image_lib->resize())
            {
                $error = array('error'=>$ci->image_lib->display_errors());
                return $error;
            }
            else
            {
                return TRUE;
            }
                        //limpeamos el contenido de image_lib esto para crear varias thumbs
            $ci->image_lib->clear();
        }
    }
function crearVistasPreviasCompletas($img,$dir, $width, $height)
    {
                //unset al arreglo config por si existe en memoria
        unset($config);
        $config['image_library']  = 'GD2';
        $config['source_image']   = './'.$dir.'/'.$img;
                //se debe de crear la carpeta thumb dentro de nuestro directorio $dir
        $config['new_image']      = './'.$dir.'/thumbs_completos/'.$img;
        $config['create_thumb']   = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width']          = $width;
        $config['height']         = $height;

                //verificamos que no este bacio nuestro archivo a subir
        if(!empty($config['source_image']))
        {
                        //cargamos desde CI  a nuestra libreria image_lib
            $ci =& get_instance();
            $ci->load->library('image_lib', $config);
                        // iniciamos image_lib con el contenido de $config
            $ci->image_lib->initialize($config);

                        //le hacemos resize a nuestra imagen
            if (!$ci->image_lib->resize())
            {
                $error = array('error'=>$ci->image_lib->display_errors());
                return $error;
            }
            else
            {
                return TRUE;
            }
                        //limpeamos el contenido de image_lib esto para crear varias thumbs
            $ci->image_lib->clear();
        }
    }


function redimencionMarcaAgua($maxsize = 600, $file_tmp, $carpeta, $file_name){

    // el archivo o imagen
    $filename = $file_tmp;

    // Asignar el ancho y alto maximos
    $width = $maxsize;
    $height = $maxsize;

    // mandando las cabeceras correspondientes
    header('Content-type: image/jpeg');

    // obteniendo las dimensiones actuales
    list($width_orig, $height_orig) = getimagesize($filename);
    if ($width && ($width_orig < $height_orig)) {
    $width = ($height / $height_orig) * $width_orig;
    } else {
    $height = ($width / $width_orig) * $height_orig;
    }

    // Cambiando el tamano de la imagen o resample
    $image_p = imagecreatetruecolor($width, $height);
    $image = imagecreatefromjpeg($filename);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

    // Marca de Agua o Watermark
    $watermark = imagecreatefrompng('uploads/Copyright.png');
    $watermark_width = imagesx($watermark);
    $watermark_height = imagesy($watermark);
    $image = imagecreatetruecolor($watermark_width, $watermark_height);
    $dest_x = 0; //$width - $watermark_width - 10;
    $dest_y = 0; //$height - $watermark_height - 10;
    imagecopymerge($image_p, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, 30);

    // Salida
    imagejpeg($image_p, $carpeta . DIRECTORY_SEPARATOR .'thumbs'. DIRECTORY_SEPARATOR . $file_name);
    imagedestroy($image);
    imagedestroy($image_p);
    imagedestroy($watermark);

}

function deleteArchivos($carpeta){
  foreach(glob($carpeta . "/*") as $archivos_carpeta){             
    if (is_dir($archivos_carpeta)){
      deleteArchivos($archivos_carpeta);
    } else {
    unlink($archivos_carpeta);
    }
  }
  rmdir($carpeta);
}

function createCarpetas($carpeta){
    $contenido = '<!DOCTYPE html><html><head>
                    <title>403 Forbidden</title>
                    <style type="text/css">
                        body{background-color:#ffffff;font-family:verdana,sans-serif;
                            font-size: 35px}
                    </style>
                </head>
                <body>
                    <p>Acceso denegado</p>
                </body></html>';

    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777, true);
        file_put_contents($carpeta . DIRECTORY_SEPARATOR .'index.html', $contenido);
    }
    if (!file_exists($carpeta . DIRECTORY_SEPARATOR . 'originales')) {
        mkdir($carpeta . DIRECTORY_SEPARATOR . 'originales', 0777, true);
        file_put_contents($carpeta . DIRECTORY_SEPARATOR . 'originales'. DIRECTORY_SEPARATOR .'index.html', $contenido);
    }
    if (!file_exists($carpeta . DIRECTORY_SEPARATOR .'thumbs')) {
        mkdir($carpeta . DIRECTORY_SEPARATOR . 'thumbs', 0777, true);
        file_put_contents($carpeta . DIRECTORY_SEPARATOR . 'thumbs'. DIRECTORY_SEPARATOR .'index.html', $contenido);
    }
    if (!file_exists($carpeta . DIRECTORY_SEPARATOR .'descargadas')) {
        mkdir($carpeta . DIRECTORY_SEPARATOR .'descargadas', 0777, true);
        file_put_contents($carpeta . DIRECTORY_SEPARATOR . 'descargadas'. DIRECTORY_SEPARATOR .'index.html', $contenido);
    }
}