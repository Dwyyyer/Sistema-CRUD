<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir cadastro</title>
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <h1>Excluir Cadastro</h1>
    <form method="POST">

        <label></label>
        <input type="text" id="cc" name="cc" placeholder="Código de cadastro" required>
        <button type="submit">Excluir</button>
    </form>
    <button id="voltar" onclick="window.location.href='./index.php'">Voltar</button>

    <?php
    require_once 'conexao.php';

    $bancodados = new Conexao();
    $conexao = $bancodados->conectar();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $codigo_cadastro = $_POST['cc'];
            $verificacao = "SELECT * FROM cadastros WHERE id_cadastro = :id_cadastro";
            $stmt_verificar = $conexao->prepare($verificacao);
            $stmt_verificar->bindValue(':id_cadastro', $codigo_cadastro);
            $stmt_verificar->execute();

            if ($stmt_verificar->rowCount() > 0) {
                $exclusao = "DELETE FROM cadastros WHERE id_cadastro = :id_cadastro";
                $stmt = $conexao->prepare($exclusao);
                $stmt->bindValue(':id_cadastro', $codigo_cadastro);
                $stmt->execute();
                echo "<p>Cadastro excluido com sucesso!</p>";
            } else {
                echo "<p>Cadastro não encontrado.</p>";
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }
    ?>
</body>

</html>