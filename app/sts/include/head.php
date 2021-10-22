<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao encontrada!<br>");
}
//var_dump($path_page);
if (empty($path_page)) {
    $path_page_seo = "home";
} else {
    if (file_exists("app/sts/view/" . $path_page . ".php")) {
        $path_page_seo = $path_page;
    } else {
        $path_page_seo = "404";
    }
    
}
//var_dump($path_page_seo);
$query_seo_head = "SELECT title, description 
        FROM sts_pages 
        WHERE name = '$path_page_seo' 
        LIMIT 1";
$result_seo_head = mysqli_query($conn, $query_seo_head);
$row_seo_head = mysqli_fetch_assoc($result_seo_head);
//var_dump($row_seo_head);
?>

<meta charset="UTF-8">        
<title><?php echo $row_seo_head['title']; ?></title>
<meta name="description" content="<?php echo $row_seo_head['description']; ?>">
<!--link rel="icon" href="app/sts/assets/images/icon/favicon.ico"-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
<link rel="stylesheet" href="app/sts/assets/css/custom.css">