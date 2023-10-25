<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CSS/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>INDEXXX</title>
</head>



<body cz-shortcut-listen="true">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top mask-custom shadow-0">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/MEDIA-REVELS-LOGO/logo-meouwth.png" alt="logoNav">
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
            <div class="button-container">
                <button type="button" id="btnRegister" class="btn btn-rounded" data-mdb-ripple-color="#ffffff" style="background-color:#fc92ad">REGISTER</button>
                <button type="button" id="btnLogin" class="btn btn-rounded" data-mdb-ripple-color="#ffffff" style="background-color:#fc92ad">LOGIN</button>
            </div>
        </div>
    </nav>

    <!-- REGISTER FORM -->
    <div class="register-page">
        <div class="form">
            <form class="register-form">
                <input type="text" placeholder="name" />
                <input type="password" placeholder="password" />
                <input type="text" placeholder="email address" />
                <button>create</button>
                <p class="message">Already registered? <a href="#">Sign In</a></p>
            </form>
            <form class="register-form">
                <input type="text" placeholder="username" />
                <input type="password" placeholder="password" />
                <button>Register</button>
                <p class="message">¿Tienes una cuenta? <a href="#">Logueate</a></p>
            </form>
        </div>
    </div>

</body>



</html>