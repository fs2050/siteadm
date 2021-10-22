<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

$top_home_exist = false;
$msg = "";

?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Editar Home</h2>
            </div>
            <div class="p-2">
                <a href="view_home" class="btn btn-outline-primary btn-sm">Visualizar</a>
            </div>
        </div>
        <hr class="hr-title">
        <?php

        $query_home_top = "SELECT title_top, description_top, link_btn_top, txt_btn_top 
                    FROM sts_homes_tops LIMIT 1";
        $result_home_top = mysqli_query($conn, $query_home_top);
        if (($result_home_top) AND ($result_home_top->num_rows != 0)) {
            $row_home_top = mysqli_fetch_assoc($result_home_top);
            //var_dump($row_sit_user);
            $top_home_exist = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Topo da página Home não encontrado!</div>";
            $url_destination = URLADM . "/view_home";
            header("Location: $url_destination");
        }

        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($data['EditHomeTop'])) {

            $empty_input = false;

            $data = array_map('trim', $data);
            if (in_array("", $data)) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher todos os campos!</div>";
            }

            if (!$empty_input) {
                $query_up_home_top = "UPDATE sts_homes_tops SET title_top = '" . $data['title_top'] . "', description_top = '" . $data['description_top'] . "', link_btn_top = '" . $data['link_btn_top'] . "', txt_btn_top = '" . $data['txt_btn_top'] . "', modified = NOW() LIMIT 1";
                mysqli_query($conn, $query_up_home_top);

                if (mysqli_affected_rows($conn)) {
                    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Topo da página Home editado com sucesso</div>";
                    $url_destination = URLADM . "/view_home";
                    header("Location: $url_destination");
                } else {
                    $msg = "<div class='alert alert-danger' role='alert'>Erro: Topo da página Home não editado com sucesso!</div>";
                }
            }
        }

        if ($top_home_exist) {
            if (!empty($msg)) {
                echo $msg;
                $msg = "";
            }
            ?>
            <span class="msg"></span>
            <form id="edit_home_top" method="POST" action="">
                <div class="form-group">
                    <label for="title_top"><span class="text-danger">*</span> Título</label>
                    <input name="title_top" type="text" class="form-control" id="title_top" placeholder="Digite o título do topo" value="<?php
                    if (isset($data['title_top'])) {
                        echo $data['title_top'];
                    } elseif (isset($row_home_top['title_top'])) {
                        echo $row_home_top['title_top'];
                    }
                    ?>" autofocus required>
                </div>

                <div class="form-group">
                    <label for="description_top"><span class="text-danger">*</span> Descrição</label>
                    <input name="description_top" type="text" class="form-control" id="description_top" placeholder="Digite a descrição do topo" value="<?php
                    if (isset($data['description_top'])) {
                        echo $data['description_top'];
                    } elseif (isset($row_home_top['description_top'])) {
                        echo $row_home_top['description_top'];
                    }
                    ?>" required>
                </div>

                <div class="form-group">
                    <label for="link_btn_top"><span class="text-danger">*</span> Link do Botão</label>
                    <input name="link_btn_top" type="text" class="form-control" id="link_btn_top" placeholder="Link do botão do topo" value="<?php
                    if (isset($data['link_btn_top'])) {
                        echo $data['link_btn_top'];
                    } elseif (isset($row_home_top['link_btn_top'])) {
                        echo $row_home_top['link_btn_top'];
                    }
                    ?>" required>
                </div>

                <div class="form-group">
                    <label for="txt_btn_top"><span class="text-danger">*</span> Texto do Botão</label>
                    <input name="txt_btn_top" type="text" class="form-control" id="txt_btn_top" placeholder="Texto do botão do topo" value="<?php
                    if (isset($data['txt_btn_top'])) {
                        echo $data['txt_btn_top'];
                    } elseif (isset($row_home_top['txt_btn_top'])) {
                        echo $row_home_top['txt_btn_top'];
                    }
                    ?>" required>
                </div>
                  

                <p>
                    <span class="text-danger">*</span> Campo Obrigatório
                </p>
                <input type="submit" value="Salvar" name="EditHomeTop" class="btn btn-outline-warning btn-sm">
            </form>
        </div>    
    </div>
    <?php
}