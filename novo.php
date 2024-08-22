<?php

include_once('config.php');
include_once('classes/clientes.class.php');
include_once('classes/gatilhos.class.php');

$cliente = "";
$gatilho = "";
$pergunta = "";

if (isset($_POST['nome'])) {

    $nome = $_POST['nome'];

    $cliente = new Cliente(0, "");
    $cliente_dados = $cliente->pesquisar("nome","LIKE","%$nome%");
    // print_r($customer_data = $customer->search("nome","LIKE","%$nome%"));
    
    // $cliente_id = $customer_data[0]["id"];
    // $cliente = $customer_data[0]["nome"];

    $gatilho = new Gatilho(0, "");
    $gatilho_dados = $gatilho->pesquisar("mgt_nps_gatilho.id","!=","");
    // print_r($gatilho_dados);

} else {
    $nome = "";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NPS - Novo</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/nps-admin.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" integrity="sha512-dPXYcDub/aeb08c63jRq/k6GaKccl256JQy/AnOq7CAnEZ9FzSL9wSbcZkMp4R26vBsMLFYH4kQ67/bbV8XaCQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

</head>
<body>

    <?php include_once('header.php'); ?>
    <?php include_once('menu.php'); ?>

    <main>

        <h1>Nova chamada NPS</h1>


        <div class="search-bar">
            <form class="form-cliente" action="?" method="post">
                Nome do cliente: 
                <input type="text" id="nome" name="nome" 
                    placeholder="Nome" value="<?php echo $nome; ?>" 
                    class="search-customer-name"
                />
                <input type="submit" class="send-button" value="Pesquisar" />
            </form>
        </div>

        <form class="form-novo-nps" action="detalhes.php" method="post">
            <fieldset>
                <label for="cliente">Cliente:</label>

                <select name="cliente" class="new-customer">
                    <option>Selecione:</option>

                    <?php
                        foreach ($cliente_dados as $key => $value) {
                            echo "<option value='$value[id]'>$value[nome]</option>";
                        }
                    ?>
                </select>

            </fieldset> 
            <fieldset>
                <label for="gatilho">Gatilho:</label> 

                <select name="gatilho" class="new-trigger">
                    <option>Selecione:</option>
                    
                    <?php
                        foreach ($gatilho_dados as $key => $value) {
                            echo "<option value='$value[id]'>$value[id] - $value[nome]</option>";
                        }
                    ?>
                </select>

            </fieldset>
            <input type="submit" value="Gerar link" class="send-button" />
        </form>

    </main>
    
    <footer>
        Todos os direitos reservados.
    </footer>
    
    
</body>
</html>