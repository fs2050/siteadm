<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

$top_home_serv_exist = false;
$msg = "";

?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Editar Serviços da Página Home</h2>
            </div>
            <div class="p-2">
                <a href="view_home" class="btn btn-outline-primary btn-sm">Visualizar</a>
            </div>
        </div>
        <hr class="hr-title">
        <?php

        $query_home_serv = "SELECT title_serv, description_serv, icone_um_serv, titulo_um_serv, description_um_serv, icone_dois_serv, titulo_dois_serv, description_dois_serv, icone_tres_serv, titulo_tres_serv, description_tres_serv FROM sts_homes_servs LIMIT 1";
        $result_home_serv = mysqli_query($conn, $query_home_serv);
        if (($result_home_serv) AND ($result_home_serv->num_rows != 0)) {
            $row_home_serv = mysqli_fetch_assoc($result_home_serv);
            //var_dump($row_home_serv);
            $top_home_serv_exist = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Serviços da página Home não encontrado!</div>";
            $url_destination = URLADM . "/view_home";
            header("Location: $url_destination");
        }

        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($data['EditHomeServ'])) {

            $empty_input = false;

            $data = array_map('trim', $data);
            if (in_array("", $data)) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher todos os campos!</div>";
            }

            if (!$empty_input) {
                $query_up_home_serv = "UPDATE sts_homes_servs SET title_serv = '" . $data['title_serv'] . "', description_serv = '" . $data['description_serv'] . "', icone_um_serv = '" . $data['icone_um_serv'] . "', titulo_um_serv = '" . $data['titulo_um_serv'] . "', description_um_serv = '" . $data['description_um_serv'] . "', icone_dois_serv = '" . $data['icone_dois_serv'] . "', description_dois_serv = '" . $data['description_dois_serv'] . "', icone_tres_serv = '" . $data['icone_tres_serv'] . "', titulo_tres_serv = '" . $data['titulo_tres_serv'] . "', description_tres_serv = '" . $data['description_tres_serv'] . "', modified = NOW() LIMIT 1";
                mysqli_query($conn, $query_up_home_serv);

                if (mysqli_affected_rows($conn)) {
                    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Serviço da página Home editado com sucesso</div>";
                    $url_destination = URLADM . "/view_home";
                    header("Location: $url_destination");
                } else {
                    $msg = "<div class='alert alert-danger' role='alert'>Erro: Serviço da página Home não editado com sucesso!</div>";
                }
            }
        }

        if ($top_home_serv_exist) {
            if (!empty($msg)) {
                echo $msg;
                $msg = "";
            }
            ?>
            <span class="msg"></span>
            <form id="edit_home_serv" method="POST" action="">
                <div class="form-group">
                    <label for="title_serv"><span class="text-danger">*</span> Título do Serviço</label>
                    <input name="title_serv" type="text" class="form-control" id="title_serv" placeholder="Digite o título do serviço" value="<?php
                    if (isset($data['title_serv'])) {
                        echo $data['title_serv'];
                    } elseif (isset($row_home_serv['title_serv'])) {
                        echo $row_home_serv['title_serv'];
                    }
                    ?>" autofocus required>
                </div>

                <div class="form-group">
                    <label for="description_serv"><span class="text-danger">*</span> Descrição do Serviço</label>
                    <textarea name="description_serv" class="form-control" id="description_serv" rows="3" required><?php
                    if (isset($data['description_serv'])) {
                        echo $data['description_serv'];
                    } elseif (isset($row_home_serv['description_serv'])) {
                        echo $row_home_serv['description_serv'];
                    }
                    ?></textarea>
                </div>

                <div class="form-group">
                    <label for="icone_um_serv"><span class="text-danger">*</span> Icone do Serviço Um</label>
                    <input name="icone_um_serv" type="text" class="form-control" id="icone_um_serv" placeholder="Icone do serviço um" value="<?php
                    if (isset($data['icone_um_serv'])) {
                        echo $data['icone_um_serv'];
                    } elseif (isset($row_home_serv['icone_um_serv'])) {
                        echo $row_home_serv['icone_um_serv'];
                    }
                    ?>" required>
                </div>

                <div class="form-group">
                    <label for="titulo_um_serv"><span class="text-danger">*</span> Título do serviço um</label>
                    <input name="titulo_um_serv" type="text" class="form-control" id="titulo_um_serv" placeholder="Título do serviço um" value="<?php
                    if (isset($data['titulo_um_serv'])) {
                        echo $data['titulo_um_serv'];
                    } elseif (isset($row_home_serv['titulo_um_serv'])) {
                        echo $row_home_serv['titulo_um_serv'];
                    }
                    ?>" required>
                </div>

                <div class="form-group">
                    <label for="description_um_serv"><span class="text-danger">*</span> Descrição do serviço um</label>
                    <textarea name="description_um_serv" class="form-control" id="description_um_serv" rows="3" required><?php
                    if (isset($data['description_um_serv'])) {
                        echo $data['description_um_serv'];
                    } elseif (isset($row_home_serv['description_um_serv'])) {
                        echo $row_home_serv['description_um_serv'];
                    }
                    ?></textarea>
                </div>

                <div class="form-group">
                    <label for="icone_dois_serv"><span class="text-danger">*</span> Icone do serviço dois</label>
                    <input name="icone_dois_serv" type="text" class="form-control" id="icone_dois_serv" placeholder="Icone do serviço dois" value="<?php
                    if (isset($data['icone_dois_serv'])) {
                        echo $data['icone_dois_serv'];
                    } elseif (isset($row_home_serv['icone_dois_serv'])) {
                        echo $row_home_serv['icone_dois_serv'];
                    }
                    ?>" required>
                </div>

                <div class="form-group">
                    <label for="titulo_dois_serv"><span class="text-danger">*</span> Título do serviço dois</label>
                    <input name="titulo_dois_serv" type="text" class="form-control" id="titulo_dois_serv" placeholder="Título do serviço dois" value="<?php
                    if (isset($data['titulo_dois_serv'])) {
                        echo $data['titulo_dois_serv'];
                    } elseif (isset($row_home_serv['titulo_dois_serv'])) {
                        echo $row_home_serv['titulo_dois_serv'];
                    }
                    ?>" required>
                </div>

                <div class="form-group">
                    <label for="description_dois_serv"><span class="text-danger">*</span> Descrição do serviço dois</label>                    
                    <textarea name="description_dois_serv" class="form-control" id="description_dois_serv" rows="3" required><?php
                    if (isset($data['description_dois_serv'])) {
                        echo $data['description_dois_serv'];
                    } elseif (isset($row_home_serv['description_dois_serv'])) {
                        echo $row_home_serv['description_dois_serv'];
                    }
                    ?></textarea>
                </div>

                <div class="form-group">
                    <label for="icone_tres_serv"><span class="text-danger">*</span> Icone do serviço três</label>
                    <input name="icone_tres_serv" type="text" class="form-control" id="icone_tres_serv" placeholder="Icone do serviço três" value="<?php
                    if (isset($data['icone_tres_serv'])) {
                        echo $data['icone_tres_serv'];
                    } elseif (isset($row_home_serv['icone_tres_serv'])) {
                        echo $row_home_serv['icone_tres_serv'];
                    }
                    ?>" required>
                </div>

                <div class="form-group">
                    <label for="titulo_tres_serv"><span class="text-danger">*</span> Título do serviço três</label>
                    <input name="titulo_tres_serv" type="text" class="form-control" id="titulo_tres_serv" placeholder="Título do serviço três" value="<?php
                    if (isset($data['titulo_tres_serv'])) {
                        echo $data['titulo_tres_serv'];
                    } elseif (isset($row_home_serv['titulo_tres_serv'])) {
                        echo $row_home_serv['titulo_tres_serv'];
                    }
                    ?>" required>
                </div>

                <div class="form-group">
                    <label for="description_tres_serv"><span class="text-danger">*</span> Descrição do serviço três</label>                    
                    <textarea name="description_tres_serv" class="form-control" id="description_tres_serv" rows="3" required><?php
                    if (isset($data['description_tres_serv'])) {
                        echo $data['description_tres_serv'];
                    } elseif (isset($row_home_serv['description_tres_serv'])) {
                        echo $row_home_serv['description_tres_serv'];
                    }
                    ?></textarea>
                </div>
                  

                <p>
                    <span class="text-danger">*</span> Campo Obrigatório
                </p>
                <input type="submit" value="Salvar" name="EditHomeServ" class="btn btn-outline-warning btn-sm">
            </form>
        </div>    
    </div>
    <?php
}