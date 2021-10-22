<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

$msg = "";

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if (!empty($data['SendNewRecoverPass'])) {
    $empty_input = false;

    $data['email'] = str_ireplace(" ", "", $data['email']);

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $empty_input = true;
        $msg = "<div class='alert alert-danger' role='alert'>Erro: E-mail inválido!</div>";
    }

    if (!$empty_input) {
        $query_user = "SELECT id, name FROM adms_users WHERE email = '" . $data['email'] . "' LIMIT 1";
        $result_user = mysqli_query($conn, $query_user);
        if (($result_user) AND ($result_user->num_rows != 0)) {
            $row_user = mysqli_fetch_assoc($result_user);
            include './lib/lib_recover_pass_single.php';
            $recover_password = keyRecoverPassSingle();

            $query_up_user = "UPDATE adms_users SET recover_password = '$recover_password' WHERE id= " . $row_user['id'] . " LIMIT 1";
            mysqli_query($conn, $query_up_user);
            if (mysqli_affected_rows($conn)) {
                $name = explode(" ", $row_user['name']);
                $first_name = $name[0];

                include './lib/lib_send_email.php';

                $email_data['to_email'] = $data['email'];
                $email_data['to_name'] = $first_name;

                $url = URLADM . "/login_up_password?key=" . $recover_password;

                $email_data['subject'] = "Recuperar senha";

                $email_data['content_html'] = "Prezado(a) $first_name <br><br>";
                $email_data['content_html'] .= "Você solicitou alteração de senha.<br><br>";
                $email_data['content_html'] .= "Para continuar o processo de recuperação de sua senha, clique no link abaixo ou cole o endereço no seu navegador: <br><br>";
                $email_data['content_html'] .= "<a href='$url'>$url</a><br><br>";
                $email_data['content_html'] .= "Se você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá a mesma até que você ative este código.<br><br>";

                $email_data['content_text'] = "Prezado(a) $first_name \n\n";
                $email_data['content_text'] .= "Você solicitou alteração de senha.\n\n";
                $email_data['content_text'] .= "Para continuar o processo de recuperação de sua senha, clique no link abaixo ou cole o endereço no seu navegador: \n\n";
                $email_data['content_text'] .= "$url\n\n";
                $email_data['content_text'] .= "Se você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá a mesma até que você ative este código.\n\n";
                
                if (sendEmail($email_data, 2)) {
                    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Enviado e-mail com instruções para recuperar a senha. Acesse a sua caixa de e-mail para recuperar a senha!</div>";
                    $url_destination = URLADM . "/login";
                    header("Location: $url_destination");
                } else {
                    $msg = "<div class='alert alert-danger' role='alert'>Erro: E-mail com as intruções para recuperar a senha não enviado, tente novamente ou entre em contato com o e-mail " . EMAILADM . "!</div>";
                }
            } else {
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Link não enviado, tente novamente!</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger' role='alert'>Erro: E-mail inválido!</div>";
        }
    }
}
?>

<form class="form-signin" id="new_recover_pass" method="POST" action="">
    <div class="text-center mb-4">
        <img class="mb-4" src="app/adms/assets/images/logo/logo.png" alt="Celke" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal text-light">Recuperar Senha</h1>
    </div>
    <span class="msg"></span>
    <?php
    if (!empty($msg)) {
        echo $msg;
        unset($msg);
    }
    ?>
    
    <div class="form-label-group">
        <input type="email" name="email" id="email" class="form-control" placeholder="Digite o e-mail cadastrado" value="<?php
        if (isset($data['email'])) {
            echo $data['email'];
        }
        ?>" autofocus required>
        <label for="email">E-mail</label>
    </div>

    <input type="submit" name="SendNewRecoverPass" class="btn btn-lg btn-primary btn-block" value="Solicitar">
    
    <p class="mt-2 mb-3 text-muted text-center">
        <a href="<?php echo URLADM . '/login'; ?>" class="text-decoration-none">Clique aqui</a> para acessar
    </p>
</form>
