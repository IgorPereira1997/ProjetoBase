<?php require_once("../connection/conexao.php"); ?>
<?php include_once("_incluir/funcoes.php"); ?>

<?php

    //security test
    session_start();
    if (!isset($_SESSION["cliente_portal"])) {
        header("location:login.php");
    }
    if (isset($_GET["codigo_prod"])) {
        $produto_id = $_GET["codigo_prod"];
    } else {
        Header("Location: login.php");
    }

    // Consulta ao banco de dados
    $consulta = "SELECT * FROM produtos ";
    $consulta .= "WHERE produtoID = {$produto_id} ";
    $detalhe    = mysqli_query($connect, $consulta);

    // Testar erro
    if (!$detalhe) {
        die("Falha no Banco de dados");
    } else {
        $dados_detalhe = mysqli_fetch_assoc($detalhe);
        $produtoID      = $dados_detalhe["produtoID"];
        $nomeproduto    = $dados_detalhe["nomeproduto"];
        $descricao      = $dados_detalhe["descricao"];
        $codigobarra    = $dados_detalhe["codigobarra"];
        $tempoentrega   = $dados_detalhe["tempoentrega"];
        $precorevenda   = $dados_detalhe["precorevenda"];
        $precounitario  = $dados_detalhe["precounitario"];
        $estoque        = $dados_detalhe["estoque"];
        $imagemgrande   = $dados_detalhe["imagemgrande"];
    }
?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Curso PHP Integração com MySQL</title>

    <!-- estilo -->
    <link href="_css/estilo.css" rel="stylesheet">
    <link href="_css/produto_detalhe.css" rel="stylesheet">
</head>

<body>
    <?php include_once("_incluir/topo.php"); ?>

    <main>
        <div id="detalhe_produto">
            <ul>
                <li class="imagem"><img src="<?php echo $imagemgrande ?>"></li>
                <li>
                    <h2><?php echo $nomeproduto ?></h2>
                </li>
                <li><b>Descri&ccedil;&atilde;o: </b><?php echo $descricao ?></li>
                <li><b>C&oacute;digo de Barra: </b><?php echo $codigobarra ?></li>
                <li><b>Tempo de Entrega: </b><?php echo $tempoentrega ?></li>
                <li><b>Pre&ccedil;o Revenda: </b><?php echo real_format($precorevenda); ?></li>
                <li><b>Pre&ccedil;o Unit&aacute;rio: </b><?php echo real_format($precounitario); ?></li>
                <li><b>Quantidade em Estoque: </b><?php echo $estoque ?> unidades.</li>
            </ul>

        </div>
    </main>

    <?php include_once("_incluir/rodape.php"); ?>
</body>

</html>

<?php
// Fechar conexao
mysqli_close($connect);
?>