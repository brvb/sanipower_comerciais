<div>
<div>
<div class="row" style="margin-left: 10px;">
<div class="card-body" style = "align-items: center">
    <center>
    <label for="monthInput">Mês:</label>
    <input type="number" id="monthInput" min="1" max="12" value="" wire:model.defer="Month" oninput = "validateInputs('monthInput')" />
    
    <label for="yearInput">Ano:</label>
    <input type="number" id="yearInput" min="2000" value="" wire:model.defer="Year" oninput = "validateInputs('yearInput')" />

    <button class="btn btn-sm btn-primary" wire:click="FlushAll()" id="updateButton90"> 
        <i class="ti-reload"></i><span> Atualizar</span>
    </button>
    <br>
</center>
</div>
</div>
<div class="row" style="margin-left: 10px;">
    @if ($this->show90dias == true)
    <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="card mb-3">
            <div class="card-body">
                <div id="product-sales-chart"></div>
            </div>
        </div>
    </div>
    @endif
    @if ($this->showObjFat == true)
    <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="card mb-3">
            <div class="card-body">
                <div id="expenses-chart1"></div>
            </div>
        </div>
    </div>
    @endif  
</div>

<div class="row" style="margin-left: 10px;">
    <!-- Expenses Chart -->
    @if ($this->showTop500 == true)
     <!-- Inputs para Mês e Ano -->
     <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="card mb-3">
            <div class="card-body">
                <div id="expenses-chart2"></div>
            </div>
        </div>
    </div>
    @endif
    <!-- Expenses Chart -->
    @if ($this->showObjMargin == true)
    <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="card mb-3">
            <div class="card-body">
                <div id="expenses-chart3"></div>
            </div>
        </div>
    </div> 
    @endif
</div>

<!-- EOF MAIN-BODY -->
<style>
    .row {
        display: flex;
        flex-wrap: wrap;
    }
    .card {
        flex: 1 1 auto;
        min-height: 400px; /* ou o valor que você preferir */
    }
  </style>
  
  <script>
    function validateInputs(section) {
        const monthInput = document.getElementById(`monthInput${section}`).value;
        const yearInput = document.getElementById(`yearInput${section}`).value;
        const updateButton = document.getElementById(`updateButton${section}`);

        const isMonthValid = monthInput >= 1 && monthInput <= 12;
        const isYearValid = yearInput > 2000;

        if (isMonthValid && isYearValid) {
            updateButton.disabled = false;
        } else {
            updateButton.disabled = true;
        }
    }
