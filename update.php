<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Editar cadastro</title>
</head>

<body>

    <h1>Editar Formulário de Cadastro</h1>
    <form method="POST">

        <label for="cc"></label>
        <input type="text" id="cc" name="cc" placeholder="Código de cadastro" required>

        <label for="nome"></label>
        <input type="text" id="editarnome" name="editarnome" placeholder="Nome" required>

        <label for="email"></label>
        <input type="email" id="editaremail" name="editaremail" placeholder="E-mail" required>

        <label for="cpf"></label>
        <input type="text" id="editarcpf" name="editarcpf" placeholder="CPF" required>

        <button type="submit">Editar</button>
    </form>
    <div class="botoes">
        <button id="voltar" onclick="window.location.href='./index.php'">Voltar</button>
    </div>
    <?php
    require_once 'conexao.php';

    $bancodados = new Conexao();
    $conexao = $bancodados->conectar();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $codigo_cadastro = $_POST['cc'];
            $novo_nome = $_POST['editarnome'];
            $novo_email = $_POST['editaremail'];
            $novo_cpf = $_POST['editarcpf'];

            $verificacao = "SELECT * FROM cadastros WHERE id_cadastro = :id_cadastro";
            $stmt_verificar = $conexao->prepare($verificacao);
            $stmt_verificar->bindValue(':id_cadastro', $codigo_cadastro);
            $stmt_verificar->execute();

            if ($stmt_verificar->rowCount() > 0) {

                $atualizacao = "UPDATE cadastros SET nome = :nome, email = :email, cpf = :cpf WHERE id_cadastro = :id_cadastro";
                $stmt = $conexao->prepare($atualizacao);
                $stmt->bindValue(':id_cadastro', $codigo_cadastro);
                $stmt->bindValue(':nome', $novo_nome);
                $stmt->bindValue(':email', $novo_email);
                $stmt->bindValue(':cpf', $novo_cpf);
                $stmt->execute();
                echo "<p>Cadastro editado com sucesso!</p>";
            } else {
                echo "<p>Cadastro não existente.</p>";
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }
    ?>

</body>

</html>