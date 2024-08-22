<?php

include_once('config.php');
include_once('classes/clientes.class.php');
include_once('classes/gatilhos.class.php');
include_once('classes/nps.class.php');

$nps = new Nps(0, "");
$gatilho = new Gatilho(0, "");
$gatilho_dados = $gatilho->pesquisar("mgt_nps_gatilho.id","!=","");

if (isset($_POST['gatilho'])) {
    $gatilho_id = $_POST['gatilho'];
} else {
    $gatilho_id = "";
}

if ( (isset($_POST['from'])) && (isset($_POST['to'])) ) {
    $from = $_POST['from'];
    $to = $_POST['to'];
}

if (isset($_POST['data'])) {
    $data = $_POST['data'];
} else {
    $data = "";
}

if (isset($_POST['respondida'])) {
    $respondida = $_POST['respondida'];
} else {
    $respondida = "";
}

if (isset($_POST['nome'])) {
    $nome = $_POST['nome'];
    $nps->pesquisarNomeDoCliente($nome, $data, $from, $to, $gatilho_id, $respondida, "mgt_nps.id DESC");
    
} else {
    $nome = "";
    $cliente_dados = $nps->pesquisar("mgt_nps.id","!=","", "mgt_nps.id DESC");
}

$cliente_dados = $nps->getResultQuery();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NPS</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/nps-admin.css">
    <link rel="stylesheet" href="assets/css/dashboard-chart.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script src="./assets/js/highcharts.js"></script>
    <script src="./assets/js/exporting.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" integrity="sha512-dPXYcDub/aeb08c63jRq/k6GaKccl256JQy/AnOq7CAnEZ9FzSL9wSbcZkMp4R26vBsMLFYH4kQ67/bbV8XaCQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
  
    <?php include_once('header.php'); ?>
    <?php include_once('menu.php'); ?>

    <main>
        <?php
            include_once('search-bar.php');
            $dashboard_data = $nps->getDashboard();

            include_once('grafico-barras.php');
            showDashboard($dashboard_data);
        ?>

        <div class="nps-result">
            <div class="nps-list">
                <div class="nps-item-title">
                    <div class="nps-item-id">ID</div>
                    <div class="nps-item-name">Cliente</div>
                    <div class="nps-trigger">Gatilho</div>
                    <div class="nps-created">Criado</div>
                    <div class="nps-answered">Respondido</div>
                    <div class="nps-item-score">Score</div>
                    <div class="nps-item-link">Link</div>
                </div>

                <?php foreach ($cliente_dados as $key => $value) { ?>
                    <div class="nps-item-data">
                        <div class="nps-item-id"><?= $value['id'] ?></div>
                        <div class="nps-item-name">
                            <a href="detalhes.php?id=<?= $value['id'] ?>">
                                <?= $value['cliente_nome'] ?>
                            </a>
                        </div>
                        <div class="nps-trigger"><?= $value['gatilho'] ?></div>
                        <div class="nps-created"><?= $value['data_criacao'] ?></div>
                        <div class="nps-answered"><?= $value['data_resposta'] ?></div>
                        <div class="nps-item-score"><?= $value['nota'] ?></div>
                        <div class="nps-item-link">

                            
                        <!-- Botão usado para copiar o link -->
                        <?php

                            $link_nps = $dominio_resposta . "responder.php?link=" .
                            $value['codigo_link'];

                        ?>

                        <input type="text" value="http:<?php echo $link_nps; ?>" 
                            id="linkParaCopia<?php echo $value['id']; ?>"
                            sizeof="1"
                            style="display: none;"
                        >

                        <button class="link-button" onclick="copyToClipboard(linkParaCopia<?php echo $value['id']; ?>)">Copiar Link <?php //echo $value['codigo_link']; ?> </button>

                        </div>
                    </div>
                <?php } ?>


            </div>
        </div>

    </main>

    <footer>
        Todos os direitos reservados.
    </footer>
    
</body>
</html>

<script>
    function copyToClipboard(element) {
        let id = element.id;
        let copyText = document.getElementById(id);
        copyText.select();
        copyText.setSelectionRange(0, 99999); // Para dispositivos móveis
        navigator.clipboard.writeText(copyText.value);
        // alert("Link copiado com sucesso! " + copyText.value);
        alert("Link copiado com sucesso!");
    }

</script>