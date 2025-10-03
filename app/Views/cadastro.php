<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DS Equip Wiki</title>
    <link rel="stylesheet" type="text/css" href="../../public/assets/style/global.css" />
    <link rel="stylesheet" type="text/css" href="../../public/assets/style/cad_log.css" />

</head>
<body>
    <section class="page_cad_log">
        <div class="image_div">
            <div class="filter_img"><h2 class="title_log_cad">Dark Souls<br>Equipment Wiki</h2></div>
            <img src="../../public/assets/img/espadafire.jpg" class="img_cad_log"/>
        </div>
        <div class="container_cad_log">
            <div class="content_cad_log">
                <div class="title">
                    <h2 class="title_page">Cadastro de usuário</h2>
                </div>
                <div class="divFormating">
                    <form method="POST" class="form_cad_log" action="../../index.php?controller=usuario&method=cadastrarUsuario">
                        <input type="hidden" name="action" value="cadastro" />
                        <div class="container_half_fields">
                            <label>Nome Completo</label>
                            <input type="text" class="field" name="name" />
                        </div>
                        <div class="container_half_fields">
                            <label>Telefone</label>
                            <input type="text" class="field" name="phone" />
                        </div>
                        <div class="container_half_fields">
                            <label>Senha</label>
                            <input type="password" class="field" name="pass" />
                        </div>
                        <div class="div_containers_complete">
                            <div class="container_complete_fields">
                                <label>E-mail</label>
                                <input type="text" class="field" name="email" />
                            </div>
                        </div>
                        <div class="div_containers_complete">
                            <div class="">
                                <label>Termos de Uso</label>
                                <input type="checkbox" name="sys_termos_uso" />
                            </div>
                        </div>
                        <div class="div_send">
                            <button type="submit" class="button_send">Cadastrar-se</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>