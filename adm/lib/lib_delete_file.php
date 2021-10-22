<?php

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

function deleteFile($destiny) {
    if(file_exists($destiny)){
        unlink($destiny);
    }    
}
