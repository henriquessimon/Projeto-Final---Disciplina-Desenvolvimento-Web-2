document.addEventListener('click', async function(e) {
    if (e.target.closest('.btn-save')) {
        e.preventDefault();

        const formAddEqp = document.getElementById('formAddEqp');

        const data = {
            id: formAddEqp.querySelector('[name="id"]')?.value || null,
            nome: formAddEqp.querySelector('[name="nome"]').value,
            descricao: formAddEqp.querySelector('[name="descricao"]').value,
            effect: formAddEqp.querySelector('[name="effect"]').value,
            raridade_id: formAddEqp.querySelector('[name="raridade_id"]').value,
            tipo_equipamento: formAddEqp.querySelector('[name="tipo_equipamento"]').value,
            categoria_id: formAddEqp.querySelector('[name="categoria_id"]').value,
            dano_fisico: formAddEqp.querySelector('[name="dano_fisico"]').value,
            dano_magico: formAddEqp.querySelector('[name="dano_magico"]').value,
            dano_fogo: formAddEqp.querySelector('[name="dano_fogo"]').value,
            dano_eletrico: formAddEqp.querySelector('[name="dano_eletrico"]').value,
            dano_fisico_reducao: formAddEqp.querySelector('[name="dano_fisico_reducao"]').value,
            dano_magico_reducao: formAddEqp.querySelector('[name="dano_magico_reducao"]').value,
            dano_fogo_reducao: formAddEqp.querySelector('[name="dano_fogo_reducao"]').value,
            dano_eletrico_reducao: formAddEqp.querySelector('[name="dano_eletrico_reducao"]').value,
            estabilidade: formAddEqp.querySelector('[name="estabilidade"]').value
        };

        let msg = document.querySelector('.message_error, .message_success');

        if (!msg) {
            msg = document.createElement('p');
            formAddEqp.appendChild(msg);
        }

        const emptyField = Object.entries(data).find(([key, value]) => value === null || value === '');
        if (emptyField) {
            msg.className = 'message_error';
            msg.textContent = `O campo "${emptyField[0]}" não está preenchido`;
            msg.style.color = "#990000";
            return;
        }


        const response = await attEqp(data);

        msg.className = 'message_success';
        msg.textContent = response.message;
        msg.style.color = "#009900";
        
        setTimeout(() => window.location.reload(), 600);
    }
})

async function attEqp(data) {
    const resp = await fetch('?controller=equipamento&method=attEqp', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    });

    return await resp.json();
}