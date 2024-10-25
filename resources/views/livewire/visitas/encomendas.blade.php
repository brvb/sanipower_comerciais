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

    

    <!-- FIM LOADING -->


    <!-- INICIO TABELA  -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header d-block">
                    <div class="row">
                        <div class="col-xl-8 col-xs-12">
                            <div class="caption uppercase">
                                <i class="ti-stats-up"></i> Encomendas
                            </div>
                        </div>

                    </div>

                </div>
                <div class="card-body">

                    <div class="row mb-2">
                        <div class="col-lg-4">
                            <label class="mt-2">Estado Encomenda</label>
                                <div class="input-group">
                                    <select name="perPage" wire:model.lazy="estadoEncomenda" class="form-control">
                                        <option value="0" selected>Todas</option>
                                        <option value="1">Com comentário</option>
                                        <option value="2">Sem comentário</option>
                                    </select>
                                </div>
                        </div>
                    </div>

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
                                    <th>Encomenda</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Ações</th>
                                    {{-- <th>Detalhe Encomenda</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detalhesEncomenda as $detalhe)
                                <tr>
                                    <td>{{ date('Y-m-d', strtotime($detalhe->date)) }}</td>
                                    <td>{{ $detalhe->order }}</td>
                                    <td>{{ number_format($detalhe->total,3) }}€</td>
                                    <td>{{ $detalhe->status }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" wire:click="detalheEncomendaModal({{ json_encode($detalhe) }})">
                                            <i class="ti ti-plus"></i> Ver Encomenda
                                        </button>
                                        {{-- <button type="button" class="btn btn-primary" wire:click="verComentario({{ json_encode($detalhe->id) }})">
                                            Comentários
                                        </button> --}}
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                        {{ $detalhesEncomenda->links() }}
                    <hr/>
                    <div class="form-group">
                        <div class="col-xs-12 col-xl-4">
                            <label>Comentário</label>
                            <div class="input-group">
                                <textarea type="text" class="form-control" cols="4" rows="6" style="resize: none;" wire:model.lazy="comentario_encomendas" @if(isset($checkStatus)) @if($checkStatus == "1") readonly @endif @endif></textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- FIM TABELA  -->


    <!-- MODALS -->

    <div class="modal fade" id="modalComentario" tabindex="-1" role="dialog" aria-labelledby="modalComentario" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="modalComentario">Encomenda {{ $encomendaName }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="scrollModal" style="overflow-y: auto;max-height:500px;">
                    <div class="card mb-3">
                        <div class="card-body">
                            <label>Comentário</label>
                            <div class="input-group">
                                <textarea type="text" class="form-control" cols="4" rows="6" style="resize: none;" wire:model.defer="comentarioEncomenda"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-outline-primary" wire:click="sendComentario({{ json_encode($encomendaID) }})">Adicionar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalVerComentario" tabindex="-1" role="dialog" aria-labelledby="modalVerComentarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalVerComentarioLabel">Comentários</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="timeline-wrapper">
                        @isset($comentario)
                        @foreach ($comentario as $comentarios)
                        <div class="timeline-item" data-date="{{ $comentarios->created_at }} &#8594; {{ $comentarios->user->name }}">
                            <p>{{ $comentarios->comentario }}</p>
                        </div>
                        @endforeach
                        @endisset
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="detalheEncomendaModal" tabindex="-1" role="dialog" aria-labelledby="detalheEncomendaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered" style="margin: 1.75rem auto;" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detalheEncomendaModalLabel">Detalhes da Encomenda</h5>
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
                                    {{-- <th>Desconto 2</th> --}}
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($detalhesEncomenda)
                                @foreach ($detalhesEncomenda as $enc)
                                    @if($enc->id == $encomendaID)
                                        @foreach ($enc->lines as $line)
                                            <tr>
                                                <td>{{ $line->reference }}</td>
                                                <td>{{ $line->description }}</td>
                                                <td style="text-align:center">{{ $line->quantity }}</td>
                                                <td style="text-align:center">{{ number_format($line->price, 3) }} €</td>
                                                <td style="text-align:center">{{ $line->discount }}</td>
                                                {{-- <td style="text-align:center">{{ $line->discount2 }}</td> --}}
                                                <td style="text-align:center">{{ number_format($line->total, 3) }} €</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                                @endisset
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="card-body" style="margin-left:15px;margin-right:15px;">
                                <hr>
                                <h5>Adicionar Comentário</h5>
                                <div class="input-group">
                                    <textarea type="text" class="form-control" cols="4" rows="6" style="resize: none;" wire:model.defer="comentarioEncomenda"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-success" wire:click="sendComentario({{ json_encode($encomendaID) }})">Adicionar Comentário</button>
                        <button type="button" class="btn btn-outline-primary" wire:click="gerarPdfEncomenda({{ json_encode($encomendaID)}}, {{ json_encode($detalhesEncomenda)}})">Gerar PDF</button>
                        <button type="button" class="btn btn-outline-primary" wire:click="enviarEmail({{ json_encode($detalhesEncomenda) }},{{json_encode($encomendaID)}})" class="btn btn-sm btn-primary">Enviar email</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="cursor:pointer">Fechar</button>
                    </div>
                </div>
            </div>
        </div>


<!----->
<script>
    document.addEventListener('livewire:load', function() {
        Livewire.hook('message.sent', () => {
            document.getElementById('loader').style.display = 'block';
        });

        // Oculta o loader quando o Livewire terminar de carregar
        Livewire.hook('message.processed', () => {
            document.getElementById('loader').style.display = 'none';
        });
    });


    document.addEventListener('abrirModalVerComentario', function() {
        $('#modalVerComentario').modal('show');
    });

    document.addEventListener('openDetalheEncomendaModal', function() {
        $('#detalheEncomendaModal').modal('show');
    });
    
    document.addEventListener('DOMContentLoaded', function () {
        window.addEventListener('checkToaster', event => {
            $('#detalheEncomendaModal').modal('hide');
        });
    });
   
</script>

</div>