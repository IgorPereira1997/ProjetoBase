<?php require_once("../connection/conexao.php"); ?>
<?php include_once("_incluir/funcoes.php"); ?>

<?php
    session_start();

    if (!isset($_SESSION["cliente_portal"])) {
        header("location:login.php");
    }
    
    // Determinar localidade BR
    setlocale(LC_ALL, 'pt_BR');

    // Consulta ao banco de dados
    $produtos = "SELECT produtoID, nomeproduto, tempoentrega, precounitario, imagempequena ";
    $produtos .= "FROM produtos ";
    if (isset($_GET["produto"])) {
        $nome_produto   = urlencode($_GET["produto"]);
        $produtos       .= "WHERE nomeproduto LIKE '%{$nome_produto}%' ";
    }
    $resultado = mysqli_query($connect, $produtos);
    if (!$resultado) {
        die("Falha na consulta ao banco");
    }
?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curso PHP Integração com MySQL</title>

    <!-- estilo -->
    <link href="_css/estilo.css" rel="stylesheet">
    <link href="_css/produtos.css" rel="stylesheet">
    <link href="_css/produto_pesquisa.css" rel="stylesheet">
</head>

<body>
    <?php include_once("_incluir/topo.php"); ?>

    <main>
        <div id="janela_pesquisa">
            <form action="listagem_produtos.php" method="get">
                <input type="text" name="produto" placeholder="Pesquisa">
                <input type="image" name="pesquisa" src="_assets/botao_search.png">
            </form>
        </div>

        <div id="listagem_produtos">
            <?php while ($linha = mysqli_fetch_assoc($resultado)) { ?>
                <ul>
                    <li class="imagem">
                        <a href="detalhe_produtos.php?codigo_prod=<?php echo $linha['produtoID'] ?>">
                            <img src="<?php echo $linha["imagempequena"] ?>">
                        </a>
                    </li>
                    <li>
                        <h3><?php echo $linha["nomeproduto"] ?></h3>
                    </li>
                    <li>Tempo de Entrega : <?php echo $linha["tempoentrega"] ?></li>
                    <li>Preço unitário : <?php echo real_format($linha["precounitario"]) ?></li>
                </ul>
            <?php } ?>
        </div>

    </main>

    <?php include_once("_incluir/rodape.php"); ?>
</body>

</html>

<?php
// Fechar conexao
mysqli_close($connect);
?>