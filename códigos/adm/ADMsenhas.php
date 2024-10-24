<?php
include("../conexao.php");
include("../protect.php");
include("../codigo.php");
protect();

$mensagem = [];
$string = "abcdefghijklmnopqrstuvwxyz1234567890";
$codigo = palavra_aleatoria($string) . palavra_aleatoria($string) . palavra_aleatoria($string);
$mostrarcodigo = false;

function verificarCPF($cpf)
{
    global $mensagem, $mysqli;

    if (!is_numeric($cpf) || strlen($cpf) != 11) {
        $mensagem[] = "CPF inválido.";
        return false;
    } else {

        $stmt = $mysqli->prepare("SELECT * FROM usuarios WHERE `CPF` = '$cpf'"); // Preparar a consulta
        if ($stmt === false)
            die("Erro na preparação: " . $mysqli->error);

        $stmt->execute(); //executar consulta
        $result = $stmt->get_result(); //obter resultado

        if ($result->num_rows > 0) {
            return true;
        } else {
            $mensagem[] = "O CPF informado não está cadastrado no sistema.";
            return false;
        }
        $stmt->close();
    }
}

if (isset($_POST['CPF'])) {
    $CPF = $_POST['CPF'];

    if (verificarCPF($CPF)) {
        $stmt = $mysqli->prepare("UPDATE `usuarios` set `codigo`= '$codigo' where `CPF` = '$CPF')"); // Preparar a consulta
        if ($stmt === false) {
            die("Erro na preparação: " . $mysqli->error);
        }

        $stmt->execute(); //executar consulta

        if ($stmt->affected_rows > 0) {
            $mostrarcodigo = true;
        } else {
            $mensagem[] = "Erro ao efetuar operação.";
        }
        $stmt->close();
    }
}

$mysqli->close();
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

    <title>Recuperar senha</title>

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

            <div class="card text- img-adulto">
                <div class="card-body">
                    <div class="p-2 img-adulto">
                        <img class="d-block mx-auto" src="../Imagens/adulto.png" alt="" height="155">
                    </div>
                </div>
            </div>


            <div class="container">

                <h3 class="py-5">Recuperar senha</h3>

                <form class="needs-validation row g-3" method="POST" action="" novalidate>
                    <div class="col-md-6 mb-5">
                        <label for="CPF" class="form-label">CPF</label>
                        <input type="number" class="form-control" id="CPF" name="CPF" required />
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            Gerar código
                        </button>
                    </div>

                    <div class="col-12 pt-5">
                        <?php if ($mostrarcodigo): ?>
                            <div class="d-flex justify-content-center">
                                <div class="card w-75 mb-3">
                                    <div class="card-header d-flex justify-content-end">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard" viewBox="0 0 16 16" title="Copiar" onclick="copiarConteudo('codigo')" alt="Copiar">
                                            <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z" />
                                            <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z" />
                                        </svg>
                                    </div>
                                    <div class="card-header d-flex justify-content-center">
                                        Código para definir uma senha.
                                    </div>
                                    <div class="card-body text-center">
                                        <blockquote class="blockquote mb-0" id="codigo">
                                            <p><?php echo $codigo; ?></p>
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

        </div>
    </section>

    <script>
        function copiarConteudo(elementId) {
            // Obtém o elemento pelo ID
            var codigoElement = document.getElementById(elementId);

            // Obtém o conteúdo de texto dentro do elemento
            var codigoText = codigoElement.innerText || codigoElement.textContent;

            // Copia o conteúdo para a área de transferência
            navigator.clipboard.writeText(codigoText);
        }
    </script>

    <script>
        (() => {
            'use strict'

            const forms = document.querySelectorAll('.needs-validation')

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>

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