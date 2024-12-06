<?php
include("../conexao.php");
include("../protect.php");
protect();

$mensagem = [];

$stmt = $mysqli->prepare("SELECT * FROM `avaliacoes`"); // Preparar a consulta
if ($stmt === false) {
    die("Erro na preparação: " . $mysqli->error);
}

$stmt->execute(); //executar consulta
$result = $stmt->get_result(); //obter resultado

if (isset($_POST['editar_btn'])) {
    $_SESSION['ID_avaliacao'] = $_POST['ID_avaliacao'];
    header('Location: ADMeditarAvaliacao.php');
    exit();
}

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

            <div class="card text-center">
                <div class="card-body">

                    <div class="d-flex flex-column mb-3">
                        <div class="p-2">
                            <h1 class="display-5 fw-bold text-body-emphasis">Avaliações</h1>
                        </div>
                        <div class="p-2">
                            <p class="lead mb-4">Cadastre novas avaliações ou acesse as existentes.</p>
                        </div>
                        <div class="p-2">
                            <button class="btn btn-primary d-inline-flex align-items-center " type="button">
                                <a href="./ADMcadastrarAvaliacao.php" class="text-white text-decoration-none">Cadastrar avaliação</a>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <section class="result-cards">

        <div class="row row-cols-1 row-cols-md-3 g-4">

            <?php

            $editar =   '<form method="POST" action="">
                            <input type="submit" name="editar_btn" value="Editar" class="btn btn-primary">
                            <input type="hidden" name="ID_avaliacao" value="' . $row['ID_avaliacao'] . '">
                        </form>';

            $naoEditar = '<div class="fs-5 fw-light">Apenas autores podem fazer alterações</div>';

            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {
                    echo '

        <div class="col">

            <div class="text-center card avaliacao h-100">
                <div class="card-header">
                    <div class="fs-5 fw-light"> ' . $row['nome_avaliacao'] . '</div>
                </div>
                <div class="card-body">
                    <h5 class="card-title fw-bold">Autor: ' . $row['nome_autor'] . '</h5>
                    <div class="fs-5 fw-light">Data: ' . date($row['encaminhamento']) . '</div>
                </div>
                <div class="card-footer text-body-secondary">
                ' . $_SESSION['CPF'] == $row['CPF_autor'] ? $editar : $naoEditar . '
                    
                </div>
            </div>

        </div>';
                }
                $stmt->close(); //fechar declaração
            }
            ?>

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