<?php

include_once('config.php');
include_once('classes/clientes.class.php');
include_once('classes/gatilhos.class.php');
include_once('classes/perguntas.class.php');
include_once('classes/nps.class.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CloudiNet - NPS</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
</head>
<body>

<?php include_once('header.php'); ?>

<main>

    <?php

        if ( (isset($_POST['nps'])) && (isset($_POST['link'])) ) {
            $score = $_POST['nps'];
            $link = $_POST['link'];
        
            $nps = new Nps(0, "");
            $nps->pesquisar("mgt_nps.codigo_link", "=", $link, "mgt_nps.id");
            $nps_dados = $nps->getResultQuery();
            $nps_dados[0]['nota'] = $score;
            $nps_dados[0]['data_resposta'] = date("Y-m-d H:i:s");

            // print_r($nps_dados[0]);

            $nps->setNps($nps_dados[0]);

            $nps->escreverDb();

            echo "
                <p>Resposta enviada com sucesso!</p>

                <p>Muito obrigado!</p>
            ";
            
        } else {
            echo "
                <p>Erro ao enviar resposta!</p>
                ";
        }
        

    ?>
    

</main>

</body>
</html>

<script src="./assets/js/script.js"></script>