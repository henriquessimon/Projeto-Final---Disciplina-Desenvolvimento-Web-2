<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="plagiarism" content="Este conteúdo é protegido por direitos autorais. Por favor, atribua a autoria corretamente para evitar problemas de plágio.">
    <title>DS Equip Wiki</title>
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>public/assets/style/global.css" />
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>public/assets/style/oneLocal.css" />
    <?php include_once __DIR__ . '/components/importCssHF.php' ?>
    <script src="<?= BASE_URL ?>public/assets/js/verificaLogin.js"></script>
</head>
<body> 
    <main>
        <section>
            <div class="main_container">
                <div class="title_page">
                    <div class="eqp_title_div">
                        <h1><?= $inimigo['nome'] ?></h1>
                    </div>
                </div>
                <div class="content_page">
                    <p><?= $inimigo['descricao'] ?></p>
                    <div>
                        <label><span><strong>Tipo: </strong></span><?=  $inimigo['tipo']?></label>
                        <p><?= $inimigo['tipo_text'] ?></p>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Resistência fisica</th>
                                <th>Resistência Mágica</th>
                                <th>Resistência ao Fogo</th>
                                <th>Resistencia elétrica</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= $inimigo['res_fisica'] ?></td>
                                <td><?= $inimigo['res_magica'] ?></td>
                                <td><?= $inimigo['res_fogo'] ?></td>
                                <td><?= $inimigo['res_eletrica'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <label><span><strong>Localizações encontrado:</strong></span></label>
                        <ul>
                            <?php foreach ($inimigo['locais'] as $loc):?>
                                <li><?= $loc['local_nome'] ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>