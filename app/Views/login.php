<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DS Equip Wiki</title>
    <link rel="stylesheet" type="text/css" href="../../public/style/global.css" />
    <link rel="stylesheet" type="text/css" href="../../public/style/cad_log.css" />
    <script src="../../public/js/login.js"></script>
</head>
<body>
    <section class="page_cad_log">
        <div class="image_div">
            <div class="filter_img"><h1 class="title_log_cad">Dark Souls<br>Equipment Wiki</h2></div>
            <img src="../../public/style/src/espadafire.jpg" class="img_cad_log"/>
        </div>
        <div class="container_cad_log">
            <div class="content_cad_log">
                <div class="title">
                    <h2 class="title_page">Login</h3>
                </div>
                <div class="divFormating">
                    <form method="POST" class="form_cad_log">
                        <div class="div_containers_complete">
                            <div class="container_complete_fields">
                                <label>E-mail</label>
                                <input type="text" class="field" name="email" />
                            </div>
                        </div>
                        <div class="container_half_fields">
                            <label>Senha</label>
                            <input type="text" class="field" name="pass" />
                        </div>
                        <div class="display_none_error_login message_error_login_container"><span class="text_error_login">E-mail ou senha incorreto</span></div>
                        <div class="div_send">
                            <button type="submit" class="button_send">Entrar</button>
                            <a class="cad_redirect" href="cadastro.html">Cadastrar-se</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>