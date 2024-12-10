@extends('main')
@section('body')

    <div class="row navigationLinks">
        <div class="col">
            <ol class="breadcrumb" style="padding-left: 25px;">
                <li class="breadcrumb-item"><a href="{{route('visitas')}}"><i class="ti-calendar"></i> Visita</a></li>
                <li class="breadcrumb-item">Informação</li>
                <li class="breadcrumb-item active">{{$nameCliente}}</li>
            </ol>
        </div>
    </div>
    
    @livewire('visitas.detalhe-visitas',["cliente" => $idCliente, "idVisita" => $idVisita,"tst" => $tst])

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
        document.addEventListener('openComentarioModal', function() {
            jQuery("#modalComentario").modal();
        });

        document.addEventListener('openComentarioModalPropostas', function() {
    
            jQuery("#modalComentarioProp").modal();
        });

        document.addEventListener('openComentarioModalOcorrencias', function() {
            jQuery("#modalComentarioOcor").modal();
        });



        window.addEventListener('DOMContentLoaded', (event) => {

            document.getElementById('loader').style.display = 'none';
        });

        window.addEventListener('beforeunload', function () {
            // Show the loader when the user navigates away or the page is being unloaded
            document.getElementById('loader').style.display = 'block';
        });



        window.addEventListener('checkToaster', function(e) {

            jQuery("#modalComentario").modal('hide');
            jQuery("#modalComentarioProp").modal('hide');
            jQuery("#detalhePropostaModal").modal('hide');

            if (e.detail.status == "success") {
                toastr.success(e.detail.message);
            }

            if(e.detail.status == "error"){
                toastr.warning(e.detail.message);
            }
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