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
                            <button class="addEqp" id="addEqp">Adicionar Local</button>
                        </div>
                    </div>
                    <div class="content_page">
                        <div class="local_list_container">
                            <?php foreach ($locais as $loc):?>
                                <div class="local_list_item" id="<?=$loc['id']?>">
                                    <h3><?= $loc['nome'] ?></h3>
                                    <svg class="dlt_local" width="24" height="24" viewBox="0 0 24 24" fill="red" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3 6H5H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6H19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M10 11V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14 11V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>