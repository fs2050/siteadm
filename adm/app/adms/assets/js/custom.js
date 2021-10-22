
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

$(document).ready(function () {
    //Apresentar ou ocultar o menu
    $('.sidebar-toggle').on('click', function () {
        $('.sidebar').toggleClass('toggled');
    });

    //carregar aberto o submenu
    var active = $('.sidebar .active');
    if(active.length && active.parent('.collapse').length){
        var parent = active.parent('.collapse');
        parent.prev('a').attr('aria-expanded', true);
        parent.addClass('show');
    }
});

$(document).ready(function () {
    $('#send_login').on("submit", function () {
        if ($('#username').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo usuário!</div>");
            return false;
        }
        if ($('#password').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo senha!</div>");
            return false;
        }
    });
});

$(document).ready(function () {
    $('#login_new_user').on("submit", function () {
        var password = $('#password').val();
        if ($('#name').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo nome!</div>");
            return false;
        }
        if ($('#email').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo email!</div>");
            return false;
        }
        if (password === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo senha!</div>");
            return false;
        }
        if (password.length < 6) {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: A senha dever ter no minimo 6 caracteres!</div>");
            return false;
        }
        if (password.match(/([1-9]+)\1{1,}/)) {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: A senha não deve ter número repetido!</div>");
            return false;
        }
        if (!password.match(/[A-Za-z]/)) {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: A senha deve ter pelo menos uma letra!</div>");
            return false;
        }
    });
});

