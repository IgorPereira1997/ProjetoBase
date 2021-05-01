<header>
    <div id="header_central">
        <?php
            if (isset($_SESSION["cliente_portal"])){
                $user = $_SESSION["cliente_portal"];
                $saudation = "SELECT nomecompleto FROM clientes WHERE clienteID = {$user} ";

                $saudation_login = mysqli_query($connect, $saudation);
                if(!$saudation_login){
                    die("Falha no banco de dados! (Saudação)");
                }

                $saudation_login = mysqli_fetch_assoc($saudation_login);
                $nome = $saudation_login["nomecompleto"];
        ?>
        <div id="header_saudacao">
            <h5>Bem vindo, <?php echo $nome; ?> - <a href="sair.php">Sair</a></h5>           
        </div>
        <?php
            }if (isset($_SESSION["fornecedor_portal"])){
                    $user = $_SESSION["fornecedor_portal"];
                    $saudation = "SELECT nomefornecedor FROM fornecedores WHERE fornecedorID = {$user} ";
    
                    $saudation_login = mysqli_query($connect, $saudation);
                    if(!$saudation_login){
                        die("Falha no banco de dados! (Saudação)");
                    }
    
                    $saudation_login = mysqli_fetch_assoc($saudation_login);
                    $nome = $saudation_login["nomefornecedor"];
        ?>
        <div id="header_saudacao">
            <h5>Bem vindo, <?php echo $nome; ?> - <a href="sair.php">Sair</a></h5>           
        </div>
        <?php
           }
        ?>
        <img src="_assets/logo_andes.gif">
        <img src="_assets/text_bnwcoffee.gif">
    </div>
</header>