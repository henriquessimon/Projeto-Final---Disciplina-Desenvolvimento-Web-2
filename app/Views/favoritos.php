<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favoritos - DS Equip Wiki</title>
    <meta name="plagiarism" content="Este conteúdo é protegido por direitos autorais. Por favor, atribua a autoria corretamente para evitar problemas de plágio.">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>public/assets/style/global.css" />
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>public/assets/style/eqp_list.css" />
    <?php include_once __DIR__ . '/components/importCssHF.php' ?>

    <script src="<?= BASE_URL ?>public/assets/js/verificaLogin.js"></script>
    <script src="<?= BASE_URL ?>public/assets/js/mainPage.js"></script>

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
                <h1>Meus Favoritos</h1>
            </div>
        </div>

        <div class="content_page">
            <div class="categoria_div">
                <h1>Equipamentos Favoritados</h1>

                <div class="categoria_eqp_list">
                    <ul class="status_eqp_list">
                        <li title="Nome">Nome</li>
                        <li title="Dano Físico">DF</li>
                        <li title="Dano Mágico">DM</li>
                        <li title="Dano de Fogo">DFG</li>
                        <li title="Dano Elétrico">DE</li>
                        <li title="Redução de dano Físico">RF</li>
                        <li title="Redução de dano Mágico">RM</li>
                        <li title="Redução de dano de Fogo">RFo</li>
                        <li title="Redução de dano Elétrico">RE</li>
                        <li title="Estabilidade">Est</li>
                        <li>Favorito</li>
                    </ul>
                    <?php foreach ($favoritos as $item): ?>
                        <ul class="status_eqp_list fav_page" id="<?= $item['equipamento_id'] ?>">

                            <li class="item_list"><?= $item['equipamento_nome'] ?></li>
                            <li class="item_list"><?= $item['dano_fisico'] ?></li>
                            <li class="item_list"><?= $item['dano_magico'] ?></li>
                            <li class="item_list"><?= $item['dano_fogo'] ?></li>
                            <li class="item_list"><?= $item['dano_eletrico'] ?></li>

                            <li class="item_list"><?= $item['dano_fisico_reducao'] ?></li>
                            <li class="item_list"><?= $item['dano_magico_reducao'] ?></li>
                            <li class="item_list"><?= $item['dano_fogo_reducao'] ?></li>
                            <li class="item_list"><?= $item['dano_eletrico_reducao'] ?></li>

                            <li class="item_list"><?= $item['estabilidade'] ?></li>
                            <li class="item_list" id="favoritar">
                                <svg id="estr_svg" width="30" height="30" 
                                     viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                    <polygon 
                                        points="50,15 61,35 83,38 67,55 70,77 50,67 
                                                30,77 33,55 17,38 39,35"
                                        fill="gold"
                                        stroke="orange"
                                        stroke-width="2"
                                    />
                                </svg>
                            </li>

                        </ul>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</section>
</main>
</body>
</html>