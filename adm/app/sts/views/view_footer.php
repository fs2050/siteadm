<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Rodapé</h2>
            </div>
            <div class="mr-auto p-2">
                <h2 class="display-4 title"></h2>
            </div>
            <div class="p-2">
                <span class="d-none d-lg-block">
                    <a href="edit_footer" class="btn btn-outline-warning btn-sm">Editar</a>
                </span>
                <div class="dropdown d-block d-lg-none">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                        <a class="dropdown-item" href="edit_footer">Editar</a>
                    </div>
                </div>
            </div>
        </div>
        <hr class="hr-title">

        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }

        $query_footer = "SELECT id, title_site, title_contact, phone, address, url_address, cnpj, url_cnpj, title_social_networks, txt_one_social_networks, link_one_social_networks, txt_two_social_networks, link_two_social_networks, txt_three_social_networks, link_three_social_networks, txt_four_social_networks, link_four_social_networks FROM sts_footers LIMIT 1";
        $result_footer = mysqli_query($conn, $query_footer);
        if (($result_footer) AND ($result_footer->num_rows != 0)) {
            $row_footer = mysqli_fetch_assoc($result_footer);
            extract($row_footer);
            //var_dump($row_contact);

            echo "<dl class='row'>";

            echo "<dt class='col-sm-3'>Título do site:</dt>";
            echo "<dd class='col-sm-9'>$title_site</dd>";

            echo "<dt class='col-sm-3'>Título do contato:</dt>";
            echo "<dd class='col-sm-9'>$title_contact</dd>";

            echo "<dt class='col-sm-3'>Telefone:</dt>";
            echo "<dd class='col-sm-9'>$phone</dd>";

            echo "<dt class='col-sm-3'>Endereço:</dt>";
            echo "<dd class='col-sm-9'>$address</dd>";

            echo "<dt class='col-sm-3'>Url 1:</dt>";
            echo "<dd class='col-sm-9'>$url_address</dd>";
            
            echo "<dt class='col-sm-3'>Cnpj:</dt>";
            echo "<dd class='col-sm-9'>$cnpj</dd>";
            
            echo "<dt class='col-sm-3'>Url 2:</dt>";
            echo "<dd class='col-sm-9'>$url_cnpj</dd>";
            
            echo "<dt class='col-sm-3'>Título rede social:</dt>";
            echo "<dd class='col-sm-9'>$title_social_networks</dd>";
            
            echo "<dt class='col-sm-3'>Texto rede social 1:</dt>";
            echo "<dd class='col-sm-9'>$txt_one_social_networks</dd>";
            
            echo "<dt class='col-sm-3'>Link rede social 1:</dt>";
            echo "<dd class='col-sm-9'>$link_one_social_networks</dd>";
            
            echo "<dt class='col-sm-3'>Texto rede social 2:</dt>";
            echo "<dd class='col-sm-9'>$txt_two_social_networks</dd>";
            
            echo "<dt class='col-sm-3'>Link rede social 2:</dt>";
            echo "<dd class='col-sm-9'>$link_two_social_networks</dd>";
            
            echo "<dt class='col-sm-3'>Texto rede social 3:</dt>";
            echo "<dd class='col-sm-9'>$txt_three_social_networks</dd>";
            
            echo "<dt class='col-sm-3'>Link rede social 3:</dt>";
            echo "<dd class='col-sm-9'>$link_three_social_networks</dd>";
            
            echo "<dt class='col-sm-3'>Texto rede social 4:</dt>";
            echo "<dd class='col-sm-9'>$txt_four_social_networks</dd>";
            
            echo "<dt class='col-sm-3'>Link rede social 4:</dt>";
            echo "<dd class='col-sm-9'>$link_four_social_networks</dd>";

            echo "</dl>";
        }
        ?>
    </div>
</div>