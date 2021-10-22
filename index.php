<?php
ob_start();
define('R4F5CC', true);

include_once './lib/lib_clean_url.php';
include_once './config/config.php';
include_once './config/connection.php';

$url = filter_input(INPUT_GET, "url", FILTER_SANITIZE_STRING);
$url_clean = cleanUrl($url);
//var_dump($url);
$url_path = explode("/", $url_clean);

if (isset($url_path[0])) {
    $path_page = $url_path[0];
} else {
    $path_page = "";
}

if (isset($url_path[1])) {
    $path_detail = $url_path[1];
} else {
    $path_detail = "";
}
//var_dump($url_path);
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        include_once './app/sts/include/head.php';
        ?>
    </head>
    <body>

        <?php
        include_once './app/sts/include/menu.php';

        if (!empty($path_page)) {
            if (file_exists("app/sts/view/" . $path_page . ".php")) {
                include "app/sts/view/" . $path_page . ".php";
            } else {
                include "app/sts/view/404.php";
            }
        } else {
            include "app/sts/view/home.php";
        }
        
        include_once './app/sts/include/footer.php';
        
        ?>       

    </body>
</html>
