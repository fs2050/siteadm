<?php

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

function uploadFile($image, $destiny) {
    if(!file_exists($destiny)){
        mkdir($destiny, 0755);
    }
    if(move_uploaded_file($image['tmp_name'], $destiny . $image['name'])){
        return true;
    }else{
        return false;
    }
    
}
