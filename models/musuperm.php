<?php
/**
 * Resolución de permisos por perfil para el módulo de usuario.
 *
 * La fuente de verdad es la matriz pagxper que se administra desde vusuadmin.php.
 * Se consulta en cada petición para que los cambios del administrador se apliquen
 * sin depender de una sesión antigua.
 */
if (!function_exists('ManejoErrorPermisos')) {
    function ManejoErrorPermisos($e)
    {
        error_log('UrbanPaws Permisos Error: ' . $e->getMessage());
    }
}

class mUsuPerm
{
    private $iduser;
    private $roles = array();
    private $paginas = array();
    private $cargado = false;
    private $error;

    public function __construct($iduser = 0)
    {
        $this->iduser = (int) $iduser;
    }

    public function getIduser()
    {
        return $this->iduser;
    }

    public function setIduser($iduser)
    {
        $this->iduser = (int) $iduser;
        $this->recargar();
    }

    public function getError()
    {
        return $this->error;
    }

    private function setError($mensaje)
    {
        $this->error = $mensaje;
    }

    public function recargar()
    {
        $this->roles = array();
        $this->paginas = array();
        $this->cargado = false;
        $this->error = NULL;
        return $this->cargar();
    }

    private function cargar()
    {
        if ($this->cargado) {
            return true;
        }
        if ($this->iduser <= 0) {
            $this->setError('No hay usuario autenticado.');
            return false;
        }

        try {
            require_once __DIR__ . '/conexion.php';
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();

            $sqlRoles = "SELECT p.idperf, p.nomperf
                         FROM userxper ux
                         INNER JOIN perfil p ON ux.idperf = p.idperf
                         WHERE ux.iduser = :iduser
                         ORDER BY p.idperf";
            $result = $conexion->prepare($sqlRoles);
            $result->bindParam(':iduser', $this->iduser, PDO::PARAM_INT);
            $result->execute();
            $filas = $result->fetchAll(PDO::FETCH_ASSOC);

            foreach ($filas as $fila) {
                $this->roles[] = array(
                    'idperf' => (int) $fila['idperf'],
                    'nomperf' => (string) $fila['nomperf'],
                );
            }

            if (count($this->roles) === 0) {
                $this->cargado = true;
                return true;
            }

            $ids = array();
            foreach ($this->roles as $rol) {
                $ids[] = $rol['idperf'];
            }
            $marcadores = implode(',', array_fill(0, count($ids), '?'));
            $sqlPaginas = "SELECT DISTINCT idpag FROM pagxper
                           WHERE idperf IN ($marcadores)
                           ORDER BY idpag";
            $result = $conexion->prepare($sqlPaginas);
            $result->execute($ids);
            foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $fila) {
                $this->paginas[] = (int) $fila['idpag'];
            }

            $this->cargado = true;
            return true;
        } catch (Exception $e) {
            ManejoErrorPermisos($e);
            $this->setError('No fue posible consultar los permisos del usuario.');
            return false;
        }
    }

    public function getRoles()
    {
        $this->cargar();
        return $this->roles;
    }

    public function getIdperfiles()
    {
        $ids = array();
        foreach ($this->getRoles() as $rol) {
            $ids[] = $rol['idperf'];
        }
        return $ids;
    }

    public function getNombresRoles()
    {
        $nombres = array();
        foreach ($this->getRoles() as $rol) {
            $nombres[] = $rol['nomperf'];
        }
        return $nombres;
    }

    public function getNombreRol()
    {
        $nombres = $this->getNombresRoles();
        return count($nombres) > 0 ? implode(', ', $nombres) : '';
    }

    public function getPaginas()
    {
        $this->cargar();
        return $this->paginas;
    }

    public function tieneRol($nombre)
    {
        $nombre = strtolower(trim((string) $nombre));
        foreach ($this->getRoles() as $rol) {
            if (strtolower(trim($rol['nomperf'])) === $nombre) {
                return true;
            }
        }
        return false;
    }

    public function esAdmin()
    {
        return $this->tieneRol('admin');
    }

    public function esPaseador()
    {
        return $this->tieneRol('paseador');
    }

    public function esCliente()
    {
        return $this->tieneRol('cliente');
    }

    /**
     * Página de inicio según el perfil del usuario.
     * pg=1 se reserva como inicio del rol y siempre está disponible.
     */
    public function dashboard()
    {
        if ($this->esAdmin()) {
            return 2;
        }
        if ($this->esPaseador()) {
            return 3;
        }
        return 1;
    }

    public function puedeVer($pg)
    {
        $pg = (int) $pg;
        if ($pg === 1) {
            return true;
        }
        if (!$this->cargar()) {
            return false;
        }
        return in_array($pg, $this->paginas, true);
    }
}

if (!function_exists('up_permisos')) {
    function up_permisos()
    {
        static $instancia = NULL;
        if ($instancia === NULL) {
            $iduser = isset($_SESSION['iduser']) ? (int) $_SESSION['iduser'] : 0;
            $instancia = new mUsuPerm($iduser);
        }
        return $instancia;
    }
}

if (!function_exists('up_puede_ver')) {
    function up_puede_ver($pg)
    {
        return up_permisos()->puedeVer($pg);
    }
}

if (!function_exists('up_dashboard')) {
    function up_dashboard()
    {
        return up_permisos()->dashboard();
    }
}
?>
