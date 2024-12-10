@extends('main')
@section('body')


    <div class="row navigationLinks">
        <div class="col">
            <ol class="breadcrumb" style="padding-left: 25px;">
                <li class="breadcrumb-item"><a href="{{route('visitas')}}"><i class="ti-calendar"></i> Visitas</a></li>
                <li class="breadcrumb-item active">Listagem</li>
            </ol>
        </div>
    </div>

    <h4>Visitas</h4>

    @livewire('visitas.visitas', ["idAgendar" => $idAgendar])
 
    

@endsection

@push('scripts_footer')
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
     document.addEventListener('livewire:load', function() {
            Livewire.hook('message.sent', () => {
                document.getElementById('loader').style.display = 'block';
            });

            // Oculta o loader quando o Livewire terminar de carregar
            Livewire.hook('message.processed', () => {
                document.getElementById('loader').style.display = 'none';
            });
        });

        window.addEventListener('DOMContentLoaded', (event) => {
            if ("{{ session('success') }}") {
                toastr.success("{{ session('success') }}");
            }

            if("{{ session('error') }}"){
                toastr.warning("{{ session('error') }}");
            }
        });

        window.addEventListener('beforeunload', function () {
            // Show the loader when the user navigates away or the page is being unloaded
            document.getElementById('loader').style.display = 'block';
        });


        window.addEventListener('openToastMessage', function(e) {
    
            jQuery("#agendarVisita").modal('hide');

            if (e.detail.status == "success") {
                toastr.success(e.detail.message);
            }

            if(e.detail.status == "error"){
                toastr.warning(e.detail.message);
            }
        });


</script>

<script src="{{asset('assets/scripts/pages/cp_datetime.js')}}"></script>

@endpush

