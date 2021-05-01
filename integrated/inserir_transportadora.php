<?php require_once("../connection/conexao.php"); ?>
<?php

    session_start();

    if (!isset($_SESSION["fornecedor_portal"])) {
        header("location:login.php");
    }

    // Determinar localidade BR
    setlocale(LC_ALL, 'pt_BR');

    //inserção no banco
    if (
        isset($_POST["nometransportadora"]) &&
        isset($_POST["endereco"]) &&
        isset($_POST["telefone"]) &&
        isset($_POST["cidade"]) &&
        isset($_POST["estados"]) &&
        isset($_POST["cep"]) &&
        isset($_POST["cnpj"])
    ) {
        $nome_transp = $_POST["nometransportadora"];
        $endereco = $_POST["endereco"];
        $tel = $_POST["telefone"];
        $city = $_POST["cidade"];
        $state = $_POST["estados"];
        $cep = $_POST["cep"];
        $cnpj = $_POST["cnpj"];

        $insert = "INSERT INTO transportadoras ";
        $insert .= "(nometransportadora, endereco, telefone, cidade, estadoID, cep, cnpj) ";
        $insert .= "VALUES ";
        $insert .= "('$nome_transp', '$endereco', '$tel', '$city', $state, '$cep', '$cnpj')";
        
        $op_inserir = mysqli_query($connect, $insert);

        if(!$op_inserir){
            die("Conexão com o banco de dados falhou!");
        }else{
            header("location:listagem_transportadora.php");
        }
    }

    //seleção estados
    $select = "SELECT estadoID, nome FROM estados";
    $lista_estados = mysqli_query($connect, $select);
    if (!$lista_estados) {
        die("Falha no acesso ao banco de dados!");
    }
?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Curso PHP Integração com MySQL</title>

    <!-- estilo -->
    <link href="_css/estilo.css" rel="stylesheet">
    <link href="_css/crudNEW.css" rel="stylesheet">
</head>

<body>
    <?php include_once("_incluir/topo.php"); ?>
    <?php include_once("_incluir/funcoes.php"); ?>

    <main>
        <div id="janela_formulario">

            <form action="inserir_transportadora.php" method="post">
                <input type="text" name="nometransportadora" placeholder="Nome da Transportadora">
                <input type="text" name="endereco" placeholder="Endereço">
                <input type="text" name="telefone" placeholder="Telefone">
                <input type="text" name="cidade" placeholder="Cidade">
                <select name="estados">
                    <?php while ($linha = mysqli_fetch_assoc($lista_estados)) { ?>

                        <option value="<?php echo $linha["estadoID"]; ?>">
                            <?php echo $linha["nome"]; ?>
                        </option>

                    <?php } ?>

                </select>
                <input type="text" name="cep" placeholder="CEP">
                <input type="text" name="cnpj" placeholder="CNPJ">
                <input type="submit" value="Inserir">
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