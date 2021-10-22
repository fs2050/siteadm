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
                <h2 class="display-4 title">Cadastrar Sobre Empresa</h2>
            </div>
            <div class="p-2">
                <a href="list_companies" class="btn btn-outline-info btn-sm">Listar</a>
            </div>
        </div>
        <hr class="hr-title">
        <?php
        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($data['AddCompany'])) {
            //var_dump($data);
            $empty_input = false;

            $data = array_map('trim', $data);
            if (in_array("", $data)) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher todos os campos!</div>";
            }
            
            $data_image = $_FILES['new_image'];
            //var_dump($data_image);
            
            include './lib/lib_val_ext_img.php';

            if (empty($data_image['name'])) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário selecionar uma imagem!</div>";
            } elseif (!valExtensionImg($data_image['type'])) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário selecionar uma imagem JPEG ou PNG!</div>";
            }

            if (!$empty_input) {
                include './lib/lib_special_characters.php';
                $data_image['name'] = specialCharacters($data_image['name']);
                $query_about_comoany = "INSERT INTO sts_abouts_companies (title, description, image, sts_situation_id, created) VALUES ('" . $data['title'] . "', '" . $data['description'] . "', '" . $data_image['name'] . "','" . $data['sts_situation_id'] . "', NOW())";                
                mysqli_query($conn, $query_about_comoany);

                if (mysqli_insert_id($conn)) {
                    if (!empty($data_image['name'])) {
                        include './lib/lib_upload_img_resize.php';
                        $destiny = "app/sts/assets/images/sobre/" . mysqli_insert_id($conn) . "/";
                        uploadImgResize($data_image, $destiny, 500, 500);
                    }
                    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Sobre empresa cadastrado com sucesso!</div>";
                    $url_destination = URLADM . "/list_companies";
                    header("Location: $url_destination");
                    exit();
                } else {
                    $msg = "<div class='alert alert-danger' role='alert'>Erro: Sobre empresa não cadastrado com sucesso!</div>";
                }
            }
        }

        if (!empty($msg)) {
            echo $msg;
            $msg = "";
        }
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <span class="msg"></span>
        <form id="add_company" method="POST" action="" enctype="multipart/form-data"> 
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="title"><span class="text-danger">*</span> Título</label>
                    <input name="title" type="text" class="form-control" id="title" placeholder="Título"  value="<?php
                    if (isset($data['title'])) {
                        echo $data['title'];
                    }
                    ?>" autofocus required>
                </div>
                <div class="form-group col-md-12">
                    <label for="description"> Descrição</label>                   
                    <textarea name="description" class="form-control" id="description" rows="3" required><?php
                        if (isset($data['description'])) {
                            echo $data['description'];
                        }
                        ?></textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="image">Foto 500x500<span class="text-danger">*</span> Imagem</label>
                    <input type="file" name="new_image" class="form-control-file" id="new_image" onchange="previewImage();">
                    <?php 
                    $preview = "app/sts/assets/images/sobre/icon_sobre.jpg"; 
                    ?>
                </div>
                <div class="form-group col-md-6">
                    <img src="<?php echo $preview; ?>" alt="Imagem" id="preview-image" style="width: 150px; height: 150px;" class="img-thumbnail view-img-size">
                </div>
            </div>

            <?php
            $query_sits = "SELECT id, name FROM sts_situations ORDER BY name ASC";
            $result_sits = mysqli_query($conn, $query_sits);
            ?>
            <div class="form-group">
                <label for="sts_situation_id"><span class="text-danger">*</span> Situação</label>
                <select name="sts_situation_id" id="sts_situation_id" class="form-control" required>
                    <option value="">Selecione</option>
                    <?php
                    while ($row_sit = mysqli_fetch_assoc($result_sits)) {
                        $select_sits = "";
                        if (isset($data['sts_situation_id']) AND ($data['sts_situation_id'] == $row_sit['id'])) {
                            $select_sits = "selected";
                        }
                        echo "<option value='" . $row_sit['id'] . "' $select_sits>" . $row_sit['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>


            <p>
                <span class="text-danger">*</span> Campo Obrigatório
            </p>

            <input type="submit" value="Cadastrar" name="AddCompany" class="btn btn-outline-success btn-sm">
        </form>
    </div>
</div>