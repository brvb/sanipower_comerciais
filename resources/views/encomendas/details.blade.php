@extends('main')
@section('body')

    <div class="row navigationLinks">
        <div class="col">
            <ol class="breadcrumb pl-4" style="padding-left: 25px;">
                <li class="breadcrumb-item"><a href="{{route('encomendas')}}"><i class="ti-user"></i> Encomenda</a></li>
                <li class="breadcrumb-item">Cliente</li>
                @if(isset($nameCliente))
                    <li class="breadcrumb-item active">{{$nameCliente}}</li>
                @else
                    <li class="breadcrumb-item active">{{$encomenda->name}}</li>
                @endif

            </ol>
        </div>
    </div>

    <div>
        @if($encomenda != null)
            @livewire('encomendas.encomenda-info',["encomenda" => $encomenda])
        @else
            @livewire('encomendas.detalhe-encomenda',["codvisita"=> $codvisita, "cliente" => $idCliente , "codEncomenda" => $codEncomenda])
        @endif
    </div>

@endsection

@push('scripts_footer')

<script>
    // document.addEventListener("DOMContentLoaded", function() {

        document.addEventListener('encomendaAtual', function() {

           jQuery('#modalEncomenda').modal();
         
        });

        window.addEventListener('beforeunload', function () {
            // Show the loader when the user navigates away or the page is being unloaded
            document.getElementById('loader').style.display = 'block';
        });

        
        document.addEventListener('livewire:load', function() {
            Livewire.hook('message.sent', () => {
                if(document.getElementById('loader') != null){
                    document.getElementById('loader').style.display = 'block';
                }
            });

            // Oculta o loader quando o Livewire terminar de carregar
            // Erro pode ser aqui
            Livewire.hook('message.processed', () => {
                if(document.getElementById('loader') != null){
                    document.getElementById('loader').style.display = 'none';
                }
            });
        });


        window.addEventListener('checkToaster', function(e) {
    
            jQuery("#modalProdutos").modal('hide');
            jQuery("#modalEncomenda").modal('hide');
            jQuery("#modalProposta").modal('hide');
            jQuery("#modalComentario").modal('hide');   
            

            if (e.detail.status == "success") {
                toastr.success(e.detail.message);
            }

            if(e.detail.status == "error"){
                toastr.warning(e.detail.message);
            }
        });
    // });
</script>

@endpush
