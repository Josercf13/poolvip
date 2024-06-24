<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/base.css">
</head>

<body>



    <div id="mySidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="wallet.php">Wallet</a>
        <a href="pool.php">Pool</a>
        <a href="configuration.php">Configuración</a>
        <button id="logoutButton">Cerrar sesión</button>
    </div>

    <div id="main">
        <button class="openbtn" onclick="openNav()">&#9776; </button>  
        <div class="container dashboard-container">
            <div class="dashboard-header">
                <h1>Dashboard</h1>

            </div>
            <p>Usuario: <span id="username"></span></p>
        </div>
    </div>

    <script src="js/auth.js"></script>
    <script>
        function openNav() {
            document.getElementById("mySidebar").style.left = "0";
            document.getElementById("main").style.marginLeft = "250px";
        }

        function closeNav() {
            document.getElementById("mySidebar").style.left = "-250px";
            document.getElementById("main").style.marginLeft= "0";
        }
    </script>
</body>
</html>

<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        echo '
            <script>
            alert("debes iniciar sesión");
            </script>
        ';
    header("location: login.html");
    session_destroy();
    die();

}
?>