</script>

  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    window.addEventListener('callJavascriptFunction', event => {
            // Chame sua função JavaScript diretamente passando os dados
            console.log(event.detail.objectiveProd);
            productSalesChart(event.detail.objectiveProd, event.detail.salesProd);
            ObjetivoFat1(event.detail.objectiveOBJ1, event.detail.salesOBJ1);
            ObjetivoFat2(event.detail.objectiveOBJ2, event.detail.salesOBJ2);
            ObjetivoFat3(event.detail.objectiveOBJ3, event.detail.salesOBJ3);    

        });
    
    });

    function productSalesChart(objective, sales) {
        // const objective = event.detail.objective;
        // const sales = event.detail.sales;
        console.log(objective, sales);
        var objetivo = objective;
        var vendas = sales;
        var diference = objetivo - vendas;

        // Arredondar para as centésimas e trocar ponto por vírgula
        var diferenceForm = diference.toFixed(2).replace('.', ',');
        var objetivoForm = objetivo.toFixed(2).replace('.', ',');
        var vendasForm = vendas.toFixed(2).replace('.', ',');

        var options = {
            title: {
                text: '90 Dias',
                align: 'left'
            },
            series: [diference, vendas], // Alterado para mostrar o restante e as vendas
            chart: {
                height: 310,
                width: 480,
                type: 'donut',
                foreColor: '#999999'
            },
            dataLabels: {
                enabled: false
            },
            fill: {
                type: 'gradient',
            },
            labels: ['Restante', 'Clientes'], // Certificar que a label está correta
            legend: {
                formatter: function (val, opts) {
                    return val + " - " + opts.w.globals.series[opts.seriesIndex];
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 310,
                        width: 300
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#product-sales-chart"), options);
        chart.render();
    }
    
    function ObjetivoFat1(objective, sales) {
                // const objective = event.detail.objective;
                // const sales = event.detail.sales;
                console.log(objective, sales);
                var objetivo = objective;
                var vendas = sales;
                var diference = objetivo - vendas;

                // Arredondar para as centésimas e trocar ponto por vírgula
                var diferenceForm = (diference).toFixed(2).replace('.', ',');
                var objetivoForm = (objetivo).toFixed(2).replace('.', ',');
                var vendasForm = (vendas).toFixed(2).replace('.', ',');
    
                var options = {
                    title: {
                        text: 'Objetivos de Faturação - ' + objetivoForm + '€',
                        align: 'left'
                    },
                    series: [diference, vendas],
                    chart: {
                        height: 310,
                        width: 480,
                        type: 'donut',
                        foreColor: '#999999'
                    },
                    dataLabels: {
                        enabled: false
                    },
                    fill: {
                        type: 'gradient',
                    },
                    labels: ['Restante', 'Vendas'],
                    legend: {
                        formatter: function (val, opts) {
                            return val + " - " + opts.w.globals.series[opts.seriesIndex]+'€';
                        }
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                height: 310,
                                width: 300
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };
    
                var chart = new ApexCharts(document.querySelector("#expenses-chart1"), options);
                chart.render(); // Renderiza o gráfico com os novos dados
    }

    function ObjetivoFat2(objective, sales) {
                // const objective = event.detail.objective;
                // const sales = event.detail.sales;
                console.log(objective, sales);
                var objetivo = objective;
                var vendas = sales;
                var diference = objetivo - vendas;

                // Arredondar para as centésimas e trocar ponto por vírgula
                var diferenceForm = (diference).toFixed(2).replace('.', ',');
                var objetivoForm = (objetivo).toFixed(2).replace('.', ',');
                var vendasForm = (vendas).toFixed(2).replace('.', ',');
    
            var options = {
                    title: {
                        text: 'TOP 500 - ' + objetivo + ' Clientes',
                        align: 'left'
                    },
                    series: [diference, vendas],
                    chart: {
                        height: 310,
                        width: 480,
                        type: 'donut',
                        foreColor: '#999999'
                    },
                    dataLabels: {
                        enabled: false
                    },
                    fill: {
                        type: 'gradient',
                    },
                    labels: ['Restante', 'Clientes'],
                    legend: {
                        formatter: function (val, opts) {
                            return val + " - " + opts.w.globals.series[opts.seriesIndex];
                        }
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                height: 310,
                                width: 300
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };
    
                var chart = new ApexCharts(document.querySelector("#expenses-chart2"), options);
                chart.render(); // Renderiza o gráfico com os novos dados
    }

    function ObjetivoFat3(objective, sales) {
                // const objective = event.detail.objective;
                // const sales = event.detail.sales;
                console.log(objective, sales);
                var objetivo = objective;
                var vendas = sales;
                var diference = objetivo - vendas;

                // Arredondar para as centésimas e trocar ponto por vírgula
                var diferenceForm = (diference).toFixed(2).replace('.', ',');
                var objetivoForm = (objetivo).toFixed(2).replace('.', ',');
                var vendasForm = (vendas).toFixed(2).replace('.', ',');
    
                var options = {
                      title: {
                          text: 'Objetivo Margem - ' + objetivo + '%',
                          align: 'left'
                      },
                      series: [diference, vendas],
                      chart: {
                          height: 310,
                          width: 480,
                          type: 'donut',
                          foreColor: '#999999'
                      },
                      dataLabels: {
                          enabled: false
                      },
                      fill: {
                          type: 'gradient',
                      },
                      labels: ['Diferença', 'Margem Atual'],
                      legend: {
                          formatter: function (val, opts) {
                              return val + " - " + opts.w.globals.series[opts.seriesIndex]+'%';
                          }
                      },
                      responsive: [{
                          breakpoint: 480,
                          options: {
                              chart: {
                                  height: 310,
                                  width: 300
                              },
                              legend: {
                                  position: 'bottom'
                              }
                          }
                      }]
                  };
    
                var chart = new ApexCharts(document.querySelector("#expenses-chart3"), options);
                chart.render(); // Renderiza o gráfico com os novos dados
    }
</script>
@if ($this->INICIO == 1)
@php
    echo "<script>setTimeout(function() {
        const event = new CustomEvent('callJavascriptFunction', {
            detail: {
                objectiveProd: ".session('objectiveProd').",
                salesProd: ".session('salesProd').",
                objectiveOBJ1: ".session('objectiveOBJ1').",
                salesOBJ1: ".session('salesOBJ1').",
                objectiveOBJ2: ".session('objectiveOBJ2').",
                salesOBJ2: ".session('salesOBJ2').",
                objectiveOBJ3: ".session('objectiveOBJ3').",
                salesOBJ3: ".session('salesOBJ3')."
            }
        });
        // Disparar o evento
        window.dispatchEvent(event);
    }, 1000);</script>";

    $this->INICIO == 0;
@endphp  
@endif
</div>
</div>