<?php

//require 'libs/Database.php';

/**
 * Archivo helper.php
 * Funciones complementarias para utilzar en todo el sistema
 */
class Helper {

    function __construct() {
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
    }

    /**
     * Funcion para limpiar un string
     * @param strig $String a quitar caracteres especiales y espacios
     * @return string formateado
     */
    public function cleanUrl($String) {
        $String = str_replace(array('á', 'à', 'â', 'ã', 'ª', 'ä'), "a", $String);
        $String = str_replace(array('Á', 'À', 'Â', 'Ã', 'Ä'), "A", $String);
        $String = str_replace(array('Í', 'Ì', 'Î', 'Ï'), "I", $String);
        $String = str_replace(array('í', 'ì', 'î', 'ï'), "i", $String);
        $String = str_replace(array('é', 'è', 'ê', 'ë'), "e", $String);
        $String = str_replace(array('É', 'È', 'Ê', 'Ë'), "E", $String);
        $String = str_replace(array('ó', 'ò', 'ô', 'õ', 'ö', 'º'), "o", $String);
        $String = str_replace(array('Ó', 'Ò', 'Ô', 'Õ', 'Ö'), "O", $String);
        $String = str_replace(array('ú', 'ù', 'û', 'ü'), "u", $String);
        $String = str_replace(array('Ú', 'Ù', 'Û', 'Ü'), "U", $String);
        $String = str_replace(array('?', '[', '^', '´', '`', '¨', '~', ']', '¿', '!', '¡'), "", $String);
        $String = str_replace("ç", "c", $String);
        $String = str_replace("Ç", "C", $String);
        $String = str_replace("ñ", "n", $String);
        $String = str_replace("Ñ", "N", $String);
        $String = str_replace("Ý", "Y", $String);
        $String = str_replace("ý", "y", $String);

        $String = str_replace("'", "", $String);
        //$String = str_replace(".", "_", $String);
        $String = str_replace(" ", "_", $String);
        $String = str_replace("/", "_", $String);

        $String = str_replace("&aacute;", "a", $String);
        $String = str_replace("&Aacute;", "A", $String);
        $String = str_replace("&eacute;", "e", $String);
        $String = str_replace("&Eacute;", "E", $String);
        $String = str_replace("&iacute;", "i", $String);
        $String = str_replace("&Iacute;", "I", $String);
        $String = str_replace("&oacute;", "o", $String);
        $String = str_replace("&Oacute;", "O", $String);
        $String = str_replace("&uacute;", "u", $String);
        $String = str_replace("&Uacute;", "U", $String);
        return $String;
    }

    /**
     * Funcion para limpiar un input antes de enviarlo por post
     * @param type $data
     * @return type
     */
    public function cleanInput($data) {
        $data = trim($data);
        $data = str_replace("'", "\'", $data);
        $data = htmlspecialchars($data);
        $data = stripslashes($data);

        return $data;
    }

    /**
     * Funcion para mostrar mensajes de alerta
     * @param string $type (success - info - warning - error)
     * @param string $message (mensaje a mostrar)
     * @return string
     */
    public function messageAlert($type, $message) {
        $alert = "";
        switch ($type) {
            case 'success':
                $alert .= '<div class="alert alert-success" role="alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            ' . $message . '
                        </div>';
                break;
            case 'info':
                $alert .= '<div class="alert alert-info" role="alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            ' . $message . '
                        </div>';
                break;
            case 'warning':
                $alert .= '<div class="alert alert-warning" role="alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            ' . $message . '
                        </div>';
                break;
            case 'error':
                $alert .= '<div class="alert alert-danger" role="alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            ' . $message . '
                        </div>';
                break;
        }
        return $alert;
    }

