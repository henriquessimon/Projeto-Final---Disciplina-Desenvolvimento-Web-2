<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DS Equip Wiki</title>
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>public/assets/style/global.css" />
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>public/assets/style/eqp.css.css" />
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
                        <p><?= !empty($eqp['descricao']) ? htmlspecialchars($eqp['descricao']) : 'Sem descrição' ?></p>
                    </div>

                    <div class="eqp_section">
                        <h2>Raridade</h2>
                        <p>
                            <?= !empty($eqp['raridade_nome']) ? htmlspecialchars($eqp['raridade_nome']) : 'Comum' ?> 
                            (Nível Máx: <?= !empty($eqp['raridade_nivel_max']) ? $eqp['raridade_nivel_max'] : '1' ?>)
                        </p>
                    </div>

                    <?php if(!empty($eqp['dano_fisico']) || !empty($eqp['dano_magico']) || !empty($eqp['dano_fogo']) || !empty($eqp['dano_eletrico'])): ?>
                    <div class="eqp_section">
                        <h2>Estatísticas de Combate</h2>
                        <table class="eqp_stats_table">
                            <tr>
                                <th>Tipo</th>
                                <th>Valor</th>
                            </tr>
                            <?php if(!empty($eqp['dano_fisico'])): ?>
                            <tr>
                                <td>Dano Físico</td>
                                <td><?= $eqp['dano_fisico'] ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if(!empty($eqp['dano_magico'])): ?>
                            <tr>
                                <td>Dano Mágico</td>
                                <td><?= $eqp['dano_magico'] ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if(!empty($eqp['dano_fogo'])): ?>
                            <tr>
                                <td>Dano Fogo</td>
                                <td><?= $eqp['dano_fogo'] ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if(!empty($eqp['dano_eletrico'])): ?>
                            <tr>
                                <td>Dano Elétrico</td>
                                <td><?= $eqp['dano_eletrico'] ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if(!empty($eqp['dano_fisico_reducao'])): ?>
                            <tr>
                                <td>Redução Dano Físico</td>
                                <td><?= $eqp['dano_fisico_reducao'] ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if(!empty($eqp['dano_magico_reducao'])): ?>
                            <tr>
                                <td>Redução Dano Mágico</td>
                                <td><?= $eqp['dano_magico_reducao'] ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if(!empty($eqp['dano_fogo_reducao'])): ?>
                            <tr>
                                <td>Redução Dano Fogo</td>
                                <td><?= $eqp['dano_fogo_reducao'] ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if(!empty($eqp['dano_eletrico_reducao'])): ?>
                            <tr>
                                <td>Redução Dano Elétrico</td>
                                <td><?= $eqp['dano_eletrico_reducao'] ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if(!empty($eqp['estabilidade'])): ?>
                            <tr>
                                <td>Estabilidade</td>
                                <td><?= $eqp['estabilidade'] ?></td>
                            </tr>
                            <?php endif; ?>
                        </table>
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
                        <p><?= !empty($eqp['effect']) ? nl2br(htmlspecialchars($eqp['effect'])) : 'Sem efeitos especiais' ?></p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>