<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

$msg = "";

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if (!empty($data['SendNewConfEmail'])) {
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
            include './lib/lib_conf_email_single.php';
            $conf_email = keyConfEmailSingle();
            $query_up_user = "UPDATE adms_users SET conf_email = '$conf_email' WHERE id= " . $row_user['id'] . " LIMIT 1";
            //"UPDATE adms_users SET conf_email = '$conf_email' WHERE email= " . $data['email'] . " LIMIT 1";
            mysqli_query($conn, $query_up_user);
            if (mysqli_affected_rows($conn)) {
                $name = explode(" ", $row_user['name']);
                $first_name = $name[0];

                include './lib/lib_send_email.php';

                $email_data['to_email'] = $data['email'];
                $email_data['to_name'] = $first_name;

                $url = URLADM . "/login_conf_email?key=" . $conf_email;

                $email_data['subject'] = "Confirmar sua conta";

                $email_data['content_html'] = "Prezado(a) $first_name <br><br>";
                $email_data['content_html'] .= "Agradecemos a sua solicitação de cadastramento em nosso site!<br><br>";
                $email_data['content_html'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo: <br><br>";
                $email_data['content_html'] .= "<a href='$url'>$url</a><br><br>";
                $email_data['content_html'] .= "Esta mensagem foi enviada a você pela empresa XXX.<br>Você está recebendo porque está cadastrado no banco de dados da empresa XXX. Nenhum e-mail enviado pela empresa XXX tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.<br><br>";

                $email_data['content_text'] = "Prezado(a) $first_name \n\n";
                $email_data['content_text'] .= "Agradecemos a sua solicitação de cadastramento em nosso site!\n\n";
                $email_data['content_text'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo ou cole o link no navegador: \n\n";
                $email_data['content_text'] .= "$url\n\n";
                $email_data['content_text'] .= "Esta mensagem foi enviada a você pela empresa XXX.\nVocê está recebendo porque está cadastrado no banco de dados da empresa XXX. Nenhum e-mail enviado pela empresa XXX tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.\n\n";

                if (sendEmail($email_data, 2)) {
                    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Novo link enviado com sucesso. Acesse a sua caixa de e-mail para confimar o e-mail!</div>";
                    $url_destination = URLADM . "/login";
                    header("Location: $url_destination");
                } else {
                    $msg = "<div class='alert alert-danger' role='alert'>Erro: Link não enviado, tente novamente ou entre em contato com o e-mail " . EMAILADM . "!</div>";
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
<form class="form-signin" id="new_conf_email" method="POST" action="">
    <div class="text-center mb-4">
        <img class="mb-4" src="app/adms/assets/images/logo/logo.png" alt="Celke" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal text-light">Novo Link</h1>
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

    <input type="submit" name="SendNewConfEmail" class="btn btn-lg btn-primary btn-block" value="Solicitar">
    
    <p class="mt-2 mb-3 text-muted text-center">
        <a href="<?php echo URLADM . '/login'; ?>" class="text-decoration-none">Clique aqui</a> para acessar
    </p>
</form>