<div class="tab-pane fade show active">

    <p class="card-text">
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
                            <div class="col-xl-6 col-xs-12 d-flex gap-3">
                                <div class="col-xl-6">
                                    <label for="data-inicial">Data inicial</label>
                                    <input type="date" id="data-inicial" class="form-control" value = "{{ $this->DateIniAnalise }}" wire:change="AlterDateIniAnalise($event.target.value)">
                                </div>
                                <div class="col-xl-6">
                                    <label for="data-final">Data final</label>
                                    <input type="date" id="data-final" class="form-control" value = "{{ $this->DateEndAnalise }}" wire:change="AlterDateEndAnalise($event.target.value)">
                                </div>
                            </div>
                            </div>
                        </div>
                    <div class="card-body">
                        <div id="dataTables_wrapper" class="dataTables_wrapper container" style="margin-left:0px;padding-left:0px;margin-bottom:10px;">
                            {{-- <div class="left">
                                <label>Mostrar
                                    <select name="perPage" wire:model="perPage">
                                        <option value="10"
                                            @if ($perPage == 10) selected @endif>10</option>
                                        <option value="25"
                                            @if ($perPage == 25) selected @endif>25</option>
                                        <option value="50"
                                            @if ($perPage == 50) selected @endif>50</option>
                                        <option value="100"
                                            @if ($perPage == 100) selected @endif>100</option>
                                    </select>
                                    registos
                                </label>
                            </div> --}}
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
                                
                                @if(isset($analisesCliente) && $analisesCliente != null)
                                {{-- @dd($analisesCliente); --}}
                                    @foreach ($analisesCliente as $clt )
                                        <tr>
                                            <td>{{$clt->Familia ?? null}}</td>
                                            <td>{{$clt->Nome ?? null}}</td>
                                            <td>{{$clt->Percentagem ?? null}}%</td>
                                            <td>{{$clt->Total ?? null }}€</td>
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

    </p>

    <p class="card-text">
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
                        <div id="dataTables_wrapper" class="dataTables_wrapper container" style="margin-left:0px;padding-left:0px;margin-bottom:10px;">
                            {{-- <div class="left">
                                <label>Mostrar
                                    <select name="perPage" wire:model="perPage">
                                        <option value="10"
                                            @if ($perPage == 10) selected @endif>10</option>
                                        <option value="25"
                                            @if ($perPage == 25) selected @endif>25</option>
                                        <option value="50"
                                            @if ($perPage == 50) selected @endif>50</option>
                                        <option value="100"
                                            @if ($perPage == 100) selected @endif>100</option>
                                    </select>
                                    registos
                                </label>
                            </div> --}}
                        </div>
                        <div class="table-responsive">
                        <table class="table table-bordered table-hover">
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
        <script>
            document.addEventListener('livewire:load', function () {
                Livewire.on('refreshPage', () => {
                    window.location.reload();
                });
            });
        </script>
        