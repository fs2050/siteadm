<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao encontrada!<br>");
}
?>
<div class="jumbotron head-sobre">
    <div class="container">
        <h1 class="text-center">Sobre a Empresa</h1>
    </div>            
</div>
<?php
$query_abouts = "SELECT id, title, description, image
        FROM sts_abouts_companies
        WHERE sts_situation_id = 1
        ORDER BY id DESC
        LIMIT 40";
$result_abouts = mysqli_query($conn, $query_abouts);
while ($row_about = mysqli_fetch_assoc($result_abouts)) {
    //var_dump($row_about);
    extract($row_about);
    ?>
    <div class="jumbotron sobre">
        <div class="container">
            <div class="row featurette">
                <div class="col-md-7 order-md-2">
                    <h2 class="featurette-heading"><?php echo $title; ?></h2>
                    <p class="lead"><?php echo $description; ?></p>
                </div>

                <div class="col-md-5 order-md-1">
                    <img src="<?php echo URLADM ."/app/sts/assets/images/sobre/". $id . "/" . $image; ?>" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" alt="<?php echo $title; ?>">
                </div>
            </div>
        </div>
    </div>
    <?php
}
