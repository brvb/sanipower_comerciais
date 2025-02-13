@extends('main')
@section('body')

    <div class="row navigationLinks">
        <div class="col">
            <ol class="breadcrumb pl-4" style="padding-left: 25px;">
                <li class="breadcrumb-item"><a href="{{route('financeiro')}}"><i class="ti-wallet"></i> Financeiro</a></li>
                <li class="breadcrumb-item">Cliente</li>
                    <li class="breadcrumb-item active">{{$financeiro->customer_name}}</li>
            </ol>
        </div>
    </div>
    <div>
            @livewire('financeiro.financeiro-info', ["financeiro" => $financeiro])
    </div>
    


@endsection

@push('scripts_footer')

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<script>

        document.addEventListener('encomendaAtual', function() {


           jQuery('#modalEncomenda').modal();
         
        });

        window.addEventListener('beforeunload', function () {
            document.getElementById('loader').style.display = 'block';
        });

        
        document.addEventListener('livewire:load', function() {
            Livewire.hook('message.sent', () => {
                if(document.getElementById('loader') != null){
                    document.getElementById('loader').style.display = 'block';
                }
            });

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
</script>

@endpush
