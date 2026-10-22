<?php
/**
 * mMasArchivo — Helper de carga de archivos del módulo Mascotas.
 *
 * Centraliza la subida de la foto de la mascota y del carnet de vacunas:
 *  - valida el CONTENIDO real del archivo (MIME con fileinfo), no el nombre;
 *  - limita el peso a 5 MB;
 *  - deriva la extensión del MIME verificado (un .php nunca se guarda como .php);
 *  - para imágenes exige que getimagesize() las reconozca como imágenes reales;
 *  - almacena en uploads/mascotas/ y devuelve la ruta relativa que va a la BD.
 *
 * No requiere Composer ni librerías externas: solo fileinfo (extensión nativa).
 */
class mMasArchivo
{
    const MAX_BYTES  = 5242880;          // 5 MB
    const CARPETA_REL = 'uploads/mascotas';

    /** MIME permitido => extensión segura con la que se guarda */
    private static $mimeExt = [
        'image/jpeg'      => 'jpg',
        'image/pjpeg'     => 'jpg',
        'image/png'       => 'png',
        'application/pdf' => 'pdf',
    ];

    /**
     * Guarda el archivo enviado en el input $campo.
     *
     * @param string $campo          nombre del input file
     * @param string $prefijo        prefijo del nombre generado (mascota / carnet)
     * @param array  $extPermitidas  extensiones aceptadas: jpg, png, pdf
     * @return array ['ruta' => string|null, 'error' => string|null, 'subido' => bool]
     */
    public static function guardar($campo, $prefijo, $extPermitidas = ['jpg', 'png'])
    {
        $res = ['ruta' => NULL, 'error' => NULL, 'subido' => FALSE];

        if (!isset($_FILES[$campo]) || !is_array($_FILES[$campo])) {
            return $res; // no se envió ningún campo
        }
        $file = $_FILES[$campo];
        $err  = isset($file['error']) ? (int) $file['error'] : UPLOAD_ERR_NO_FILE;

        if ($err === UPLOAD_ERR_NO_FILE) {
            return $res; // el usuario no eligió archivo: se conserva el actual
        }
        if ($err === UPLOAD_ERR_INI_SIZE || $err === UPLOAD_ERR_FORM_SIZE) {
            $res['error'] = "El archivo supera el tamaño máximo permitido (5 MB).";
            return $res;
        }
        if ($err !== UPLOAD_ERR_OK) {
            $res['error'] = "No se pudo subir el archivo. Inténtalo de nuevo.";
            return $res;
        }

        $tmp = isset($file['tmp_name']) ? $file['tmp_name'] : '';
        if ($tmp === '' || !is_uploaded_file($tmp)) {
            $res['error'] = "El archivo recibido no es válido.";
            return $res;
        }

        $tam = (int) @filesize($tmp);
        if ($tam <= 0) {
            $res['error'] = "El archivo está vacío.";
            return $res;
        }
        if ($tam > self::MAX_BYTES) {
            $res['error'] = "El archivo supera el tamaño máximo permitido (5 MB).";
            return $res;
        }

        // MIME real del contenido (no la extensión del nombre)
        $mime = self::mimeReal($tmp);
        if (!isset(self::$mimeExt[$mime])) {
            $res['error'] = "Tipo de archivo no permitido. Solo se aceptan: "
                          . strtoupper(implode(", ", $extPermitidas)) . ".";
            return $res;
        }
        $ext = self::$mimeExt[$mime];

        if (!in_array($ext, $extPermitidas, TRUE)) {
            $res['error'] = "Tipo de archivo no permitido para este campo. Solo se aceptan: "
                          . strtoupper(implode(", ", $extPermitidas)) . ".";
            return $res;
        }

        if ($ext === 'pdf') {
            // Segunda barrera: un PDF debe empezar por la firma %PDF-
            $cab = (string) @file_get_contents($tmp, FALSE, NULL, 0, 5);
            if ($cab !== '%PDF-') {
                $res['error'] = "El archivo no es un PDF válido.";
                return $res;
            }
        } else {
            // Segunda barrera: una imagen debe ser una imagen real
            // (corta un archivo de código renombrado a .jpg)
            $info = @getimagesize($tmp);
            if ($info === FALSE || empty($info['mime']) || !isset(self::$mimeExt[$info['mime']])) {
                $res['error'] = "El archivo no es una imagen válida.";
                return $res;
            }
            $ext = self::$mimeExt[$info['mime']];
            if (!in_array($ext, $extPermitidas, TRUE)) {
                $res['error'] = "Tipo de archivo no permitido para este campo. Solo se aceptan: "
                              . strtoupper(implode(", ", $extPermitidas)) . ".";
                return $res;
            }
        }

        if (!self::asegurarCarpeta()) {
            $res['error'] = "No se pudo preparar la carpeta de archivos del servidor.";
            return $res;
        }

        $nombre = $prefijo . '_' . date('Ymd_His') . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
        $abs    = self::raizApp() . '/' . self::CARPETA_REL . '/' . $nombre;

        if (!@move_uploaded_file($tmp, $abs)) {
            $res['error'] = "No se pudo guardar el archivo en el server.";
            return $res;
        }
        @chmod($abs, 0644);

        $res['ruta']   = self::CARPETA_REL . '/' . $nombre;
        $res['subido'] = TRUE;
        return $res;
    }

