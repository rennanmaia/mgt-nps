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

class Nps
{

    private $db;
    private $data;
    private $result_query;
    private $dashboard;

    public function __construct ($id, $uuid) {

        $this->dashboard = [];

        $this->db = new Db();

        if ( ($id != 0) || ($uuid != "") ) {

            $this->data = $this->db->query("
                SELECT * FROM mgt_nps WHERE 
                id = ? ", 
                $id 
            )->fetchArray();
        } 

    }

    public function loadNps() {

        $this->db = new Db();

        if ( ($id != 0) || ($uuid != "") ) {

            $this->data = $this->db->query("
                SELECT * FROM mgt_nps WHERE 
                id = ? ", 
                $id 
            )->fetchArray();
        } 

    }    

    public function getNps () {
        return $this->data;
    }

    public function getResultQuery () {
        return $this->result_query;
    }

    public function setNps($new_data) {

        $this->data = $new_data;

    }

    public function insertNps() {
        if (isset($this->data["cliente_id"])) {
            $query = "
                INSERT INTO mgt_nps (cliente_id, data_criacao, nps_pergunta_id, nps_gatilho_id, codigo_link)
                VALUES ('".$this->data["cliente_id"]."',
                        '".$this->data["data_criacao"]."',
                        '".$this->data["nps_pergunta_id"]."',
                        '".$this->data["nps_gatilho_id"]."',
                        '".$this->data["codigo_link"]."'
                        )";

            $this->db->query($query);
            $this->data["id"] = $this->db->lastInsertID();
            
            return $this->data["id"];
        }
    }

    public function escreverDb() {

        if (isset($this->data["id"])) {
            $query = "
                UPDATE mgt_nps 
                SET 
                    cliente_id = '" . $this->data["cliente_id"] . "',
                    nota = '" . $this->data["nota"] . "',
                    data_criacao = '" . $this->data["data_criacao"] . "',
                    data_resposta = '" . $this->data["data_resposta"] . "',
                    nps_pergunta_id = '" . $this->data["nps_pergunta_id"] . "',
                    nps_gatilho_id = '" . $this->data["nps_gatilho_id"] . "',
                    codigo_link = '" . $this->data["codigo_link"] . "' 
                WHERE 
                    id = '" . $this->data["id"] . "' ";
            $this->db->query($query);
        }

    }
    
    public function pesquisar($field, $operator, $value, $order) {
        
        if ( ($field == "") && ($value == "") ) {
            echo $query = "
                SELECT mgt_nps.*, sis_cliente.nome AS cliente_nome, mgt_nps_pergunta.pergunta AS pergunta,
                    mgt_nps_gatilho.nome AS gatilho
                FROM mgt_nps
                INNER JOIN sis_cliente ON sis_cliente.id = mgt_nps.cliente_id
                INNER JOIN mgt_nps_pergunta ON mgt_nps_pergunta.id = mgt_nps.nps_pergunta_id
                INNER JOIN mgt_nps_gatilho ON mgt_nps_gatilho.id = mgt_nps.nps_gatilho_id
                ORDER BY $order 
            ";
        } else {
            $query = "
                SELECT mgt_nps.*, sis_cliente.nome AS cliente_nome, mgt_nps_pergunta.pergunta AS pergunta,
                    mgt_nps_gatilho.nome AS gatilho
                FROM mgt_nps
                INNER JOIN sis_cliente ON sis_cliente.id = mgt_nps.cliente_id
                INNER JOIN mgt_nps_pergunta ON mgt_nps_pergunta.id = mgt_nps.nps_pergunta_id
                INNER JOIN mgt_nps_gatilho ON mgt_nps_gatilho.id = mgt_nps.nps_gatilho_id
            WHERE "
            . $field . " "
            . $operator . " '"
            . $value . "' 
                ORDER BY $order "
            ;
        }

        $this->result_query = $this->db->query($query)->fetchAll();
        $this->dashboard = $this->db->query($query)->numRows();

    }

    public function pesquisaDetalhada($field, $value) {
        
        if ( ($field != "") && ($value != "") ) {
            return $this->db->query("
            SELECT * FROM mgt_nps WHERE "
            . $field . " LIKE '%"
            . $value . "%'
            ORDER BY mgt_nps.id "
            )->fetchAll();
        }
        
    }


    public function pesquisarNomeDoCliente($nome, $data, $from, $to, $gatilho_id, $respondida, $order) {

        $query = "
                SELECT mgt_nps.*, sis_cliente.nome AS cliente_nome, mgt_nps_pergunta.pergunta AS pergunta,
                    mgt_nps_gatilho.nome AS gatilho
                FROM mgt_nps
                INNER JOIN sis_cliente ON sis_cliente.id = mgt_nps.cliente_id
                INNER JOIN mgt_nps_pergunta ON mgt_nps_pergunta.id = mgt_nps.nps_pergunta_id
                INNER JOIN mgt_nps_gatilho ON mgt_nps_gatilho.id = mgt_nps.nps_gatilho_id 
                WHERE 1 ";
        
        if ($nome != "") {
            $query .= " AND sis_cliente.nome LIKE '%$nome%' ";
        }
    
        if ( ($data != "") && ($from != "") && ($to != "") ) {
            $query .= " AND mgt_nps.$data >= '$from 0:0:0' && mgt_nps.$data <= '$to 23:59:59' ";                    
        }

        if ($gatilho_id != "") {
            $query .= " AND mgt_nps.nps_gatilho_id = '$gatilho_id' ";
        }

        if ($respondida != "") {
            if ($respondida == "sim") {
                $query .= " AND mgt_nps.nota <> -1 ";
            } else {
                $query .= " AND mgt_nps.nota = -1 ";
            }
        }

        $query .= "ORDER BY $order";

        // echo $query;
        $this->result_query = $this->db->query($query)->fetchAll();
        $this->dashboard = $this->db->query($query)->numRows();
        // return $this->db->query($query)->fetchAll();
        
    }

    public function getDashboard() {

        $result = array();

        foreach ($this->result_query as $key => $value) {
            if ($value["nota"] != -1) {
                $result[] = $value;
            }
        }

        $num_rows = count($result);

        $soma = 0;
        $media = 0.0;
        $qtd_promotores = 0;
        $qtd_passivos = 0;
        $qtd_detratores = 0;

        foreach ($result as $key => $value) {
            $soma += $value["nota"];

            if ($value["nota"] <= 6) {
                $qtd_detratores++;
            } elseif ($value["nota"] <= 8) {
                $qtd_passivos++;
            } else {
                $qtd_promotores++;
            }
            // echo $value["id"] . " - " . $value["nota"] . "<br>";
        }


        if ($num_rows > 0) {
            $media = $soma / $num_rows;
            $porc_detratores = $qtd_detratores / $num_rows * 100;
            $porc_passivos = $qtd_passivos / $num_rows * 100;
            $porc_promotores = $qtd_promotores / $num_rows * 100;

            $res = array(
                "num_rows" => $num_rows,
                "media" => $media,
                "qtd_promotores" => $qtd_promotores,
                "qtd_passivos" => $qtd_passivos,
                "qtd_detratores" => $qtd_detratores,
                "porc_detratores" => $porc_detratores,
                "porc_passivos" => $porc_passivos,
                "porc_promotores" => $porc_promotores
            );

            $this->dashboard = $res;

        }

        return $this->dashboard;
    }


}

