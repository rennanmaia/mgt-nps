<?php

include_once('config.php');
include_once('classes/clientes.class.php');
include_once('classes/gatilhos.class.php');
include_once('classes/perguntas.class.php');
include_once('classes/nps.class.php');

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $nps = new Nps(0, "");
    $nps_dados = $nps->pesquisar("mgt_nps.id", "=", $id, "mgt_nps.id");
    $nps_dados = $nps->getResultQuery();
    
} else {
    $id = "";

    if (isset($_POST['cliente'])) {
        $link_gerado = gerarStringAleatoria(8);
        $data_criacao = date("Y-m-d H:i:s");

        $cliente_id = $_POST['cliente'];
        $gatilho_id = $_POST['gatilho'];

        $gatilho = new Gatilho(0, "");
        $gatilho_dados = $gatilho->pesquisar("mgt_nps_gatilho.id", "=", $gatilho_id );
        $pergunta_id = $gatilho_dados[0]['nps_pergunta_id'];

        $nps = new Nps(0, "");

        $new_data = $nps->getNps();
        $new_data['cliente_id'] = $cliente_id;
        $new_data['nps_pergunta_id'] = $pergunta_id;
        $new_data['nps_gatilho_id'] = $gatilho_id;
        $new_data['codigo_link'] = $link_gerado;
        $new_data['data_criacao'] = $data_criacao;
        $nps->setNps($new_data);
        $id = $nps->insertNps();
        $nps_dados = $nps->pesquisar("mgt_nps.id", "=", $id, "mgt_nps.id");
        $nps_dados = $nps->getResultQuery();
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NPS - Novo</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- <link rel="stylesheet" href="assets/css/nps-admin.css"> -->
    <link rel="stylesheet" href="assets/css/style-details-page.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script src="./assets/js/script.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" integrity="sha512-dPXYcDub/aeb08c63jRq/k6GaKccl256JQy/AnOq7CAnEZ9FzSL9wSbcZkMp4R26vBsMLFYH4kQ67/bbV8XaCQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

</head>
<body>

    <?php include_once('header.php'); ?>
    <?php include_once('menu.php'); ?>

    <main>

    <div>

        <h1>Detalhes</h1>

        <div class="details-base-fields">
            <div class="details-id">
                ID:
                <?php echo $nps_dados[0]["id"]; ?>
            </div>

            <div class="details-customer">  
                Cliente: 
                <?php echo $nps_dados[0]["cliente_nome"]; ?>
            </div>

            <div class="created-date">
                Data de criação:
                <?php echo $nps_dados[0]["data_criacao"]; ?>
            </div>

            <div class="answered-date">
                Data de resposta:
                <?php echo $nps_dados[0]["data_resposta"]; ?>
            </div>

            <div class="details-trigger">
                Gatilho:
                <?php echo $nps_dados[0]["gatilho"]; ?>
            </div>

            <div class="details-question">
                Pergunta:
                <?php echo $nps_dados[0]["pergunta"]; ?>
            </div>

            <div class="details-score">
                Score:
                <?php echo $nps_dados[0]["nota"]; ?>
            </div>

        </div>


        <!-- Campo texto contendo link do NPS -->
         <?php

            $link_nps = $dominio_resposta . "responder.php?link=" .
                $nps_dados[0]["codigo_link"];
        
        ?>

        <div class="details-link">
        
            <input type="text" value="http:<?php echo $link_nps; ?>" id="linkParaCopiar" style="display: none;">

            <!-- Botão usado para copiar o link -->
            <button onclick="copyToClipboard()">Copiar Link</button>
        
        </div>

        <script>
            function copyToClipboard() {
                var copyText = document.getElementById("linkParaCopiar");
                copyText.select();
                copyText.setSelectionRange(0, 99999); // Para dispositivos móveis
                navigator.clipboard.writeText(copyText.value);
                alert("Link copiado com sucesso!");
            }
        </script>

    </div>

    </main>
    
    <footer>
        Todos os direitos reservados.
    </footer>
    
    
</body>
</html>