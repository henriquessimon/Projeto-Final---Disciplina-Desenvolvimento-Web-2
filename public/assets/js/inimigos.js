document.addEventListener('click', async function(e) {
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

        const enemy_list_container = document.querySelector('.enemy_list_container');

        const ul = document.createElement('ul');
        ul.classList.add('enemy_list_item', 'click_item');

        ul.innerHTML = `
            <li>${data.nome}</li>
            <li>${data.res_fisica}</li>
            <li>${data.res_magica}</li>
            <li>${data.res_fogo}</li>
            <li>${data.res_eletrico}</li>
        `;

        enemy_list_container.appendChild(ul);
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
