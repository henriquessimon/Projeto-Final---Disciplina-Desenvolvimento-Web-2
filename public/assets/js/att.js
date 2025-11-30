document.addEventListener('DOMContentLoaded', () => {

    const nome_completo = document.querySelector('[name="nome_completo"]');
    const telefone = document.querySelector('[name="telefone"]');
    const email = document.querySelector('[name="email"]');
    const senha = document.querySelector('[name="senha"]');

    // ===== CARREGAR DADOS DO USUÁRIO =====
    fetch('?controller=usuario&method=getOneUser', { method: 'GET' })
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


    // ===== EVENTOS DE CLIQUE =====
    document.addEventListener('click', async function(e) {

        // ===== ATUALIZAR USUÁRIO =====
        if (e.target.closest('#attButton')) {

            const data = {
                nome_completo: nome_completo.value,
                telefone: telefone.value,
                email: email.value,
                senha: senha.value
            };

            const resposta = await attUser(data);

            const formUser = document.getElementById('form_user');

            // Remove mensagem anterior
            const msgAntiga = formUser.querySelector('.msgResposta');
            if (msgAntiga) msgAntiga.remove();

            // Criar elemento de mensagem
            const msg = document.createElement('div');
            msg.classList.add('msgResposta');
            msg.style.marginTop = '10px';

            // Caso erro
            if (!resposta.success) {
                msg.style.color = 'red';

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
            msg.innerText = "Usuário atualizado com sucesso!";
            formUser.appendChild(msg);

            // Recarrega a página
            setTimeout(() => window.location.reload(), 1000);
        }


        // ===== EXCLUIR USUÁRIO =====
        if (e.target.closest('#excluir_user')) {
            const resposta = await excUser();

            if (resposta.success) {
                alert('Usuário excluído com sucesso');
                window.location.href = '?controller=home&method=index';
            }
        }

    });
});



// ============================================================
// FUNÇÕES AJAX
// ============================================================

// Atualizar usuário
async function attUser(data) {
    const resp = await fetch('?controller=usuario&method=attUser', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    });

    return await resp.json(); // <-- CORREÇÃO IMPORTANTE
}

// Excluir usuário
async function excUser() {
    const resp = await fetch('?controller=usuario&method=deleteUser', {
        method: 'GET'
    });

    return await resp.json();
}
