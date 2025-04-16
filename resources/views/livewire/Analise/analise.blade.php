<style>
    @media (max-width: 1200px) {
        .font-menor {
            font-size: 7pt;
        }
    }

    @media (max-width: 900px) {
        .font-menor {
            font-size: 6pt;
        }
    }

    .table-wrapper {
        width: 100% !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important; 
    }

    .table-responsive table {
        width: 100% !important;
        min-width: 900px !important;
        white-space: nowrap !important;
    }
</style>

<div class="tab-pane fade show active">
    <p class="card-text">
        <div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header d-block">
                            <div class="row">
                                <div class="col-lg-8 col-md-12">
                                    <div class="caption uppercase">
                                    <i class="ti-stats-up"></i> Análise de Vendas por Cliente
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filtro de data -->
                        @php
                            $DataInicial = $_GET['dataInicio'] ?? now()->subDays(30)->format('Y-m-d');
                            $DataFinal = $_GET['dataFim'] ?? now()->format('Y-m-d');
                        @endphp
                    
                        <div class="row mb-1">
                            <form class="w-100 d-flex align-items-end justify-content-start flex-wrap gap-3">
                                <div class="form-group me-3">
                                    <label for="dataInicio">Data Inicial</label>
                                    <input type="date" class="form-control" id="dataInicio" name="dataInicio" value="{{ $DataInicial }}"  wire:model.defer="dataInicio">
                                </div>
                                
                                <div class="form-group me-3">
                                    <label for="dataFim">Data Final</label>
                                    <input type="date" class="form-control" id="dataFim" name="dataFim" value="{{ $DataFinal }}"  wire:model.defer="dataFim">
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" wire:click.prevent="carregarClientes">
                                        Filtrar
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Tabela de clientes -->
                        <div class="table-wrapper">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="tabela-cliente3">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Número</th>
                                            <th>Cliente</th>
                                            <th style="text-align:right;">Vendas (€)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $clientes1 = session('clientes'); @endphp
                                        @if(!isset($clientes1->Message))
                                            @foreach (session('clientes') as $cliente)
                                                <tr>
                                                    <td>{{ $cliente->number ?? null }}</td>
                                                    <td>{{ $cliente->name ?? null }}</td>
                                                    <td class="font-weight-bold text-right">{{ number_format($cliente->sales ?? null, 2, ',', '.') }}€</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>                        
                            </div>
                        </div>
                    </div>
                </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header d-block">
                            <div class="row">
                                <div class="col-lg-8 col-md-12">
                                    <div class="caption uppercase">
                                        <i class="ti-stats-up"></i> Análises Por Família
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-6 col-12">
                                    <label class="mt-2">Data inicial</label>
                                    <input type="date" id="data-inicial" class="form-control" value="{{ $this->DateIniAnalise }}">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="mt-2">Data final</label>
                                    <input type="date" id="data-final" class="form-control" value="{{ $this->DateEndAnalise }}">
                                </div>
                            </div>
                            <div class="table-wrapper">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="tabela-cliente2">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Familia</th>
                                                <th>Nome</th>
                                                <th>Percentagem</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($analisesCliente != null)
                                                @foreach ($analisesCliente as $clt)
                                                    <tr>
                                                        <td>{{$clt->Familia}}</td>
                                                        <td>{{$clt->Nome}}</td>
                                                        <td>{{$clt->Percentagem}}%</td>
                                                        <td>{{$clt->Total }}€</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- {{ $analisesCliente->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tabela Anual -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header d-block">
                            <div class="row">
                                <div class="col-lg-8 col-md-12">
                                    <div class="caption uppercase">
                                        <i class="ti-stats-up"></i> Análises Anual
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-wrapper">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover font-menor" id="tabela-cliente2">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Ano</th>
                                                <th>Janeiro</th>
                                                <th>Fevereiro</th>
                                                <th>Março</th>
                                                <th>Abril</th>
                                                <th>Maio</th>
                                                <th>Junho</th>
                                                <th>Julho</th>
                                                <th>Agosto</th>
                                                <th>Setembro</th>
                                                <th>Outubro</th>
                                                <th>Novembro</th>
                                                <th>Dezembro</th>
                                                <th>Total (€)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($vendasAnuais))
                                                @foreach ($vendasAnuais as $venda)
                                                    <tr>
                                                        <td><b>{{ str_replace('Vendas de ', '', $venda->Descricao ?? '') }}</b></td>
                                                        <td>{{ number_format($venda->Janeiro ?? 0, 2, ',', '.') }}</td>
                                                        <td>{{ number_format($venda->Fevereiro ?? 0, 2, ',', '.') }}</td>
                                                        <td>{{ number_format($venda->Marco ?? 0, 2, ',', '.') }}</td>
                                                        <td>{{ number_format($venda->Abril ?? 0, 2, ',', '.') }}</td>
                                                        <td>{{ number_format($venda->Maio ?? 0, 2, ',', '.') }}</td>
                                                        <td>{{ number_format($venda->Junho ?? 0, 2, ',', '.') }}</td>
                                                        <td>{{ number_format($venda->Julho ?? 0, 2, ',', '.') }}</td>
                                                        <td>{{ number_format($venda->Agosto ?? 0, 2, ',', '.') }}</td>
                                                        <td>{{ number_format($venda->Setembro ?? 0, 2, ',', '.') }}</td>
                                                        <td>{{ number_format($venda->Outubro ?? 0, 2, ',', '.') }}</td>
                                                        <td>{{ number_format($venda->Novembro ?? 0, 2, ',', '.') }}</td>
                                                        <td>{{ number_format($venda->Dezembro ?? 0, 2, ',', '.') }}</td>
                                                        <td class="font-weight-bold">{{ number_format($venda->Total ?? 0, 2, ',', '.') }}€</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>                        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <style>
            .range-container {
                width: 300px;
                position: relative;
                margin: 40px auto;
            }
            
            .slider {
                width: 100%;
                position: absolute;
                pointer-events: none;
                height: 4px;
                top: 18px;
                background: #000;
                border-radius: 2px;
            }
            
            input[type=range] {
                pointer-events: auto;
                -webkit-appearance: none;
                position: absolute;
                width: 100%;
                height: 4px;
                background: transparent;
            }
            
            input[type=range]::-webkit-slider-thumb {
                -webkit-appearance: none;
                height: 20px;
                width: 20px;
                border-radius: 50%;
                background: #000;
                cursor: pointer;
                margin-top: -8px;
                position: relative;
                z-index: 2;
            }
            
            .date-labels {
                display: flex;
                justify-content: space-between;
                margin-top: 40px;
                font-weight: bold;
            }
            </style>
        </div>
    </p>
</div>
</div>
<script>
    const startInput = document.getElementById('rangeStart');
    const endInput = document.getElementById('rangeEnd');

    const startDateLabel = document.getElementById('startDateLabel');
    const endDateLabel = document.getElementById('endDateLabel');

    const hiddenStartDate = document.getElementById('hiddenStartDate');
    const hiddenEndDate = document.getElementById('hiddenEndDate');

    function formatDate(date) {
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${month}-${day}-${year}`;
    }

    const startDate = new Date('2008-01-01');
    const endDate = new Date();
    const dates = [];
    let current = new Date(startDate);
    while (current <= endDate) {
        dates.push(formatDate(current));
        current.setDate(current.getDate() + 1);
    }

    // Encontra o índice da data padrão recebida do PHP
    const defaultStartDate = startInput.dataset.defaultDate;
    const defaultEndDate = endInput.dataset.defaultDate;

    const startIndex = dates.indexOf(defaultStartDate);
    const endIndex = dates.indexOf(defaultEndDate);

    // Define os limites e os valores iniciais dos sliders
    startInput.min = 0;
    endInput.min = 0;
    startInput.max = dates.length - 1;
    endInput.max = dates.length - 1;

    startInput.value = startIndex !== -1 ? startIndex : 0;
    endInput.value = endIndex !== -1 ? endIndex : dates.length - 1;

    function updateLabels() {
        const startVal = Math.min(parseInt(startInput.value), parseInt(endInput.value));
        const endVal = Math.max(parseInt(startInput.value), parseInt(endInput.value));
        const startDateStr = dates[startVal];
        const endDateStr = dates[endVal];

        startDateLabel.textContent = startDateStr;
        endDateLabel.textContent = endDateStr;

        hiddenStartDate.value = startDateStr;
        hiddenEndDate.value = endDateStr;
    }

    startInput.addEventListener('input', updateLabels);
    endInput.addEventListener('input', updateLabels);

    updateLabels();
</script>


<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('refreshPage', () => {
            window.location.reload();
        });
    });
</script>
