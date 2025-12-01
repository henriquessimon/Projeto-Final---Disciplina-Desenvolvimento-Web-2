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
    <script src="<?= BASE_URL ?>public/assets/js/attEqp.js"></script>
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
                            <h2><?= isset($eqp['equipamento_id']) ? 'Editar Equipamento' : 'Adicionar Equipamento' ?></h2>
                            <form id="formAddEqp">
                                <?php if(isset($eqp['equipamento_id'])): ?>
                                    <input type="hidden" name="id" value="<?= $eqp['equipamento_id'] ?>">
                                <?php endif; ?>

                                <label class="form_label">Nome</label>
                                <input type="text" name="nome" value="<?= isset($eqp['equipamento_nome']) ? htmlspecialchars($eqp['equipamento_nome']) : '' ?>" required>

                                <label class="form_label">Descrição</label>
                                <input type="text" name="descricao" value="<?= isset($eqp['descricao']) ? htmlspecialchars($eqp['descricao']) : '' ?>" required>
                                
                                <div class="form-section">
                                    <h3>Dano</h3>
                                    <div class="form-grid">
                                        <label class="form_label">Dano Físico</label>
                                        <input type="number" name="dano_fisico" value="<?= isset($eqp['dano_fisico']) ? $eqp['dano_fisico'] : '0' ?>" required>

                                        <label class="form_label">Dano Mágico</label>
                                        <input type="number" name="dano_magico" value="<?= isset($eqp['dano_magico']) ? $eqp['dano_magico'] : '0' ?>" required>

                                        <label class="form_label">Dano de Fogo</label>
                                        <input type="number" name="dano_fogo" value="<?= isset($eqp['dano_fogo']) ? $eqp['dano_fogo'] : '0' ?>" required>

                                        <label class="form_label">Dano Elétrico</label>
                                        <input type="number" name="dano_eletrico" value="<?= isset($eqp['dano_eletrico']) ? $eqp['dano_eletrico'] : '0' ?>" required>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <h3>Redução de Dano</h3>
                                    <div class="form-grid">
                                        <label class="form_label">Redução Dano Físico</label>
                                        <input type="number" name="dano_fisico_reducao" value="<?= isset($eqp['dano_fisico_reducao']) ? $eqp['dano_fisico_reducao'] : '0' ?>" required>

                                        <label class="form_label">Redução Dano Mágico</label>
                                        <input type="number" name="dano_magico_reducao" value="<?= isset($eqp['dano_magico_reducao']) ? $eqp['dano_magico_reducao'] : '0' ?>" required>

                                        <label class="form_label">Redução Dano de Fogo</label>
                                        <input type="number" name="dano_fogo_reducao" value="<?= isset($eqp['dano_fogo_reducao']) ? $eqp['dano_fogo_reducao'] : '0' ?>" required>

                                        <label class="form_label">Redução Dano Elétrico</label>
                                        <input type="number" name="dano_eletrico_reducao" value="<?= isset($eqp['dano_eletrico_reducao']) ? $eqp['dano_eletrico_reducao'] : '0' ?>" required>
                                    </div>
                                </div>

                                <div class="form-grid-2">
                                    <div>
                                        <label class="form_label">Estabilidade</label>
                                        <input type="number" name="estabilidade" value="<?= isset($eqp['estabilidade']) ? $eqp['estabilidade'] : '0' ?>" required>
                                    </div>
                                    
                                    <div>
                                        <label class="form_label">Effect</label>
                                        <input type="text" name="effect" value="<?= isset($eqp['effect']) ? htmlspecialchars($eqp['effect']) : '' ?>" required>
                                    </div>
                                </div>

                                <label class="form_label">Raridade</label>
                                <select class="select_add_eqp" name="raridade_id">
                                    <option value="1" <?= (isset($eqp['raridade_id']) && $eqp['raridade_id'] == 1) ? 'selected' : '' ?>>Comum</option>
                                    <option value="2" <?= (isset($eqp['raridade_id']) && $eqp['raridade_id'] == 2) ? 'selected' : '' ?>>Único</option>
                                    <option value="3" <?= (isset($eqp['raridade_id']) && $eqp['raridade_id'] == 3) ? 'selected' : '' ?>>Boss</option>
                                    <option value="4" <?= (isset($eqp['raridade_id']) && $eqp['raridade_id'] == 4) ? 'selected' : '' ?>>Dragão</option>
                                    <option value="5" <?= (isset($eqp['raridade_id']) && $eqp['raridade_id'] == 5) ? 'selected' : '' ?>>Demon</option>
                                </select>

                                <label class="form_label">Tipo de Equipamento</label>
                                <select id="selectTipo" class="select_add_eqp" name="tipo_equipamento">
                                    <option value="">Selecione o Tipo</option>
                                    <option value="arma" <?= (isset($eqp['arma_categoria_id']) && !empty($eqp['arma_categoria_id'])) ? 'selected' : '' ?>>Arma</option>
                                    <option value="escudo" <?= (isset($eqp['escudo_categoria_id']) && !empty($eqp['escudo_categoria_id'])) ? 'selected' : '' ?>>Escudo</option>
                                    <option value="anel" <?= (isset($eqp['tipo']) && $eqp['tipo'] == 'anel') ? 'selected' : '' ?>>Anel</option>
                                </select>

                                <label class="slc_cat_label">Categoria do equipamento</label>
                                <select id="selectCategoria" class="select_add_eqp slc_cat" name="categoria_id">
                                    <?php if(isset($eqp['arma_categoria_id']) && !empty($eqp['arma_categoria_id'])): ?>
                                        <option value="<?= $eqp['arma_categoria_id'] ?>" selected>
                                            <?= htmlspecialchars($eqp['arma_categoria_nome']) ?>
                                        </option>
                                    <?php elseif(isset($eqp['escudo_categoria_id']) && !empty($eqp['escudo_categoria_id'])): ?>
                                        <option value="<?= $eqp['escudo_categoria_id'] ?>" selected>
                                            <?= htmlspecialchars($eqp['escudo_categoria_nome']) ?>
                                        </option>
                                    <?php else: ?>
                                        <option value="">Selecione uma categoria</option>
                                    <?php endif; ?>
                                </select>

                                <div class="form-buttons">
                                    <button type="button" class="btn-save"><?= isset($eqp['equipamento_id']) ? 'Atualizar' : 'Salvar' ?></button>
                                    <button type="button" class="btn-close" id="closeModal">Fechar</button>
                                </div>
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
                    <div class="eqp_section">
                        <button id="build">Me Sugira uma build</button>
                        <p class="resposta_gemini"></p>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script>
        document.addEventListener('click', async function(e) {
            if (e.target.closest('#build')) {
                e.preventDefault();

                const respostaElem = document.querySelector('.resposta_gemini');
                respostaElem.textContent = 'Carregando...';

                try {
                    const equipamento = encodeURIComponent('<?= $eqp['equipamento_nome'] ?>');
                    const res = await fetch(`?controller=gemini&method=gerarBuild&equipamento=${equipamento}`);
                    if (!res.ok) throw new Error('Erro na requisição');

                    const buildResponse = await res.json();

                    // Como a Gemini retorna JSON dentro de "texto", precisamos parsear novamente
                    const build = JSON.parse(buildResponse.texto);

                    let texto = `🏹 Build: ${build.nome_build}\n\n`;

                    const eqp = build.equipamento;
                    texto += `🔹 Arma Principal: ${eqp.arma_principal.nome} - ${eqp.arma_principal.descricao}\n`;
                    texto += `🔹 Arma Secundária: ${eqp.arma_secundaria.nome} - ${eqp.arma_secundaria.descricao}\n`;
                    texto += `🔹 Escudo: ${eqp.escudo.nome} - ${eqp.escudo.descricao}\n`;
                    texto += `🔹 Anel 1: ${eqp.anel_1.nome} - ${eqp.anel_1.descricao}\n`;
                    texto += `🔹 Anel 2: ${eqp.anel_2.nome} - ${eqp.anel_2.descricao}\n`;
                    texto += `🔹 Cabeça: ${eqp.cabeca.nome} - ${eqp.cabeca.descricao}\n`;
                    texto += `🔹 Peitoral: ${eqp.peitoral.nome} - ${eqp.peitoral.descricao}\n`;
                    texto += `🔹 Luvas: ${eqp.luvas.nome} - ${eqp.luvas.descricao}\n`;
                    texto += `🔹 Pernas: ${eqp.pernas.nome} - ${eqp.pernas.descricao}\n\n`;

                    texto += `🔥 Feitiços/Piromancias:\n`;
                    eqp.feitiços_piromancias.forEach(f => {
                        texto += `- ${f.nome}: ${f.descricao}\n`;
                    });

                    texto += `\n💪 Status Ideais:\n`;
                    const s = build.status_ideais;
                    texto += `- Nível Inicial: ${s.nivel_inicial}\n`;
                    texto += `- Vitalidade: ${s.vitalidade.valor} (${s.vitalidade.descricao})\n`;
                    texto += `- Memória: ${s.memoria.valor} (${s.memoria.descricao})\n`;
                    texto += `- Resistência: ${s.resistencia.valor} (${s.resistencia.descricao})\n`;
                    texto += `- Força: ${s.forca.valor} (${s.forca.descricao})\n`;
                    texto += `- Destreza: ${s.destreza.valor} (${s.destreza.descricao})\n`;
                    texto += `- Resistência Física: ${s.resistencia_fisica.valor} (${s.resistencia_fisica.descricao})\n`;
                    texto += `- Inteligência: ${s.inteligencia.valor} (${s.inteligencia.descricao})\n`;
                    texto += `- Fé: ${s.fe.valor} (${s.fe.descricao})\n`;

                    respostaElem.textContent = texto;

                } catch (err) {
                    respostaElem.textContent = '❌ Erro ao gerar build: ' + err.message;
                }
            }
        });
    </script>
</body>
</html>