<template>
    <div>
        <bar-chart :chart-data="dados" :options="chartOptions" class="chart-style"></bar-chart>
    </div>
</template>

<script>
    import BarChart from './bar-chart.js'
    export default {
        components:{
            BarChart
        },
        props:["item"],
        data(){
            return {
                dados: this.dadosGrafico(this.item),
                chartOptions: {
                    maintainAspectRatio: false,
                    legend:{
                        position: "bottom",
                        labels:{
                            boxWidth:20
                        }
                    },
                    scales: {
                        xAxes: [{
                            stacked: true
                        }],
                        yAxes: [{
                            
                            stacked: true
                        }]
                    },
                    responsive:true
                }
            }
        },
        methods:{
            dadosGrafico: function(dados){
                function cor(nome){
                    switch(nome){
                        case "vermelho": return "rgba(255,0,0, 1)";
                        case "azul": return "rgba(56,176,222, 1)";
                        case "verde": return "rgba(50,205,153,1)";
                        case "preto": return "rgba(0, 0, 0, 1)";
                        case "cinza": return "rgba(168,168,168, 1)";
                        
                        default: return "rgba(168,168,168, 1)";
                    }
                }
                var arrDados = [];
                if(dados.configuracao.grupo == "B"){
                    if(dados.configuracao.modalidade == "Convencional"){
                        arrDados = [{
                            label: "Convencional",
                            backgroundColor : cor("azul"),
                            data : []
                        }];
                        arrDados[0].data = dados.consumo.conv.slice(0,12);
                    }
                    if(dados.configuracao.modalidade == "Branca"){
                        arrDados = [
                            {
                                label: "Fora da Ponta",
                                backgroundColor : cor("azul"),
                                data : []
                            },
                            {
                                label: "Interm.",
                                backgroundColor : cor("cinza"),
                                data : []
                            },
                            {
                                label: "Ponta",
                                backgroundColor : cor("verde"),
                                data : []
                            }
                        ];
                        arrDados[0].data = dados.consumo.fp.slice(0,12);
                        arrDados[1].data = dados.consumo.int.slice(0,12);
                        arrDados[2].data = dados.consumo.p.slice(0,12);
                    }
                }else{
                    arrDados = [
                        {
                            label: "Fora da Ponta",
                            backgroundColor : cor("azul"),
                            data : []
                        },
                        {
                            label: "Na Ponta",
                            backgroundColor : cor("verde"),
                            data : []
                        }
                    ];
                    arrDados[0].data = dados.consumo.fp.slice(0,12);
                    arrDados[1].data = dados.consumo.p.slice(0,12);
                }
                var chartData = {
                    labels: ["Jan", "Fev", "Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"],
                    datasets: arrDados
                }
                return chartData;
            }
        }
    }
</script>

<style>
    .chart-style{
        height:200px;
    }

</style>