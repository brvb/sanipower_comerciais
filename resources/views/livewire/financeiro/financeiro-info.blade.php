
<div>
    @if ($showLoaderPrincipal == true)
        <div id="loader" style="display: none;">
            <div class="loader" role="status">

            </div>
        </div>
    @endif
    
    <div class="card card-tabs-pills mb-3">
        <div class="card-header">
            <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                    <a href="#tab6" data-toggle="tab" class="nav-link {{ $tabDetalhesfinanceiros }}">Artigos</a>
                    
                </li>
              
                <li class="nav-item">
                   <a href="#tab4" data-toggle="tab" class="nav-link {{ $tabDetail }}">Detalhes</a>
                </li>
            </ul>

            <div class="teste" style="padding-right:35px;">
                <div class="row group-buttons group-buttons d-flex justify-content-end mr-0 mb-2">
                    <div class="tools">
                        <a href="javascript:void(0);" wire:click="goBack" class="btn btn-sm btn-secondary"> Voltar atrás</a>
                    </div>
                </div>
            </div>

        </div>

        <div class="card-body" id="scrollModalBody" style="overflow-y:auto;max-height:70vh;padding-right: 0;">
            <div class="tab-content">
                <div class="tab-pane fade {{ $tabDetail }}" id="tab4">
                    <div style="display:flex;align-items: center;">
                        <h4 class="card-title" style="margin-bottom: 0;">{{ $financeiro->document }} - {{ $financeiro->customer_name }} </h4>
                        <button class="btn btn-sm btn-primary text-left" style="margin-left: 10px;margin-right: 10px;" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <i class="fas fa-info"></i>
                        </button>
                    </div>
                    <div class="row ml-0 mr-0 mt-4 d-block">
                        <div class="accordion" id="accordionExample">
                            <div class="card" style="margin-left: 18px;margin-right: 34px;">
                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>Nome do Cliente</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-carolina"><i
                                                                class="ti-user text-light"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                        value="{{ $financeiro->customer_name }}" readonly>
                                                </div>
                                            </div>
                
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>Nº do Cliente</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-carolina"><i
                                                                class="ti-info-alt text-light"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                        value="{{ $financeiro->customer_number }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>Nº de Contribuinte</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-carolina"><i
                                                                class="ti-marker text-light"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                        value="" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row form-group">
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>Morada</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-carolina"><i
                                                                class="ti-location-arrow text-light"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                        value="" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>Localidade</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-carolina"><i
                                                                class="ti-location-arrow text-light"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                        value="" readonly>
                                                </div>
                                            </div>
                
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>Código Postal</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-carolina"><i
                                                                class="ti-location-arrow text-light"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                        value="" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>Email do Cliente</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-carolina"><i
                                                                class="ti-pin text-light"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                        value="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>Zona do Cliente</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-carolina"><i
                                                                class="ti-pin text-light"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                        value="" readonly>
                                                </div>
                                            </div>
                                        </div>
                
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>Condições de pagamento</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-carolina"><i
                                                                class="ti-credit-card text-light"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                        value="" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <br>
                     <div class="card" style="margin-left: 18px; margin-right: 34px;">
                        <div class="row">
                           <div class="col-12" style="margin-left:10px; margin-top:10px;">
                               <h5>Informações Adicionais</h5>
                               <div class="row">
                                   <div class="col-xl-6">
                                       <div class="form-group">
                                           <label>ID</label>
                                           <input type="text" class="form-control" value="{{ $financeiro->id }}" readonly>
                                        </div>
                                    </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                           <label>Data</label>
                                           <input type="text" class="form-control" value="{{ $financeiro->date }}" readonly>
                                        </div>
                                   </div>
                                   <div class="col-xl-6">
                                       <div class="form-group">
                                           <label>Documento</label>
                                           <textarea class="form-control" rows="6" style="resize: none;" readonly>{{ $financeiro->document }}</textarea>
                                       </div>
                                   </div>
                                   <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Nº Documento</label>
                                        <textarea class="form-control" rows="6" style="resize: none;" readonly>{{ $financeiro->document_number }}</textarea>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Total</label>
                                        <textarea class="form-control" rows="6" style="resize: none;" readonly>{{ $financeiro->total }}</textarea>
                                    </div>
                                </div>
                               </div>
                           </div>
                       </div>
                   </div>
                </div>

            <div class="tab-pane fade {{ $tabDetalhesfinanceiros }} m-3" id="tab6" style="border: none;">
                <h4 class="card-title" style="margin-left: 0px;margin-top: -10px;">{{ $financeiro->document }} Nº{{ $financeiro->document_number }} - {{ $financeiro->customer_name }} </h4>
                <div class="row" style="align-items: center;">  
                    <div class="col-md-12 p-0">
                        <table class="table table-hover init-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 11%;">Referência</th>
                                    <th class="d-none d-md-table-cell">Descrição</th>
                                    <th style="text-align: right;width: 0%;">Quantidade</th>
                                    <th style="text-align: right;width: 0%;">Preço</th>
                                    <th style="text-align: right;width: 0%;">Desconto</th>
                                    {{-- <th style="text-align: right;width: 7%;">Iva</th> --}}
                                    <th style="text-align: right;" >Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @forelse ($financeiro->lines as $prod)
                                        <tr data-href="#"  style="border-top:1px solid #9696969c!important; border-bottom:1px solid #9696969c!important;">
                                            <td>{{ $prod->reference }}</td>
                                            <td style="white-space: nowrap;">{{ $prod->description }}</td>
                                            <td style="text-align: right; white-space: nowrap;">{{ $prod->quantity }}</td>
                                            <td class="d-none d-md-table-cell"  style="text-align: right; white-space: nowrap;">{{ number_format($prod->unit_price, 3, ',', '.') }} €</td>
                                            <td style=" text-align: right; white-space: nowrap;">{{ $prod->discount1 }}%@if ($prod->discount2 != "0" && $prod->discount2 != null)+{{ $prod->discount2 }}%@endif</td>
                                            {{-- <td style=" width: 0; text-align: right; white-space: nowrap;">{{ $prod->tax }}%</td> --}}
                                            <td style=" width: 10%; text-align: right; white-space: nowrap;">{{ number_format($prod->total, 3, ',', '.') }} €</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" style="border-top:1px solid #232b58!important; border-bottom:1px solid #232b58!important; text-align:center;">Nenhum encontrado produto na Fatura</td>
                                        </tr>
                                    @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-right" style="border-bottom: none;">
                        <table class="float-right" style="width: 240px; margin-top: 1rem;">
                            <tbody>
                                <tr style="border-bottom: 1px solid #232b58!important;">
                                    <td style="width: 100px; text-align: left;">Total</td>
                                    <td style="width: 140px;" class="bold">{{ number_format($financeiro->total, 3, ',', '.') }} €</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- MODAL -->

    <div class="modal fade" id="modalProposta" tabindex="-1" role="dialog" aria-labelledby="modalProposta" aria-hidden="true" >
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary"><i class="ti-archive"></i> Envio de Email</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="table-responsive" style="overflow-x:none!important;">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Check</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($emailArray != null)
                                           
                                            @foreach ($emailArray as $i => $item)
                                                <tr>
                                                    <td>
                                                        <div class="form-checkbox">
                                                            <label>
                                                                <input type="checkbox" id="emailCheckBox" wire:model.defer="emailSend.{{$i}}">
                                                                <span class="checkmark"><i class="fa fa-check pick"></i></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>{{ $item }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#tab6" id="enviarEmailClientes" wire:click="enviarEmailClientes({{json_encode($financeiro)}})" data-toggle="tab" class="nav-link btn btn-outline-primary">Enviar Email</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="crossorigin="anonymous"></script>
    <script>
        window.addEventListener('reloadPageAfterDelay', () => {
            setTimeout(() => {
                location.reload();
            }, 1500); 
        });

        window.addEventListener('open-modal-adjudicar-proposta', event => {
            $('#confirmAdjudicarModal').modal('show');
        });
       
        window.addEventListener('chooseEmail', function(e) {
            $("#emailCheckBox").prop('checked', false);
            $("#modalProposta").modal();

        });
    </script>
    

</div>
