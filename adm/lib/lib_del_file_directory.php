<?php

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

function delFileDirectory($directory, $image) {
    if (file_exists($directory . $image)) {
        unlink($directory . $image);
    }
    if(file_exists($directory)){
        rmdir($directory);
    }
}
