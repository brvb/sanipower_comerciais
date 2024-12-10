@extends('main')
@section('body')

    <div class="row navigationLinks">
        <div class="col">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('visitas')}}"><i class="ti-calendar"></i> Visitas</a></li>
                <li class="breadcrumb-item">Listagem</li>
                <li class="breadcrumb-item">Criar visita</li>
                <li class="breadcrumb-item active">{{$idCliente}}</li>
            </ol>
        </div>
    </div>
    @livewire('visitas.new-visita',["cliente" => $idCliente])

@endsection

@push('scripts_footer')

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

        window.addEventListener('beforeunload', function () {
            // Show the loader when the user navigates away or the page is being unloaded
            document.getElementById('loader').style.display = 'block';
        });

        window.addEventListener('DOMContentLoaded', (event) => {
            if ("{{ session('success') }}") {
                toastr.success("{{ session('success') }}");
            }

            if("{{ session('error') }}"){
                toastr.warning("{{ session('error') }}");
            }
        });
</script>

@endpush