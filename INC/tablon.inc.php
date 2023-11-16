<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CSS/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Revels.</title>
</head>

<body cz-shortcut-listen="true">
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top mask-custom shadow-0">
        <div class="container-fluid">
            <a class="navbar-brand" href="/index.php">
                <img src="/MEDIA-REVELS-LOGO/logo-navbar.png" alt="logoNav">
            </a>
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form class="me-3">
                    <div class="form-white input-group" style="width: 250px;">
                        <input type="search" class="form-control rounded" placeholder="Search..." aria-label="Search" aria-describedby="search-addon">
                    </div>
                </form>
            </div>

                <div class="login">
                    <button type="button" class="btn btn-danger" data-mdb-ripple-color="#ffffff"> Mi perfil </button>
                    <button type="button" class="btn btn-danger" data-mdb-ripple-color="#ffffff"> Nuevo Revel </button>
                    <form method="post" action="/INC/logout.inc.php">
                    <button type="submit" class="btn btn-danger"> Salir </button>
                </form>
                </div>';

        </div>
    </nav>

    <!-- LOGIN FORM -->
   

</body>

</html>