<?php

function showDashboard($dashboard_data) {

?>

<div id="nps-dashboard">

    <div class="show-dashboard-data">

        <div id="dashboard-answer-box" class="dashboard-box">
            <div class="answer-number-title box-title">
                Número da respostas:
            </div>
            <div class="answer-number-value">
                <?php echo $dashboard_data['num_rows']; ?>
            </div>
        </div>
    
        <div id="everage_score" class="dashboard-box">
            <div class="average-score-title box-title">
                Nota Média: 
            </div>
            <div class="average-score-value">
                <?php echo number_format($dashboard_data['media'], 2, ',', '.'); ?>
            </div>
        </div>
    
        <div id="detractors" class="dashboard-box">
            <div class="detractors-title box-title">
                Detratores: 
            </div>
            <div class="detractors value">
                <?php echo $dashboard_data['qtd_detratores']; ?>
                (<?php echo number_format($dashboard_data['porc_detratores'], 2, ',', '.') . "%"; ?>)
            </div>
        </div>
    
        <div id="passives" class="dashboard-box">
            <div class="passives-title box-title">
                Neutros: 
            </div>
            <div class="passives-value">
                <?php echo $dashboard_data['qtd_passivos']; ?>
                (<?php echo number_format($dashboard_data['porc_passivos'], 2, ',', '.') . "%"; ?>)
            </div>
            
        </div>
    
        <div id="promoters" class="dashboard-box">
            <div class="promoters-title box-title">
                Promotores: 
            </div>
            <div class="promoters-value">
                <?php echo $dashboard_data['qtd_promotores']; ?>
                (<?php echo number_format($dashboard_data['porc_promotores'], 2, ',', '.') . "%" ; ?>)
            </div>
        </div>

    </div>


    <figure class="highcharts-figure">
        <div id="container-bb"></div>

        <p class="highcharts-description">
        
        <script>

        // gr�fico 1
        Highcharts.chart('container-bb', {
            plotOptions: {
                bar: { 
                    dataLabels: {
                        enabled: true
                    },
                    groupPadding: 0.1
                },
            },

            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 80,
                floating: true,
                borderWidth: 1,
                backgroundColor:
                    Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                shadow: true
            },
            title: {
                text: 'NPS'
            },
            xAxis: {
                categories: [
                    'Tipo de cliente'
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Quantidade',
                    align: 'high'
                },
                labels: {
                overflow: 'justify'
                },
        
                gridLineWidth: 0
            },
            credits: {
                enabled: false
            },
            series: [{
                type: 'bar',
                name: 'Detratores',
                data: [
                    <?php echo $dashboard_data['qtd_detratores']; ?>
                ]
            }, {
                type: 'bar',
                name: 'Neutros',
                data: [
                    <?php echo $dashboard_data['qtd_passivos']; ?>
                ]
            }, {
                type: 'bar',
                name: 'Promotores',
                data: [
                    <?php echo $dashboard_data['qtd_promotores']; ?>
                ]
            }],

        });
        </script>
        </p>
    </figure>

</div>

<?php
    
}

?>