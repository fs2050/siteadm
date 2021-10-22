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
                <h2 class="display-4 title">Editar Senha</h2>
            </div>
            <div class="p-2">
                <a href="list_users" class="btn btn-outline-info btn-sm">Listar</a>
                <a href="view_user?id=<?php echo $id ?>" class="btn btn-outline-primary btn-sm">Visualizar</a>
            </div>
        </div>
        <hr class="hr-title">

        <?php

        if (!empty($id)) {
            $query_user = "SELECT id FROM adms_users WHERE id = $id LIMIT 1";
            $result_user = mysqli_query($conn, $query_user);
            if (($result_user) AND ($result_user->num_rows != 0)) {
                $row_user = mysqli_fetch_assoc($result_user);
                //var_dump($row_profile);
                $user_exist = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Usuário não encontrado!</div>";
                $url_destination = URLADM . "/list_users";
                header("Location: $url_destination");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Usuário não encontrado!</div>";
            $url_destination = URLADM . "/list_users";
            header("Location: $url_destination");
        }

        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($data['EditUserPass'])) {
            $empty_input = false;
            
            include './lib/lib_val_password.php';

            $data = array_map('trim', $data);
            if (in_array("", $data)) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher todos os campos!</div>";
            } elseif (!valPassword($data['password'])) {
                $empty_input = true;
            }

            if (!$empty_input) {
                $password_encrypted = password_hash($data['password'], PASSWORD_DEFAULT);
                $query_up_user = "UPDATE adms_users SET password= '$password_encrypted', modified = NOW() WHERE id = $id LIMIT 1";
                mysqli_query($conn, $query_up_user);
                if (mysqli_affected_rows($conn)) {
                    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Senha atualizada com sucesso!</div>";
                    $url_destination = URLADM . "/view_user?id=$id";
                    header("Location: $url_destination");
                } else {
                    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Senha não atualizada, tente novamente!</div>";
                }
            }
        }

        if ($user_exist) {
            if (!empty($msg)) {
                echo $msg;
                unset($msg);
            }
            ?>
            <span class="msg"></span>
                <form id="edit_profile_pass" method="POST" action="">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="password"><span class="text-danger">*</span> Senha</label>
                            <input name="password" type="password" class="form-control" id="password" placeholder="A senha deve ter no mínimo 6 caracteres" onkeyup="passwordStrength()" value="<?php
                            if (isset($data['password'])) {
                                echo $data['password'];
                            }
                            ?>" autofocus required>
                        </div>
                    </div>
                    <span id="msgviewStrength"></span>

                    <p>
                        <span class="text-danger">*</span> Campo Obrigatório
                    </p>

                    <input type="submit" value="Salvar" name="EditUserPass" class="btn btn-outline-warning btn-sm">
                </form>
            </div>    
        </div>    
        <?php
    }
