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
    function redimencionMarcaAgua2($maxsize = 600, $carpeta, $file_name) {
        $ci =& get_instance();
        $ci->load->library('image_moo');
        $ci->image_moo->set_watermark_transparency(40);
        //$ci->image_moo->set_jpg_quality(80);
        // el archivo o imagen
        $filename = $carpeta . DIRECTORY_SEPARATOR .'originales'. DIRECTORY_SEPARATOR . $file_name;
        list($width_orig, $height_orig) = getimagesize($filename);
        // Asignar el ancho y alto maximos
        $width = $maxsize;
        $height = $maxsize;
        $miniatura = $carpeta . DIRECTORY_SEPARATOR .'thumbs'. DIRECTORY_SEPARATOR . $file_name;
        $ci->image_moo->load($filename)->resize($width, $height)->save($miniatura, true);

        for ($i=1; $i <= 9; $i++) {
            if($width_orig < $height_orig){
                if(!in_array($i, array(2,5,8))){
                    $ci->image_moo->load($miniatura)->load_watermark('assets/images/watermark2.png')->watermark($i)->save($miniatura, true);
                }
            }else{
                $ci->image_moo->load($miniatura)->load_watermark('assets/images/watermark2.png')->watermark($i)->save($miniatura, true);
            }
        }

        return true;
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
    $image = imagecreatefromjpeg($filename);
    $image_p = imagecreatetruecolor($width, $height);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

    // Marca de Agua o Watermark

    $watermark_image = imagecreatefrompng('assets/images/watermark.png');
    $wm_width = imagesx($watermark_image);
    $wm_height = imagesy($watermark_image);
    $watermark = imagecreatetruecolor($wm_width, $wm_height);

    $dest_x = 0; //$width - $watermark_width - 10;
    $dest_y = 0; //$height - $watermark_height - 10;
    imagecopy($watermark, $watermark_image, 0, 0, 0, 0, $wm_width, $wm_height);
    // imagecopy($watermark, $watermark_image, 0, 0, 0, 0, $wm_width, $wm_height);


    imagecopymerge($image_p, $watermark, $dest_x, $dest_y, 0, 0, $wm_width, $wm_height, 20);
    // imagecopymerge($image_p, $watermark, $dest_x, $dest_y, 0, 0, $wm_width, $wm_height, 30);

    // Salida
    imagejpeg($image_p, $carpeta . DIRECTORY_SEPARATOR .'thumbs'. DIRECTORY_SEPARATOR . $file_name);
    imagedestroy($image);
    imagedestroy($image_p);
    imagedestroy($watermark);
}
function redimenciona($maxsize = 300, $file_tmp, $carpeta, $file_name){
    // ini_set('memory_limit', '100M');
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
    $image = imagecreatefromjpeg($filename);
    $image_p = imagecreatetruecolor($width, $height);
    // imageresolution($image_p, 92);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

     // Salida
    imagejpeg($image_p, $carpeta . DIRECTORY_SEPARATOR . $file_name, 92);
    imagedestroy($image);
    imagedestroy($image_p);
}

function imagenVideo($file_name, $name, $carpeta_destino){

    $video = $file_name;
    $time = '00:00:02';
    $image_destino = $carpeta_destino.$name.'.jpg';
    $ffmpeg_path = 'C:\\ffmpeg\\bin\\';

    // Sacar Imagen del Video
    exec($ffmpeg_path."ffmpeg -i ".$video." -ss ".$time." -vframes 1 ".$image_destino);

    // Marca de Agua o Watermark
    list($image_video_width, $image_video_height) = getimagesize($image_destino);
    $image_video = imagecreatefromjpeg($image_destino);

    $watermark = imagecreatefrompng('assets/images/play_icon.png');
    $watermark_width = imagesx($watermark);
    $watermark_height = imagesy($watermark);

    $image = imagecreatetruecolor($watermark_width, $watermark_height);
    $dest_x = ($image_video_width - $watermark_width) / 2;
    $dest_y = ($image_video_height - $watermark_height) / 2;
    imagecopy($image_video, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height);

    // Salida
    imagejpeg($image_video, $image_destino);
    imagedestroy($image_video);
    imagedestroy($image);
    imagedestroy($watermark);
}