function passwordStrength() {
    var password = document.getElementById('password').value;
    //alert(password);
    var strength = 0;

    if ((password.length >= 6) && (password.length <= 7)) {
        strength += 10;
    } else if (password.length > 7) {
        strength += 25;
    }

    if ((password.length >= 6) && (password.match(/[a-z]+/))) {
        strength += 20;
    }

    if ((password.length >= 7) && (password.match(/[A-Z]+/))) {
        strength += 20;
    }

    if ((password.length >= 8) && (password.match(/[@#$%&*]+/))) {
        strength += 25;
    }

    if (password.match(/([1-9]+)\1{1,}/)) {
        strength += -25;
    }

    //console.log(strength);
    viewStrength(strength);
}

function viewStrength(strength) {
    /*Imprimir a força da senha*/
    if (strength < 30) {
        document.getElementById("msgviewStrength").innerHTML = ("<div class='alert alert-danger' role='alert'>Senha Fraca</div>");
    } else if ((strength >= 30) && (strength < 50)) {
        document.getElementById("msgviewStrength").innerHTML = ("<div class='alert alert-warning' role='alert'>Senha Média</<div class='alert alert-danger' role='alert'>");
    } else if ((strength >= 50) && (strength < 70)) {
        document.getElementById("msgviewStrength").innerHTML = ("<div class='alert alert-primary' role='alert'>Senha Boa</div>");
    } else if ((strength >= 70) && (strength < 100)) {
        document.getElementById("msgviewStrength").innerHTML = ("<div class='alert alert-success' role='alert'>Senha Forte</div>");
    }
}

$(document).ready(function () {
    $('#new_recover_pass').on("submit", function () {
        if ($('#email').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo e-mail!</div>");
            return false;
        }
    });
});

$(document).ready(function () {
    $('#new_conf_email').on("submit", function () {
        if ($('#email').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo e-mail!</div>");
            return false;
        }
    });
});

$(document).ready(function () {
    $('#edit_profile').on("submit", function () {
        if ($('#name').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo nome!</div>");
            return false;
        }
        if ($('#nickname').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo apelido!</div>");
            return false;
        }
        if ($('#email').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo e-mail!</div>");
            return false;
        }
        if ($('#username').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo usuário!</div>");
            return false;
        }
    });
});

function previewImage() {
    var image = document.querySelector('input[name=new_image]').files[0];
    //console.log(image);
    var preview = document.querySelector('#preview-image');
    //console.log(preview);

    //console.log(image.type);
    var imageTypes = ["image/jpeg", "image/jpg", "image/png"];
    if (imageTypes.indexOf(image.type) === -1) {
        preview.src = "./app/adms/assets/images/users/icon_user.png";
        $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário selecionar uma imagem JPG ou PNG!</div>");
        return false;
    } else {
        //FileReader permite ler o conteúdo de arquivo
        //Documentação: https://developer.mozilla.org/pt-BR/docs/Web/API/FileReader
        var reader = new FileReader();

        //Realiza a leitura do arquivo para obter a URL do arquivo
        reader.readAsDataURL(image);

        //Quando finalizar a leitura chama esse evento, neste caso executa a função
        reader.onloadend = function () {
            //console.log(reader.result);
            preview.src = reader.result;
            $(".msg").html("");
        };
    }
}

$(document).ready(function () {
    $('#add_user').on("submit", function () {
        var password = $('#password').val();
        if ($('#name').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo nome!</div>");
            return false;
        }
        if ($('#email').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo email!</div>");
            return false;
        }
        if ($('#username').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo usuário!</div>");
            return false;
        }
        if (password === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo senha!</div>");
            return false;
        }
        if (password.length < 6) {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: A senha dever ter no minimo 6 caracteres!</div>");
            return false;
        }
        if (password.match(/([1-9]+)\1{1,}/)) {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: A senha não deve ter número repetido!</div>");
            return false;
        }
        if (!password.match(/[A-Za-z]/)) {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: A senha deve ter pelo menos uma letra!</div>");
            return false;
        }
        if ($('#adms_sits_user_id').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo situação!</div>");
            return false;
        }
    });
});

$(document).ready(function () {
    $('#add_sit_user').on("submit", function () {
        if ($('#name').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo nome!</div>");
            return false;
        }
        if ($('#adms_color_id').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo cor!</div>");
            return false;
        }
    });
});

$(document).ready(function () {
    $('#add_email').on("submit", function () {
        if ($('#title').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo título!</div>");
            return false;
        }
        if ($('#name').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo nome!</div>");
            return false;
        }
        if ($('#email').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo e-mail!</div>");
            return false;
        }
        if ($('#host_server').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo host!</div>");
            return false;
        }
        if ($('#username').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo usuário!</div>");
            return false;
        }
        if ($('#password').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo senha!</div>");
            return false;
        }
        if ($('#smtpsecure').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo SMTP!</div>");
            return false;
        }
        if ($('#port').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo porta!</div>");
            return false;
        }
    });
});

$(document).ready(function () {
    $('#edit_profile_pass').on("submit", function () {
        var password = $('#password').val();
        if (password === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo senha!</div>");
            return false;
        }
        if (password.length < 6) {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: A senha dever ter no minimo 6 caracteres!</div>");
            return false;
        }
        if (password.match(/([1-9]+)\1{1,}/)) {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: A senha não deve ter número repetido!</div>");
            return false;
        }
        if (!password.match(/[A-Za-z]/)) {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: A senha deve ter pelo menos uma letra!</div>");
            return false;
        }
    });
});

$(document).ready(function () {
    $('#edit_user').on("submit", function () {
        if ($('#name').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo nome!</div>");
            return false;
        }
        if ($('#email').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo email!</div>");
            return false;
        }
        if ($('#username').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo usuário!</div>");
            return false;
        }
        if ($('#adms_sits_user_id').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo situação!</div>");
            return false;
        }
    });
});

//Carregar modal define para apagar
$(document).ready(function () {
    $('a[data-confirm]').click(function (ev) {
        var href = $(this).attr('href');

        if (!$('#confirm-delete').length) {
            $('body').append('<div class="modal fade" id="confirm-delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-danger text-white"><h5 class="modal-title" id="exampleModalLabel">EXCLUIR ITEM</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Tem certeza de que deseja excluir o item selecionado?</div><div class="modal-footer"><button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button><a class="btn btn-danger" id="dataComfirmOk">Apagar</a></div></div></div>');
        }

        $('#dataComfirmOk').attr('href', href);
        $('#confirm-delete').modal({show: true});
        return false;
    });    
});

$(document).ready(function () {
    $('#add_color').on("submit", function () {
        if ($('#name').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo nome!</div>");
            return false;
        }
        if ($('#color').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Preencha o campo cor!</div>");
            return false;
        }
    });
});