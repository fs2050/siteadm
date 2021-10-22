<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao encontrada!<br>");
}

$query_footer = "SELECT title_site, title_contact, phone, address, url_address, cnpj, url_cnpj, title_social_networks, txt_one_social_networks, link_one_social_networks, txt_two_social_networks, link_two_social_networks, txt_three_social_networks, link_three_social_networks, txt_four_social_networks, link_four_social_networks
            FROM sts_footers
            LIMIT 1";
$result_footer = mysqli_query($conn, $query_footer);

$row_footer = mysqli_fetch_assoc($result_footer);
//var_dump($row_home_serv);
extract($row_footer);
?>

<div class="jumbotron footer-per">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-4">
                <h5><?php echo $title_site; ?></h5>
                <ul class="list-unstyled">
                    <li>
                        <a href="<?php echo URLSITE; ?>" class="link-footer">Home</a>
                    </li>
                    <li>
                        <a href="<?php echo URLSITE . '/sobre'; ?>" class="link-footer">Sobre Empresa</a>
                    </li>
                    <li>
                        <a href="<?php echo URLSITE . '/contato'; ?>" class="link-footer">Contato</a>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-sm-12 col-md-4">
                <h5><?php echo $title_contact; ?></h5>
                <ul class="list-unstyled">
                    <li>
                        <a href="<?php echo $phone; ?>" class="link-footer"><?php echo $phone; ?></a>
                    </li>
                    <li>
                        <a href="<?php echo $url_address; ?>" class="link-footer"><?php echo $address; ?></a>
                    </li>
                    <li>
                        <a href="<?php echo $url_cnpj; ?>" class="link-footer"><?php echo $cnpj; ?></a>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-sm-12 col-md-4">
                <h5><?php echo $title_social_networks; ?></h5>
                <ul class="list-unstyled">
                    <li>
                        <a href="<?php echo $link_one_social_networks; ?>" target="_blank" class="link-footer"><?php echo $txt_one_social_networks; ?></a>
                    </li>
                    <li>
                        <a href="<?php echo $link_two_social_networks; ?>" target="_blank" class="link-footer"><?php echo $txt_two_social_networks; ?></a>
                    </li>
                    <li>
                        <a href="<?php echo $link_three_social_networks; ?>" target="_blank" class="link-footer"><?php echo $txt_three_social_networks; ?></a>
                    </li>
                    <li>
                        <a href="<?php echo $link_four_social_networks; ?>" target="_blank" class="link-footer"><?php echo $txt_four_social_networks; ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script src="app/sts/assets/js/jquery.min.js"></script>
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="app/sts/assets/js/custom.js"></script>

