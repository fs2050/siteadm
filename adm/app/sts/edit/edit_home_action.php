<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

$top_home_action_exist = false;
$msg = "";

?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Editar Ação</h2>
            </div>
            <div class="p-2">
                <a href="view_home" class="btn btn-outline-primary btn-sm">Visualizar</a>
            </div>
        </div>
        <hr class="hr-title">
        <?php

        $query_home_action = "SELECT title_action, subtitle_action, description_action, link_btn_action, txt_btn_action FROM sts_homes_actions LIMIT 1";
        $result_home_action = mysqli_query($conn, $query_home_action);
        if (($result_home_action) AND ($result_home_action->num_rows != 0)) {
            $row_home_action = mysqli_fetch_assoc($result_home_action);
            //var_dump($row_home_serv);
            $top_home_action_exist = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Ação não encontrada!</div>";
            $url_destination = URLADM . "/view_home";
            header("Location: $url_destination");
        }

        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($data['EditHomeAction'])) {

            $empty_input = false;

            $data = array_map('trim', $data);
            if (in_array("", $data)) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher todos os campos!</div>";
            }

            if (!$empty_input) {
                $query_up_home_serv = "UPDATE sts_homes_actions SET title_action = '" . $data['title_action'] . "', subtitle_action = '" . $data['subtitle_action'] . "', description_action = '" . $data['description_action'] . "', link_btn_action = '" . $data['link_btn_action'] . "', txt_btn_action = '" . $data['txt_btn_action'] . "', modified = NOW() LIMIT 1";
                mysqli_query($conn, $query_up_home_serv);

                if (mysqli_affected_rows($conn)) {
                    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Ação editada com sucesso</div>";
                    $url_destination = URLADM . "/view_home";
                    header("Location: $url_destination");
                } else {
                    $msg = "<div class='alert alert-danger' role='alert'>Erro: Ação não editada com sucesso!</div>";
                }
            }
        }

        if ($top_home_action_exist) {
            if (!empty($msg)) {
                echo $msg;
                $msg = "";
            }
            ?>
            <span class="msg"></span>
            <form id="edit_home_action" method="POST" action="">
                <div class="form-group">
                    <label for="title_action"><span class="text-danger">*</span> Título da ação</label>
                    <input name="title_action" type="text" class="form-control" id="title_action" placeholder="Digite o título da ação" value="<?php
                    if (isset($data['title_action'])) {
                        echo $data['title_action'];
                    } elseif (isset($row_home_action['title_action'])) {
                        echo $row_home_action['title_action'];
                    }
                    ?>" autofocus required>
                </div>

                <div class="form-group">
                    <label for="subtitle_action"><span class="text-danger">*</span> Subtitulo da ação</label>
                    <input name="subtitle_action" type="text" class="form-control" id="subtitle_action" placeholder="Subtitulo da ação" value="<?php
                    if (isset($data['subtitle_action'])) {
                        echo $data['subtitle_action'];
                    } elseif (isset($row_home_action['subtitle_action'])) {
                        echo $row_home_action['subtitle_action'];
                    }
                    ?>" required>
                </div>

                <div class="form-group">
                    <label for="description_action"><span class="text-danger">*</span> Descrição da ação</label>
                    <textarea name="description_action" class="form-control" id="description_action" rows="3" required><?php
                    if (isset($data['description_action'])) {
                        echo $data['description_action'];
                    } elseif (isset($row_home_action['description_action'])) {
                        echo $row_home_action['description_action'];
                    }
                    ?></textarea>
                </div>

                <div class="form-group">
                    <label for="link_btn_action"><span class="text-danger">*</span> Link do botão da ação</label>
                    <input name="link_btn_action" type="text" class="form-control" id="link_btn_action" placeholder="Título do serviço um" value="<?php
                    if (isset($data['link_btn_action'])) {
                        echo $data['link_btn_action'];
                    } elseif (isset($row_home_action['link_btn_action'])) {
                        echo $row_home_action['link_btn_action'];
                    }
                    ?>" required>
                </div>

                <div class="form-group">
                    <label for="txt_btn_action"><span class="text-danger">*</span> Texto do botão da ação</label>
                    <input name="txt_btn_action" type="text" class="form-control" id="txt_btn_action" placeholder="Icone do serviço dois" value="<?php
                    if (isset($data['txt_btn_action'])) {
                        echo $data['txt_btn_action'];
                    } elseif (isset($row_home_action['txt_btn_action'])) {
                        echo $row_home_action['txt_btn_action'];
                    }
                    ?>" required>
                </div>
                  

                <p>
                    <span class="text-danger">*</span> Campo Obrigatório
                </p>
                <input type="submit" value="Salvar" name="EditHomeAction" class="btn btn-outline-warning btn-sm">
            </form>
        </div>    
    </div>
    <?php
}