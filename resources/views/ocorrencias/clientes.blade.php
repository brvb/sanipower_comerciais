@extends('main')
@section('body')


    <div class="row navigationLinks">
        <div class="col">
            <ol class="breadcrumb" style="padding-left: 25px;">
                <li class="breadcrumb-item"><a href="{{route('ocorrencias')}}"><i class="ti-wallet"></i> Ocorrências</a></li>
                <li class="breadcrumb-item"> Clientes</li>
                <li class="breadcrumb-item active">Listagem</li>
            </ol>
        </div>
    </div>

    <h4>Ocorrências</h4>
    
    @livewire('ocorrencias.ocorrencias-adicionar')
 
    

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
</script>

@endpush
