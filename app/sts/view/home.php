<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao encontrada!<br>");
}

$query_home_top = "SELECT title_top, description_top, link_btn_top, txt_btn_top, image
            FROM sts_homes_tops
            LIMIT 1";
$result_home_top = mysqli_query($conn, $query_home_top);

$row_home_top = mysqli_fetch_assoc($result_home_top);
//var_dump($row_home_top);
extract($row_home_top);
$img_top = URLADM . "/app/sts/assets/images/home_top/" . $image;
?>
<div class="jumbotron descr-top" style="background-image: url('<?php echo $img_top; ?>');">
    <div class="container text-center">
        <h1 class="display-4"><?php echo $title_top; ?></h1>
        <p class="lead"><?php echo $description_top; ?></p>
        <a class="btn btn-primary btn-lg" href="<?php echo $link_btn_top; ?>" role="button"><?php echo $txt_btn_top; ?></a>
    </div>
</div>
<?php
$query_home_serv = "SELECT title_serv, description_serv, icone_um_serv, titulo_um_serv, description_um_serv, icone_dois_serv, titulo_dois_serv, description_dois_serv, icone_tres_serv, titulo_tres_serv, description_tres_serv
            FROM sts_homes_servs
            LIMIT 1";
$result_home_serv = mysqli_query($conn, $query_home_serv);

$row_home_serv = mysqli_fetch_assoc($result_home_serv);
//var_dump($row_home_serv);
extract($row_home_serv);
?>
<div class="jumbotron descr-serv">
    <div class="container text-center">
        <h2 class="display-4"><?php echo $title_serv; ?></h2>
        <p class="lead pb-4"><?php echo $description_serv; ?></p>

        <div class="row">
            <div class="col-lg-4">
                <div class="rounded-circle circulo centralizar border border-info shadow">
                    <i class="<?php echo $icone_um_serv; ?>"></i>
                </div>
                <h2 class="mt-4 mb-4"><?php echo $titulo_um_serv; ?></h2>
                <p><?php echo $description_um_serv; ?></p>
            </div>
            <div class="col-lg-4">
                <div class="rounded-circle circulo centralizar border border-info shadow">
                    <i class="<?php echo $icone_dois_serv; ?>"></i>
                </div>
                <h2 class="mt-4 mb-4"><?php echo $titulo_dois_serv; ?></h2>
                <p><?php echo $description_dois_serv; ?></p>
            </div>
            <div class="col-lg-4">
                <div class="rounded-circle circulo centralizar border border-info shadow">
                    <i class="<?php echo $icone_tres_serv; ?>"></i>
                </div>
                <h2 class="mt-4 mb-4"><?php echo $titulo_tres_serv; ?></h2>
                <p><?php echo $description_tres_serv; ?></p>
            </div>
        </div>
    </div>
</div>
<?php
$query_home_action = "SELECT title_action, subtitle_action, description_action, link_btn_action, txt_btn_action, image
            FROM sts_homes_actions
            LIMIT 1";
$result_home_action = mysqli_query($conn, $query_home_action);

$row_home_action = mysqli_fetch_assoc($result_home_action);
//var_dump($row_home_serv);
extract($row_home_action);
$img_action = URLADM . "/app/sts/assets/images/home_action/" . $image;
?>
<div class="jumbotron descr-action" style='background-image: url("<?php echo $img_action; ?>");'>
    <div class="container text-center">
        <h4 class="lead mb-4"><?php echo $title_action; ?></h4>
        <h2 class="display-4 mb-4"><?php echo $subtitle_action; ?></h2>
        <p class="lead mb-4"><?php echo $description_action; ?></p>
        <a class="btn btn-primary btn-lg" href="<?php echo $link_btn_action; ?>" role="button"><?php echo $txt_btn_action; ?></a>
    </div>
</div>

<?php
$query_home_det = "SELECT title_det, subtitle_det, description_det, image
            FROM sts_homes_dets
            LIMIT 1";
$result_home_det = mysqli_query($conn, $query_home_det);

$row_home_det = mysqli_fetch_assoc($result_home_det);
//var_dump($row_home_serv);
extract($row_home_det);
?>
<div class="jumbotron descr-det">
    <div class="container">
        <h2 class="display-4 text-center titulo"><?php echo $title_det; ?></h2>

        <div class="row featurette">
            <div class="col-md-7 order-md-2">
                <h2 class="featurette-heading"><?php echo $subtitle_det; ?></h2>
                <p class="lead"><?php echo $description_det; ?></p>
            </div>

            <div class="col-md-5 order-md-1">
                <img src="<?php echo URLADM . '/app/sts/assets/images/home_det/' . $image; ?>" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" alt="Detalhes do serviços...">
            </div>
        </div>
    </div>
</div>
