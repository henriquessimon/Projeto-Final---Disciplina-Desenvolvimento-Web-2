document.addEventListener('click', function(e) {
    if(e.target.closest('#addEqp')) {
        const modalAddEqp = document.getElementById('modalAddEqp');
        modalAddEqp.style.display = 'flex';
    }

    if(e.target.closest('#closeModal')) {
        document.getElementById('modalAddEqp').style.display = 'none';
    }

    if(document.getElementById("modalAddEqp")) {
        document.getElementById("modalAddEqp").addEventListener("click", (e) => {
            if (e.target.id === "modalAddEqp") {
                e.target.style.display = "none";
            }
        });
    }
});