<?php

$extensao = "hhvm";
// $extensao = "php";

$dominio_resposta = "localhost/mgt-nps/";

function gerarStringAleatoria($size){
   $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
   $randomString = '';
   for($i = 0; $i < $size; $i++){
      $randomString .= $chars[mt_rand(0,35)];
   }
   if (verificarLinkExiste($randomString)) {
      gerarStringAleatoria($size);
   } else {
      return $randomString;
   }
}

function verificarLinkExiste($link) {

   include_once("classes/nps.class.php");

   $nps = new Nps(0, "");
   $cliente_dados = $nps->pesquisar("mgt_nps.codigo_link", "=", $link, "mgt_nps.id DESC");
   if ($cliente_dados) {
      return true;
   } else {
      return false;
   }

}


?>