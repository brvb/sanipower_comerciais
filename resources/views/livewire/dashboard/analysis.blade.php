<div>
<div>
<div class="row" style="margin-left: 10px;">
    @if ($this->show90dias == true)
    <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="card mb-3">
            <div class="card-body">
                <label for="monthInput">Mês:</label>
                <input type="number" id="monthInput90" min="1" max="12" value="" wire:model.defer="Month" oninput = "validateInputs(90)" />
                
                <label for="yearInput">Ano:</label>
                <input type="number" id="yearInput90" min="2000" value="" wire:model.defer="Year" oninput = "validateInputs(90)" />

                <button class="btn btn-sm btn-primary" wire:click="updateDateproductSalesChart()" id="updateButton90"> 
                    <i class="ti-reload"></i><span> Atualizar</span>
                </button>
                <br>
            <div id="product-sales-chart"></div>
        </div>
        </div>
    </div>
    @endif
    @if ($this->showObjFat == true)
    <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="card mb-3">
            <div class="card-body">
                <label for="monthInput">Mês:</label>
                <input type="number" id="monthInputObjFat" min="1" max="12" value="" wire:model.defer="Month1" oninput = "validateInputs('ObjFat')" />
                
                <label for="yearInput">Ano:</label>
                <input type="number" id="yearInputObjFat" min="2000" value="" wire:model.defer="Year1" oninput = "validateInputs('ObjFat')" />

                <button class="btn btn-sm btn-primary" wire:click="updateDateObjetivoFat1()" id="updateButtonObjFat"> 
                    <i class="ti-reload"></i><span> Atualizar</span>
                </button>
                <br>
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
                <label for="monthInput">Mês:</label>
                <input type="number" id="monthInputTop500" min="1" max="12" value="" wire:model.defer="Month2" oninput = "validateInputs('Top500')" />
                
                <label for="yearInput">Ano:</label>
                <input type="number" id="yearInputTop500" min="2000" value="" wire:model.defer="Year2" oninput = "validateInputs('Top500')" />

                <button class="btn btn-sm btn-primary" wire:click="updateDateObjetivoFat2()" id="updateButtonTop500"> 
                    <i class="ti-reload"></i><span> Atualizar</span>
                </button>
                <br>
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
                <label for="monthInput">Mês:</label>
                <input type="number" id="monthInputObjMargin" min="1" max="12" value="" wire:model.defer="Month3" oninput = "validateInputs('ObjMargin')" />
                
                <label for="yearInput">Ano:</label>
                <input type="number" id="yearInputObjMargin" min="2000" value="" wire:model.defer="Year3" oninput = "validateInputs('ObjMargin')" />

                <button class="btn btn-sm btn-primary" wire:click="updateDateObjetivoFat3()" id="updateButtonObjMargin"> 
                    <i class="ti-reload"></i><span> Atualizar</span>
                </button>
                <br>
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