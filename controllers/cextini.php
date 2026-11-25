<?php
    require_once(__DIR__ . "/../models/mextini.php");
    require_once(__DIR__ . "/../models/musuperm.php");

    // Captura de POST según vextini.php (Usuario/Email + Contraseña)
    $usuario   = isset($_POST["usuario"]) ? $_POST["usuario"] : "";
    $contrasena = isset($_POST["contrasena"]) ? $_POST["contrasena"] : "";
    $ope       = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : "";

    $mcextini = new mExtini();
    $error_login = "";

    if($ope == "login"){
        // El campo "usuario" puede ser documento, email o teléfono
        $mcextini->setDocu($usuario);
        $mcextini->setEmailu($usuario);
        $mcextini->setTeleu($usuario);

        $user = $mcextini->login();

        if($user && password_verify($contrasena, $user['passusu'])){
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            session_regenerate_id(true);

            $rolesIngreso = array();
            $listaRoles = isset($user['idperf_lista']) ? (string) $user['idperf_lista'] : '';
            if ($listaRoles !== '') {
                foreach (explode(',', $listaRoles) as $idRol) {
                    $idRol = (int) $idRol;
                    if ($idRol > 0) {
                        $rolesIngreso[] = $idRol;
                    }
                }
            }

            $_SESSION['iduser'] = (int) $user['iduser'];
            $_SESSION['emailu'] = $user['emailu'];
            $_SESSION['prinom'] = $user['prinom'];
            $_SESSION['nomperf'] = isset($user['nomperf']) ? (string) $user['nomperf'] : '';
            $_SESSION['roles'] = $rolesIngreso;
            $_SESSION['idperf'] = count($rolesIngreso) > 0 ? $rolesIngreso[0] : 0;

            $permisosIngreso = new mUsuPerm((int) $user['iduser']);
            header("Location: home.php?pg=" . (int) $permisosIngreso->dashboard());
            exit;
        } else {
            $error_login = "Usuario o contraseña incorrectos";
        }
    }

    // Incluir la vista del formulario de login
    include("views/vextini.php");
?>
