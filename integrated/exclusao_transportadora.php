<?php require_once("../connection/conexao.php"); ?>
<?php

    session_start();

    if (!isset($_SESSION["fornecedor_portal"])) {
        header("location:login.php");
    }

    // Determinar localidade BR
    setlocale(LC_ALL, 'pt_BR');


    if( isset($_POST["nometransportadora"]) && 
        isset($_POST["endereco"]) && 
        isset($_POST["telefone"]) && 
        isset($_POST["cidade"]) && 
        isset($_POST["estados"]) && 
        isset($_POST["cep"]) && 
        isset($_POST["cnpj"]) ){
            $tID = $_POST["transportadoraID"];
            $exclusao = "DELETE FROM transportadoras WHERE transportadoraID = {$tID}";
            $con_excl = mysqli_query($connect, $exclusao);
            if(!$con_excl){
                die("Registro não encontrado!");
            }else{
                header("location:listagem_transportadora.php");
            }
    }

    //Consulta a tabela de transportadoras
    $tr = "SELECT * FROM transportadoras ";
    if (isset($_GET["codigo"])) {
        $id = $_GET["codigo"];
        $tr .= "WHERE transportadoraID = {$id}";
    }else{
        header("location:listagem_transportadora.php");
    }

    $con_transportadora = mysqli_query($connect, $tr);
    if (!$con_transportadora) {
        die("Erro na consulta!");
    }

    $info_tr = mysqli_fetch_assoc($con_transportadora);
    //consultar estados
    $estados = "SELECT * FROM estados WHERE estadoID = {$info_tr['estadoID']}";
    $nome_estado = mysqli_query($connect, $estados);
    if (!$nome_estado) {
        die("Erro na consulta!");
    }

    $nome_estado = mysqli_fetch_assoc($nome_estado);

?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Curso PHP Integração com MySQL</title>

    <!-- estilo -->
    <link href="_css/estilo.css" rel="stylesheet">
    <link href="_css/alteracao.css" rel="stylesheet">
</head>

<body>
    <?php include_once("_incluir/topo.php"); ?>
    <?php include_once("_incluir/funcoes.php"); ?>

    <main>
        <div id="janela_formulario">
            <form action="exclusao_transportadora.php" method="post">
                <h2>Exclusão de Transportadoras</h2>
                <label for="nometransportadora">Nome da Transportadora</label>
                <input type="text" value="<?php echo $info_tr["nometransportadora"] ?>" name="nometransportadora" id="nometransportadora" readonly>

                <label for="endereco">Endereço</label>
                <input type="text" value="<?php echo $info_tr["endereco"] ?>" name="endereco" id="endereco" readonly>

                <label for="cidade">Cidade</label>
                <input type="text" value="<?php echo $info_tr["cidade"] ?>" name="cidade" id="cidade" readonly>

                <label for="estados">Estado</label>
                <input type="text" value="<?php echo $nome_estado["nome"] ?>" name="estados" id="cidade" readonly>
                

                <label for="cep">CEP</label>
                <input type="text" value="<?php echo $info_tr["cep"] ?>" name="cep" id="cep" readonly>

                <label for="telefone">Telefone</label>
                <input type="text" value="<?php echo $info_tr["telefone"] ?>" name="telefone" id="telefone" readonly>

                <label for="cnpj">CNPJ</label>
                <input type="text" value="<?php echo $info_tr["cnpj"] ?>" name="cnpj" id="cnpj" readonly>

                <input type="hidden" name="transportadoraID" value="<?php echo $info_tr["transportadoraID"]; ?>">

                <input type="submit" value="Confirmar Exclusão">
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