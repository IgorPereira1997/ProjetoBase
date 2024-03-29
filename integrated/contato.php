<?php require_once("../connection/conexao.php"); ?>
<?php include_once("_incluir/funcoes.php"); ?>

<?php
if (isset($_POST["enviar"])) {
    if (enviarMensagem($_POST)) {
        $mensagem = "Mensagem enviada com sucesso!";
    } else {
        $mensagem = "Erro no envio da mensagem!";
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
    <link href="_css/contato.css" rel="stylesheet">
</head>

<body>
    <?php include_once("_incluir/topo.php"); ?>


    <main>
        <div id="janela_formulario">
            <form action="contato.php" method="post">
                <input type="text" name="nome" placeholder="Digite seu nome">
                <input type="email" name="email" placeholder="Digite seu email">
                <label>Mensagem</label>
                <textarea name="mensagem"></textarea>
                <input type="submit" name="enviar" value="Enviar Mensagem">

                <?php
                if (isset($mensagem)) {
                    echo "<p>" . $mensagem . "</p>";
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