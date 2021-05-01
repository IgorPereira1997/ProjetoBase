<?php require_once("../connection/conexao.php"); ?>
<?php
    session_start();

    if (!isset($_SESSION["fornecedor_portal"])) {
        header("location:login.php");
    }

    // Determinar localidade BR
    setlocale(LC_ALL, 'pt_BR');

    // tabela de transportadoras
    $tr = "SELECT * FROM transportadoras ";
    $consulta_tr = mysqli_query($connect, $tr);
    if(!$consulta_tr) {
        die("erro no banco");
    }
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Curso PHP Integração com MySQL</title>
        
        <!-- estilo -->
        <link href="_css/estilo.css"            rel="stylesheet">
        <link href="_css/novo-alteracao.css"    rel="stylesheet">
    </head>

    <body>
        <?php include_once("_incluir/topo.php"); ?>
        <?php include_once("_incluir/funcoes.php"); ?>  
        
        <main>
            <div id="inserir_transportadora"> 
            <a href="inserir_transportadora.php">Inserir Transportadora</a>
            </div> 
            <div id="janela_transportadoras">
                <?php
                    while($linha = mysqli_fetch_assoc($consulta_tr)) {
                ?>
                <ul>
                    <li><?php echo $linha["nometransportadora"] ?></li>
                    <li><?php echo $linha["cidade"] ?></li>
                    <li><a href="alteracao_transportadora.php?codigo=<?php echo $linha["transportadoraID"] ?>">Alterar</a> </li>
                    <li><a href="exclusao_transportadora.php?codigo=<?php echo $linha["transportadoraID"] ?>">Excluir</a> </li>
                </ul>
                <?php
                    }
                ?>
            </div>
        </main>

        <?php include_once("_incluir/rodape.php"); ?>  
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($connect);
?>