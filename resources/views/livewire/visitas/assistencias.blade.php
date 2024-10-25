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

    <!-- FIM LOADING -->


    <!-- INICIO TABELA  -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header d-block">
                    <div class="row">
                        <div class="col-xl-8 col-xs-12">
                            <div class="caption uppercase">
                                <i class="ti-stats-up"></i> Assistências
                            </div>
                        </div>

                    </div>

                </div>
                <div class="card-body">
                    <div id="dataTables_wrapper" class="dataTables_wrapper container" style="margin-left:0px;padding-left:0px;margin-bottom:10px;">
                        <div class="left">
                            <label>
                                Mostrar
                                <select name="perPage" wire:model="perPage">
                                    <option value="10" @if ($perPage==10) selected @endif>10</option>
                                    <option value="25" @if ($perPage==25) selected @endif>25</option>
                                    <option value="50" @if ($perPage==50) selected @endif>50</option>
                                    <option value="100" @if ($perPage==100) selected @endif>100
                                    </option>
                                </select>
                                registos
                            </label>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tabela-cliente2">
                            <thead class="thead-light">
                                <tr>
                                    <th>Data</th>
                                    <th>Ocorrência</th>
                                    <th>status</th>
                                    <th>total</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($detailsAssistencias as $details)
                                <tr>
                                    <td>{{ date('Y-m-d', strtotime($details->date))}}</td>
                                    <td>{{ $details->occurrence }}</td>
                                    <td>{{ $details->status }}</td>
                                    <td>{{ number_format($details->total,3) }}€</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" wire:click="detalheAssistencias({{ json_encode($details) }})">
                                            <i class="fas fa-info"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $detailsAssistencias->links() }}

                </div>
            </div>
        </div>

    </div>

    <!-- FIM TABELA  -->


    <!-- MODALS -->
    <div class="modal fade" id="detalheAssistenciasModal" tabindex="-1" role="dialog" aria-labelledby="detalheAssistenciasModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" style="margin: 1.75rem auto;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detalheAssistenciasModalLabel">Detalhes da Assistências</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div style="overflow-x:auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Referencia</th>
                                <th>Descrição</th>
                                <th>Quantidade</th>
                                <th>Preço</th>
                                <th>Desconto</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($detailsLine)
                                @foreach ($detailsLine['lines'] as $prod)
                                    <tr>
                                        <td>{{ $prod['reference'] }}</td>
                                        <td>{{ $prod['description'] }}</td>
                                        <td>{{ $prod['quantity'] }}</td>
                                        <td>{{ number_format($prod['price'], 3) }} €</td>
                                        <td>{{ $prod['discount'] }}</td>
                                        <td>{{ number_format($prod['total'], 3) }} €</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">Não foram encontrados registos para exibir.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>

        document.addEventListener('openDetalheAssistenciasModal', function() {
            $('#detalheAssistenciasModal').modal('show');
        });

        document.addEventListener('DOMContentLoaded', function () {
            window.addEventListener('checkToaster', event => {
            
                $('#detalheAssistenciasModal').modal('hide');
            });
        });
        window.addEventListener('checkToaster', function(e) {
            $('#detalheAssistenciasModal').modal('hide');
        });
    </script>
    

</div>