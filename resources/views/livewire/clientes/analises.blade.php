<div>

    <style>
         @media (max-width: 1100px) {
            .btn:not(:disabled):not(.disabled) {
                cursor: pointer;
                font-size: 0.9rem;
                height: auto;
                padding: 0.3rem 0.6rem;
                margin-top: 0.6rem;
            }
        }
        @media (max-width: 680px) {
            .btn:not(:disabled):not(.disabled) {
                cursor: pointer;
                font-size: 0.8rem;
                height: auto;
                padding: 0.3rem 0.5rem;
                margin-top: 0.6rem;
            }

            .col-lg-12 {
                padding-right: 0;
                padding-left: 8px;
            }

            .card-body {

                padding: 0.35rem;
            }

            .main {
                padding-left: 0.3rem !important;
            }

            .table td {
                padding: 0.5rem;
                font-size: 0.8rem;
            }

            .table .thead-light th {
                font-size: 0.9rem;
                padding: 0.5rem;
            }

        }
    </style>
    <!--  LOADING -->

    <div id="loader" style="display: none;">
        <div class="loader" role="status">

        </div>
    </div>

        <!-- INICIO TABELA  -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-header d-block">
                        <div class="row">
                            <div class="col-xl-8 col-xs-12">
                                <div class="caption uppercase">
                                    <i class="ti-stats-up"></i> Análises Por Família
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                                <div class="col-lg-6">
                                    <label class="mt-2">Data inicial</label>
                                    <input type="date" id="data-inicial" class="form-control" value = "{{ $this->DateIniAnalise }}" wire:change="AlterDateIniAnalise($event.target.value)">
                                </div>
                                <div class="col-lg-6">
                                    <label class="mt-2">Data final</label>
                                    <input type="date" id="data-final" class="form-control" value = "{{ $this->DateEndAnalise }}" wire:change="AlterDateEndAnalise($event.target.value)">
                                </div>
                        </div>
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
                                    @foreach ($analisesCliente as $clt )
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
                        {{-- {{ $analisesCliente->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- FIM TABELA  -->

        <!-- INICIO TABELA  -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-header d-block">
                        <div class="row">
                            <div class="col-xl-8 col-xs-12">
                                <div class="caption uppercase">
                                    <i class="ti-stats-up"></i> Análises Anual
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="tabela-cliente2" style = "font-size: 10pt;">
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
        <!-- FIM TABELA  -->
</div>
