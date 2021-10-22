<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}
$msg = "";
?>

<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Cadastrar Situação para Usuário</h2>
            </div>
            <div class="p-2">
                <a href="list_sits_users" class="btn btn-outline-info btn-sm">Listar</a>
            </div>
        </div>
        <hr class="hr-title">
        <?php
        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($data['AddSitUser'])) {
            $empty_input = false;

            $data = array_map('trim', $data);
            if (in_array("", $data)) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher todos os campos!</div>";
            }

            if (!$empty_input) {
                $query_sit_user = "INSERT INTO adms_sits_users (name, adms_color_id, created) VALUES ('" . $data['name'] . "', '" . $data['adms_color_id'] . "', NOW())";
                mysqli_query($conn, $query_sit_user);

                if (mysqli_insert_id($conn)) {
                    //$ultimo_id = mysqli_insert_id($conn);
                    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Situação para usuário cadastrado com sucesso!</div>";
                    $url_destination = URLADM . "/list_sits_users";
                    header("Location: $url_destination");
                } else {
                    $msg = "<div class='alert alert-danger' role='alert'>Erro: Situação para usuário não cadastrado com sucesso!</div>";
                }
            }
        }

        if (!empty($msg)) {
            echo $msg;
            $msg = "";
        }
        ?>
        <span class="msg"></span>
        <form id="add_sit_user" method="POST" action="">
            <div class="form-group">
                <label for="name"><span class="text-danger">*</span> Nome</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Nome da situação" value="<?php
                if (isset($data['name'])) {
                    echo $data['name'];
                }
                ?>" autofocus required>
            </div>
            
            <?php
            $query_colors = "SELECT id, name FROM adms_colors ORDER BY name ASC";
            $result_colors = mysqli_query($conn, $query_colors);
            ?>
            <div class="form-group">
                <label for="adms_color_id"><span class="text-danger">*</span> Cor</label>
                <select name="adms_color_id" id="adms_color_id" class="form-control" required>
                    <option value="">Selecione</option>
                    <?php
                    while ($row_color = mysqli_fetch_assoc($result_colors)) {
                        $select_color = "";
                        if (isset($data['adms_color_id']) AND ($data['adms_color_id'] == $row_color['id'])) {
                            $select_color = "selected";
                        }
                        echo "<option value='" . $row_color['id'] . "' $select_color>" . $row_color['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <p>
                <span class="text-danger">*</span> Campo Obrigatório
            </p>

            <input type="submit" value="Cadastrar" name="AddSitUser" class="btn btn-outline-success btn-sm">
        </form>
    </div>    
</div>