<div class="header_main_container">
    <div class="header_ident_container">
        <div class="header_sub_container">
            <div class="header_list_container">
                <ul class="header_list">
                    <a href="<?=BASE_URL ?>?controller=inimigo&method=listarInimigos"><li class="header_list_item">Inimigos</li></a>
                    <a href="<?=BASE_URL ?>?controller=equipamento&method=listarEquipamentos"><li class="header_list_item">Equipamentos</li></a>
                    <a href="<?=BASE_URL ?>?controller=local&method=listarLocais"><li class="header_list_item">Locais</li></a>
                </ul>
            </div>
        </div>
        <div class="header_user">
            <span>
                <svg width="30" height="30" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="20" cy="20" r="19" stroke="#f17929" stroke-width="2" fill="none"/>
                    <circle cx="20" cy="16" r="5" stroke="#f17929" stroke-width="2" fill="none"/>
                    <path d="M28 31C28 26.5817 24.4183 23 20 23C15.5817 23 12 26.5817 12 31" stroke="#f17929" stroke-width="2" fill="none"/>
                </svg>
            </span>
            <div class="menu_container">
                <ul class="menu_opt">
                    <li id="favs_header">Favoritos</li>
                    <li id="attPage">Atualizar Cadastro</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const favs_header = document.getElementById('favs_header');
    favs_header.addEventListener('click', () => {
        window.location.href = '<?=BASE_URL ?>?controller=favoritos&method=listarFavoritos';
    });

    const attPage = document.getElementById('attPage');
    attPage.addEventListener('click', () => {
        window.location.href = `<?= BASE_URL ?>?controller=atualiza&method=attPage`;
    });
});
</script>