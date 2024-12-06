<?php
include("../protect.php");
protect();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/telaInicial.css" class="css">
    <link rel="stylesheet" href="../css/responsive.css" class="css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <!-- /Bootstrap -->

    <title>Tela inicial</title>

</head>

<body class="telaInicial">

    <header>
        <nav class="navbar sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="../Imagens/logoGemtes.png" alt="Gemtes" width="200" height="50">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 nav-underline">
                            <li class="nav-item">
                                <a class="nav-link" href="./telaInicial.php">Tela inicial</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./assistidos.php">Assistidos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./avaliacoes.php">Avaliações</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./consultas.php">Consultas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./relatorio.php">Relatório</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../sair.php">Sair</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <section class="hero-site">
        <div class="interface">

            <div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                <div class="card-body">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2">
                            <div class="d-flex flex-column mb-3">
                                <div class="p-2">
                                    <h1 class="display-4 fw-bold lh-1 text-body-emphasis">Bem-vindo de volta!</h1>
                                </div>
                                <div class="p-2">
                                    <p class="lead">O que você quer fazer?</p>
                                </div>
                                <div class="p-2">
                                    <button type="button" class="btn btn-primary m-2">
                                        <a class="link-body-emphasis text-decoration-none" href="./assistidos.php">Ver assistidos</a>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary m-2">
                                        <a class="link-body-emphasis text-decoration-none" href="./avaliacoes.php">Avaliações</a>
                                    </button>
                                </div>
                            </div>


                        </div>
                        <div class="p-2">
                            <img class="rounded-lg-3 imagemTelaInicial" src="../Imagens/bloquinhos.png" alt="Desenho pessoas montando blocos" height="420">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>

</html>