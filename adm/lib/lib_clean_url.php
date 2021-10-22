<?php

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

function cleanUrl($url){
    $format_a = '"!@#$%*()+{[}];:,\\\'<>°ºª';
    $format_b = '____________________________';
    $content_strtr = strtr($url, $format_a, $format_b);
    $content_replace = str_ireplace(" ", "", $content_strtr);
    $content_tag = strip_tags($content_replace);
    $content_url = trim($content_tag);
    
    return $content_url;
}
