<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DS Equip Wiki</title>
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>public/assets/style/global.css" />
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>public/assets/style/inimigo_list.css" />
    <?php include_once __DIR__ . '/components/importCssHF.php' ?>
    <script src="<?= BASE_URL ?>public/assets/js/verificaLogin.js"></script>
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
                            <h1>Inimigos</h1>
                        </div>
                    </div>
                    <div class="content_page">
                        <div class="enemy_list_container">
                            <ul class="enemy_list_item">
                                <li title="Nome">Nome</li>
                                <li title="Resistencia contra dano físico">RES Física</li>
                                <li title="Resistencia contra dano mágico">RES Mágica</li>
                                <li title="Resistencia contra dano de fogo">RES de Fogo</li>
                                <li title="Resistencia contra dano elétrico">RES Elétrica</li>
                            </ul>
                            <?php foreach ($enemys as $enem):?>
                                <ul class="enemy_list_item" id="<?=$enem['id']?>">
                                    <li><?= $enem['nome'] ?></li>
                                    <li><?= $enem['res_fisica'] ?></li>
                                    <li><?= $enem['res_magica'] ?></li>
                                    <li><?= $enem['res_fogo'] ?></li>
                                    <li><?= $enem['res_eletrico'] ?></li>
                                </ul>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
        </section>
    </main>
</body>
</html>