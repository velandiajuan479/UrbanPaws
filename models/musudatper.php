<?php
/**
 * mUsuDatPer — Modelo de Datos personales (pg=7).
 *
 * Gestiona la edición del propio usuario: nombres, correo, teléfono,
 * ubicación y foto de perfil (subida validada a uploads/usuarios/).
 */
require_once 'conexion.php';

if (!function_exists('ManejoError')) {
    function ManejoError($e) {
        error_log("UrbanPaws Error: " . $e->getMessage());
    }
}

class mUsuDatPer
{
    private $iduser;
    private $prinom;
    private $seconom;
    private $priapel;
    private $segapel;
    private $emailu;
    private $teleu;
    private $foto;
    private $idubi;

    const MAX_BYTES   = 5242880; // 5 MB
    const CARPETA_REL = 'uploads/usuarios';

    /** MIME permitido => extensión segura con la que se guarda */
    private static $mimeExt = [
        'image/jpeg' => 'jpg',
        'image/pjpeg' => 'jpg',
        'image/png'  => 'png',
    ];

    function getIduser()  { return $this->iduser; }
    function getPrinom()  { return $this->prinom; }
    function getSeconom() { return $this->seconom; }
    function getPriapel() { return $this->priapel; }
    function getSegapel() { return $this->segapel; }
    function getEmailu()  { return $this->emailu; }
    function getTeleu()   { return $this->teleu; }
    function getFoto()    { return $this->foto; }
    function getIdubi()   { return $this->idubi; }

    function setIduser($iduser)   { $this->iduser = $iduser; }
    function setPrinom($prinom)   { $this->prinom = $prinom; }
    function setSeconom($seconom) { $this->seconom = $seconom; }
    function setPriapel($priapel) { $this->priapel = $priapel; }
    function setSegapel($segapel) { $this->segapel = $segapel; }
    function setEmailu($emailu)   { $this->emailu = $emailu; }
    function setTeleu($teleu)     { $this->teleu = $teleu; }
    function setFoto($foto)       { $this->foto = $foto; }
    function setIdubi($idubi)     { $this->idubi = $idubi; }

    public function getAll()
    {
        try {
            $conexion = (new Conexion())->get_conexion();
            $sql = "SELECT u.iduser, u.prinom, u.seconom, u.priapel, u.segapel, u.emailu, u.teleu, u.foto, u.idubi, b.nomubi
                    FROM usuario u
                    LEFT JOIN ubicacion b ON u.idubi = b.idubi
                    ORDER BY u.prinom ASC";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            ManejoError($e);
            return false;
        }
    }

    public function getOne($iduser)
    {
        try {
            $conexion = (new Conexion())->get_conexion();
            $sql = "SELECT iduser, docu, prinom, seconom, priapel, segapel, emailu, teleu, foto, idubi
                    FROM usuario WHERE iduser = :iduser";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':iduser', $iduser);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            ManejoError($e);
            return false;
        }
    }

    public function upd()
    {
        try {
            $conexion = (new Conexion())->get_conexion();
            $sql = "UPDATE usuario SET
                        prinom = :prinom,
                        seconom = :seconom,
                        priapel = :priapel,
                        segapel = :segapel,
                        emailu = :emailu,
                        teleu = :teleu,
                        foto = :foto,
                        idubi = :idubi
                    WHERE iduser = :iduser";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':prinom', $this->prinom);
            $stmt->bindParam(':seconom', $this->seconom);
            $stmt->bindParam(':priapel', $this->priapel);
            $stmt->bindParam(':segapel', $this->segapel);
            $stmt->bindParam(':emailu', $this->emailu);
            $stmt->bindParam(':teleu', $this->teleu);
            $stmt->bindParam(':foto', $this->foto);
            $stmt->bindParam(':idubi', $this->idubi);
            $stmt->bindParam(':iduser', $this->iduser);
            return $stmt->execute();
        } catch (PDOException $e) {
            ManejoError($e);
            return false;
        }
    }

    /** Catálogo de ubicaciones para el select del formulario */
    public function getUbicaciones()
    {
        try {
            $conexion = (new Conexion())->get_conexion();
            $sql = "SELECT idubi, nomubi, depaubi FROM ubicacion ORDER BY nomubi ASC";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            ManejoError($e);
            return array();
        }
    }

