<?php

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

function valExtensionImg($image) {
    switch ($image) {
        case 'image/png';
        case 'image/x-png';
            return true;
        case 'image/jpeg';
        case 'image/pjpeg';
            return true;
        default:
            return false;
    }
}