    /**
     * Borra un archivo subido. Solo se borra lo que esté dentro de uploads/.
     *
     * @param string|null $rutaRel ruta relativa guardada en la BD
     * @return bool
     */
    public static function eliminar($rutaRel)
    {
        if (empty($rutaRel) || !is_string($rutaRel)) {
            return FALSE;
        }
        $abs  = realpath(self::raizApp() . '/' . ltrim(str_replace('\\', '/', $rutaRel), '/'));
        $base = realpath(self::raizApp() . '/uploads');
        if ($abs === FALSE || $base === FALSE) {
            return FALSE;
        }
        $base = rtrim(str_replace('\\', '/', $base), '/') . '/';
        $abs  = str_replace('\\', '/', $abs);
        if (strpos($abs, $base) !== 0) {
            return FALSE; // fuera de uploads/: nunca se toca
        }
        if (is_file($abs)) {
            return @unlink($abs);
        }
        return FALSE;
    }

    /** Ruta absoluta en disco a partir de la ruta relativa guardada en la BD */
    public static function rutaAbsoluta($rutaRel)
    {
        if (empty($rutaRel)) {
            return '';
        }
        return self::raizApp() . '/' . ltrim(str_replace('\\', '/', $rutaRel), '/');
    }

    /** ¿La ruta apunta a un archivo que realmente existe en disco? */
    public static function existe($rutaRel)
    {
        $abs = self::rutaAbsoluta($rutaRel);
        return ($abs !== '' && is_file($abs));
    }

    /** ¿La ruta apunta a una imagen (jpg/png)? */
    public static function esImagen($rutaRel)
    {
        $ext = strtolower((string) pathinfo((string) $rutaRel, PATHINFO_EXTENSION));
        return in_array($ext, ['jpg', 'jpeg', 'png'], TRUE);
    }

    /** Raíz del proyecto (carpeta que contiene models/, views/, controllers/) */
    public static function raizApp()
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

    /** Crea uploads/ y uploads/mascotas/ con permisos restrictivos y el .htaccess de protección */
    private static function asegurarCarpeta()
    {
        $dirUploads = self::raizApp() . '/uploads';
        $dirMasc    = self::raizApp() . '/' . self::CARPETA_REL;

        if (!is_dir($dirUploads)) {
            @mkdir($dirUploads, 0755, TRUE);
        }
        if (!is_dir($dirMasc)) {
            @mkdir($dirMasc, 0755, TRUE);
        }
        if (!is_dir($dirMasc)) {
            return FALSE;
        }

        // El .htaccess se autogenera si falta (protección contra ejecución de scripts)
        $htaccess = $dirUploads . '/.htaccess';
        if (!file_exists($htaccess)) {
            @file_put_contents($htaccess, self::contenidoHtaccess());
        }
        return TRUE;
    }

    /** Contenido del .htaccess que bloquea la ejecución de scripts en uploads/ */
    public static function contenidoHtaccess()
    {
        return <<<'HTACCESS'
# ==========================================================
#  UrbanPaws - proteccion de la carpeta de archivos subidos
# ==========================================================
#  Este archivo lo genera models/mmasarchivo.php si no existe.
#  Objetivo: que nada de lo que se suba pueda ejecutarse como codigo.

# 1) Apagar el motor PHP para este directorio (si el modulo esta cargado)
<IfModule mod_php.c>
    php_flag engine off
</IfModule>
<IfModule php_module>
    php_flag engine off
</IfModule>

# 2) Desvincular cualquier interprete de la zona de este directorio
RemoveHandler .php .phtml .php3 .php4 .php5 .php7 .php8 .phps .cgi .pl .py .shtml .asp .aspx
RemoveType   .php .phtml .php3 .php4 .php5 .php7 .php8 .phps .cgi .pl .py .shtml .asp .aspx
SetHandler none

# 3) Negar el acceso a cualquier archivo con extension de script
<FilesMatch "(?i)\.(php|phtml|php[0-9]|phps|cgi|pl|py|shtml|asp|aspx|jsp|htaccess)$">
    <IfModule mod_authz_core.c>
        Require all denied
    </IfModule>
    <IfModule !mod_authz_core.c>
        Order allow,deny
        Deny from all
    </IfModule>
</FilesMatch>

# 4) No listar el contenido de los directorios ni permitir CGI
Options -Indexes -ExecCGI

# 5) Cabeceras de seguridad para los archivos servidos
<IfModule mod_headers.c>
    Header always set X-Content-Type-Options "nosniff"
</IfModule>
HTACCESS;
    }
}
