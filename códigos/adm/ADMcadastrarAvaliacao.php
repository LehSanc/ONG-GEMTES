<?php


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/avaliacoes.css" class="css">
    <link rel="stylesheet" href="../css/responsive.css" class="css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <!-- /Bootstrap -->

    <title>Avaliações</title>

</head>

<body>

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
                                <a class="nav-link" href="./ADMusuarios.php">Usuários</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./ADMtelaInicial.php">Tela inicial</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./ADMassistidos.php">Assistidos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./ADMavaliacoes.php">Avaliações</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./ADMconsultas.php">Consultas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./ADMrelatorio.php">Relatório</a>
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

            <div aria-live="polite" aria-atomic="true">
                <div class="toast-container p-3">

                    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <strong class="me-auto">Gemtes</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            <?php foreach ($mensagem as $msg) {
                                echo $msg;
                            } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container py-5">

                <h3 class="py-2">Cadastrar avaliação</h3>

                <form class="needs-validation row g-3" method="POST" action="" novalidate>

                    <div class="col-md-8">
                        <div class="col-md-8">
                            <label for="campo_texto" class="form-label">
                                <div class="d-flex flex-column mb-3">
                                    <div class="p-2">
                                        <div class="fw-bold">Passo 1: </div> Descreva qual informação é esperada de forma objetiva.
                                    </div>
                                    <div class="p-2">Campo de texto que sugira uma resposta:</div>
                                </div>
                            </label>
                            <input type="text" class="form-control" id="campo_texto" name="campo_texto" placeholder="Exemplo: 'Dados para orientação:' " required />
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="d-flex flex-column mb-3">
                            <div class="p-2">
                                <div class="fw-bold">Passo 2: </div> Selecione qual é o formato da resposta.
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="campo_vazio" id="campo_vazio">
                            <label class="form-check-label" for="campo_vazio">
                                Campo de texto vazio
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="opcoes" id="opcoes">
                            <label class="form-check-label" for="opcoes">
                                Opções para selecionar
                            </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php
            if (count($mensagem) > 0) {

            ?>
                var toastEl = document.querySelector('.toast');
                var toast = new bootstrap.Toast(toastEl);
                toast.show();
            <?php
            }

            ?>
        });
    </script>

</body>

</html>