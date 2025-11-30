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
    <script src="<?= BASE_URL ?>public/assets/js/modal.js"></script>
</head>

<body>
    <header>
        <?php include_once __DIR__ . '/components/header.php'; ?>
    </header>
    <main>
        <section>
            <?php
                if($_SESSION['role_user'] == 'adm') {

            ?>
                <div id="modalAddEqp" class="modal-overlay">
                    <div class="modal">
                        <h2>Adicionar Equipamento</h2>
                        <form id="formAddEqp">
                            <label class="form_label">Nome</label>
                            <input type="text" name="nome" required>

                            <label class="form_label">Descricao</label>
                            <input type="text" name="descricao" required>

                            <label class="form_label">Resistência Física</label>
                            <input type="number" name="res_fisica" required>

                            <label class="form_label">Resistência Mágica</label>
                            <input type="number" name="res_magico" required>
                            
                            <label class="form_label">Resistência ao Fogo</label>
                            <input type="number" name="res_fogo" required>

                            <label class="form_label">Resistência elétrica</label>
                            <input type="number" name="res_eletrico" required>

                            <label class="form_label">Tipo</label>
                            <select class="select_add_eqp tipo">
                                <option value="Normal">Normal</option>
                                <option value="especial">Especial</option>
                                <option value="boss">Boss</option>
                                <option value="normal/especial">Normal/Especial</option>
                                <option value="normal/npc">Normal/NPC</option>
                                <option value="Online">Online</option>
                                <option value="boss/normal">Boss/Normal</option>
                            </select>

                            <label class="form_label">Locais</label>
                            <select class="select_add_eqp local" multiple>
                                <?php foreach($locais as $loc): ?>
                                    <option value="<?= $loc['id'] ?>"><?= $loc['nome'] ?></option>
                                <?php endforeach ?>
                            </select>

                            <button type="button" class="btn-save">Salvar</button>
                            <button type="button" class="btn-close" id="closeModal">Fechar</button>
                        </form>
                    </div>
                </div>
            <?php 
                }
            ?>
            <div class="main_container">
                <div class="title_page">
                    <div class="eqp_title_div">
                        <h1><?= htmlspecialchars($eqp['equipamento_nome']) ?></h1>
                        <?php if($_SESSION['role_user'] == 'adm'): ?>
                            <button class="addEqp" id="addEqp">Adicionar Inimigo</button>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="content_page">

                    <div class="eqp_section">
                        <h2>Descrição</h2>
                        <p><?= htmlspecialchars($eqp['descricao']) ?></p>
                    </div>

                    <div class="eqp_section">
                        <h2>Raridade</h2>
                        <p><?= htmlspecialchars($eqp['raridade_nome']) ?> (Nivel Máx: <?= $eqp['raridade_nivel_max'] ?>)</p>
                    </div>

                    <?php if(!empty($eqp['dano_fisico'])): ?>
                    <div class="eqp_section">
                        <h2>Estatísticas de Combate</h2>
                        <ul>
                            <li>Dano Físico: <?= $eqp['dano_fisico'] ?></li>
                            <li>Dano Mágico: <?= $eqp['dano_magico'] ?></li>
                            <li>Dano Fogo: <?= $eqp['dano_fogo'] ?></li>
                            <li>Dano Elétrico: <?= $eqp['dano_eletrico'] ?></li>
                            <li>Redução Dano Físico: <?= $eqp['dano_fisico_reducao'] ?></li>
                            <li>Redução Dano Mágico: <?= $eqp['dano_magico_reducao'] ?></li>
                            <li>Redução Dano Fogo: <?= $eqp['dano_fogo_reducao'] ?></li>
                            <li>Redução Dano Elétrico: <?= $eqp['dano_eletrico_reducao'] ?></li>
                            <li>Estabilidade: <?= $eqp['estabilidade'] ?></li>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <?php if(!empty($eqp['arma_categoria_nome'])): ?>
                    <div class="eqp_section">
                        <h2>Categoria da Arma</h2>
                        <p><?= htmlspecialchars($eqp['arma_categoria_nome']) ?></p>
                    </div>
                    <?php endif; ?>

                    <?php if(!empty($eqp['escudo_categoria_nome'])): ?>
                    <div class="eqp_section">
                        <h2>Categoria do Escudo</h2>
                        <p><?= htmlspecialchars($eqp['escudo_categoria_nome']) ?></p>
                    </div>
                    <?php endif; ?>

                    <div class="eqp_section">
                        <h2>Efeito</h2>
                        <p><?= nl2br(htmlspecialchars($eqp['effect'])) ?></p>
                    </div>

                </div>
            </div>
        </section>
    </main>
</body>
</html>