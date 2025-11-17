setInterval(() => {
    fetch('?controller=auth&method=verifica_login')
    .then(resp => {
        if(!resp.ok) {
            throw new Error('Erro ao verificar sessão');
        }
        return resp.json();
    })
    .then(data => {
        if(!data.logged_in && data.expirou) {
            alert('Sua sessão expirou');
            window.location.href ='?controller=home&method=index';
        }
    })
    .catch(error => {
        console.log("Erro: ", error);
    });
}, 10000)