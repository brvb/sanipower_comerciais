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

    </style>

            <!-- BOF Breadcrumb -->
            <div class="row navigationLinks">
                <div class="col">
                    <ol class="breadcrumb" style="padding-left: 25px;">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="ti-home"></i> Dashboard</a></li>
                    </ol>
                </div>
            </div>
            <!-- EOF Breadcrumb -->

 
            <div class="row" style="margin-left: 10px;">
                <!-- Employees Sales -->
                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                    @livewire('dashboard.calendar-dashboard')
                </div>

                <!-- My Tasks -->
                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">

                    @livewire('dashboard.tarefas')
    
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