    /**
     * Guarda la foto de perfil enviada en el input $campo.
     * Valida el CONTENIDO real (MIME con fileinfo + getimagesize), no el nombre.
     *
     * @return array ['ruta' => string|null, 'error' => string|null, 'subido' => bool]
     */
    public function subirFoto($campo)
    {
        $res = array('ruta' => NULL, 'error' => NULL, 'subido' => FALSE);

        if (!isset($_FILES[$campo]) || !is_array($_FILES[$campo])) {
            return $res;
        }
        $file = $_FILES[$campo];
        $err  = isset($file['error']) ? (int) $file['error'] : UPLOAD_ERR_NO_FILE;

        if ($err === UPLOAD_ERR_NO_FILE) {
            return $res;
        }
        if ($err === UPLOAD_ERR_INI_SIZE || $err === UPLOAD_ERR_FORM_SIZE) {
            $res['error'] = "La foto supera el tamaño máximo permitido (5 MB).";
            return $res;
        }
        if ($err !== UPLOAD_ERR_OK) {
            $res['error'] = "No se pudo subir la foto. Inténtalo de nuevo.";
            return $res;
        }

        $tmp = isset($file['tmp_name']) ? $file['tmp_name'] : '';
        if ($tmp === '' || !is_uploaded_file($tmp)) {
            $res['error'] = "El archivo recibido no es válido.";
            return $res;
        }

        $tam = (int) @filesize($tmp);
        if ($tam <= 0) {
            $res['error'] = "La foto está vacía.";
            return $res;
        }
        if ($tam > self::MAX_BYTES) {
            $res['error'] = "La foto supera el tamaño máximo permitido (5 MB).";
            return $res;
        }

        // MIME real del contenido (no la extensión del nombre)
        $mime = self::mimeReal($tmp);
        if (!isset(self::$mimeExt[$mime])) {
            $res['error'] = "Tipo de archivo no permitido. Solo se aceptan: JPG y PNG.";
            return $res;
        }
        $ext = self::$mimeExt[$mime];

        // Segunda barrera: debe ser una imagen real (corta un .php renombrado a .jpg)
        $info = @getimagesize($tmp);
        if ($info === FALSE || empty($info['mime']) || !isset(self::$mimeExt[$info['mime']])) {
            $res['error'] = "El archivo no es una imagen válida.";
            return $res;
        }
        $ext = self::$mimeExt[$info['mime']];

        if (!self::asegurarCarpeta()) {
            $res['error'] = "No se pudo preparar la carpeta de fotos del servidor.";
            return $res;
        }

        $nombre = 'usr_' . $this->getIduser() . '_' . date('Ymd_His') . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
        $abs    = self::raizApp() . '/' . self::CARPETA_REL . '/' . $nombre;

        if (!@move_uploaded_file($tmp, $abs)) {
            $res['error'] = "No se pudo guardar la foto en el servidor.";
            return $res;
        }
        @chmod($abs, 0644);

        $res['ruta']   = self::CARPETA_REL . '/' . $nombre;
        $res['subido'] = TRUE;
        return $res;
    }

    /**
     * Borra la foto de perfil actual. Solo borra archivos dentro de
     * uploads/usuarios/: cualquier otra ruta se ignora.
     *
     * @param string|null $rutaRel ruta relativa guardada en la BD
     * @return bool
     */
    public function borrarFoto($rutaRel)
    {
        if (empty($rutaRel) || !is_string($rutaRel)) {
            return FALSE;
        }
        $rutaRel = str_replace('\\', '/', ltrim($rutaRel, '/'));
        if (strpos($rutaRel, self::CARPETA_REL . '/') !== 0) {
            return FALSE; // fuera de uploads/usuarios/: nunca se toca
        }

        $abs  = realpath(self::raizApp() . '/' . $rutaRel);
        $base = realpath(self::raizApp() . '/' . self::CARPETA_REL);
        if ($abs === FALSE || $base === FALSE) {
            return FALSE;
        }
        $base = rtrim(str_replace('\\', '/', $base), '/') . '/';
        $abs  = str_replace('\\', '/', $abs);
        if (strpos($abs, $base) !== 0) {
            return FALSE;
        }
        if (is_file($abs)) {
            return @unlink($abs);
        }
        return FALSE;
    }

    /** Raíz del proyecto (carpeta que contiene models/, views/, controllers/) */
    private static function raizApp()
    {
        return dirname(__DIR__);
    }

    /** Detecta el MIME real del archivo usando fileinfo */
    private static function mimeReal($tmp)
    {
        if (function_exists('finfo_open')) {
            $finfo = @finfo_open(FILEINFO_MIME_TYPE);
            if ($finfo !== FALSE) {
                $mime = @finfo_file($finfo, $tmp);
                finfo_close($finfo);
                if ($mime) {
                    return strtolower(trim($mime));
                }
            }
        }
        if (function_exists('mime_content_type')) {
            $mime = @mime_content_type($tmp);
            if ($mime) {
                return strtolower(trim($mime));
            }
        }
        return '';
    }

    /** Crea uploads/usuarios/ si no existe (el .htaccess de uploads/ ya protege la subcarpeta) */
    private static function asegurarCarpeta()
    {
        $dirUsuarios = self::raizApp() . '/' . self::CARPETA_REL;
        if (!is_dir($dirUsuarios)) {
            @mkdir($dirUsuarios, 0755, TRUE);
        }
        return is_dir($dirUsuarios);
    }
}
?>