    /**
     * 
     * @return string url anterior del sitio
     */
    public function getUrlAnterior() {
        $url = (!empty($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
        return $url;
    }

    /**
     * Funcion que retorna la url actual en forma de array
     * @return array url
     */
    public function getUrl() {
        $url = $_GET['url'];
        $url = explode('/', $url);
        return $url;
    }

    /**
     * Funcion que lista las opciones del campo enum de una tabla
     * @param string $table
     * @param string $field
     * @return array con las opciones del campo enum
     */
    public function getEnumOptions($table, $field) {
        $finalResult = array();
        if (strlen(trim($table)) < 1)
            return false;
        $query = $this->db->select("show columns from $table");
        foreach ($query as $row) {
            if ($field != $row["Field"])
                continue;
            //check if enum type 
            if (preg_match('/enum.(.*)./', $row['Type'], $match)) {
                $opts = explode(',', $match[1]);
                foreach ($opts as $item)
                    $finalResult[] = substr($item, 1, strlen($item) - 2);
            } else
                return false;
        }
        return $finalResult;
    }

    /**
     * Funcion para obtener las paginas donde nos encontramos
     * @return array
     */
    public function getPage() {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $pagina = (explode('/', $url));
        return $pagina;
    }

    /**
     * Devuelve la ip del visitante
     * @return string IP
     */
    public function getReal_ip() {
        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            return $_SERVER["HTTP_CLIENT_IP"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
            return $_SERVER["HTTP_X_FORWARDED"];
        } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_FORWARDED"])) {
            return $_SERVER["HTTP_FORWARDED"];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    /**
     * Funcion que obtiene el HOST actual
     * @return string
     */
    public function getHost() {
        $host = $_SERVER['HTTP_HOST'];
        return $host;
    }

    /**
     * Funcion que envia un correo a travez de la funcion mail de PHP.
     * @param string $para
     * @param string $asunto
     * @param string $mensaje
     */
    public function sendMail($para, $asunto, $mensaje) {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: Garden Intranet <noresponder@garden.com.py>' . "\r\n";
        $headers .= 'Reply-To: noresponder@garden.com.py' . "\r\n";
        mail($para, $asunto, $mensaje, $headers);
    }

    public function mesEspanol($month) {
        switch (strtolower($month)) {
            case 'january':
                $mes = 'Enero';
                break;
            case 'february':
                $mes = 'Febrero';
                break;
            case 'march':
                $mes = 'Marzo';
                break;
            case 'april':
                $mes = 'Abril';
                break;
            case 'may':
                $mes = 'Mayo';
                break;
            case 'june':
                $mes = 'Junio';
                break;
            case 'july':
                $mes = 'Julio';
                break;
            case 'august':
                $mes = 'Agosto';
                break;
            case 'september':
                $mes = 'Septiembre';
                break;
            case 'october':
                $mes = 'Octubre';
                break;
            case 'november':
                $mes = 'Noviembre';
                break;
            case 'december':
                $mes = 'Diciembre';
                break;
        }
        return $mes;
    }

    function redimensionar($file, $nameFile, $ancho, $alto, $serverdir) {
        # se obtene la dimension y tipo de imagen 
        $datos = getimagesize($file);

        $ancho_orig = $datos[0]; # Anchura de la imagen original 
        $alto_orig = $datos[1];    # Altura de la imagen original 
        $tipo = $datos[2];

        if ($tipo == 1) { # GIF 
            if (function_exists("imagecreatefromgif"))
                $img = imagecreatefromgif($file);
            else
                return false;
        }
        else if ($tipo == 2) { # JPG 
            if (function_exists("imagecreatefromjpeg"))
                $img = imagecreatefromjpeg($file);
            else
                return false;
        }
        else if ($tipo == 3) { # PNG 
            if (function_exists("imagecreatefrompng"))
                $img = imagecreatefrompng($file);
            else
                return false;
        }

        # Se calculan las nuevas dimensiones de la imagen 
        if ($ancho_orig > $alto_orig) {
            $ancho_dest = $ancho;
            $alto_dest = ($ancho_dest / $ancho_orig) * $alto_orig;
        } else {
            $alto_dest = $alto;
            $ancho_dest = ($alto_dest / $alto_orig) * $ancho_orig;
        }

        // imagecreatetruecolor, solo estan en G.D. 2.0.1 con PHP 4.0.6+ 
        $img2 = @imagecreatetruecolor($ancho_dest, $alto_dest) or $img2 = imagecreate($ancho_dest, $alto_dest);

        // Redimensionar 
        // imagecopyresampled, solo estan en G.D. 2.0.1 con PHP 4.0.6+ 
        @imagecopyresampled($img2, $img, 0, 0, 0, 0, $ancho_dest, $alto_dest, $ancho_orig, $alto_orig) or imagecopyresized($img2, $img, 0, 0, 0, 0, $ancho_dest, $alto_dest, $ancho_orig, $alto_orig);

        // Crear fichero nuevo, según extensión. 
        if ($tipo == 1) // GIF 
            if (function_exists("imagegif"))
                imagegif($img2, $serverdir . $nameFile, 60);
            else
                return false;

        if ($tipo == 2) // JPG 
            if (function_exists("imagejpeg"))
                imagejpeg($img2, $serverdir . $nameFile, 60);
            else
                return false;

        if ($tipo == 3)  // PNG 
            if (function_exists("imagepng"))
                imagepng($img2, $serverdir . $nameFile, 6);
            else
                return false;

        return true;
    }

    public function getCategorias() {
        $sql = $this->db->select("select * from categoria");
        return $sql;
    }

    public function loadGalleryImage($id, $tipo) {
        $imagenes = $this->getFilesPost($id, $tipo);
        $contenido = '';
        foreach ($imagenes as $item) {
            $id = $item['id'];
            if ($item['img_principal'] == 1) {
                $img_principal = '<a class="pointer btnImgPrincipal" id="imgPrincipal' . $id . '" data-id="' . $id . '"><span class="label label-success">Principal</span></a>';
                $imgPrincipal = utf8_encode($item['descripcion']);
            } else {
                $img_principal = '<a class="pointer btnImgPrincipal" id="imgPrincipal' . $id . '" data-id="' . $id . '"><span class="label label-warning">Principal</span></a>';
            }
            if ($item['estado'] == 1) {
                $mostrar = '<a class="pointer btnMostrarImg" id="mostrarImg' . $id . '" data-id="' . $id . '"><span class="label label-success">Visible</span></a>';
            } else {
                $mostrar = '<a class="pointer btnMostrarImg" id="mostrarImg' . $id . '" data-id="' . $id . '"><span class="label label-danger">Oculta</span></a>';
            }
            $contenido .= '     <div class="col-sm-3" id="imagenGaleria' . $id . '">
                                    <img class="img-responsive" src="' . ARCHIVOS . utf8_encode($item['descripcion']) . '" alt="Photo">
                                    <p>' . $img_principal . ' | ' . $mostrar . ' | <a class="pointer btnEliminarImg" data-id="' . $id . '" id="eliminarImg' . $id . '"><span class="label label-danger">Eliminar</span></a></p>
                                </div>
                                <!-- /.col -->';
        }
        return $contenido;
    }

    public function loadImage($id) {
        $item = $this->getImage($id);
        $id = $item[0]['id'];
        $img_principal = '<a class="pointer btnImgPrincipal" id="imgPrincipal' . $id . '" data-id="' . $id . '"><span class="label label-warning">Principal</span></a>';
        $mostrar = '<a class="pointer btnMostrarImg" id="mostrarImg' . $id . '" data-id="' . $id . '"><span class="label label-success">Visible</span></a>';
        $contenido = '<div class="col-sm-3" id="imagenGaleria' . $id . '">
                        <img class="img-responsive" src="' . ARCHIVOS . utf8_encode($item[0]['descripcion']) . '" alt="Photo">
                        <p>' . $img_principal . ' | ' . $mostrar . ' | <a class="pointer btnEliminarImg" data-id="' . $id . '" id="eliminarImg' . $id . '"><span class="label label-danger">Eliminar</span></a></p>
                      </div>
                      <!-- /.col -->';
        return $contenido;
    }

    public function getImage($id) {
        $item = $this->db->select("select pa.id, 
                                        pa.descripcion,
                                        pa.img_principal,
                                        pa.estado,
                                        pa.id_post
                                from post_archivo pa 
                                where pa.id = $id");
        return $item;
    }

    public function loadVideo($id) {
        $video = $this->getFilesPost($id, 2);
        $videos = $this->getArchivosPOst($id);
        $imgVideo = '';
        $contenido = '<iframe src="https://www.youtube.com/embed/' . utf8_encode($videos['video'][0]['archivo']) . '" frameborder="0" allowfullscreen></iframe>';
        return $contenido;
    }

    /**
     * Funcion que retorna los archivos relacionados un post
     * @param int $idPost
     * @param int $tipoArchivo (Imagen = 1,Video = 2)
     * @return array
     */
    public function getFilesPost($idPost, $tipoArchivo) {
        $sql = $this->db->select("select pa.id,
                                        pa.descripcion,
                                        pa.img_principal,
                                        pa.estado,
                                        pa.id_post
                                from post_archivo pa 
                                where pa.id_post = $idPost 
                                and pa.id_tipo_archivo = $tipoArchivo");
        return $sql;
    }

    public function getArchivosPOst($idPost) {
        $contenido = $this->db->select("SELECT pa.descripcion,
                                                pa.img_principal,
                                                ta.descripcion as tipoArchivo
                                        FROM post_archivo pa 
                                        LEFT JOIN tipo_archivo ta on ta.id = pa.id_tipo_archivo
                                        WHERE pa.id_post = $idPost;");
        #verificamos que dentro de los archivos no haya ningun video
        $video = false;
        foreach ($contenido as $item) {
            if ($item['tipoArchivo'] == 'Video') {
                $video = true;
            }
        }
        $data = array(
            'tipo' => '',
            'video' => array(),
            'imagenes' => array()
        );
        if ($video == true) {
            $data['tipo'] = 'video';
            foreach ($contenido as $item) {
                if ($item['tipoArchivo'] == 'Video') {
                    $extension = strstr($item['descripcion'], '.', FALSE);
                    $extension = str_replace('.', '', $extension);
                    if ($extension == 'mp4') {
                        $type = 'video/mp4';
                    } else {
                        $type = 'video/ogg';
                    }
                    array_push($data['video'], array('archivo' => $item['descripcion'], 'type' => $type));
                } else {
                    array_push($data['imagenes'], array('imagen' => $item['descripcion'], 'principal' => $item['img_principal']));
                }
            }
        } else {
            $data['tipo'] = 'imagen';
            foreach ($contenido as $item) {
                if ($item['tipoArchivo'] != 'video')
                    array_push($data['imagenes'], array('imagen' => $item['descripcion'], 'principal' => $item['img_principal']));
            }
        }
        return $data;
    }

    public function getDataQuienesSomos() {
        $sql = $this->db->select("SELECT * FROM `quienes_somos`;");
        return $sql[0];
    }

    public function getDataUnidadesNegocio() {
        $sql = $this->db->select("SELECT * FROM `unidades_negocio` where estado = 1;");
        return $sql;
    }

    public function getDataClientes() {
        $sql = $this->db->select("SELECT * FROM `clientes` where estado = 1 ORDER BY RAND();");
        return $sql;
    }

    public function getRedes() {
        $sql = $this->db->select("select * from config_redes where estado = 1");
        return $sql;
    }

    public function getContenidoPrincipal() {
        $contenido = $this->db->select("SELECT  p.id,
                                                p.titulo,
                                                p.contenido,
                                                (SELECT pa.descripcion FROM post_archivo pa WHERE pa.id_post = p.id AND pa.img_principal = 1 AND pa.estado = 1 AND pa.id_tipo_archivo = 1) AS img,
                                                c.descripcion AS categoria,
                                                c.id AS id_categoria,
                                                c.tag,
                                                p.fecha
                                        FROM post p
                                        LEFT JOIN post_categoria pc ON pc.id_post = p.id 
                                        LEFT JOIN categoria c ON c.id = pc.id_categoria
                                        WHERE p.estado = 1
                                        ORDER BY p.fecha DESC
                                        LIMIT 16");
        return $contenido;
    }

    public function getPostTitle($idPost) {
        $sql = $this->db->select("select titulo from post where id = $idPost");
        $data = array(
            'url' => $this->cleanUrl(utf8_encode($sql[0]['titulo'])),
            'titulo' => utf8_encode($sql[0]['titulo'])
        );
        return $data;
    }

    public function getConfigSitio() {
        $sql = $this->db->select("select * from config_sitio where id = 1");
        return $sql[0];
    }

    public function getLocales() {
        $sql = $this->db->select("SELECT * FROM locales where estado = 1");
        $data = array(
            'principal' => '',
            'sedes' => array()
        );
        foreach ($sql as $item) {
            if ($item['casa_central'] == 1) {
                $data['principal'] = array(
                    'tipo_oficina' => utf8_encode($item['tipo_oficina']),
                    'direccion' => utf8_encode($item['direccion']),
                    'telefono' => utf8_encode($item['telefono']),
                    'email' => utf8_encode($item['email']),
                );
            } else {
                array_push($data['sedes'], array(
                    'tipo_oficina' => utf8_encode($item['tipo_oficina']),
                    'direccion' => utf8_encode($item['direccion']),
                    'telefono' => utf8_encode($item['telefono']),
                    'email' => utf8_encode($item['email']),
                ));
            }
        }
        return $data;
    }

    public function getNosotrosFooter() {
        $sql = $this->db->select("select quienes_somos from quienes_somos where id = 1");
        return substr(strip_tags(utf8_encode($sql[0]['quienes_somos'])), 0, 140);
    }
    
    public function getUltimosTrabajos() {
        $contenido = $this->db->select("SELECT  p.id,
                                                p.titulo,
                                                p.contenido,
                                                (SELECT pa.descripcion FROM post_archivo pa WHERE pa.id_post = p.id AND pa.img_principal = 1 AND pa.estado = 1 AND pa.id_tipo_archivo = 1) AS img,
                                                c.descripcion AS categoria,
                                                c.id AS id_categoria,
                                                p.fecha
                                        FROM post p
                                        LEFT JOIN post_categoria pc ON pc.id_post = p.id 
                                        LEFT JOIN categoria c ON c.id = pc.id_categoria
                                        WHERE p.estado = 1
                                        ORDER BY p.fecha DESC
                                        LIMIT 3");
        return $contenido;
    }
    
    public function getVideo(){
        $sql = $this->db->select("select * from config_videos");
        $data = array(
            'portada' => $sql[0]['valor'],
            'reel' => $sql[1]['valor']
        );
        return $data;
    }
    
    public function getTrabajosSinVer(){
        $sql = $this->db->select("SELECT count(*) as cant FROM trabaja where estado = 0;");
        return $sql[0]['cant'];
    }
    
    public function getContactosSinVer(){
        $sql = $this->db->select("SELECT count(*) as cant FROM contacto where estado = 0;");
        return $sql[0]['cant'];
    }
    
    public function getCantTrabajos(){
        $sql = $this->db->select("SELECT count(*) as cant FROM post where estado = 1;");
        return $sql[0]['cant'];
    }
    
    public function getColores() {
        $sql = $this->db->select("SELECT * FROM `config_colores` where estado = 1;");
        return $sql;
    }
}
