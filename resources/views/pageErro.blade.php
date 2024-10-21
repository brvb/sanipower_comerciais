@extends('main')

@section('body')
    <style>
        #calendar {
            padding: 10px;
        }

        .scrollbox-md {
            overflow-y: auto;
        }

        .card-body {
            flex-grow: 1;
        }

        #filterOptions {
            position: absolute;
            background-color: white;
            z-index: 10;
            width: 100%;
            top: 8rem;
            box-shadow: 0px 8px 8px #e8e8e8;
        }

        .fc .fc-button-primary:not(:disabled).fc-button-active, .fc .fc-button-primary:not(:disabled):active {
            background-color: #0c7294!important;
            border-color: #0c7294!important;
            color: white!important;
            border: none;
        }

        .fc .fc-button-primary {
            background-color: #1791ba!important;
            border-color: #1791ba!important;
            color: white!important;
        }

        .fc .fc-button-primary:not(:disabled):active:focus {
            box-shadow: none;
        }

        /* Estilos personalizados para a página de erro */
        .error-container {
            text-align: center;
            margin-top: 100px;
        }

        .error-title {
            font-size: 72px;
            font-weight: bold;
            color: #dc3545;
        }

        .error-description {
            font-size: 18px;
            color: #6c757d;
            margin-bottom: 30px;
        }

        .back-btn {
            margin-top: 20px;
        }
    </style>

    <div class="row error-container">
        <div class="col-md-12">
            <h1 class="error-title">Oops!</h1>
            <p class="error-description">Algo correu mal. A página que está a procurar pode ter sido removida ou está temporariamente indisponível.</p>
            <a href="/" class="btn btn-primary back-btn">Voltar para a Página Inicial</a>
        </div>
    </div>

    @livewire('dashboard.analysis')
@endsection

@push('scripts_footer')
    <script src="{{asset('assets/scripts/pages/dashboard1.js')}}"></script>
    <script src="{{asset('assets/scripts/pages/fm_control.js')}}"></script>
    <script src="{{asset('assets/scripts/pages/cp_datetime.js')}}"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    
    @if (session('status') && session('message'))
        <script>
            window.onload = function() {
                let status = '{{ session('status') }}';
                let message = '{{ session('message') }}';

                if (status === 'success') {
                    toastr.success(message);
                } else if (status === 'error') {
                    toastr.error(message);
                }
            };
        </script>
    @endif

    <script>
        document.getElementById('toggleFilters').addEventListener('click', function() {
            var filterOptions = document.getElementById('filterOptions');
            if (filterOptions.style.display === 'none' || filterOptions.style.display === '') {
                filterOptions.style.display = 'block';
            } else {
                filterOptions.style.display = 'none';
            }
        });
    </script>
@endpush



