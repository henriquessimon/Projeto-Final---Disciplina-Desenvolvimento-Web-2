document.addEventListener('click', async function(e) {
    if (e.target.closest('.btn-save')) {
        e.preventDefault();

        const nome = document.querySelector('[name="nome"]').value
        const descricao = document.querySelector('[name="descricao"]').value
        const link_img = document.querySelector('[name="link_img"]').value
        const dificuldade = document.querySelector('.select_add_eqp').value

        const formAddEqp = document.getElementById('formAddEqp');

        let msg = document.querySelector('.message_error, .message_success');

        if (!msg) {
            msg = document.createElement('p');
            formAddEqp.appendChild(msg);
        }

        if (!nome || !descricao || !link_img || !dificuldade) {
            msg.className = 'message_error';
            msg.textContent = "Algum campo não está preenchido";
            msg.style.color = "#990000";
            return;
        }

        const data = {
            nome,
            descricao,
            link_img,
            dificuldade
        };

        const response = await createLocal(data);

        msg.className = 'message_success';
        msg.textContent = response.message;
        msg.style.color = "#009900";
        
        setTimeout(() => window.location.reload(), 600);
    }

    if(e.target.closest('.local_list_item')) {
        const local_id = e.target.closest('.local_list_item').getAttribute('id');
        window.location.href = `?controller=local&method=getOneLocal&local_id=${local_id}`;
    }

    if(e.target.closest('.dlt_local')) {
        e.stopPropagation();
        const local_id = e.target.closest('.local_list_item').getAttribute('id');

        const data = await deleteLocal(local_id);

        if(data.success == true) {
            const local_list_container = document.querySelector('.local_list_container');
            const local = document.getElementById(local_id);
            
            local_list_container.removeChild(local);
        }

        return
    }
});

async function createLocal(data) {
        const resp = await fetch('?controller=local&method=createLocal', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    });

    try {
        return await resp.json();
    } catch(err) {
        console.error('Algo de errado não está certo no create: ', err);
        return {message: "Erro inesperado"}
    }
}

async function deleteLocal(id) {
    const resp = await fetch(`?controller=local&method=deleteLocal&id=${id}`, {
        method: 'POST',
    })

    return await resp.json();
}