<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Home</h2>
            </div>
        </div>

        <hr class="hr-title">
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Topo</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-lg-block">
                    <a href="edit_home_top" class="btn btn-outline-warning btn-sm">Editar</a>
                </span>
                <div class="dropdown d-block d-lg-none">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                        <a class="dropdown-item" href="edit_home">Editar</a>
                    </div>
                </div>
            </div>
        </div>        
        <?php
        $query_home_top = "SELECT id, title_top, description_top, link_btn_top, txt_btn_top, image FROM sts_homes_tops LIMIT 1";
        $result_home_top = mysqli_query($conn, $query_home_top);
        if (($result_home_top) AND ($result_home_top->num_rows != 0)) {
            $row_home_top = mysqli_fetch_assoc($result_home_top);
            extract($row_home_top);
            //var_dump($row_home_top);

            echo "<dl class='row'>";

            echo "<dt class='col-sm-3'>Imagem:</dt>";
            if (!empty($image) and (file_exists("app/sts/assets/images/home_top/$image"))) {
                $image = "app/sts/assets/images/home_top/$image";
            } else {
                $image = "app/sts/assets/images/home_top/icon_home_top.jpg";
            }
            ?>
            <dd class="col-sm-9 mb-4">
                <div class="img-edit">
                    <img src="<?php echo $image; ?>" alt="Imagem do topo do site" class="img-thumbnail view-img-size-sts">
                    <div class="edit">
                        <a href="<?php echo 'edit_home_top_image?id=' . $id; ?>" class="btn btn-outline-warning btn-sm">
                            <i class="far fa-edit"></i>
                        </a>
                    </div>
                </div>
            </dd>
            <?php
            echo "<dt class='col-sm-3'>Título:</dt>";
            echo "<dd class='col-sm-9'>$title_top</dd>";

            echo "<dt class='col-sm-3'>Descrição:</dt>";
            echo "<dd class='col-sm-9'>$description_top</dd>";

            echo "<dt class='col-sm-3'>Link do Botão:</dt>";
            echo "<dd class='col-sm-9'>$link_btn_top</dd>";

            echo "<dt class='col-sm-3'>Texto do Botão:</dt>";
            echo "<dd class='col-sm-9'>$txt_btn_top</dd>";

            echo "</dl>";
        }
        ?>
        <hr class="hr-title">

        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Serviços</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-lg-block">
                    <a href="edit_home_serv" class="btn btn-outline-warning btn-sm">Editar</a>
                </span>
                <div class="dropdown d-block d-lg-none">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                        <a class="dropdown-item" href="edit_home_serv">Editar</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }

        $query_home_serv = "SELECT id, title_serv, description_serv, icone_um_serv, titulo_um_serv, description_um_serv, icone_dois_serv, titulo_dois_serv, description_dois_serv, icone_tres_serv, titulo_tres_serv, description_tres_serv FROM sts_homes_servs";
        $result_home_serv = mysqli_query($conn, $query_home_serv);
        if (($result_home_serv) AND ($result_home_serv->num_rows != 0)) {
            $row_home_serv = mysqli_fetch_assoc($result_home_serv);
            extract($row_home_serv);
            //var_dump($row_home_serv);

            echo "<dl class='row'>";

            echo "<dt class='col-sm-3'>Título:</dt>";
            echo "<dd class='col-sm-9'>$title_serv</dd>";

            echo "<dt class='col-sm-3'>Descrição:</dt>";
            echo "<dd class='col-sm-9'>$description_serv</dd>";

            echo "<dt class='col-sm-3'>Icone do serviço um:</dt>";
            echo "<dd class='col-sm-9'><i class='$icone_um_serv'></i> - $icone_um_serv</dd>";

            echo "<dt class='col-sm-3'>Título serviço um:</dt>";
            echo "<dd class='col-sm-9'>$titulo_um_serv</dd>";

            echo "<dt class='col-sm-3'>Descrição serviço um:</dt>";
            echo "<dd class='col-sm-9'>$description_um_serv</dd>";

            echo "<dt class='col-sm-3'>Icone do serviço dois:</dt>";
            echo "<dd class='col-sm-9'><i class='$icone_dois_serv'></i> - $icone_dois_serv</dd>";

            echo "<dt class='col-sm-3'>Título serviço dois:</dt>";
            echo "<dd class='col-sm-9'>$titulo_dois_serv</dd>";

            echo "<dt class='col-sm-3'>Descrição serviço dois:</dt>";
            echo "<dd class='col-sm-9'>$description_dois_serv</dd>";

            echo "<dt class='col-sm-3'>Icone do serviço três:</dt>";
            echo "<dd class='col-sm-9'><i class='$icone_tres_serv'></i> -$icone_tres_serv</dd>";

            echo "<dt class='col-sm-3'>Título serviço três:</dt>";
            echo "<dd class='col-sm-9'>$titulo_tres_serv</dd>";

            echo "<dt class='col-sm-3'>Descrição serviço três:</dt>";
            echo "<dd class='col-sm-9'>$description_tres_serv</dd>";

            echo "</dl>";
        }
        ?>

        <hr class="hr-title">

        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Ação</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-lg-block">
                    <a href="edit_home_action" class="btn btn-outline-warning btn-sm">Editar</a>
                </span>
                <div class="dropdown d-block d-lg-none">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                        <a class="dropdown-item" href="edit_home_action">Editar</a>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }

        $query_home_action = "SELECT id, title_action, subtitle_action, description_action, link_btn_action, txt_btn_action, image FROM sts_homes_actions LIMIT 1";
        $result_home_action = mysqli_query($conn, $query_home_action);
        if (($result_home_action) AND ($result_home_action->num_rows != 0)) {
            $row_home_action = mysqli_fetch_assoc($result_home_action);
            extract($row_home_action);
            //var_dump($row_home_action);

            echo "<dl class='row'>";

            echo "<dt class='col-sm-3'>Imagem:</dt>";
            if (!empty($image) and (file_exists("app/sts/assets/images/home_action/$image"))) {
                $image = "app/sts/assets/images/home_action/$image";
            } else {
                $image = "app/sts/assets/images/home_action/icon_chamada_acao.jpg";
            }
            ?>
            <dd class="col-sm-9 mb-4">
                <div class="img-edit">
                    <img src="<?php echo $image; ?>" alt="Imagem da ação do site" class="img-thumbnail view-img-size-sts">
                    <div class="edit">
                        <a href="<?php echo 'edit_home_action_image?id=' . $id; ?>" class="btn btn-outline-warning btn-sm">
                            <i class="far fa-edit"></i>
                        </a>
                    </div>
                </div>
            </dd>
            <?php
            echo "<dt class='col-sm-3'>Título da ação:</dt>";
            echo "<dd class='col-sm-9'>$title_action</dd>";

            echo "<dt class='col-sm-3'>Subtitulo da ação:</dt>";
            echo "<dd class='col-sm-9'>$subtitle_action</dd>";

            echo "<dt class='col-sm-3'>Descrição da ação:</dt>";
            echo "<dd class='col-sm-9'>$description_action</dd>";

            echo "<dt class='col-sm-3'>Link do botão da ação:</dt>";
            echo "<dd class='col-sm-9'>$link_btn_action</dd>";

            echo "<dt class='col-sm-3'>Texto do botão da ação:</dt>";
            echo "<dd class='col-sm-9'>$txt_btn_action</dd>";

            echo "</dl>";
        }
        ?>


        <hr class="hr-title">

        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Detalhes do Serviço</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-lg-block">
                    <a href="edit_home_det" class="btn btn-outline-warning btn-sm">Editar</a>
                </span>
                <div class="dropdown d-block d-lg-none">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                        <a class="dropdown-item" href="edit_home_det">Editar</a>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }

        $query_home_dets = "SELECT id, title_det, subtitle_det, description_det, image FROM sts_homes_dets LIMIT 1";
        $result_home_dets = mysqli_query($conn, $query_home_dets);
        if (($result_home_dets) AND ($result_home_dets->num_rows != 0)) {
            $row_home_dets = mysqli_fetch_assoc($result_home_dets);
            extract($row_home_dets);
            //var_dump($row_home_dets);

            echo "<dl class='row'>";

            echo "<dt class='col-sm-3'>Imagem:</dt>";
            if (!empty($image) and (file_exists("app/sts/assets/images/home_det/$image"))) {
                $image = "app/sts/assets/images/home_det/$image";
            } else {
                $image = "app/sts/assets/images/home_det/icon_detalhes_servico.jpg";
            }
            ?>
            <dd class="col-sm-9 mb-4">
                <div class="img-edit">
                    <img src="<?php echo $image; ?>" alt="Imagem do detalhe do serviço" class="img-thumbnail view-img-size-sts">
                    <div class="edit">
                        <a href="<?php echo 'edit_home_det_image?id=' . $id; ?>" class="btn btn-outline-warning btn-sm">
                            <i class="far fa-edit"></i>
                        </a>
                    </div>
                </div>
            </dd>
            <?php
            echo "<dt class='col-sm-3'>Título:</dt>";
            echo "<dd class='col-sm-9'>$title_det</dd>";

            echo "<dt class='col-sm-3'>Subtitulo do detalhe:</dt>";
            echo "<dd class='col-sm-9'>$subtitle_det</dd>";

            echo "<dt class='col-sm-3'>Descrição do detalhe:</dt>";
            echo "<dd class='col-sm-9'>$description_det</dd>";

            echo "</dl>";
        }
        ?>
    </div>

</div>
</div>