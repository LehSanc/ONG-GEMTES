<?php
include("../conexao.php");
include("../protect.php");
protect();

$mensagem = [];

$ID_assistido = $_SESSION['ID_assistido'];

function verificarCPF($cpf)
{
    global $mensagem;

    if (!is_numeric($cpf) || strlen($cpf) != 11) {
        $mensagem[] = "CPF inválido.";
        return false;
    } else {
        return true;
    }
}

function verificarIdade($idade_cognitiva)
{
    global $mensagem;

    if (strlen($idade_cognitiva) > 2 || strlen($idade_cognitiva) < 1) {
        $mensagem[] = "Idade cognitiva inválida.";
        return false;
    } else {
        return true;
    }
}

if (isset($_POST['editar_btn'])) {

    if (isset($_POST['nome_assistido']) && isset($_POST['idade_cognitiva']) && isset($_POST['data_nascimento']) && isset($_POST['encaminhamento']) && isset($_POST['nome_responsavel']) && isset($_POST['CPF_responsavel']) && isset($_POST['telefone']) && isset($_POST['parentesco'])) {

        $nome_assistido = strtolower(trim($_POST['nome_assistido']));
        $idade_cognitiva = strtolower(trim($_POST['idade_cognitiva']));
        $data_nascimento = strtolower(trim($_POST['data_nascimento']));
        $encaminhamento = strtolower(trim($_POST['encaminhamento']));
        $nome_responsavel = strtolower(trim($_POST['nome_responsavel']));
        $CPF_responsavel = strtolower(trim($_POST['CPF_responsavel']));
        $telefone = strtolower(trim($_POST['telefone']));
        $parentesco = strtolower(trim($_POST['parentesco']));

        if (verificarCPF($CPF_responsavel) && verificarIdade($idade_cognitiva)) {
            $stmt = $mysqli->prepare("UPDATE `assistidos` SET `nome_assistido`='$nome_assistido',`idade_cognitiva`='$idade_cognitiva',`data_nascimento`='$data_nascimento',`encaminhamento`='$encaminhamento',`nome_responsavel`='$nome_responsavel',`CPF_responsavel`='$CPF_responsavel',`telefone`='$telefone',`parentesco`='$parentesco' WHERE `ID_assistido`='$ID_assistido'");
            if ($stmt === false) {
                die("Erro na preparação: " . $mysqli->error);
            }

            $stmt->execute(); // Executar atualização
            if ($stmt->affected_rows > 0) {
                $_SESSION['sucesso'] = 1;
                header('Location: ./assistidos.php');
                exit();
            } else {
                $mensagem[] = "Erro ao alterar dados do assistido.";
            }
            $stmt->close();
        }
    }
}

// Obter os dados do serviço para pré preencher o formulário
$stmt = $mysqli->prepare("SELECT * FROM `assistidos` WHERE `ID_assistido` = '$ID_assistido'");

if ($stmt === false) {
    die("Erro na preparação: " . $mysqli->error);
}

$stmt->execute(); //executar consulta
$result = $stmt->get_result(); //obter resultado

if ($result->num_rows > 0) {
    $assistido = $result->fetch_assoc();
} else {
    $mensagem[] = "Desculpe, não foi possível recuperar os dados.";
}
$stmt->close();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dadosAssistidos.css" class="css">
    <link rel="stylesheet" href="../css/responsive.css" class="css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <!-- /Bootstrap -->

    <title>Assistidos</title>

</head>

<body>

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

            <div class="container">

                <h3 class="py-2">Cadastrar assistido</h3>

                <form class="needs-validation row g-3" method="POST" action="" novalidate>
                    <div class="col-md-6">
                        <label for="nome_assistido" class="form-label">Nome completo</label>
                        <input type="text" class="form-control" id="nome_assistido" name="nome_assistido" value="<?php echo $assistido['nome_assistido']; ?>" required />
                    </div>
                    <div class="col-md-6">
                        <label for="idade_cognitiva" class="form-label">Idade cognitiva</label>
                        <input type="number" class="form-control" id="idade_cognitiva" name="idade_cognitiva" value="<?php echo $assistido['idade_cognitiva']; ?>" required />
                    </div>
                    <div class="col-md-6">
                        <label for="data_nascimento" class="form-label">Data de nascimento</label>
                        <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="<?php echo date($assistido['data_nascimento']); ?>" min="1990-01-01" required />
                    </div>
                    <div class="col-md-6">
                        <label for="encaminhamento" class="form-label">Encaminhamento</label>
                        <input type="text" class="form-control" id="encaminhamento" name="encaminhamento" value="<?php echo $assistido['encaminhamento']; ?>" required />
                    </div>

                    <h3 class="py-2 my-3">Responsável pelo assistido</h3>

                    <div class="col-md-6">
                        <label for="nome_responsavel" class="form-label">Nome completo</label>
                        <input type="text" class="form-control" id="nome_responsavel" name="nome_responsavel" value="<?php echo $assistido['nome_responsavel']; ?>" required />
                    </div>
                    <div class="col-md-6">
                        <label for="CPF_responsavel" class="form-label">CPF</label>
                        <input type="number" class="form-control" id="CPF_responsavel" name="CPF_responsavel" value="<?php echo $assistido['CPF_responsavel']; ?>" required />
                    </div>
                    <div class="col-md-6">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echo $assistido['telefone']; ?>" required />
                    </div>
                    <div class="col-md-6">
                        <label for="parentesco" class="form-label">Grau de Parentesco</label>
                        <input type="text" class="form-control" id="parentesco" name="parentesco" value="<?php echo $assistido['parentesco']; ?>" required />
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-primary" name="editar_btn">
                            Editar
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </section>

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