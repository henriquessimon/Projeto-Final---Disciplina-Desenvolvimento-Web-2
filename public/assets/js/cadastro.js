document.addEventListener('DOMContentLoaded', () => {
    button_send = document.querySelector('.button_send');

    button_send.addEventListener('click', async () => {
        const name = document.querySelector('[name="name"]').value;
        const phone = document.querySelector('[name="phone"]').value;
        const pass = document.querySelector('[name="pass"]').value;
        const email = document.querySelector('[name="email"]').value;
        const sys_termos_uso = document.querySelector('[name="sys_termos_uso"]');

        let role_user

        const params = new URLSearchParams(window.location.search);

        if(params.get('adm')) {
            role_user = 'adm'
        } else {
            role_user = 'normal'
        }

        data = {
            name: name,
            phone: phone,
            pass: pass,
            email: email,
            sys_termos_uso: sys_termos_uso.checked,
            role_user: role_user
        }

        resposta = await cadastroUser(data)

        if(resposta.erro) {
            resposta.erros_campos.forEach(campo => {
                const field = document.querySelector(`[name="${campo}"]`)
                field.classList.add('erro_field');
            });

            return
        }

        window.location.href = "?controller=equipamento&method=listarEquipamentos"
    });
})

async function cadastroUser(data) {
    const resp = await fetch("?controller=usuario&method=cadastrarUsuario", {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    });

    return await resp.json();
}