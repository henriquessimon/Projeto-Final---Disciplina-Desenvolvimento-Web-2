document.addEventListener('click', async function(e) {

    if(e.target.closest('.dlt_enemy')) {
        e.stopPropagation();
        const enemy_id = e.target.closest('.enemy_list_item').getAttribute('id');

        const data = await deleteInimigo(enemy_id);

        if(data.success == true) {
            const enemy = document.getElementById(enemy_id);
            
            if(enemy) {
                enemy.remove()
            }
        }

        return;
    }
           
    if(e.target.closest('.click_item') && !e.target.closest('.dlt_enemy')) {
        const enemy_id = e.target.closest('.click_item').getAttribute('id');
        window.location.href = `<?= BASE_URL ?>?controller=inimigo&method=getOneInimigo&enemy_id=${enemy_id}`;
        
    }

    if (e.target.closest('.btn-save')) {
        console.log('crico');
        const nome = document.querySelector('[name="nome"]').value;
        const descricao = document.querySelector('[name="descricao"]').value;
        const res_fisica = document.querySelector('[name="res_fisica"]').value;
        const res_magica = document.querySelector('[name="res_magico"]').value;
        const res_fogo = document.querySelector('[name="res_fogo"]').value;
        const res_eletrico = document.querySelector('[name="res_eletrico"]').value;
        const tipo = document.querySelector('.tipo').value;
        const local = Array.from(document.querySelector('.local').selectedOptions).map(opt => opt.value);


        if (!nome || !descricao || !res_fisica || !res_magica || !res_fogo || !res_eletrico || !tipo || !local) {
            if(!document.querySelector('.message_error') && !document.querySelector('.message_success')) {      
                const p = document.createElement('p');
                p.classList.add('message_error');
                p.textContent = "Algum campo não está preenchido";
                p.style.color= "#990000";

                const formAddEqp = document.getElementById('formAddEqp');
                formAddEqp.appendChild(p);
            } else {
                const p = document.querySelector('.message_success');
                p.classList.remove('message_success');
                p.classList.add('message_error');
                p.textContent = "Algum campo não está preenchido";
                p.style.color= "#990000";
            }

            return
        }

        const data = {
            nome,
            descricao,
            res_fisica,
            res_magica,
            res_fogo,
            res_eletrico,
            tipo,
            local
        };

        const response = await createInimigo(data);

        if(!document.querySelector('.message_success')){
            const p = document.createElement('p');
            p.classList.add('message_success');
            p.textContent = `${response.message}`;
            p.style.color= "#009900";

            const formAddEqp = document.getElementById('formAddEqp');
            formAddEqp.appendChild(p);
        }

        setTimeout(() => window.location.reload(), 600);
    }
});

async function createInimigo(data) {
    const resp = await fetch('?controller=inimigo&method=createInimigo', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    });

    return await resp.json();
}

async function deleteInimigo(id) {
    const resp = await fetch(`?controller=inimigo&method=deleteInimigo&id=${id}`, {
        method: 'POST',
    })

    return await resp.json();
}