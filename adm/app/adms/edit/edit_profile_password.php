<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}
$user_exist = false;
$msg = "";

?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Editar Senha</h2>
            </div>
        </div>
        <hr class="hr-title">

        <?php

        if (isset($_SESSION['user_id'])) {
            $query_profile = "SELECT id FROM adms_users WHERE id = " . $_SESSION['user_id'] . " LIMIT 1";
            $result_profile = mysqli_query($conn, $query_profile);
            if (($result_profile) AND ($result_profile->num_rows != 0)) {
                $row_profile = mysqli_fetch_assoc($result_profile);
                //var_dump($row_profile);
                $user_exist = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Perfil não encontrado!</div>";
                $url_destination = URLADM . "/login";
                header("Location: $url_destination");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Perfil não encontrado!</div>";
            $url_destination = URLADM . "/login";
            header("Location: $url_destination");
        }

        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($data['EditProfilePass'])) {
            $empty_input = false;

            $data = array_map('trim', $data);
            if (in_array("", $data)) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher todos os campos!</div>";
            } elseif (stristr($data['password'], "'")) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Caracter ( ' ) utilizado no campo senha inválido!</div>";
            } elseif (stristr($data['password'], '"')) {
                $empty_input = true;
                $msg = '<div class="alert alert-danger" role="alert">Erro: Caracter ( " ) utilizado no campo senha inválido!</div>';
            } elseif (stristr($data['password'], " ")) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Proibido utilizar espaço em branco no campo senha!</div>";
            } elseif ((strlen($data['password'])) < 6) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: A senha deve ter no mínimo 6 caracteres!</div>";
            } elseif (!preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9!@#$%&*()]{6,}$/', $data['password'])) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: A senha deve ter letras e números!</div>";
            }

            if (!$empty_input) {
                $password_encrypted = password_hash($data['password'], PASSWORD_DEFAULT);
                $query_up_user = "UPDATE adms_users SET password= '$password_encrypted', modified = NOW() WHERE id = " . $_SESSION['user_id'] . " LIMIT 1";
                mysqli_query($conn, $query_up_user);
                if (mysqli_affected_rows($conn)) {
                    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Senha atualizada com sucesso!</div>";
                    $url_destination = URLADM . "/profile";
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
                            <input name="password" type="password" class="form-control" id="password" placeholder="Digite a nova senha" onkeyup="passwordStrength()" value="<?php
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

                    <input type="submit" value="Salvar" name="EditProfilePass" class="btn btn-outline-warning btn-sm">
                </form>
            </div>    
        </div>
        <?php
    }
