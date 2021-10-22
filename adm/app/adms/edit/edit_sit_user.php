<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}
$sit_user_exist = false;
$msg = "";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Editar Situação para Usuário</h2>
            </div>
            <div class="p-2">
                <a href="list_sits_users" class="btn btn-outline-info btn-sm">Listar</a>
                <a href="view_sit_user?id=<?php echo $id ?>" class="btn btn-outline-primary btn-sm">Visualizar</a>
            </div>
        </div>
        <hr class="hr-title">
        <?php
        if (!empty($id)) {
            $query_sit_user = "SELECT name, adms_color_id 
                    FROM adms_sits_users
                    WHERE id = $id 
                    LIMIT 1";
            $result_sit_user = mysqli_query($conn, $query_sit_user);
            if (($result_sit_user) AND ($result_sit_user->num_rows != 0)) {
                $row_sit_user = mysqli_fetch_assoc($result_sit_user);
                //var_dump($row_sit_user);
                $sit_user_exist = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação para usuário não encontrado!</div>";
                $url_destination = URLADM . "/list_sit_users";
                header("Location: $url_destination");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação para usuário não encontrado!</div>";
            $url_destination = URLADM . "/list_sit_users";
            header("Location: $url_destination");
        }

        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($data['EditSitUser'])) {

            $empty_input = false;

            $data = array_map('trim', $data);
            if (in_array("", $data)) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher todos os campos!</div>";
            }

            if (!$empty_input) {
                $query_up_sit_user = "UPDATE adms_sits_users SET name = '" . $data['name'] . "', adms_color_id = '" . $data['adms_color_id'] . "', modified = NOW() WHERE id = $id LIMIT 1";
                mysqli_query($conn, $query_up_sit_user);

                if (mysqli_affected_rows($conn)) {
                    $_SESSION['user_name'] = $data['name'];
                    $_SESSION['user_nickname'] = $data['nickname'];
                    $_SESSION['user_email'] = $data['email'];

                    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Situação para usuário editado com sucesso!</div>";
                    $url_destination = URLADM . "/list_sits_users";
                    header("Location: $url_destination");
                } else {
                    $msg = "<div class='alert alert-danger' role='alert'>Erro: Situação para usuário não editado com sucesso!</div>";
                }
            }
        }

        if ($sit_user_exist) {
            if (!empty($msg)) {
                echo $msg;
                $msg = "";
            }
            ?>
            <span class="msg"></span>
            <form id="add_sit_user" method="POST" action="">
                <div class="form-group">
                    <label for="name"><span class="text-danger">*</span> Nome</label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="Nome da situação para usuário" value="<?php
                    if (isset($data['name'])) {
                        echo $data['name'];
                    } elseif (isset($row_sit_user['name'])) {
                        echo $row_sit_user['name'];
                    }
                    ?>" autofocus required>
                </div>

                <div class="form-group">
                    <?php
                    $query_colors = "SELECT id, name FROM adms_colors ORDER BY name ASC";
                    $result_colors = mysqli_query($conn, $query_colors);
                    ?>
                    <div class="form-group">
                        <label for="situation"><span class="text-danger">*</span> Cor</label>
                        <select name="adms_color_id" id="adms_color_id" class="form-control" required>
                            <option selected>Selecione</option>
                            <?php
                            while ($row_color = mysqli_fetch_assoc($result_colors)) {
                                $select_color = "";
                                if (isset($data['adms_color_id']) AND ($data['adms_color_id'] == $row_color['id'])) {
                                    $select_color = "selected";
                                } elseif (isset($row_sit_user['adms_color_id']) AND ($row_sit_user['adms_color_id'] == $row_color['id'])) {
                                    $select_color = "selected";
                                }
                                echo "<option value='" . $row_color['id'] . "' $select_color>" . $row_color['name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>  

                <p>
                    <span class="text-danger">*</span> Campo Obrigatório
                </p>
                <input type="submit" value="Salvar" name="EditSitUser" class="btn btn-outline-warning btn-sm">
            </form>
        </div>    
    </div>
    <?php
}
