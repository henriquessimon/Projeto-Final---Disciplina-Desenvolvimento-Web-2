<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DS Equip Wiki</title>
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>public/assets/style/global.css" />
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>public/assets/style/local_list.css" />
    <?php include_once __DIR__ . '/components/importCssHF.php' ?>
    <script src="<?= BASE_URL ?>public/assets/js/verificaLogin.js"></script>
    <script src="<?= BASE_URL ?>public/assets/js/modal.js"></script>
    <script src="<?= BASE_URL ?>public/assets/js/locais.js"></script>
</head>
<body>
    <header>
        <?php include_once __DIR__ . '/components/header.php'; ?>
    </header>
    <body>
        <main>
            <section>
                <div id="modalAddEqp" class="modal-overlay">
                    <div class="modal">
                        <h2>Adicionar Local</h2>
                        <form id="formAddEqp">
                            <label class="form_label">Nome</label>
                            <input type="text" name="nome" required>

                            <label class="form_label">Descricao</label>
                            <input type="text" name="descricao" required>

                            <label class="form_label">Dificuldade</label>
                            <select class="select_add_eqp">
                                <option value="Fácil">Fácil</option>
                                <option value="Médio">Médio</option>
                                <option value="Dificil">Difícil</option>
                            </select>

                            <label class="form_label">Link imagem</label>
                            <textarea name="link_img" rows="1" required></textarea>

                            <button type="button" class="btn-save">Salvar</button>
                            <button type="button" class="btn-close" id="closeModal">Fechar</button>
                        </form>
                    </div>
                </div>
                <div class="main_container">
                    <div class="title_page">
                        <div class="eqp_title_div">
                            <h1>Locais</h1>
                            <button class="addEqp" id="addEqp">Adicionar Inimigo</button>
                        </div>
                    </div>
                    <div class="content_page">
                        <div class="local_list_container">
                            <?php foreach ($locais as $loc):?>
                                <div class="local_list_item" id="<?=$loc['id']?>">
                                    <h3><?= $loc['nome'] ?></h3>
                                </div>
                            <?php endforeach ?>
                        </div>
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