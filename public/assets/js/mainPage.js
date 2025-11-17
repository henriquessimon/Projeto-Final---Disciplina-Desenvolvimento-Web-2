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

    document.addEventListener('click', function(e) {
        if (e.target.closest('#favoritar')) {
            estrela_button = e.target.closest('#favoritar');
            eqp_id = e.target.closest('.status_eqp_list').getAttribute('id');
            estrela_svg = estrela_button.querySelector('#estr_svg');

            favoritar(eqp_id).then(favoritou => {
                estrela_svg.setAttribute('fill', favoritou ? 'gold' : '');
            });
        }

        if(e.target.closest('#addEqp')) {
            const modalAddEqp = document.getElementById('modalAddEqp');
            modalAddEqp.style.display = 'flex';
        }

        if(e.target.closest('#closeModal')) {
            document.getElementById('modalAddEqp').style.display = 'none';
        }

        if(document.getElementById("modalAddEqp")) {
            document.getElementById("modalAddEqp").addEventListener("click", (e) => {
                if (e.target.id === "modalAddEqp") {
                    e.target.style.display = "none";
                }
            });
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
})