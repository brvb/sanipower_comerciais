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
                                        <i class="ti-stats-up"></i> Análises Por Família
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-6 col-12">
                                    <label class="mt-2">Data inicial</label>
                                    <input type="date" id="data-inicial" class="form-control" value="{{ $this->DateIniAnalise }}" wire:change="AlterDateIniAnalise($event.target.value)">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="mt-2">Data final</label>
                                    <input type="date" id="data-final" class="form-control" value="{{ $this->DateEndAnalise }}" wire:change="AlterDateEndAnalise($event.target.value)">
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
    </p>
</div>
</div>
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('refreshPage', () => {
            window.location.reload();
        });
    });
</script>
