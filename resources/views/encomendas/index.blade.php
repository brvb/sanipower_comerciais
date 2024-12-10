@extends('main')
@section('body')


    <div class="row">
        <div class="col">
            <ol class="breadcrumb" style="padding-left: 25px;">
                <li class="breadcrumb-item"><a href="{{route('encomendas')}}"><i class="ti-user"></i> Encomenda</a></li>
                <li class="breadcrumb-item active">Listagem</li>
            </ol>
        </div>
    </div>

    <h4>Encomendas</h4>

    @livewire('encomendas.encomendas')
    

@endsection

@push('scripts_footer')

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
    document.addEventListener("DOMContentLoaded", function() {
        document.addEventListener('livewire:load', function() {
            Livewire.hook('message.sent', (message,component) => {
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
    });

</script>

@endpush
