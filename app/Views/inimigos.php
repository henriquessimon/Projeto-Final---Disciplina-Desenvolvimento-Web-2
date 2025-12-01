<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DS Equip Wiki</title>
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>public/assets/style/global.css" />
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>public/assets/style/inimigo_list.css" />
    <?php include_once __DIR__ . '/components/importCssHF.php' ?>
    <script src="<?= BASE_URL ?>public/assets/js/modal.js"></script>
    <script src="<?= BASE_URL ?>public/assets/js/inimigos.js"></script>
</head>

<body>
    <header>
        <?php include_once __DIR__ . '/components/header.php'; ?>
    </header>
    <main>
        <section>
            <?php
                if(isset($_SESSION['role_user']) && $_SESSION['role_user'] == 'adm') {

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
                            <h1>Inimigos</h1>
                            <?php
                                if(isset($_SESSION['role_user']) && $_SESSION['role_user'] == 'adm') {

                            ?>
                                <button class="addEqp" id="addEqp">Adicionar Inimigo</button>
                            <?php 
                                }
                            ?>
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
                                <?php
                                    if(isset($_SESSION['role_user']) && $_SESSION['role_user'] == 'adm') {

                                ?>
                                    <li></li>
                                <?php 
                                    }
                                ?>
                            </ul>
                            <?php foreach ($enemys as $enem):?>
                                <ul class="enemy_list_item click_item" id="<?=$enem['id']?>">
                                    <li><?= $enem['nome'] ?></li>
                                    <li><?= $enem['res_fisica'] ?></li>
                                    <li><?= $enem['res_magica'] ?></li>
                                    <li><?= $enem['res_fogo'] ?></li>
                                    <li><?= $enem['res_eletrico'] ?></li>
                                    <?php
                                        if(isset($_SESSION['role_user']) && $_SESSION['role_user'] == 'adm') {

                                    ?>
                                        <li>
                                            <svg class="dlt_enemy" width="24" height="24" viewBox="0 0 24 24" fill="red" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3 6H5H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6H19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M10 11V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M14 11V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </li>
                                    <?php 
                                        }
                                    ?>
                                </ul>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
        </section>
    </main>
</body>
</html>