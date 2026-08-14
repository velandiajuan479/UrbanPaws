<?php
class misFun {
    public function ManejoError($e){
        $mjs = "";
        $err = $e->getMessage();
        if(strpos($err,'1062')){
            $mjs = "Registro duplicado. Intente con otro dato.";
        } elseif(strpos($err,'1451')){
            $mjs = "No se puede eliminar. Está relacionado con otro registro.";
        } else {
            $mjs = "Error: " . $err;
        }
        echo '<script>alert("'.$mjs.'");</script>';
    }

    public function titu($nom="Sin Título", $tt="fa-solid fa-circle"){
        $txt = '<h2 class="display-title mb-4"><i class="'.$tt.'"></i> '.$nom.'</h2>';
        return $txt;
    }
}
?>