<?php

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

function specialCharacters($text) {
    //Substituir os cacracters especiais
    $original = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_+={[}]/?;:,\\\'<>°ºª';
    $to_replace = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr-------------------------------';
    $special_characters = strtr(utf8_decode($text), utf8_decode($original), $to_replace);
    
    //Substituir o espaco em branco pelo traco
    $blank_space = str_replace(" ", "-", $special_characters);
    
    //Reduzir os tracos
    $reduce_strokes = str_replace(array('----', '---', '--'), "-", $blank_space);
    
    //Converter para minusculo
    $tiny = strtolower($reduce_strokes);
    
    return $tiny;
}
