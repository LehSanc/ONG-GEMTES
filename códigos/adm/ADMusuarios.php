<?php
include("../conexao.php");
include("../protect.php");
protect();

$mensagem = [];

if (isset($_POST['excluir_btn'])) {
    $CPF = $_POST['CPF'];

    $stmt = $mysqli->prepare("DELETE FROM `usuarios` WHERE `CPF` = '$CPF'"); // Preparar a consulta
    if ($stmt === false) {
        die("Erro na preparação: " . $mysqli->error);
    }

    $stmt->execute(); //executar consulta
    $result = $stmt->get_result(); //obter resultado
    if ($stmt->affected_rows > 0) {
        $_SESSION['sucesso'] = 1;
        header('Location: ./ADMtelaInicial.php');
    } else {
        $mensagem[] = "Erro ao excluir usuário.";
    }
    $stmt->close();
}

if (isset($_POST['ADM_btn'])) {
    if (isset($_POST['ID_usuario']) == 1) {
        $CPF = strtolower($_POST['CPF']);

        $stmt = $mysqli->prepare("UPDATE `usuarios` SET `ID_usuario`='2' WHERE `CPF` = '$CPF'"); // Preparar a consulta
        if ($stmt === false) {
            die("Erro na preparação: " . $mysqli->error);
        }

        $stmt->execute(); //executar consulta
        $result = $stmt->get_result(); //obter resultado
        if ($stmt->affected_rows > 0) {
            $_SESSION['sucesso'] = 1;
            header('Location: ./ADMtelaInicial.php');
        } else {
            $mensagem[] = "Erro ao efetuar operação.";
        }
        $stmt->close();
    }
}

$stmt = $mysqli->prepare("SELECT * FROM `usuarios` where `CPF` != $_SESSION[CPF]"); // Preparar a consulta
if ($stmt === false) {
    die("Erro na preparação: " . $mysqli->error);
}

$stmt->execute(); //executar consulta
$result = $stmt->get_result(); //obter resultado

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/assistidos.css" class="css">
    <link rel="stylesheet" href="../css/responsive.css" class="css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <!-- /Bootstrap -->

    <title>Usuários</title>

</head>

<body class="telaUsuario">

    <header>
        <nav class="navbar sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="../Imagens/logoGemtes.png" alt="Bootstrap" width="200" height="50">
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
                                <a class="nav-link" href="./ADMavaliacoes">Avaliações</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./ADMconsultas">Consultas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./ADMrelatorio">Relatório</a>
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
                            <img class="d-block mx-auto" src="../Imagens/adulto.png" alt="" height="155">
                        </div>
                        <div class="p-2">
                            <h1 class="display-5 fw-bold text-body-emphasis">Usuários</h1>
                        </div>
                        <div class="p-2">
                            <p class="lead mb-4">Cadastre um novo usuário, solicite recuperação de senhas e veja os dados cadastrados.</p>
                        </div>
                        <div class="p-2">
                            <button class="btn btn-primary d-inline-flex align-items-center m-2" type="button">
                                <a href="./cadastrarUsuario.php" class="text-white text-decoration-none">Cadastrar usuario</a>
                            </button>
                            <button class="btn btn-primary d-inline-flex align-items-center m-2" type="button">
                                <a href="./ADMsenhas.php" class="text-white text-decoration-none">Recuperar senha</a>
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
            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {
                    echo '

        <div class="col">

            <div class="text-center card h-100">
                <div class="card-header">
                    <div class="fs-5 fw-light">';

                    if ($row['ID_usuario'] == 1) echo 'Usuário comum';
                    else if ($row['ID_usuario'] == 2) echo 'Adiministrador';

                    echo '</div>
                    <div class="fs-5 fw-light">Nome: ' . $row['nome'] . '</div> 
                </div>
                <div class="card-body">
                    <div class="fs-5 fw-light">CPF: ' . $row['CPF'] . '</div>
                </div>
                <div class="card-footer text-body-secondary">
                    <form method="POST" action="">
                        <input type="submit" name="excluir_btn" value="Excluir" class="btn btn-primary">';

                    if ($row['ID_usuario'] == 1) echo '<input type="submit" name="ADM_btn" value="Tornar ADM" class="btn btn-primary m-2">';
                    echo '    
                        <input type="hidden" name="CPF" value="' . $row['CPF'] . '">
                        <input type="hidden" name="ID_usuario" value="' . $row['ID_usuario'] . '">
                    </form>
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