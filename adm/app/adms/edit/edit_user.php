<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}
$user_exist = false;
$msg = "";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Editar Usuário</h2>
            </div>
            <div class="p-2">
                <a href="list_users" class="btn btn-outline-info btn-sm">Listar</a>
                <a href="view_user?id=<?php echo $id ?>" class="btn btn-outline-primary btn-sm">Visualizar</a>
            </div>
        </div>
        <hr class="hr-title">

        <?php
        if (!empty($id)) {
            $query_user = "SELECT name, nickname, email, username, adms_sits_user_id 
                    FROM adms_users
                    WHERE id = $id 
                    LIMIT 1";
            $result_user = mysqli_query($conn, $query_user);
            if (($result_user) AND ($result_user->num_rows != 0)) {
                $row_user = mysqli_fetch_assoc($result_user);
                //var_dump($row_user);
                $user_exist = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Usuário não encontrado!</div>";
                $url_destination = URLADM . "/list_users";
                header("Location: $url_destination");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Usuário não encontrado!</div>";
            $url_destination = URLADM . "/list_users";
            header("Location: $url_destination");
        }

        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($data['EditUser'])) {

            $empty_input = false;

            include './lib/lib_val_email.php';
            include './lib/lib_email_single_edit.php';
            include './lib/lib_val_username.php';

            $data = array_map('trim', $data);
            $remove_val['nickname'] = $data['nickname'];
            unset($data['nickname']);
            if (in_array("", $data)) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher todos os campos!</div>";
            } elseif (stristr($data['name'], '"')) {
                $empty_input = true;
                $msg = '<div class="alert alert-danger" role="alert">Erro: Caracter ( " ) utilizado no campo nome inválido!</div>';
            } elseif (!valEmail($data['email'])) {
                $empty_input = true;
            } elseif (valUserEmailSingleEdit($data['email'], $id)) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Este e-mail já está sendo utilizando!</div>";
            } elseif (valUserEmailSingleEdit($data['username'], $id)) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Este usuário já está sendo utilizando!</div>";
            } elseif (!valUsername($data['username'])) {
                $empty_input = true;
            }

            $data['nickname'] = $remove_val['nickname'];
            if (!$empty_input) {
                $query_up_user = "UPDATE adms_users SET name = '" . $data['name'] . "', nickname = '" . $data['nickname'] . "', email = '" . $data['email'] . "', username = '" . $data['username'] . "', adms_sits_user_id ='" . $data['adms_sits_user_id'] . "', modified = NOW() WHERE id = $id LIMIT 1";
                mysqli_query($conn, $query_up_user);

                if (mysqli_affected_rows($conn)) {

                    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Usuário editado com sucesso!</div>";
                    $url_destination = URLADM . "/view_user?id=$id";
                    header("Location: $url_destination");
                } else {
                    $msg = "<div class='alert alert-danger' role='alert'>Erro: Usuário não editado com sucesso!</div>";
                }
            }
        }

        if ($user_exist) {
            if (!empty($msg)) {
                echo $msg;
                $msg = "";
            }
            ?>
            <span class="msg"></span>
            <form id="edit_user" method="POST" action="">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name"><span class="text-danger">*</span> Nome</label>
                        <input name="name" type="text" class="form-control" id="name" placeholder="Nome completo"  value="<?php
                        if (isset($data['name'])) {
                            echo $data['name'];
                        } elseif (isset($row_user['name'])) {
                            echo $row_user['name'];
                        }
                        ?>" autofocus required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nickname">Apelido</label>
                        <input name="nickname" type="text" class="form-control" id="nickname" placeholder="Apelido" value="<?php
                        if (isset($data['nickname'])) {
                            echo $data['nickname'];
                        } elseif (isset($row_user['nickname'])) {
                            echo $row_user['nickname'];
                        }
                        ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email"><span class="text-danger">*</span> E-mail</label>
                        <input name="email" type="text" class="form-control" id="email" placeholder="Melhor e-mail"  value="<?php
                        if (isset($data['email'])) {
                            echo $data['email'];
                        } elseif (isset($row_user['email'])) {
                            echo $row_user['email'];
                        }
                        ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="username">Usuário</label>
                        <input name="username" type="text" class="form-control" id="username" placeholder="Usuário para acessar o administrativo" value="<?php
                        if (isset($data['username'])) {
                            echo $data['username'];
                        } elseif (isset($row_user['username'])) {
                            echo $row_user['username'];
                        }
                        ?>" required>
                    </div>
                </div> 

                <?php
                $query_sits_users = "SELECT id, name FROM adms_sits_users ORDER BY name ASC";
                $result_sits_users = mysqli_query($conn, $query_sits_users);
                ?>
                <div class="form-group">
                    <label for="situation"><span class="text-danger">*</span> Situação</label>
                    <select name="adms_sits_user_id" id="adms_sits_user_id" class="form-control" required>
                        <option selected>Selecione</option>
                        <?php
                        while ($row_sit_user = mysqli_fetch_assoc($result_sits_users)) {
                            $select_sits_user = "";
                            if (isset($data['adms_sits_user_id']) AND ($data['adms_sits_user_id'] == $row_sit_user['id'])) {
                                $select_sits_user = "selected";
                            } elseif (isset($row_user['adms_sits_user_id']) AND ($row_user['adms_sits_user_id'] == $row_sit_user['id'])) {
                                $select_sits_user = "selected";
                            }
                            echo "<option value='" . $row_sit_user['id'] . "' $select_sits_user>" . $row_sit_user['name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <p>
                    <span class="text-danger">*</span> Campo Obrigatório
                </p>
                <input type="submit" value="Salvar" name="EditUser" class="btn btn-outline-warning btn-sm">
            </form>
        </div>    
    </div>
    <?php
}