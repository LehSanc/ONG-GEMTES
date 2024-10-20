<?php
include("conexao.php");

// Caso exista uma sessão ela é destruída para que o login seja feito corretamente
if (isset($_SESSION)) session_destroy();
session_start();
$mensagem = [];

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

function verificarSenha($cpf, $senha)
{
  global $mensagem, $mysqli;

  // o ID define o tipo de usuário: id = 1 user comum, id = 2 adiministrador, id = NULL usuário novo que precisa definir senha
  $stmt = $mysqli->prepare("SELECT `senha`, `ID_usuario` FROM usuarios WHERE `CPF` = '$cpf'"); // Preparar a consulta

  if ($stmt === false)
    die("Erro na preparação: " . $mysqli->error);

  $stmt->execute(); //executar consulta
  $result = $stmt->get_result(); //obter resultado

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); //obter os dados do usuario

    if ($row['ID_usuario'] == NULL) {
      $mensagem[] = "Novo por aqui? Vá para a sessão 'esqueci senha' e defina uma senha!";
      return false;
    } else {
      if (password_verify($senha, $row['senha'])) {
        $_SESSION['CPF'] = $cpf; //toda a vez que vamos verificar se o usuário está logado, utilizar o CPF

        $caminho = "./user/telaInicial.php";

        if ($row['ID_usuario'] == 2)
          $caminho = "./adm/ADMtelaInicial.php";

        echo "<script>location.href = '$caminho';</script>";
      } else {
        $mensagem[] = "Senha incorreta";
      }
    }
  }
  $stmt->close();
}

function verificarCodigo($cpf, $codigo)
{
  global $mensagem, $mysqli;

  $stmt = $mysqli->prepare("SELECT `codigo` FROM usuarios WHERE `CPF` = '$cpf'");
  if ($stmt === false)
    die("Erro na preparação: " . $mysqli->error);

  $stmt->execute(); //executar consulta
  $result = $stmt->get_result(); //obter resultado

  if ($result->num_rows > 0) {

    $row = $result->fetch_assoc(); //obter os dados do usuario
    if ($row['codigo'] == $codigo) {
      return true;
    } else {
      $mensagem[] = "O código informado não é válido, certifique-se de que não ocorreu nenhum erro de digitação.";
      return false;
    }
  }
  $stmt->close();
}

function alterarSenha($cpf, $senha)
{
  global $mensagem, $mysqli;

  $nova_senha_hash = password_hash($senha, PASSWORD_DEFAULT);
  $stmt = $mysqli->prepare("UPDATE usuarios SET `ID_usuario` = 1, `senha` = '$nova_senha_hash', `codigo` = ' ' WHERE `CPF` = '$cpf'");
  if ($stmt === false) {
    die("Erro na preparação da atualização: " . $mysqli->error);
  }

  $stmt->execute(); // Executar a atualização
  if ($stmt->affected_rows > 0) {
    $mensagem[] = "Senha alterada com sucesso!";
  }
  $stmt->close();
}

if (isset($_POST['entrar'])) {
  if (isset($_POST['CPFentrar']) && isset($_POST['senha'])) {
    $cpf = $_POST['CPFentrar'];
    $senha = trim($_POST['senha']);

    if (verificarCPF($cpf)) {
      verificarSenha($cpf, $senha);
    }
  }
}

if (isset($_POST['alterar'])) {
  if (isset($_POST['CPFsenha']) && isset($_POST['codigo']) && isset($_POST['senha1']) && isset($_POST['senha2'])) {

    $cpf = $_POST['CPFsenha'];
    $codigo = trim($_POST['codigo']);
    $senha1 = trim($_POST['senha1']);
    $senha2 = trim($_POST['senha2']);

    if (verificarCPF($cpf)) {
      if (verificarCodigo($cpf, $codigo)) {
        if ($senha1 == $senha2) {
          alterarSenha($cpf, $senha1);
        } else {
          $mensagem[] = "Por favor confirme a mesma senha.";
        }
      }
    }
  }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/index.css" class="css">
  <link rel="stylesheet" href="./css/responsive.css" class="css">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <!-- /Bootstrap -->

  <title>Tela inicial</title>

</head>

<body>

  <header>
    <nav class="navbar fixed-top">
      <div class="container m-0 p-0">
        <a class="navbar-brand" href="#">
          <img src="./Imagens/logoGemtes.png" alt="Bootstrap" width="200" height="50">
        </a>
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
        <div class="card-header">

          <ul class="nav nav-pills card-header-pills">
            <li class="nav-item">
              <button type="button" class="btn btn-light btn-lg" id="hideFormularioSenha" onclick="hideFormularioSenha()">Entrar</button>
            </li>
            <li class="nav-item">
              <button type="button" class="btn btn-light btn-lg" id="mostrarFormularioSenha" onclick="mostrarFormularioSenha()">Esqueci senha</button>
            </li>
          </ul>
        </div>

        <div class="formularioEntrar" id="formularioEntrar">

          <div class="card-body text-center">
            <div class="d-flex flex-row mb-3 align-items-center">
              <div class="p-2 container-sm">
                <img src="./Imagens/bloquinhos.png" class="img-thumbnail" alt="...">
              </div>

              <div class="p-2">
                <h5 class="card-title p-2">Entrar</h5>
                <div class="card-text">

                  <form method="POST" action="" class="row g-3 needs-validation" novalidate>

                    <div class="col-12">
                      <label for="CPFentrar" class="form-label">CPF</label>
                      <input type="number" class="form-control" name="CPFentrar" id="CPFentrar" required>
                    </div>

                    <div class="col-12">
                      <label for="senha" class="form-label">Senha</label>
                      <input type="password" class="form-control" name="senha" id="senha" required>
                    </div>

                    <div class="col-12">
                      <button type="submit" class="btn btn-primary" name="entrar" value="entrar">Entrar</button>
                    </div>

                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="formularioSenha" id="formularioSenha">

          <div class="card-body text-center">
            <div class="d-flex flex-row mb-3 align-items-center">

              <div class="p-2">
                <h5 class="card-title p-2">Alterar senha</h5>
                <div class="card-text">

                  <form method="POST" action="" class="row g-3 needs-validation" novalidate>

                    <div class="col-12">
                      <label for="CPFsenha" class="form-label">CPF</label>
                      <input type="number" class="form-control" name="CPFsenha" id="CPFsenha" required>
                    </div>

                    <div class="col-12">
                      <label for="codigo" class="form-label">Código de alteração</label>
                      <input type="text" class="form-control" name="codigo" id="codigo" required>
                    </div>

                    <div class="col-12">
                      <label for="senha1" class="form-label">Nova senha</label>
                      <input type="password" class="form-control" name="senha1" id="senha1" required>
                    </div>

                    <div class="col-12">
                      <label for="senha2" class="form-label">Confirme a mesma senha</label>
                      <input type="password" class="form-control" name="senha2" id="senha2" required>
                    </div>

                    <div class="col-12">
                      <button type="submit" class="btn btn-primary" name="alterar" value="entrar">Alterar</button>
                    </div>

                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>

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

  <script>
    function mostrarFormularioSenha() { // Função para abrir o form de recuperação de senha
      document.getElementById('formularioSenha').style.display = 'block';
      document.getElementById('formularioEntrar').style.display = 'none';
    }
  </script>

  <script>
    function hideFormularioSenha() { // Função para fechar o form de recuperação de senha
      document.getElementById('formularioSenha').style.display = 'none';
      document.getElementById('formularioEntrar').style.display = 'block';
    }
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