<?php
    function real_format($valor) {
        $valor  = number_format($valor,2,",",".");
        return "R$ " . $valor;
    }

    function gerarCodigoUnico(){
        $alfabeto = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $tamanho = 12;
        $letra = "";
        $resultado = "";

        for ($i = 1; $i < $tamanho; $i++) {
            $letra = substr($alfabeto, rand(0, 35), 1);
            $resultado .= $letra;
        }

        date_default_timezone_set('America/Recife');
        $agr = getdate();

        $cod_data = $agr["year"] . "_" . $agr["yday"];
        $cod_data .= $agr['hours'] . $agr['minutes'] . $agr["seconds"];

        return "foto_".$cod_data . "_" . $resultado;
    }

    function getExtensao($nome){
        return strrchr($nome, ".");
    }

    function warningUpload($num){
        $array_erro = array(
            UPLOAD_ERR_OK => "Sem erro.",
            UPLOAD_ERR_INI_SIZE => "O arquivo enviado excede o limite definido na diretiva upload_max_filesize do php.ini.",
            UPLOAD_ERR_FORM_SIZE => "O arquivo excede o limite definido em MAX_FILE_SIZE no formulário HTML",
            UPLOAD_ERR_PARTIAL => "O upload do arquivo foi feito parcialmente.",
            UPLOAD_ERR_NO_FILE => "Nenhum arquivo foi enviado.",
            UPLOAD_ERR_NO_TMP_DIR => "Pasta temporária ausente.",
            UPLOAD_ERR_CANT_WRITE => "Falha em escrever o arquivo em disco.",
            UPLOAD_ERR_EXTENSION => "Uma extensão do PHP interrompeu o upload do arquivo."
        );
        
        return $array_erro[$num];
    }

    function publishArchive($archive){
        
        $arq_tmp = $archive['tmp_name'];
        $name_original = basename($archive['name']);
        $name_new = gerarCodigoUnico().getExtensao($name_original);
        $name_full = "images/product_images/".$name_new;

        if (move_uploaded_file($arq_tmp, $name_full)) {
            return array("Imagem publicada com sucesso!", $name_full);
        } else {
            return array(warningUpload($archive['error']), "");
        }
    }

    function enviarMensagem($dados){
        // Dados formulário
        $nome_user  = $dados['nome'];
        $email_user = $dados["email"];
        $msg_user   = $dados['mensagem'];

        //Criar variáveis de envio
        $destino   = "teste_to@teste.com";
        $remetente = "teste_from@teste.com";
        $assunto   = "Mensagem do site de PHP_BD";

        //Montar corpo da mensagem
        $mensagem = "O usuário ". $nome_user . " enviou uma mensagem." . "</>";
        $mensagem .= "Email do usuário: ".$email_user."</br>";
        $mensagem .= "Mensagem: ". "</br>";
        $mensagem .= $msg_user;

        return mail($destino, $assunto, $mensagem, $remetente);

    }
    
?>