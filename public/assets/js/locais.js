document.addEventListener('click', async function(e) {
    if (e.target.closest('.btn-save')) {
        e.preventDefault();

        const nome = document.querySelector('[name="nome"]').value
        const descricao = document.querySelector('[name="descricao"]').value
        const link_img = document.querySelector('[name="link_img"]').value
        const dificuldade = document.querySelector('.select_add_eqp').value

        const formAddEqp = document.getElementById('formAddEqp');

        // ======== SISTEMA DE MENSAGEM ÚNICA ========
        let msg = document.querySelector('.message_error, .message_success');

        if (!msg) {
            msg = document.createElement('p');
            formAddEqp.appendChild(msg);
        }
        // ===========================================

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

        // Atualiza dinamicamente a lista
        const local_list_container = document.querySelector('.local_list_container');
        const div = document.createElement('div');
        div.classList.add('local_list_item');
        div.innerHTML = `<h3>${data.nome}</h3>`;
        local_list_container.appendChild(div);

        // Se quiser recarregar, mas espere um pouco pro usuário ver:
        setTimeout(() => window.location.reload(), 600);
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
        console.error('Algo de errado não está certo: ', err);
        return {message: "Erro inesperado"}
    }
}