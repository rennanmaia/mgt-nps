<?php

require_once 'db.php';

// Use examples
// Source: https://codeshack.io/super-fast-php-mysql-database-class/
// Declaration
// $customer = new Customer(1,"");
// $customer = new Customer(0,"");

// Return just customer by id 1
// print_r($customer->getCustomer());

// Return search result
// print_r($customer->search("nome","=","Rennan"));
// print_r($cashbook->search("login","=","rennan@cloudinet.com.br"));

// Edit a cashbook 
// $new_data = $customer->getCustomer();

// $new_data["nome"] = "nome";
// $new_data["login"] = "login@cloudinet.com.br"; 

// $customer->setCustomer($new_data);
// $customer->writeDb();
// print_r($customer->getCustomer());

class Gatilho
{

    private $db;
    private $data;

    public function __construct ($id, $uuid) {

        $this->db = new Db();

        if ( ($id != 0) || ($uuid != "") ) {

            $this->data = $this->db->query("
                SELECT * FROM mgt_nps_gatilho WHERE 
                id = ? ", 
                $id
            )->fetchArray();
        } 

    }

    public function getGatilho () {

        return $this->data;

    }

    public function setGatilho($new_data) {

        $this->data = $new_data;

    }

    public function escreverDb() {

        if (isset($this->data["id"])) {
            $this->db->query("
                UPDATE mgt_nps_gatilho 
                SET 
                    nome = ?, 
                    descricao = ?
                    nps_pergunta_id = ?
                WHERE 
                    id = '" . $this->data["id"] . "' "
            );
        }

    }
    
    public function pesquisar($field, $operator, $value) {
        
        if ( ($field == "") && ($value == "") ) {
            return $this->db->query("
                SELECT mgt_nps_gatilho.*, mgt_nps_pergunta.pergunta AS pergunta
                FROM mgt_nps_gatilho
                INNER JOIN mgt_nps_pergunta ON mgt_nps_pergunta.id = mgt_nps_gatilho.nps_pergunta_id
            ")->fetchAll();
        } else {
            return $this->db->query("
                SELECT mgt_nps_gatilho.*, mgt_nps_pergunta.pergunta AS pergunta
                FROM mgt_nps_gatilho
                INNER JOIN mgt_nps_pergunta ON mgt_nps_pergunta.id = mgt_nps_gatilho.nps_pergunta_id
            WHERE "
            . $field . " "
            . $operator . " '"
            . $value . "'"
            )->fetchAll();
        }
        
    }

    public function pesquisaDetalhada($field, $value) {
        
        if ( ($field != "") && ($value != "") ) {
            return $this->db->query("
            SELECT * FROM sis_cliente WHERE "
            . $field . " LIKE '%"
            . $value . "%'"
            )->fetchAll();
        }
        
    }

}

