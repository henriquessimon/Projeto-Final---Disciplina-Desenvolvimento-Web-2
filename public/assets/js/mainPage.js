document.addEventListener('DOMContentLoaded', () => {
    const categorias = {
        arma: [
            { id: 1, nome: "Daggers" },
            { id: 2, nome: "Straight Swords" },
            { id: 3, nome: "Greatswords" },
            { id: 4, nome: "Ultra Greatswords" },
            { id: 5, nome: "Curved Swords" },
            { id: 6, nome: "Katanas" },
            { id: 7, nome: "Curved Greatswords" },
            { id: 8, nome: "Piercing Swords" },
            { id: 9, nome: "Axes" },
            { id: 10, nome: "Great Axes" },
            { id: 11, nome: "Hammers" },
            { id: 12, nome: "Great Hammers" },
            { id: 13, nome: "Fist & Claw" },
            { id: 14, nome: "Spears" },
            { id: 15, nome: "Halberds" },
            { id: 16, nome: "Whips" },
            { id: 17, nome: "Bows" },
            { id: 18, nome: "Greatbows" },
            { id: 19, nome: "Crossbows" },
            { id: 20, nome: "Flames" },
            { id: 21, nome: "Catalysts" },
            { id: 22, nome: "Talismans" },
        ],

        escudo: [
            { id: 1, nome: "Small Shields" },
            { id: 2, nome: "Standard Shields" },
            { id: 3, nome: "Greatshields" }
        ]
    };

    //FAVORITAR
    async function favoritar(eqp_id) {
        try {
            resp = await fetch(`http://localhost/sys_login/index.php?controller=favoritos&method=Favoritar&eqp_id=${eqp_id}`);
            data = await resp.json();

            return data.favorito
        } catch (error){
            console.error('Erro: ', error);
        }
    }

    document.addEventListener('click', async function(e) {
        if (e.target.closest('#favoritar')) {
            estrela_button = e.target.closest('#favoritar');
            eqp_id = e.target.closest('.status_eqp_list').getAttribute('id');
            estrela_svg = estrela_button.querySelector('#estr_svg');

            favoritar(eqp_id).then(favoritou => {
                estrela_svg.setAttribute('fill', favoritou ? 'gold' : '');
            });
        }
        if (e.target.closest('.btn-save')) {
            e.preventDefault();

            const form = document.getElementById('formAddEqp');

            let msg = form.querySelector('.message_error, .message_success');

            if (!msg) {
                msg = document.createElement('p');
                form.appendChild(msg);
            }
            const nome = form.querySelector('[name="nome"]').value.trim();
            const descricao = form.querySelector('[name="descricao"]').value.trim();
            const dano_fisico = form.querySelector('[name="dano_fisico"]').value;
            const dano_magico = form.querySelector('[name="dano_magico"]').value;
            const dano_fogo = form.querySelector('[name="dano_fogo"]').value;
            const dano_eletrico = form.querySelector('[name="dano_eletrico"]').value;
            const dano_fisico_reducao = form.querySelector('[name="dano_fisico_reducao"]').value;
            const dano_magico_reducao = form.querySelector('[name="dano_magico_reducao"]').value;
            const dano_fogo_reducao = form.querySelector('[name="dano_fogo_reducao"]').value;
            const dano_eletrico_reducao = form.querySelector('[name="dano_eletrico_reducao"]').value;
            const estabilidade = form.querySelector('[name="estabilidade"]').value;
            const effect = form.querySelector('[name="effect"]').value.trim();

            const raridade = form.querySelector('.select_add_eqp').value;
            const tipo = document.getElementById('selectTipo').value;

            let categoria = null;
            if (tipo !== 'anel') {
                categoria = document.getElementById('selectCategoria').value;
            }

            if (!nome || !descricao || !raridade || !tipo || !effect) {
                msg.className = 'message_error';
                msg.style.color = "#990000";
                msg.textContent = "Algum campo obrigatório não está preenchido.";
                return;
            }

            if (tipo !== 'anel') {
                const numCampos = [
                    dano_fisico, dano_magico, dano_fogo, dano_eletrico,
                    dano_fisico_reducao, dano_magico_reducao,
                    dano_fogo_reducao, dano_eletrico_reducao, estabilidade
                ];

                if (numCampos.some(v => v === "")) {
                    msg.className = 'message_error';
                    msg.style.color = "#990000";
                    msg.textContent = "Preencha todos os campos de dano / redução / estabilidade.";
                    return;
                }
            }

            const data = {
                nome,
                descricao,
                raridade,
                tipo,
                effect,
                ...(tipo !== 'anel' && {
                    dano_fisico,
                    dano_magico,
                    dano_fogo,
                    dano_eletrico,
                    dano_fisico_reducao,
                    dano_magico_reducao,
                    dano_fogo_reducao,
                    dano_eletrico_reducao,
                    estabilidade,
                    categoria
                })
            };

            console.log(data);

            const response = await createEqp(data);

            msg.className = 'message_success';
            msg.style.color = "#009900";
            msg.textContent = response.message;

            const container = document.querySelector('.equip_list_container');

            if (container) {
                const div = document.createElement('div');
                div.classList.add('equip_list_item');
                div.innerHTML = `<h3>${data.nome}</h3>`;
                container.appendChild(div);
            }

            //setTimeout(() => window.location.reload(), 600);
        }
    });

    selectTipo = document.getElementById('selectTipo');
    if(selectTipo) {
        selectTipo.addEventListener('change', () => {
            selectCat = document.getElementById('selectCategoria');
            if(selectCat) {
                selectCatLabel = document.querySelector('.slc_cat_label');
            }
            const tipo = selectTipo.value;

            selectCat.innerHTML = '';

            if (tipo == "anel"){
                selectCat.style.display = 'none';
                selectCatLabel.style.display = 'none';
                return;
            }

            categorias[tipo].forEach(cat => {
                const option = document.createElement('option');
                option.value = cat.id;
                option.textContent = cat.nome;
                selectCat.appendChild(option);
            });

            selectCat.style.display = 'block';
            selectCatLabel.style.display = 'block';
        });
    }

    async function createEqp(data) {
        const resp = await fetch('?controller=equipamento&method=createEqp', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(data)
        });
        try {
            return await resp.json();
        } catch(err) {
            console.error("Erro inesperado no retorno:", err);
            return { message: "Erro inesperado." };
        }
    }

})