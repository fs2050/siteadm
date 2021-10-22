<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

$top_home_det_exist = false;
$msg = "";

?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Editar Detalhes do Serviço</h2>
            </div>
            <div class="p-2">
                <a href="view_home" class="btn btn-outline-info btn-sm">Listar</a>
            </div>
        </div>
        <hr class="hr-title">
        <?php

        $query_home_det = "SELECT title_det, subtitle_det, description_det FROM sts_homes_dets LIMIT 1";
        $result_home_det = mysqli_query($conn, $query_home_det);
        if (($result_home_det) AND ($result_home_det->num_rows != 0)) {
            $row_home_det = mysqli_fetch_assoc($result_home_det);
            //var_dump($row_sit_user);
            $top_home_det_exist = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Detalhes do serviço não encontrado!</div>";
            $url_destination = URLADM . "/view_home";
            header("Location: $url_destination");
        }

        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($data['EditHomeDet'])) {

            $empty_input = false;

            $data = array_map('trim', $data);
            if (in_array("", $data)) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher todos os campos!</div>";
            }

            if (!$empty_input) {
                $query_up_home_det = "UPDATE sts_homes_dets SET title_det = '" . $data['title_det'] . "', subtitle_det = '" . $data['subtitle_det'] . "', description_det = '" . $data['description_det'] . "', modified = NOW() LIMIT 1";
                mysqli_query($conn, $query_up_home_det);

                if (mysqli_affected_rows($conn)) {
                    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Detalhes do serviço editado com sucesso</div>";
                    $url_destination = URLADM . "/view_home";
                    header("Location: $url_destination");
                } else {
                    $msg = "<div class='alert alert-danger' role='alert'>Erro: Detalhes do serviço não editado com sucesso!</div>";
                }
            }
        }

        if ($top_home_det_exist) {
            if (!empty($msg)) {
                echo $msg;
                $msg = "";
            }
            ?>
            <span class="msg"></span>
            <form id="edit_home_det" method="POST" action="">
                <div class="form-group">
                    <label for="title_det"><span class="text-danger">*</span> Título do detalhe</label>
                    <input name="title_det" type="text" class="form-control" id="title_det" placeholder="Digite o título do detalhe" value="<?php
                    if (isset($data['title_det'])) {
                        echo $data['title_det'];
                    } elseif (isset($row_home_det['title_det'])) {
                        echo $row_home_det['title_det'];
                    }
                    ?>" autofocus required>
                </div>

                <div class="form-group">
                    <label for="subtitle_det"><span class="text-danger">*</span> Subtitulo do detalhe</label>
                    <input name="subtitle_det" type="text" class="form-control" id="subtitle_det" placeholder="Nome da situação para usuário" value="<?php
                    if (isset($data['subtitle_det'])) {
                        echo $data['subtitle_det'];
                    } elseif (isset($row_home_det['subtitle_det'])) {
                        echo $row_home_det['subtitle_det'];
                    }
                    ?>" required>
                </div>

                <div class="form-group">
                    <label for="description_det"><span class="text-danger">*</span> Descrição do detalhe</label> 
                    <textarea name="description_det" class="form-control" id="description_det" rows="3" required><?php
                    if (isset($data['description_det'])) {
                        echo $data['description_det'];
                    } elseif (isset($row_home_det['description_det'])) {
                        echo $row_home_det['description_det'];
                    }
                    ?></textarea>
                </div>                  

                <p>
                    <span class="text-danger">*</span> Campo Obrigatório
                </p>
                <input type="submit" value="Salvar" name="EditHomeDet" class="btn btn-outline-warning btn-sm">
            </form>
        </div>    
    </div>
    <?php
}