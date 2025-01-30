
<div>

    
    <!--  LOADING -->
    @if ($showLoaderPrincipal == true)
        <div id="loader" style="display: none;">
            <div class="loader" role="status">

            </div>
        </div>
    @endif

    <!-- FIM LOADING -->

    <!-- TABS  -->

    
    <div class="card card-tabs-pills mb-3">
        <div class="card-header">
            <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                    <a href="#tab6" data-toggle="tab" class="nav-link {{ $tabDetalhesOcorrencias }}">Detalhes</a>
                    
                </li>
                <li class="nav-item">
                    <a href="#tab4" data-toggle="tab" class="nav-link {{ $tabDetail }}">Linhas</a>
                 </li>
            </ul>

            <div class="teste" style="padding-right:35px;">
                <div class="row group-buttons group-buttons d-flex justify-content-end mr-0 mb-2">
                    <div class="tools">
                        {{-- <a href="javascript:void(0);" wire:click="enviarEmail({{ json_encode($proposta) }})" class="btn btn-sm btn-primary"><i class="fas fa-paper-plane"></i> Enviar email</a> --}}
                        <a href="javascript:void(0);" wire:click="goBack" class="btn btn-sm btn-secondary"> Voltar atrás</a>
                    </div>
                </div>
            </div>

        </div>

        <div class="card-body" id="scrollModalBody" style="overflow-y:auto;max-height:70vh;padding-right: 0;">
            <div class="tab-content">
           
                <div class="tab-pane fade {{ $tabDetail }}" id="tab4">
                    <div style="display:flex;align-items: center;">
                        <h4 class="card-title" style="margin-bottom: 0;">{{ $ocorrencia->document }} Nº{{ $ocorrencia->document_number }} - {{ $ocorrencia->customer_name }} </h4>
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
                                                        value="{{ $ocorrencia->customer_name }}" readonly>
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
                                                        value="{{ $ocorrencia->customer_number }}" readonly>
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
                                                        value="{{ $ocorrencia->nif }}" readonly>
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
                                                        value="{{ $ocorrencia->address }}" readonly>
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
                                                        value="{{ $ocorrencia->city }}" readonly>
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
                                                        value="{{ $ocorrencia->zipcode }}" readonly>
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
                                                        value="{{ $ocorrencia->email }}" readonly>
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
                                                        value="{{ $ocorrencia->zone }}" readonly>
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
                                                    <input type="text" class="form-control" value="" readonly>
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
                    <div class="row" style="align-items: center;">   
                        <div class="col-md-12 p-0">
                            <table class="table table-hover init-datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="d-none d-md-table-cell">Referência</th>
                                        <th class="d-none d-md-table-cell">Descrição</th>
                                        <th class="d-none d-md-table-cell">Quantidade</th>
                                        <th class="d-none d-md-table-cell">PVP</th>
                                        <th class="d-none d-md-table-cell">Preço</th>
                                        <th class="d-none d-md-table-cell">Desconto</th>
                                        <th class="d-none d-md-table-cell">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($ocorrencia->lines as $prod)
                                        <tr data-href="#"  style="border-top:1px solid #9696969c!important; border-bottom:1px solid #9696969c!important;">
                                            <td>{{ $prod->reference }}</td>
                                            <td>{{ $prod->description }}</td>
                                            <td>{{ $prod->quantity }}</td>
                                            <td>{{ $prod->pvp }}€</td>
                                            <td>{{ $prod->price }}€</td>
                                            <td>{{ $prod->discount }}% @if($prod->discount2 > 0) + {{$prod->discount2}}% @endif</td>
                                            <td>{{ $prod->total }}€</td>                                        
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" style="border-top:1px solid #232b58!important; border-bottom:1px solid #232b58!important; text-align:center;">Detalhes vazio.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                      </div>
                    </div>
              </div>  
              <div class="tab-pane fade {{ $tabDetalhesOcorrencias }}" id="tab6">                
                <div style="display:flex;align-items: center;">
                    <h4 class="card-title" style="margin-bottom: 0;">{{ $ocorrencia->document }} Nº{{ $ocorrencia->document_number }} - {{ $ocorrencia->customer_name }} </h4>
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
                                                        <span class="input-group-text bg-carolina"><i class="ti-user text-light"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" value="{{ $ocorrencia->customer_name }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>Nº do Cliente</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-carolina"><i class="ti-info-alt text-light"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" value="{{ $ocorrencia->customer_number }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>Nº de Contribuinte</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-carolina"><i class="ti-marker text-light"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" value="{{ $ocorrencia->nif }}" readonly>
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
                                                        <span class="input-group-text bg-carolina"><i class="ti-location-arrow text-light"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" value="{{ $ocorrencia->address }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>Localidade</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-carolina"><i class="ti-location-arrow text-light"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" value="{{ $ocorrencia->city }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>Código Postal</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-carolina"><i class="ti-location-arrow text-light"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" value="{{ $ocorrencia->zipcode }}" readonly>
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
                                                        <span class="input-group-text bg-carolina"><i class="ti-pin text-light"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" value="{{ $ocorrencia->email }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>Zona do Cliente</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-carolina"><i class="ti-pin text-light"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" value="{{ $ocorrencia->zone }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>Condições de pagamento</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-carolina"><i class="ti-credit-card text-light"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" value="" readonly>
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
                <div class="row" style="align-items: center;">   
                    <div class="col-md-12 p-0">
                        <table class="table table-hover init-datatable">
                            <tbody>
                                @forelse ($ocorrencia->details as $prod)
                                    <tr style="border-top:1px solid #9696969c!important; border-bottom:1px solid #9696969c!important;">
                                        <td>
                                            Por quem?
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" value = "{{ $prod->by_whom }}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($prod->collection_date)->format('d/m/Y') }}" readonly>
                                        </td>
                                    </tr>
                                    <tr style="border-top:1px solid #9696969c!important; border-bottom:1px solid #9696969c!important;">
                                        <td>
                                            Recolha de Material?
                                        </td>
                                        <td>
                                            <input type="checkbox" {{ isset($prod->invoice) && $prod->invoice ? 'checked' : '' }} disabled>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($prod->invoice_date)->format('d/m/Y') }}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" value="{{ $prod->invoice_number }}" readonly>
                                        </td>
                                    </tr>
                                    
                                    <tr style="border-top:1px solid #9696969c!important; border-bottom:1px solid #9696969c!important;">
                                        <td>
                                            Guia de transporte?
                                        </td>
                                        <td>
                                            <input type="checkbox" {{ isset($prod->transport_guide) && $prod->transport_guide ? 'checked' : '' }} disabled>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($prod->transport_guide_date)->format('d/m/Y') }}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" value="{{ $prod->transport_guide_number }}" readonly>
                                        </td>
                                    </tr>
            
                                    <tr style="border-top:1px solid #9696969c!important; border-bottom:1px solid #9696969c!important;">
                                        <td>
                                            Encomenda de Cliente?
                                        </td>
                                        <td>
                                            <input type="checkbox" {{ isset($prod->order) && $prod->order ? 'checked' : '' }} disabled>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($prod->order_date)->format('d/m/Y') }}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" value="{{ $prod->order_number }}" readonly>
                                        </td>
                                    </tr>
            
                                    <tr style="border-top:1px solid #9696969c!important; border-bottom:1px solid #9696969c!important;">
                                        <td>
                                            Nota de Crédito?
                                        </td>
                                        <td>
                                            <input type="checkbox" {{ isset($prod->credit_note) && $prod->credit_note ? 'checked' : '' }} disabled>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($prod->credit_note_date)->format('d/m/Y') }}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" value="{{ $prod->credit_note_number }}" readonly>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" style="border-top:1px solid #232b58!important; border-bottom:1px solid #232b58!important; text-align:center;">Detalhes vazio.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
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

        window.addEventListener('openComentario', function(e) {
            $("#modalComentario").modal();
        });

       
        document.addEventListener('livewire:load', function () {
            function moreComments()
            {
                const moreCommentsButton = document.getElementById('toggleMoreComments');
                const lessCommentsButton = document.getElementById('toggleLessComments');
                const additionalComments = document.getElementById('additionalComments');

                
                if (moreCommentsButton && lessCommentsButton && additionalComments) {
                    // Remove existing event listeners by cloning and replacing nodes
                    const newMoreCommentsButton = moreCommentsButton.cloneNode(true);
                    const newLessCommentsButton = lessCommentsButton.cloneNode(true);
                    moreCommentsButton.parentNode.replaceChild(newMoreCommentsButton, moreCommentsButton);
                    lessCommentsButton.parentNode.replaceChild(newLessCommentsButton, lessCommentsButton);

                    // Add event listeners to the new buttons
                    newMoreCommentsButton.addEventListener('click', function () {
                        additionalComments.style.display = 'block';
                        newMoreCommentsButton.classList.add('d-none');
                        newLessCommentsButton.classList.remove('d-none');
                    });

                    newLessCommentsButton.addEventListener('click', function () {
                        additionalComments.style.display = 'none';
                        newLessCommentsButton.classList.add('d-none');
                        newMoreCommentsButton.classList.remove('d-none');
                    });
                }
            }

            moreComments();
            
            Livewire.hook('message.processed', (message, component) => {
                moreComments();
            });
        });

        jQuery(document).ready(function() {
            const url = new URL(window.location.href);
            if (!url.searchParams.has('reloaded')) {
                url.searchParams.append('reloaded', 'true');
                window.location.href = url.href;
            } else {
                jQuery('.checkboxItem').each(function() {
                    jQuery(this).prop('checked', true);
                });
            }
        });
    </script>
    

</div>
