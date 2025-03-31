<div>
    <!--  LOADING -->

    <div id="loader" style="display: none;">
        <div class="loader" role="status">

        </div>
    </div>

    <!-- FIM LOADING -->

    <!-- TABS  -->
    
    <div class="row group-buttons group-buttons d-flex justify-content-end mr-0 mb-2">
        <div class="col-md-3 col-xs-12">
            <h4>Adicionar Ocorrência</h4>
        </div>
        
        <div class="tools col-md-9 col-xs-12 text-right">
            <a href="javascript:void(0);" wire:click="salvarOcorrencia" id="saveButton" class="btn btn-sm btn-primary" disabled><i class="ti-save"></i> Gravar</a>           
           
            <a href="javascript:void(0);" wire:click="voltarAtras" class="btn btn-sm btn-secondary" > Voltar atrás</a>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const input = document.getElementById("selectedInvoicesInput");
            const button = document.getElementById("saveButton");
    
            function toggleButton() {
                button.disabled = !input.value.trim(); // Desativa se estiver vazio, ativa se tiver valor
            }
    
            // Observer para detectar mudanças no atributo 'value' do input
            const observer = new MutationObserver(toggleButton);
            observer.observe(input, { attributes: true, attributeFilter: ["value"] });
    
            // Chama a função no início para garantir o estado correto do botão
            toggleButton();
        });
    </script>

    <div class="card card-tabs-pills mb-3">
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane fade {{$tabDetail}}" id="tab4">
                    <div style="display:flex;align-items: center;">


                    <h4 class="card-title" style="margin-bottom: 0;">{{$detalhesCliente->name}}</h4>
                        <button class="btn btn-sm btn-primary text-left" style="margin-left: 10px;margin-right: 10px;" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <i class="fas fa-info"></i>
                        </button>
                     
                    </div>
                     <div class="row ml-0 mr-0 mt-4 d-block">

                        <div class="accordion" id="accordionExample">
                            <div class="card" style="margin-left: 18px;margin-right: 34px;">
                           
                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne">
                                <div class="card-body">

                        <!--  INICIO DOS DETALHES   -->

                        <div class="row form-group">
                            <div class="col-xl-4">

                                <div class="form-group">
                                    <label>Nome do Cliente</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-carolina"><i class="ti-user text-light"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$detalhesCliente->name}}" readonly>
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
                                        <input type="text" class="form-control" value="{{$detalhesCliente->no}}" readonly>
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
                                        <input type="text" class="form-control" value="{{$detalhesCliente->nif}}" readonly>
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
                                        <input type="text" class="form-control" value="{{$detalhesCliente->address}}" readonly>
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
                                        <input type="text" class="form-control" value="{{$detalhesCliente->city}}" readonly>
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
                                        <input type="text" class="form-control" value="{{$detalhesCliente->zipcode}}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-xl-4">

                                <div class="form-group">
                                    <label>Zona do Cliente</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-carolina"><i class="ti-pin text-light"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$detalhesCliente->zone}}" readonly>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-4">

                                <div class="form-group">
                                    <label>Contactos</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-carolina"><i class="ti-email text-light"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$detalhesCliente->phone}}" readonly>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-4">

                                <div class="form-group">
                                    <label>Nº Propostas em aberto</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-carolina"><i class="ti-comment text-light"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$detalhesCliente->open_proposals}}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-xl-4">

                                <div class="form-group">
                                    <label>Nº Ocorrências em aberto</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-carolina"><i class="ti-light-bulb text-light"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$detalhesCliente->open_occurrences}}" readonly>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-4">

                                <div class="form-group">
                                    <label>Saldo em Aberto</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-carolina"><i class="ti-money text-light"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{ number_format($detalhesCliente->current_account,3)}}" readonly>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-4">

                                <div class="form-group">
                                    <label>Cheques em carteira</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-carolina"><i class="ti-bag text-light"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$detalhesCliente->balance_checks}}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-xl-4">

                                <div class="form-group">
                                    <label>Pontos</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-carolina"><i class="ti-stats-up text-light"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$detalhesCliente->balance_points}}" readonly>
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
                                        <input type="text" class="form-control" value="{{$detalhesCliente->payment_conditions}}" readonly>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!--  FIM DETALHES   -->
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                
                

                    <p class="card-text">

                        <!-- INICIO RELATORIO  -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card mb-3">
                                    <div class="card-header d-block">
                                        <div class="row">
                                            <div class="col-xl-8 col-xs-12">
                                                <div class="caption uppercase">
                                                    <i class="ti-files"></i> Relatório
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="card-body">

                                        {{-- <div class="form-group">
                                            <label>Motivo</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-carolina"><i class="ti-clip text-light"></i></span>
                                                </div>
                                                <input type="text" class="form-control" value="" wire:model.defer="assunto">
                                            </div>
                                        </div> --}}

                                        <div class="form-group">
                                            <label>Descrição</label>
                                            <div class="input-group">
                                                <textarea type="text" class="form-control" cols="4" rows="6" style="resize: none;" wire:model.defer="relatorio"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Anexos</label>
                                            <div class="input-group mb-3">
                                                <label class="input-group-text btn" for="inputGroupFile02">Upload</label>
                                                <input 
                                                    type="file" 
                                                    class="form-control" 
                                                    id="inputGroupFile02" 
                                                    wire:model="anexos" 
                                                    style="display:none;" 
                                                    multiple
                                                    onchange="validateFileSize()">
                                            </div>
                                            <script>
                                                function validateFileSize() {
                                                    const maxFileSize = 10 * 1024 * 1024;
                                                     const input = document.getElementById('inputGroupFile02');
                                         
                                                     for (const file of input.files) {
                                                         if (file.size > maxFileSize) {
                                                             const message = `O arquivo ${file.name} excede o tamanho máximo permitido de 10MB.`;
                                                         
                                                             toastr.warning(message);
                                                             input.value = '';
                                                             return;
                                                         }
                                                     }
                                                 }
                                            </script>
                                            @if(Session::has('OcorrenciasAnexos'))
                                                <div class="mt-3">
                                                    <ul style=" list-style-type: none; margin:0;padding: 0;">
                                                        @foreach(Session::get('OcorrenciasAnexos') as $file)
                                                        <li>
                                                            @if(isset($file['path']))
                                                                <button wire:click="removeAnexo('{{ $file['path'] }}')" class="btn btn-danger btn-sm">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                                <a href="{{ asset('storage/' . $file['path']) }}" download="{{ $file['original_name'] }}">
                                                                    {{ $file['original_name'] }}
                                                                </a>
                                                            @else
                                                                @php
                                                                    $filename = strstr($file, '/');
                                                                    $filename = ltrim($filename, '/');
                                                                    $filenameSee = strstr($file, '&');
                                                                    $filenameSee = ltrim($filenameSee, '&');
                                                                @endphp
                                                                <button wire:click="removeAnexo('{{ $file }}')" class="btn btn-danger btn-sm">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                                <a href="{{ asset('storage/anexos/' . $filename) }}" download="{{ $filenameSee }}">
                                                                    {{ $filenameSee }}
                                                                </a>
                                                            @endif
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label>Tipo</label>
                                            <div class="input-group">
                                                <select class="form-control" id="tipoVisitaSelect1" wire:model.defer="tipoOcorrenciaSelect1">
                                                    <option value="0">Selecione o Tipo da Ocorrência</option>
                                                    <option value="1">Erro de Sanipower</option>
                                                    <option value="2">Erro de Cliente</option>
                                                    <option value="3">Produto não conforme</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Tipo 2</label>
                                            <div class="input-group">
                                                <select class="form-control" id="tipoVisitaSelect2" wire:model.defer="tipoOcorrenciaSelect2">
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function () {
                                                const tipo1 = document.getElementById("tipoVisitaSelect1");
                                                const tipo2 = document.getElementById("tipoVisitaSelect2");
                                            
                                                const optionsMap = {
                                                    "1": [
                                                        { value: "Erro Preparação", text: "Erro Preparação" },
                                                        { value: "Produto Errado", text: "Produto Errado" },
                                                        { value: "Não Entrega de Material", text: "Não Entrega de Material" },
                                                        { value: "Acordo Comercial", text: "Acordo Comercial" },
                                                        { value: "Facturação", text: "Facturação" },
                                                        { value: "Entregue Duplicado", text: "Entregue Duplicado" }
                                                    ],
                                                    "2": [
                                                        { value: "Erro Cliente", text: "Erro Cliente" },
                                                        { value: "Fora de Garantia", text: "Fora de Garantia" }
                                                    ],
                                                    "3": [
                                                        { value: "Produto Não Conforme", text: "Produto Não Conforme" }
                                                    ]
                                                };
                                            
                                                tipo1.addEventListener("change", function () {
                                                    const selectedValue = this.value;
                                            
                                                    tipo2.innerHTML = "";
                                            
                                                
                                                    if (optionsMap[selectedValue]) {
                                                        optionsMap[selectedValue].forEach(option => {
                                                            let newOption = document.createElement("option");
                                                            newOption.value = option.value;
                                                            newOption.textContent = option.text;
                                                            tipo2.appendChild(newOption);
                                                        });
                                                    } else {
                                                    
                                                        let defaultOption = document.createElement("option");
                                                        defaultOption.value = "0";
                                                        defaultOption.textContent = "Selecione uma opção válida";
                                                        tipo2.appendChild(defaultOption);
                                                    }
                                                });
                                            
                                                tipo1.dispatchEvent(new Event("change"));
                                            });
                                            </script>
                                        <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#invoiceModal">
                                            Selecionar Faturas
                                        </button>
                                        <style>
                                            .modal-custom {
                                                max-width: 90vw !important;
                                            }
                                        </style>
                                        <style>
                                            @media (max-width: 1200px) {
                                                .modal-dialog {
                                                    max-width: 95% !important;
                                                }
                                                .modal-body {
                                                    display: flex;
                                                    flex-wrap: nowrap;
                                                    overflow-x: auto;
                                                    max-height: 70vh;
                                                }
                                                .modal-body > div {
                                                    min-width: 50%;
                                                    flex: 1;
                                                    padding: 5px;
                                                    overflow-x: auto;
                                                }
                                                .table-responsive {
                                                    overflow-x: auto;
                                                }
                                            }
                                        </style>
                                        
                                        <div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-custom modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="invoiceModalLabel">Selecionar Faturas</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <button type="button" class="btn btn-success" id="confirmSelection">Confirmar Seleção</button>
                                                    <div class="modal-body d-flex">
                                                        <!-- Tabela de Faturas -->
                                                        <div class="pr-2">
                                                            <h6>Faturas</h6>
                                                            <input type="text" id="filterInput" class="form-control mb-2" placeholder="Filtrar por Nº. Doc.">
                                                            <label>
                                                                <input type="checkbox" id="endCustomerFilter" checked> Consumidor final?
                                                            </label>
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Nº. Doc.</th>
                                                                            <th>Documento</th>
                                                                            <th>Cliente</th>
                                                                            <th>Data</th>
                                                                            <th>Total</th>
                                                                            <th>Ação</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="invoiceTableBody">
                                                                        @foreach($invoices as $invoice)
                                                                            @php
                                                                                $invoice = (object) $invoice;
                                                                            @endphp
                                                                            <tr>
                                                                                <td class="document-number">{{ $invoice->document_number }}</td>
                                                                                <td>{{ $invoice->document }}</td>
                                                                                <td>{{ $invoice->customer_name }}</td>
                                                                                <td>{{ \Carbon\Carbon::parse($invoice->date ?? null)->format('d/m/Y') }}</td>
                                                                                <td>{{ number_format($invoice->total, 2, ',', '.') }}</td>
                                                                                <td>
                                                                                    <button class="btn btn-sm btn-primary select-invoice" 
                                                                                        data-invoice="{{ json_encode($invoice) }}">
                                                                                        Selecionar
                                                                                    </button>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    
                                                        <!-- Tabela de Linhas da Fatura Selecionada -->
                                                        <div class="pl-2">
                                                            <h6>Linhas da Fatura</h6>
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Referência</th>
                                                                            <th>Descrição</th>
                                                                            <th>Quantidade</th>
                                                                            <th>Ação</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="invoice-lines">
                                                                        <!-- Linhas serão carregadas aqui -->
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" id="selectedInvoicesInput" name="selected_invoices" wire:model.defer="selectedInvoicesJson">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div id="toaster" class="toast" style="position: absolute; top: 20px; right: 20px; z-index: 1000; display: none; background-color: #28a745; color: white; padding: 10px; border-radius: 5px;">
                                            Seleção registrada com sucesso! ✅
                                        </div>

                                        <script>
                                            document.getElementById('endCustomerFilter').addEventListener('change', function () {
                                                let showEndCustomers = this.checked; 
                                                let rows = document.querySelectorAll('#invoiceTableBody tr');
                                            
                                                rows.forEach(row => {
                                                    let invoiceData = JSON.parse(row.querySelector('.select-invoice').getAttribute('data-invoice'));
                                                    // console.log(invoiceData);
                                                    let isEndCustomer = invoiceData.end_customer; 
                                            
                                                    row.style.display = (showEndCustomers === isEndCustomer) ? '' : 'none';
                                                });
                                            });
                                            </script>

                                        <script>
                                            document.getElementById('filterInput').addEventListener('input', function () {
                                                let filter = this.value.trim();
                                                let rows = document.querySelectorAll('#invoiceTableBody tr');
                                        
                                                rows.forEach(row => {
                                                    let documentNumber = row.querySelector('.document-number').textContent.trim();
                                                    row.style.display = (documentNumber === filter || filter === '') ? '' : 'none';
                                                });
                                            });
                                        
                                            document.addEventListener("DOMContentLoaded", function () {
                                                let selectedInvoice = null;
                                                let selectedLines = [];
                                        
                                                document.querySelectorAll(".select-invoice").forEach(button => {
                                                    button.addEventListener("click", function () {
                                                        const invoice = JSON.parse(this.getAttribute("data-invoice"));
                                                        const linesContainer = document.getElementById("invoice-lines");
                                                        
                                                        selectedLines = [];
                                        
                                                        document.querySelectorAll(".select-line").forEach(lineButton => {
                                                            lineButton.classList.remove("btn-danger");
                                                            lineButton.classList.add("btn-success");
                                                            lineButton.textContent = "Selecionar";
                                                        });
                                        
                                                        selectedInvoice = invoice;
                                        
                                                        document.querySelectorAll(".select-invoice").forEach(btn => {
                                                            btn.classList.remove("btn-warning");
                                                            btn.textContent = "Selecionar";
                                                        });
                                        
                                                        this.classList.add("btn-warning");
                                                        this.textContent = "Selecionado ✅";
                                        
                                                        linesContainer.innerHTML = "";
                                                        invoice.lines.forEach(line => {
                                                            let row = document.createElement("tr");
                                                            row.innerHTML = `
                                                                <td>${line.reference}</td>
                                                                <td>${line.description}</td>
                                                                <td>${line.quantity}</td>
                                                                <td>
                                                                    <button class="btn btn-sm btn-success select-line" data-line='${JSON.stringify(line)}'>
                                                                        Selecionar
                                                                    </button>
                                                                </td>
                                                            `;
                                        
                                                            linesContainer.appendChild(row);
                                                        });
                                        
                                                        document.querySelectorAll(".select-line").forEach(lineButton => {
                                                            lineButton.addEventListener("click", function () {
                                                                const lineData = JSON.parse(this.getAttribute("data-line"));
                                        
                                                                const index = selectedLines.findIndex(l => l.id === lineData.id);
                                                                if (index === -1) {
                                                                    selectedLines.push(lineData);
                                                                    this.textContent = "Remover";
                                                                    this.classList.remove("btn-success");
                                                                    this.classList.add("btn-danger");
                                                                } else {
                                                                    selectedLines.splice(index, 1);
                                                                    this.textContent = "Selecionar";
                                                                    this.classList.remove("btn-danger");
                                                                    this.classList.add("btn-success");
                                                                }
                                                            });
                                                        });
                                                    });
                                                });
                                        
                                                document.getElementById("confirmSelection").addEventListener("click", function () {
                                                    let hiddenInput = document.getElementById("selectedInvoicesInput");
                                        
                                                    if (!selectedInvoice) {
                                                        alert("Por favor, selecione uma fatura principal antes de confirmar.");
                                                        return;
                                                    }
                                        
                                                    let selectedData = {
                                                        invoice: selectedInvoice,
                                                        lines: selectedLines
                                                    };
                                        
                                                    hiddenInput.value = JSON.stringify(selectedData);
                                                    hiddenInput.dispatchEvent(new Event('input'));
                                        
                                                    $("#invoiceModal").modal("hide");
                                        
                                                    let toaster = document.getElementById("toaster");
                                                    toaster.style.display = "block";
                                        
                                                    setTimeout(() => {
                                                        toaster.style.display = "none";
                                                    }, 3000);
                                                });
                                        
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
