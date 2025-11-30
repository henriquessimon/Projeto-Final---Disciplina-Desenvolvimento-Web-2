<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DS Equip Wiki</title>
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>public/assets/style/global.css" />
    <?php include_once __DIR__ . '/components/importCssHF.php' ?>
    <script src="<?= BASE_URL ?>public/assets/js/verificaLogin.js"></script>
    <script src="<?= BASE_URL ?>public/assets/js/att.js"></script>
</head>
<body>
    <header>
        <?php include_once __DIR__ . '/components/header.php'; ?>
    </header>

    <main>
        <section>                    
            <div class="main_container">
                <div class="title_page">
                    <div class="eqp_title_div">
                        <h1>Meus Dados</h1>
                    </div>
                </div>

                <div class="content_page">
                    <form id="form_user">
                        <label>Nome Completo</label>
                        <input type="text" name="nome_completo" />
                        
                        <label>Telefone</label>
                        <input type="phone" name="telefone" />

                        <label>E-mail</label>
                        <input type="text" name="email"/>

                        <label>Senha</label>
                        <input type="senha" name="senha" />

                        <button type="button" id="attButton">Atualizar dados</button>
                        <button type="button" id="excluir_conta">Excluir conta</button>
                    </form>

                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('click', function(e) {
            if(e.target.closest('.local_list_item')) {
                const local_id = e.target.closest('.local_list_item').getAttribute('id');
                window.location.href = `<?= BASE_URL ?>?controller=local&method=getOneLocal&local_id=${local_id}`;
            }
        })
    </script>

</body>
</html>