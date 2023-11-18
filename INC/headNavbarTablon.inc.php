<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CSS/tablon.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="/MEDIA-REVELS-LOGO/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Revels.</title>
</head>
<nav class="navbar navbar-expand-lg navbar-light fixed-top mask-custom shadow-0">
    <div class="container-fluid">
        <a class="navbar-brand" href="/index">
            <img src="/MEDIA-REVELS-LOGO/logo-navbar.png" alt="logoNav">
        </a>
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <form method="post" action="/results" class="me-3">
                <div class="form-white input-group" style="width: 250px;">
                    <input type="search" class="form-control rounded" placeholder="Search..." name="search_query" aria-label="Search" aria-describedby="search-addon">
                    <button id="btnSearch" type="submit" class="btn button-33">Buscar</button>
                </div>
            </form>
        </div>
        <h3 id='bienvenido'>
            ¡Bienvenid@, <?php echo $_SESSION['usuario'] ?>!
        </h3>
        <div class="buttons">
            <form method="post" action="/user/<?php echo urlencode($_SESSION['usuario']); ?>">
                <button type="submit" class="btn button-33"> Mi perfil </button>
            </form>
            <form method="post" action="/new">
                <button type="submit" class="btn button-33"> Nuevo Revel </button>
            </form>
            <form method="post" action="/close.php">
                <button type="submit" class="btn button-33"> Salir </button>
            </form>
        </div>
    </div>
</nav>