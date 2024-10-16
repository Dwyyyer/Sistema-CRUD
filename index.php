<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Sistema CRUD</title>
</head>

<body>
    <h1>
        Cadastros
    </h1>
    <div class="modal" id="formulariomodal">
        <div class="conteudo-modal">
            <button class="close-button" onclick="fecharformulario('formulariomodal')" id="fechar">X</button>
            <h2 id="titulo-cadastro">Formulário de Cadastro</h2>
            <form method="POST">
                <label for="nome"></label>
                <input type="text" id="nome" name="nome" placeholder="Nome" required>

                <label for="email"></label>
                <input type="email" id="email" name="email" placeholder="E-mail" required>

                <label for="cpf"></label>
                <input type="text" id="cpf" name="cpf" placeholder="CPF" required>

                <button type="submit">Cadastrar</button>
                <?php

                require_once 'conexao.php';

                $bancodados = new Conexao();
                $conexao = $bancodados->conectar();

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $nome = $_POST['nome'];
                    $email = $_POST['email'];
                    $cpf = $_POST['cpf'];

                    $insercao = "INSERT INTO cadastros (nome, email, cpf) VALUES (:nome, :email, :cpf)";
                    $stmt = $conexao->prepare($insercao);
                    $stmt->bindValue(':nome', $nome);
                    $stmt->bindValue(':email', $email);
                    $stmt->bindValue(':cpf', $cpf);
                    $stmt->execute();
                    echo "<p>Usuário $nome cadastrado com sucesso!</p>";
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit();
                }
                ?>
            </form>
        </div>
    </div>
    <table class="tabela">
        <thead>
            <th>Nome</th>
            <th>E-mail</th>
            <th>CPF</th>
            <th>Código de cadastro</th>
        </thead>
        <div id="botoes">
        <button class="botao" onclick="abrirformulario('formulariomodal')" id="botaocadastro">Cadastrar usuário</button>
        <button class="botao" onclick="window.location.href='./update.php'">Editar cadastro</button>
        <button class="botao" onclick="window.location.href='./delete.php'">Excluir cadastro</button>
        </div>
        <form method="GET">
            <div id="pesquisas">
            <input type="text" name="pesquisa" placeholder="Buscar por nome ou CPF" id="barra-pesquisa">
            <button type="submit" id="botao-pesquisar">Pesquisar</button>
            </div>
        </form>
        <tbody id="tabela-corpo">
            <?php

            require_once 'conexao.php';

            $bancodados = new Conexao();
            $conexao = $bancodados->conectar();
            $pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if (!empty($pesquisa)) {
                $consulta = "SELECT * FROM cadastros WHERE nome LIKE :pesquisa OR cpf LIKE :pesquisa";
                $stmt = $conexao->prepare($consulta);
                $stmt->bindValue(':pesquisa', '%' . $pesquisa . '%');
                $stmt->execute();
                while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>", $linha['nome'], "</td>";
                    echo "<td>", $linha['email'], "</td>";
                    echo "<td>", $linha['cpf'], "</td>";
                    echo "<td>", $linha['id_cadastro'], "</td>";
                    echo "</tr>";
                }
            } else {
                $consulta = "SELECT * FROM cadastros";
                $stmt = $conexao->prepare($consulta);
                $stmt->execute();
                while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>", $linha['nome'], "</td>";
                    echo "<td>", $linha['email'], "</td>";
                    echo "<td>", $linha['cpf'], "</td>";
                    echo "<td>", $linha['id_cadastro'], "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
    <script src="./formulario.js"></script>
</body>

</html>