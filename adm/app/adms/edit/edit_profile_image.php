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
                <h2 class="display-4 title">Editar Foto</h2>
            </div>
        </div>
        <hr class="hr-title">
        <?php

        if (isset($_SESSION['user_id'])) {
            $query_profile = "SELECT image FROM adms_users WHERE id = " . $_SESSION['user_id'] . " LIMIT 1";
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
        //var_dump($data);
        if (!empty($data['EditProfileImage'])) {
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
                $query_up_profile = "UPDATE adms_users SET image = '" . $data_image['name'] . "', modified = NOW() WHERE id = " . $_SESSION['user_id'] . " LIMIT 1";
                mysqli_query($conn, $query_up_profile);

                if (mysqli_affected_rows($conn)) {
                    $destiny = "app/adms/assets/images/users/" . $_SESSION['user_id'] . "/";
                    if (!empty($row_profile['image'])) {
                        include './lib/lib_delete_file.php';
                        deleteFile($destiny . $row_profile['image']);
                    }

                    //var_dump($data_image);
                    include './lib/lib_upload_img_resize.php';
                    if (uploadImgResize($data_image, $destiny, 500, 500)) {
                        $_SESSION['user_image'] = $data_image['name'];
                        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Foto do perfil editado com sucesso!</div>";
                        $url_destination = URLADM . "/profile";
                        header("Location: $url_destination");
                    } else {
                        $msg = "<div class='alert alert-danger' role='alert'>Erro: Foto do perfil não editado com sucesso!</div>";
                    }
                } else {
                    $msg = "<div class='alert alert-danger' role='alert'>Erro: Foto do perfil não editado com sucesso!</div>";
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
                <form id="edit_profile_image" method="POST" action="" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="image">Foto 500x500<span class="text-danger">*</span> Imagem</label>
                            <input type="file" name="new_image" class="form-control-file" id="new_image" onchange="previewImage();">
                            <?php
                            if (isset($row_profile['image']) AND (file_exists("app/adms/assets/images/users/" . $_SESSION['user_id'] . "/" . $row_profile['image']))) {
                                $image_old = "app/adms/assets/images/users/" . $_SESSION['user_id'] . "/" . $row_profile['image'];
                            } else {
                                 $image_old = "app/adms/assets/images/users/icon_user.png";
                            }
                            ?>
                        </div>
                        <div class="form-group col-md-6">                            
                            <img src="<?php echo $image_old; ?>" alt="Imagem" id="preview-image" class="img-thumbnail view-img-size" style="width: 150px; height: 150px;">
                        </div>
                    </div>

                    <p>
                        <span class="text-danger">*</span> Campo Obrigatório
                    </p>                    

                    <input type="submit" value="Salvar" name="EditProfileImage" class="btn btn-outline-warning btn-sm">

                </form>
            </div>    
        </div>    
        <?php

    }