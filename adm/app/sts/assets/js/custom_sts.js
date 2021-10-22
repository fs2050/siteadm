$(document).ready(function () {
    $('#edit_home_top').on("submit", function () {
        if ($('#title_top').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo título!</div>");
            return false;
        }
        if ($('#description_top').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo descrição!</div>");
            return false;
        }
        if ($('#link_btn_top').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo link do botão!</div>");
            return false;
        }
        if ($('#txt_btn_top').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo texto do botão!</div>");
            return false;
        }
    });
});

$(document).ready(function () {
    $('#edit_home_serv').on("submit", function () {
        if ($('#title_serv').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo título!</div>");
            return false;
        }
        if ($('#description_serv').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo descrição!</div>");
            return false;
        }
        if ($('#icone_um_serv').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo ícone do serviço um!</div>");
            return false;
        }
        if ($('#titulo_um_serv').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo título do serviço um!</div>");
            return false;
        }
        if ($('#description_um_serv').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo descrição do serviço um!</div>");
            return false;
        }
        
        if ($('#icone_dois_serv').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo ícone do serviço dois!</div>");
            return false;
        }
        if ($('#titulo_dois_serv').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo título do serviço dois!</div>");
            return false;
        }
        if ($('#description_dois_serv').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo descrição do serviço dois!</div>");
            return false;
        }
        
        if ($('#icone_tres_serv').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo ícone do serviço três!</div>");
            return false;
        }
        if ($('#titulo_tres_serv').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo título do serviço três!</div>");
            return false;
        }
        if ($('#description_tres_serv').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo descrição do serviço três!</div>");
            return false;
        }
    });
});

$(document).ready(function () {
    $('#edit_home_action').on("submit", function () {
        if ($('#title_top').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo título!</div>");
            return false;
        }
        if ($('#subtitle_action').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo subtitulo!</div>");
            return false;
        }
        if ($('#description_action').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo descrição!</div>");
            return false;
        }
        if ($('#link_btn_action').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo link do botão!</div>");
            return false;
        }
        if ($('#txt_btn_action').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo texto do botão!</div>");
            return false;
        }
    });
});

$(document).ready(function () {
    $('#edit_home_det').on("submit", function () {
        if ($('#title_det').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo título!</div>");
            return false;
        }
        if ($('#subtitle_det').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo subtitulo!</div>");
            return false;
        }
        if ($('#description_det').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo descrição!</div>");
            return false;
        }
    });
});