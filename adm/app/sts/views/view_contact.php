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
                <h2 class="display-4 title">Contato</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-lg-block">
                    <a href="edit_contact" class="btn btn-outline-warning btn-sm">Editar</a>
                </span>
                <div class="dropdown d-block d-lg-none">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                        <a class="dropdown-item" href="edit_contact">Editar</a>
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

        $query_contact = "SELECT id, title_opening_hours, opening_hours, title_address, address, address_two, phone FROM sts_contacts LIMIT 1";
        $result_contact = mysqli_query($conn, $query_contact);
        if (($result_contact) AND ($result_contact->num_rows != 0)) {
            $row_contact = mysqli_fetch_assoc($result_contact);
            extract($row_contact);
            //var_dump($row_contact);

            echo "<dl class='row'>";

            echo "<dt class='col-sm-3'>Título:</dt>";
            echo "<dd class='col-sm-9'>$title_opening_hours</dd>";

            echo "<dt class='col-sm-3'>Horario:</dt>";
            echo "<dd class='col-sm-9'>$opening_hours</dd>";

            echo "<dt class='col-sm-3'>Título do Endereço:</dt>";
            echo "<dd class='col-sm-9'>$title_address</dd>";

            echo "<dt class='col-sm-3'>Endereço 1:</dt>";
            echo "<dd class='col-sm-9'>$address</dd>";

            echo "<dt class='col-sm-3'>Endereço 2:</dt>";
            echo "<dd class='col-sm-9'>$address_two</dd>";
            
            echo "<dt class='col-sm-3'>Telefone:</dt>";
            echo "<dd class='col-sm-9'>$phone</dd>";

            echo "</dl>";
        }
        ?>
    </div>
</div>