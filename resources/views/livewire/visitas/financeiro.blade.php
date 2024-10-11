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
                                <i class="ti-stats-up"></i> Financeiro
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
                                    <th>Documento</th>
                                    <th>NºDoc</th>
                                    <th>Observação</th>
                                    <th>Emissão</th>
                                    <th>Vencimento</th>
                                    <th>Não regularizado</th>
                                    <th>Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detailsfinanceiro as $details)
                                    <tr>
                                        <td>{{$details->document}}</td>
                                        <td>{{$details->document_number}}</td>
                                        <td>{{$details->obs}}</td>
                                        <td>{{ date('Y-m-d', strtotime($details->date_issue))}}</td>
                                        <td>{{ date('Y-m-d', strtotime($details->due_date))}}</td>
                                        <td>{{ number_format($details->not_regularized, 2, ',', '.') }}</td>
                                        <td>{{ number_format($details->balance, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $detailsfinanceiro->links() }}
                    <hr/>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-4">
                                <label>Comentário</label>
                                <div class="input-group">
                                    <textarea type="text" class="form-control" cols="4" rows="6" style="resize: none;" wire:model.lazy="comentario_financeiro" @if(isset($checkStatus)) @if($checkStatus == "1") readonly @endif @endif></textarea>
                                </div>
                                
                            </div>
                           <div class="col-lg-4">
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

                                @if(Session::has('visitasPropostasAnexos'))
                                    <div class="mt-3">
                                        <ul style=" list-style-type: none; margin:0;padding: 0;">
                                            @foreach(Session::get('visitasPropostasAnexos') as $file)
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

                                {{-- <button wire:click="upload" class="btn btn-primary mt-2">Enviar</button> --}}
                            </div>

                            


                        </div>

                    </div>
                    
                </div>
            </div>
        </div>

    </div>

    <!-- FIM TABELA  -->


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

        window.addEventListener('sendToaster', function(e) {

            if (e.detail.status == "success") {
                toastr.success(e.detail.message);
            }

            if (e.detail.status == "error") {
                toastr.warning(e.detail.message);
            }
            
            $("#modalInformacao").modal('hide');
            $("#modalTarefas").modal('hide');
            $("#modalAddTarefa").modal('hide');
            $("#agendarVisita").modal('hide');

        });

        window.addEventListener('DOMContentLoaded', (event) => {
            if ("{{ session('success') }}") {
                toastr.success("{{ session('success') }}");
            }
            if("{{ session('warning') }}"){
                toastr.warning("{{ session('warning') }}");
            }
        });
    </script>
    

</div>