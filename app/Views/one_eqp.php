<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DS Equip Wiki</title>
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>public/assets/style/global.css" />
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>public/assets/style/eqp.css" />
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
                            <h2><?= isset($eqp['id']) ? 'Editar Equipamento' : 'Adicionar Equipamento' ?></h2>
                            <form id="formAddEqp">
                                <?php if(isset($eqp['equipamento_id'])): ?>
                                    <input type="hidden" name="id" value="<?= $eqp['equipamento_id'] ?>">
                                <?php endif; ?>

                                <label class="form_label">Nome</label>
                                <input type="text" name="nome" value="<?= isset($eqp['equipamento_nome']) ? htmlspecialchars($eqp['equipamento_nome']) : '' ?>" required>

                                <label class="form_label">Descrição</label>
                                <input type="text" name="descricao" value="<?= isset($eqp['descricao']) ? htmlspecialchars($eqp['descricao']) : '' ?>" required>

                                <label class="form_label">Efeito</label>
                                <input type="text" name="effect" value="<?= isset($eqp['effect']) ? htmlspecialchars($eqp['effect']) : '' ?>">

                                <!-- Resistências/Reduções de Dano -->
                                <label class="form_label">Redução Dano Físico</label>
                                <input type="number" name="dano_fisico_reducao" value="<?= isset($eqp['dano_fisico_reducao']) ? $eqp['dano_fisico_reducao'] : '0' ?>" required>

                                <label class="form_label">Redução Dano Mágico</label>
                                <input type="number" name="dano_magico_reducao" value="<?= isset($eqp['dano_magico_reducao']) ? $eqp['dano_magico_reducao'] : '0' ?>" required>
                                
                                <label class="form_label">Redução Dano Fogo</label>
                                <input type="number" name="dano_fogo_reducao" value="<?= isset($eqp['dano_fogo_reducao']) ? $eqp['dano_fogo_reducao'] : '0' ?>" required>

                                <label class="form_label">Redução Dano Elétrico</label>
                                <input type="number" name="dano_eletrico_reducao" value="<?= isset($eqp['dano_eletrico_reducao']) ? $eqp['dano_eletrico_reducao'] : '0' ?>" required>

                                <!-- Danos -->
                                <label class="form_label">Dano Físico</label>
                                <input type="number" name="dano_fisico" value="<?= isset($eqp['dano_fisico']) ? $eqp['dano_fisico'] : '0' ?>">

                                <label class="form_label">Dano Mágico</label>
                                <input type="number" name="dano_magico" value="<?= isset($eqp['dano_magico']) ? $eqp['dano_magico'] : '0' ?>">

                                <label class="form_label">Dano Fogo</label>
                                <input type="number" name="dano_fogo" value="<?= isset($eqp['dano_fogo']) ? $eqp['dano_fogo'] : '0' ?>">

                                <label class="form_label">Dano Elétrico</label>
                                <input type="number" name="dano_eletrico" value="<?= isset($eqp['dano_eletrico']) ? $eqp['dano_eletrico'] : '0' ?>">

                                <label class="form_label">Estabilidade</label>
                                <input type="number" name="estabilidade" value="<?= isset($eqp['estabilidade']) ? $eqp['estabilidade'] : '0' ?>">

                                <!-- Raridade -->
                                <label class="form_label">Raridade</label>
                                <select class="select_add_eqp" name="raridade_id">
                                    <?php 
                                    // Você precisa buscar as raridades do banco
                                    $stmt_raridades = $conn->prepare("SELECT id, nome FROM raridade_eqp");
                                    $stmt_raridades->execute();
                                    $raridades = $stmt_raridades->fetchAll(PDO::FETCH_ASSOC);
                                    
                                    foreach($raridades as $raridade): ?>
                                        <option value="<?= $raridade['id'] ?>" 
                                            <?= (isset($eqp['raridade_id']) && $eqp['raridade_id'] == $raridade['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($raridade['nome']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <!-- Categoria Arma -->
                                <label class="form_label">Categoria da Arma</label>
                                <select class="select_add_eqp" name="arma_categoria_id">
                                    <option value="">Nenhuma</option>
                                    <?php 
                                    $stmt_cat_armas = $conn->prepare("SELECT id, nome FROM categoria_armas");
                                    $stmt_cat_armas->execute();
                                    $categorias_armas = $stmt_cat_armas->fetchAll(PDO::FETCH_ASSOC);
                                    
                                    foreach($categorias_armas as $cat_arma): ?>
                                        <option value="<?= $cat_arma['id'] ?>" 
                                            <?= (isset($eqp['arma_categoria_id']) && $eqp['arma_categoria_id'] == $cat_arma['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cat_arma['nome']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <!-- Categoria Escudo -->
                                <label class="form_label">Categoria do Escudo</label>
                                <select class="select_add_eqp" name="escudo_categoria_id">
                                    <option value="">Nenhuma</option>
                                    <?php 
                                    $stmt_cat_escudos = $conn->prepare("SELECT id, nome FROM categoria_escudos");
                                    $stmt_cat_escudos->execute();
                                    $categorias_escudos = $stmt_cat_escudos->fetchAll(PDO::FETCH_ASSOC);
                                    
                                    foreach($categorias_escudos as $cat_escudo): ?>
                                        <option value="<?= $cat_escudo['id'] ?>" 
                                            <?= (isset($eqp['escudo_categoria_id']) && $eqp['escudo_categoria_id'] == $cat_escudo['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cat_escudo['nome']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <!-- Tipo (mantendo o mesmo) -->
                                <label class="form_label">Tipo</label>
                                <select class="select_add_eqp tipo" name="tipo">
                                    <option value="Normal" <?= (isset($eqp['tipo']) && $eqp['tipo'] == 'Normal') ? 'selected' : '' ?>>Normal</option>
                                    <option value="especial" <?= (isset($eqp['tipo']) && $eqp['tipo'] == 'especial') ? 'selected' : '' ?>>Especial</option>
                                    <option value="boss" <?= (isset($eqp['tipo']) && $eqp['tipo'] == 'boss') ? 'selected' : '' ?>>Boss</option>
                                    <option value="normal/especial" <?= (isset($eqp['tipo']) && $eqp['tipo'] == 'normal/especial') ? 'selected' : '' ?>>Normal/Especial</option>
                                    <option value="normal/npc" <?= (isset($eqp['tipo']) && $eqp['tipo'] == 'normal/npc') ? 'selected' : '' ?>>Normal/NPC</option>
                                    <option value="Online" <?= (isset($eqp['tipo']) && $eqp['tipo'] == 'Online') ? 'selected' : '' ?>>Online</option>
                                    <option value="boss/normal" <?= (isset($eqp['tipo']) && $eqp['tipo'] == 'boss/normal') ? 'selected' : '' ?>>Boss/Normal</option>
                                </select>

                                <!-- Locais (corrigido) -->
                                <label class="form_label">Locais</label>
                                <select class="select_add_eqp local" name="locais[]" multiple>
                                    <?php 
                                    // Buscar locais associados ao equipamento
                                    if(isset($eqp['equipamento_id'])) {
                                        $stmt_locais_eqp = $conn->prepare("
                                            SELECT local_id FROM equipamento_locais 
                                            WHERE equipamento_id = ?
                                        ");
                                        $stmt_locais_eqp->execute([$eqp['equipamento_id']]);
                                        $locais_associados = $stmt_locais_eqp->fetchAll(PDO::FETCH_COLUMN);
                                    } else {
                                        $locais_associados = [];
                                    }
                                    
                                    foreach($locais as $loc): ?>
                                        <option value="<?= $loc['id'] ?>" 
                                            <?= in_array($loc['id'], $locais_associados) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($loc['nome']) ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>

                                <button type="submit" class="btn-save"><?= isset($eqp['equipamento_id']) ? 'Atualizar' : 'Salvar' ?></button>
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
                            <button class="addEqp" id="addEqp">Atualizar arma</button>
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