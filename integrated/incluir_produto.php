<?php require_once("../connection/conexao.php"); ?>
<?php include_once("_incluir/funcoes.php"); ?>

<?php

    session_start();

    if (!isset($_SESSION["cliente_portal"])) {
        header("location:login.php");
    }    

    // conferir se a navegacao veio pelo preenchimento do formulario
    if (isset($_POST['nomeproduto'])) {
        $resultado1 = publishArchive($_FILES['foto_grande']);
        $resultado2 = publishArchive($_FILES['foto_pequena']);

        $mensagem1 = $resultado1[0];
        $mensagem2 = $resultado2[0];

        $nomeproduto    = $_POST['nomeproduto'];
        $codigobarra    = $_POST['codigobarra'];
        $tempoentrega   = $_POST['tempoentrega'];
        $categoriaID    = $_POST['categoriaID'];
        $fornecedorID   = $_POST['fornecedorID'];
        $precounitario  = $_POST['precounitario'];
        $precorevenda   = $_POST['precorevenda'];
        $estoque        = $_POST['estoque'];
        $desc           = $_POST['descricao'];

        $imagem_grande  = $resultado1[1];
        $imagem_pequena = $resultado2[1];

        // Insercao no banco
        $inserir = "INSERT INTO produtos ";
        $inserir .= "(nomeproduto,codigobarra,tempoentrega,categoriaID,fornecedorID,precounitario,precorevenda,estoque,imagemgrande,imagempequena, descricao) ";
        $inserir .= "VALUES ";
        $inserir .= "('$nomeproduto','$codigobarra',$tempoentrega,$categoriaID,$fornecedorID,$precounitario,$precorevenda,$estoque,'$imagem_grande','$imagem_pequena', '$desc')";
        $qInserir = mysqli_query($connect, $inserir);
        if (!$qInserir) {
            die("Erro na insercao");
        } else {
            $mensagem = "Inserção ocorreu com sucesso.";
        }
    }else{
        header("location:listagem_produtos.php");
    }

// Consulta a tabela de categorias
$categorias = "SELECT categoriaID, nomecategoria ";
$categorias .= "FROM categorias ";
$qCategorias = mysqli_query($connect, $categorias);
if (!$qCategorias) {
    die("Falha na consulta ao banco");
}

// Consulta a tabela de fornecedores
$fornecedores = "SELECT fornecedorID, nomefornecedor ";
$fornecedores .= "FROM fornecedores ";
$qFornecedores = mysqli_query($connect, $fornecedores);
if (!$qFornecedores) {
    die("Falha na consulta ao banco");
}
?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Curso PHP Integração com MySQL</title>

    <!-- estilo -->
    <link href="_css/estilo.css" rel="stylesheet">
    <link href="_css/inclusao.css" rel="stylesheet">
</head>

<body>
    <?php include_once("_incluir/topo.php"); ?>


    <main>
        <div id="janela_formulario">
            <form action="incluir_produto.php" method="post" enctype="multipart/form-data">
                <h2>Incluir Novo Produto</h2>

                <!-- campo de nome do produto e codigo de barra -->
                <input type="text" name="nomeproduto" placeholder="Nome do Produto">
                <input type="text" name="codigobarra" placeholder="Codigo de Barra">

                <!-- campo de descrição do produto -->
                <input type="text" name="descricao" placeholder="Descrição do Produto">

                <!-- campo de tempo de entrega -->
                <label>Tempo de Entrega</label>
                <input type="radio" name="tempoentrega" value="5">5 dias
                <input type="radio" name="tempoentrega" value="8">8 dias
                <input type="radio" name="tempoentrega" value="15">15 dias
                <input type="radio" name="tempoentrega" value="30">30 dias

                <!-- campo de categorias -->
                <label>Selecione a categoria do produto</label>
                <select name="categoriaID">
                    <?php
                    while ($linha = mysqli_fetch_assoc($qCategorias)) {
                    ?>
                        <option value="<?php echo $linha["categoriaID"];  ?>">
                            <?php echo $linha["nomecategoria"];  ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>

                <!-- campo de fornecedor -->
                <label>Selecione o fornecedor do produto</label>
                <select name="fornecedorID">
                    <?php
                    while ($linha = mysqli_fetch_assoc($qFornecedores)) {
                    ?>
                        <option value="<?php echo $linha["fornecedorID"];  ?>">
                            <?php echo utf8_encode($linha["nomefornecedor"]);  ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>

                <!-- campo de precos -->
                <input type="text" name="precorevenda" placeholder="Preço Revenda">
                <input type="text" name="precounitario" placeholder="Preço Unitário">


                <!-- campo de estoque -->
                <input type="number" name="estoque" placeholder="Estoque adquirido" min="1">
                <p style="background-color: white;"></p>


                <!-- setar valor max de arquivo -->
                <input type="hidden" name="MAX_FILE_SIZE" value="614400">

                <!-- campo de foto grande -->
                <label>Foto Grande</label>
                <input type="file" name="foto_grande">
                <span class="resposta">
                    <?php
                    if (isset($mensagem1)) {
                        echo $mensagem1;
                    }
                    ?>
                </span>

                <!-- campo de foto pequena -->
                <label>Foto Pequena</label>
                <input type="file" name="foto_pequena">
                <span class="resposta">
                    <?php
                    if (isset($mensagem2)) {
                        echo $mensagem2;
                    }
                    ?>
                </span>

                <!-- botao submit -->
                <input type="submit" value="Inserir novo produto">

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
// Fechar as queries
mysqli_free_result($qCategorias);
mysqli_free_result($qFornecedores);
?>

<?php
// Fechar conexao
mysqli_close($connect);
?>