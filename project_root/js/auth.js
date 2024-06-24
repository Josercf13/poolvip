document.addEventListener('DOMContentLoaded', () => {
    const logoutButton = document.getElementById('logoutButton');
    if (logoutButton) {
        logoutButton.addEventListener('click', () => {
            fetch('backend/logout.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = 'login.html';
                    } else {
                        alert('Error al cerrar sesión. Por favor, inténtelo de nuevo.');
                    }
                });
        });
    }

    // Mostrar nombre de usuario en el dashboard
    const usernameDisplay = document.getElementById('username');
    if (usernameDisplay) {
        fetch('backend/get_user_info.php')
            .then(response => response.json())
            .then(data => {
                if (data.username) {
                    usernameDisplay.textContent = data.username;
                }
            });
    }
});
