<?php

include_once('config.php');
include_once('classes/clientes.class.php');
include_once('classes/gatilhos.class.php');
include_once('classes/perguntas.class.php');
include_once('classes/nps.class.php');

if (isset($_GET['link'])) {

    $link = $_GET['link'];

    $nps = new Nps(0, "");
    $nps_dados = $nps->pesquisar("mgt_nps.codigo_link", "=", $link, "mgt_nps.id");
    
}

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

<header>
    <img src="./assets/images/logo-nps.png" alt="logo" id="logo">
    <h1>CloudiNet Provedor de Internet</h1>
</header>

<main>
    
    <div class="question">
        Em uma escala de 0 a 10, você indicaria essa empresa para um familiar ou amigo?
    </div>
    
    <div class="nps-scores">
       <div class="detractor" id="1">1</div>
       <div class="detractor" id="2">2</div>
       <div class="detractor" id="3">3</div>
       <div class="detractor" id="4">4</div>
       <div class="detractor" id="5">5</div>
       <div class="passive" id="6">6</div>
       <div class="passive" id="7">7</div>
       <div class="passive" id="8">8</div>
       <div class="promoter" id="9">9</div>
       <div class="promoter" id="10">10</div>
    </div>
    
    <form class="form_resposta" action="agradecimento.php" method="POST">
        <input type="hidden" name="link" id="link" placeholder="Link" value="<?= $link ?>">
        <input type="hidden" name="nps" id="nps" placeholder="NPS" value="0">
        <button class="send-button">Enviar</button>
    </form>

</main>

<script src="./assets/js/script.js"></script>

<!-- 
<div class="perguntas">

   <div class="pergunta">
      Em uma escala de 0 a 10, você indicaria essa empresa par aum familiar ou amigo?
   </div>

   <div class="pergunta">
      Em uma escala de 0 a 10, qual é o seu nível de satisfação com este atendimento?
   </div>

   <div class="pergunta">
      Em uma escala, como você avaliaria a experiência de compra?
   </div>

   <div class="pergunta">
      Qual a probabilidade de você recomendar nossa empresa para um amigo ou familiar?
   </div>

</div> -->

</body>
</html>
