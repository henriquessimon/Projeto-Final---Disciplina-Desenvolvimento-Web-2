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
                            <h1>Locais</h1>
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
    </body>
</html>