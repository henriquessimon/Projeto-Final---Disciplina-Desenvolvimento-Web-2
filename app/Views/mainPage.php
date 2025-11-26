<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DS Equip Wiki</title>
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>public/assets/style/global.css" />
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>public/assets/style/eqp_list.css" />
    <?php include_once __DIR__ . '/components/importCssHF.php' ?>
    <script src="<?= BASE_URL ?>public/assets/js/verificaLogin.js"></script>
    <script src="<?= BASE_URL ?>public/assets/js/modal.js"></script>
    <script src="<?= BASE_URL ?>public/assets/js/mainPage.js"></script>
</head>
<body>
    <header>
        <?php include_once __DIR__ . '/components/header.php'; ?>
    </header>
    <main>
        <section>
            <div id="modalAddEqp" class="modal-overlay">
                <div class="modal">
                    <h2>Adicionar Equipamento</h2>
                    <form id="formAddEqp">
                        <label class="form_label">Nome</label>
                        <input type="text" name="nome" required>

                        <label class="form_label">Descricao</label>
                        <input type="text" name="descricao" required>

                        <label class="form_label">Dano Físico</label>
                        <input type="number" name="dano_fisico" required>

                        <label class="form_label">Dano Mágico</label>
                        <input type="number" name="dano_magico" required>
                        
                        <label class="form_label">Dano de Fogo</label>
                        <input type="number" name="dano_fogo" required>

                        <label class="form_label">Dano Elétrico</label>
                        <input type="number" name="dano_eletrico" required>

                        <label class="form_label">Redução de Dano físico</label>
                        <input type="number" name="dano_fisico_reducao" required>

                        <label class="form_label">Redução de Dano Mágico</label>
                        <input type="number" name="dano_magico_reducao" required>

                        <label class="form_label">Redução de Dano de Fogo</label>
                        <input type="number" name="dano_fogo_reducao" required>

                        <label class="form_label">Redução de Dano Elétrico</label>
                        <input type="number" name="dano_eletrico_reducao" required>

                        <label class="form_label">Estabilidade</label>
                        <input type="number" name="estabilidade" required>

                        <label class="form_label">Effect</label>
                        <input type="text" name="effect" required>

                        <label class="form_label">Raridade</label>
                        <select class="select_add_eqp">
                            <option value="1">Comum</option>
                            <option value="2">único</option>
                            <option value="3">Boss</option>
                            <option value="4">Dragão</option>
                            <option value="5">Demon</option>
                        </select>

                        <label class="form_label">Tipo de Equipamento</label>
                        <select id="selectTipo" class="select_add_eqp">
                            <option value="">Selecione o Tipo</option>
                            <option value="arma">Arma</option>
                            <option value="escudo">Escudo</option>
                            <option value="anel">Anel</option>
                        </select>

                        <label class="slc_cat_label">Categoria do equipamento</label>
                        <select id ="selectCategoria" class="select_add_eqp slc_cat" >
                        </select>

                        <button type="submit" class="btn-save">Salvar</button>
                        <button type="button" class="btn-close" id="closeModal">Fechar</button>
                    </form>
                </div>
            </div>
            <div class="main_container">
                <div class="title_page">
                    <div class="eqp_title_div">
                        <h1>Lista Equipamentos</h1>
                        <button class="addEqp" id="addEqp">Adicionar Equipamento</button>
                    </div>
                </div>
                <div class="content_page">
                    <?php foreach ($equipamentosPorCategoria as $cat):?>
                        <div class="categoria_div">
                            <h1><?= $cat['categoria']?></h1>
                            <div class="categoria_eqp_list">
                                <ul class="status_eqp_list">
                                    <li title="Nome">Nome</li>
                                    <li title="Dano Físico">DF</li>
                                    <li title="Dano Mágico">DM</li>
                                    <li title="Dano de Fogo">DFG</li>
                                    <li title="Dano Elétrico">DE</li>
                                    <li title="Redução de dano Físico">RF</li>
                                    <li title="Redução de dano Mágico">RM</li>
                                    <li title="Redução de dano de Fogo">RF</li>
                                    <li title="Redução de dano Elétrico">RE</li>
                                    <li title="Estabilidade">Estabilidade</li>
                                    <li title="Estabilidade" >Favoritar</li>
                                </ul>
                                <?php foreach  ($cat['items'] as $item):?>
                                    <ul class="status_eqp_list" id="<?=$item['id']?>">
                                        <li class="item_list"><?=$item['nome']?></li>
                                        <li class="item_list"><?=$item['dano_fisico']?></li>
                                        <li class="item_list"><?=$item['dano_magico']?></li>
                                        <li class="item_list"><?=$item['dano_fogo']?></li>
                                        <li class="item_list"><?=$item['dano_eletrico']?></li>
                                        <li class="item_list"><?=$item['dano_fisico_reducao']?></li>
                                        <li class="item_list"><?=$item['dano_magico_reducao']?></li>
                                        <li class="item_list"><?=$item['dano_fogo_reducao']?></li>
                                        <li class="item_list"><?=$item['dano_eletrico_reducao']?></li>
                                        <li class="item_list"><?= $item['estabilidade'] ?></li>
                                        <li class="item_list" id="favoritar">
                                            <?php
                                                if($item['favoritado'] == '0') {
                                                    $fill_start = "";
                                                } else {
                                                    $fill_start = "gold";
                                                }
                                            ?>
                                            <svg id="estr_svg" width="30" height="30" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                                <polygon points="50,15 61,35 83,38 67,55 70,77 50,67 30,77 33,55 17,38 39,35" 
                                                    fill="<?=$fill_start?>" stroke="orange" stroke-width="2"/>
                                            </svg>
                                        </li>
                                    </ul>
                                <?php endforeach ?>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </section>
    </main>
</body>
</html>