document.addEventListener('DOMContentLoaded', () => {

    const nome_completo = document.querySelector('[name="nome_completo"]');
    const telefone = document.querySelector('[name="telefone"]');
    const email = document.querySelector('[name="email"]');
    const senha = document.querySelector('[name="senha"]');

    fetch('?controller=usuario&method=getOneUser', {
        method: 'GET'
    })
    .then(resp => {
        if (!resp.ok) throw new Error("Erro ao procurar usuario");
        return resp.json();
    })
    .then(data => {

        if (!data.results) {
            console.error("Nenhum usuário encontrado");
            return;
        }

        nome_completo.value = data.results.nome_completo;
        telefone.value = data.results.telefone;
        email.value = data.results.email;
    })
    .catch(err => {
        console.error("Erro na requisição de carregamento do usuario", err);
    });


    document.addEventListener('click', async function(e) {
        if (e.target.closest('#attButton')) {

            const data = {
                nome_completo: nome_completo.value,
                telefone: telefone.value,
                email: email.value,
                senha: senha.value
            }

            const resposta = await attUser(data);

            const formUser = document.getElementById('form_user');

            // Remove mensagem anterior (se houver)
            const msgAntiga = formUser.querySelector('.msgResposta');
            if (msgAntiga) msgAntiga.remove();

            // Criar elemento de mensagem
            const msg = document.createElement('div');
            msg.classList.add('msgResposta');

            // Caso erro
            if (!resposta.success) {

                msg.style.color = 'red';
                msg.style.marginTop = '10px';

                if (resposta.erros_campos) {
                    msg.innerText = `Erro: campos inválidos → ${resposta.erros_campos.join(', ')}`;
                } else {
                    msg.innerText = "Erro ao atualizar usuário.";
                }

                formUser.appendChild(msg);
                return;
            }

            // Caso sucesso
            msg.style.color = 'green';
            msg.style.marginTop = '10px';
            msg.innerText = "Usuário atualizado com sucesso!";

            formUser.appendChild(msg);

            // Atualiza a página depois de mostrar a mensagem
            setTimeout(() => window.location.reload(), 1000);
        }

        if (e.target.closest('#excluir_user')) {
            const resposta = await excUser();

            if (resposta.success) {
                alert('Usuário excluído com sucesso');
                window.location.href = '?controller=home&method=index';
            }
        }
    })
})

async function attUser(data) {
    const resp = await fetch('?controller=usuario&method=attUser', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    })

    return await resp
}

async function excUser() {
    const resp = await fetch('?controller=usuario&method=deleteUser', {
        method: 'GET'
    })

    return await resp.json();
}