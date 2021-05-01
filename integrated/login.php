<?php require_once("../connection/conexao.php"); ?>
<?php
    //adicionar variáveis de sessão
    session_start();

    if (isset($_POST["user_cliente"]) && isset($_POST["key_password_cliente"])) {
        $usuario = $_POST["user_cliente"];
        $key = $_POST["key_password_cliente"];
        $login = "SELECT * FROM clientes WHERE usuario = '{$usuario}' AND senha = '{$key}' ";
        $acesso = mysqli_query($connect, $login);
        if (!$acesso) {
            die("Falha na consulta ao banco de dados (login details)");
        }
        $info = mysqli_fetch_assoc($acesso);

        if (empty($info)) {
            $mensagem = "Usuário ou senha incorretos!";
        } else {
            $_SESSION["cliente_portal"] = $info["clienteID"];
            header("location:listagem_produtos.php");
        }
    } 

    if (isset($_POST["user_fornecedor"]) && isset($_POST["key_password_fornecedor"])) {
        $usuario = $_POST["user_fornecedor"];
        $key = $_POST["key_password_fornecedor"];
        $login = "SELECT * FROM fornecedores WHERE usuario = '{$usuario}' AND senha = '{$key}' ";
        $acesso = mysqli_query($connect, $login);
        if (!$acesso) {
            die("Falha na consulta ao banco de dados (login details)");
        }
        $info = mysqli_fetch_assoc($acesso);

        if (empty($info)) {
            $mensagem = "Usuário ou senha incorretos!";
        } else {
            $_SESSION["fornecedor_portal"] = $info["fornecedorID"];
            header("location:listagem_transportadora.php");
        }
    } 
?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Curso PHP Integração com MySQL</title>

    <!-- estilo -->
    <link href="_css/estilo.css" rel="stylesheet">
    <link href="_css/login.css" rel="stylesheet">

</head>

<body>
    <?php include_once("_incluir/topo.php"); ?>
    <?php include_once("_incluir/funcoes.php"); ?>

    <main>
        <div id="janela_login">
            <form action="login.php" method="post">
                <h2>Tela de Login para Cliente</h2>
                <input type="text" name="user_cliente" placeholder="Nome de Usuário">
                <input type="password" name="key_password_cliente" placeholder="Senha">
                <input type="submit" name="submit_cliente" value="Login">

                <?php
                    if(isset($mensagem)){
                ?>
                <p><?php echo $mensagem; ?></p>    
                <?php
                    }
                ?>
            </form>
            <form action="login.php" method="post">
                <h2>Tela de Login para Transportadoras</h2>
                <input type="text" name="user_fornecedor" placeholder="Nome de Usuário">
                <input type="password" name="key_password_fornecedor" placeholder="Senha">
                <input type="submit" name="submit_fornecedor" value="Login">

                <?php
                    if(isset($mensagem)){
                ?>
                <p><?php echo $mensagem; ?></p>    
                <?php
                    }
                ?>
            </form>
        </div>
    </main>

    <?php include_once("_incluir/rodape.php"); ?>
</body>

</html>

<?php
// Fechar conexao
mysqli_close($connect);
?>