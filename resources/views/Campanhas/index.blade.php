@extends('main')
@section('body')

    <div class="row">
        <div class="col">
            <ol class="breadcrumb" style="padding-left: 25px;">
                <li class="breadcrumb-item"><a href="{{route('campanhas')}}"><i class="fa fa-tag"></i> Campanhas</a></li>
            </ol>
        </div>
    </div>

    
    @livewire('campanhas.campanha')
 
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
