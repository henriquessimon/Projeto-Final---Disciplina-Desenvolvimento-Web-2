document.addEventListener('DOMContentLoaded', () => {
    const submitButton = document.querySelector('.button_send');

    submitButton.addEventListener('click', async (e) => {
        e.preventDefault();
        const fields = {
            email: document.querySelector('input[name="email"]').value,
            senha: document.querySelector('input[name="pass"]').value
        }
        const resp = await fetch('http://localhost/sys_login/core/Router.php?controller=Auth&method=login', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(fields)
        });

        const data = await resp.json();

        console.log(data);

        if(data.success == false) {
            const message = document.querySelector('.display_none_error_login');
            console.log(message);
            message.classList.remove('display_none_error_login');
            message.classList.add('display_block_error_login');
        } else {
            window.location.href = "http://localhost/sys_login/app/Views/mainPage.php"
        }
    })
});