<?php

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

function uploadImgResize($image, $destiny, $width, $height) {
    if (!file_exists($destiny)) {
        mkdir($destiny, 0755);
    }
    switch ($image['type']) {
        case 'image/png';
        case 'image/x-png';

            //Criar uma nova imagem a partir de um arquivo
            $image_temp = imagecreatefrompng($image['tmp_name']);

            //Redimensionar a imagem
            $img_resized = resizeImgem($image_temp, $width, $height);

            //Realizar o upload da imagem redimensionada
            if (imagepng($img_resized, $destiny . $image['name'], 1)) {
                return true;
            } else {
                return false;
            }
            break;
        case 'image/jpeg';
        case 'image/pjpeg';
            //Criar uma nova imagem a partir de um arquivo
            $image_temp = imagecreatefromjpeg($image['tmp_name']);

            //Redimensionar a imagem
            $img_resized = resizeImgem($image_temp, $width, $height);

            //Realizar o upload da imagem redimensionada
            if (imagejpeg($img_resized, $destiny . $image['name'], 100)) {
                return true;
            } else {
                return false;
            }
            break;            
        default:
            return false;
    }
}

function resizeImgem($image_temp, $width, $height) {
    $original_width = imagesx($image_temp);
    $original_height = imagesy($image_temp);

    $img_resized = imagecreatetruecolor($width, $height);

    imagecopyresampled($img_resized, $image_temp, 0, 0, 0, 0, $width, $height, $original_width, $original_height);

    return $img_resized;
}
