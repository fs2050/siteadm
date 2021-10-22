<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}
$msg = "";

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (!empty($data['SendLogin'])) {
    $empty_input = false;

    $data = array_map('trim', $data);
    if (in_array("", $data)) {
        $empty_input = true;
        $msg = "<div class='alert alert-danger' role='alert'>Necessário preencher todos os campos</div>";
    } elseif (stristr($data['username'], "'")) {
        $empty_input = true;
        $msg = "<div class='alert alert-danger' role='alert'>Usuário ou a senha inválida!</div>";
    } elseif (stristr($data['username'], '"')) {
        $empty_input = true;
        $msg = "<div class='alert alert-danger' role='alert'>Usuário ou a senha inválida!</div>";
    } elseif (stristr($data['username'], " ")) {
        $empty_input = true;
        $msg = "<div class='alert alert-danger' role='alert'>Usuário ou a senha inválida!</div>";
    } elseif (stristr($data['password'], "'")) {
        $empty_input = true;
        $msg = "<div class='alert alert-danger' role='alert'>Usuário ou a senha inválida!</div>";
    } elseif (stristr($data['password'], '"')) {
        $empty_input = true;
        $msg = "<div class='alert alert-danger' role='alert'>Usuário ou a senha inválida!</div>";
    } elseif (stristr($data['password'], " ")) {
        $empty_input = true;
        $msg = "<div class='alert alert-danger' role='alert'>Usuário ou a senha inválida!</div>";
    }

    if (!$empty_input) {
        $query_user = "SELECT id, name, nickname, email, password, image, adms_sits_user_id
                FROM adms_users 
                WHERE email = '" . $data['username'] . "'
                OR username = '" . $data['username'] . "'
                LIMIT 1";
        $result_user = mysqli_query($conn, $query_user);
        if (($result_user) AND ($result_user->num_rows != 0)) {
            $row_user = mysqli_fetch_assoc($result_user);
            if ($row_user['adms_sits_user_id'] != 1) {
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário confirmar o e-mail, solicite novo e-mail <a href='" . URLADM . "/login_new_conf_email'>clique aqui</a>!</div>";
            } else if (password_verify($data['password'], $row_user['password'])) {
                $_SESSION['user_id'] = $row_user['id'];
                $_SESSION['user_name'] = $row_user['name'];
                $_SESSION['user_nickname'] = $row_user['nickname'];
                $_SESSION['user_email'] = $row_user['email'];
                $_SESSION['user_image'] = $row_user['image'];
                $_SESSION['user_key'] = password_hash($row_user['id'], PASSWORD_DEFAULT);

                unset($data);
                $url_destination = URLADM . "/dashboard";
                header("Location: $url_destination");
            } else {
                $msg = "<div class='alert alert-danger' role='alert'>Usuário ou a senha inválida!</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger' role='alert'>Usuário ou a senha inválida!</div>";
        }
    }
}
?>

<form class="form-signin" id="send_login" method="POST" action="">
    <div class="text-center mb-4">
        <img class="mb-4" src="app/adms/assets/images/logo/logo.jpg" alt="logo" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal text-light">Área Restrita</h1>
    </div>
    <span class="msg"></span>
    <?php
    if (!empty($msg)) {
        echo $msg;
        unset($msg);
    }
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>

    <div class="form-label-group">
        <input type="text" name="username" id="username" class="form-control" placeholder="Digite o usuário ou e-mail" value="<?php
    if (isset($data['username'])) {
        echo $data['username'];
    }
    ?>" autofocus required>
        <label for="username">Usuário</label>
    </div>

    <div class="form-label-group">
        <input type="password" name="password" id="password" class="form-control" placeholder="Digite a senha" value="<?php
        if (isset($data['password'])) {
            echo $data['password'];
        }
    ?>" required>
        <label for="password">Senha</label>
    </div>

    <input type="submit" name="SendLogin" class="btn btn-lg btn-primary btn-block" value="Acessar">

    <p class="mt-2 mb-3 text-muted text-center">
        <a href="<?php echo URLADM . '/login_new_user'; ?>" class="text-decoration-none">Cadastrar</a> - 
        <a href="<?php echo URLADM . '/login_recover_password'; ?>" class="text-decoration-none">Esqueceu a Senha</a>
    </p>

    <p class="text-white">
        Usuário: fabiolfs76@.com.br<br>
        Senha: 123456a
    </p>
</form>

