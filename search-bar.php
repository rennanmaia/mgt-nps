<div class="search-bar">

    <form class="form-cliente" action="?" method="post">

        <div class="search-bar-inputs">
            <label>Cliente:</label>
            <input type="text" id="nome" name="nome" placeholder="Nome do cliente" 
            value="<?php echo $nome; ?>" class="search-bar-input" />
        
            <select name="data" class="search-bar-input">
                <option value="">Tipo de Data:</option>
                <option value="data_criacao"
                <?php if ($data == "data_criacao") { echo " selected "; } ?>
                >Data da criação</option>
                <option value="data_resposta"
                <?php if ($data == "data_resposta") { echo " selected "; } ?>
                >Data da resposta</option>
            </select>

            <span class="search-bar-period">
                <label for="fromperiod">Início: </label>
                <input type="date" id="fromperiod" name="from" 
                    value="<?php echo $from; ?>" class="search-bar-input">
                <label for="toperiod">Fim: </label>
                <input type="date" id="toperiod" name="to" 
                    value="<?php echo $to; ?>" class="search-bar-input">
            </span>

            <select name="gatilho" class="search-bar-input">
                <option value="">Gatilho:</option>
                <?php foreach ($gatilho_dados as $key => $value) { ?>
                    <option value="<?= $value['id'] ?>"
                        <?php
                        if ($value['id'] == $gatilho_id) { echo " selected "; } ?>
                        ><?= $value['nome'] ?></option>
                    <?php } ?>
            </select>

            <select name="respondida" class="search-bar-input">
                <option value="">Respondida?</option>
                <option value="sim"
                    <?php if ($respondida == "sim") { echo " selected "; } ?>
                    >Sim</option>
                <option value="nao"
                    <?php if ($respondida == "nao") { echo " selected "; } ?>
                >Não</option>
            </select>
        </div>

        <div class="search-bar-button-container">
            <input type="submit" value="Pesquisar" class="search-bar-button" />
        </div>

    </form>
</div>
