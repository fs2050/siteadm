<?php

session_start();
ob_start();

define('R4F5CC', true);

include_once './lib/lib_clean_url.php';
include_once './config/config.php';
include_once './config/connection.php';
include_once './lib/lib_validate_access.php';

$url = filter_input(INPUT_GET, "variavel", FILTER_SANITIZE_STRING);
$url_clean = cleanUrl($url);

$url_path = explode("/", $url_clean);

if (isset($url_path['0'])) {
    $path_page = $url_path['0'];
} else {
    $path_page = "";
}

if (isset($url_path['1'])) {
    $path_detail = $url_path['1'];
} else {
    $path_detail = "";
}

$path_page = validateAccess($path_page);

if (!file_exists("app/adms/login/" . $path_page . ".php")) {
    include_once './app/adms/include/head.php';
    include_once './app/adms/include/header.php';
    include_once './app/adms/include/menu.php';
} else {
    include_once './app/adms/include/head_login.php';
}

if (!empty($path_page)) {
    if (file_exists("app/adms/views/" . $path_page . ".php")) {
        include_once "app/adms/views/" . $path_page . ".php";
    } elseif (file_exists("app/adms/login/" . $path_page . ".php")) {
        include_once "app/adms/login/" . $path_page . ".php";
    } elseif (file_exists("app/adms/edit/" . $path_page . ".php")) {
        include_once "app/adms/edit/" . $path_page . ".php";
    } elseif (file_exists("app/adms/lists/" . $path_page . ".php")) {
        include_once "app/adms/lists/" . $path_page . ".php";
    } elseif (file_exists("app/adms/create/" . $path_page . ".php")) {
        include_once "app/adms/create/" . $path_page . ".php";
    } elseif (file_exists("app/adms/delete/" . $path_page . ".php")) {
        include_once "app/adms/delete/" . $path_page . ".php";
    } elseif (file_exists("app/sts/views/" . $path_page . ".php")) {
        include_once "app/sts/views/" . $path_page . ".php";
    } elseif (file_exists("app/sts/edit/" . $path_page . ".php")) {
        include_once "app/sts/edit/" . $path_page . ".php";
    } elseif (file_exists("app/sts/lists/" . $path_page . ".php")) {
        include_once "app/sts/lists/" . $path_page . ".php";
    } elseif (file_exists("app/sts/create/" . $path_page . ".php")) {
        include_once "app/sts/create/" . $path_page . ".php";
    } elseif (file_exists("app/sts/delete/" . $path_page . ".php")) {
        include_once "app/sts/delete/" . $path_page . ".php";
    } else {
        //Redirecionar para a página 404
        //$url_destination = URLADM . "/404";
        //header("Location: $url_destination");
        //Redirecionar para a página de login
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Página não encontrada!</div>";
        $url_destination = URLADM . "/login";
        header("Location: $url_destination");
    }
} else {
    include_once "app/adms/login/login.php";
}

if (!file_exists("app/adms/login/" . $path_page . ".php")) {
    include_once './app/adms/include/footer.php';
} else {
    include_once './app/adms/include/footer_login.php';
}


