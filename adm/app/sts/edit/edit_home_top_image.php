<?php

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}
$top_image_exist = false;
$msg = "";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Editar Foto</h2>
            </div>
            <div class="p-2">
                <a href="view_home" class="btn btn-outline-primary btn-sm">Visualizar</a>
            </div>
        </div>
        <hr class="hr-title">
        <?php

        if (!empty($id)) {
            $query_top_image = "SELECT image FROM sts_homes_tops WHERE id = $id LIMIT 1";
            $result_top_image = mysqli_query($conn, $query_top_image);
            if (($result_top_image) AND ($result_top_image->num_rows != 0)) {
                $row_top_image = mysqli_fetch_assoc($result_top_image);
                //var_dump($row_profile);
                $top_image_exist = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Imagem não encontrada!</div>";
                $url_destination = URLADM . "/view_home";
                header("Location: $url_destination");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Imagem não encontrada!</div>";
            $url_destination = URLADM . "/view_home";
            header("Location: $url_destination");
        }

        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        //var_dump($data);
        if (!empty($data['EditTopImage'])) {
            $data_image = $_FILES['new_image'];
            //var_dump($data_image);

            $empty_input = false;

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
                $query_up_top_image = "UPDATE sts_homes_tops SET image = '" . $data_image['name'] . "', modified = NOW() WHERE id = $id LIMIT 1";
                mysqli_query($conn, $query_up_top_image);

                if (mysqli_affected_rows($conn)) {
                    $destiny = "app/sts/assets/images/home_top/";
                    if (!empty($row_top_image['image'])) {
                        include './lib/lib_delete_file.php';
                        deleteFile($destiny . $row_top_image['image']);
                    }

                    //var_dump($data_image);
                    include './lib/lib_upload_img_resize.php';
                    if (uploadImgResize($data_image, $destiny, 1897, 604)) {
                        //$_SESSION['user_image'] = $data_image['name'];
                        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Foto do topo editada com sucesso!</div>";
                        $url_destination = URLADM . "/view_home";
                        header("Location: $url_destination");
                    } else {
                        $msg = "<div class='alert alert-danger' role='alert'>Erro: Foto do topo não foi editada com sucesso!</div>";
                    }
                } else {
                    $msg = "<div class='alert alert-danger' role='alert'>Erro: Foto do topo não foi editada com sucesso!</div>";
                }
            }
        }

        if ($top_image_exist) {
            if (!empty($msg)) {
                echo $msg;
                unset($msg);
            }
            ?>
            <span class="msg"></span>
                <form id="edit_home_top_image" method="POST" action="" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="image">Foto 1897x604<span class="text-danger">*</span> Imagem</label>
                            <input type="file" name="new_image" class="form-control-file" id="new_image" onchange="previewImage();">
                            <?php
                            if (isset($row_top_image['image']) AND (file_exists("app/sts/assets/images/home_top/" . $row_top_image['image']))) {
                                $image_old = "app/sts/assets/images/home_top/" . $row_top_image['image'];
                            } else {
                                $image_old = "app/sts/assets/images/home_top/icon_home_top.jpg";
                            }
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                            <img src="<?php echo $image_old; ?>" alt="Imagem" id="preview-image" class="img-thumbnail view-img-size-sts img-fluid">
                        </div>
                    </div>

                    <p>
                        <span class="text-danger">*</span> Campo Obrigatório
                    </p>

                    <input type="submit" value="Salvar" name="EditTopImage" class="btn btn-outline-warning btn-sm">

                </form>
            </div>    
        </div>
        <?php

    }