function deleteArchivos($carpeta){
  foreach(glob($carpeta .DIRECTORY_SEPARATOR. "*") as $archivos_carpeta){
    if (is_dir($archivos_carpeta)){
      deleteArchivos($archivos_carpeta);
    } else {
        if(substr($archivos_carpeta, strrpos($archivos_carpeta, ".")+1) != 'html'){
            unlink($archivos_carpeta);
        }
    }
  }
  //rmdir($carpeta);
}

function deleteUnArchivo($carpeta, $archivo){
  foreach(glob($carpeta . "/*") as $value){
    print_r($value . "\n");
    print_r($archivo. "\n");
    if($value == $archivo){
        unlink($value);
    }
  }
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
    if (!file_exists($carpeta . DIRECTORY_SEPARATOR .'thumbs')) {
        mkdir($carpeta . DIRECTORY_SEPARATOR . 'thumbs', 0777, true);
        file_put_contents($carpeta . DIRECTORY_SEPARATOR . 'thumbs'. DIRECTORY_SEPARATOR .'index.html', $contenido);
    }
    if (!file_exists($carpeta . DIRECTORY_SEPARATOR . 'originales')) {
        mkdir($carpeta . DIRECTORY_SEPARATOR . 'originales', 0777, true);
        file_put_contents($carpeta . DIRECTORY_SEPARATOR . 'originales'. DIRECTORY_SEPARATOR .'index.html', $contenido);
    }
    if (!file_exists($carpeta . DIRECTORY_SEPARATOR . 'originales' . DIRECTORY_SEPARATOR . 'thumbs')) {
        mkdir($carpeta . DIRECTORY_SEPARATOR . 'originales'. DIRECTORY_SEPARATOR . 'thumbs', 0777, true);
        file_put_contents($carpeta . DIRECTORY_SEPARATOR . 'originales'. DIRECTORY_SEPARATOR . 'thumbs'. DIRECTORY_SEPARATOR .'index.html', $contenido);
    }
    if (!file_exists($carpeta . DIRECTORY_SEPARATOR .'descargadas')) {
        mkdir($carpeta . DIRECTORY_SEPARATOR .'descargadas', 0777, true);
        file_put_contents($carpeta . DIRECTORY_SEPARATOR . 'descargadas'. DIRECTORY_SEPARATOR .'index.html', $contenido);
    }
    if (!file_exists($carpeta . DIRECTORY_SEPARATOR .'descargadas'. DIRECTORY_SEPARATOR .'thumbs')) {
        mkdir($carpeta . DIRECTORY_SEPARATOR .'descargadas' . DIRECTORY_SEPARATOR .'thumbs', 0777, true);
        file_put_contents($carpeta . DIRECTORY_SEPARATOR . 'descargadas'. DIRECTORY_SEPARATOR . 'thumbs'. DIRECTORY_SEPARATOR .'index.html', $contenido);
    }
}

function createCarpetaBlog($carpeta){
    $contenido = '<!DOCTYPE html><html><head>
                    <title>403 Forbidden</title>
                    <style type="text/css">
                        body{background-color:#ffffff;font-family:verdana,sans-serif;
                            font-size: 18px}
                    </style>
                </head>
                <body>
                    <h1>Acceso denegado</h1>
                </body></html>';

    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777, true);
        file_put_contents($carpeta . DIRECTORY_SEPARATOR .'index.html', $contenido);
    }
    if (!file_exists($carpeta . DIRECTORY_SEPARATOR .'thumbs')) {
        mkdir($carpeta . DIRECTORY_SEPARATOR . 'thumbs', 0777, true);
        file_put_contents($carpeta . DIRECTORY_SEPARATOR . 'thumbs'. DIRECTORY_SEPARATOR .'index.html', $contenido);
    }

}
function createCarpeta($carpeta){
    $contenido = '<!DOCTYPE html><html><head>
                    <title>403 Forbidden</title>
                    <style type="text/css">
                        body{background-color:#ffffff;font-family:verdana,sans-serif;
                            font-size: 18px}
                    </style>
                </head>
                <body>
                    <h1>Acceso denegado</h1>
                </body></html>';

    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777, true);
        file_put_contents($carpeta . DIRECTORY_SEPARATOR .'index.html', $contenido);
    }
}

