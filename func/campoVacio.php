<?php
function validaCampoVacio($campo){
    $error="";
    if(empty($campo)){
        $error=true;
    }else{
        $error=false;
    }
    return $error;
}
?>