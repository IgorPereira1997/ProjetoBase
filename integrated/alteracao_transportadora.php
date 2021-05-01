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
    $nome = $_POST["nometransportadora"];
    $endereco = $_POST["endereco"];
    $telefone = $_POST["telefone"];
    $cidade = $_POST["cidade"];
    $estado = $_POST["estados"];
    $cep = $_POST["cep"];
    $cnpj = $_POST["cnpj"];
    $tID = $_POST["transportadoraID"];

    //Objeto para alterar
    $alterar = "UPDATE transportadoras SET ";
    $alterar .= "nometransportadora = '{$nome}', ";
    $alterar .= "endereco = '{$endereco}', ";
    $alterar .= "telefone = '{$telefone}', ";
    $alterar .= "cidade = '{$cidade}', ";
    $alterar .= "estadoID = {$estado}, ";
    $alterar .= "cep = '{$cep}', ";
    $alterar .= "cnpj = '{$cnpj}' ";
    $alterar .= "WHERE transportadoraID = {$tID} ";

    $op_alterar = mysqli_query($connect, $alterar);
    if(!$op_alterar){
        die("ERRO! Operação de alteração nao foi concluida com sucesso!");
    }else{
        header("location:listagem_transportadora.php");
    }

}
// Consultar a tabela de transportadora
$tr = "SELECT * FROM transportadoras ";
if (isset($_GET["codigo"])) {
    $id = $_GET["codigo"];
    $tr .= "WHERE transportadoraID = {$id} ";
} else {
    header("location:listagem_transportadora.php");
}

$con_transportadora = mysqli_query($connect, $tr);
if (!$con_transportadora) {
    die("Erro na consulta!");
}

$info_tr = mysqli_fetch_assoc($con_transportadora);

//consultar estados
$estados = "SELECT * FROM estados";
$lista_estados = mysqli_query($connect, $estados);
if (!$lista_estados) {
    die("Erro na consulta!");
}

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
            <form action="alteracao_transportadora.php" method="post">
                <h2>Alteração de Transportadoras</h2>
                <label for="nometransportadora">Nome da Transportadora</label>
                <input type="text" value="<?php echo $info_tr["nometransportadora"] ?>" name="nometransportadora" id="nometransportadora">

                <label for="endereco">Endereço</label>
                <input type="text" value="<?php echo $info_tr["endereco"] ?>" name="endereco" id="endereco">

                <label for="cidade">Cidade</label>
                <input type="text" value="<?php echo $info_tr["cidade"] ?>" name="cidade" id="cidade">

                <label for="estados">Estado</label>
                <select id="estados" name="estados">
                    <?php
                    $meu_estado = $info_tr["estadoID"];
                    while ($linha = mysqli_fetch_assoc($lista_estados)) {
                        if ($meu_estado == $linha["estadoID"]) {
                    ?>
                        <option value="<?php echo $linha["estadoID"]; ?>" selected>
                            <?php echo $linha["nome"]; ?>
                        </option>

                        <?php
                        }else{
                        ?>
                            <option value="<?php echo $linha["estadoID"]; ?>">
                                <?php echo $linha["nome"]; ?>
                            </option>
                        <?php } ?>
                    <?php } ?>
                </select>

                <label for="cep">CEP</label>
                <input type="text" value="<?php echo $info_tr["cep"] ?>" name="cep" id="cep">

                <label for="telefone">Telefone</label>
                <input type="text" value="<?php echo $info_tr["telefone"] ?>" name="telefone" id="telefone">

                <label for="cnpj">CNPJ</label>
                <input type="text" value="<?php echo $info_tr["cnpj"] ?>" name="cnpj" id="cnpj">
                
                <input type="hidden" name="transportadoraID" value="<?php echo $info_tr["transportadoraID"]; ?>">

                <input type="submit" value="Confirmar Alteração">
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