<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DS Equip Wiki</title>
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>public/assets/style/global.css" />
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>public/assets/style/oneLocal.css" />
    <?php include_once __DIR__ . '/components/importCssHF.php' ?>
    <script src="<?= BASE_URL ?>public/assets/js/verificaLogin.js"></script>
</head>
<body>
    <header>
        <?php include_once __DIR__ . '/components/header.php'; ?>
    </header>
    <body>
        <main>
            <section>
                <div class="main_container">
                    <div class="title_page">
                        <div class="eqp_title_div">
                            <h1><?= $loc['nome'] ?></h1>
                        </div>
                    </div>
                    <div class="content_page">
                        <p><?= $loc['descricao'] ?></p>
                        <p><span><strong>Dificuldade:  </strong></span> <?= $loc['dificuldade'] ?></p>
                        <div>
                            <label><span><strong>Inimigos do local:</strong></span></label>
                            <ul>
                                <?php foreach ($enemys as $ini):?>
                                    <li><?= $ini['enemy_nome'] ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                        <img src="<?= $loc['link_img'] ?>" alt="Imagem do local de dark souls <?= $loc['nome'] ?>" width="30%" height="300px">
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>