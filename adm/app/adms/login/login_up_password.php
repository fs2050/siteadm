<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

$recover_password = filter_input(INPUT_GET, "key", FILTER_SANITIZE_STRING);

$recover_password = str_ireplace(" ", "a", $recover_password);
$msg = "";

if (!empty($recover_password)) {
    $query_user = "SELECT id FROM adms_users WHERE recover_password = '$recover_password' LIMIT 1";
    $result_user = mysqli_query($conn, $query_user);
    if (($result_user) AND ($result_user->num_rows != 0)) {
        $row_user = mysqli_fetch_assoc($result_user);

        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($data['EditPass'])) {
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
                $value_recover_pass = 'NULL';
                $query_up_user = "UPDATE adms_users SET password= '$password_encrypted', recover_password = $value_recover_pass, modified = NOW() WHERE id = " . $row_user['id'] . " LIMIT 1";
                mysqli_query($conn, $query_up_user);
                if (mysqli_affected_rows($conn)) {
                    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Senha atualizada com sucesso!</div>";
                    $url_destination = URLADM . "/login";
                    header("Location: $url_destination");
                } else {
                    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Senha não atualizada, tente novamente!</div>";
                }
            }
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Link inválido, solicite novo link <a href='" . URLADM . "/login_recover_password'>clique aqui</a>!</div>";
        $url_destination = URLADM . "/login";
        header("Location: $url_destination");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Link inválido, solicite novo link <a href='" . URLADM . "/login_recover_password'>clique aqui</a>!</div>";
    $url_destination = URLADM . "/login";
    header("Location: $url_destination");
}
?>
<form class="form-signin" id="login_up_pass" method="POST" action="login_up_password?key=<?php if(!empty($recover_password)) { echo $recover_password; } ?>">
    
    <div class="text-center mb-4">
        <img class="mb-4" src="app/adms/assets/images/logo/logo.png" alt="Celke" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal text-light">Nova Senha</h1>
    </div>
    <span class="msg"></span>
    <?php
    if (!empty($msg)) {
        echo $msg;
        unset($msg);
    }
    ?>
    
    <div class="form-label-group">
        <input type="password" name="password" id="password" class="form-control" placeholder="Digite a nova senha" onkeyup="passwordStrength()" value="<?php
        if (isset($data['password'])) {
            echo $data['password'];
        }
        ?>" autofocus required>
        <label for="password">Senha</label>
    </div>

    <input type="submit" name="EditPass" class="btn btn-lg btn-primary btn-block" value="Salvar">
    
    <p class="mt-2 mb-3 text-muted text-center">
        <a href="<?php echo URLADM . '/login'; ?>" class="text-decoration-none">Clique aqui</a> para acessar
    </p>
</form>
