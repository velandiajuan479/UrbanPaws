<?php
class misFun{
    public function ManejoError($e){
        $mjs = "";
        $err = $e->getMessage();
        $e = isset($err) ? $err : NULL;
        if(strpos($e,'1115') || strpos($e,'1451')){
            $mjs = "No se puede eliminar este registro.<br>Por que se encuentra relacionado en otra opcion.";
        }elseif(strpos($e,'1116') || strpos($e,'1062')){
            $mjs = "Registro duplicado. Intente nuevamente con otro numero de identificacion o comuniquese con el administrador del sistema.";
        }else{
            $mjs = "Se genero un error comuniquese con el administrador del sistema. <br><br>" . $e;
        }
        echo '<script>err("' . $mjs . '");</script>';
    }

    public function titu($nom="Sin Titulo", $tt="fa-solid fa-user"){
        $txt = '';
        $txt .= '<h2 class="display-title">';
        $txt .= '<i class="' . $tt . '"></i> ';
        $txt .= $nom;
        $txt .= '</h2>';
        return $txt;
    }
}
?>